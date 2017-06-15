<?php

namespace AppBundle\Services;

/**
 * Clase usada para verificar si es un base64
 */
class Tools
{
    /**
     * Get Extention File.
     *
     */
    private function getExtention($type) {
        $mme = array(
            'image/png' => '.png', 'image/jpeg' => '.jpg', 'image/gif' => '.gif',
            'mime/type' => '.pdf', 'application/pdf' => '.pdf', 'binary/octet-stream' => '.pdf',
            'application/zip' => '.zip', 'application/x-rar-compressed' => '.rar',
            'application/x-tar' => '.tar', 'application/x-bzip' => '.bz', 'application/x-bzip2' => '.bz2',
            'application/x-tar-gz' => '.tar.gz', 'application/x-gzip' => '.gz', 'application/x-compressed-tar' => '.tgz',
            'application/msword' => '.doc', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
            'application/vnd.ms-excel' => '.xls', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '.xlsx',
            'application/vnd.ms-powerpoint' => '.ppt', 'application/vnd.openxmlformats-officedocument.presentationml.presentation' => '.pptx',
            'application/vnd.openxmlformats-officedocument.presentationml.slideshow' => '.ppsx',
            'application/vnd.oasis.opendocument.text' => '.odt', 'application/vnd.oasis.opendocument.spreadsheet' => '.ods', 'application/vnd.oasis.opendocument.presentation' => '.odp'
        );
        return $mme[$type];
    }

    /**
     * Get File From Code Base64.
     *
     */
    public function getFileFromBase64($code, $dir) {
        try {
            $subCode = explode(',', $code);
            $ext = $this->getExtention(substr($subCode[0], 5, -7));
            $file = base64_decode($subCode[1]);
            $rand = $this->getRandom();
            if (!file_exists($dir)) mkdir($dir, 0777, true);
            file_put_contents($dir.'/'.$rand.$ext, $file);
            return array($rand.$ext, substr($subCode[0], 5, -7));
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Get Random Number.
     *
     */
    public function getRandom()
    {
        $bytes = false;
        if (function_exists('openssl_random_pseudo_bytes') && 0 !== stripos(PHP_OS, 'win')) {
            $bytes = openssl_random_pseudo_bytes(32, $strong);
            if (true !== $strong) {
                $bytes = false;
            }
        }
        if (false === $bytes) {
            $bytes = hash('sha256', uniqid(mt_rand(), true), true);
        }
        return base_convert(bin2hex($bytes), 16, 36);
    }

    /**
     * Resize all images.
     *
     */
    public function resizeImagen($ruta, $nombre, $alto, $ancho, $type){
        $extension = explode('/', $type)[1];
        $rutaImagenOriginal = $ruta.$nombre;
        if($extension == 'GIF' || $extension == 'gif'){
            $img_original = imagecreatefromgif($rutaImagenOriginal);
        }
        if($extension == 'jpg' || $extension == 'JPG'){
            $img_original = imagecreatefromjpeg($rutaImagenOriginal);
        }
        if($extension == 'png' || $extension == 'PNG'){
            $img_original = imagecreatefrompng($rutaImagenOriginal);
        }
        $max_ancho = $ancho;
        $max_alto = $alto;
        list($ancho,$alto)=getimagesize($rutaImagenOriginal);
        $x_ratio = $max_ancho / $ancho;
        $y_ratio = $max_alto / $alto;
        if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
            $ancho_final = $ancho;
            $alto_final = $alto;
        } elseif (($x_ratio * $alto) < $max_alto){
            $alto_final = ceil($x_ratio * $alto);
            $ancho_final = $max_ancho;
        } else{
            $ancho_final = ceil($y_ratio * $ancho);
            $alto_final = $max_alto;
        }
        $tmp=imagecreatetruecolor($ancho_final,$alto_final);
        imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
        imagedestroy($img_original);
        unlink($rutaImagenOriginal);
        $calidad=90;
        $newFile = $ruta.explode('.', $nombre)[0].'.jpeg';
        imagejpeg($tmp, $newFile, $calidad);
        return $newFile;
    }
}
