<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Provider extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_providers()
    {
        $this->db->from('providers');
        $query = $this->db->get();
        return $query->result();
    }

    function get_provider_by_email($email)
    {
        $this->db->where('email', $email);
        $this->db->from('providers');
        $query = $this->db->get();
        return $query->row();
    }

    function get_provider_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('providers');
        $query = $this->db->get();
        return $query->row();
    }

    function create_provider($data)
    {
        return $this->db->insert('providers', $data) ? $this->db->insert_id() : false;
    }

    function update_provider($id, $data)
    {
		$this->db->where('id', $id);
		return $this->db->update('providers', $data);
    }
}
