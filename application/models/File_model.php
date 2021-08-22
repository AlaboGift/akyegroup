<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends CI_Model
{

    //upload image
    public function upload_image()
    {
        $product_id = $this->input->post('product_id', true);
        $image_order = $this->input->post('image_order', true);
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if (!empty($file['name'])) {
                if ($file["size"] <= $this->img_uplaod_max_file_size) {
                    $data = array(
                        'product_id' => $product_id,
                        'image_default' => $this->upload_model->product_default_image_upload($file, "images"),
                        'image_big' => $this->upload_model->product_big_image_upload($file, "images"),
                        'image_small' => $this->upload_model->product_small_image_upload($file, "images"),
                        'image_order' => $image_order
                    );
                    $this->db->insert('images', $data);
                }
            }
        }
    }

    //upload image session
    public function upload_image_session()
    {
        $image_order = $this->input->post('image_order', true);
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if (!empty($file['name'])) {
                if ($file["size"] <= $this->img_uplaod_max_file_size) {
                    $modesy_images = array();
                    if (isset($_SESSION["modesy_product_images"])) {
                        $modesy_images = $_SESSION["modesy_product_images"];
                    }
                    if (isset($modesy_images[$image_order])) {
                        unset($modesy_images[$image_order]);
                    }
                    $modesy_images[$image_order]["img_default"] = $this->upload_model->product_default_image_upload($file, "temp");
                    $modesy_images[$image_order]["img_big"] = $this->upload_model->product_big_image_upload($file, "temp");
                    $modesy_images[$image_order]["img_small"] = $this->upload_model->product_small_image_upload($file, "temp");
                    $_SESSION["modesy_product_images"] = $modesy_images;
                }
            }
        }
    }
