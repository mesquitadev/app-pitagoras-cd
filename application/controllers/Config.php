<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    public function backup()
    {

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('auth/login');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cBackup')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para efetuar backup.');
            redirect(base_url());
        }



        $this->load->dbutil();
        $prefs = array(
            'format'      => 'zip',
            'foreign_key_checks' => false,
            'filename'    => 'backup'.date('d-m-Y').'.sql'
        );

        $backup = $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url().'backup/backup.zip', $backup);

        $this->load->helper('download');
        force_download('backup'.date('d-m-Y H:m:s').'.zip', $backup);
    }
}
