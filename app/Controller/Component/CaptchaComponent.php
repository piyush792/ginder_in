<?php

class CaptchaComponent extends Component {

    public $font = 'monofont.ttf';
    public $components = array('Session');

    function generate_code($characters) {
        /* list all possible characters, similar looking characters and vowels have been removed */
        $possible = '23456789bcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        $i = 0;
        while ($i < $characters) {
            $code .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            $i++;
        }
        return $code;
    }

    function generate_image($width = '120', $height = '40', $characters = '6') {
        $code = $this->generate_code($characters);
        /* font size will be 75% of the image height */
        $font_size = $height * 0.75;
        $image = @imagecreate($width, $height) or die(__('Cannot initialize new GD image stream'));
        /* set the colours */
        $background_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 20, 40, 100);
        $noise_color = imagecolorallocate($image, 100, 120, 180);
        /* generate random dots in background */
        for ($i = 0; $i < ($width * $height) / 3; $i++) {
            imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $noise_color);
        }
        /* generate random lines in background */
        for ($i = 0; $i < ($width * $height) / 150; $i++) {
            imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $noise_color);
        }
        /* create textbox and add text */
        $textbox = imagettfbbox($font_size, 0, $this->font, $code) or die(__('Error in imagettfbbox function'));
        $x = ($width - $textbox[4]) / 2;
        $y = ($height - $textbox[5]) / 2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font, $code) or die(__('Error in imagettftext function'));
        $this->Session->write('security_code', $code);
        /* output captcha image to browser */
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
    }

}

/*
  $width = isset($_GET['width']) ? $_GET['width'] : '120';
  $height = isset($_GET['height']) ? $_GET['height'] : '40';
  $characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';

  $captcha = new CaptchaSecurityImages($width,$height,$characters); */
?>