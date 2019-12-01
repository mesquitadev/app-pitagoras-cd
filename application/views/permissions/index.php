<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Permissões</h2>
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
            <a href="<?=base_url('/permissions/new')?>" type="button" class="btn btn-primary">
                <i class="fa fa-plus"></i> Adicionar Permissão
            </a>
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
                            <th>Situação</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($permissions as $p):?>
                            <tr>

                                <td class="over"><?=$p->id;?></td>
                                <td class="over"><?=$p->name;?></td>
                                <td class="over"><?php print date('d/m/Y H:i:s', strtotime($p->created_at));?></td>

                                <td>
                                    <?php if($p->permissons_situation_id == 1){
                                        print '<span class="label label-primary">Ativo</span>';
                                    } else if($p->permissons_situation_id == 2) {
                                        print '<span class="label label-danger">Inativo</span>';
                                    } else {
                                        print 'Erro, Não Há status cadastrado';
                                    }?>
                                </td>



                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'cPermissao')):?>
                                        <a class="btn-warning btn btn-xs" href="<?=base_url('/keys/editKey/').$p->id?>" >Editar</a>
                                    <?php endif;?>

                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'cPermissao')):?>
                                        <button id="" data-id="<?=$p->id?>" class="btn btn-danger btn-xs deleteKey">Apagar</button>
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
