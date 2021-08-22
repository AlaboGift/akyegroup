<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_admin_model extends CI_Model
{
    //get products
    public function get_products()
    {
        $this->db->where('status', 1);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get latest products
    public function get_latest_products($limit)
    {
        $this->db->where('status', 1);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get products count
    public function get_products_count()
    {
        $this->db->where('status', 1);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    public function get_service_request(){
        $this->db->where('paid', 0);
        $this->db->order_by('service_date','DESC');
        $this->db->order_by('service_start_time','DESC');
        $query = $this->db->get('request_service');
        return $query->result();  
    }

    //get pending products
    public function get_pending_products()
    {
        $this->db->where('status !=', 1);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get latest pending products
    public function get_latest_pending_products($limit)
    {
        $this->db->where('status !=', 1);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get pending products count
    public function get_pending_products_count()
    {
        $this->db->where('status !=', 1);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //filter by values
    public function assign($service_id,$agent_id){
       if(!empty($service_id)){
            $data = array("provider_id" => $agent_id);
            $this->db->where('service_id', $service_id);
            return $this->db->update('request_service', $data);
        }
        return false;
    }
    public function get_email_by_id($agent_id){
        $this->db->where('id',$agent_id);
        $query = $this->db->get('users');
        $ret = $query->row();
        return $ret->email;
    }

    public function filter_products()
    {
        $data = array(
            'category' => $this->input->get('category', true),
            'subcategory' => $this->input->get('subcategory', true),
            'third_category' => $this->input->get('third_category', true),
            'q' => $this->input->get('q', true),
        );

        $data['q'] = trim($data['q']);

        if (!empty($data['type']) && $data['type'] == "regular") {
            $this->db->where('products.is_promoted', 0);
        }
        if (!empty($data['category'])) {
            $this->db->where('products.category_id', $data['category']);
        }
        if (!empty($data['subcategory'])) {
            $this->db->where('products.subcategory_id', $data['subcategory']);
        }
        if (!empty($data['third_category'])) {
            $this->db->where('products.third_category_id', $data['third_category']);
        }
        if (!empty($data['q'])) {
            $this->db->like('products.title', $data['q']);
        }
    }

    //filter by list
    public function filter_products_list($list)
    {
        if (!empty($list)) {
            if ($list == "products") {
                $this->db->where('products.visibility', 1);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "promoted_products") {
                $this->db->where('products.visibility', 1);
                $this->db->where('products.is_promoted', 1);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "pending_products") {
                $this->db->where('products.visibility', 1);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "hidden_products") {
                $this->db->where('products.visibility', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
        }
    }

    //get paginated products count
    public function get_paginated_products_count($list)
    {
        $this->filter_products();
        $this->filter_products_list($list);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_completed', 1);
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get paginated products
    public function get_paginated_products($per_page, $offset, $list)
    {
        $this->filter_products();
        $this->filter_products_list($list);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_completed', 1);
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get paginated promoted products count
    public function get_paginated_promoted_products_count($list)
    {
        $this->filter_products();
        $this->filter_products_list($list);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_completed', 1);
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get paginated promoted products
    public function get_paginated_promoted_products($per_page, $offset, $list)
    {
        $this->filter_products();
        $this->filter_products_list($list);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_completed', 1);
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get paginated pending products count
    public function get_paginated_pending_products_count($list)
    {
        $this->filter_products();
        $this->filter_products_list($list);
        $this->db->where('products.status !=', 1);
        $this->db->where('products.is_completed', 1);
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get paginated pending products
    public function get_paginated_pending_products($per_page, $offset, $list)
    {
        $this->filter_products();
        $this->filter_products_list($list);
        $this->db->where('products.status !=', 1);
        $this->db->where('products.is_completed', 1);
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get paginated hidden product count
    public function get_paginated_hidden_products_count($list)
    {
        $this->filter_products();
        $this->filter_products_list($list);
        $this->db->where('products.is_completed', 1);
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get paginated hidden products
    public function get_paginated_hidden_products($per_page, $offset, $list)
    {
        $this->filter_products();
        $this->filter_products_list($list);
        $this->db->where('products.is_completed', 1);
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get product
    public function get_product($id)
    {
        $this->db->where('products.id', $id);
        $query = $this->db->get('products');
        return $query->row();
    }

        public function get_service($id)
    {
        $this->db->join('users', 'request_service.provider_id = users.id');
        $this->db->where('service_id', $id);
        $query = $this->db->get('request_service');
        return $query->row();
    }


    //approve product
    public function approve_product($id)
    {
        $product = $this->get_product($id);
        if (!empty($product)) {
            $data = array(
                'status' => 1,
            );
            $this->db->where('id', $id);
            return $this->db->update('products', $data);
        }

        return false;
    }

    //add remove promoted products
    public function add_remove_promoted_products($product_id, $day_count)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            if ($product->is_promoted == 1) {
                $data = array(
                    'is_promoted' => 0,
                );
            } else {
                $date = date('Y-m-d H:i:s');
                $end_date = date('Y-m-d H:i:s', strtotime($date . ' + ' . $day_count . ' days'));
                $data = array(
                    'is_promoted' => 1,
                    'promote_start_date' => $date,
                    'promote_end_date' => $end_date
                );
            }
            $this->db->where('id', $product_id);
            return $this->db->update('products', $data);
        }

        return false;
    }

    //delete product
    public function delete_product($id)
    {
        $product = $this->get_product($id);
        if (!empty($product)) {
            //delete images
            $this->file_model->delete_product_images($id);
            $this->db->where('id', $id);
            return $this->db->delete('products');
        }
        return false;
    }

    public function delete_service($id)
    {
        $service = $this->get_service($id);
        if (!empty($service)) {
            //delete images
            $this->db->where('service_id', $id);
            return $this->db->delete('request_service');
        }
        return false;
    }

    public function get_agents($service){
        $this->db->where('profession',$service);
        $this->db->where('role','service');
        $query = $this->db->get('users');
        return $query->result();
    }

    //delete multi product
    public function delete_multi_products($product_ids)
    {
        if (!empty($product_ids)) {
            foreach ($product_ids as $id) {
                $product = $this->get_product($id);

                if (!empty($product)) {
                    //delete images
                    $this->file_model->delete_product_images($id);

                    $this->db->where('id', $id);
                    $this->db->delete('products');
                }
            }
        }
    }

}