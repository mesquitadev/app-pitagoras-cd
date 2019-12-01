<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 09/11/18
 * Time: 23:24
 */
Class Manage extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cPermissao')) {
            $json['status'] = "warning";
            $json['message'] = "Você não tem permissão para configuraissão para configurar as permissões no sistemar as permissões no sistema.";
            echo json_encode($json);
            exit();
        }

        $this->load->helper(array('form'));
        $this->load->model('permissions_model', 'permissions', true);
        $this->load->model('usuarios_model', 'users', true);
        $this->load->model('manage_model', 'manage', true);
        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['menuPermissoes'] = 'Permissoes';

    }

    public function index()
    {
        $this->data['view'] = 'manage/index';
        $this->data['sector'] = $this->manage->get('*', 'sector');

        $this->load->view('includes/header', $this->data);
    }

    public function addSector()
    {

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('mapos/login');
        }

        /*
         * Verificação de permissão
         */
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cPermissao')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para Adicionar Setor.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'name', 'required|trim');

        if ($this->form_validation->run() == false) {

            echo json_encode(array(
                "status" => "warning",
                "message" => "Campos obrigatórios não foram preenchidos!"
            ));
            redirect(base_url().'keys/index');

        } else {

            $data['name'] = $this->input->post('name');

            $this->manage->insert('sector', $data);

            $return = $this->db->affected_rows() > 0;
            if ($return) {
                    echo json_encode(array(
                        "status" => "success",
                        "title" => "Sucesso",
                        "message" => "Inserido com Sucesso!"
                    ));
            } else {
                echo json_encode(array(
                    "status" => "error",
                    "title" => "Erro!",
                    "message" => "Houve Algum erro na inserção!"
                ));
            }
        }
    }

    public function update()
    {

    }

    public function delete()
    {
        $id =  $this->uri->segment(3);
        $this->manage->delete('sector', 'id', $id);

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
