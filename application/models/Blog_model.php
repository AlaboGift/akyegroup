<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'title' => $this->input->post('title', true),
            'slug' => $this->input->post('slug', true),
            'summary' => $this->input->post('summary', true),
            'keywords' => $this->input->post('keywords', true),
            'category_id' => $this->input->post('category_id', true),
            'content' => $this->input->post('content', true),
            'user_id' => user()->id
        );
        return $data;
    }

    //add post
    public function add_post()
    {
        $data = $this->input_values();

        if (empty($data["slug"])) {
            //slug for title

            $data["slug"] = str_slug($data["title"]);
        }
        $data["created_at"] = date('Y-m-d H:i:s');
        //upload image
        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            $data["image_default"] = $this->upload_model->blog_image_default_upload($file);
            $data["image_small"] = $this->upload_model->blog_image_small_upload($file);
        } else {
            $data["image_default"] = "";
            $data["image_small"] = "";
        }
        return $this->db->insert('blog_posts', $data);
    }

    //update slug
    public function update_slug($id)
    {
        $post = $this->get_post($id);

        if (empty($post->slug) || $post->slug == "-") {
            $data = array(
                'slug' => $post->id
            );
            $this->db->where('id', $id);
            $this->db->update('blog_posts', $data);
        } else {
            if ($this->check_is_slug_unique($post->slug, $id) == true) {
                $data = array(
                    'slug' => $post->slug . "-" . $post->id
                );

                $this->db->where('id', $id);
                $this->db->update('blog_posts', $data);
            }
        }
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {
        $this->db->where('blog_posts.slug', $slug);
        $this->db->where('blog_posts.id !=', $id);
        $query = $this->db->get('blog_posts');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //get post
    public function get_post($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('blog_posts');
        return $query->row();
    }

    //get post joined
    public function get_post_joined($id)
    {
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_posts.id', $id);
        $query = $this->db->get('blog_posts');
        return $query->row();
    }

    //get post by slug
    public function get_post_by_slug($slug)
    {
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_posts.slug', $slug);
        $query = $this->db->get('blog_posts');
        return $query->row();
    }

    //get posts
    public function get_posts()
    {
        $this->db->where('blog_posts.lang_id', $this->selected_lang->id);
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //get posts count
    public function get_posts_count()
    {
        $this->db->where('blog_posts.lang_id', $this->selected_lang->id);
        $query = $this->db->get('blog_posts');
        return $query->num_rows();
    }

    //get all posts
    public function get_posts_all()
    {
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //get all posts joined
    public function get_posts_all_joined()
    {
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //get all posts count
    public function get_all_posts_count()
    {
        $query = $this->db->get('blog_posts');
        return $query->num_rows();
    }

    //get latest posts
    public function get_latest_posts($limit)
    {
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_posts.lang_id', $this->selected_lang->id);
        $this->db->limit($limit);
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //get posts by category
    public function get_posts_by_category($category_id)
    {
        $this->db->where('blog_posts.category_id', $category_id);
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //get post count by category
    public function get_post_count_by_category($category_id)
    {
        $this->db->where('blog_posts.category_id', $category_id);
        $query = $this->db->get('blog_posts');
        return $query->num_rows();
    }

    //get paginated posts
    public function get_paginated_posts($per_page, $offset)
    {
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_posts.lang_id', $this->selected_lang->id);
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //get paginated category posts
    public function get_paginated_category_posts($per_page, $offset, $category_id)
    {
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_posts.category_id', $category_id);
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //get paginated tag posts
    public function get_paginated_tag_posts($per_page, $offset, $tag_slug)
    {
        $this->db->join('blog_tags', 'blog_posts.id= blog_tags.post_id');
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_tags.tag_slug', $tag_slug);
        $this->db->where('blog_posts.lang_id', $this->selected_lang->id);
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //get paginated tag posts count
    public function get_paginated_tag_posts_count($tag_slug)
    {
        $this->db->join('blog_tags', 'blog_posts.id= blog_tags.post_id');
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_tags.tag_slug', $tag_slug);
        $this->db->where('blog_posts.lang_id', $this->selected_lang->id);
        $query = $this->db->get('blog_posts');
        return $query->num_rows();
    }

    //get related posts
    public function get_related_posts($category_id, $post_id)
    {
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_posts.id !=', $post_id);
        $this->db->where('blog_posts.category_id', $category_id);
        $this->db->order_by('rand()');
        $this->db->limit(3);
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //update post
    public function update_post($id)
    {
        $data = $this->input_values();
        $post = $this->get_post($id);

        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["title"]);
        }

        //upload image
        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            //delete old image
            delete_file_from_server($post->image_default);
            delete_file_from_server($post->image_small);
            $data["image_default"] = $this->upload_model->blog_image_default_upload($file);
            $data["image_small"] = $this->upload_model->blog_image_small_upload($file);
        }

        $this->db->where('id', $id);
        return $this->db->update('blog_posts', $data);
    }

    //delete post
    public function delete_post($id)
    {
        $post = $this->get_post($id);

        if (!empty($post)) {
            //delete  image
            delete_file_from_server($post->image_default);
            delete_file_from_server($post->image_small);
            //delete post tags
            $this->tag_model->delete_post_tags($id);
            $this->db->where('id', $id);
            return $this->db->delete('blog_posts');
        } else {
            return false;
        }
    }

}