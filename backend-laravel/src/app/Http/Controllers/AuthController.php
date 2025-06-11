<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Module;
use App\Models\Permit;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Endpoints de autenticación"
 * )
 */

class AuthController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/api/v1/signup",
     *     summary="Registrar nuevo usuario",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@correo.com"),
     *             @OA\Property(property="password", type="string", format="password", example="123456"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario registrado correctamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function signup(Request $request): JsonResponse
    {
        // Definir reglas de validación
        $rules = [
            'name'      => 'required|string',
            'email'     => 'required|string|email|unique:users,email',
            'password'  => 'required|string|min:4|confirmed',
        ];

        // Definir mensajes personalizados en español
        $messages = [
            'name.required'     => 'El nombre es obligatorio.',
            'name.string'       => 'El nombre debe ser una cadena de texto válida.',

            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.string'      => 'El correo electrónico debe ser una cadena de texto válida.',
            'email.email'       => 'El correo electrónico debe ser una dirección válida.',
            'email.unique'      => 'El correo electrónico ya está en uso.',

            'password.required'  => 'La contraseña es obligatoria.',
            'password.string'    => 'La contraseña debe ser una cadena de texto válida.',
            'password.min'       => 'La contraseña debe tener al menos 4 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];

        // Validar los datos de entrada
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Error de validación.', [implode(' ', $validator->errors()->all())], 422);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => trim($request->email),
            'password'  => Hash::make($request->password),
        ]);
        $fullToken = $user->createToken('user-token')->plainTextToken;
        $token = explode('|', $fullToken)[1];
        return $this->sendResponse([], 'Usuario registrado correctamente.');
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Iniciar sesión",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="juan@correo.com"),
     *             @OA\Property(property="password", type="string", format="password", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Cuenta inactiva"
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->sendError('Credenciales incorrectas.', ['El email o la contraseña son incorrectos.'], 401);
        }
        $user = Auth::user();
        if ($user->status !== 1) {
            return $this->sendError('Acceso denegado.', ['Su cuenta no está activa. Contacte al administrador.'], 403);
        }
        $fullToken = $user->createToken('ApiDash')->plainTextToken;
        $token = explode('|', $fullToken)[1];
        $expiresAt = now()->addMinutes(60);
        //$expiresAt = Carbon::now()->addMinutes(10);
        $user->tokens()->latest()->first()->update([
            'expires_at' => $expiresAt,
        ]);

        $mnavbar = Permit::select('id', 'level', 'sub_module_id') // Campos necesarios del modelo Permit
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->whereHas('module', function (Builder $q) {
                $q->where('status', 1)
                    ->whereIn('show_on', ['navbar', 'all']);
            })
            ->with(['module' => function ($q) {
                $q->select('id', 'nom', 'desc', 'icon', 'color', 'url_module');
            }])
            ->get()
            ->map(function ($item) {
                $module = $item->module ? $item->module->toArray() : [];
                unset($item['module']);
                return array_merge($item->toArray(), $module);
            })
            ->toArray();

        $msidebar = Module::where('status', 1) // Módulos principales
        ->where('module_id', 0) // Filtrar solo módulos principales
        ->whereIn('show_on', ['sidebar', 'panel', 'none'])
        ->with(['subModules' => function ($q) use ($user) {
            $q->where('status', 1) // Submódulos activos
                ->whereIn('show_on', ['sidebar', 'all', 'none'])
                ->whereHas('permits', function ($query) use ($user) {
                    $query->where('user_id', $user->id) // Submódulos permitidos para el usuario
                        ->where('status', 1); // Permisos activos
              })
              ->select('id', 'nom', 'desc', 'color', 'icon', 'url_module','active', 'module_id', 'show_on'); // Seleccionar campos necesarios
        }])
        ->get()
        ->map(function ($module) {
            return [
                'id' => $module->id,
                'nom' => $module->nom,
                'desc' => $module->desc,
                'icon' => $module->icon,
                'color' => $module->color,
                'url_module' => $module->url_module,
                'sub_modules' => $module->subModules->map(function ($subModule) {
                    return [
                        'id' => $subModule->id,
                        'nom' => $subModule->nom,
                        'desc' => $subModule->desc,
                        'icon' => $subModule->icon,
                        'color' => $subModule->color,
                        'url_module' => $subModule->url_module,
                        'show' => $subModule->show_on,
                        'active' => $subModule->active,
                    ];
                }),
            ];
        });

        $mpanel = Module::where('module_id', 0)
        ->where('status', 1)
        ->whereIn('show_on', ['panel'])
        ->whereHas('subModules', function ($query) use ($user) {
            $query->where('status', 1)
                ->whereHas('permits', function ($subQuery) use ($user) {
                    $subQuery->where('user_id', $user->id);
                });
        })
        ->with(['subModules' => function ($query) use ($user) {
            $query->where('status', 1)
                  ->whereHas('permits', function ($subQuery) use ($user) {
                      $subQuery->where('user_id', $user->id);
                  });
        }])
        ->get()
        ->map(function ($module) {
            return [
                'id' => $module->id,
                'nom' => $module->nom,
                'desc' => $module->desc,
                'icon' => $module->icon,
                'color' => $module->color,
                'url_module' => $module->url_module,
                'sub_modules' => $module->subModules->map(function ($subModule) {
                    return [
                        'id' => $subModule->id,
                        'nom' => $subModule->nom,
                        'desc' => $subModule->desc,
                        'icon' => $subModule->icon,
                        'color' => $subModule->color,
                        'url_module' => $subModule->url_module,
                        'show' => $subModule->show_on,
                    ];
                }),
            ];
        });

        $permisos = Permit::select('id', 'sub_module_id', 'url_module')->where('status', 1)->where('user_id', $user->id)->get();

        $data = [
            'token' => $token,
            'expires_at' => $expiresAt->toDateTimeString(),
            'name' => $user->name,
            'id' => $user->id,
            'email' => $user->email,
            'avatar' => $user->avatar? route('viewfile',$user->avatar->name):"",
            'mnavbar' => $mnavbar,
            'msidebar' => $msidebar,
            'mpanel' => $mpanel,
            'permisos' => $permisos,
        ];

        return $this->sendResponse($data, 'Inicio de sesión exitoso.');
    }

     /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="Cerrar sesión",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sesión finalizada correctamente"
     *     )
     * )
     */
    public function logout()
    {
        Auth::user()->tokens->each(function ($token) {
            $token->forceDelete();
        });
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Conexión exitosa',
            'resultado' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Sesión finalizada.',
            ]
        ];
        return response()->json( $response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/token",
     *     summary="Renovar token de acceso",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"token"},
     *             @OA\Property(property="token", type="string", example="AbCdEf123456...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token renovado correctamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Token requerido"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token inválido"
     *     )
     * )
     */
    public function token(Request $request)
    {
        $tokenString = $request->input('token');
        if (!$tokenString) {
            return response()->json(['message' => 'Token requerido'], 400);
        }

        $token = PersonalAccessToken::findToken($tokenString);
        if (!$token) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        $user = $token->tokenable;
        $token->delete();
        $newToken = $user->createToken('auth-token', ['*'], Carbon::now()->addMinutes(60));
        $plainToken = explode('|', $newToken->plainTextToken)[1] ?? '';

        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Conexión exitosa',
            'resultado' => [
                'status' => 'success',
                'code' => 200,
                'message'    => 'Token renovado correctamente',
                'data' => [
                    'token'      => $plainToken,
                    'expires_at' => Carbon::now()->addMinutes(60)->toISOString()
                ]
            ]
        ];
        return response()->json( $response, 200);
    }
}
