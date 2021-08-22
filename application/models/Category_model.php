<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'slug' => $this->input->post('slug', true),
            'description' => $this->input->post('description', true),
            'keywords' => $this->input->post('keywords', true),
            'category_order' => $this->input->post('category_order', true),
            'homepage_order' => $this->input->post('homepage_order', true),
            'visibility' => $this->input->post('visibility', true),
            'show_on_homepage' => $this->input->post('show_on_homepage', true),
            'icon'=> $this->input->post('icon',true)
        );
        return $data;
    }

    //add category name
    public function add_category_name($category_id)
    {
        $data = array();
        foreach ($this->languages as $language) {
            $data["category_id"] = $category_id;
            $data["lang_id"] = $language->id;
            $data["name"] = $this->input->post('name_lang_' . $language->id, true);
            $this->db->insert('categories_lang', $data);
        }
    }

    //update category name
    public function update_category_name($category_id)
    {
        $data = array();
        foreach ($this->languages as $language) {
            $data["category_id"] = $category_id;
            $data["lang_id"] = $language->id;
            $data["name"] = $this->input->post('name_lang_' . $language->id, true);

            //check category name exists
            $this->db->where('category_id', $category_id);
            $this->db->where('lang_id', $language->id);
            $row = $this->db->get('categories_lang')->row();
            if (empty($row)) {
                $this->db->insert('categories_lang', $data);
            } else {
                $this->db->where('category_id', $category_id);
                $this->db->where('lang_id', $language->id);
                $this->db->update('categories_lang', $data);
            }
        }
    }

    //add category
    public function add_category()
    {
        $data = $this->input_values();
        //set parent id
        $parent_id = $this->input->post('parent_id', true);
        $second_parent_id = $this->input->post('second_parent_id', true);
        if (!empty($second_parent_id)) {
            $data["parent_id"] = $second_parent_id;
            $data["top_parent_id"] = $parent_id;
            $data["category_level"] = 3;
        } else {
            $data["parent_id"] = $parent_id;
            $data["top_parent_id"] = $parent_id;
            $data["category_level"] = 2;
            if ($parent_id == 0) {
                $data["parent_id"] = 0;
                $data["top_parent_id"] = 0;
                $data["category_level"] = 1;
            }
        }
        //set slug
        if (empty($data["slug"])) {
            //slug for title
            $data["slug"] = str_slug($this->input->post('name_lang_' . $this->general_settings->site_lang, true));
        }

        //upload image
        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            $data["image_1"] = $this->upload_model->category_image_upload($file, 420, 312);
            $data["image_2"] = $this->upload_model->category_image_upload($file, 440, 541);
        } else {
            $data["image_1"] = "";
            $data["image_2"] = "";
        }
        $data["parent_slug"] = $this->get_parent_category_slug($data["parent_id"]);
        $data["top_parent_slug"] = $this->get_parent_category_slug($data["top_parent_id"]);
        $data["created_at"] = date('Y-m-d H:i:s');

        return $this->db->insert('categories', $data);
    }

    //update category
    public function update_category($id)
    {
        $data = $this->input_values();
        //set parent id
        $parent_id = $this->input->post('parent_id', true);
        $second_parent_id = $this->input->post('second_parent_id', true);
        if (!empty($second_parent_id)) {
            $data["parent_id"] = $second_parent_id;
            $data["top_parent_id"] = $parent_id;
            $data["category_level"] = 3;
        } else {
            $data["parent_id"] = $parent_id;
            $data["top_parent_id"] = $parent_id;
            $data["category_level"] = 2;
            if ($parent_id == 0) {
                $data["parent_id"] = 0;
                $data["top_parent_id"] = 0;
                $data["category_level"] = 1;
            }
        }
        //set slug
        if (empty($data["slug"])) {
            //slug for title
            $data["slug"] = str_slug($this->input->post('name_lang_' . $this->general_settings->site_lang, true));
        }
        //upload image
        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            $category = $this->get_category($id);
            delete_file_from_server($category->image_1);
            delete_file_from_server($category->image_2);
            $data["image_1"] = $this->upload_model->category_image_upload($file, 420, 312);
            $data["image_2"] = $this->upload_model->category_image_upload($file, 440, 541);
        }

        $this->update_subcategories_parent_slug($id, $data["slug"]);

        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    //get parent category slug
    public function get_parent_category_slug($parent_id)
    {
        if ($parent_id != 0) {
            $category = $this->get_category($parent_id);
            if (!empty($category)) {
                return $category->slug;
            }
        }
        return "";
    }

    //update slug
    public function update_slug($id)
    {
        $category = $this->get_category($id);
        if (empty($category->slug) || $category->slug == "-") {
            $data = array(
                'slug' => $category->id
            );
            $this->db->where('id', $id);
            return $this->db->update('categories', $data);
        } else {
            if (!empty($this->check_category_slug($category->slug, $id))) {
                $data = array(
                    'slug' => $category->slug . "-" . $category->id
                );

                $this->db->where('id', $id);
                return $this->db->update('categories', $data);
            }
        }
    }

    //update subcategories parent slug
    public function update_subcategories_parent_slug($parent_id, $slug)
    {
        $this->db->where('categories.parent_id', $parent_id);
        $query = $this->db->get('categories');
        $categories = $query->result();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $data = array(
                    'parent_slug' => $slug
                );
                $this->db->where('id', $category->id);
                $this->db->update('categories', $data);
            }
        }

        $this->db->where('categories.top_parent_id', $parent_id);
        $query = $this->db->get('categories');
        $categories = $query->result();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $data = array(
                    'top_parent_slug' => $slug
                );
                $this->db->where('id', $category->id);
                $this->db->update('categories', $data);
            }
        }
    }

    //check category slug
    public function check_category_slug($slug, $id)
    {
        $this->db->where('slug', $slug);
        $this->db->where('id !=', $id);
        $query = $this->db->get('categories');
        return $query->row();
    }

    //get category
    public function get_category($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('categories');
        return $query->row();
    }

    public function get_mobile_category(){
        $this->db->limit(9);        
        $this->db->join('categories_lang', 'categories_lang.category_id = categories.id');
        $this->db->select('categories.*, categories_lang.lang_id as lang_id, categories_lang.name as name');
        $this->db->where('categories.category_level', 1);
        $this->db->where_not_in('categories.slug','other-categories');
        $query=$this->db->get('categories');
        return $query->result_array();
    }

    //get category joined
    public function get_category_joined($id)
    {
        $this->db->join('categories_lang', 'categories_lang.category_id = categories.id');
        $this->db->select('categories.*, categories_lang.lang_id as lang_id, categories_lang.name as name');
        $this->db->where('categories_lang.lang_id', $this->selected_lang->id);
        $this->db->where('categories.id', $id);
        $this->db->where('categories.visibility', 1);
        $query = $this->db->get('categories');
        return $query->row();
    }

    //get all categories
    public function get_categories_all()
    {
        $this->db->join('categories_lang', 'categories_lang.category_id = categories.id');
        $this->db->select('categories.*, categories_lang.lang_id as lang_id, categories_lang.name as name');
        $this->db->where('categories_lang.lang_id', $this->selected_lang->id);
        $this->db->order_by('category_order');
        $query = $this->db->get('categories');
        return $query->result();
    }

    //get sitemap categories
    public function get_sitemap_categories()
    {
        $this->db->join('categories_lang', 'categories_lang.category_id = categories.id');
        $this->db->select('categories.*, categories_lang.lang_id as lang_id, categories_lang.name as name');
        $this->db->where('categories.visibility', 1);
        $this->db->order_by('category_order');
        $query = $this->db->get('categories');
        return $query->result();
    }

    //get parent categories
    public function get_parent_categories()
    {
        $this->db->join('categories_lang', 'categories_lang.category_id = categories.id');
        $this->db->select('categories.*, categories_lang.lang_id as lang_id, categories_lang.name as name');
        $this->db->where('categories_lang.lang_id', $this->selected_lang->id);
        $this->db->where('category_level', 1);
        $this->db->where('categories.visibility', 1);
        $this->db->order_by('category_order');
        $query = $this->db->get('categories');
        return $query->result();
    }

    //get subcategories by parent id
    public function get_subcategories_by_parent_id($parent_id)
    {
        $this->db->join('categories_lang', 'categories_lang.category_id = categories.id');
        $this->db->select('categories.*, categories_lang.lang_id as lang_id, categories_lang.name as name');
        $this->db->where('categories_lang.lang_id', $this->selected_lang->id);
        $this->db->where('parent_id', $parent_id);
        $this->db->where('categories.visibility', 1);
        $this->db->order_by('category_order');
        $query = $this->db->get('categories');
        return $query->result();
    }

    //get category name by lang
    public function get_category_name_by_lang($category_id, $lang_id)
    {
        $this->db->where('categories_lang.category_id', $category_id);
        $this->db->where('categories_lang.lang_id', $lang_id);
        $query = $this->db->get('categories_lang');
        $row = $query->row();
        if (!empty($row)) {
            return $row->name;
        } else {
            return "";
        }
    }

    //get category by slug
    public function get_category_by_slug($slug)
    {
        $this->db->join('categories_lang', 'categories_lang.category_id = categories.id');
        $this->db->select('categories.*, categories_lang.lang_id as lang_id, categories_lang.name as name');
        $this->db->where('categories_lang.lang_id', $this->selected_lang->id);
        $this->db->where('categories.slug', $slug);
        $this->db->where('categories.visibility', 1);
        $query = $this->db->get('categories');
        return $query->row();
    }

    //get featured categories
    public function get_featured_categories()
    {
        $this->db->join('categories_lang', 'categories_lang.category_id = categories.id');
        $this->db->select('categories.*, categories_lang.lang_id as lang_id, categories_lang.name as name');
        $this->db->where('categories_lang.lang_id', $this->selected_lang->id);
        $this->db->where('show_on_homepage', 1);
        $this->db->where('categories.visibility', 1);
        $this->db->where('categories.category_level', 1);
        $this->db->order_by('homepage_order');
        $query = $this->db->get('categories');
        return $query->result();
    }

    //get featured categories count
    public function get_featured_categories_count()
    {
        $this->db->join('categories_lang', 'categories_lang.category_id = categories.id');
        $this->db->select('categories.*, categories_lang.lang_id as lang_id, categories_lang.name as name');
        $this->db->where('categories_lang.lang_id', $this->selected_lang->id);
        $this->db->where('show_on_homepage', 1);
        $this->db->where('categories.visibility', 1);
        $query = $this->db->get('categories');
        return $query->num_rows();
    }

    //get featured category
    public function get_featured_category($count)
    {
        $categories = $this->get_featured_categories();
        if (!empty($categories)) {
            $i = 1;
            foreach ($categories as $category) {
                if ($i == $count) {
                    return $category;
                    break;
                }
                $i++;
            }
        }
        return false;
    }

    //delete category name
    public function delete_category_name($category_id)
    {
        $this->db->where('category_id', $category_id);
        $query = $this->db->get('categories_lang');
        $results = $query->result();
        if (!empty($results)) {
            foreach ($results as $result) {
                $this->db->where('id', $result->id);
                $this->db->delete('categories_lang');
            }
        }
    }

    //delete category
    public function delete_category($id)
    {
        $category = $this->get_category($id);
        if (!empty($category)) {
            //delete category name
            $this->delete_category_name($id);
            delete_file_from_server($category->image_1);
            delete_file_from_server($category->image_2);
            $this->db->where('id', $id);
            return $this->db->delete('categories');
        }
        return false;
    }

}