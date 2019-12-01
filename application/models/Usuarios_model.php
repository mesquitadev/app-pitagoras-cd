<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Usuarios_model extends CI_Model {
    public function check_credentials($email)
    {
        $this->db->where('email', $email);
        $this->db->where('user_status_id', 1);
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    function getById($id)
    {
        $this->db->select('*');
        $this->db->from('vw_users');
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function getRequestUsers()
    {
        $this->db->select('*')->from('request_users');
        return $this->db->get()->result();
    }

    public function getAllUsers()
    {
        $this->db->select('*')->from('vw_users');
        return $this->db->get()->result();
    }

    public function getUsers($from, $cpf)
    {
        $this->db->select('*');
        $this->db->from($from);
        $this->db->where('cpf', $cpf);
        return $this->db->get()->result();
    }
}