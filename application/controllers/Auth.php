<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model', TRUE);
        $this->load->helper('url');
    }

    public function index()
    {
        return $this->load->view('auth/index');
    }

    public function login()
    {

        header('Access-Control-Allow-Origin: '.base_url());
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');

        $this->load->library('form_validation');
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'valid_email|required|trim'
        );
        $this->form_validation->set_rules(
            'password',
            'Senha',
            'required|trim'
        );
        if ($this->form_validation->run() == false) {
            $json = array(
                'result' => false,
                'message' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $this->load->model('Usuarios_model');
            $user = $this->Usuarios_model->check_credentials($email);

            if ($user) {
                if (password_verify($password, $user->password)) {
                    $session_data = array(
                        'nome' => $user->full_name,
                        'email' => $user->email,
                        'id' => $user->id,
                        'permissao' => $user->permissions_id ,
                        'logado' => true
                    );
                    $this->session->set_userdata($session_data);
                    $json = array('result' => true);
                    echo json_encode($json);
                } else {
                    $json['status'] = "warning";
                    $json['message'] = "Verifique as credenciais de acesso!";
                    echo json_encode($json);
                }

            } else {
                $json['status'] = "warning";
                $json['message'] = "Verifique as suas credenciais!";
                echo json_encode($json);
            }
        }
        die();
    }

    /**
     *
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }



}
