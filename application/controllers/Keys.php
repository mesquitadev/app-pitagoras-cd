<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  data
 */
class Keys extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model', 'users', true);
        $this->load->model('keys_model', 'keys', true);
        $this->load->model('requests_model', 'requests', true);
        $this->load->model('permissions_model', 'permissoes', true);

        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['menuChaves'] = 'Chaves';

    }


    public function index()
	{
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('auth');
        }


        $this->data['keys'] = $this->keys->getKeys();
        $this->data['setor'] = $this->keys->getSetor();
        $this->data['tipo'] = $this->keys->getType();
        $this->data['status'] = $this->keys->getStatus();

        $this->data['view'] = 'keys/index';
        $this->data['menuListar'] = 'Chaves';
        $this->load->view('includes/header', $this->data);
	}


	public function saveCard()
    {
        $result = array();
        $imagedata = base64_decode($_POST['img_data']);
        $filename = md5(date("dmYhisA"));
        //Location to where you want to created sign image
        $file_name = './doc_signs/'.$filename.'.png';
        file_put_contents($file_name,$imagedata);
        $result['status'] = 1;
        $result['file_name'] = $file_name;
        echo json_encode($result);

    }

    public function card()
    {
       if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('keys/edit');
        }
        $id = $this->uri->segment(3);
        $this->data['view'] = 'keys/card';
        $this->data['keys'] = $this->keys->getById('vw_chaves', $id);
        $this->load->view('includes/header', $this->data);
    }





    /*
     * @author : Victor Mesquita
     * Função para buscar dados da chave no banco de dados via protocolo GET
     * retornando os dados para a view em JSON
     */
    public function infoKeys()
    {
        $barcode = $this->input->get('barcode');

        if ($this->keys->getRequest($barcode)) {
            $response = $this->keys->getRequest($barcode);
            echo json_encode($response);
            exit();

        } else {
            echo json_encode(array(
                "status" => "warning",
                "title" => "Erro",
                "message" => "Chave Não Encontrada!"
            ));
            exit();
        }
    }

    /*
     * @author : Victor Mesquita
     * Função para adicionar novas chaves ao banco
     */
    public function add()
    {

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        /*
         * Verificação de permissão
         */
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aChave')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para Adicionar Chave.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('barcode', 'barcode', 'required|trim');
        $this->form_validation->set_rules('sector_id', 'sector_id', 'required|trim');
        $this->form_validation->set_rules('type_name', 'type_name', 'required|trim');

        if ($this->form_validation->run() == false) {

            echo json_encode(array(
                "status" => "warning",
              "message" => "Campos obrigatórios não foram preenchidos!"
            ));
            redirect(base_url().'keys/index');

        } else {

            $data['name'] = $this->input->post('name');
            $data['barcode'] = $this->input->post('barcode');
            $data['sector_id'] = $this->input->post('sector_id');
            $data['type_name'] = $this->input->post('type_name');

            $this->keys->insert($data);

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
     * Função para adicionar novos requisitantes ao banco
     */
    public function addRequestUser()
    {

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        /*
         * Verificação de permissão
         */
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('cpf', 'cpf', 'required|trim');
        $this->form_validation->set_rules('full_name', 'full_name', 'required|trim');
        $this->form_validation->set_rules('phone1', 'phone1', 'required|trim');
        $this->form_validation->set_rules('phone2', 'phone2', 'trim');

        if ($this->form_validation->run() == false) {

            echo json_encode(array(
                "status" => "warning",
                "message" => "Campos obrigatórios não foram preenchidos!"
            ));
            redirect(base_url().'users/request');

        } else {

            $data['cpf'] = $this->input->post('cpf');
            $data['full_name'] = $this->input->post('full_name');
            $data['phone1'] = $this->input->post('phone1');
            $data['phone2'] = $this->input->post('phone2');
            $this->keys->insertRequestUser($data);



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


    public function editRequestUser()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar clientes.');
            redirect(base_url());
        }

        $this->load->library('form_validation');

        if ($this->form_validation->run('clientes') == false) {
            echo json_encode(array(
                "status" => "warning",
                "message" => "Campos obrigatórios não foram preenchidos!"
            ));
        } else {
            $data = array(
                'nomeCliente' => $this->input->post('nomeCliente'),
                'documento' => $this->input->post('documento'),

            );

            if ($this->clientes_model->edit('clientes', $data, 'idClientes', $this->input->post('idClientes')) == true) {
                $this->session->set_flashdata('success', 'Cliente editado com sucesso!');
                redirect(base_url() . 'index.php/clientes/editar/'.$this->input->post('idClientes'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->keys->getById('request_users', $this->input->post('id'));
    }

    function editKey()
    {

        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('keys/edit');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'name', 'required|trim');
        $this->form_validation->set_rules('barcode', 'barcode', 'required|trim');
        $this->form_validation->set_rules('sector_id', 'sector_id', 'required|trim');
        $this->form_validation->set_rules('type_name', 'type_name', 'required|trim');

        if ($this->form_validation->run() == true) {
            echo json_encode(array(
                "status" => "error",
                "title" => "Erro!",
                "message" => "Campos não foram preenchidos!"
            ));
        } else {
            $data = array(
                'name_novo' => $this->input->post('name'),
                'chave_barcode' => $this->input->post('barcode'),
                'novo_sector_id' => $this->input->post('sector_id'),
                'novo_type_id' => $this->input->post('type_name')
            );
            if ($this->keys->edit($data) == true) {
                echo json_encode(array(
                    "status" => "success",
                    "title" => "Sucesso!",
                    "message" => "Usuário Editado com sucesso!"
                ));
            } else {
                echo json_encode(array(
                    "status" => "error",
                    "title" => "Erro!",
                    "message" => "Ocorreu algum erro na Atualização dos dados!"
                ));
            }
        }



        $this->data['result'] = $this->keys->getById('vw_chaves', $this->uri->segment(3));
        $this->data['permissoes'] = $this->permissoes->getActive('permissions', 'permissions.id, permissions.name');
        $this->data['setor'] = $this->keys->getSetor();
        $this->data['tipo'] = $this->keys->getType();
        $this->data['status'] = $this->keys->getStatus();

        $this->data['view'] = 'keys/edit';
        $this->load->view('includes/header', $this->data);


    }


    /*
     * @author : Victor Mesquita
     * Função para deletar dados do banco passando o parâmetro via where
     * Finalizado
     */
    public function delete()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dChave')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir Chaves.');
            redirect(base_url());
        }
        $id =  $this->uri->segment(3);
        $this->keys->delete('chaves', 'id', $id);

        $return = $this->db->affected_rows() > 0;
        if ($return) {
                echo json_encode(array(
                    "status" => "success",
                    "title" => "Sucesso!",
                    "message" => "Registro deletado com sucesso!"

                ));
        }
    }

    public function deleteRequestUser()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir O.S.');
            redirect(base_url());
        }
        $id =  $this->uri->segment(3);
        $this->keys->delete('request_users', 'id', $id);

        $return = $this->db->affected_rows() > 0;
        if ($return) {
            echo json_encode(array(
                "status" => "success",
                "title" => "Sucesso!",
                "message" => "Registro deletado com sucesso!"

            ));
        }
    }
}
