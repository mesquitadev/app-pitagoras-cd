<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Reports_model extends CI_Model
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

    function getDisponiveis()
    {
        $this->db->select('*')->from('vw_requests_disponiveis');
        return $this->db->get()->result();
    }

    public function getIndisponiveis()
    {
        $this->db->select('*')->from('vw_requests_indisponiveis');
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

    public function getLogs()
    {
        $this->db->select('*')->from('historico');
        $this->db->order_by("id","desc");
        return $this->db->get()->result();
    }

    public function getReports($dataInicial = null, $dataFinal = null)
    {

        if ($dataInicial == null || $dataFinal == null) {
            $dataInicial = date('Y-m-d');
            $dataFinal = date('Y-m-d');
        }
        $query = "SELECT * FROM vw_relatorio WHERE dt_emprestimo AND dt_devolucao BETWEEN ? AND ?";
        return $this->db->query($query, array($dataInicial, $dataFinal))->result();

    }
    


    public function request()
    {
        $procedure = "CALL insert_request(?,?,?,?,?)";

        return $this->db->query($procedure, $data);
    }


    public function getRequest($from, $barcode)
    {
        $this->db->select('chaves.*, sector.sector_name, type.type_name');
        $this->db->from($from);
        $this->db->where('barcode', $barcode);
        $this->db->join('sector', 'chaves.sector_id = sector.id');
        $this->db->join('type', 'chaves.type_id = type.id');
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



    function delete($from, $field)
    {
        header('Content-type: application/json; charset=UTF-8');
        $this->db->from($from);
        $this->db->where($field);

        if ($this->db->affected_rows() == '1') {
            $response['status']  = 'success';
            $response['message'] = 'Product Deleted Successfully ...';
        } else {
            $response['status']  = 'error';
            $response['message'] = 'Unable to delete product ...';
        }
        echo json_encode($response);
    }




}