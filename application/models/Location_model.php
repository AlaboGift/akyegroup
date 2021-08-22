<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_model extends CI_Model
{
    //add country
    public function add_country()
    {
        $data = array(
            'name' => $this->input->post('name', true)
        );

        return $this->db->insert('countries', $data);
    }

    //update country
    public function update_country($id)
    {
        $data = array(
            'name' => $this->input->post('name', true)
        );

        $this->db->where('id', $id);
        return $this->db->update('countries', $data);
    }

    //add state
    public function add_state()
    {
        $data = array(
            'name' => $this->input->post('name', true),
            'country_id' => $this->input->post('country_id', true)
        );

        return $this->db->insert('states', $data);
    }

    //update state
    public function update_state($id)
    {
        $data = array(
            'name' => $this->input->post('name', true),
            'country_id' => $this->input->post('country_id', true)
        );

        $this->db->where('id', $id);
        return $this->db->update('states', $data);
    }


    //get countries
    public function get_countries()
    {
        $this->db->order_by('countries.id');
        $query = $this->db->get('countries');
        return $query->result();
    }

    //get paginated countries
    public function get_paginated_countries($per_page, $offset)
    {
        $q = trim($this->input->get('q', true));
        if (!empty($q)) {
            $this->db->like('countries.name', $q);
        }
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('countries');
        return $query->result();
    }

    //get paginated countries count
    public function get_paginated_countries_count()
    {
        $q = trim($this->input->get('q', true));
        if (!empty($q)) {
            $this->db->like('countries.name', $q);
        }
        $query = $this->db->get('countries');
        return $query->num_rows();
    }

    //get country
    public function get_country($id)
    {
        $this->db->where('countries.id', $id);
        $query = $this->db->get('countries');
        return $query->row();
    }

    //delete country
    public function delete_country($id)
    {
        $country = $this->get_country($id);
        if (!empty($country)) {
            $this->db->where('id', $id);
            return $this->db->delete('countries');
        }
        return false;
    }

    //get states
    public function get_states()
    {
        $this->db->order_by('states.name');
        $query = $this->db->get('states');
        return $query->result();
    }

    //get paginated states
    public function get_paginated_states($per_page, $offset)
    {
        $country = $this->input->get('country', true);
        $q = trim($this->input->get('q', true));
        $this->db->join('countries', 'states.country_id = countries.id');
        $this->db->select('states.*, countries.name as country_name');
        if (!empty($country)) {
            $this->db->where('states.country_id', $country);
        }
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('countries.name', $q);
            $this->db->or_like('states.name', $q);
            $this->db->group_end();
        }
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('states');
        return $query->result();
    }

    //get paginated states count
    public function get_paginated_states_count()
    {
        $country = $this->input->get('country', true);
        $q = trim($this->input->get('q', true));
        $this->db->join('countries', 'states.country_id = countries.id');
        $this->db->select('states.*, countries.name as country_name');
        if (!empty($country)) {
            $this->db->where('states.country_id', $country);
        }
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('countries.name', $q);
            $this->db->or_like('states.name', $q);
            $this->db->group_end();
        }
        $query = $this->db->get('states');
        return $query->num_rows();
    }

    //get state
    public function get_state($id)
    {
        $this->db->where('states.id', $id);
        $query = $this->db->get('states');
        return $query->row();
    }

    //get states by country
    public function get_states_by_country($country_id)
    {
        $this->db->where('states.country_id', $country_id);
        $this->db->order_by('states.name');
        $query = $this->db->get('states');
        return $query->result();
    }
    //
    public function get_cities_by_state($state_id)
    {
        $this->db->where('cities.state_id', $state_id);
        $this->db->order_by('cities.city_name');
        $query = $this->db->get('cities');
        return $query->result();
    }
    //set default product country
    public function set_default_product_country()
    {
        $default_product_location = $this->input->post('default_product_location', true);
        $country_id = $this->input->post('country_id', true);

        $data = array(
            'default_product_location' => 0
        );

        if ($default_product_location == 1) {
            if (!empty($country_id)) {
                $data = array(
                    'default_product_location' => $country_id
                );
            }
        }

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //delete state
    public function delete_state($id)
    {
        $state = $this->get_state($id);
        if (!empty($state)) {
            $this->db->where('id', $id);
            return $this->db->delete('states');
        }
        return false;
    }

    public function country_by_name($country_name){
            if ($country_name != '') {
            return $this->db->get_where('countries', array('name' => $country_name))->row()->id;       
        }
    }
}