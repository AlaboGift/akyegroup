<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH .'third_party/Facebook/autoload.php';

class Product_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->review_limit = 5;
        $this->comment_limit = 5;
        $this->product_per_page = 30;
    }

    /**
     * Add Product
     */
    public function add_product()
    {
        //check auth
        if (!auth_check()) {
            redirect(base_url());
        }

        if (user()->email_status != 1 AND $this->general_settings->mail_confirmation_register == 1) {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(base_url() . "settings/update-profile");
        }

        $data['title'] = "Swap Now";
        $data['description'] = "Swap Now". " - " . $this->app_name;
        $data['keywords'] = "Swap Now". "," . $this->app_name;

        $this->load->view('partials/_header', $data);
        $this->load->view('product/add_product');
        $this->load->view('partials/_footer');
    }

        public function request_service()
    {

        $data['title'] = "Request Service";
        $data['description'] = "Request Service". " - " . $this->app_name;
        $data['keywords'] = "Request Service". "," . $this->app_name;
        $data['services'] = $this->product_model->get_services();
        $this->load->view('partials/_header', $data);
        $this->load->view('product/request_service');
        $this->load->view('partials/_footer');
    }

    public function request_service_post(){
        $this->form_validation->set_rules('request_phone','Phone Number', 'required|xss_clean|min_length[11]|max_length[100]');
        $this->form_validation->set_rules('request_name', "Full Name", 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('request_address',"Address", 'required|xss_clean|max_length[200]');


        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->product_model->service_request_values());
            redirect($this->agent->referrer());
        } else {
            $service_type = $this->input->post('service_type', true);
            $service_date = $this->input->post('service_date', true);
            $service_start_time = $this->input->post('service_start_time',true);
            $service_end_time = $this->input->post('service_end_time',true);
            $service_description = $this->input->post('service_description',true);
            $request_name = $this->input->post('request_name', true);
            $request_address = $this->input->post('request_address', true);
            $request_phone = $this->input->post('request_phone',true);
            $request_email = $this->input->post('request_email',true);
            
            //is email unique
            if ($service_type == 'none') {
                $this->session->set_flashdata('form_data', $this->product_model->service_request_values());
                $this->session->set_flashdata('error', "Select a valid service type");
                redirect($this->agent->referrer());
            }

            //is username unique
            if (strtotime($service_date) <  time()) {
                $this->session->set_flashdata('form_data', $this->product_model->service_request_values());
                $this->session->set_flashdata('error',"Please Select Valid Date");
                redirect($this->agent->referrer());
            }

            $service = $this->product_model->service_request($service_type,$service_date,$service_start_time,$service_end_time,$service_description,$request_phone,$request_email,$request_address,$request_name);
            if($service){
                $this->session->set_flashdata('success', "Your Service Request was successful, a qualified agent of ours will be sent to your address shortly");
                redirect($this->agent->referrer());
                }else{
                $this->session->set_flashdata('form_data', $this->product_model->service_request_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());  
                }
            }
        }
    /**
     * Add Product Post
     */
    public function add_product_post()
    {
        //check auth
        if (!auth_check()) {
            redirect(base_url());
        }
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->product_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //add product
            if ($this->product_model->add_product()) {
                //last id
                $last_id = $this->db->insert_id();
                //update slug
                $this->product_model->update_slug($last_id);
                //add product images
                $this->file_model->add_product_images($last_id);
                    if ($this->product_model->set_product_completed($last_id)) {
                                $email = user()->email;
                                $this->load->model("email_model");
                                $subject = "Product Added Successfuly";
                                $message = trans("msg_product_added");
                                $this->email_model->send_email($email, null, $subject, $message);
                                $data["product"] = $this->product_model->get_product_by_id($last_id);
/*                               $fb = new Facebook\Facebook([
                                 'app_id' => '487208345378110',
                                 'app_secret' => '89a915c995ea96bd76bc902b796c0437',
                                 'default_graph_version' => 'v2.5',
                                ]);
                                $page_id = '101296194928471';
                                $linkData = [
                                 'link' => 'https://akyegroup.com/'.$data["product"]->slug,
                                 'caption' => $data["product"]->title,
                                 'description' => $data["product"]->description,
                                 'message' => $data["product"]->title.' sold at &#x20a6;'.$data["product"]->price,
                                 'picture' => get_product_small_image($data["product"]->id)
                                ];
                                $pageAccessToken ='EAAG7HQhbnT4BAGTo7f5V45nilJTIHo3onjV3ZBlRO2Reg8rMKiao0FZAfstYLDBhEVCQpUKSnJNOijkX3JJw4vmrDKUfNZCofKN8mvi13BGhFV6GA95Cm4XZCS1WoomszyKzugwZA8VYmVZB0KRlrIJZCEAnCepga852Yo1JiEX7wZDZD';

                                try {
                                 $response = $fb->post($page_id.'/feed', $linkData, $pageAccessToken);
                                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                                 echo 'Graph returned an error: '.$e->getMessage();
                                 exit;
                                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                                 echo 'Facebook SDK returned an error: '.$e->getMessage();
                                 exit;
                                }
                                $graphNode = $response->getGraphNode();*/

                                    $page_access_token = 'EAAG7HQhbnT4BAGTo7f5V45nilJTIHo3onjV3ZBlRO2Reg8rMKiao0FZAfstYLDBhEVCQpUKSnJNOijkX3JJw4vmrDKUfNZCofKN8mvi13BGhFV6GA95Cm4XZCS1WoomszyKzugwZA8VYmVZB0KRlrIJZCEAnCepga852Yo1JiEX7wZDZD';
                                    $page_id = '101296194928471';
                                    $data['picture'] = get_product_small_image($data["product"]->id);
                                    $data['link'] = 'https://akyegroup.com/'.$data["product"]->slug;
                                    $data['message'] = $data["product"]->title.' sold at &#x20a6;'.$data["product"]->price;
                                    $data['caption'] = $data["product"]->title;
                                    $data['description'] = $data["product"]->description;
                                    $data['access_token'] = $page_access_token;
                                    $post_url = 'https://graph.facebook.com/'.$page_id.'/feed';
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $post_url);
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    $return = curl_exec($ch);
                                    curl_close($ch);

                        $this->session->set_flashdata('success', trans("msg_product_added"));
                        redirect(base_url() . "swap-now");
                    } else {
                        $this->session->set_flashdata('error', trans("msg_error"));
                        redirect(base_url() . "swap-now");
                    }
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Pricing
     */
    public function pricing($product_id)
    {
        //check auth
        if (!auth_check()) {
            redirect(base_url());
        }

        if ($this->promoted_products_enabled != 1) {
            redirect(base_url());
        }

        $data["product"] = $this->product_model->get_product_by_id($product_id);
        if (empty($data["product"])) {
            redirect(base_url());
        }
        //check product user
        if ($data["product"]->user_id != user()->id) {
            redirect(base_url());
        }

        $m_type = trim($this->input->get('m_type', true));
        if ($m_type != "existing" && $m_type != "new") {
            redirect(base_url());
        }

        $data['title'] = trans("pricing");
        $data['description'] = trans("pricing") . " - " . $this->app_name;
        $data['keywords'] = trans("pricing") . "," . $this->app_name;
        $this->load->view('partials/_header', $data);
        $this->load->view('product/pricing', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Pricing Post
     */
    public function pricing_post()
    {
        //check auth
        if (!auth_check()) {
            redirect(base_url());
        }

        //check plan type
        $plan_type = $this->input->post('plan_type', true);
        $product_id = $this->input->post('product_id', true);
        if ($plan_type == "free") {

            if ($this->product_model->set_product_completed($product_id)) {
                $email = user()->email;
                $this->load->model("email_model");
                $subject = "Product Added Successfuly";
                $message = trans("msg_product_added");
        $this->email_model->send_email($email, null, $subject, $message);
                $this->session->set_flashdata('success', trans("msg_product_added"));
                redirect(base_url() . "swap-now");
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect(base_url() . "pricing/" . $product_id);
            }
        } else {
            $price_per_day = price_format($this->general_settings->price_per_day);
            $price_per_month = price_format($this->general_settings->price_per_month);
            $day_count = $this->input->post('day_count', true);
            $month_count = $this->input->post('month_count', true);
            $total_amount = 0;
            if ($plan_type == "daily") {
                $total_amount = number_format($day_count * $price_per_day, 2, ".", "");
            }
            if ($plan_type == "monthly") {
                $day_count = $month_count * 30;
                $total_amount = number_format($month_count * $price_per_month, 2, ".", "");
            }
            $m_type = $this->input->post('m_type', true);
            //create paypal payment
            $this->load->model("paypal_model");
            $result = $this->paypal_model->create_payment($product_id, $total_amount, $plan_type, $day_count, $m_type);
            redirect($result);
        }
    }

    /**
     * Execute Paypal Payment
     */
    public function execute_paypal_payment()
    {
        //execute paypal payment
        $this->load->model("paypal_model");
        $result = $this->paypal_model->execute_payment();
        redirect($result);
    }


    /**
     * Pay with Stripe
     */
    public function pay_with_stripe()
    {
        if (!auth_check()) {
            $this->session->set_flashdata('error', trans("msg_error"));
            exit();
        }

        $product_id = $this->input->post('product_id', true);
        $token = $this->input->post('token', true);
        $email = $this->input->post('email', true);
        $plan_type = $this->input->post('plan_type', true);
        $day_count = $this->input->post('day_count', true);
        $month_count = $this->input->post('month_count', true);
        $m_type = $this->input->post('m_type', true);

        $price_per_day = price_format($this->general_settings->price_per_day);
        $price_per_month = price_format($this->general_settings->price_per_month);

        $total_amount = 0;
        $purchased_plan = "";
        if ($plan_type == "daily") {
            $total_amount = number_format($day_count * $price_per_day, 2);
            $purchased_plan = trans("daily_plan") . " (" . $day_count . " " . trans("days") . ")";
        }

        if ($plan_type == "monthly") {
            $day_count = $month_count * 30;
            $total_amount = number_format($month_count * $price_per_month, 2);
            $purchased_plan = trans("monthly_plan") . " (" . $day_count . " " . trans("days") . ")";
        }

        require_once(APPPATH . 'third_party/stripe/vendor/autoload.php');
        try {
            //Init stripe
            $stripe = array(
                "secret_key" => $this->general_settings->stripe_secret_key,
                "publishable_key" => $this->general_settings->stripe_publishable_key
            );
            \Stripe\Stripe::setApiKey($stripe['secret_key']);
            //customer
            $customer = \Stripe\Customer::create(array(
                'email' => $email,
                'source' => $token
            ));
            $charge = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount' => $total_amount * 100,
                'currency' => $this->general_settings->currency,
                'description' => $purchased_plan
            ));

            $data = array(
                'payment_method' => "Stripe",
                'payment_id' => $token,
                'user_id' => user()->id,
                'product_id' => $product_id,
                'currency' => $this->general_settings->currency,
                'payment_amount' => $total_amount,
                'payer_email ' => $email,
                'payment_status' => $charge->status,
                'purchased_plan' => $purchased_plan,
                'created_at' => date("Y-m-d H:i:s")
            );
            //add payment
            $this->load->model("payment_model");
            if ($m_type == "new") {
                if ($this->payment_model->add_payment($data)) {
                    $this->product_model->add_to_promoted_products($product_id, $purchased_plan, $day_count);
                    $this->session->set_flashdata('success', trans("msg_add_product_success"));
                    echo base_url() . "swap-now";
                } else {
                    $this->session->set_flashdata('error', trans("msg_payment_database_error"));
                    echo base_url() . "swap-now";
                }
            } else {
                if ($this->payment_model->add_payment($data)) {
                    $this->product_model->add_to_promoted_products($product_id, $purchased_plan, $day_count);
                    $this->session->set_flashdata('success', trans("msg_payment_success"));
                    echo base_url() . "pricing/" . $product_id . "?m_type=$m_type";
                } else {
                    $this->session->set_flashdata('error', trans("msg_payment_database_error"));
                    echo base_url() . "pricing/" . $product_id . "?m_type=$m_type";
                }
            }

        } catch (\Stripe\Error\Base $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            echo $e->getMessage();
            exit();
        } catch (Exception $e) {
            $this->session->set_flashdata('error', trans("msg_error"));
            echo base_url() . "pricing/" . $product_id . "?m_type=$m_type";
        }
    }


    /**
     * Update Product
     */
    public function update_product($id)
    {
        //check auth
        if (!auth_check()) {
            redirect(base_url());
        }

        $data["product"] = $this->product_admin_model->get_product($id);
        if (empty($data["product"])) {
            redirect($this->agent->referrer());
        }
        if ($data["product"]->user_id != user()->id && user()->role != "admin") {
            redirect($this->agent->referrer());
        }

        $data['title'] = trans("update_product");
        $data['description'] = trans("update_product") . " - " . $this->app_name;
        $data['keywords'] = trans("update_product") . "," . $this->app_name;

        $data['subcategories'] = $this->category_model->get_subcategories_by_parent_id($data["product"]->category_id);
        $data['third_categories'] = $this->category_model->get_subcategories_by_parent_id($data["product"]->subcategory_id);
        if ($this->general_settings->default_product_location == 0) {
            $data["states"] = $this->location_model->get_states_by_country($data["product"]->country_id);
        } else {
            $data["states"] = $this->location_model->get_states_by_country($this->general_settings->default_product_location);
        }
        
        $data["images_array"] = $this->file_model->get_product_images_array($data["product"]->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/update_product');
        $this->load->view('partials/_footer');
    }

    /**
     * Update Product Post
     */

    public function update_product_post()
    {
        //check auth
        if (!auth_check()) {
            redirect(base_url());
        }

        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            //product id
            $product_id = $this->input->post('id', true);

            if ($this->product_model->update_product($product_id)) {
                //update slug
                $this->product_model->update_slug($product_id);
                //add product images
                $this->file_model->add_product_images($product_id);

                $this->session->set_flashdata('success', trans("msg_product_updated"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Filter Products
     */
    public function filter_products()
    {
        $search_type = $this->input->post('search_type', true);
        $search = trim($this->input->post('search', true));
        //set sort
        $sort = $this->input->post("sort", true);
        if (!empty($sort)) {
            $_SESSION["modesy_sort_products"] = $sort;
        }

        //filters
        $category_id = $this->input->post("category_id", true);
        $subcategory_id = $this->input->post("subcategory_id", true);
        $third_category_id = $this->input->post("third_category_id", true);
        $country = $this->input->post("country", true);
        $state = $this->input->post("state", true);
        $condition = $this->input->post("condition", true);
        $p_min = $this->input->post("p_min", true);
        $p_max = $this->input->post("p_max", true);

        //reset filters
        $reset_search = $this->input->post("reset_search", true);
        $rreset_price = $this->input->post("reset_price", true);
        if (!empty($reset_search)) {
            $search = "";
        }
        if (!empty($rreset_price)) {
            $p_min = "";
            $p_max = "";
        }

        if (!empty($category_id)) {
            $category = $this->category_model->get_category($category_id);
        }
        if (!empty($subcategory_id)) {
            $subcategory = $this->category_model->get_category($subcategory_id);
        }
        if (!empty($third_category_id)) {
            $third_category = $this->category_model->get_category($third_category_id);
        }
        if (empty($condition)) {
            $condition = "all";
        }
        //generate query string
        $query_string = "?condition=" . $condition;
        if (!empty($_SESSION["modesy_sort_products"])) {
            $query_string .= "&sort=" . $_SESSION["modesy_sort_products"];
        }
        if (!empty($country)) {
            $query_string .= "&country=" . $country;
        }
        if (!empty($state)) {
            $query_string .= "&state=" . $state;
        }
        if ($p_min != "") {
            $query_string .= "&p_min=" . intval($p_min);
        }
        if ($p_max != "") {
            $query_string .= "&p_max=" . intval($p_max);
        }

        if ($search != ""){
            $query_string .= "&search=" . $search;
        }

        if (!empty($third_category) && !empty($subcategory) && !empty($category)) {
            redirect(base_url() . 'category' . '/' . $category->slug . '/' . $subcategory->slug . '/' . $third_category->slug . $query_string);
        } elseif (!empty($subcategory) && !empty($category)) {
            redirect(base_url() . 'category' . '/' . $category->slug . '/' . $subcategory->slug . $query_string);
        } elseif (!empty($category)) {
            redirect(base_url() . 'category' . '/' . $category->slug . $query_string);
        } else {
            redirect(base_url() . 'products' . $query_string);
        }
    }


    /**
     * Products
     */
    public function products()
    {
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;

        //get paginated posts
        $link = base_url() . 'products';
        $pagination = $this->paginate($link, $this->product_model->get_paginated_filtered_products_count(null, null, null), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_products(null, null, null, $pagination['per_page'], $pagination['offset']);
        $data["categories"] = $this->category_model->get_parent_categories();

        //filters
        $data['filter_country'] = $this->input->get("country");
        $data['filter_state'] = $this->input->get("state");
        $data['filter_condition'] = $this->input->get("condition");
        $data['filter_p_min'] = $this->input->get("p_min");
        $data['filter_p_max'] = $this->input->get("p_max");
        $data['filter_sort'] = $this->input->get("sort");
        $data['filter_search'] = $this->input->get("search");

        if (empty($data['filter_sort'])) {
            if (isset($_SESSION["modesy_sort_products"])) {
                unset($_SESSION["modesy_sort_products"]);
            }
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Category
     */
    public function category($slug)
    {
        $data["category"] = $this->category_model->get_category_by_slug($slug);
        if (empty($data['category'])) {
            redirect($this->agent->referrer());
        }
        $data["subcategories"] = $this->category_model->get_subcategories_by_parent_id($data["category"]->id);

        $data['title'] = $data["category"]->name;
        $data['description'] = $data["category"]->description;
        $data['keywords'] = $data["category"]->keywords;

        //get paginated posts
        $link = base_url() . 'category/' . $data["category"]->slug;
        $pagination = $this->paginate($link, $this->product_model->get_paginated_filtered_products_count($data["category"]->id, null, null), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_products($data["category"]->id, null, null, $pagination['per_page'], $pagination['offset']);

        //filters
        $data['filter_country'] = $this->input->get("country");
        $data['filter_state'] = $this->input->get("state");
        $data['filter_condition'] = $this->input->get("condition");
        $data['filter_p_min'] = $this->input->get("p_min");
        $data['filter_p_max'] = $this->input->get("p_max");
        $data['filter_sort'] = $this->input->get("sort");
        $data['filter_search'] = $this->input->get("search");

        if (empty($data['filter_sort'])) {
            if (isset($_SESSION["modesy_sort_products"])) {
                unset($_SESSION["modesy_sort_products"]);
            }
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Subcategory
     */
    public function subcategory($category_slug, $subcategory_slug)
    {
        $data["category"] = $this->category_model->get_category_by_slug($category_slug);
        if (empty($data['category'])) {
            redirect($this->agent->referrer());
        }
        $data["subcategory"] = $this->category_model->get_category_by_slug($subcategory_slug);
        if (empty($data['subcategory'])) {
            redirect($this->agent->referrer());
        }
        $data["third_categories"] = $this->category_model->get_subcategories_by_parent_id($data["subcategory"]->id);

        $data['title'] = $data["category"]->name;
        $data['description'] = $data["category"]->description;
        $data['keywords'] = $data["category"]->keywords;

        //get paginated posts
        $link = base_url() . 'category/' . $data["category"]->slug . '/' . $data["subcategory"]->slug;
        $pagination = $this->paginate($link, $this->product_model->get_paginated_filtered_products_count($data["category"]->id, $data["subcategory"]->id, null), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_products($data["category"]->id, $data["subcategory"]->id, null, $pagination['per_page'], $pagination['offset']);

        //filters
        $data['filter_country'] = $this->input->get("country");
        $data['filter_state'] = $this->input->get("state");
        $data['filter_condition'] = $this->input->get("condition");
        $data['filter_p_min'] = $this->input->get("p_min");
        $data['filter_p_max'] = $this->input->get("p_max");
        $data['filter_sort'] = $this->input->get("sort");
        $data['filter_search'] = $this->input->get("search");

        if (empty($data['filter_sort'])) {
            if (isset($_SESSION["modesy_sort_products"])) {
                unset($_SESSION["modesy_sort_products"]);
            }
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Third Category
     */
    public function third_category($category_slug, $subcategory_slug, $thirdcategory_slug)
    {
        $data["category"] = $this->category_model->get_category_by_slug($category_slug);
        if (empty($data['category'])) {
            redirect($this->agent->referrer());
        }
        $data["subcategory"] = $this->category_model->get_category_by_slug($subcategory_slug);
        if (empty($data['subcategory'])) {
            redirect($this->agent->referrer());
        }
        $data["third_category"] = $this->category_model->get_category_by_slug($thirdcategory_slug);
        if (empty($data['third_category'])) {
            redirect($this->agent->referrer());
        }

        $data["third_categories"] = $this->category_model->get_subcategories_by_parent_id($data["subcategory"]->id);

        $data['title'] = $data["category"]->name;
        $data['description'] = $data["category"]->description;
        $data['keywords'] = $data["category"]->keywords;

        //get paginated posts
        $link = base_url() . 'category/' . $data["category"]->slug . '/' . $data["subcategory"]->slug . '/' . $data["third_category"]->slug;
        $pagination = $this->paginate($link, $this->product_model->get_paginated_filtered_products_count($data["category"]->id, $data["subcategory"]->id, $data["third_category"]->id), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_products($data["category"]->id, $data["subcategory"]->id, $data["third_category"]->id, $pagination['per_page'], $pagination['offset']);

        //filters
        $data['filter_country'] = $this->input->get("country");
        $data['filter_state'] = $this->input->get("state");
        $data['filter_condition'] = $this->input->get("condition");
        $data['filter_p_min'] = $this->input->get("p_min");
        $data['filter_p_max'] = $this->input->get("p_max");
        $data['filter_sort'] = $this->input->get("sort");
        $data['filter_search'] = $this->input->get("search");

        if (empty($data['filter_sort'])) {
            if (isset($_SESSION["modesy_sort_products"])) {
                unset($_SESSION["modesy_sort_products"]);
            }
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Delete Product
     */
    public function delete_product()
    {
        //check auth
        if (!auth_check()) {
            redirect(base_url());
        }

        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_product($id)) {
            $this->session->set_flashdata('success', trans("msg_product_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    //make review
    public function make_review()
    {
        if ($this->general_settings->product_reviews != 1) {
            exit();
        }
        $limit = $this->input->post('limit', true);
        $product_id = $this->input->post('product_id', true);
        $review = $this->review_model->get_review($product_id, user()->id);
        $data["product"] = $this->product_model->get_product_by_id($product_id);

        if (!empty($review)) {
            echo "voted_error";
        } elseif ($data["product"]->user_id == user()->id) {
            echo "error_own_product";
        } else {
            $this->review_model->add_review();
            $data["reviews"] = $this->review_model->get_limited_reviews($product_id, $limit);
            $data['review_count'] = $this->review_model->get_review_count($data["product"]->id);
            $data['review_limit'] = $limit;
            $data["product"] = $this->product_model->get_product_by_id($product_id);
            $this->load->view('product/_make_review', $data);
        }
    }


    //load more review
    public function load_more_review()
    {
        $product_id = $this->input->post('product_id', true);
        $limit = $this->input->post('limit', true);
        $new_limit = $limit + $this->review_limit;
        $data["product"] = $this->product_model->get_product_by_id($product_id);
        $data["reviews"] = $this->review_model->get_limited_reviews($product_id, $new_limit);
        $data['review_count'] = $this->review_model->get_review_count($data["product"]->id);
        $data['review_limit'] = $new_limit;

        $this->load->view('product/_make_review', $data);
    }

    //delete review
    public function delete_review()
    {
        $id = $this->input->post('id', true);
        $product_id = $this->input->post('product_id', true);
        $limit = $this->input->post('limit', true);
        $this->review_model->delete_review($id, $product_id);
        $data["product"] = $this->product_model->get_product_by_id($product_id);
        $data["reviews"] = $this->review_model->get_limited_reviews($product_id, $limit);
        $data['review_count'] = $this->review_model->get_review_count($data["product"]->id);
        $data['review_limit'] = $limit;

        $this->load->view('product/_make_review', $data);
    }

    //make comment
    public function make_comment()
    {
        if ($this->general_settings->product_comments != 1) {
            exit();
        }
        $limit = $this->input->post('limit', true);
        $product_id = $this->input->post('product_id', true);

        if (auth_check()) {
            $this->comment_model->add_comment();
        } else {
            if ($this->recaptcha_verify_request()) {
                $this->comment_model->add_comment();
            }
        }

        $data["product"] = $this->product_model->get_product_by_id($product_id);
        $data['comment_count'] = $this->comment_model->get_product_comment_count($product_id);
        $data['comments'] = $this->comment_model->get_comments($product_id, $limit);
        $data['comment_limit'] = $limit;

        $this->load->view('product/_comments', $data);
    }

    //load more comment
    public function load_more_comment()
    {
        $product_id = $this->input->post('product_id', true);
        $limit = $this->input->post('limit', true);
        $new_limit = $limit + $this->comment_limit;
        $data["product"] = $this->product_model->get_product_by_id($product_id);
        $data["comments"] = $this->comment_model->get_comments($product_id, $new_limit);
        $data['comment_count'] = $this->comment_model->get_product_comment_count($data["product"]->id);
        $data['comment_limit'] = $new_limit;

        $this->load->view('product/_comments', $data);
    }

    //delete comment
    public function delete_comment()
    {
        $id = $this->input->post('id', true);
        $product_id = $this->input->post('product_id', true);
        $limit = $this->input->post('limit', true);
        $this->comment_model->delete_comment($id);
        $data["product"] = $this->product_model->get_product_by_id($product_id);
        $data["comments"] = $this->comment_model->get_comments($product_id, $limit);
        $data['comment_count'] = $this->comment_model->get_product_comment_count($data["product"]->id);
        $data['comment_limit'] = $limit;

        $this->load->view('product/_comments', $data);
    }

    //delete comment
    public function load_subcomment_box()
    {
        $comment_id = $this->input->post('comment_id', true);
        $limit = $this->input->post('limit', true);
        $data["parent_comment"] = $this->comment_model->get_comment($comment_id);
        $data["comment_limit"] = $limit;
        $this->load->view('product/_make_subcomment', $data);
    }

    //add or remove favorites
    public function add_remove_favorites()
    {
        if (auth_check()) {
            $product_id = $this->input->post('product_id', true);
            $user_id = user()->id;
            $this->product_model->add_remove_favorites($user_id, $product_id);
            redirect($this->agent->referrer());
        }
    }

    //add or remove favorites
    public function add_remove_favorite_ajax()
    {
        if (auth_check()) {
            $product_id = $this->input->post('product_id', true);
            $user_id = user()->id;
            $this->product_model->add_remove_favorites($user_id, $product_id);
        }
    }

    //get states
    public function get_states()
    {
        $country_id = $this->input->post('country_id', true);
        $states = $this->location_model->get_states_by_country($country_id);
        foreach ($states as $item) {
            echo '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

        public function get_cities()
    {
        $state_id = $this->input->post('state_id', true);
        $cities = $this->location_model->get_cities_by_state($state_id);
        foreach ($cities as $item) {
            echo '<option value="' . $item->city_id . '">' . $item->city_name . '</option>';
        }
    }

            public function load_description()
    {
        $category_id = $this->input->post('category_id', true);
        if($category_id == 108){
          $this->load->view('partials/_phones');
        }
        if($category_id == 71 OR $category_id == 72){
          $this->load->view('partials/_computers');  
        }
    }

    //show address on map
    public function show_address_on_map()
    {
        $country_text = $this->input->post('country_text', true);
        $country_val = $this->input->post('country_val', true);
        $state_text = $this->input->post('state_text', true);
        $state_val = $this->input->post('state_val', true);
        $address = $this->input->post('address', true);

        $adress_details = $address;
        $data["map_address"] = "";
        if (!empty($adress_details)) {
            $data["map_address"] = $adress_details . " ";
        }
        if (!empty($state_val)) {
            $data["map_address"] = $data["map_address"] . $state_text . " ";
        }
        if (!empty($country_val)) {
            $data["map_address"] = $data["map_address"] . $country_text;
        }

        $this->load->view('product/_load_map', $data);
    }

    public function get_autocomplete(){
        $term = $this->input->post('term');
        if(isset($term)){
            $result = $this->product_model->search_brand($term);
            if(count($result) > 0){
                foreach ($result as $row) {
                     echo '<li onclick="setIt(\''.$row->brand.'\')"><span  class="s">' . $row->brand . '</span></li>';
                }
            }
        }
    }
       public function get_autocomplete_models(){
        $brand = $this->input->post('brand');
        $model = $this->input->post('model');
        if(isset($model)){
            $result = $this->product_model->search_model($brand,$model);
            if(count($result) > 0){
                foreach ($result as $row) {
                     echo '<li onclick="setmodel(\''.$row->model.'\')"><span  class="s">' . $row->model . '</span></li>';
                }
            }
        }
    } 

    public function swapped(){
        $product_id = $this->input->post('prod_id');
        $swapped = $this->input->post('swapped');
        $int_swapped = $this->input->post('int_swapped');
        $init_quant = $this->input->post('init_quant');
        $nt = $swapped + $int_swapped;
        if($nt <= $init_quant){
         $res = $this->product_model->swapped($product_id,$nt);
        if($res){
            $this->session->set_flashdata('success', "Update successful");
             redirect($this->agent->referrer());
        }else{
            $this->session->set_flashdata('error', "Update failed");
             redirect($this->agent->referrer());
        }
        }else{
           $this->session->set_flashdata('error', "Quantity Swapped is above Initial Quantity");
             redirect($this->agent->referrer());
        }
    }

}