<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Total de Chaves</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$allkeys?></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Chaves Emprestadas</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?=$allEmprestimos?></h1>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ultimas Retiradas</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-hover no-margins">
                                <thead>
                                <tr>
                                    <th>Chave:</th>
                                    <th>Usuário Retirada:</th>
                                    <th>Retirada:</th>
                                    <th>Entrega:</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($request_keys as $r): ?>
                                    <tr>
                                        <td><?php print $r->name_chave;?></td>
                                        <td><?php print $r->full_name;?></td>
                                        <td><span class="label label-danger">Saída</span> <?=date('d/m/Y', strtotime($r->dt_emprestimo))?></td>

                                        <?php if ($r->name == 'Indisponível'):?>
                                            <td><span class="label label-danger">Não Entregue</span></td>
                                        <?php else:?>     
                                            <td><span class="label label-primary">Entrada</span> <?=date('d/m/Y', strtotime($r->dt_devolucao))?></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
