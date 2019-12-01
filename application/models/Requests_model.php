<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Requests_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model', 'users', true);
        $this->load->model('keys_model', 'keys', true);
    }




    function getRequests()
    {
        $this->db->select('*')->from('vw_requests');
        $this->db->order_by("id","desc");
        return $this->db->get()->result();
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

        $sql = $this->db->query($procedure, $data);
        return $sql->result();
    }




    public function getMessage()
    {
        $this->db->select('*')->from('mensagens')->where('id', 1);
        return $this->db->get()->result();
    }

    public function getVw($barcode)
    {
        $this->db->select('*')->from('vw_requests');
        $this->db->where('barcode', $barcode);
        $this->db->limit(1);
        return $this->db->get()->result();
    }

    /*
     * Função para buscar os dados do banco de dados pelo
     * Código de barras da view_requests
     */
    public function getAll($from, $barcode)
    {
        $this->db->select('*');
        $this->db->from($from);
        $this->db->where('barcode', $barcode);
        $this->db->limit(1);
        return $this->db->get()->result();
    }

    public function getUsers($from, $cpf)
    {
        $this->db->select('*');
        $this->db->from($from);
        $this->db->where('cpf', $cpf);
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