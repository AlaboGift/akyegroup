<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model
{
    //product default image upload
    public function product_default_image_upload($file, $folder)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'img_x500_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 70;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_ratio_no_zoom_in = true;
            $this->my_upload->image_y = 500;
            $this->my_upload->image_ratio_x = true;
            $this->my_upload->process('./uploads/' . $folder . '/');
            $image_path = $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //product big image upload
    public function product_big_image_upload($file, $folder)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'img_1920x_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 70;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_ratio_no_zoom_in = true;
            $this->my_upload->image_x = 1920;
            $this->my_upload->image_ratio_y = true;
            $this->my_upload->process('./uploads/' . $folder . '/');
            $image_path = $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //product small image upload
    public function product_small_image_upload($file, $folder)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'img_x300_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 70;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_ratio_no_zoom_in = true;
            $this->my_upload->image_y = 300;
            $this->my_upload->image_ratio_x = true;
            $this->my_upload->process('./uploads/' . $folder . '/');
            $image_path = $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //blog image default upload
    public function blog_image_default_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'image_d' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 70;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_ratio_no_zoom_in = true;
            $this->my_upload->image_x = 880;
            $this->my_upload->image_ratio_y = true;
            $this->my_upload->process('./uploads/blog/');
            $image_path = "uploads/blog/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //blog image default upload
    public function blog_image_small_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'image_s' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 70;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_x = 500;
            $this->my_upload->image_y = 332;
            $this->my_upload->process('./uploads/blog/');
            $image_path = "uploads/blog/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //category image upload
    public function category_image_upload($file, $width, $height)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'category_' . $width . '-' . $height . '_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 70;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_x = $width;
            $this->my_upload->image_y = $height;
            $this->my_upload->process('./uploads/category/');
            $image_path = "uploads/category/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //slider image upload
    public function slider_image_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'slider_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 95;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_x = 1170;
            $this->my_upload->image_y = 356;
            $this->my_upload->process('./uploads/slider/');
            $image_path = "uploads/slider/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //avatar image upload
    public function avatar_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'avatar_' . '_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 80;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_x = 180;
            $this->my_upload->image_y = 180;
            $this->my_upload->process('./uploads/profile/');
            $image_path = "uploads/profile/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //guarantor form upload
    function guarantor_form_upload($file){
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'guarantor_'.uniqid();
                        $this->my_upload->process('./uploads/documents/');
            $doc_path = "uploads/documents/" . $this->my_upload->file_dst_name;
            return $doc_path;
        }else{
            return null;
        }
    }


    //referal form upload
    function referal_form_upload($file){
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'referal_'.uniqid();
                        $this->my_upload->process('./uploads/documents/');
            $doc_path = "uploads/documents/" . $this->my_upload->file_dst_name;
            return $doc_path;
        }else{
            return null;
        }
    }


    //logo image upload
    public function logo_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'logo_' . uniqid();
            $this->my_upload->process('./uploads/logo/');
            $image_path = "uploads/logo/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //favicon image upload
    public function favicon_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'favicon_' . uniqid();
            $this->my_upload->process('./uploads/logo/');
            $image_path = "uploads/logo/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //ad upload
    public function ad_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'block_' . uniqid();
            $this->my_upload->process('./uploads/blocks/');
            $image_path = "uploads/blocks/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }
}