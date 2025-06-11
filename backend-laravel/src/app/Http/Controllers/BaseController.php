<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


 /**
 * @OA\Info(
 *     title="ApiPost - linuxitos",
 *     version="1.0.0",
 *     description="API con login, registro, actualización de información de usuario, perfil, listar posts, agregar, actualizar y eliminar posts. Obtiene token de inicio de sesión y se valida temporalidad.",
 *     @OA\Contact(
 *         email="contact@linuxitos.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000/api/v1/",
 *     description="Servidor local de desarrollo"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class BaseController extends Controller
{
    /**
     * Enviar respuesta de éxito.
     *
     * @param mixed  $data      Datos de la respuesta
     * @param string $message   Mensaje a mostrar
     * @param int    $code      Código de respuesta HTTP (por defecto 200)
     * @return JsonResponse
     */
    public function sendResponse($data, $message, $code = 200): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Conexión exitosa',
            'resultado' => [
                'status'  => 'success',
                'code'    => $code,
                'message' => $message,
                'data'    => $data,
            ],
        ], 200);
    }

    /**
     * Enviar respuesta de error.
     *
     * @param string $message        Mensaje de error
     * @param array  $errorMessages  Errores adicionales (opcional)
     * @param int    $code           Código de error (por defecto 400)
     * @return JsonResponse
     */
    public function sendError($message, $errorMessages = [], $code = 400): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Conexión exitosa',
            'resultado' => [
                'status'  => 'danger',
                'code'    => $code,
                'message' => !empty($errorMessages) ? (is_array($errorMessages) ? implode(' ', $errorMessages) : $errorMessages) : $message,
            ],
        ], 200);
    }
}
