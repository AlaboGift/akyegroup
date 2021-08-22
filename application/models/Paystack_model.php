<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paystack_model extends CI_Model
{   
public function input_values()
    {
        $data = array(
            'agent_id' => $this->input->post('agent_id', true),
            'service_id' => $this->input->post('service_id', true),
            'amount' => $this->input->post('amount',true)
        );
        return $data;
    }

public function payment(){
   $data = $this->paystack_model->input_values();
   return $this->db->insert('service_payments', $data);
}   
}