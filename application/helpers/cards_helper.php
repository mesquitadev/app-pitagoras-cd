<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function gerarCard()
{

    require_once APPPATH . '/helpers/cards/cards.php';

    $carteirinha = new Carteirinha(386, 244);
    $carteirinha->setImagemCarteira(base_url('/assets/img/uploads/cartao.jpg'));
    $carteirinha->setFoto(base_url('/assets/img/uploads/foto.jpg'));
    $carteirinha->setTamanhoFoto(22, 22, 138, 121);
    $carteirinha->setNomeAluno("Victor Mesquita");
    $carteirinha->setTexto(5, 174, 40);
    $carteirinha->setCorTexto(0, 0, 0);

//    $carteirinha = new Carteirinha(386, 244);
//    $carteirinha->setImagemCarteira(base_url('/assets/img/uploads/cartao.jpg'));
//    $carteirinha->setFoto(base_url('/assets/img/uploads/foto.jpg'));
////    $carteirinha->setTamanhoFoto(22, 22, 138, 121);
//    $carteirinha->setNomeAluno('Victor Mesquita 2');
//    $carteirinha->setTexto(5, 174, 40);
//    $carteirinha->setCorTexto(0, 0, 0);

    $carteirinha->gerar(base_url('assets/img/')."carteira-".date('d-m-Y'));
//    $carteirinha->gerar(base_url('/assets/img/uploads/carteira_nova-'.date('d-m-y')));


}
