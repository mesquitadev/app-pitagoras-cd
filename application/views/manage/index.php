<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Setores</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?=base_url('/dashboard')?>">Dashboard</a>
            </li>
            <li>
                <a href="<?=base_url('/permissions')?>">Permissões</a>
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
                    <h5>Permissões</h5>
                </div>
                <div class="ibox-content">

                    <table class="footable table table-stripped toggle-arrow-tiny">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Data de Criação</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($sector as $s):?>
                            <tr>

                                <td class="over"><?=$s->id;?></td>
                                <td class="over"><?=$s->sector_name;?></td>
                                <td class="over"><?php print date('d/m/Y H:i:s', strtotime($s->created_at));?></td>
                                <td>

                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'cPermissao')):?>
                                        <a class="btn-warning btn btn-xs" href="<?=base_url('/manage/edit/').$s->id?>" >Editar</a>
                                    <?php endif;?>

                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'cPermissao')):?>
                                        <button id="" data-id="<?=$s->id?>" class="btn btn-danger btn-xs deleteSector">Apagar</button>
                                    <?php endif;?>
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
<!--Modal Adicionar Chave-->
<div class="modal inmodal fade" id="addChave" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Adicionar Setor</h4>
            </div>

            <div class="modal-body">

                <form id="addSector" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Setor</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control">
                        </div>
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