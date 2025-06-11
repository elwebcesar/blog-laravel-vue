<?php

namespace App\Http\Controllers;

use App\Models\Images;

class ImageController extends Controller
{
    public function viewfile($filename)
    {
        // Buscar el archivo en la base de datos en la tabla Images
        $image = Images::where('name', $filename)->first();

        // Construir la ruta completa del archivo si existe en la BD
        $filePath = $image ? storage_path("app/public/" . $image->path . $image->name) : null;

        // Verificar si el archivo existe en el sistema de almacenamiento
        if (!$image || !file_exists($filePath)) {
            $defaultImagePath = public_path("app/images/404.png");
            if (in_array($image?->mime, ['image/jpeg', 'image/png', 'image/webp', 'image/gif'])) {
                return response()->file($defaultImagePath, [
                    'Content-Type' => 'image/png',
                    'Content-Disposition' => 'inline; filename="404.png"'
                ]);
            } else {
                return view('filenotfound', ['filename' => $filename]);
            }
        }

        // Obtener el tipo MIME del archivo
        $mimeType = $image->mime ?? 'application/octet-stream';

        // Retornar el archivo para visualizarlo en el navegador
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($image->name) . '"'
        ]);
    }

}
