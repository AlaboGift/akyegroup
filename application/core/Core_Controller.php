<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Core_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //general settings
        $global_data["modesy_default_location"] = 160;
        $global_data['general_settings'] = $this->settings_model->get_general_settings();
        $this->general_settings = $global_data['general_settings'];

        //set timezone
        date_default_timezone_set($this->general_settings->timezone);

        //languages
        $global_data['languages'] = $this->language_model->get_languages();
        $this->languages = $global_data['languages'];

        //site lang
        $global_data['site_lang'] = $this->language_model->get_language($this->general_settings->site_lang);
        if (empty($global_data['site_lang'])) {
            $global_data['site_lang'] = $this->language_model->get_language('1');
        }
        $global_data['selected_lang'] = $global_data['site_lang'];
        $this->selected_lang = $global_data['site_lang'];

        //settings
        $global_data['settings'] = $this->settings_model->get_settings($this->selected_lang->id);
        $this->settings = $global_data['settings'];

        $global_data['rtl'] = false;
        if ($global_data['site_lang']->text_direction == "rtl") {
            $global_data['rtl'] = true;
        }
        $this->rtl = $global_data['rtl'];

        //set language
        $this->config->set_item('language', $this->selected_lang->folder_name);
        $this->lang->load("site_lang", $this->selected_lang->folder_name);

        //check promoted posts
        $this->product_model->check_promoted_products();

        $global_data['img_bg_product_small'] = base_url() . "assets/img/img_bg_product_small.jpg";
        $global_data['img_bg_blog_small'] = base_url() . "assets/img/img_bg_blog_small.jpg";
        $global_data['app_name'] = $this->general_settings->application_name;
        $this->app_name = $global_data['app_name'];

        //promoted products enabled or disabled
        $global_data['promoted_products_enabled'] = $this->general_settings->promoted_products;
        $this->promoted_products_enabled = $global_data['promoted_products_enabled'];

        //max file size
        $this->img_uplaod_max_file_size = 5242880;

        //update last seen time
        $this->auth_model->update_last_seen();

        $this->load->vars($global_data);
    }

}

class Home_Core_Controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();

        //set selected lang
        $session_lang_id = $this->session->userdata("modesy_selected_lang");
        if (!empty($session_lang_id)) {
            $lang = $this->language_model->get_language($session_lang_id);
            if (!empty($lang)) {
                $global_data['selected_lang'] = $lang;
                $this->selected_lang = $lang;
            }
            if (!file_exists(APPPATH . "language/" . $this->selected_lang->folder_name)) {
                echo "Language folder doesn't exists!";
                exit();
            }
            //settings
            $global_data['settings'] = $this->settings_model->get_settings($this->selected_lang->id);
            $this->settings = $global_data['settings'];
            //set language
            $this->config->set_item('language', $this->selected_lang->folder_name);
            $this->lang->load("site_lang", $this->selected_lang->folder_name);
        }


        $global_data['parent_categories'] = $this->category_model->get_parent_categories();
        $global_data['footer_quick_links'] = $this->page_model->get_quick_links();
        $global_data['footer_information_links'] = $this->page_model->get_information_links();
        $global_data["countries"] = $this->location_model->get_countries();

        //recaptcha status
        $global_data['recaptcha_status'] = true;
        if (empty($this->general_settings->recaptcha_site_key) || empty($this->general_settings->recaptcha_secret_key)) {
            $global_data['recaptcha_status'] = false;
        }
        $this->recaptcha_status = $global_data['recaptcha_status'];

        if (auth_check()) {
            $global_data['unread_message_count'] = get_unread_conversations_count(user()->id);
        } else {
            $global_data['unread_message_count'] = 0;
        }

        //default location
        $global_data['default_location'] = "";
        if (isset($_SESSION["modesy_default_location"])) {
            $location_country = $this->location_model->get_country($_SESSION["modesy_default_location"]);
            if (!empty($location_country)) {
                $global_data['default_location'] = $location_country->name;
            }
        } else {
            $global_data['default_location'] = trans("all");
        }

        //only one location
        if ($this->general_settings->default_product_location != 0) {
            $location_country = $this->location_model->get_country($this->general_settings->default_product_location);
            if (!empty($location_country)) {
                $global_data['default_location'] = $location_country->name;
            }
        }


        $this->load->vars($global_data);
    }

    //verify recaptcha
    public function recaptcha_verify_request()
    {
        if (!$this->recaptcha_status) {
            return true;
        }

        $this->load->library('recaptcha');
        $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) && $response['success'] === true) {
                return true;
            }
        }
        return false;
    }

    public function paginate($url, $total_rows, $per_page)
    {
        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }

        $config['num_links'] = 4;
        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);

        return array('per_page' => $per_page, 'offset' => $page * $per_page);
    }
}

class Admin_Core_Controller extends Core_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function paginate($url, $total_rows)
    {
        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        $per_page = $this->input->get('show', true);
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }

        if (empty($per_page)) {
            $per_page = 15;
        }
        $config['num_links'] = 4;
        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);

        return array('per_page' => $per_page, 'offset' => $page * $per_page);
    }
}

