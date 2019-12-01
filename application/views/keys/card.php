<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Chaves Cadastradas</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url('/dashboard')?>">Dashboard</a>
                </li>
                <li>
                    <a href="<?=base_url('/keys')?>">Chaves</a>
                </li>
                <li class="active">
                    <strong>Listar</strong>
                </li>
        </div>
    </div>


    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Editar Chave</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="col-sm-6">
                                            <img class="barcode"
                                                 jsbarcode-format="CODE128"
                                                 jsbarcode-value="<?=$keys->barcode;?>"
                                                 jsbarcode-textmargin="0"
                                                 jsbarcode-fontoptions="bold"
                                            >
                                        </div>
                                        <div class="col-sm-6">

                                            <div class="info">
                                                <h3>Chave: <?=$keys->name_chave;?></h3>
                                                <h3>Setor: <?=$keys->sector_name;?></h3>
                                                <h3>Tipo: <?=$keys->type_name;?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn btn-success"style="margin-top: 10px;" id="gerarCard">Salvar</a>
                                </div>
                                <div class="col-md-4"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

