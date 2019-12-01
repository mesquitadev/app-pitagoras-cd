<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Manage_model extends CI_Model {

    function getById($id)
    {
        $this->db->select('*');
        $this->db->from('vw_users');
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function get($fields, $table)
    {
        $this->db->select($fields)->from($table);
        return $this->db->get()->result();
    }

    public function insert($table, $data)
    {
            $this->db->insert($table, $data);
            if ($this->db->affected_rows() == '1') {
                return true;
            }

            return false;
    }

    function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        return false;
    }

}