<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    //update settings
    public function update_settings()
    {
        $data = array(
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'google_url' => $this->input->post('google_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'youtube_url' => $this->input->post('youtube_url', true),
            'about_footer' => $this->input->post('about_footer', true),
            'contact_text' => $this->input->post('contact_text', false),
            'contact_address' => $this->input->post('contact_address', true),
            'contact_email' => $this->input->post('contact_email', true),
            'contact_phone' => $this->input->post('contact_phone', true),
            'copyright' => $this->input->post('copyright', true),
            'cookies_warning' => $this->input->post('cookies_warning', false),
            'cookies_warning_text' => $this->input->post('cookies_warning_text', false)
        );
        $lang_id = $this->input->post('lang_id', true);

        $this->db->where('lang_id', $lang_id);
        return $this->db->update('settings', $data);
    }

    //update general settings
    public function update_general_settings()
    {
        $data = array(
            'timezone' => $this->input->post('timezone', true),
            'application_name' => $this->input->post('application_name', true),
            'head_code' => $this->input->post('head_code', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update recaptcha settings
    public function update_recaptcha_settings()
    {
        $data = array(
            'recaptcha_site_key' => $this->input->post('recaptcha_site_key', true),
            'recaptcha_secret_key' => $this->input->post('recaptcha_secret_key', true),
            'recaptcha_lang' => $this->input->post('recaptcha_lang', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);

    }

    //update email settings
    public function update_email_settings()
    {
        $data = array(
            'mail_protocol' => $this->input->post('mail_protocol', true),
            'mail_title' => $this->input->post('mail_title', true),
            'mail_host' => $this->input->post('mail_host', true),
            'mail_port' => $this->input->post('mail_port', true),
            'mail_username' => $this->input->post('mail_username', true),
            'mail_password' => $this->input->post('mail_password', true),
            'mail_confirmation_register' => $this->input->post('mail_confirm', true),
            'mail_contact' => $this->input->post('mail_contact', true),
            'mail_contact_status' => $this->input->post('mail_contact_status', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update social login settings
    public function update_social_login_settings()
    {
        $data = array(
            'facebook_app_id' => $this->input->post('facebook_app_id', true),
            'facebook_app_secret' => $this->input->post('facebook_app_secret', true),
            'google_app_name' => $this->input->post('google_app_name', true),
            'google_client_id' => $this->input->post('google_client_id', true),
            'google_client_secret' => $this->input->post('google_client_secret', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update seo tools
    public function update_seo_tools()
    {
        $data_general = array(
            'google_analytics' => $this->input->post('google_analytics', true)
        );
        $this->db->where('id', 1);
        $this->db->update('general_settings', $data_general);

        $lang_id = $this->input->post('lang_id', true);
        $data = array(
            'site_title' => $this->input->post('site_title', true),
            'homepage_title' => $this->input->post('homepage_title', true),
            'site_description' => $this->input->post('site_description', true),
            'keywords' => $this->input->post('keywords', true)
        );
        $this->db->where('lang_id', $lang_id);
        return $this->db->update('settings', $data);
    }

    //update payment settings
    public function update_payment_settings()
    {
        $data = array(
            'currency' => $this->input->post('currency', true),
            'paypal_enabled' => $this->input->post('paypal_enabled', true),
            'stripe_enabled' => $this->input->post('stripe_enabled', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update paypal settings
    public function update_paypal_settings()
    {
        $data = array(
            'paypal_store_name' => $this->input->post('paypal_store_name', true),
            'paypal_client_id' => trim($this->input->post('paypal_client_id', true)),
            'paypal_client_secret' => trim($this->input->post('paypal_client_secret', true))
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update stripe settings
    public function update_stripe_settings()
    {
        $data = array(
            'stripe_store_name' => $this->input->post('stripe_store_name', true),
            'stripe_publishable_key' => trim($this->input->post('stripe_publishable_key', true)),
            'stripe_secret_key' => trim($this->input->post('stripe_secret_key', true))
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update pricing settings
    public function update_pricing_settings()
    {
        $data = array(
            'price_per_day' => $this->input->post('price_per_day', true),
            'price_per_month' => $this->input->post('price_per_month', true)
        );

        $data['price_per_day'] = number_format($data["price_per_day"], 2, '.', '') * 100;
        $data['price_per_month'] = number_format($data["price_per_month"], 2, '.', '') * 100;

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update preferences
    public function update_preferences()
    {
        $data = array(
            'promoted_products' => $this->input->post('promoted_products', true),
            'multilingual_system' => $this->input->post('multilingual_system', true),
            'product_reviews' => $this->input->post('product_reviews', true),
            'product_comments' => $this->input->post('product_comments', true),
            'blog_comments' => $this->input->post('blog_comments', true),
            'mail_confirmation_register' => $this->input->post('mail_confirmation_register', true),
            'index_slider' => $this->input->post('index_slider', true),
            'index_categories' => $this->input->post('index_categories', true),
            'index_promoted_products' => $this->input->post('index_promoted_products', true),
            'index_latest_products' => $this->input->post('index_latest_products', true),
            'index_blog_slider' => $this->input->post('index_blog_slider', true),
            'product_link_structure' => $this->input->post('product_link_structure', true),
            'index_promoted_products_count' => $this->input->post('index_promoted_products_count', true),
            'index_latest_products_count' => $this->input->post('index_latest_products_count', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update visual settings
    public function update_visual_settings()
    {
        $data = array(
            'site_color' => $this->input->post('site_color', true)
        );

        //get file
        $file = $_FILES['logo'];
        if (!empty($file['name'])) {
            //upload logo
            $data["logo"] = $this->upload_model->logo_upload($file);
        }

        //get file
        $file = $_FILES['favicon'];
        if (!empty($file['name'])) {
            //upload logo
            $data["favicon"] = $this->upload_model->favicon_upload($file);
        }

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update admin panel link
    public function update_admin_panel_link($link)
    {
        $link = str_slug($link);
        if (empty($link)) {
            $link = "admin";
        }
        $start = '<?php defined("BASEPATH") OR exit("No direct script access allowed");' . PHP_EOL;
        $keys = '$custom_slug_array["admin"] = "' . $link . '";';
        $end = '?>';

        $content = $start . $keys . $end;

        file_put_contents(FCPATH . "application/config/route_slugs.php", $content);
    }

    //get general settings
    public function get_general_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('general_settings');
        return $query->row();
    }

    //get settings
    public function get_settings($lang_id)
    {
        $this->db->where('lang_id', $lang_id);
        $query = $this->db->get('settings');
        return $query->row();
    }

}