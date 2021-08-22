<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'username' => $this->input->post('username', true),
            'email' => $this->input->post('email', true),
            'password' => $this->input->post('password', true),
            'phone_number' => $this->input->post('phone_number',true),
            'country_id' => $this->input->post('country_id',true),
            'state_id' => $this->input->post('state_id',true),
            'city_id' => $this->input->post('city_id',true),
            'role' => $this->input->post('service_type',true)
        );
        return $data;
    }

    //login
    public function login()
    {
        $this->load->library('bcrypt');

        $data = $this->input_values();
        $user = $this->get_user_by_email($data['email']);

        if (!empty($user)) {
            //check password
            if (!$this->bcrypt->check_password($data['password'], $user->password)) {
                $this->session->set_flashdata('error', trans("login_error"));
                return false;
            }
            if ($user->banned == 1) {
                $this->session->set_flashdata('error', trans("msg_ban_error"));
                return false;
            }
            //set user data
            $user_data = array(
                'modesy_sess_user_id' => $user->id,
                'modesy_sess_user_email' => $user->email,
                'modesy_sess_user_role' => $user->role,
                'modesy_sess_logged_in' => true,
                'modesy_sess_app_key' => $this->config->item('app_key'),
            );
            $this->session->set_userdata($user_data);
            return true;
        } else {
            $this->session->set_flashdata('error', trans("login_error"));
            return false;
        }
    }

    //login direct
    public function login_direct($user)
    {
        //set user data
        $user_data = array(
            'modesy_sess_user_id' => $user->id,
            'modesy_sess_user_email' => $user->email,
            'modesy_sess_user_role' => $user->role,
            'modesy_sess_logged_in' => true,
            'modesy_sess_app_key' => $this->config->item('app_key'),
        );

        $this->session->set_userdata($user_data);
    }

    //login with facebook
    public function login_with_facebook()
    {
        $id = $this->input->post('id', true);
        $email = $this->input->post('email', true);
        $first_name = $this->input->post('first_name', true);
        $last_name = $this->input->post('last_name', true);

        $user = $this->get_user_by_email($email);

        //check if user registered
        if (empty($user)) {
            $username = $this->generate_uniqe_username($first_name . " " . $last_name);
            $slug = $this->generate_uniqe_slug($username);
            //add user to database
            $data = array(
                'facebook_id' => $id,
                'email' => $email,
                'email_status' => 1,
                'token' => md5(uniqid()),
                'username' => $username,
                'slug' => $slug,
                'avatar' => "https://graph.facebook.com/" . $id . "/picture?type=large",
                'user_type' => "facebook",
            );
            if (!empty($data['email'])) {
                $this->db->insert('users', $data);
                $user = $this->get_user_by_email($email);
                $this->login_direct($user);
            }
        } else {
            //login
            $this->login_direct($user);
        }
    }

    //generate uniqe username
    public function generate_uniqe_username($username)
    {
        $new_username = $username;
        if (!empty($this->get_user_by_username($new_username))) {
            $new_username = $username . " 1";
            if (!empty($this->get_user_by_username($new_username))) {
                $new_username = $username . " 2";
                if (!empty($this->get_user_by_username($new_username))) {
                    $new_username = $username . " 3";
                    if (!empty($this->get_user_by_username($new_username))) {
                        $new_username = $username . "-" . uniqid();
                    }
                }
            }
        }
        return $new_username;
    }

    //generate uniqe slug
    public function generate_uniqe_slug($username)
    {
        $slug = str_slug($username);
        if (!empty($this->get_user_by_slug($slug))) {
            $slug = str_slug($username . "-1");
            if (!empty($this->get_user_by_slug($slug))) {
                $slug = str_slug($username . "-2");
                if (!empty($this->get_user_by_slug($slug))) {
                    $slug = str_slug($username . "-3");
                    if (!empty($this->get_user_by_slug($slug))) {
                        $slug = str_slug($username . "-" . uniqid());
                    }
                }
            }
        }
        return $slug;
    }

    //login with google
    public function login_with_google()
    {
        $id = $this->input->post('id', true);
        $email = $this->input->post('email', true);
        $name = $this->input->post('name', true);
        $avatar = $this->input->post('avatar', true);

        $user = $this->get_user_by_email($email);

        //check if user registered
        if (empty($user)) {

            $username = $this->generate_uniqe_username($name);
            $slug = $this->generate_uniqe_slug($name);

            //add user to database
            $data = array(
                'google_id' => $id,
                'email' => $email,
                'email_status' => 1,
                'token' => md5(uniqid()),
                'username' => $username,
                'slug' => $slug,
                'avatar' => $avatar,
                'user_type' => "google",
            );

            if (!empty($data['email'])) {
                $this->db->insert('users', $data);
                $user = $this->get_user_by_email($email);
                $this->login_direct($user);
            }

        } else {
            //login
            $this->login_direct($user);
        }
    }

    //register
    public function register()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['banned'] = 0;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['token'] = md5(uniqid());

        if ($this->db->insert('users', $data)) {
            $last_id = $this->db->insert_id();
            if ($this->general_settings->mail_confirmation_register == 1) {
                $data['email_status'] = 0;
                $this->send_activation_email($last_id);
            } else {
                $data['email_status'] = 1;
            }
            return $this->get_user($last_id);
        } else {
            return false;
        }
    }

    //add administrator
    public function add_administrator()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['role'] = "admin";
        $data['banned'] = 0;
        $data['email_status'] = 1;
        $data['token'] = md5(uniqid());
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('users', $data);
    }

    //update slug
    public function update_slug($id)
    {
        $user = $this->get_user($id);

        if (empty($user->slug) || $user->slug == "-") {
            $data = array(
                'slug' => "user-" . $user->id,
            );
            $this->db->where('id', $id);
            $this->db->update('users', $data);

        } else {
            if ($this->check_is_slug_unique($user->slug, $id) == true) {
                $data = array(
                    'slug' => $user->slug . "-" . $user->id
                );

                $this->db->where('id', $id);
                $this->db->update('users', $data);
            }
        }
    }

    //logout
    public function logout()
    {
        //unset user data
        $this->session->unset_userdata('modesy_sess_user_id');
        $this->session->unset_userdata('modesy_sess_user_email');
        $this->session->unset_userdata('modesy_sess_user_role');
        $this->session->unset_userdata('modesy_sess_logged_in');
        $this->session->unset_userdata('modesy_sess_app_key');
        $this->session->sess_destroy();
    }

    public function send_activation_email($user_id)
    {
        $user = $this->get_user($user_id);
        if (!empty($user)) {
            $subject = trans("confirm_your_email");
            $message = '
<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Akyegroup Confirmation Mail</title>
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
<span class="preheader"></span>
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
<center><img src="https://akyegroup.com/uploads/logo/logo_5eb1c29277ca2.png" style="height:60px;" alt="Akyegroup logo" /></center>
<h2>You are almost done..</h2>
<p>Hi, '.ucwords($user->username).'</p>
<p>Please complete your registration with akyegroup.com by confirming your email address, click the link below.</p><br>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
<tbody>
<tr>
<td align="left">
<table role="presentation" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td><a href="'.base_url().'confirm?email='.$user->email.'&token='.$user->token.'">Confirm Email</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
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
</html>';

//send email
$this->load->model("email_model");
if ($this->email_model->send_email($user->email, null, $subject, $message)) {
if (isset($_SESSION["email_confirmed"])) {
unset($_SESSION["email_confirmed"]);
}
return true;
} else {
return false;
}
}
}

    //reset password
    public function reset_password($email)
    {
        $this->load->library('bcrypt');

        //generate new password
        $new_password = bin2hex(openssl_random_pseudo_bytes(3));

        $data = array(
            'password' => $this->bcrypt->hash_password($new_password)
        );

        //change password
        $this->db->where('email', $email);
        $this->db->update('users', $data);
        return $new_password;
    }

    //delete user
    public function delete_user($id)
    {
        $user = $this->get_user($id);
        if (!empty($user)) {
            $this->db->where('id', $id);
            return $this->db->delete('users');
        }
        return false;
    }

    //update last seen time
    public function update_last_seen()
    {
        if ($this->is_logged_in()) {
            $user = user();
            //update last seen
            $data = array(
                'last_seen' => date("Y-m-d H:i:s"),
            );
            $this->db->where('id', $user->id);
            $this->db->update('users', $data);
        }
    }

    //is logged in
    public function is_logged_in()
    {
        //check if user logged in
        if ($this->session->userdata('modesy_sess_logged_in') == true && $this->session->userdata('modesy_sess_app_key') == $this->config->item('app_key')) {
            $user = $this->get_user($this->session->userdata('modesy_sess_user_id'));
            if (!empty($user)) {
                if ($user->banned == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    //function get user
    public function get_logged_user()
    {
        if ($this->is_logged_in()) {
            $user_id = $this->session->userdata('modesy_sess_user_id');
            $this->db->where('id', $user_id);
            $query = $this->db->get('users');
            return $query->row();
        }
    }

    //is admin
    public function is_admin()
    {
        //check logged in
        if ($this->is_logged_in()) {
            $user = $this->get_logged_user();
            if ($user->role == 'admin') {
                return true;
            }
        }
        return false;
    }

        //is admin
    public function is_service()
    {
        //check logged in
        if ($this->is_logged_in()) {
            $user = $this->get_logged_user();
            if ($user->role == 'service') {
                return true;
            }
        }
        return false;
    }

    //get user by id
    public function get_user($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by email
    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by username
    public function get_user_by_username($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by slug
    public function get_user_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get users
    public function get_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    //get users count
    public function get_users_count()
    {
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    //get members
    public function get_members()
    {
        $this->db->where('role', "member");
        $query = $this->db->get('users');
        return $query->result();
    }

        //get service providers
    public function get_service()
    {
        $this->db->where('role', "service");
        $query = $this->db->get('users');
        return $query->result();
    }

    //get latest members
    public function get_latest_members($limit)
    {
        $this->db->limit($limit);
        $this->db->order_by('users.id', 'DESC');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get members count
    public function get_members_count()
    {
        $this->db->where('role', "member");
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    //get service providers count
    public function get_service_request_count()
    {   
        $this->db->where('paid',0);
        $query = $this->db->get('request_service');
        return $query->num_rows();
    }
    //get service providers count
    public function get_service_providers_count()
    {
        $this->db->where('role', "service");
        $query = $this->db->get('users');
        return $query->num_rows();
    }
    //get administrators
    public function get_administrators()
    {
        $this->db->where('role', "admin");
        $query = $this->db->get('users');
        return $query->result();
    }

    //get last users
    public function get_last_users()
    {
        $this->db->order_by('users.id', 'DESC');
        $this->db->limit(7);
        $query = $this->db->get('users');
        return $query->result();
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {
        $this->db->where('users.slug', $slug);
        $this->db->where('users.id !=', $id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //check if email is unique
    public function is_unique_email($email, $user_id = 0)
    {
        $user = $this->auth_model->get_user_by_email($email);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }

    //check if username is unique
    public function is_unique_username($username, $user_id = 0)
    {
        $user = $this->get_user_by_username($username);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //username taken
                return false;
            } else {
                return true;
            }
        }
    }

    //verify email
    public function verify_email($user)
    {
        if (!empty($user)) {
            $data = array();
            $data['email_status'] = 1;
            $data['token'] = md5(uniqid());
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }

        return false;
    }

    //ban or remove user ban
    public function ban_remove_ban_user($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {
            $data = array();
            if ($user->banned == 0) {
                $data['banned'] = 1;
            }
            if ($user->banned == 1) {
                $data['banned'] = 0;
            }

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }

        return false;
    }
   
    //make verified
    public function make_verified($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {
            $data = array();
            if ($user->verified == 'No') {
                $data['verified'] = 'Yes';
            }
            if ($user->verified == 'Yes') {
                $data['verified'] = 'No';
            }

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }

        return false;
    }

}