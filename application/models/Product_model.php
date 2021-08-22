<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'title' => $this->input->post('title', true),
            'category_id' => $this->input->post('category_id', true),
            'subcategory_id' => $this->input->post('subcategory_id', true),
            'third_category_id' => $this->input->post('third_category_id', true),
            'price' => $this->input->post('price', true),
            'currency' => $this->input->post('currency', true),
            'description' => $this->input->post('description', true),
            'product_condition' => $this->input->post('product_condition', true),
            'country_id' => user()->country_id,
            'state_id' => user()->state_id,
            'city_id' => user()->city_id,
            'address' => user()->address,
            'user_id' => user()->id,
            'status' => 0,
            'is_promoted' => 0,
            'promote_start_date' => date('Y-m-d H:i:s'),
            'promote_end_date' => date('Y-m-d H:i:s'),
            'promote_plan' => "none",
            'promote_day' => 0,
            'visibility' => 1,
            'rating' => 0,
            'hit' => 0,
            'is_completed' => 0,
            'quantity' => $this->input->post('quantity', true),
            'created_at' => date('Y-m-d H:i:s'),
        );

              if($data['subcategory_id'] == 108){
               $data['brand'] = $this->input->post('brand',true);
               $data['model'] = $this->input->post('model',true);
               $data['ram'] = $this->input->post('ram',true);
               $data['memory'] = $this->input->post('memory',true);
               $data['color'] = $this->input->post('color',true);
               $data['screen_size'] = $this->input->post('screen_size',true);
               $data['camera'] = $this->input->post('camera',true);
               $data['battery'] = $this->input->post('battery',true);
              }

              if($data['subcategory_id'] == 71 OR $data['subcategory_id'] == 72){
               $data['brand'] = $this->input->post('brand',true);
               $data['model'] = $this->input->post('model',true);
               $data['ram'] = $this->input->post('ram',true);
               $data['memory'] = $this->input->post('memory',true);
               $data['color'] = $this->input->post('color',true);
               $data['screen_size'] = $this->input->post('screen_size',true);
              }

        return $data;
    }

