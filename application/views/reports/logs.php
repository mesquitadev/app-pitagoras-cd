<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Log de Registros</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url('/reports')?>">Relatórios</a>
                </li>
                <li>
                    <a href="<?=base_url('/logs')?>">Logs</a>
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
                        <h5>Log de Registros</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                            <tr>
                                <th>Chave</th>
                                <th>Evento</th>
                                <th>Solicitante</th>
                                <th>Empresa:</th>
                                <th>Serviço</th>
                                <th>Coordenador</th>
                                <th>Responsável pela Entrega</th>
                                <th>Data/hora</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($log as $k):?>
                            <tr>
                                <td class="over"><?=$k->chave_name;?></td>
                                <td class="over"><?=$k->evento;?></td>
                                <td class="over"><?=$k->request_user?></td>
                                <td class="over"><?=$k->company;?></td>
                                <td class="over"><?=$k->service?></td>
                                <td class="over"><?=$k->manager?></td>
                                <td class="over"><?=$k->porteiro?></td>
                                <td class="over"><?=date('d/m/Y', strtotime($k->data));?> ás <?=$k->hora?></td>

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
