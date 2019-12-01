<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Chaves Indisponíveis</h2>
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
                    <a href="<?=base_url('/reports/download')?>" target="_blank" type="button" class="btn btn-primary">
                        <i class="fa fa-print"></i> Imprimir
                    </a>
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
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($keys as $k):?>
                            <tr>
                                <td class="campo"><?=$k->id;?></td>
                                <td class="campo"><?=$k->name_chave;?></td>
                                <td class="campo"><?=$k->sector_name?></td>
                                <td class="campo"><?=$k->barcode;?></td>
                                <td class="campo"><?=$k->type_name?></td>
                                <td>
                                    <?php if($k->name == "Disponível"){
                                        print '<span class="label label-primary">Disponível</span>';
                                    } else if($k->name == "Indisponível") {
                                        print '<span class="label label-danger">Indisponível</span>';
                                    } else {
                                        print 'Erro, Não Há status cadastrado';
                                    }?>
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
