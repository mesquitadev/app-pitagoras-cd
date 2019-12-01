<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  data
 */
class Reports extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('reports_model', 'reports', true);
        $this->load->model('usuarios_model', 'users', true);
        $this->load->model('keys_model', 'keys', true);
        $this->data['menuKeys'] = 'Chaves';
        $this->data['menuRelatorios'] = 'Relatórios';
        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
    }


    /**
     *
     */
    public function index()
	{
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('auth');
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');

        $this->data['keys'] = $this->reports->getReports($dataInicial, $dataFinal);
        $this->data['menuReports'] = 'Relatórios';
        $this->data['view'] = 'reports/index';
        $this->data['log'] = $this->reports->getLogs();

        $this->load->view('includes/header', $this->data);

	}

	public function gerarRelatorioPdf()
    {
        $this->load->helper('mpdf');
        $html = $this->load->view('reports/press/print', $this->data, true);
        pdf_create($html, 'relatorio_produtos' . date('d/m/y'), true);
    }

    /**
     *
     */
    public function keysind()
    {
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('auth');
        }

        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['keys'] = $this->reports->getIndisponiveis();



        $this->load->view('includes/header');
        $this->load->view('includes/menu', $this->data);
        $this->load->view('reports/indisp', $this->data);
        $this->load->view('includes/copyright');
        $this->load->view('includes/footer');

    }

    public function logs()
    {
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('auth');
        }

        $this->data['user'] = $this->users->getById($this->session->userdata('id'));
        $this->data['log'] = $this->reports->getLogs();



        $this->load->view('includes/header');
        $this->load->view('includes/menu', $this->data);
        $this->load->view('reports/logs', $this->data);
        $this->load->view('includes/copyright');
        $this->load->view('includes/footer');
    }

	public function downloads()
    {

    }

    public function download()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar O.S.');
            redirect(base_url());
        }


        $this->data['user'] = $this->usuarios_model->getById($this->session->userdata('id'));


        $this->load->view('includes/header');
        $this->load->view('includes/menu', $this->data);
        $this->load->view('reports/press/index', $this->data);
        $this->load->view('includes/copyright');
        $this->load->view('includes/footer');

    }
}