function imagecreatefromfile( $filename ) {
    if (!file_exists($filename)) {
        throw new InvalidArgumentException('File "'.$filename.'" not found.');
    }
    switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
        case 'jpeg':
        case 'jpg':
            return imagecreatefromjpeg($filename);
        break;

        case 'png':
            return imagecreatefrompng($filename);
        break;

        case 'gif':
            return imagecreatefromgif($filename);
        break;

        default:
            throw new InvalidArgumentException('File "'.$filename.'" is not valid jpg, png or gif image.');
        break;
    }
}
    //add product images
    public function add_product_images($product_id)
    {
        $modesy_images = array();
        if (isset($_SESSION["modesy_product_images"])) {
            $modesy_images = $_SESSION["modesy_product_images"];
        }
        if (!empty($modesy_images)) {
            for ($i = 1; $i < 6; $i++) {
                if (isset($modesy_images[$i])) {
                    $data = array(
                        'product_id' => $product_id,
                        'image_default' => $modesy_images[$i]["img_default"],
                        'image_big' => $modesy_images[$i]["img_big"],
                        'image_small' => $modesy_images[$i]["img_small"],
                        'image_order' => $i,
                    );
                    //move default image
                    $stamp = imagecreatefrompng(FCPATH .'uploads/logo/stamp.png');
                    // Set the margins for the stamp and get the height/width of the stamp image
                    $marge_right = 10;
                    $marge_bottom = 10;
                    $sx = imagesx($stamp);
                    $sy = imagesy($stamp);
                    $im = $this->imagecreatefromfile(FCPATH . "uploads/temp/" . $modesy_images[$i]["img_default"]);
                    // Copy the stamp image onto our photo using the margin offsets and the photo 
                    // width to calculate positioning of the stamp. 
                    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_top, 0, 0, imagesx($stamp), imagesy($stamp));
                    $filename = FCPATH . "uploads/temp/" . $modesy_images[$i]["img_default"];
                    imagepng($im, $filename);
                    imagedestroy($im);
                    copy(FCPATH . "uploads/temp/" . $modesy_images[$i]["img_default"], FCPATH . "uploads/images/" . $modesy_images[$i]["img_default"]);
                    delete_file_from_server("uploads/temp/" . $modesy_images[$i]["img_default"]);
                    //move big image
                    copy(FCPATH . "uploads/temp/" . $modesy_images[$i]["img_big"], FCPATH . "uploads/images/" . $modesy_images[$i]["img_big"]);
                    delete_file_from_server("uploads/temp/" . $modesy_images[$i]["img_big"]);
                    //move small image
                    copy(FCPATH . "uploads/temp/" . $modesy_images[$i]["img_small"], FCPATH . "uploads/images/" . $modesy_images[$i]["img_small"]);
                    delete_file_from_server("uploads/temp/" . $modesy_images[$i]["img_small"]);
                    //add to database
                    $this->db->insert('images', $data);
                }
            }
        }

        if (isset($_SESSION["modesy_product_images"])) {
            unset($_SESSION["modesy_product_images"]);
        }
    }

    //get product images
    public function get_product_images($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->order_by('images.image_order');
        $query = $this->db->get('images');
        return $query->result();
    }

    //get product image
    public function get_product_image($image_id)
    {
        $this->db->where('images.id', $image_id);
        $query = $this->db->get('images');
        return $query->row();
    }

    //get product image by image order
    public function get_product_image_by_image_order($product_id, $image_order)
    {
        $this->db->where('images.product_id', $product_id);
        $this->db->where('images.image_order', $image_order);
        $query = $this->db->get('images');
        return $query->row();
    }

    //get product small image
    public function get_product_small_image($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('image_order', 1);
        $query = $this->db->get('images');
        $row = $query->row();

        if (empty($row)) {
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('images');
            $row = $query->row();
        }

        if (!empty($row)) {
            return base_url() . "uploads/images/" . $row->image_small;
        }
        return base_url() . 'assets/img/no-image.jpg';
    }

    //get product main image
    public function get_product_main_image($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('image_order', 1);
        $query = $this->db->get('images');
        $row = $query->row();

        if (empty($row)) {
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('images');
            $row = $query->row();
        }

        if (!empty($row)) {
            return base_url() . "uploads/images/" . $row->image_default;
        }
        return base_url() . 'assets/img/no-image.jpg';
    }

    //get product images array
    public function get_product_images_array($product_id)
    {
        $images_array = array();
        for ($i = 1; $i < 6; $i++) {
            $image = $this->get_product_image_by_image_order($product_id, $i);
            if (!empty($image)) {
                $data = array(
                    'id' => $image->id,
                    'product_id' => $product_id,
                    'image_default' => $image->image_default,
                    'image_big' => $image->image_big,
                    'image_small' => $image->image_small,
                    'image_order' => $image->image_order
                );
                $images_array[$i] = $data;
            } else {
                $data = array(
                    'id' => "",
                    'product_id' => "",
                    'image_default' => "",
                    'image_big' => "",
                    'image_small' => "",
                    'image_order' => ""
                );
                $images_array[$i] = $data;
            }
        }
        return $images_array;
    }

    //delete image session
    public function delete_image_session($image_order)
    {
        $modesy_images = array();
        if (isset($_SESSION["modesy_product_images"])) {
            $modesy_images = $_SESSION["modesy_product_images"];
        }
        if (isset($modesy_images[$image_order])) {
            delete_file_from_server("uploads/temp/" . $modesy_images[$image_order]["img_default"]);
            delete_file_from_server("uploads/temp/" . $modesy_images[$image_order]["img_big"]);
            delete_file_from_server("uploads/temp/" . $modesy_images[$image_order]["img_small"]);
            unset($modesy_images[$image_order]);
        }
        $_SESSION["modesy_product_images"] = $modesy_images;
    }

    //delete product image
    public function delete_product_image($image_id)
    {
        $image = $this->get_product_image($image_id);
        if (!empty($image)) {
            delete_file_from_server("uploads/images/" . $image->image_default);
            delete_file_from_server("uploads/images/" . $image->image_big);
            delete_file_from_server("uploads/images/" . $image->image_small);
            $this->db->where('id', $image->id);
            $this->db->delete('images');
        }
    }

    //delete product images
    public function delete_product_images($product_id)
    {
        $images = $this->get_product_images($product_id);
        if (!empty($images)) {
            foreach ($images as $image) {
                $this->delete_product_image($image->id);
            }
        }
    }

}