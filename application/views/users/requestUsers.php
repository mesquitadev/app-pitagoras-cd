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
                    <h5>Requisitantes</h5>
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
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $u):?>
                            <tr>
                                <td><?=$u->id;?></td>
                                <td><?=$u->full_name;?></td>
                                <td><?=$u->cpf;?></td>

                                <td><?=$u->phone1?></td>

                                <td><?=$u->phone2?></td>

                                <td>
                                    <button class="btn-warning btn btn-xs" data-toggle="modal" data-target="#editKey">Editar</button>
                                    <button id="" data-id="<?=$u->id?>" class="btn btn-danger btn-xs deleteRequestUser">Apagar</button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="10">
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
                <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Requisitante</h4>
            </div>

            <div class="modal-body">

                <form id="addRequestUser" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label for="cpf" class="col-sm-2 control-label">CPF:</label>
                        <div class="col-sm-10">
                            <input type="number" name="cpf" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nome Completo:</label>
                        <div class="col-sm-10">
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone1" class="col-sm-2 control-label">Telefone 1:</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone1" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone2" class="col-sm-2 control-label">Telefone 2:</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone2" class="form-control">
                        </div>
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

                <form id="addRequestUser" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label for="cpf" class="col-sm-2 control-label">CPF:</label>
                        <div class="col-sm-10">
                            <input type="number" name="cpf" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nome Completo:</label>
                        <div class="col-sm-10">
                            <input type="text" name="full_name" value="" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone1" class="col-sm-2 control-label">Telefone 1:</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone1" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone2" class="col-sm-2 control-label">Telefone 2:</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone2" value="" class="form-control">
                        </div>
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

