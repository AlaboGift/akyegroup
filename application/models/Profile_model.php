<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    //update profile
    public function update_profile($data, $user_id)
    {
        //upload image
        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            //delete old avatar
            delete_file_from_server(user()->avatar);
            $data["avatar"] = $this->upload_model->avatar_upload($file);
        }

        $_SESSION["modesy_user_old_email"] = user()->email;

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //update service profile
    public function update_service($data, $user_id)
    {
        $sel = array('doc','docx','pdf');
        //upload guarantor form
        $guarantor_form = $_FILES['guarantor_form'];
        if (!empty($guarantor_form['name'])) {
            //delete old avatar
        $docFileType=pathinfo($guarantor_form,PATHINFO_EXTENSION);
        $docFileType=strtolower($docFileType);
        //if(in_array($docFileType, $sel) == TRUE){
            delete_file_from_server(user()->guarantor_form);
            $data["guarantor_form"] = $this->upload_model->guarantor_form_upload($guarantor_form);
         //}
        }

        //upload avatar
        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            //delete old avatar
            delete_file_from_server(user()->avatar);
            $data["avatar"] = $this->upload_model->avatar_upload($file);
        }

        //upload referal form
        $referal_form = $_FILES['referal_form'];
        if (!empty($referal_form['name'])) {
            //delete old avatar
        $FileType=pathinfo($referal_form,PATHINFO_EXTENSION);
        $FileType=strtolower($FileType);
        //if(in_array($FileType, $sel) == TRUE){
            delete_file_from_server(user()->referal_form);
            $data["referal_form"] = $this->upload_model->referal_form_upload($referal_form);
         //}
        }

        $_SESSION["modesy_user_old_email"] = user()->email;
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }
    //check email updated
    public function check_email_updated($user_id)
    {
        if ($this->general_settings->mail_confirmation_register == 1) {
            $user = $this->auth_model->get_user($user_id);
            if (!empty($user)) {
                if (isset($_SESSION["modesy_user_old_email"]) && $_SESSION["modesy_user_old_email"] != $user->email) {
                    //send confirm email
                    $this->auth_model->send_activation_email($user->id);
                    $data = array(
                        'email_status' => 0
                    );

                    $this->db->where('id', $user->id);
                    return $this->db->update('users', $data);
                }
            }

            if (isset($_SESSION["modesy_user_old_email"])) {
                unset($_SESSION["modesy_user_old_email"]);
            }
        }

        return false;
    }

    //update contact informations
    public function update_contact_informations()
    {
        $user_id = user()->id;
        $data = array(
            'country_id' => $this->input->post('country_id', true),
            'state_id' => $this->input->post('state_id', true),
            'city_id' => $this->input->post('city_id', true),
            'address' => $this->input->post('address', true),
            'zip_code' => $this->input->post('zip_code', true),
            'phone_number' => $this->input->post('phone_number', true),
            'show_email' => $this->input->post('show_email', true),
            'show_phone' => $this->input->post('show_phone', true),
            'show_location' => $this->input->post('show_location', true)
        );

        if (empty($data['show_email'])) {
            $data['show_email'] = 0;
        }
        if (empty($data['show_phone'])) {
            $data['show_phone'] = 0;
        }
        if (empty($data['show_location'])) {
            $data['show_location'] = 0;
        }

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //update update social media
    public function update_social_media()
    {
        $user_id = user()->id;
        $data = array(
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'google_url' => $this->input->post('google_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'youtube_url' => $this->input->post('youtube_url', true)
        );

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->input->post('old_password', true),
            'password' => $this->input->post('password', true),
            'password_confirm' => $this->input->post('password_confirm', true)
        );
        return $data;
    }

    //change password
    public function change_password($old_password_exists)
    {
        $this->load->library('bcrypt');

        $user = user();
        if (!empty($user)) {
            $data = $this->change_password_input_values();
            if ($old_password_exists == 1) {
                //password does not match stored password.
                if (!$this->bcrypt->check_password($data['old_password'], $user->password)) {
                    $this->session->set_flashdata('error', trans("msg_wrong_old_password"));
                    $this->session->set_flashdata('form_data', $this->change_password_input_values());
                    redirect($this->agent->referrer());
                }
            }

            $data = array(
                'password' => $this->bcrypt->hash_password($data['password'])
            );

            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //follow user
    public function follow_unfollow_user()
    {
        $data = array(
            'following_id' => $this->input->post('following_id', true),
            'follower_id' => $this->input->post('follower_id', true)
        );

        $follow = $this->get_follow($data["following_id"], $data["follower_id"]);
        if (empty($follow)) {
            //add follower
            $this->db->insert('followers', $data);
        } else {
            $this->db->where('id', $follow->id);
            $this->db->delete('followers');
        }
    }

    //follow
    public function get_follow($following_id, $follower_id)
    {
        $this->db->where('following_id', $following_id);
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->row();
    }

    //is user follows
    public function is_user_follows($following_id, $follower_id)
    {
        $follow = $this->get_follow($following_id, $follower_id);
        if (empty($follow)) {
            return false;
        } else {
            return true;
        }
    }

    //get followers
    public function get_followers($following_id)
    {
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    //get followers count
    public function get_followers_count($following_id)
    {
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }

    //get following users
    public function get_following_users($follower_id)
    {
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    //get following users
    public function get_following_users_count($follower_id)
    {
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }

    //search members
    public function search_members($search)
    {
        $this->db->like('users.username', $search);
        $query = $this->db->get('users');
        return $query->result();
    }
    public function get_jobs($id){
        $this->db->where('provider_id',$id);
        $this->db->order_by('service_date','DESC');
        $this->db->order_by('service_start_time','DESC');
        $query = $this->db->get("request_service");
        return $query->result();

    }
    public function get_paginated_jobs($limit, $offset,$id){
        $this->db->limit($limit, $offset);
        $this->db->where('provider_id',$id);
        $this->db->order_by('service_date','DESC');
        $this->db->order_by('service_start_time','DESC');
        $query = $this->db->get("request_service");
        return $query->result();
    }


        public function accept_job($service_id){
       if(!empty($service_id)){
            $data = array("accepted" => 1);
            $this->db->where('service_id', $service_id);
            return $this->db->update('request_service', $data);
        }
        return false;
    }
    public function reject_job($service_id){
       if(!empty($service_id)){
            $data = array("accepted" => 0, 'provider_id' => 0);
            $this->db->where('service_id', $service_id);
            return $this->db->update('request_service', $data);
        }
        return false;
    }
}