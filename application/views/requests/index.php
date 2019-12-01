<div class="row wrapper border-bottom white-bg page-heading" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-10">
        <h2>Solicitar Chave</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?=base_url('/dashboard')?>">Dashboard</a>
            </li>
            <li>
                <a href="<?=base_url('/keys')?>">Chaves</a>
            </li>
            <li class="active">
                <strong>Solicitar</strong>
            </li>
        </ol>
    </div>

</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Solicitar Chave</h5>
                            </div>
                            <div class="ibox-content">
                                <form id="addRequest" class="forrm-horizontal" method="POST">

                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="cpf" class="control-label">CPF do Solicitante:</label>
                                            <input type="number" name="cpf" class="form-control" id="cpf" placeholder="Digite o Cpf do solicitante">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <div class="col-xs-6">
                                                <label for="inputEmail3" class="control-label">Usuário:</label>
                                                <input type="text" name="user_name" class="form-control" id="user_nome"readonly>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="inputEmail3" class="control-label"> Telefone:</label>
                                                <input type="text" class="form-control" id="telefone" readonly>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="inputEmail3" class="control-label">Código da Chave:</label>
                                            <input type="number" name="barcode" class="form-control" id="barcode" placeholder="Digite o código da chave">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <div class="col-xs-6">
                                                <label for="inputEmail3" class="control-label"> Chave:</label>
                                                <input type="text" class="form-control" id="nome" readonly>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="inputEmail3" class="control-label"> Tipo de Chave:</label>
                                                <input type="text" class="form-control" id="tipo_chave" readonly>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6">

                                        </div>

                                        <div class="form-group col-sm-6">
                                            <div class="col-xs-6">
                                                <label for="inputEmail3" class="control-label">Serviço a ser Realizado:</label>
                                                <input type="text" class="form-control" name="request_service" required>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="inputEmail3" class="control-label">Empresa:</label>
                                                <input type="text" class="form-control" name="request_company" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6">

                                        </div>

                                        <div class="form-group col-sm-6">
                                            <div class="col-xs-6">
                                                <label for="inputEmail3" class="control-label">Gestor:</label>
                                                <input type="text" class="form-control" name="request_manager" required>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="inputEmail3" class="control-label">Portaria:</label>
                                                <select class="form-control" name="user_id">
                                                    <option value="<?php echo $user->id?>" selected readonly><?php echo $user->full_name?></option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="hr-line-dashed"></div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="col-sm-offset-2 pull-right">
                                                <button id="btn-acessar" type="submit" class="btn btn-success">Solicitar</button>
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


