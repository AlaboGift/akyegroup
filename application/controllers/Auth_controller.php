<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH . 'third_party/PHPMailer/src/Exception.php';
require APPPATH . 'third_party/PHPMailer/src/PHPMailer.php';
require APPPATH . 'third_party/PHPMailer/src/SMTP.php';

class Auth_controller extends Home_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Login Post
     */
    public function login_post()
    {
        //check auth
        if (auth_check()) {
            echo "success";
            exit();
        }
        //validate inputs
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[100]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|max_length[30]');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            $this->load->view('partials/_messages');
        } else {
            $result = $this->auth_model->login();
            if ($result == false) {
                $this->load->view('partials/_messages');
            } else {
                echo "success";
            }
            reset_flash_data();
        }
    }

    /**
     * Login with Facebook
     */
    public function login_with_facebook()
    {
        //check auth
        if (auth_check()) {
            redirect(base_url());
        }
        $this->auth_model->login_with_facebook();
    }

    /**
     * Login with Google
     */
    public function login_with_google()
    {
        //check auth
        if (auth_check()) {
            redirect(base_url());
        }
        $this->auth_model->login_with_google();
    }


    /**
     * Register
     */
    public function register()
    {
        //check if logged in
        if (auth_check()) {
            redirect(base_url());
        }

        $data['title'] = trans("register");
        $data['description'] = trans("register") . " - " . $this->app_name;
        $data['keywords'] = trans("register") . "," . $this->app_name;
        $data['states'] = $this->location_model->get_states_by_country(160);
        $this->load->view('partials/_header', $data);
        $this->load->view('auth/register');
        $this->load->view('partials/_footer');
    }


    /**
     * Register Post
     */
    public function register_post()
    {
        //check if logged in
        if (auth_check()) {
            redirect(base_url());
        }

        if ($this->recaptcha_status == true) {
            if (!$this->recaptcha_verify_request()) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_recaptcha"));
                redirect($this->agent->referrer());
                exit();
            }
        }

        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('phone_number', trans("phone_number"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('confirm_password', trans("password_confirm"), 'required|xss_clean|matches[password]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $email = $this->input->post('email', true);
            $username = $this->input->post('username', true);
            $phone_number = $this->input->post('phone_number',true);
            $country_id = $this->input->post('country_id',true);
            $role = $this->input->post('service_type',true);
            //is email unique
            if (!$this->auth_model->is_unique_email($email)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_email_unique_error"));
                redirect($this->agent->referrer());
            }
            //is username unique
            if (!$this->auth_model->is_unique_username($username)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
            }
            //is service = 0
            if ($role == 'none'){
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', 'Please select a valid Service');
                redirect($this->agent->referrer());
            }
            //register
            $user = $this->auth_model->register();
            if ($user) {
                //update slug
                $this->auth_model->update_slug($user->id);
                $this->auth_model->login_direct($user);
                if ($this->general_settings->mail_confirmation_register == 1) {
                    $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
                } else {
                    $this->session->set_flashdata('success', trans("msg_register_success"));
                }
                redirect(base_url() . "settings");
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Logout
     */
    public function logout()
    {
        $this->auth_model->logout();
        redirect($this->agent->referrer());
    }


    /**
     * Confirm Email
     */
    public function confirm()
    {
        if (isset($_SESSION["email_confirmed"])) {
            redirect(base_url());
        }

        $data['title'] = trans("confirm_your_email");
        $data['description'] = trans("confirm_your_email") . " - " . $this->app_name;
        $data['keywords'] = trans("confirm_your_email") . "," . $this->app_name;

        $email = trim($this->input->get("email", true));
        $token = trim($this->input->get("token", true));


        $data["user"] = $this->auth_model->get_user_by_email($email);

        if (empty($data["user"])) {
            $data["error"] = trans("msg_reset_password_error");
        } else {

            if ($data["user"]->email_status == 1) {
                redirect(base_url());
            }
            if ($data["user"]->token == $token) {
                $this->auth_model->verify_email($data["user"]);
                $data["success"] = trans("msg_confirmed");
                $_SESSION["email_confirmed"] = true;
            } else {
                $data["error"] = trans("msg_error");
            }
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/confirm_email', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Reset Password
     */
    public function reset_password()
    {
        //check if logged in
        if (auth_check()) {
            redirect(base_url());
        }

        $data['title'] = trans("reset_password");
        $data['description'] = trans("reset_password") . " - " . $this->app_name;
        $data['keywords'] = trans("reset_password") . "," . $this->app_name;

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/reset_password');
        $this->load->view('partials/_footer');
    }


    /**
     * Reset Password Post
     */
    public function reset_password_post()
    {
        //check auth
        if (auth_check()) {
            redirect(base_url());
        }

        $email = $this->input->post('email', true);

        //get user
        $user = $this->auth_model->get_user_by_email($email);

        //if user not exists
        if (empty($user)) {
            $this->session->set_flashdata('error', html_escape(trans("msg_reset_password_error")));
            redirect($this->agent->referrer());
        } else {
            $this->load->model("email_model");

            //generate new password
            $new_password = $this->auth_model->reset_password($email);
            $subject = trans("password_reset");
            $message = trans("email_reset_password") . " <strong>" . $new_password . "</strong>";
            
            //send email
            if ($this->email_model->send_email($email, null, $subject, $message)) {
                    $this->session->set_flashdata('success', trans("msg_reset_password_success"));
              }
            redirect($this->agent->referrer());
        }
    }
}