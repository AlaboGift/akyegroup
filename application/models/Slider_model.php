<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_model extends CI_Model
{
    //add item
    public function add_item()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'link' => $this->input->post('link', true),
            'item_order' => $this->input->post('item_order', true)
        );
        //upload image
        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            $data["image"] = $this->upload_model->slider_image_upload($file);
        } else {
            $data["image"] = "";
        }
        return $this->db->insert('slider', $data);
    }

    //update item
    public function update_item($id)
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'link' => $this->input->post('link', true),
            'item_order' => $this->input->post('item_order', true)
        );
        //upload image
        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            $item = $this->get_slider_item($id);
            delete_file_from_server($item->image);
            $data["image"] = $this->upload_model->slider_image_upload($file);
        }
        $this->db->where('id', $id);
        return $this->db->update('slider', $data);
    }

    //get slider item
    public function get_slider_item($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('slider');
        return $query->row();
    }

    //get slider items
    public function get_slider_items()
    {
        $this->db->where('slider.lang_id', $this->selected_lang->id);
        $this->db->order_by('item_order');
        $query = $this->db->get('slider');
        return $query->result();
    }

    //get all slider items
    public function get_slider_items_all()
    {
        $this->db->order_by('item_order');
        $query = $this->db->get('slider');
        return $query->result();
    }

    //delete slider item
    public function delete_slider_item($id)
    {
        $slider_item = $this->get_slider_item($id);
        if (!empty($slider_item)) {
            delete_file_from_server($slider_item->image);
            $this->db->where('id', $id);
            return $this->db->delete('slider');
        }
        return false;
    }

}