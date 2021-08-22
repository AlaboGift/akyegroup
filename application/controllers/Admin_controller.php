<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin() AND user()->role !='super-admin') {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['title'] = trans("admin_panel");

        $data['product_count'] = $this->product_admin_model->get_products_count();
        $data['pending_product_count'] = $this->product_admin_model->get_pending_products_count();
        $data['blog_posts_count'] = $this->blog_model->get_all_posts_count();
        $data['members_count'] = $this->auth_model->get_members_count();
        $data['service_providers_count'] = $this->auth_model->get_service_providers_count();
        $data['latest_pending_products'] = $this->product_admin_model->get_latest_pending_products(10);
        $data['latest_products'] = $this->product_admin_model->get_latest_products(10);

        $this->load->model("payment_model");
        $data['latest_payments'] = $this->payment_model->get_latest_payments(10);

        $data['latest_reviews'] = $this->review_model->get_latest_reviews(10);
        $data['latest_comments'] = $this->comment_model->get_latest_comments(10);

        $data['latest_members'] = $this->auth_model->get_latest_members(6);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/index');
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Slider Items
    */
    public function slider_items()
    {
        $data['title'] = trans("slider_items");
        $data['slider_items'] = $this->slider_model->get_slider_items_all();
        $data['lang_search_column'] = 3;
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/slider/slider_items', $data);
        $this->load->view('admin/includes/_footer');
    }


    /*
    * Add Slider Item
    */
    public function add_slider_item()
    {
        $data['title'] = trans("add_slider_item");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/slider/add_item', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Slider Item Post
     */
    public function add_slider_item_post()
    {
        if ($this->slider_model->add_item()) {
            $this->session->set_flashdata('success', trans("msg_slider_added"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Update Slider Item
     */
    public function update_slider_item($id)
    {
        $data['title'] = trans("update_slider_item");

        //get item
        $data['item'] = $this->slider_model->get_slider_item($id);

        if (empty($data['item'])) {
            redirect($this->agent->referrer());
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/slider/update_item', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Slider Item Post
     */
    public function update_slider_item_post()
    {
        //item id
        $id = $this->input->post('id', true);
        if ($this->slider_model->update_item($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect(admin_url() . 'slider-items');
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /**
     * Delete Slider Item Post
     */
    public function delete_slider_item_post()
    {
        $id = $this->input->post('id', true);
        if ($this->slider_model->delete_slider_item($id)) {
            $this->session->set_flashdata('success', trans("msg_slider_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Newsletter
     */
    public function newsletter()
    {
        $data['title'] = trans("newsletter");

        $data['subscribers'] = $this->newsletter_model->get_subscribers();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Delete Subscriber Post
     */
    public function delete_subscriber_post()
    {
        $id = $this->input->post('id', true);

        $data['subscriber'] = $this->newsletter_model->get_subscriber_by_id($id);

        if (empty($data['subscriber'])) {
            redirect($this->agent->referrer());
        }

        if ($this->newsletter_model->delete_from_subscribers($id)) {
            $this->session->set_flashdata('success', trans("msg_subscriber_deleted"));
            $this->session->set_flashdata("mes_subscriber_delete", 1);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_subscriber_delete", 1);
        }
    }


    /**
     * Newsletter Send Email Post
     */
    public function newsletter_send_email_post()
    {
        $this->load->model("email_model");

        $subject = $this->input->post('subject', true);
        $message = $this->input->post('message', false);

        $data['subscribers'] = $this->newsletter_model->get_subscribers();

        foreach ($data['subscribers'] as $item) {
            //send email
            if (!$this->email_model->send_email($item->email, null, $subject, $message)) {
                redirect($this->agent->referrer());
                exit();
            }
        }

        $this->session->set_flashdata('success', trans("msg_email_sent"));
        redirect($this->agent->referrer());
    }

    /**
     * Contact Messages
     */
    public function contact_messages()
    {
        $data['title'] = trans("contact_messages");

        $data['messages'] = $this->contact_model->get_contact_messages();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/contact_messages', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Delete Contact Message Post
     */
    public function delete_contact_message_post()
    {
        $id = $this->input->post('id', true);

        if ($this->contact_model->delete_contact_message($id)) {
            $this->session->set_flashdata('success', trans("msg_message_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Ads
     */
    public function ad_spaces()
    {
        $data['title'] = trans("ad_spaces");

        $data['ad_space'] = $this->input->get('ad_space', true);

        if (empty($data['ad_space'])) {
            redirect(admin_url() . "ad-spaces?ad_space=index_1");
        }

        $data['ad_codes'] = $this->ad_model->get_ad_codes($data['ad_space']);
        if (empty($data['ad_codes'])) {
            redirect(admin_url() . "ad-spaces");
        }

        $data["array_ad_spaces"] = array(
            "index_1" => trans("index_ad_space_1"),
            "index_2" => trans("index_ad_space_2"),
            "products" => trans("products_ad_space"),
            "products_sidebar" => trans("products_sidebar_ad_space"),
            "product" => trans("product_ad_space"),
            "product_sidebar" => trans("product_sidebar_ad_space"),
            "blog_1" => trans("blog_ad_space_1"),
            "blog_2" => trans("blog_ad_space_2"),
            "blog_post_details" => trans("blog_post_details_ad_space"),
            "blog_post_details_sidebar" => trans("blog_post_details_sidebar_ad_space"),
            "profile" => trans("profile_ad_space"),
            "profile_sidebar" => trans("profile_sidebar_ad_space"),
        );

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/ad_spaces', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Ads Post
     */
    public function ad_spaces_post()
    {
        $ad_space = $this->input->post('ad_space', true);

        if ($this->ad_model->update_ad_spaces($ad_space)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    /*
    * Seo Tools
    */
    public function seo_tools()
    {
        $data['title'] = trans("seo_tools");

        $data["current_lang_id"] = $this->input->get("lang", true);

        if (empty($data["current_lang_id"])) {
            $data["current_lang_id"] = $this->general_settings->site_lang;
            redirect(admin_url() . "seo-tools?lang=" . $data["current_lang_id"]);
        }

        $data['settings'] = $this->settings_model->get_settings($data["current_lang_id"]);
        $data['languages'] = $this->language_model->get_languages();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/seo_tools', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Seo Tools Post
     */
    public function seo_tools_post()
    {
        if ($this->settings_model->update_seo_tools()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
    * Email Settings
    */
    public function email_settings()
    {
        $data['title'] = trans("email_settings");

        $data['general_settings'] = $this->settings_model->get_general_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/email_settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Email Settings Post
     */
    public function email_settings_post()
    {
        if ($this->settings_model->update_email_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('submit', $this->input->post('submit', true));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('submit', $this->input->post('submit', true));
            redirect($this->agent->referrer());
        }
    }

    /*
    * Visual Settings
    */
    public function visual_settings()
    {
        $data['title'] = trans("visual_settings");

        $data['visual_settings'] = $this->settings_model->get_general_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/visual_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Visual Settings Post
     */
    public function visual_settings_post()
    {
        if ($this->settings_model->update_visual_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
    * Social Login Settings
    */
    public function social_login_settings()
    {
        $data['title'] = trans("social_login_configuration");

        $data['general_settings'] = $this->settings_model->get_general_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/social_login', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Social Login Settings Post
     */
    public function social_login_settings_post()
    {
        if ($this->settings_model->update_social_login_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Members
     */
    public function members()
    {
        $data['title'] = trans("members");

        $data['users'] = $this->auth_model->get_members();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/members');
        $this->load->view('admin/includes/_footer');

    }

    /**
     * service providers
     */
    public function service()
    {
        $data['title'] = 'Service Providers';

        $data['users'] = $this->auth_model->get_service();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/service');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Administrators
     */
    public function administrators()
    {
        $data['title'] = trans("administrators");

        $data['users'] = $this->auth_model->get_administrators();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/administrators');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Administrator
     */
    public function add_administrator()
    {
        $data['title'] = trans("add_administrator");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/add_administrator');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Administrator
     */
    public function add_administrator_post()
    {
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[50]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $email = $this->input->post('email', true);
            $username = $this->input->post('username', true);
            //is username unique
            if (!$this->auth_model->is_unique_username($username)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
            }
            //is email unique
            if (!$this->auth_model->is_unique_email($email)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_email_unique_error"));
                redirect($this->agent->referrer());
            }

            //add user
            if ($this->auth_model->add_administrator()) {
                $this->session->set_flashdata('success', trans("msg_administrator_added"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }

            redirect($this->agent->referrer());
        }
    }


    /**
     * Ban or Remove User Ban
     */
    public function ban_remove_ban_user()
    {
        $id = $this->input->post('id', true);
        if ($this->auth_model->ban_remove_ban_user($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Delete User
     */
    public function delete_user_post()
    {
        $id = $this->input->post('id', true);
        if ($this->auth_model->delete_user($id)) {
            $this->session->set_flashdata('success', trans("msg_user_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }
    /**
    *verified user
    */

        public function make_verified()
    {
        $id = $this->input->post('id', true);
        if ($this->auth_model->make_verified($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /*
    * Payments
    */
    public function payments()
    {
        $data['title'] = trans("payments");
        $this->load->model("payment_model");
        $data['payments'] = $this->payment_model->get_payments();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/payment/payments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Payment Details
    */
    public function payment_details($id)
    {
        $data['title'] = trans("payment_details");
        $this->load->model("payment_model");
        $data['payment'] = $this->payment_model->get_payment($id);

        if (empty($data['payment'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/payment/details', $data);
        $this->load->view('admin/includes/_footer');
    }


    /*
    * Payment Settings
    */
    public function payment_settings()
    {
        $data['title'] = trans("payment_settings");
        $data['general_settings'] = $this->settings_model->get_general_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/payment_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Payment Settings Post
     */
    public function payment_settings_post()
    {
        if ($this->settings_model->update_payment_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_pay", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_paypal", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Paypal Settings Post
     */
    public function paypal_settings_post()
    {
        if ($this->settings_model->update_paypal_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_paypal", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_paypal", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Stripe Settings Post
     */
    public function stripe_settings_post()
    {
        if ($this->settings_model->update_stripe_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_stripe", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_stripe", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Pricing Settings Post
     */
    public function pricing_settings_post()
    {
        if ($this->settings_model->update_pricing_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_pricing", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_pricing", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Preferences
     */
    public function preferences()
    {
        $data['title'] = trans("preferences");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/preferences', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Preferences Post
     */
    public function preferences_post()
    {
        if ($this->settings_model->update_preferences()) {
            $admin_panel_link = $this->input->post('admin_panel_link', true);
            $this->settings_model->update_admin_panel_link($admin_panel_link);
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect(admin_url() . "preferences");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
     * Settings
     */
    public function settings()
    {
        $data['title'] = trans("settings");

        $data["settings_lang"] = $this->input->get("lang", true);

        if (empty($data["settings_lang"])) {
            $data["settings_lang"] = $this->selected_lang->id;
            redirect(admin_url() . "settings?lang=" . $data["settings_lang"]);
        }

        $data['settings'] = $this->settings_model->get_settings($data["settings_lang"]);
        $data['general_settings'] = $this->settings_model->get_general_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Settings Post
     */
    public function settings_post()
    {
        if ($this->settings_model->update_settings()) {
            $this->settings_model->update_general_settings();
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_settings", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_settings", 1);
            redirect($this->agent->referrer());
        }
    }


    /**
     * Recaptcha Settings Post
     */
    public function recaptcha_settings_post()
    {
        if ($this->settings_model->update_recaptcha_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * LOCATION
    *-------------------------------------------------------------------------------------------------
    */


    /**
     * Location Settings
     */
    public function location_settings()
    {
        $data['title'] = trans("location_settings");
        $data['countries'] = $this->location_model->get_countries();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/location_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Location Settings Post
     */
    public function location_settings_post()
    {
        if ($this->location_model->set_default_product_country()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /**
     * Countries
     */
    public function countries()
    {
        $data['title'] = trans("countries");

        //get paginated products
        $pagination = $this->paginate(admin_url() . 'countries', $this->location_model->get_paginated_countries_count());
        $data['countries'] = $this->location_model->get_paginated_countries($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/countries', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Country
     */
    public function add_country()
    {
        $data['title'] = trans("add_country");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/add_country', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Country Post
     */
    public function add_country_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->location_model->add_country()) {
                $this->session->set_flashdata('success', trans("msg_country_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update Country
     */
    public function update_country($id)
    {
        $data['title'] = trans("update_country");

        //get country
        $data['country'] = $this->location_model->get_country($id);
        if (empty($data['country'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/update_country', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Country Post
     */
    public function update_country_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            //country id
            $id = $this->input->post('id', true);
            if ($this->location_model->update_country($id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect(admin_url() . 'countries');
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Delete Country Post
     */
    public function delete_country_post()
    {
        $id = $this->input->post('id', true);
        if ($this->location_model->delete_country($id)) {
            $this->session->set_flashdata('success', trans("msg_country_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * States
     */
    public function states()
    {
        $data['title'] = trans("states");
        $data['countries'] = $this->location_model->get_countries();


        //get paginated products
        $pagination = $this->paginate(admin_url() . 'states', $this->location_model->get_paginated_states_count());
        $data['states'] = $this->location_model->get_paginated_states($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/states', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add State
     */
    public function add_state()
    {
        $data['title'] = trans("add_state");
        $data['countries'] = $this->location_model->get_countries();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/add_state', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add State Post
     */
    public function add_state_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->location_model->add_state()) {
                $this->session->set_flashdata('success', trans("msg_state_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update State
     */
    public function update_state($id)
    {
        $data['title'] = trans("update_state");

        //get state
        $data['state'] = $this->location_model->get_state($id);
        if (empty($data['state'])) {
            redirect($this->agent->referrer());
        }
        $data['countries'] = $this->location_model->get_countries();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/update_state', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update State Post
     */
    public function update_state_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            //country id
            $id = $this->input->post('id', true);
            if ($this->location_model->update_state($id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                $redirect_url = $this->input->post('redirect_url', true);
                if (!empty($redirect_url)) {
                    redirect($redirect_url);
                } else {
                    redirect(admin_url() . 'states');
                }
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete State Post
     */
    public function delete_state_post()
    {
        $id = $this->input->post('id', true);
        if ($this->location_model->delete_state($id)) {
            $this->session->set_flashdata('success', trans("msg_state_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

}
