<div class="row wrapper border-bottom white-bg page-heading">
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
                                <h5>Cadastrar Permissão</h5>
                            </div>
                            <div class="ibox-content">
                                <form class="form-horizontal" method="POST" action="<?=base_url('permissions/new')?>">

                                    <div class="widget-content">

                                        <div class="span6">
                                            <label>Nome da Permissão</label>
                                            <input name="nome" type="text" id="nome" class="form-control" />

                                        </div>
                                        <div class="span6">
                                            <br/>
                                            <label>
                                                <input name="marcarTodos" type="checkbox" value="1" id="marcarTodos" />
                                                <span class="lbl"> Marcar Todos</span>

                                            </label>
                                            <br/>
                                        </div>

                                        <div class="control-group">
                                            <label for="documento" class="control-label"></label>
                                            <div class="controls">

                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="vChave" class="marcar" type="checkbox" checked="checked" value="1" />
                                                                <span class="lbl"> Visualizar Chaves</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="aChave" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Adicionar Chave</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="eChave" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Editar Chave</span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label>
                                                                <input name="dChave" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Excluir Chave</span>
                                                            </label>
                                                        </td>

                                                    </tr>

                                                    <tr><td colspan="4"></td></tr>
                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="vUsuario" class="marcar" type="checkbox" checked="checked" value="1" />
                                                                <span class="lbl"> Visualizar Usuario</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="aUsuario" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Adicionar Usuario</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="eUsuario" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Editar Usuário</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="dUsuario" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Excluir Usuario</span>
                                                            </label>
                                                        </td>

                                                    </tr>
                                                    <tr><td colspan="4"></td></tr>

                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="vSolicitacao" class="marcar" type="checkbox" checked="checked" value="1" />
                                                                <span class="lbl"> Visualizar Solicitações</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="aSolicitacao" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Adicionar Solicitação</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="eServico" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Editar Serviço</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="dServico" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Excluir Serviço</span>
                                                            </label>
                                                        </td>

                                                    </tr>

                                                    <tr><td colspan="4"></td></tr>
                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="vOs" class="marcar" type="checkbox" checked="checked" value="1" />
                                                                <span class="lbl"> Visualizar OS</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="aOs" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Adicionar OS</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="eOs" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Editar OS</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="dOs" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Excluir OS</span>
                                                            </label>
                                                        </td>

                                                    </tr>
                                                    <tr><td colspan="4"></td></tr>

                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="vVenda" class="marcar" type="checkbox" checked="checked" value="1" />
                                                                <span class="lbl"> Visualizar Venda</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="aVenda" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Adicionar Venda</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="eVenda" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Editar Venda</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="dVenda" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Excluir Venda</span>
                                                            </label>
                                                        </td>

                                                    </tr>

                                                    <tr><td colspan="4"></td></tr>

                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="vArquivo" class="marcar" type="checkbox" checked="checked" value="1" />
                                                                <span class="lbl"> Visualizar Arquivo</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="aArquivo" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Adicionar Arquivo</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="eArquivo" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Editar Arquivo</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="dArquivo" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Excluir Arquivo</span>
                                                            </label>
                                                        </td>

                                                    </tr>

                                                    <tr><td colspan="4"></td></tr>

                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="vLancamento" class="marcar" type="checkbox" checked="checked" value="1" />
                                                                <span class="lbl"> Visualizar Lançamento</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="aLancamento" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Adicionar Lançamento</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="eLancamento" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Editar Lançamento</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="dLancamento" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Excluir Lançamento</span>
                                                            </label>
                                                        </td>

                                                    </tr>

                                                    <tr><td colspan="4"></td></tr>

                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="rChave" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Relatório Chaves</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="rSolicitacoes" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Relatório Solicitações</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="rOs" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Relatório OS</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="rProduto" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Relatório Produto</span>
                                                            </label>
                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="rVenda" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Relatório Venda</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="rFinanceiro" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Relatório Financeiro</span>
                                                            </label>
                                                        </td>
                                                        <td colspan="2"></td>

                                                    </tr>
                                                    <tr><td colspan="4"></td></tr>

                                                    <tr>

                                                        <td>
                                                            <label>
                                                                <input name="cUsuario" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Configurar Usuário</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="cEmitente" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Configurar Emitente</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="cPermissao" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Configurar Permissão</span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <label>
                                                                <input name="cBackup" class="marcar" type="checkbox" value="1" />
                                                                <span class="lbl"> Backup</span>
                                                            </label>
                                                        </td>

                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>




                                        <div class="hr-line-dashed"></div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="col-sm-offset-2 pull-right">
                                                <button type="submit" class="btn btn-default">Sign in</button>
                                                <button type="submit" class="btn btn-success">Solicitar</button>
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
<script type="text/javascript" src="<?php echo base_url('assets/js/validate.js')?>"></script>
