<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  data
 */
class Request extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('auth');
        }
        $this->load->model('usuarios_model', 'users', true);
        $this->load->model('keys_model', 'keys', true);
        $this->load->model('requests_model', 'requests', true);
        $this->data['menuKeys'] = 'Chaves';


    }


    public function index()
	{

        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['requestkey'] = 'Requests';
        $this->data['view'] = 'requests/index';
        $this->data['menuSolicitar'] = 'Chaves';
        $this->data['menuChaves'] = 'Chaves';


        $this->load->view('includes/header', $this->data);


	}

    /*
     * @author : Victor Mesquita
     * Função para inserir nova requisição no banco de dados a partir da
     * procedure de insert_request
     */
    public function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cpf', 'cpf', 'required|trim');
        $this->form_validation->set_rules('barcode', 'barcode', 'required|trim');
        $this->form_validation->set_rules('request_service', 'request_service', 'required|trim');
        $this->form_validation->set_rules('request_company', 'request_company', 'required|trim');
        $this->form_validation->set_rules('request_manager', 'request_manager', 'required|trim');
        $this->form_validation->set_rules('user_id', 'user_id', 'required|trim');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('error', 'Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'request/index');

        } else {

            $data['cpf'] = $this->input->post('cpf');
            $data['barcode'] = $this->input->post('barcode');
            $data['request_service'] = $this->input->post('request_service');
            $data['request_company'] = $this->input->post('request_company');
            $data['request_manager'] = $this->input->post('request_manager');
            $data['user_id'] = $this->input->post('user_id');

            $this->keys_model->insertRequest($data);

            $row = $this->requests->getMessage();

            $return = $this->db->affected_rows() > 0;
            if ($return) {
                foreach($row as $r):
                echo json_encode(array(
                    "status" => "$r->flag",
                    "title" => "$r->titulo",
                    "message" => "$r->descricao"

                ));
                endforeach;
            }

        }

    }

    /*
     * @author : Victor Mesquita
     * Função para exibição da view de requests
     */
    public function giveback()
    {
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('auth');
        }

        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['givebackKey'] = 'Devolver';
        $this->data['view'] = 'requests/giveback';
        $this->data['menuDevolver'] = 'Chaves';

        $this->load->view('includes/header', $this->data);

    }

    /*
     * @author : Victor Mesquita
     * Função para devolução de chaves a partir da procedure de update_request
     */
    public function givebk()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('barcode', 'barcode', 'required|trim');;

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('error', 'Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'keys/index');

        } else {

            $data['barcode'] = $this->input->post('barcode');
            $this->requests->devolve($data);
            $return = $this->db->affected_rows() > 0;
            if ($return) {
                echo json_encode(array(
                    "status" => "success",
                    "title" => "Sucesso!",
                    "message" => "Chave entregue!"

                ));

            } else {
                echo json_encode(array(
                    "status" => "error",
                    "title" => "Erro!",
                    "message" => "Chave já Entregue!"

                ));

            }

        }
    }


    public function getRequest()
    {
        $barcode = $this->input->get('barcode');

        if ($this->requests->getVw($barcode)) {
            $response = $this->requests->getVw($barcode);
            echo json_encode($response);
            exit();

        } else {
            echo json_encode(array(
                "status" => "error",
                "title" => "Erro",
                "message" => "Chave Não Encontrada!"
            ));
            exit();
        }
    }



    /*
     * @author : Victor Mesquita
     * função para busca dos dados da view de requests retornando-os em JSON
     * model: requests
     */
    public function getInfo()
    {
        $barcode = $this->input->get('barcode');

        $return =  $this->requests->getAll('vw_requests', $barcode);

        if ($return) {
            $response = $this->requests->getAll('vw_requests', $barcode);
            echo json_encode($response);
            exit();

        } else {
            echo json_encode(array(
                "status" => "error",
                "title" => "Erro",
                "message" => "Chave Não Encontrada!"
            ));
            exit();
        }
    }

}
