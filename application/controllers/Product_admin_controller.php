<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_admin_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(base_url());
        }
    }

    /**
     * Products
     */
    public function products()
    {
        $data['title'] = trans("products");
        $data['form_action'] = admin_url() . "products";
        $data['list_type'] = "products";

        //get paginated products
        $pagination = $this->paginate(admin_url() . 'products', $this->product_admin_model->get_paginated_products_count('products'));
        $data['products'] = $this->product_admin_model->get_paginated_products($pagination['per_page'], $pagination['offset'], 'products');
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /*service request*/
        public function service_request()
    {
        $data['title'] = 'Service Requests';
        $data['form_action'] = admin_url() . "service-requests";
        $data['list_type'] = "products";
        $data['services'] = $this->product_admin_model->get_service_request();
        //get paginated products
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/service_request', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Promoted Products
     */
    public function promoted_products()
    {
        $data['title'] = trans("promoted_products");
        $data['form_action'] = admin_url() . "promoted-products";
        $data['list_type'] = "promoted_products";

        //get paginated promoted products
        $pagination = $this->paginate(admin_url() . 'promoted-products', $this->product_admin_model->get_paginated_promoted_products_count('promoted_products'));
        $data['products'] = $this->product_admin_model->get_paginated_promoted_products($pagination['per_page'], $pagination['offset'], 'promoted_products');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/promoted_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Pending Products
     */
    public function pending_products()
    {
        $data['title'] = trans("pending_products");
        $data['form_action'] = admin_url() . "pending-products";
        $data['list_type'] = "pending_products";

        //get paginated pending products
        $pagination = $this->paginate(admin_url() . 'pending-products', $this->product_admin_model->get_paginated_pending_products_count('pending_products'));
        $data['products'] = $this->product_admin_model->get_paginated_pending_products($pagination['per_page'], $pagination['offset'], 'pending_products');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/pending_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Hidden Products
     */
    public function hidden_products()
    {
        $data['title'] = trans("hidden_products");
        $data['form_action'] = admin_url() . "hidden-products";
        $data['list_type'] = "hidden_products";

        //get paginated products
        $pagination = $this->paginate(admin_url() . 'hidden-products', $this->product_admin_model->get_paginated_hidden_products_count('hidden_products'));
        $data['products'] = $this->product_admin_model->get_paginated_hidden_products($pagination['per_page'], $pagination['offset'], 'hidden_products');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Product Details
     */
    public function product_details($id)
    {
        $data['title'] = trans("product_details");
        $data['product'] = $this->product_admin_model->get_product($id);
        if (empty($data['product'])) {
            redirect($this->agent->referrer());
        }
        $data['review_count'] = $this->review_model->get_review_count($data["product"]->id);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/product_details', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function service_details($id)
    {
        $data['title'] = "Service Details";
        $data['service'] = $this->product_admin_model->get_service($id);
        $data['review_count'] = $this->review_model->get_service_review_count($data["service"]->service_id);
        if (empty($data['service'])) {
            redirect($this->agent->referrer());
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/service_details', $data);
        $this->load->view('admin/includes/_footer');
    }
        public function assign_agent($id,$service)
    {
        $data['title'] = "Assign Agent";
        $data['service'] = $this->product_admin_model->get_agents($service);
        $data['service_id'] = $id; 
        if (empty($data['service'])) {
            redirect($this->agent->referrer());
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/assign_agent', $data);
        $this->load->view('admin/includes/_footer');
    }

 public function assign()
    {
        $service_id = $this->input->post('service_id', true);
        $agent_id = $this->input->post('agent_id', true);
        $email   = $this->product_admin_model->get_email_by_id($agent_id);
        $data['service'] = $this->product_admin_model->get_service($service_id);
        if ($this->product_admin_model->assign($service_id,$agent_id)) {
            $this->load->model("email_model");
            $subject = "New Job Assignment";
            $message = 'You have a new Job Request for a <span>'.strtoupper($data['service']->service_type).'</span>, at <span>'.strtoupper($data['service']->request_address).'</span>, ordered by <span>'.strtoupper($data['service']->request_name).'</span> to be started on <span>'.date('jS F, Y',strtotime($data['service']->service_date)).'</span> at <span>'.date('h:i a',strtotime($data['service']->service_start_time)).'</span> and completed before <span>'.date('h:i a',strtotime($data['service']->service_end_time)).'</span>.<br><a href="https://akyegroup.com" target="_blank">click to go to site</a>';
                $this->email_model->send_email($email, null, $subject, $message);
                $this->session->set_flashdata('success', "Agent has been succesfully assigned");
        } else {
            $this->session->set_flashdata('error', "Failed to assign agent");
        }
    }
    /**
     * Approve Product
     */
    public function approve_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->approve_product($id)) {
            $this->session->set_flashdata('success', trans("msg_product_approved"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        $redirect_url = $this->input->post('redirect_url', true);
        if (!empty($redirect_url)) {
            redirect($redirect_url);
        }
    }

    /**
     * Delete Product
     */
    public function delete_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_product($id)) {
            $this->session->set_flashdata('success', trans("msg_product_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

        public function delete_service()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_service($id)) {
            $this->session->set_flashdata('success',"Service Request Deleted");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Products
     */
    public function delete_selected_products()
    {
        $product_ids = $this->input->post('product_ids', true);
        $this->product_admin_model->delete_multi_products($product_ids);
    }

    /**
     * Add Remove Promoted Products
     */
    public function add_remove_promoted_products()
    {
        $product_id = $this->input->post('product_id', true);
        $day_count = $this->input->post('day_count', true);
        $is_ajax = $this->input->post('is_ajax', true);
        if ($this->product_admin_model->add_remove_promoted_products($product_id, $day_count)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        if ($is_ajax == 0) {
            redirect($this->agent->referrer());
        }

    }

    /**
     * Comments
     */
    public function comments()
    {
        $data['title'] = trans("comments");
        $data['comments'] = $this->comment_model->get_all_comments();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Comment
     */
    public function delete_comment()
    {
        $id = $this->input->post('id', true);
        if ($this->comment_model->delete_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Comments
     */
    public function delete_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->delete_multi_comments($comment_ids);
    }

    /**
     * Reviews
     */
    public function reviews()
    {
        $data['title'] = trans("reviews");
        $data['reviews'] = $this->review_model->get_all_reviews();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/reviews', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Review
     */
    public function delete_review()
    {
        $id = $this->input->post('id', true);
        if ($this->review_model->delete_review($id)) {
            $this->session->set_flashdata('success', trans("msg_review_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Delete Selected Reviews
     */
    public function delete_selected_reviews()
    {
        $review_ids = $this->input->post('review_ids', true);
        $this->review_model->delete_multi_reviews($review_ids);
    }


}