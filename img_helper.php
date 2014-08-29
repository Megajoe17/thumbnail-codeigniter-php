<?php
/*
 * get_img(array('file'=>'image.png', 'path'=>NEWS_PATH, 'size'=>array(100, 100), 'file_no_image'=>'nouser.png'))
 */
 function get_img($params = [])
{
    $defaults = [
        'file' => false,
        'path' => false,
        'size' => false,
        'with_http' => false,
        'need_crop' => true,
        'center' => true,
        'orientation' => 'inside',
        'file_no_image' => 'noimage.png',
        'path_no_image' => 'media/upload/no_image/'
    ];
    $params = array_merge($defaults, $params);

    $real_path = realpath('.'). '/'. $params['path'];
    $real_path_file =  $real_path . $params['file'];

    if (!is_file($real_path_file))
    {
        $params['file'] = $params['file_no_image'];
        $params['path'] = $params['path_no_image'];
        $real_path = realpath('.'). '/'. $params['path'];
        $real_path_file =  $real_path . $params['file_no_image'];
    }

    if ($params['size'])
    {
        $resize_file = $params['size'][0].'_'.$params['size'][1].'_'.$params['file'];
        $real_path_resize_file = $real_path.$resize_file;

        if (!is_file($real_path_resize_file))
        {
            $file_size = getimagesize($real_path_file); // размеры оригинальной картинки

            if (($file_size[0] > $params['size'][0]) || ($file_size[1] > $params['size'][1]))
            {
                $params['file'] = $resize_file;

                if ($file_size[0] <= $params['size'][0])
                {
                    $params['size'][0] = $file_size[0];
                }
                if ($file_size[1] <= $params['size'][1])
                {
                    $params['size'][1] = $file_size[1];
                }

                $oCI = & get_instance();
                $config = array();
                $config['source_image'] = $real_path_file;
                $config['new_image']= $real_path_resize_file;
                $config['width'] = $params['size'][0];
                $config['height'] = $params['size'][1];
                $config['image_library'] = 'gd2';

                $config['master_dim'] = 'auto';
                if ($params['orientation'] == 'outside')
                {
                    $ratio_image = $file_size[0]/$file_size[1]; // 0.6734 картинка была 330*490
                    $calculation_h = $config['width']/$ratio_image; // при w=100 расчитали h = 148
                    $calculation_w = $config['height']*$ratio_image; // при h=120 расчитали w = 80

                    if ($calculation_w < $config['width'])
                    {
                        $config['master_dim'] = 'width';
                    }
                    elseif ($calculation_h < $config['height'])
                    {
                        $config['master_dim'] = 'height';
                    }
                }

                $oCI->load->library('image_lib', $config);

                if (!$oCI->image_lib->resize())
                {
                    echo $oCI->image_lib->display_errors();
                }
            }
        }
        else
        {
            $params['file'] = $resize_file;
        }
    }

    if ($params['need_crop'] && $params['orientation'] == 'outside')
    {
        crop_image($params);
    }

    if ($params['with_http'])
    {
        $params['path'] = base_url().$params['path'];
    }
    else
    {
        $params['path'] = TO_APP_FOLDER.$params['path'];
    }
    return $params['path'].$params['file'];
}

function crop_image($params)
{
    $real_path = realpath('.'). '/'. $params['path'];
    $real_path_file =  $real_path . $params['file'];

    $file_size = getimagesize($real_path_file);
    $img_width = $file_size[0];
    $img_height = $file_size[1];
    $block_width = $params['size'][0];
    $block_height = $params['size'][1];

    $crop_info = (object) array('x'=>0, 'y'=>0, 'x2'=>0, 'y2'=>0);

    if ($params['center'])
    {
        $crop_info->x = ($img_width - $block_width)/2;
        $crop_info->x2 = $crop_info->x + $block_width;
        $crop_info->y = ($img_height - $block_height)/2;
        $crop_info->y2 = $crop_info->y + $block_height;
    }
    else
    {
        $crop_info->x2 = $block_width;
        $crop_info->y2 = $block_height;
    }

    if (($crop_info->x2 != 0) && ($crop_info->y2 != 0))
    {
        $oCI = & get_instance();

        $oCI->load->library('image_moo');
        $oCI->image_moo->load($real_path_file);
        $oCI->image_moo->crop((int)$crop_info->x, (int)$crop_info->y, (int)$crop_info->x2, (int)$crop_info->y2);
        $oCI->image_moo->save_pa('', '', true);
        //$response =  $oCI->image_moo->display_errors();
    }
}
