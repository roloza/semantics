<?php

namespace App\Custom\Tools;
/**
 * Class Avatar
 * @package App\Custom\Tools
 * @description Génération d'une image Avatar à partir d'une chaine de caractère
 */
class Avatar {

    private $image;

    public function __construct($string, $blocks = 5, $size = 400){
        $togenerate = ceil($blocks / 2);

        $hash = md5($string);
        $hashsize = $blocks * $togenerate;
        $hash = str_pad($hash, $hashsize, $hash);
        $hash_split = str_split($hash);

        $color = substr($hash, 0, 6);
        $blocksize = $size / $blocks;

        $image = imagecreate($size, $size);
        $color = imagecolorallocate($image, hexdec(substr($color,0,2)), hexdec(substr($color,2,2)), hexdec(substr($color,4,2)));
        $bg = imagecolorallocate($image, 255, 255, 255);

        for($i = 0; $i < $blocks; $i++){
            for($j = 0; $j < $blocks; $j++){
                if($i < $togenerate){
                    $pixel = hexdec($hash_split[($i * 5) + $j]) % 2 == 0;
                }else{
                    $pixel = hexdec($hash_split[((4 - $i) * 5) + $j]) % 2 == 0;
                }

                $pixelColor = $bg;
                if($pixel){
                    $pixelColor = $color;
                }
                imagefilledrectangle($image, $i * $blocksize, $j * $blocksize, ($i + 1) * $blocksize, ($j + 1) * $blocksize, $pixelColor);
            }
        }

        // Au lieu d'afficher l'image, on la stock dans la variable d'instance $image pour pouvoir la manipuler avec d'autres méthodes
        ob_start();
        imagepng($image);
        $image_data = ob_get_contents();
        ob_end_clean ();
        $this->image = $image_data;
    }

    // Exporte l'image en base64
    public function base64(){
        return 'data:image/png;base64,' . base64_encode($this->image);
    }

}