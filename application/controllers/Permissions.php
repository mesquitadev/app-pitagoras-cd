<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 09/11/18
 * Time: 23:24
 */
Class Permissions extends CI_Controller
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
        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['menuPermissoes'] = 'Permissoes';

    }

    function index()
    {
        $this->data['view'] = 'permissions/index';
        $this->data['permissions'] = $this->permissions->getAll();

        $this->load->view('includes/header', $this->data);
    }


    public function add()
    {

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $nomePermissao = $this->input->post('nome');
            $cadastro = date('Y-m-d');
            $situacao = 1;

            $permissoes = array(
                //Permissões Controle Chaves
                'aChave' => $this->input->post('aChave'),
                'eChave' => $this->input->post('eChave'),
                'dChave' => $this->input->post('dChave'),
                'vChave' => $this->input->post('vChave'),

                //Permissões Controle Solicitantes
                'aSolicitante' => $this->input->post('aSolicitante'),
                'eSolicitante' => $this->input->post('eSolicitante'),
                'dSolicitante' => $this->input->post('dSolicitante'),
                'vSolicitante' => $this->input->post('vSolicitante'),

                'cUsuario' => $this->input->post('cUsuario'),
                'cEmitente' => $this->input->post('cEmitente'),
                'cPermissao' => $this->input->post('cPermissao'),
                'cBackup' => $this->input->post('cBackup'),

                'rCliente' => $this->input->post('rCliente'),
                'rProduto' => $this->input->post('rProduto'),
                'rServico' => $this->input->post('rServico'),
                'rOs' => $this->input->post('rOs'),
                'rVenda' => $this->input->post('rVenda'),
                'rFinanceiro' => $this->input->post('rFinanceiro'),

            );
            $permissoes = serialize($permissoes);

            $data = array(
                'nome' => $nomePermissao,
                'data' => $cadastro,
                'permissoes' => $permissoes,
                'situacao' => $situacao
            );

            if ($this->permissions->add('permissoes', $data) == true) {

                $this->session->set_flashdata('success', 'Permissão adicionada com sucesso!');
                redirect(base_url() . 'permissions/index');
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $this->data);
        $this->load->view('permissions/new', $this->data);
        $this->load->view('includes/copyright');
        $this->load->view('includes/footer');

    }

    function editar()
    {


        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $nomePermissao = $this->input->post('nome');
            $situacao = $this->input->post('situacao');
            $permissoes = array(

                'aCliente' => $this->input->post('aCliente'),
                'eCliente' => $this->input->post('eCliente'),
                'dCliente' => $this->input->post('dCliente'),
                'vCliente' => $this->input->post('vCliente'),

                'aProduto' => $this->input->post('aProduto'),
                'eProduto' => $this->input->post('eProduto'),
                'dProduto' => $this->input->post('dProduto'),
                'vProduto' => $this->input->post('vProduto'),

                'aServico' => $this->input->post('aServico'),
                'eServico' => $this->input->post('eServico'),
                'dServico' => $this->input->post('dServico'),
                'vServico' => $this->input->post('vServico'),

                'aOs' => $this->input->post('aOs'),
                'eOs' => $this->input->post('eOs'),
                'dOs' => $this->input->post('dOs'),
                'vOs' => $this->input->post('vOs'),

                'aVenda' => $this->input->post('aVenda'),
                'eVenda' => $this->input->post('eVenda'),
                'dVenda' => $this->input->post('dVenda'),
                'vVenda' => $this->input->post('vVenda'),

                'aArquivo' => $this->input->post('aArquivo'),
                'eArquivo' => $this->input->post('eArquivo'),
                'dArquivo' => $this->input->post('dArquivo'),
                'vArquivo' => $this->input->post('vArquivo'),

                'aLancamento' => $this->input->post('aLancamento'),
                'eLancamento' => $this->input->post('eLancamento'),
                'dLancamento' => $this->input->post('dLancamento'),
                'vLancamento' => $this->input->post('vLancamento'),

                'cUsuario' => $this->input->post('cUsuario'),
                'cEmitente' => $this->input->post('cEmitente'),
                'cPermissao' => $this->input->post('cPermissao'),
                'cBackup' => $this->input->post('cBackup'),

                'rCliente' => $this->input->post('rCliente'),
                'rProduto' => $this->input->post('rProduto'),
                'rServico' => $this->input->post('rServico'),
                'rOs' => $this->input->post('rOs'),
                'rVenda' => $this->input->post('rVenda'),
                'rFinanceiro' => $this->input->post('rFinanceiro'),

            );
            $permissoes = serialize($permissoes);

            $data = array(
                'nome' => $nomePermissao,
                'permissoes' => $permissoes,
                'situacao' => $situacao
            );

            if ($this->permissoes_model->edit('permissoes', $data, 'idPermissao', $this->input->post('idPermissao')) == true) {
                $this->session->set_flashdata('success', 'Permissão editada com sucesso!');
                redirect(base_url() . 'index.php/permissoes/editar/'.$this->input->post('idPermissao'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um errro.</p></div>';
            }
        }

        $this->data['result'] = $this->permissoes_model->getById($this->uri->segment(3));

        $this->data['view'] = 'permissoes/editarPermissao';
        $this->load->view('tema/topo', $this->data);

    }

    function desativar()
    {

        $id =  $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar desativar permissão.');
            redirect(base_url().'index.php/permissoes/gerenciar/');
        }
        $data = array(
            'situacao' => false
        );
        if ($this->permissoes_model->edit('permissoes', $data, 'idPermissao', $id)) {
            $this->session->set_flashdata('success', 'Permissão desativada com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro ao desativar permissão!');
        }


        redirect(base_url().'index.php/permissoes/gerenciar/');
    }
}
