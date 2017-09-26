/**
     * 二维码推广图片
     */
    public function qbcode()
    {
        if (!$this->_islogin()) {
            hheaderLocation(hlogin_url());
        }

        $product_id = intval($_GET['product_id']);
        if (!$product_id) {
            $this->_failed($msg = '产品ID不能为空!', $result = 1, $data = null);
        }

        $product = srv_spl_partner::I()->get_product_conf($product_id);
        if (!$product) {
            $this->_failed($msg = '产品不存在!', $result = 1, $data = null);
        }

        $user     = srv_uc_session::I()->user();
        $img_code = hurl('api', 'index', 'qbcode', array('text' => $url));

        //水印图片配置
        $img = array(
            '0' => array(
                'src_img' => $product['code_img'], //背景图片
                'dst_x'   => '0',
                'dst_y'   => '0',
                'src_x'   => '0',
                'src_y'   => '0',
            ),
            '1' => array(
                'src_img' => $img_code,
                'dst_x'   => '200', // 二微码图像开始 x 坐标
                'dst_y'   => '475', //二微图像开始 y 坐标
                'src_x'   => '0',
                'src_y'   => '0',
                'zoom_x'  => '250',
                'zoom_y'  => '250',
            ),
            '2' => array(
                'dst_x'  => '513', //头像图像开始 x 坐标
                'dst_y'  => '46', //头像图像开始 y 坐标
                'zoom_x' => '94', //头像x缩放比例
                'zoom_y' => '94', //头像y缩放比例
            ),
            '3' => array(
                'text'        => '【' . $user['nickname'] . '】', //昵称
                'font_size'   => '21', //字体大小
                'fonts_path'  => '/usr/share/fonts/rzjy/waterChar.ttf', //字体路径
                'rotate_text' => '0', //旋转
                'dst_x'       => '160', //昵称开始 x 坐标
                'dst_y'       => '62', //昵称图像开始y坐标

            ),
        );
        $ext = pathinfo($img['0']['src_img']);
        switch ($ext['extension']) {
            case 'jpg':
                $image_1 = imagecreatefromjpeg($img['0']['src_img']);
                break;
            case 'jpeg':
                $image_1 = imagecreatefromjpeg($img['0']['src_img']);
                break;
            case 'png':
                $image_1 = imagecreatefrompng($img['0']['src_img']);
                break;
        }

        $image_2 = imagecreatefrompng($img['1']['src_img']);
        // 读取头像
        $image_3 = fx_image::head_rounded(havatarurl($user['uid'], 'middle', $user['avatarver']));

        //创建一个和人物图片一样大小的真彩色画布（ps：只有这样才能保证后面copy装备图片的时候不会失真）
        $bg = imageCreatetruecolor(imagesx($image_1), imagesy($image_1));
        //为真彩色画布创建白色背景，再设置为透明
        $color  = imagecolorallocate($bg, 255, 255, 255);
        $color1 = imagecolorallocate($bg, 255, 255, 255);
        imagefill($bg, 0, 0, $color);
        imageColorTransparent($bg, $color);

        //创建背景
        imagecopyresampled($bg, $image_1, $img['0']['dst_x'], $img['0']['dst_y'], $img['0']['src_x'], $img['0']['src_y'], imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));

        // 首先二微码添加到背景
        imagecopyresampled($bg, $image_2, $img['1']['dst_x'], $img['1']['dst_y'], 0, 0, $img['1']['zoom_x'], $img['1']['zoom_y'], imagesx($image_2), imagesy($image_2));

        // 再将头像添加到背景并且进行缩放
        imagecopyresampled($bg, $image_3, $img['2']['dst_x'], $img['2']['dst_y'], 0, 0, $img['2']['zoom_x'], $img['2']['zoom_y'], imagesx($image_3), imagesy($image_3));

        // 添加昵称
        imagettftext($bg, $img['3']['font_size'], $img['3']['rotate_text'], $img['3']['dst_x'], $img['3']['dst_y'], $color1, $img['3']['fonts_path'], $img['3']['text']);

        header("Content-type: image/jpg");
        imagejpeg($bg);
    }
