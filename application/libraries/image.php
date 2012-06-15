<?php

/**
 * 图片处理类
 */
class Image_Library {

    public $image;
    public $type;
    public $savepath;
    public $maxWidth;
    public $maxHeight;

    function __construct($image='', $savepath='') {
        $this->image = $image;
        $this->savepath = $savepath;
    }

    function info() {
        $imageinfo = getimagesize($this->image);
        if ($imageinfo === false)
            return false;
        $imagetype = strtolower(substr(image_type_to_extension($imageinfo[2]), 1));
        $imagesize = filesize($img);
        $info = array(
            'width' => $imageinfo[0],
            'height' => $imageinfo[1],
            'type' => $imagetype,
            'size' => $imagesize,
            'mime' => $imageinfo['mime']
        );
        return $info;
    }

    function thumb($filename = '', $maxwidth = 200, $maxheight = 50, $suffix='_thumb') {
        if (!$this->check($image)) return false;
        $info = $this->info();
        if ($info === false) return false;
        $srcwidth = $info['width'];
        $srcheight = $info['height'];
        $pathinfo = pathinfo($this->image);
        $type = $pathinfo['extension'];
        if (!$type)
            $type = $info['type'];
        $type = strtolower($type);
        unset($info);
        $scale = min($maxwidth / $srcwidth, $maxheight / $srcheight);
        $createwidth = $width = (int) ($srcwidth * $scale);
        $createheight = $height = (int) ($srcheight * $scale);
        $psrc_x = $psrc_y = 0;
        if ($autocut) {
            if ($maxwidth / $maxheight < $srcwidth / $srcheight && $maxheight >= $height) {
                $width = $maxheight / $height * $width;
                $height = $maxheight;
            } elseif ($maxwidth / $maxheight > $srcwidth / $srcheight && $maxwidth >= $width) {
                $height = $maxwidth / $width * $height;
                $width = $maxwidth;
            }
            $createwidth = $maxwidth;
            $createheight = $maxheight;
        }
        $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);
        $srcimg = $createfun($this->image);
        if ($type != 'gif' && function_exists('imagecreatetruecolor'))
            $thumbimg = imagecreatetruecolor($createwidth, $createheight);
        else
            $thumbimg = imagecreate($width, $height);
        if (function_exists('imagecopyresampled'))
            imagecopyresampled($thumbimg, $srcimg, 0, 0, $psrc_x, $psrc_y, $width, $height, $srcwidth, $srcheight);
        else
            imagecopyresized($thumbimg, $srcimg, 0, 0, $psrc_x, $psrc_y, $width, $height, $srcwidth, $srcheight);
        if ($type == 'gif' || $type == 'png') {
            $background_color = imagecolorallocate($thumbimg, 0, 255, 0);  //  指派一个绿色  
            imagecolortransparent($thumbimg, $background_color);  //  设置为透明色，若注释掉该行则输出绿色的图 
        }
        if ($type == 'jpg' || $type == 'jpeg')
            imageinterlace($thumbimg, $this->interlace);
        $imagefun = 'image' . ($type == 'jpg' ? 'jpeg' : $type);
        if (empty($filename)) {
            $filename = substr($this->image, 0, strrpos($this->image, '.')) . $suffix . '.' . $type;
        } else {
            $filename .= time() . $this->random(6) . $suffix . '.' . $type;
        }
        $imagefun($thumbimg, $filename);
        imagedestroy($thumbimg);
        imagedestroy($srcimg);
        return $filename;
    }

    function cut($width, $height, $x=0, $y=0) {
        $this->get_type();
        if ($x < 0) {
            $x = 0;
        }
        if ($y < 0) {
            $y = 0;
        }
        $info = $this->info();
        if ($width > $info['width']) {
            $width = $info['width'];
        }
        if ($height > $info['height']) {
            $height = $info['height'];
        }
        $tmpimg = imagecreatetruecolor($width, $height);
        switch ($this->type) {
            case 'jpg':
            case 'jpeg':
                header("Content-type: image/jpeg");
                $cImg = imagecreatefromjpeg($this->image);
                break;
            case 'gif':
                $cImg = imagecreatefromgif($this->image);
                break;
            case 'png':
            default :
                $cImg = imagecreatefrompng($this->image);
                break;
        }
        imagecopy($tmpimg, $cImg, 0, 0, $x, $y, $width, $height);
        $this->image = $tmpimg;
    }

    function save($filepath) {
        $fname = $fname ? $fname : time() . $this->random(6) . '.' . $this->type;
        $filepath .= $fname;
        switch ($this->type) {
            case 'jpg':
            case 'jpeg':
                header("Content-type: image/jpeg");
                $ret = imagejpeg($this->image, $filepath);
                break;
            case 'gif':
                header("Content-type: image/gif");
                $ret = imagegif($this->image, $filepath);
                break;
            case 'png':
            default :
                header("Content-type: image/png");
                $ret = imagepng($this->image, $filepath);
                break;
        }
        imagedestroy($this->image);
        if ($ret)
            return $filepath;
    }

    function get_type() {
        if (preg_match("/\.(jpg|jpeg|gif|png)/i", $this->image, $m)) {
            $this->type = strtolower($m[1]);
        } else {
            $this->type = "string";
        }
    }

    function random($length, $chars = '0123456789') {
        $hash = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    function check() {
        return extension_loaded('gd') && preg_match("/\.(jpg|jpeg|gif|png)/i", $this->image, $m) && file_exists($this->image) && function_exists('imagecreatefrom' . ($m[1] == 'jpg' ? 'jpeg' : $m[1]));
    }

}

?>
