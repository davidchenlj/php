    public static function get_lt($halfWidth) {
        //根据圆形弧度创建一个正方形的图像
        $img = imagecreatetruecolor($halfWidth, $halfWidth);
        //图像的背景
        $bgcolor = imagecolorallocate($img, 255, 255, 255);
        //填充颜色
        imagefill($img, 0, 0, $bgcolor);
        $fgcolor = imagecolorallocate($img, 0, 0, 0);
        imagefilledarc($img, $halfWidth, $halfWidth, $halfWidth * 2, $halfWidth * 2, 180, 270, $fgcolor, IMG_ARC_PIE);
        imagecolortransparent($img, $fgcolor);
        return $img;
    }

    /**
     * 头像画圆 $img 等于链接
     */
    public static function head_rounded($img) {
        $pathInfo = pathinfo($img);
        if ($pathInfo['extension'] == 'png') {
            $img2 = imagecreatefrompng($img);
        } else {
            $img2 = imagecreatefromjpeg($img);
        }
        $imgSize = getimagesize($img);
        $image_width = $imgSize[0];
        $image_height = $imgSize[1];
        //圆角长度，最好是图片宽，高的一半
        $halfWidth = 60;

        //获取四分之一透明圆角
        $lt_img = fx_image::get_lt($halfWidth);

        imagecopymerge($img2, $lt_img, 0, 0, 0, 0, $halfWidth, $halfWidth, 100);
        //旋转图片
        $lb_corner = imagerotate($lt_img, 90, 0);
        //左下角
        imagecopymerge($img2, $lb_corner, 0, $image_height - $halfWidth, 0, 0, $halfWidth, $halfWidth, 100);
        //旋转图片
        $rb_corner = imagerotate($lt_img, 180, 0);
        //右上角
        imagecopymerge($img2, $rb_corner, $image_width - $halfWidth, $image_height - $halfWidth, 0, 0, $halfWidth, $halfWidth, 100);
        //旋转图片
        $rt_corner = imagerotate($lt_img, 270, 0);
        //右下角
        imagecopymerge($img2, $rt_corner, $image_width - $halfWidth, 0, 0, 0, $halfWidth, $halfWidth, 100);
        return $img2;
    }
    
    
    
    
