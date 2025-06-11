<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


/**
 * @OA\Tag(
 *     name="Módulos",
 *     description="Operaciones para gestionar módulos del sistema"
 * )
 */
class ModuleController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/v1/module",
     *     summary="Obtener lista o un módulo específico",
     *     tags={"Módulos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="query", @OA\Schema(type="integer"), description="ID del módulo"),
     *     @OA\Parameter(name="module_id", in="query", @OA\Schema(type="integer"), description="ID del módulo padre"),
     *     @OA\Parameter(name="search", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="status", in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="order_by", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="order", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Listado de módulos obtenido correctamente"),
     *     @OA\Response(response=401, description="Token inválido o expirado")
     * )
     */
    public function get(Request $request): JsonResponse
    {
        try {
            if ($request->id > 0) {
                $reg = Module::where('id', $request->id)->first();

                if ($reg) {
                    $total = 1;
                    $regs = [$reg];
                } else {
                    $total = 0;
                    $regs = [];
                }
            } else {
                $query = Module::query();

                //$query = $query->where('module_id', $request->module_id);

                $query = $query->where('module_id', $request->module_id);
                if ($request->page > 0) {
                    $request->search = trim($request->search);

                    if ($request->search != '') {
                        $query->whereAny([
                            'nom',
                            'desc',
                        ], 'LIKE', '%' . $request->search . '%');
                    }

                    if ($request->status > 0) {
                        $query = $query->where('status', $request->status);
                    } else {
                        $query = $query->where('status', '>', 0);
                    }

                    $total = $query->count();
                    $offset = ($request->page - 1) * $request->per_page;
                    $query = $query->offset($offset)->limit($request->per_page);
                    $query = $query->orderBy($request->order_by, $request->order);
                    $regs = $query->get();
                } else {

                    $total = $query->where('id', '<>', Auth::id())->count();
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
     *     path="/api/v1/module/delete",
     *     summary="Eliminar un módulo por ID",
     *     tags={"Módulos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=5, description="ID del módulo a eliminar")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Módulo eliminado correctamente"),
     *     @OA\Response(response=404, description="Módulo no encontrado")
     * )
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $post = Module::where('id', $request->id)->first();
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
     *     path="/api/v1/module/save",
     *     summary="Crear o actualizar un módulo",
     *     tags={"Módulos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=0),
     *             @OA\Property(property="nom", type="string", example="Dashboard"),
     *             @OA\Property(property="desc", type="string", example="Módulo principal"),
     *             @OA\Property(property="icon", type="string", example="fa-dashboard"),
     *             @OA\Property(property="type", type="string", example="menu"),
     *             @OA\Property(property="url", type="string", example="/dashboard"),
     *             @OA\Property(property="color", type="string", example="#ff6600"),
     *             @OA\Property(property="show", type="string", example="panel"),
     *             @OA\Property(property="active", type="string", example="1"),
     *             @OA\Property(property="module_id", type="integer", example=0)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Módulo creado o actualizado correctamente"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function save(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $rules = [
                'nom'         => 'required|string|max:255|unique:modules,nom,' . $request->id,
                'desc'        => 'required|string',
                'icon'        => 'required|string|max:255',
                'type'        => 'required|string|max:100',
                'url'         => 'required|string|max:255',
                'color'       => 'required|string|max:50',
                'show'        => 'required|string:max:100',
                'module_id'   => 'required|integer',
            ];

            $messages = [
                'nom.required'   => 'El nombre es obligatorio.',
                'nom.string'     => 'El nombre debe ser un texto válido.',
                'nom.max'        => 'El nombre no puede exceder los 255 caracteres.',
                'nom.unique'     => 'El nombre ya ha sido registrado, elige otro.',
                'type.required'  => 'El tipo es obligatorio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->sendError('Error de validación.', [implode(' ', $validator->errors()->all())], 422);
            }

            $validated = $validator->validated();

            if ($request->id > 0) {
                $module = Module::where('id', $request->id)->first();
                if (!$module) {
                    return $this->sendError('No encontrado.', ['El módulo no existe.'], 404);
                }

                $module->update([
                    'nom'            => $validated['nom'],
                    'desc'           => $validated['desc'] ?? null,
                    'icon'           => $validated['icon'] ?? null,
                    'type'           => $validated['type'],
                    'url_module'     => $validated['url'] ?? null,
                    'color'          => $validated['color'] ?? null,
                    'show_on'        => $validated['show'] ?? false,
                    'active'        => $validated['active'] ?? "",
                    'module_id'      => $validated['module_id'] ?? 0,
                ]);

                return $this->sendResponse([], 'La información del módulo ha sido actualizada correctamente.');
            } else {
                $module = Module::create([
                    'nom'            => $validated['nom'],
                    'desc'           => $validated['desc'] ?? null,
                    'icon'           => $validated['icon'] ?? null,
                    'type'           => $validated['type'],
                    'url_module'     => $validated['url'] ?? null,
                    'color'          => $validated['color'] ?? null,
                    'show_on'        => $validated['show'] ?? false,
                    'active'        => $validated['active'] ?? "",
                    'module_id'      => $validated['module_id'] ?? 0,
                    'system'         => 0,
                    'query'          => null,
                    'back_module_id' => null,
                ]);

                return $this->sendResponse($module, 'Módulo creado correctamente.');
            }
        } catch (\Exception $e) {
            return $this->sendError('Error en la operación.', [$e->getMessage()], 500);
        }
    }
}
