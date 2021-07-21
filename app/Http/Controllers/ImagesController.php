<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ColorThief\ColorThief;
use Illuminate\Support\Facades\Session;

class ImagesController extends Controller
{
    protected function upload (Request $request)  {
        $image =  $request->file('image');
        $extension = $image->getClientOriginalExtension();
      
        if($extension == "png"){
            $i = imagecreatefrompng($image); 
        } elseif($extension == "jpeg" || $extension == 'jpg'){
            $i = imagecreatefromjpeg($image);
        }elseif($extension == "gif"){
            $i = imagecreatefromgif($image);
        }else{
            Session::flash('Error', 'Error, no se puede subir una imagen con esa extensión');
        }
       
        $color = ColorThief::getColor($i);
        $r=$color[0];
        $g=$color[1];
        $b=$color[2]; 
                       
        $colors = [
            [0, 255, 255],
            [0, 0, 0],
            [0, 0, 255],
            [255, 0, 255],
            [0, 0, 128],
            [128, 128, 0],
            [128, 0, 128],
            [255, 0, 0],
            [128, 128, 128],
            [0, 128, 0],
            [0, 255, 0],
            [128, 0, 0],
            [192, 192, 192],
            [0, 128, 128],
            [255, 255, 255],
            [255, 255, 0],
        ];
        sort($colors);
        return view('welcome')->with('color', $color);
       // $i = imagecreatefrompng($image);
        // $rTotal = 0;
        // $gTotal = 0;
        // $bTotal = 0;
        // $total = 0;
        // for ($x=0;$x<imagesx($i);$x++) {
        //     for ($y=0;$y<imagesy($i);$y++) {
        //         $rgb = imagecolorat($i,$x,$y);
        //         $r   = ($rgb >> 16) & 0xFF;
        //         $g   = ($rgb >> 8) & 0xFF;
        //         $b   = $rgb & 0xFF;

        //         $rTotal += $r;
        //         $gTotal += $g;
        //         $bTotal += $b;
        //         $total++;
        //     }
        // }

        // $rAverage = round($rTotal/$total);
        // $gAverage = round($gTotal/$total);
        // $bAverage = round($bTotal/$total);

        // die( $rAverage." ".$gAverage." ".$bAverage);

    }
}
