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
                        <h5>Chaves</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                            <tr>

                                <th>Código</th>
                                <th>Chave</th>
                                <th>Setor</th>
                                <th>Código de Barras:</th>
                                <th>Status</th>
                                <th>Tipo</th>
                                <th>Data de Cadastro:</th>
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aChave', 'eChave', 'dChave')):?>
                                    <th>Ações</th>
                                <?php endif;?>

                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($keys as $k):?>
                            <tr>
                                <td class="over"><?=$k->id;?></td>
                                <td class="over"><?=$k->name_chave;?></td>
                                <td class="over"><?=$k->sector_name?></td>
                                <td class="over"><?=$k->barcode;?></td>

                                <td>
                                    <?php if($k->name == "Disponível"){
                                        print '<span class="label label-primary">Disponível</span>';
                                    } else if($k->name == "Indisponível") {
                                        print '<span class="label label-danger">Indisponível</span>';
                                    } else {
                                        print 'Erro, Não Há status cadastrado';
                                    }?>
                                </td>
                                <td class="over" ><?=$k->type_name?></td>

                                <td><?php print date('d/m/Y', strtotime($k->created_at));?></td>

                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vChave')):?>
                                        <a class="btn-success btn btn-xs"  href="<?=base_url('/keys/card/').$k->id?>">Cartão</a>


                                    <?php endif;?>

                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eChave')):?>
                                        <a class="btn-warning btn btn-xs" href="<?=base_url('/keys/editKey/').$k->id?>" >Editar</a>
                                    <?php endif;?>

                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dChave')):?>
                                        <button id="" data-id="<?=$k->id?>" class="btn btn-danger btn-xs deleteKey">Apagar</button>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

<!--Modais-->
<!--Modal Adicionar Chave-->
    <div class="modal inmodal fade" id="addChave" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Chave</h4>
                </div>

                <div class="modal-body">

                    <form id="addKey" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Identificação da Chave</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Código de Barras</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="barcode" value="<?=date( 'dmYHi');?>" required readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sector_id" class="col-sm-2 control-label">Setor</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" name="sector_id" required>
                                    <option value="Selecione Um Setor" selected>Selecione um Setor</option>
                                    <?php foreach ($setor as $s):?>
                                        <option value="<?=$s->id;?>" ><?=$s->sector_name;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label  for="type_name" class="col-sm-2 control-label">Tipo de Chave:</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" name="type_name" required>
                                    <option value="">Selecione o Tipo de Chave</option>
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
                                     jsbarcode-value="<?=date( 'dmYHi');?>"
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
<!--Encerra modal-->