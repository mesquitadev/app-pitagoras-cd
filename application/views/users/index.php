<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Usuários Cadastrados</h2>
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
                <i class="fa fa-plus"></i> Adicionar Requisitante
            </button>
        </div>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Usuários</h5>
                </div>
                <div class="ibox-content">

                    <table class="footable table table-stripped toggle-arrow-tiny">
                        <thead>
                        <tr>

                            <th>#</th>
                            <th>Nome</th>
                            <th>Cpf</th>
                            <th>Telefone 1</th>
                            <th>Telefone 2</th>
                            <th>Permissões</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $u):?>
                            <tr>
                                <td class="campo"><?=$u->id;?></td>
                                <td class="campo"><?=$u->full_name;?></td>
                                <td class="campo"><?=$u->cpf;?></td>

                                <td class="campo"><?=$u->phone1?></td>

                                <td class="campo"><?=$u->phone2?></td>
                                <td class="campo"><?=$u->name?></td>
                                <td class="campo"><?=$u->status_name?></td>

                                <td>
                                    <button class="btn-warning btn btn-xs" data-toggle="modal" data-target="#editKey">Editar</button>
                                    <a  href="javascript:void(0)" data-id="<?=$u->id?>" class="btn btn-danger btn-xs">Apagar</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
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
                        <label for="nome" class="col-sm-2 control-label">Identificação da Chave</label>
                        <div class="col-sm-10">
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Código de Barras</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="barcode" value="<?=date( 'dmYHi');?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Setor</label>
                        <div class="col-sm-10">
                            <select class="form-control m-b" name="setor_id" required>
                                <option value="Selecione Um Setor" selected>Selecione um Setor</option>
                                <?php foreach ($setor as $s):?>
                                    <option value="<?=$s->id;?>" ><?=$s->setor_nome;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control m-b" name="status_id" required>
                                <?php foreach ($status as $s):?>
                                    <option value="<?=$s->id;?>" selected><?=$s->nome;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tipo de Chave:</label>
                        <div class="col-sm-10">
                            <select class="form-control m-b" name="id_tipo" required>
                                <option value="">Selecione o Tipo de Chave</option>
                                <?php foreach ($tipo as $t):?>
                                    <option value="<?=$t->id;?>"><?=$t->tipo_nome;?></option>
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
                        <button type="reset" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Encerra modal-->

<!--Modal Gerar Card-->
<div class="modal inmodal fade" id="gerarCard" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Gerar Cartão</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <h2>Nome</h2>
                            <img alt="image" src="<?=base_url('/assets/img/logo-pitagoras.png')?>"/>
                            <span>Gerência Operacional | Controle de Chaves</span>
                            <span class="frm1"></span>
                            <span class="frm2"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <h2>Nome</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--Encerra modal-->

<!--Modal Adicionar Chave-->
<div class="modal inmodal fade" id="editKey" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--Encerra modal-->

