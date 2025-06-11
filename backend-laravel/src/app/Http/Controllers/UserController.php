<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Module;
use App\Models\Permit;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Usuarios",
 *     description="Operaciones relacionadas con usuarios"
 * )
 */
class UserController extends BaseController
{
     /**
     * @OA\Post(
     *     path="/api/v1/user/update",
     *     summary="Actualizar perfil del usuario autenticado",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="password_current", type="string", example="claveactual123"),
     *             @OA\Property(property="password", type="string", example="nuevaclave123"),
     *             @OA\Property(property="password_confirmation", type="string", example="nuevaclave123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Perfil actualizado correctamente"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            // Reglas de validación
            $rules = [
                'name'              => 'required|string|max:120',
                'password_current'  => 'nullable|string|min:8',
                'password'          => 'nullable|string|min:8|confirmed',
            ];

            $messages = [
                'name.required'             => 'El nombre es obligatorio.',
                'name.string'               => 'El nombre debe ser una cadena de texto válida.',
                'name.max'                  => 'El nombre no puede tener más de 120 caracteres.',
                'password_current.min'       => 'La contraseña actual debe tener al menos 8 caracteres.',
                'password.min'               => 'La nueva contraseña debe tener al menos 8 caracteres.',
                'password.confirmed'         => 'Las contraseñas no coinciden.',
                'password.regex'             => 'La nueva contraseña debe incluir al menos una minúscula, una mayúscula y un número.',
            ];

            // Validar los datos de entrada
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return $this->sendError('Error de validación.', [implode(' ', $validator->errors()->all())], 422);
            }

            // Actualizar nombre
            $user->name = trim($request->name);

            // Verificar si se desea cambiar la contraseña
            if ($request->filled('password_current') || $request->filled('password') || $request->filled('password_confirmation')) {
                if (!$request->filled('password_current') || !$request->filled('password') || !$request->filled('password_confirmation')) {
                    return $this->sendError(
                        'Error de validación.',
                        ['Para actualizar la contraseña, debes proporcionar la actual, la nueva y la confirmación.'],
                        400
                    );
                }
                if (!Hash::check($request->password_current, $user->password)) {
                    return $this->sendError(
                        'Error de validación.',
                        ['La contraseña actual no es correcta.'],
                        400
                    );
                }
                $user->password = Hash::make($request->password);
            }

            // Guardar cambios en el usuario
            $user->save();

            return $this->sendResponse([], 'Tu información ha sido actualizada exitosamente.');

        } catch (\Exception $e) {
            return $this->sendError('Error en la operación.', [$e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/user/avatar",
     *     summary="Actualizar avatar del usuario",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"avatar"},
     *                 @OA\Property(property="avatar", type="file", description="Archivo de imagen (jpg, png, webp)")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Avatar actualizado con éxito"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function avatar(Request $request): JsonResponse
    {
        try {
            $user = Auth::user(); // Obtener usuario autenticado

            // Reglas de validación
            $rules = [
                'avatar' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048', // Máximo 2MB
            ];

            // Mensajes personalizados
            $messages = [
                'avatar.required' => 'Debes seleccionar un archivo de imagen.',
                'avatar.file'     => 'El avatar debe ser un archivo válido.',
                'avatar.mimes'    => 'Solo se permiten imágenes en formato JPG, JPEG, PNG y WEBP.',
                'avatar.max'      => 'El tamaño máximo permitido para el avatar es de 2MB.',
            ];

            // Validar entrada
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->sendError('Error de validación.', [implode(' ', $validator->errors()->all())], 422);
            }

            // Obtener el archivo
            if (!$request->hasFile('avatar')) {
                return $this->sendError('No se ha subido ningún archivo.', [], 400);
            }

            $file = $request->file('avatar');

            if (!$file->isValid()) {
                return $this->sendError('El archivo no es válido.', [], 400);
            }

            // Obtener la extensión en minúsculas
            $extension = strtolower($file->getClientOriginalExtension());

            // Generar nombre de archivo único
            $fileName = Str::random(6) . '-' . Str::random(8) . '.' . strtolower($extension);

            // Ruta donde se almacenará el archivo
            $storagePath = "files/user{$user->id}/";

            // Asegurar que la carpeta existe en storage/app/public
            Storage::disk('public')->makeDirectory($storagePath);

            // Eliminar imagen anterior si existe
            $existingImage = Images::where('from_table', 'users')
                ->where('from_id', $user->id)
                ->first();

            if ($existingImage) {
                $existingFilePath = $existingImage->path . $existingImage->name;
                if (Storage::disk('public')->exists($existingFilePath)) {
                    Storage::disk('public')->delete($existingFilePath);
                }
                $existingImage->delete();
            }

            // Guardar el nuevo archivo en storage/app/public
            $filePath = $file->storeAs($storagePath, $fileName, 'public');

            // Crear registro en la tabla images
            $image = new Images();
            $image->path = $storagePath;
            $image->name = $fileName;
            $image->desc = $file->getClientOriginalName();
            $image->ext = $extension;
            $image->mime = $file->getMimeType();
            $image->from_table = 'users';
            $image->from_id = $user->id;
            $image->user_id = $user->id;
            $image->save();

            // Actualizar el campo path en el modelo User
            $user->path = $storagePath;
            $user->save();

            return $this->sendResponse([
                'id'     => $user->id,
                'avatar' => route('viewfile', $fileName),
            ], 'El avatar ha sido actualizado con éxito.');
        } catch (\Exception $e) {
            return $this->sendError('Error en la operación.', [$e->getMessage()], 500);
        }
    }

     /**
     * @OA\Post(
     *     path="/api/v1/user/mypermits",
     *     summary="Obtener permisos del usuario autenticado",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Permisos obtenidos")
     * )
     */
    public function mypermits(Request $request): JsonResponse
    {
        try {
            $user =  $request->id && $request->id>0? User::find($request->id) : Auth::user();

            $modules = Module::select('id', 'nom', 'desc', 'icon', 'color', 'type')
            ->where('status', 1)
            ->where('module_id', 0)
            ->whereIn('show_on', ['panel', 'all', 'navbar'])
            ->with([
                'subModules' => function ($query) use ($user) {
                    $query->select('id', 'nom', 'desc', 'icon', 'type', 'color', 'module_id', 'url_module')
                        ->with(['permits' => function ($permitQuery) use ($user) {
                            $permitQuery->where('user_id', $user->id)->where('status', 1);
                        }]);
                }
            ])
            ->get()
            ->map(function ($module) {
                $module->subModules->each(function ($subModule) {
                    $subModule->asignado = $subModule->permits->isNotEmpty();
                    unset($subModule->permits);
                });
                return $module;
            });

            $data = [
                'id' => $user->id,
                'permisos' => $modules,
            ];

            return $this->sendResponse($data, '');

        } catch (\Exception $e) {
            return $this->sendError('Error en la operación.', [$e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/user/assignpermit",
     *     summary="Asignar o revocar permiso a un usuario",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id", "sub"},
     *             @OA\Property(property="id", type="integer", example=3, description="ID del usuario"),
     *             @OA\Property(property="sub", type="integer", example=5, description="ID del submódulo"),
     *             @OA\Property(property="status", type="boolean", example=true, description="true para asignar, false para revocar")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Permiso actualizado")
     * )
     */
    public function assignpermit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'sub' => 'required|exists:modules,id',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())
                ->map(function ($messages, $field) {
                    return ucfirst($field) . ': ' . implode(', ', $messages);
                })
                ->implode('; ');

            return $this->sendError('Error de validación', $errors, 422);
        }

        if ($request->status == true) {
            $sub = Module::find($request->sub);
            Permit::create([
                'user_id' => $request->id,
                'url_module' => $sub->url_module,
                'module_id' => $sub->parentModule->id,
                'sub_module_id' => $sub->id,
            ]);
            $message = "Permiso asignado correctamente";
        } else {
            Permit::where('sub_module_id', $request->sub)
                ->where('user_id', $request->id)
                ->delete();
            $message = "Permiso retirado correctamente";
        }

        return $this->sendResponse(null, $message);
    }


