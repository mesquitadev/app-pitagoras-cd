<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model', '', true);
        $this->load->model('keys_model', '', true);
    }

    public function index()
	{
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('auth');
        }
	    //SELECT chaves.*, setor.setor_nome FROM chaves INNER JOIN setor WHERE chaves.setor_id = setor.id
        $this->data['request_keys'] = $this->keys_model->getRequests();
        $this->data['setor'] = $this->keys_model->getSetor();
        $this->data['allkeys'] = $this->keys_model->getAllKeys();
        $this->data['allEmprestimos'] = $this->keys_model->getEmprestimos();
        $this->data['user'] = $this->usuarios_model->getById($this->session->userdata('id'));
        $this->data['menuDashboard'] = 'Painel';
        $this->data['view'] = 'dashboard/index';

	    $this->load->view('includes/header', $this->data);
	}
}
