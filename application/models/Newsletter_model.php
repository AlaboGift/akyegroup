<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter_model extends CI_Model
{

    //add to subscribers
    public function add_to_subscribers($email)
    {
        $data = array(
            'email' => $email
        );
        return $this->db->insert('subscribers', $data);
    }

    //delete from subscribers
    public function delete_from_subscribers($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('subscribers');
    }

    //get subscribers
    public function get_subscribers()
    {
        $query = $this->db->get('subscribers');
        return $query->result();
    }

    //get subscriber
    public function get_subscriber($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('subscribers');
        return $query->row();
    }

    //get subscriber by id
    public function get_subscriber_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('subscribers');
        return $query->row();
    }

}