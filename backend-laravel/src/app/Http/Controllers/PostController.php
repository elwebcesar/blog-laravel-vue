<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="Operaciones CRUD para posts del usuario autenticado"
 * )
 */
class PostController extends BaseController
{
    /**
     * Display a listing of the posts without authentication.
     *
     * @return JsonResponse
     * http://127.0.0.1:8000/api/posts
     */
    public function index(): JsonResponse
    {
        // Obtener todos los posts sin filtrar por usuario
        $posts = Post::all();

        // Devolver una respuesta JSON
        return $this->sendResponse([
            'total' => $posts->count(),
            'regs' => $posts
        ], 'Posts List.');
    }

    /**
     * Display a paginated listing of the posts.
     *
     * @param Request $request
     * @return JsonResponse
     * http://127.0.0.1:8000/api/posts/paginated
     * http://127.0.0.1:8000/api/posts/paginated?page=1&per_page=5
     */
    public function paginated(Request $request): JsonResponse
    {
        // Obtener los parámetros de paginación de la solicitud
        $page = $request->input('page', 1); // Número de página, predeterminado a 1
        $perPage = $request->input('per_page', 10); // Cantidad de posts por página, predeterminado a 10

        // Calcular el offset
        $offset = ($page - 1) * $perPage;

        // Obtener el total de posts
        $totalPosts = Post::count();

        // Obtener los posts para la página actual
        $posts = Post::offset($offset)->limit($perPage)->get();

        // Preparar la respuesta
        $response = [
            'total' => $totalPosts,
            'current_page' => $page,
            'per_page' => $perPage,
            'last_page' => ceil($totalPosts / $perPage),
            'regs' => $posts
        ];

        // Devolver una respuesta JSON
        return $this->sendResponse($response, 'Listado de posts paginado.');
    }

    /**
     * Display the specified post.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        // Buscar el post por ID
        $post = Post::find($id);

        // Verificar si el post existe
        if (!$post) {
            return $this->sendError('No encontrado.', ['El post no existe.'], 404);
        }

        // Devolver una respuesta JSON con los detalles del post
        return $this->sendResponse($post, 'Detalle del post.');
    }

    /**
     * @OA\Post(
     *     path="/api/v1/post",
     *     summary="Obtener listado o un post específico",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ID del post a consultar. Si no se envía, devuelve la lista",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer"), description="Número de página (opcional)"),
     *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer"), description="Cantidad por página"),
     *     @OA\Parameter(name="search", in="query", @OA\Schema(type="string"), description="Texto de búsqueda"),
     *     @OA\Parameter(name="status", in="query", @OA\Schema(type="integer"), description="Filtrar por estado"),
     *     @OA\Parameter(name="order_by", in="query", @OA\Schema(type="string"), description="Campo por el que ordenar"),
     *     @OA\Parameter(name="order", in="query", @OA\Schema(type="string"), description="asc o desc"),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de registros"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     )
     * )
     */
    public function get(Request $request): JsonResponse
    {
        try {
            // Verificar si se busca un solo registro o una lista
            if ($request->id > 0) {
                $reg = Post::where('id', $request->id)
                    ->where('user_id', Auth::id())
                    ->first();

                $regs = $reg ? [$reg] : [];
                if ($reg) {
                    $total = 1;
                }else{
                    $total = 0;
                }
            } else {
                $query = Post::query();

                if ($request->page > 0) {
                    $request->search = trim($request->search);

                    $request->search = trim($request->search);

                    if ($request->search != '') {
                        $query->whereAny([
                            'title',
                            'content',
                        ], 'LIKE', '%' . $request->search . '%');
                    }

                    if ($request->status > 0){
                        $query = $query->where('status', $request->status);
                    }else{
                        $query = $query->where('status', '>', 0);
                    }

                    $query = $query->where('user_id', Auth::id());

                    $total = $query->count();
                    $offset = ($request->page - 1) * $request->per_page;
                    $query = $query->offset($offset)->limit($request->per_page);
                    $query = $query->orderBy($request->order_by, $request->order);
                    $regs = $query->get();
                } else {
                    $total = $query->where('user_id', Auth::id())->count();
                    $regs = $query->get();
                }
            }

            return $this->sendResponse([
                'total' => $total,
                'regs' => $regs
            ], 'Listado de registros.');

        } catch (UnauthorizedHttpException $e) {
            return $this->sendError('Error de autenticación.', ['El token ha expirado o es inválido. Por favor, inicia sesión nuevamente.'], 401);
        } catch (\Exception $e) {
            return $this->sendError('Error en la operación.', [$e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/post/delete",
     *     summary="Eliminar un post",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1, description="ID del post a eliminar")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post no encontrado o no pertenece al usuario"
     *     )
     * )
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $post = Post::where('id', $request->id)->where('user_id', $user->id)->first();
            if (!$post) {
                return $this->sendError('No encontrado.', ['El post no existe o no pertenece al usuario.'], 404);
            }
            if ($post->delete()) {
                return $this->sendResponse([], 'Registro eliminado correctamente.');
            } else {
                return $this->sendError('Error al eliminar el registro.', [], 500);
            }
        } catch (UnauthorizedHttpException $e) {
            return $this->sendError('Error de autenticación.', ['El token ha expirado o es inválido. Por favor, inicia sesión nuevamente.'], 401);
        } catch (\Exception $e) {
            return $this->sendError('Error en la operación.', [$e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/post/save",
     *     summary="Crear o actualizar un post",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=0, description="ID del post. Si es 0 o no se envía, se crea uno nuevo."),
     *             @OA\Property(property="title", type="string", example="Mi primer post"),
     *             @OA\Property(property="content", type="string", example="Contenido del post"),
     *             @OA\Property(property="status", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post creado o actualizado correctamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function save(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            // Reglas de validación
            $rules = [
                'title'   => 'required|string|max:300|unique:posts,title,' . $request->id,
                'content' => 'nullable|string',
                'status' => 'nullable',
            ];

            $messages = [
                'status.required' => 'El estatus es obligatorio.',
                'title.required' => 'El título es obligatorio.',
                'title.string'   => 'El título debe ser un texto válido.',
                'title.max'      => 'El título no puede exceder los 300 caracteres.',
                'title.unique'   => 'El título ya ha sido registrado, elige otro.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->sendError('Error de validación.', [implode(' ', $validator->errors()->all())], 422);
            }
            $validated = $validator->validated();
            $slug = Str::slug($validated['title'], '-');

            if (Post::where('slug', $slug)->exists()) {
                $slug .= '-' . Str::random(6);
            }

            if ($request->id > 0) {
                $post = Post::where('id', $request->id)->where('user_id', $user->id)->first();
                if (!$post) {
                    return $this->sendError('No encontrado.', ['El post no existe o no pertenece al usuario.'], 404);
                }
                $post->update([
                    'title'   => $validated['title'],
                    'status'   => $validated['status'],
                    'content' => $validated['content'],
                    'slug'    => $slug,
                ]);
                return $this->sendResponse([], 'La información del registro ha sido actualizada correctamente.');
            } else {
                $post = Post::create([
                    'title'   => $validated['title'],
                    'content' => $validated['content'],
                    'slug'    => $slug,
                    'user_id' => $user->id,
                ]);
                return $this->sendResponse($post, 'Registro grabado correctamente.');
            }

        } catch (\Exception $e) {
            return $this->sendError('Error en la operación.', [$e->getMessage()], 500);
        }
    }
}
