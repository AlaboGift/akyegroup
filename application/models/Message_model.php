<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model
{
    //add conversation
    public function add_conversation()
    {
        $data = array(
            'sender_id' => $this->input->post('sender_id', true),
            'receiver_id' => $this->input->post('receiver_id', true),
            'last_receiver_id' => $this->input->post('receiver_id', true),
            'subject' => $this->input->post('subject', true),
            'is_replied' => 0,
            'is_read' => 0,
            'sender_deleted' => 0,
            'receiver_deleted' => 0,
            'created_at' => date("Y-m-d H:i:s")
        );

        return $this->db->insert('conversations', $data);
    }

    //add message
    public function add_message($conversation_id)
    {
        $data = array(
            'conversation_id' => $conversation_id,
            'sender_id' => $this->input->post('sender_id', true),
            'receiver_id' => $this->input->post('receiver_id', true),
            'message' => $this->input->post('message', true),
            'created_at' => date("Y-m-d H:i:s")
        );

        return $this->db->insert('conversation_messages', $data);
    }

    //update conversation
    public function update_conversation($conversation_id)
    {
        $data = array(
            'last_receiver_id' => $this->input->post('receiver_id', true),
            'is_replied' => 1,
            'is_read' => 0
        );
        $this->db->where('id', $conversation_id);
        return $this->db->update('conversations', $data);
    }

    //get paginated conversations
    public function get_paginated_conversations($user_id, $per_page, $offset)
    {
        $this->db->group_start();
        $this->db->where('conversations.receiver_deleted=0 AND conversations.receiver_id=' . $user_id);
        $this->db->or_where('conversations.sender_deleted=0 AND conversations.sender_id=' . $user_id);
        $this->db->group_end();
        $this->db->order_by("is_read");
        $this->db->order_by('conversations.id', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('conversations');
        return $query->result();
    }

    //get inbox conversations count
    public function get_conversations_count($user_id)
    {
        $this->db->group_start();
        $this->db->where('conversations.receiver_deleted=0 AND conversations.receiver_id=' . $user_id);
        $this->db->or_where('conversations.sender_deleted=0 AND conversations.sender_id=' . $user_id);
        $this->db->group_end();
        $query = $this->db->get('conversations');
        return $query->num_rows();
    }

    //get conversation
    public function get_conversation($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('conversations');
        return $query->row();
    }

    //get messages
    public function get_messages($conversation_id)
    {
        $this->db->where('conversation_id', $conversation_id);
        $query = $this->db->get('conversation_messages');
        return $query->result();
    }

    //get unread conversation count
    public function get_unread_conversations_count($receiver_id)
    {
        $this->db->where('conversations.last_receiver_id', $receiver_id);
        $this->db->where('conversations.receiver_deleted', 0);
        $this->db->where('conversations.is_read', 0);
        $query = $this->db->get('conversations');
        return $query->num_rows();
    }

    //set conversation as read
    public function set_conversation_as_read($conversation)
    {
        if (!empty($conversation)) {
            if ($conversation->last_receiver_id == user()->id) {
                $data = array(
                    'is_read' => 1
                );
                $this->db->where('id', $conversation->id);
                $this->db->update('conversations', $data);
            }
        }
    }

    //get last message
    public function get_last_message($conversation_id)
    {
        $this->db->where('conversation_id', $conversation_id);
        $this->db->order_by('conversation_messages.id', 'DESC');
        $query = $this->db->get('conversation_messages');
        return $query->row();
    }

    //delete conversation
    public function delete_conversation($id)
    {
        $conversation = $this->get_conversation($id);
        if (!empty($conversation)) {
            if ($conversation->sender_id == $conversation->receiver_id) {
                $data = array(
                    'sender_deleted' => 1,
                    'receiver_deleted' => 1
                );
            } else {
                //sender delete
                if ($conversation->sender_id == user()->id) {
                    $data = array(
                        'sender_deleted' => 1
                    );
                }
                //receiver delete
                if ($conversation->receiver_id == user()->id) {
                    $data = array(
                        'receiver_deleted' => 1
                    );
                }
            }

            $this->db->where('id', $conversation->id);
            $this->db->update('conversations', $data);
        }
    }

    //delete multi messages
    public function delete_multi_conversations($conversation_ids)
    {
        if (!empty($conversation_ids)) {
            foreach ($conversation_ids as $id) {
                $this->delete_conversation($id);
            }
        }
    }

}