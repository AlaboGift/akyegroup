<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Upload Image
     */
    public function upload_image()
    {
        $this->file_model->upload_image();
    }

    /**
     * Upload Image Session
     */
    public function upload_image_session()
    {
        $this->file_model->upload_image_session();
    }

    /**
     * Load Image Section
     */
    public function load_image_section()
    {
        $this->load->view("product/_image_upload_box");
    }

    /**
     * Load Image Update Section
     */
    public function load_image_update_section()
    {
        $product_id = $this->input->post('product_id', true);
        $data["images_array"] = $this->file_model->get_product_images_array($product_id);
        $data["product"] = $this->product_admin_model->get_product($product_id);

        $this->load->view("product/_image_update_box", $data);
    }

    /**
     * Delete Image Session
     */
    public function delete_image_session()
    {
        $image_order = $this->input->post('image_order', true);
        $this->file_model->delete_image_session($image_order);
        $this->load->view("product/_image_upload_box");
    }

    /**
     * Delete Image
     */
    public function delete_image()
    {
        $image_id = $this->input->post('image_id', true);
        $product_id = $this->input->post('product_id', true);
        $this->file_model->delete_product_image($image_id);

        $data["images_array"] = $this->file_model->get_product_images_array($product_id);
        $data["product"] = $this->product_admin_model->get_product($product_id);

        $this->load->view("product/_image_update_box", $data);
    }

}
