<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Guarda una imagen redimensionada y retorna la ruta relativa.
     *
     * @param UploadedFile $file       Archivo subido
     * @param string       $folder     Carpeta destino dentro de storage/app/public/
     * @param int          $width      Ancho máximo (alto se ajusta automático)
     * @param string|null  $oldImage   Ruta de imagen anterior para eliminarla
     * @return string                  Ruta relativa guardada en BD
     */
    public function save( UploadedFile $file, string $folder, int $width = 800, ?string $oldImage = null ): string 
    {
        // Eliminar imagen anterior si existe
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }
        // Generar nombre único con extensión original
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path     = $folder . '/' . $filename;
            // Redimensionar manteniendo proporción (no estira ni recorta)
        $image = Image::read($file)
            ->scaleDown(width: $width)   // solo reduce, nunca agranda
            ->toJpeg(quality: 80);       // convierte a JPG con 80% calidad

        // Guardar en storage/app/public/{folder}/
        Storage::disk('public')->put($path, $image);

        return $path; // esto es lo que guardas en BD
    }

    /**
     * Elimina una imagen del storage.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}