     /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Obtener lista de usuarios o uno específico",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="status", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="per_page", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="order_by", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="order", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Listado obtenido")
     * )
     */
    public function get(Request $request): JsonResponse
    {
        try {
            // Verificar si se busca un solo registro o una lista
            if ($request->id > 0) {
                $reg = User::where('id', $request->id)
                    ->where('id', '<>', Auth::id())
                    ->first();

                if ($reg) {
                    $total = 1;

                    // Obtener permisos del usuario
                    $permisos = Module::select('id', 'nom', 'desc', 'icon', 'color', 'type')
                        ->where('status', 1)
                        ->where('module_id', 0)
                        ->whereIn('show_on', ['panel', 'all', 'navbar'])
                        ->with([
                            'subModules' => function ($query) use ($reg) {
                                $query->select('id', 'nom', 'desc', 'icon', 'type', 'color', 'module_id', 'url_module')
                                    ->with(['permits' => function ($permitQuery) use ($reg) {
                                        $permitQuery->where('user_id', $reg->id)->where('status', 1);
                                    }]);
                            }
                        ])
                        ->get()
                        ->map(function ($module) {
                            $module->subModules->each(function ($subModule) {
                                $subModule->asignado = $subModule->permits->isNotEmpty();
                                unset($subModule->permits);
                            });
                            return $module;
                        });

                    $reg->permisos = $permisos;
                    $regs = [$reg];
                } else {
                    $total = 0;
                    $regs = [];
                }
            } else {
                $query = User::query();

                if ($request->page > 0) {
                    $request->search = trim($request->search);

                    if ($request->search != '') {
                        $query->whereAny([
                            'name',
                            'email',
                        ], 'LIKE', '%' . $request->search . '%');
                    }

                    if ($request->status > 0) {
                        $query = $query->where('status', $request->status);
                    } else {
                        $query = $query->where('status', '>', 0);
                    }

                    $query = $query->where('id', '<>', Auth::id());

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
     *     path="/api/v1/users/delete",
     *     summary="Eliminar usuario por ID",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Usuario eliminado correctamente"),
     *     @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $post = User::where('id', $request->id)->first();
            if (!$post) {
                return $this->sendError('No encontrado.', ['El usuario no existe.'], 404);
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
     *     path="/api/v1/users/save",
     *     summary="Crear o actualizar un usuario",
     *     tags={"Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=0, description="Si se envía, se actualiza el usuario"),
     *             @OA\Property(property="name", type="string", example="Pedro"),
     *             @OA\Property(property="email", type="string", example="pedro@correo.com"),
     *             @OA\Property(property="password", type="string", example="123456"),
     *             @OA\Property(property="status", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Usuario registrado o actualizado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function save(Request $request): JsonResponse
    {
        try {
            // Reglas de validación
            $rules = [
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|max:255|unique:users,email,' . $request->id,
                'password' => $request->id > 0 ? 'nullable|string|min:6' : 'required|string|min:6',
                'status'   => $request->id > 0 ? 'required|integer' : 'nullable|integer',
            ];

            $messages = [
                'name.required'     => 'El nombre es obligatorio.',
                'name.string'       => 'El nombre debe ser un texto válido.',
                'name.max'          => 'El nombre no puede exceder los 255 caracteres.',
                'email.required'    => 'El correo es obligatorio.',
                'email.email'       => 'Debe ingresar un correo válido.',
                'email.max'         => 'El correo no puede exceder los 255 caracteres.',
                'email.unique'      => 'El correo ya ha sido registrado.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.string'   => 'La contraseña debe ser una cadena de texto.',
                'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
                'status.required'   => 'El estado es obligatorio en la actualización.',
                'status.integer'    => 'El estado debe ser un número entero.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->sendError('Error de validación.', [implode(' ', $validator->errors()->all())], 422);
            }

            $validated = $validator->validated();

            if ($request->id > 0) {
                $user = User::find($request->id);
                if (!$user) {
                    return $this->sendError('No encontrado.', ['El usuario no existe.'], 404);
                }

                $updateData = [
                    'name'  => $validated['name'],
                    'email' => $validated['email'],
                    'status' => $validated['status'],
                ];

                if (!empty($validated['password'])) {
                    $updateData['password'] = Hash::make($validated['password']);
                }

                $user->update($updateData);
                return $this->sendResponse([], 'La información del usuario ha sido actualizada correctamente.');
            } else {
                $user = User::create([
                    'name'  => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'status' => 1,
                ]);
                return $this->sendResponse($user, 'Usuario registrado correctamente.');
            }
        } catch (\Exception $e) {
            return $this->sendError('Error en la operación.', [$e->getMessage()], 500);
        }
    }

}
