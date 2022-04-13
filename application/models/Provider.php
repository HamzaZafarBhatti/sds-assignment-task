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

    function get_services_by_provider_id($provider_id)
    {
        $this->db->where('provider_id', $provider_id);
        $this->db->from('services');
        $query = $this->db->get();
        return $query->result();
    }

    function get_orders_by_provider_id($provider_id)
    {
        $this->db->select('orders.*, customers.name as customer_name, services.name as service_name');
        $this->db->where('orders.provider_id', $provider_id);
        $this->db->from('orders');
		$this->db->join('services', 'services.id = orders.service_id');
		$this->db->join('customers', 'customers.id = orders.customer_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_services_count_by_provider_id($provider_id)
    {
        $this->db->where('provider_id', $provider_id);
        $this->db->from('services');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_orders_count_by_provider_id($provider_id)
    {
        $this->db->where('provider_id', $provider_id);
        $this->db->from('orders');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_service_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('services');
        $query = $this->db->get();
        return $query->row();
    }

    function get_order_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('orders');
        $query = $this->db->get();
        return $query->row();
    }
    
    function create_service($data)
    {
        return $this->db->insert('services', $data) ? $this->db->insert_id() : false;
    }

    function update_service($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('services', $data);
    }

    function update_order($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('orders', $data);
    }
    
    function delete_service($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('services');
    }
}
