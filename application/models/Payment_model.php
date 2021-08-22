<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model
{
    //add payment
    public function add_payment($data)
    {
        return $this->db->insert('payments', $data);
    }

    //get payments
    public function get_payments()
    {
        $query = $this->db->get('payments');
        return $query->result();
    }

    //get latest payments
    public function get_latest_payments($limit)
    {
        $this->db->limit($limit);
        $this->db->order_by('payments.id', 'DESC');
        $query = $this->db->get('payments');
        return $query->result();
    }

    //get payment
    public function get_payment($id)
    {
        $this->db->where('payments.id', $id);
        $query = $this->db->get('payments');
        return $query->row();
    }

}