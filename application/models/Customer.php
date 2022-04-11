<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_customers()
    {
        $this->db->from('customers');
        $query = $this->db->get();
        return $query->result();
    }

    function get_customer_by_email($email)
    {
        $this->db->where('email', $email);
        $this->db->from('customers');
        $query = $this->db->get();
        return $query->row();
    }

    function get_customer_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('customers');
        $query = $this->db->get();
        return $query->row();
    }

    function create_customer($data)
    {
        return $this->db->insert('customers', $data) ? $this->db->insert_id() : false;
    }

    function update_customer($id, $data)
    {
		$this->db->where('id', $id);
		return $this->db->update('customers', $data);
    }
}
