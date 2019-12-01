<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 09/11/18
 * Time: 23:21
 */
Class Permissions_model extends CI_Model
{


    function __construct()
    {
        parent::__construct();

    }

    function getActive($table, $fields)
    {

        $this->db->select($fields);
        $this->db->from($table);
        $this->db->where('permissions_situation_id', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function getAll()
    {
        $this->db->select('*');
        $this->db->from('permissions');
        return $this->db->get()->result();
    }


    function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {

        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idPermissao', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }


    function getById($id)
    {
        $this->db->where('idPermissao', $id);
        $this->db->limit(1);
        return $this->db->get('permissoes')->row();
    }

    function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
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

    function count($table)
    {
        return $this->db->count_all($table);
    }
}