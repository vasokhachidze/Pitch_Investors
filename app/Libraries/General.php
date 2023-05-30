<?php

namespace App\Libraries;
use App\Models\admin\category\Category;
/**
 * 
 */
class General
{

	public function __construct()
    { 

    }
    function webpConvert2($file, $compression_quality = 30)
    {
        // check if file exists
        if (!file_exists($file)) {
            return "File not exist";
        }
        $file_type = exif_imagetype($file);
        //https://www.php.net/manual/en/function.exif-imagetype.php
        //exif_imagetype($file);
        // 1    IMAGETYPE_GIF
        // 2    IMAGETYPE_JPEG
        // 3    IMAGETYPE_PNG
        // 6    IMAGETYPE_BMP
        // 15   IMAGETYPE_WBMP
        // 16   IMAGETYPE_XBM

        $expload_path       = explode('/', $file); 
       
        $expload_path_file  = end($expload_path);
     
        $expload            = explode('.', $expload_path_file);
       
        $file_name =  'cgc_'.$expload[0];

        array_pop($expload_path);
        array_push($expload_path,$file_name);

        $output_file = implode('/',$expload_path); 
        if (file_exists($output_file)) {
            return $output_file;
        }

        if (function_exists('imagewebp')) 
        {
            switch ($file_type) {
                case '1': //IMAGETYPE_GIF
                    $image = imagecreatefromgif($file);
                    imagepalettetotruecolor($image);
                    break;
                case '2': //IMAGETYPE_JPEG
                    $image = imagecreatefromjpeg($file);
                    break;
                case '3': //IMAGETYPE_PNG
                        $image = imagecreatefrompng($file);
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                        break;
                case '6': // IMAGETYPE_BMP
                    $image = imagecreatefrombmp($file);
                    break;
                case '15': //IMAGETYPE_Webp
                   return false;
                    break;
                case '16': //IMAGETYPE_XBM
                    $image = imagecreatefromxbm($file);
                    break;
                default:
                    return false;
            }


            // Save the image
            $result = imagewebp($image, $output_file, $compression_quality);
            
            if (false === $result) {
                return false;
            }
            // Free up memory
            imagedestroy($image);
            return $output_file;
        } elseif (class_exists('Imagick')) {
            $image = new Imagick();
            $image->readImage($file);
            if ($file_type === "3") {
                $image->setImageFormat('webp');
                $image->setImageCompressionQuality($compression_quality);
                $image->setOption('webp:lossless', 'true');
            }
            $image->writeImage($output_file);
            return $output_file;
        }
        return false;
    } 
		
}

?>