<?php

namespace App\Http\Controllers;
header('Access-Control-Allow-Origin: *');  

use Illuminate\Http\Request;
use ColorThief\ColorThief;
use Illuminate\Support\Facades\Session;

class ImagesController extends Controller
{
    protected function upload (Request $request)  {

        if($request->get('image')) {
            $image = $request->get('image');
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

            if($extension == "png"){
                $i = imagecreatefrompng($image); 
               }elseif($extension == "jpeg" || $extension == 'jpg'){
                   $i = imagecreatefromjpeg($image);
               }elseif($extension == "gif"){
                   $i = imagecreatefromgif($image);
               }else{
                   Session::flash('Error', 'Error, no se puede subir una imagen con esa extensión');
               }
              
               $imageRGBColor = ColorThief::getColor($i);
               $imageHexColor= sprintf("#%02x%02x%02x", $imageRGBColor[0], $imageRGBColor[1], $imageRGBColor[2]);
               $closestPaletteColor = $this->getClosestPaletteColor($imageHexColor);
            
            return response()->json([$closestPaletteColor, $imageHexColor], 200);
         }      
    }

    protected function getClosestPaletteColor($selectedImagePredominantColor) {
        $paletteColors = array(
            'Aqua' => '#00FFFF',
            'Black' => '#000000',
            'Blue'=>'#0000FF',
            'Fucsia' => '#FF00FF',
            'Navy'=>'#000080',
            'Olive' => '#808000',
            'Purple' => '#800080',
            'Red' => '#FF0000',
            'Gray' => '#808080',
            'Green'=>'#008000',
            'Lime' => '#00FF00',
            'Maroon' => '#800000',
            'Silver'=> '#C0C0C0',
            'Teal' => '#008080',
            'White' => '#FFFFFF',
            'Yellow' => '#FFFF00');

        $minDiff = 765;
        $closestColor = "";

        foreach ($paletteColors as $name => $paletteColor){
            $diff = $this->colorDiff($paletteColor,$selectedImagePredominantColor);
            if ($diff < $minDiff){
                $minDiff = $diff;
                $closestColor = $name; 
            }
        }

        return $closestColor;
    }
           
    protected function colorDiff($paletteColor,$selectedImagePredominantColor) {
        
        $red1   = hexdec(substr($paletteColor,1,2));
        $green1 = hexdec(substr($paletteColor,3,2));
        $blue1  = hexdec(substr($paletteColor,5,2));
        
        $red2   = hexdec(substr($selectedImagePredominantColor,1,2));
        $green2 = hexdec(substr($selectedImagePredominantColor,3,2));
        $blue2  = hexdec(substr($selectedImagePredominantColor,5,2));

        $colorDiff = abs($red1 - $red2) + abs($green1 - $green2) + abs($blue1 - $blue2);
        return $colorDiff;
    }

}