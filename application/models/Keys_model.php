<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Keys_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model', '', true);
        $this->load->model('keys_model', '', true);
    }

    /**
     * @param $tables
     * @param $from
     * @param $where
     * @param $fields
     * @return array
     */
    function getKeys()
    {
        $this->db->select('*')->from('vw_chaves');
        return $this->db->get()->result();
    }

    function Atualizar($id, $data) {
        if(is_null($id) || !isset($data))
            return false;
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function edit($barcode, $data)
    {
        if(is_null($barcode) || !isset($data)){
            return false;
        } else {
            $procedure = "CALL update_chave(?,?,?,?)";
            return $this->db->query($procedure, $data);
        }


    }

    function getById($table, $id)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    function getData($id)
    {
        $this->db->select('*');
        $this->db->from('vw_chaves');
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    function getDisponiveis()
    {
        $this->db->select('*')->from('vw_requests_disponiveis');
        return $this->db->get()->result();
    }

    function getRequests()
    {
        $this->db->select('*')->from('vw_requests');
        $this->db->order_by("id","desc");
        return $this->db->get()->result();
    }

    public function getAllKeys()
    {
        return $this->db->count_all('chaves');
    }

    public function getEmprestimos()
    {
        $this->db->count_all_results('chaves');  
        $this->db->where('status_id', 2);
        $this->db->from('chaves');
        return $this->db->count_all_results(); 
    }

    public function getAtrasos()
    {
        $this->db->count_all_results('chaves'); 
        $this->db->where('id', 2);
        $this->db->from('chaves');
        return $this->db->count_all_results(); 
    }
    


    public function request($data)
    {
        $procedure = "CALL insert_request(?,?,?,?,?)";
        return $this->db->query($procedure, $data);
    }

    public function insertRequestUser($data)
    {
        $procedure = "CALL insert_request_users(?,?,?,?)";
        return $this->db->query($procedure, $data);
    }




    public function getRequest($barcode)
    {
        $this->db->select('*');
        $this->db->from('vw_chaves');
        $this->db->where('barcode', $barcode);
        $this->db->limit(1);
        return $this->db->get()->result();
    }

    public function getKey($from, $barcode)
    {
        $this->db->select('*');
        $this->db->from($from);
        $this->db->where('barcode', $barcode);
        $this->db->limit(1);
        return $this->db->get()->result();
    }



    public function getSetor()
    {
        $this->db->select('*');
        $this->db->from('sector');
        return $this->db->get()->result();
    }

    public function getType()
    {
        $this->db->select('*');
        $this->db->from('type');
        return $this->db->get()->result();
    }

    public function getStatus()
    {
        $this->db->select('*');
        $this->db->from('status');
        return $this->db->get()->result();
    }

    public function insert($data)
    {
        $procedure = "CALL insert_chave(?,?,?,?)";

        return $this->db->query($procedure, $data);
    }

    public function insertRequest($data)
    {
        $procedure = "CALL insert_request(?,?,?,?,?,?)";
        $query  = $this->db->query($procedure, $data);

        $error = $this->db->error($query);
        if(!$error){
            throw  new Exception("Erro!");
        }

    }

    public function devolve($data)
    {
        $procedure = "CALL update_request(?)";

        return $this->db->query($procedure, $data);
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