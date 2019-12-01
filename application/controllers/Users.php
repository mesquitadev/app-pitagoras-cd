<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('auth');
        }
        $this->load->model('usuarios_model', 'users', true);
        $this->data['menuKeys'] = 'Chaves';


    }

    public function index()
	{

        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['users'] = $this->users->getAllUsers();
        $this->data['usersMenu'] = 'Usuários';
        $this->data['view'] = 'users/index';

        $this->load->view('includes/header', $this->data);

	}

    /*
     * @author : Victor Mesquita
     * Função para buscar os dados do usuário a partir do
     * cpf via protocolo GET, fazendo a busca no banco de dados via
     * WHERE.
     */
    public function getUser()
    {
        $cpf = $this->input->get('cpf');

        $return =  $this->users->getUsers('request_users', $cpf);

        if ($return) {
            $response = $this->users->getUsers('request_users', $cpf);
            echo json_encode($response);
            exit();

        } else {
            echo json_encode(array(
                "status" => "warning",
                "title" => "Erro",
                "message" => "Cpf Não Encontrado!"
            ));
            exit();
        }
    }


    /**
     *
     */
    public function forgotPassword()
    {

        $oldSenha = $this->input->post('oldSenha');
        $senha = $this->input->post('novaSenha');
        $result = $this->usuarios_model->alterarSenha($senha, $oldSenha, $this->session->userdata('id'));
        if ($result) {
            $this->session->set_flashdata('success', 'Senha Alterada com sucesso!');
            redirect(base_url() . 'index.php/mapos/minhaConta');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar a senha!');
            redirect(base_url() . 'index.php/mapos/minhaConta');

        }
    }

    public function myaccount()
    {

        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['myAccount'] = 'Minha Conta';
        $this->data['view'] = 'users/myaccount';

        $this->load->view('includes/header', $this->data);
    }

    public function request()
    {
        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['users'] = $this->users->getRequestUsers();
        $this->data['requestUser'] = 'Cadastrar Requisitante';
        $this->data['view'] = 'users/requestUsers';
        $this->data['menuCadastrar'] = 'Chaves';
        $this->data['menuChaves'] = 'Chaves';

        $this->load->view('includes/header', $this->data);
    }
}