public function service_request_values(){
$data = array(
'service_type' => $this->input->post('service_type', true),
'service_date' => $this->input->post('service_date', true),
'service_start_time' => $this->input->post('service_start_time',true),
'service_end_time' => $this->input->post('service_end_time',true),
'request_phone' => $this->input->post('request_phone',true),
'request_address' => $this->input->post('request_address',true),
'request_name' => $this->input->post('request_name',true),
'service_description' => $this->input->post('service_description',true)
);
return $data;
}

    public function service_request($service_type,$service_date,$service_start_time,$service_end_time,$service_description,$request_phone,$request_email,$request_address,$request_name){
        $data = $this->product_model->service_request_values();
  if ($this->db->insert('request_service', $data)) {
  $message =  '<!doctype html>
  <html>
  <head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Akyegroup Service Request</title>
  <style>
  img {
  border: none;
  -ms-interpolation-mode: bicubic;
  max-width: 100%; 
  }

  body {
  background-color: #f6f6f6;
  font-family: sans-serif;
  -webkit-font-smoothing: antialiased;
  font-size: 14px;
  line-height: 1.4;
  margin: 0;
  padding: 0;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%; 
  }

  table {
  border-collapse: separate;
  mso-table-lspace: 0pt;
  mso-table-rspace: 0pt;
  width: 100%; }
  table td {
  font-family: sans-serif;
  font-size: 14px;
  vertical-align: top; 
  }


  .body {
  background-color: #f6f6f6;
  width: 100%; 
  }

  .content {
  box-sizing: border-box;
  display: block;
  margin: 0 auto;
  max-width: 580px;
  padding: 10px; 
  }

  .main {
  background: #ffffff;
  border-radius: 3px;
  width: 100%; 
  }

  .wrapper {
  box-sizing: border-box;
  padding: 20px; 
  }

  .content-block {
  padding-bottom: 10px;
  padding-top: 10px;
  }

  .footer {
  clear: both;
  margin-top: 10px;
  text-align: center;
  width: 100%; 
  }
  .footer td,
  .footer p,
  .footer span,
  .footer a {
  color: #999999;
  font-size: 12px;
  text-align: center; 
  }

  h1,
  h2,
  h3,
  h4 {
  color: #000000;
  font-family: sans-serif;
  font-weight: 400;
  line-height: 1.4;
  margin: 0;
  margin-bottom: 30px; 
  }

  h1 {
  font-size: 35px;
  font-weight: 300;
  text-align: center;
  text-transform: capitalize; 
  }

  p,
  ul,
  ol {
  font-family: sans-serif;
  font-size: 14px;
  font-weight: normal;
  margin: 0;
  margin-bottom: 15px; 
  }
  p li,
  ul li,
  ol li {
  list-style-position: inside;
  margin-left: 5px; 
  }

  a {
  color: #3498db;
  text-decoration: underline; 
  }

  .btn {
  box-sizing: border-box;
  width: 100%; }
  .btn > tbody > tr > td {
  padding-bottom: 15px; }
  .btn table {
  width: auto; 
  }
  .btn table td {
  background-color: #ffffff;
  border-radius: 5px;
  text-align: center; 
  }
  .btn a {
  background-color: #ffffff;
  border: solid 1px #3498db;
  border-radius: 5px;
  box-sizing: border-box;
  color: #3498db;
  cursor: pointer;
  display: inline-block;
  font-size: 14px;
  font-weight: bold;
  margin: 0;
  padding: 12px 25px;
  text-decoration: none;
  text-transform: capitalize; 
  }

  .btn-primary table td {
  background-color: #3498db; 
  }

  .btn-primary a {
  background-color: #3498db;
  border-color: #3498db;
  color: #ffffff; 
  }

  .last {
  margin-bottom: 0; 
  }

  .first {
  margin-top: 0; 
  }

  .align-center {
  text-align: center; 
  }

  .align-right {
  text-align: right; 
  }

  .align-left {
  text-align: left; 
  }

  .clear {
  clear: both; 
  }

  .mt0 {
  margin-top: 0; 
  }

  .mb0 {
  margin-bottom: 0; 
  }

  .preheader {
  color: transparent;
  display: none;
  height: 0;
  max-height: 0;
  max-width: 0;
  opacity: 0;
  overflow: hidden;
  mso-hide: all;
  visibility: hidden;
  width: 0; 
  }

  .powered-by a {
  text-decoration: none; 
  }

  hr {
  border: 0;
  border-bottom: 1px solid #f6f6f6;
  margin: 20px 0; 
  }
  @media only screen and (max-width: 620px) {
  table[class=body] h1 {
  font-size: 28px !important;
  margin-bottom: 10px !important; 
  }
  table[class=body] p,
  table[class=body] ul,
  table[class=body] ol,
  table[class=body] td,
  table[class=body] span,
  table[class=body] a {
  font-size: 16px !important; 
  }
  table[class=body] .wrapper,
  table[class=body] .article {
  padding: 10px !important; 
  }
  table[class=body] .content {
  padding: 0 !important; 
  }
  table[class=body] .container {
  padding: 0 !important;
  width: 100% !important; 
  }
  table[class=body] .main {
  border-left-width: 0 !important;
  border-radius: 0 !important;
  border-right-width: 0 !important; 
  }
  table[class=body] .btn table {
  width: 100% !important; 
  }
  table[class=body] .btn a {
  width: 100% !important; 
  }
  table[class=body] .img-responsive {
  height: auto !important;
  max-width: 100% !important;
  width: auto !important; 
  }
  }

  @media all {
  .ExternalClass {
  width: 100%; 
  }
  .ExternalClass,
  .ExternalClass p,
  .ExternalClass span,
  .ExternalClass font,
  .ExternalClass td,
  .ExternalClass div {
  line-height: 100%; 
  }
  .apple-link a {
  color: inherit !important;
  font-family: inherit !important;
  font-size: inherit !important;
  font-weight: inherit !important;
  line-height: inherit !important;
  text-decoration: none !important; 
  }
  #MessageViewBody a {
  color: inherit;
  text-decoration: none;
  font-size: inherit;
  font-family: inherit;
  font-weight: inherit;
  line-height: inherit;
  }
  .btn-primary table td:hover {
  background-color: #34495e !important; 
  }
  .btn-primary a:hover {
  background-color: #34495e !important;
  border-color: #34495e !important; 
  } 
  }

  </style>
  </head>
  <body class="">
  <center><img scr="<?=get_logo($general_settings); ?>"></center>
  <span class="preheader">Request For Service From akyegroup.com</span>
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
  <tr>
  <td>&nbsp;</td>
  <td class="container">
  <div class="content">
  <table role="presentation" class="main">
  <tr>
  <td class="wrapper">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td>
  <p>Hi there,</p>
  <p>'.$request_name.' has requested for a '.$service_type.' the service should be provided not after '.$service_date.' between '.$service_start_time.' & '.$service_end_time.'<br>Contact Details are as follows:-<br>Address: '.$request_address.' Phone Number: '.$request_phone.'</p>
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
  <tbody>
  <tr>
  <td align="left">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
  <tbody>
  <tr>
  <td> <a href="https://akyegroup.com" target="_blank">Attend to Request</a> </td>
  </tr>
  </tbody>
  </table>
  </td>
  </tr>
  </tbody>
  </tYour Attention is needed to attend to the Service Delivery Request.</p>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  </div>
  </td>
  <td>&nbsp;</td>
  </tr>
  </table>
  </body>
  </html>
  ';
            $this->send_admin_service_request_email($message);
            return true;
        }else{
            return false;
        }
    }

    public function send_admin_service_request_email($message){
            $subject = 'Request For Service Delivery';
            $recipient = 'info@akyegroup.com';
            //send email
            $this->load->model("email_model");
            if ($this->email_model->send_email($recipient, null, $subject, $message)) {
                return true;
            } else {
                return false;
            }
          }

    //input update values
    public function input_update_values()
    {
        $data = array(
            'title' => $this->input->post('title', true),
            'category_id' => $this->input->post('category_id', true),
            'subcategory_id' => $this->input->post('subcategory_id', true),
            'third_category_id' => $this->input->post('third_category_id', true),
            'price' => $this->input->post('price', true),
            'currency' => $this->input->post('currency', true),
            'description' => $this->input->post('description', true),
            'product_condition' => $this->input->post('product_condition', true),
            'visibility' => $this->input->post('visibility', true),
            'country_id' => user()->country_id,
            'state_id' => user()->state_id,
            'city_id' => user()->city_id,
            'address' => user()->address
        );
            if($data['subcategory_id'] == 108){
               $data['brand'] = $this->input->post('brand',true);
               $data['model'] = $this->input->post('model',true);
               $data['ram'] = $this->input->post('ram',true);
               $data['memory'] = $this->input->post('memory',true);
               $data['color'] = $this->input->post('color',true);
               $data['screen_size'] = $this->input->post('screen_size',true);
               $data['camera'] = $this->input->post('camera',true);
               $data['battery'] = $this->input->post('battery',true);
            }

            if($data['subcategory_id'] == 71 OR $data['subcategory_id'] == 72){
               $data['brand'] = $this->input->post('brand',true);
               $data['model'] = $this->input->post('model',true);
               $data['ram'] = $this->input->post('ram',true);
               $data['memory'] = $this->input->post('memory',true);
               $data['color'] = $this->input->post('color',true);
               $data['screen_size'] = $this->input->post('screen_size',true);
            }
        return $data;
    }

    //add product
    public function add_product()
    {
        $data = $this->input_values();
        if (empty($data["subcategory_id"])) {
            $data["subcategory_id"] = 0;
        }
        if (empty($data["third_category_id"])) {
            $data["third_category_id"] = 0;
        } 
        if(user()->role == 'admin'){
            $data['status'] = 1;
        } 
        $data["slug"] = str_slug($data["title"]);
        $data["price"] = number_format($data["price"], 2, '.', '') * 100;
        return $this->db->insert('products', $data);
    }

    //update product
    public function update_product($id)
    {
        $data = $this->input_update_values();
        if (empty($data["subcategory_id"])) {
            $data["subcategory_id"] = 0;
        }
        if (empty($data["third_category_id"])) {
            $data["third_category_id"] = 0;
        }
        $data["slug"] = str_slug($data["title"]);
        $data["price"] = number_format($data["price"], 2, '.', '') * 100;
        if (is_admin()) {
            $data["visibility"] = $this->input->post('visibility', true);
        }
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    //update slug
    public function update_slug($id)
    {
        $product = $this->get_product_by_id($id);

        if (empty($product->slug) || $product->slug == "-") {
            $data = array(
                'slug' => $product->id,
            );
        } else {
            if ($this->general_settings->product_link_structure == "id-slug") {
                $data = array(
                    'slug' => $product->id . "-" . $product->slug,
                );
            } else {
                $data = array(
                    'slug' => $product->slug . "-" . $product->id,
                );
            }
        }

        if (!empty($this->page_model->check_page_slug_for_product($data["slug"]))) {
            $data["slug"] .= uniqid();
        }

        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    //build query
    public function build_query()
    {
        $this->db->join('users', 'products.user_id = users.id');
        $this->db->select('products.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('users.banned', 0);
        $this->db->where('products.status', 1);
        $this->db->where('products.visibility', 1);
        $this->db->where('products.is_completed', 1);

        //default location
        if (isset($modesy_default_location)) {
            $this->db->where('products.country_id', $modesy_default_location);
        }
    }

    //filter products
    public function filter_products($category_id, $subcategory_id, $third_category_id)
    {
        $country = $this->input->get("country", true);
        $state = $this->input->get("state", true);
        $condition = $this->input->get("condition", true);
        $p_min = $this->input->get("p_min", true);
        $p_max = $this->input->get("p_max", true);
        $sort = $this->input->get("sort", true);
        $search = trim($this->input->get('search', true));

        if (!empty($category_id)) {
            $this->db->where('products.category_id', $category_id);
        }
        if (!empty($subcategory_id)) {
            $this->db->where('products.subcategory_id', $subcategory_id);
        }
        if (!empty($third_category_id)) {
            $this->db->where('products.third_category_id', $third_category_id);
        }
        if (!empty($country)) {
            $this->db->where('products.country_id', $country);
        }
        if (!empty($state)) {
            $this->db->where('products.state_id', $state);
        }
        if (!empty($condition) && ($condition == "new" || $condition == "used")) {
            $this->db->where('products.product_condition', $condition);
        }
        if ($p_min != "") {
            $this->db->where('products.price >=', intval($p_min * 100));
        }
        if ($p_max != "") {
            $this->db->where('products.price <=', intval($p_max * 100));
        }
        if ($search != "") {
            $this->db->group_start();
            $this->db->like('products.title', $search);
            $this->db->or_like('products.description', $search);
            $this->db->group_end();
        }
        //sort products
        if (!empty($sort) && $sort == "lowest_price") {
            $this->db->order_by('products.price');
        } elseif (!empty($sort) && $sort == "highest_price") {
            $this->db->order_by('products.price', 'DESC');
        } else {
            $this->db->order_by('products.created_at', 'DESC');
        }
    }

    //get products
    public function get_products()
    {
        $this->build_query();
        $this->db->order_by('products.promote_end_date', 'DESC');
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }
        //get promoted products limited
    public function get_services()
    {
        $this->db->where('role', 'service');
        $this->db->group_by('profession');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get limited products
    public function get_products_limited($limit)
    {
        $this->build_query();
        $this->db->order_by('products.promote_end_date', 'DESC');
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('products');
        return $query->result();
    }

    //load more promoted products
    public function load_more_promoted_products($per_page, $offset)
    {
        $this->build_query();
        $this->db->where('products.is_promoted', 1);
        $this->db->limit($per_page, $offset);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get promoted products
    public function get_promoted_products()
    {
        $this->build_query();
        $this->db->where('products.is_promoted',1);
        $this->db->order_by('products.created_at','DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get promoted products limited
    public function get_promoted_products_limited($limit)
    {
        $this->build_query();
        $this->db->limit($limit);
        $this->db->order_by('products.price', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get promoted products count
    public function get_promoted_products_count()
    {
        $this->build_query();
        $this->db->where('products.is_promoted', 1);
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //check promoted products
    public function check_promoted_products()
    {
        $products = $this->get_promoted_products();
        foreach ($products as $item) {
            if (date_difference($item->promote_end_date, date('Y-m-d H:i:s')) < 1) {
                $data = array(
                    'is_promoted' => 0,
                );
                $this->db->where('id', $item->id);
                $this->db->update('products', $data);
            }
        }
    }

    //get paginated filtered products
    public function get_paginated_filtered_products($category_id, $subcategory_id, $third_category_id, $per_page, $offset)
    {
        $this->build_query();
        $this->filter_products($category_id, $subcategory_id, $third_category_id);
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get paginated filtered products count
    public function get_paginated_filtered_products_count($category_id, $subcategory_id, $third_category_id)
    {
        $this->build_query();
        $this->filter_products($category_id, $subcategory_id, $third_category_id);
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get products count by category
    public function get_products_count_by_category($category_id)
    {
        $this->build_query();
        $this->db->where('products.category_id', $category_id);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get products count by subcategory
    public function get_products_count_by_subcategory($category_id)
    {
        $this->build_query();
        $this->db->where('products.subcategory_id', $category_id);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get products count by third category
    public function get_products_count_by_third_category($category_id)
    {
        $this->build_query();
        $this->db->where('products.third_category_id', $category_id);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get related products
    public function get_related_products($product)
    {
        $this->build_query();
        if ($product->third_category_id != 0) {
            $this->db->where('products.third_category_id', $product->third_category_id);
        }elseif ($product->subcategory_id != 0){
            $this->db->where('products.subcategory_id', $product->subcategory_id);
        }
        else{
            $this->db->where('products.category_id', $product->category_id);
        }
        $this->db->where('products.id !=', $product->id);
        $this->db->limit(4);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get user products
    public function get_user_products($user_slug, $limit, $product_id)
    {
        $this->build_query();
        $this->db->where('users.slug', $user_slug);
        $this->db->where('products.id !=', $product_id);
        $this->db->limit($limit);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get paginated user products
    public function get_paginated_user_products($user_slug, $per_page, $offset)
    {
        $this->build_query();
        $this->db->where('users.slug', $user_slug);
        $this->db->limit($per_page, $offset);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get user products count
    public function get_user_products_count($user_slug)
    {
        $this->build_query();
        $this->db->where('users.slug', $user_slug);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get paginated user pending products
    public function get_paginated_user_pending_products($user_id, $per_page, $offset)
    {
        $this->db->join('users', 'products.user_id = users.id');
        $this->db->select('products.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('products.status', 0);
        $this->db->where('users.id', $user_id);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get user pending products count
    public function get_user_pending_products_count($user_id)
    {
        $this->db->join('users', 'products.user_id = users.id');
        $this->db->select('products.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('products.status', 0);
        $this->db->where('users.id', $user_id);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get user hidden products count
    public function get_user_hidden_products_count($user_id)
    {
        $this->db->join('users', 'products.user_id = users.id');
        $this->db->select('products.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('products.visibility', 0);
        $this->db->where('users.id', $user_id);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get paginated user hidden products
    public function get_paginated_user_hidden_products($user_id, $per_page, $offset)
    {
        $this->db->join('users', 'products.user_id = users.id');
        $this->db->select('products.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('products.visibility', 0);
        $this->db->where('users.id', $user_id);
        $this->db->where('products.is_completed', 1);
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get user favorited products
    public function get_user_favorited_products($user_id)
    {
        $this->build_query();
        $this->db->join('favorites', 'products.id = favorites.product_id');
        $this->db->select('products.*');
        $this->db->where('favorites.user_id', $user_id);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get user favorited products count
    public function get_user_favorited_products_count($user_id)
    {
        $this->build_query();
        $this->db->join('favorites', 'products.id = favorites.product_id');
        $this->db->select('products.*');
        $this->db->where('favorites.user_id', $user_id);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->num_rows();
    }

    //get product by id
    public function get_product_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('products');
        return $query->row();
    }

    //get product by slug
    public function get_product_by_slug($slug)
    {
        $this->db->join('users', 'products.user_id = users.id');
        $this->db->select('products.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('users.banned', 0);
        $this->db->where('products.is_completed', 1);
        $this->db->where('products.slug', $slug);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->row();
    }

    //is product favorited
    public function is_product_in_favorites($user_id, $product_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('favorites');
        if (!empty($query->row())) {
            return true;
        }
        return false;
    }

    //get product favorited count
    public function get_product_favorited_count($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('favorites');
        return $query->num_rows();
    }

    //add remove favorites
    public function add_remove_favorites($user_id, $product_id)
    {
        if ($this->is_product_in_favorites($user_id, $product_id)) {
            $this->db->where('user_id', $user_id);
            $this->db->where('product_id', $product_id);
            $this->db->delete('favorites');
        } else {
            $data = array(
                'user_id' => $user_id,
                'product_id' => $product_id
            );
            $this->db->insert('favorites', $data);
        }
    }

    //set product as completed
    public function set_product_completed($product_id)
    {
        $product = $this->get_product_by_id($product_id);
        if (!empty($product)) {
            $data = array(
                'is_completed' => 1
            );
            $this->db->where('id', $product_id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    //add to promoted products
    public function add_to_promoted_products($product_id, $plan_type, $day_count)
    {
        $product = $this->get_product_by_id($product_id);
        if (!empty($product)) {
            //set dates
            $date = date('Y-m-d H:i:s');
            $end_date = date('Y-m-d H:i:s', strtotime($date . ' + ' . $day_count . ' days'));
            $data = array(
                'promote_plan' => $plan_type,
                'promote_day' => $day_count,
                'is_promoted' => 1,
                'promote_start_date' => $date,
                'promote_end_date' => $end_date,
                'is_completed' => 1
            );
            $this->db->where('id', $product_id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    //increase product hit
    public function increase_product_hit($product)
    {
        if (!empty($product)):
            if (!isset($_COOKIE['modesy_product_' . $product->id])) :
                //increase hit
                setcookie("modesy_product_" . $product->id, '1', time() + (86400 * 300), "/");
                $data = array(
                    'hit' => $product->hit + 1
                );

                $this->db->where('id', $product->id);
                $this->db->update('products', $data);

            endif;
        endif;
    }

    public function search_brand($title){
      $this->db->like('brand',$title,'both');
      $this->db->group_by('brand');
      $this->db->order_by('brand','ASC');
      $this->db->limit(10);
      $res = $this->db->get('products');
      return $res->result();
    }

    public function search_model($brand,$model){
      $this->db->where('brand',$brand);
      $this->db->like('model',$model,'both');
      $this->db->group_by('model');
      $this->db->order_by('model','ASC');
      $this->db->limit(10);
      $res = $this->db->get('products');
      return $res->result();
   }

   public function swapped($product_id = NULL,$swapped = NULL){
     $this->db->where('id', $product_id);
     return $this->db->update('products', array('swapped' => $swapped));
   }

}