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

    function get_services()
    {
        $this->db->select('services.*, providers.name as provider_name');
        $this->db->from('services');
		$this->db->join('providers', 'providers.id = services.provider_id');
		$this->db->where('status', '1');
        $query = $this->db->get();
        return $query->result();
    }

    function get_service_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('services');
        $query = $this->db->get();
        return $query->row();
    }

    function get_service_by_id_with_provider_name($id)
    {
        $this->db->select('services.*, providers.name as provider_name');
        $this->db->where('services.id', $id);
        $this->db->from('services');
		$this->db->join('providers', 'providers.id = services.provider_id');
        $query = $this->db->get();
        return $query->row();
    }

    function get_orders_by_customer_id($customer_id)
    {
        $this->db->select('orders.*, services.name as service_name');
        $this->db->where('orders.customer_id', $customer_id);
        $this->db->from('orders');
		$this->db->join('services', 'services.id = orders.service_id');
        $query = $this->db->get();
        return $query->result();
    }

    function create_order($data)
    {
        return $this->db->insert('orders', $data) ? $this->db->insert_id() : false;
    }

    function update_order($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('orders', $data);
    }
}
