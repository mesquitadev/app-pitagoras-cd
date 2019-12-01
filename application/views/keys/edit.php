<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
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
        <div class="col-lg-2">
                <div class="text-center btn-add">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addChave">
                        <i class="fa fa-plus"></i> Adicionar Chave
                    </button>
                </div>
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

                        <form action="<?php base_url('keys/editKey')?>" method="POST" class="form-horizontal">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Identificação da Chave</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" id="name" class="form-control" value="<?php print $result->name_chave?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Código de Barras</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="barcode" value="<?php print $result->barcode?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sector_id" class="col-sm-2 control-label">Setor</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="sector_id">
                                        <?php foreach ($setor as $s):?>
                                            <option value="<?=$result->sector_name?>" selected><?=$result->sector_name?></option>
                                            <option value="<?=$s->id;?>" ><?=$s->sector_name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label  for="type_name" class="col-sm-2 control-label">Tipo de Chave:</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="type_name">
                                        <option value="1" selected><?=$result->type_name?></option>
                                        <?php foreach ($tipo as $t):?>

                                            <option value="<?=$t->id;?>"><?=$t->type_name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <svg class="barcode"
                                         jsbarcode-format="CODE128"
                                         jsbarcode-value="<?php print $result->barcode?>"
                                         jsbarcode-textmargin="0"
                                         jsbarcode-fontoptions="bold">
                                    </svg>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-white" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

