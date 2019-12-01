<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Log de Registros</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?=base_url('/dashboard')?>">Dashboard</a>
                </li>
                <li>
                    <a href="<?=base_url('/keys')?>">Chaves</a>
                </li>
                <li class="active">
                    <strong>Log</strong>
                </li>
        </div>
    </div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Relatório</h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
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
                                <tr class="gradeX ">
                                    <td><?=$k->chave_name;?></td>
                                    <td><?=$k->evento;?></td>
                                    <td><?=$k->request_user?></td>
                                    <td><?=$k->company;?></td>
                                    <td><?=$k->service?></td>
                                    <td><?=$k->manager?></td>
                                    <td><?=$k->porteiro?></td>
                                    <td><?=date('d/m/Y', strtotime($k->data));?> ás <?=$k->hora?></td>

                                </tr>
                            <?php endforeach;?>

                            </tbody>
                            <tfoot>
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
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

