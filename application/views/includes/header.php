<!DOCTYPE html>
    <html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Faculdade Pitágoras - SGC| Dashboard</title>

        <link href="<?=base_url('/assets/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('/assets/font-awesome/css/font-awesome.css')?>" rel="stylesheet">

        <link href="<?=base_url('/assets/css/animate.css')?>" rel="stylesheet">
        <link href="<?=base_url('/assets/css/style.css')?>" rel="stylesheet">
        <link href="<?=base_url('/assets/css/plugins/iCheck/custom.css')?>" rel="stylesheet">
        <link href="<?=base_url('/assets/css/plugins/dataTables/datatables.min.css')?>" rel="stylesheet">
        <link rel="icon" href="<?=base_url('assets/img/favicon.png')?>" type="image/x-icon">
        <!-- FooTable -->
        <link href="<?=base_url('/assets/css/plugins/footable/footable.core.css')?>" rel="stylesheet">

        <!-- Toastr style -->
        <link href="<?=base_url('/assets/css/plugins/toastr/toastr.min.css')?>" rel="stylesheet">
        <link rel="stylesheet" href="<?=base_url('/assets/css/card.css')?>">
        <!-- Sweet Alert -->
        <link href="<?=base_url('/assets/css/plugins/sweetalert/sweetalert.css')?>" rel="stylesheet">
        <script src="<?=base_url('/assets/js/JsBarcode.ean-upc.min.js')?>"></script>

    </head>
    <body class="fixed-sidebar skin-1">
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                                <img alt="image" src="<?=base_url('/assets/img/logo-pitagoras.png')?>" style=" width: 50px;" />
                                 </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"><span class="block m-t-xs"><strong class="font-bold">
                                                <?php echo $user->full_name?>
                                        </strong>
                                 </span>
                            </a>
                        </div>
                    </li>


                    <li class="<?php if(isset($menuDashboard)){ print 'active';}?>">
                        <a href="<?=base_url('/dashboard')?>"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
                    </li>

                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vChave')):?>
                        <?php if(isset($menuChaves)):?>
                            <li class="active">
                        <?php else :?>
                            <li class="">
                        <?php endif;?>

                            <a class=""><i class="fa fa-key"></i> <span class="nav-label">Chaves</span> <span class="fa arrow"></span></a>

                            <ul class="nav nav-second-level">
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vChave')):?>
                                    <li class="<?php if(isset($menuListar)){ print 'active';}?>">
                                        <a href="<?=base_url('/keys');?>">Listar</a>
                                    </li>
                                <?php endif;?>

                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aSolicitacao')):?>
                                    <li class="<?php if(isset($menuSolicitar)){ print 'active';}?>">
                                        <a href="<?=base_url('/request/index');?>">Solicitar</a>
                                    </li>
                                <?php endif;?>

                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dSolicitacao')):?>
                                    <li class="<?php if(isset($menuDevolver)){ print 'active';}?>">
                                        <a href="<?=base_url('/request/giveback');?>">Devolver Chave</a>
                                    </li>
                                <?php endif;?>

                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aSolicitante')):?>
                                    <li class="<?php if(isset($menuCadastrar)){ print 'active';}?>">
                                        <a href="<?=base_url('/users/request');?>">Cadastrar Requisitante</a>
                                    </li>
                                <?php endif;?>
                            </ul>
                        </li>
                    <?php endif;?>

                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vRelatorio')):?>

                        <?php if(isset($menuReports)):?>
                            <li class="active">
                        <?php else :?>
                            <li class="">
                        <?php endif;?>
                            <a href=""><i class="fa fa-files-o"></i> <span class="nav-label">Relatórios</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vRelatorio')):?>
                                    <li class=""><a href="<?=base_url('/reports/index');?>">Logs</a></li>
                                <?php endif;?>
                            </ul>
                        </li>
                    <?php endif;?>

                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vConfig')):?>
                        <?php if(isset($menuConfig)):?>
                            <li class="active">
                        <?php else :?>
                            <li class="">
                        <?php endif;?>
                            <a href="<?=base_url('/config')?>"><i class="fa fa-cog"></i> <span class="nav-label">Configurações</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'cBackup')):?>
                                    <li class=""><a href="<?=base_url('/config/backup');?>">Backup</a></li>
                                <?php endif;?>
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'admin')):?>
                                    <li class=""><a href="<?=base_url('/permissions');?>">Permissões</a></li>
                                <?php endif;?>
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vUsuario')):?>
                                    <li class=""><a href="<?=base_url('/users');?>">Usuários</a></li>
                                <?php endif;?>
                                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vSetor')):?>
                                    <li class=""><a href="<?=base_url('/manage/index');?>">Setores</a></li>
                                <?php endif;?>
                            </ul>
                        </li>
                    <?php endif;?>

                    <li class="<?php if(isset($menuPerfil)){ print 'active';}?>">
                        <a href="<?=base_url('/users/myaccount')?>"><i class="fa fa-user"></i> <span class="nav-label">Perfil</span></a>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Bem vindo ao SGC - Gerenciamento de Chaves.</span>
                        </li>
                        <li>
                            <a href="<?=base_url('/auth/logout');?>">
                                <i class="fa fa-sign-out"></i> Sair do Sistema
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>





            <?php if (isset($view)){
                echo $this->load->view($view, null, true);
            }?>














            <div class="footer fixed">
                <div class="pull-right">
                    Desenvolvido pelo <strong>ESC</strong>
                </div>
                <div>
                    <strong>SGC - Faculdade Pitágoras</strong> &copy; 2018 - Todos os direitos Reservados.
                </div>
            </div>

            <script type='text/javascript'>
                JsBarcode(".barcode").init();
            </script>
            <!-- Mainly scripts -->
            <script src="<?=base_url('/assets/js/jquery-2.1.1.js')?>"></script>
            <script src="<?=base_url('/assets/js/bootstrap.min.js')?>"></script>
            <script src="<?=base_url('/assets/js/plugins/metisMenu/jquery.metisMenu.js')?>"></script>
            <script src="<?=base_url('/assets/js/plugins/slimscroll/jquery.slimscroll.min.js')?>"></script>
            <!-- Sweet alert -->
            <script src="<?=base_url('assets/js/plugins/sweetalert/sweetalert.min.js')?>"></script>
            <!-- Custom and plugin javascript -->
            <script src="<?=base_url('/assets/js/inspinia.js')?>"></script>
            <script src="<?=base_url('/assets/js/plugins/pace/pace.min.js')?>"></script>
            <script src="<?=base_url('/assets/js/plugins/dataTables/datatables.min.js')?>"></script>
            <!-- jQuery UI -->
            <script src="<?=base_url('/assets/js/plugins/jquery-ui/jquery-ui.min.js')?>"></script>


            <!-- Toastr -->
            <script src="<?=base_url('/assets/js/plugins/toastr/toastr.min.js')?>"></script>

            <!-- FooTable -->
            <script src="<?=base_url('/assets/js/plugins/footable/footable.all.min.js')?>"></script>
            <script src="<?=base_url('/assets/js/html2canvas.js')?>"></script>
            <script src="<?=base_url('/assets/js/image2canvas.js')?>"></script>
            <script src="<?=base_url('/assets/js/page-scripts.js')?>"></script>


            <script type="text/javascript">

                $(document).ready(function() {

                    $('.footable').footable();
                    $('.footable2').footable();
                });


                $(document).ready(function(){

                    $('.dataTables-example').DataTable({
                        pageLength: 10,
                        responsive: true,
                        "oLanguage": {
                            "sProcessing": "Aguarde enquanto os dados são carregados ...",
                            "sLengthMenu": "Mostrar _MENU_ registros por pagina",
                            "sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
                            "sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
                            "sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
                            "sInfoFiltered": "",
                            "sSearch": "Procurar",
                            "oPaginate": {
                                "sFirst":    "Primeiro",
                                "sPrevious": "Anterior",
                                "sNext":     "Próximo",
                                "sLast":     "Último"
                            }
                        },

                        dom: '<"html5buttons"B>lTfgitp',
                        buttons: [
                            {
                                extend: 'excel',
                                text: 'Exportar p/ Excel',
                                title: 'Relatório de Chaves | Faculdade Pitágoras'
                            },
                            {
                                extend: 'pdf',
                                text: 'Exportar p/ PDF',
                                title: 'Relatório de Chaves | Faculdade Pitágoras'
                            },

                            {
                                extend: 'print',
                                text: 'Imprimir',
                                customize: function (win){
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                }
                            }

                        ]

                    });

                });



                /*
                 Busca de Dados do Banco com o retorno em ajax
                */
                $(document).ready(function() {
                    $("#barcode").blur(function(){
                        var barcode = $(this).val().replace(/\D/g, '');
                        if(barcode != ""){
                            var validator = /^[0-9]{12}$/;

                            if(validator.test(barcode)){
                                //Preenche os campos com "..." até achar os dados
                                $("#nome").val("...");

                                $.ajax({
                                    url: "<?=base_url('keys/infoKeys?barcode=')?>"+barcode,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data){
                                        if(data.status == "warning"){
                                            swal(data.title, data.message, data.status);
                                            setTimeout(function(){ location.reload(); }, 2000);
                                        } else {
                                            $('#nome').val(data[0].name_chave);
                                            $('#tipo_chave').val(data[0].type_name);
                                        }

                                    }
                                });

                            } else {
                                swal("Erro!", "Código de barras inválido", "warning");
                                setTimeout(function(){ location.reload(); }, 2000);
                            }
                        }
                    });
                    $("#cpf").blur(function(){
                        var cpf = $(this).val().replace(/\D/g, '');
                        if(cpf != ""){
                            var validator = /^([0-9]){3}([0-9]){3}([0-9]){3}([0-9]){2}$/;

                            if(validator.test(cpf)){
                                //Preenche os campos com "..." até achar os dados
                                $("#user_nome").val("Buscando...");
                                $("#telefone").val("Buscando...");

                                $.ajax({
                                    url: "<?=base_url('users/getUser?cpf=')?>"+cpf,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data){
                                        if(data.status == "warning"){
                                            swal("Erro", "Usuário não encontrado", "warning");
                                            setTimeout(function(){ location.reload(); }, 2000);
                                        } else {
                                            $('#user_nome').val(data[0].full_name);
                                            $('#telefone').val(data[0].phone1);
                                        }

                                    }
                                });

                            } else {
                                swal("Erro!", "CPF Inválido, Favor, verifique os dados inseridos", "warning");

                                setTimeout(function(){ location.reload(); }, 2000);
                            }
                        }
                    });
                    $("#barcodeEntrega").blur(function(){
                        var barcode = $(this).val().replace(/\D/g, '');
                        if(barcode != ""){
                            var validator = /^[0-9]{12}$/;

                            if(validator.test(barcode)){
                                $.ajax({
                                    url: "<?=base_url('request/getRequest?barcode=')?>"+barcode,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(data){
                                        if(data.status == "warning"){
                                            swal(data.title, data.message, data.status);
                                        } else {
                                            $('#nome').val(data[0].name_chave);
                                            $('#cpf').val(data[0].cpf);
                                            $('#username').val(data[0].full_name);
                                            $('#tipo_chave').val(data[0].type_name);
                                            $('#telefone').val(data[0].phone1);
                                        }
                                    }
                                });

                            }
                        }
                    });
                });



                /*
                Adiconar Chaves e Usuários de Requisição via AJAX
                Adiciona Requisições e entrega também
                 */
                $(document).ready(function () {

                    $("#addRequestUser").submit(function() {
                        event.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: "<?=base_url('keys/addRequestUser')?>",
                            data: $("#addRequestUser").serialize(),
                            success: function(data){
                                var veri=JSON.parse(data);
                                swal({
                                    title: veri.title,
                                    text: veri.message,
                                    type: veri.status

                                });
                                setTimeout(function(){ window.location.href = "<?=base_url('/dashboard');?>"; }, 3000);
                            }
                        });

                        return false;
                    });
                    $(".deleteRequestUser").click(function() {
                        var keyId = $(this).data('id');
                        event.preventDefault();

                        swal({
                            title: "Tem Certeza?",
                            text: "Uma vez deletado o registro não poderá ser restaurado!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Sim, Deletar",
                            closeOnConfirm: false
                        }, function (isConfirm) {
                            if(isConfirm){
                                $.ajax({
                                    type: "POST",
                                    url: "<?=base_url('/keys/deleteRequestUser/')?>"+keyId,
                                    data: $(".deleteKey").serialize(),
                                    success: function(data){
                                        var veri=JSON.parse(data);
                                        swal(veri.title, veri.message, veri.status);
                                        setTimeout(function(){ location.reload(); }, 2000);
                                    }
                                });
                            }
                        });


                        return false;
                    });

                    $("#addKey").submit(function() {
                        event.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: "<?=base_url('/keys/add')?>",
                            data: $("#addKey").serialize(),
                            success: function(data){
                                var veri=JSON.parse(data);
                                swal(veri.title, veri.message, veri.status);
                                $('#btn-acessar').addClass('disabled');
                                setTimeout(function(){ location.reload(); }, 2000);
                            }
                        });
                        return false;
                    });
                    $(".deleteKey").click(function() {
                        var keyId = $(this).data('id');
                        event.preventDefault();

                        swal({
                            title: "Tem Certeza?",
                            text: "Uma vez deletado o registro não poderá ser restaurado!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Sim, Deletar",
                            closeOnConfirm: false
                        }, function (isConfirm) {
                            if(isConfirm){
                                $.ajax({
                                    type: "POST",
                                    url: "<?=base_url('/keys/delete/')?>"+keyId,
                                    data: $(".deleteKey").serialize(),
                                    success: function(data){
                                        var veri=JSON.parse(data);
                                        swal(veri.title, veri.message, veri.status);
                                        setTimeout(function(){ location.reload(); }, 2000);
                                    }
                                });
                            }
                        });


                        return false;
                    });

                    $("#addRequest").submit(function() {
                        event.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: "<?=base_url('request/add')?>",
                            data: $("#addRequest").serialize(),
                            success: function(data){
                                var veri=JSON.parse(data);
                                swal({
                                    title: veri.title,
                                    text: veri.message,
                                    type: veri.status

                                });
                                setTimeout(function(){ window.location.href = "<?=base_url('/dashboard');?>"; }, 3000);
                            }
                        });

                        return false;
                    });
                    $("#devolver").submit(function() {
                        event.preventDefault();
                        $.ajax({
                            type: "POST",
                            url: "<?=base_url('request/givebk')?>",
                            data: $("#devolver").serialize(),
                            success: function(data){
                                var veri=JSON.parse(data);
                                swal(veri.title, veri.message, veri.status);
                                setTimeout(function(){ window.location.href = "<?=base_url('/dashboard');?>"; }, 3000);
                            }
                        });

                        return false;
                    });




                    /*
                    Setores
                     */
                    $("#addSector").submit(function() {
                        event.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: "<?=base_url('manage/addSector')?>",
                            data: $("#addSector").serialize(),
                            success: function(data){
                                var veri=JSON.parse(data);
                                swal({
                                    title: veri.title,
                                    text: veri.message,
                                    type: veri.status

                                });
                                setTimeout(function(){ window.location.href = "<?=base_url('/manage');?>"; }, 3000);
                            }
                        });

                        return false;
                    });
                    $(".deleteSector").click(function() {
                        var keyId = $(this).data('id');
                        event.preventDefault();

                        swal({
                            title: "Tem Certeza?",
                            text: "Uma vez deletado o registro não poderá ser restaurado!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Sim, Deletar",
                            closeOnConfirm: false
                        }, function (isConfirm) {
                            if(isConfirm){
                                $.ajax({
                                    type: "POST",
                                    url: "<?=base_url('/manage/delete/')?>"+keyId,
                                    data: $(".deleteKey").serialize(),
                                    success: function(data){
                                        var veri=JSON.parse(data);
                                        swal(veri.title, veri.message, veri.status);
                                        setTimeout(function(){ location.reload(); }, 2000);
                                    }
                                });
                            }
                        });


                        return false;
                    });

                });


                $(document).ready(function(){

                    $("#marcarTodos").change(function () {
                        $("input:checkbox").prop('checked', $(this).prop("checked"));
                    });

                });

                /*
                Notificação toastr
                 */
                $(document).ready(function() {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000
                        };
                        toastr.success('Sistema Gerenciador de Chaves', 'Bem vindo ao SGC');

                    }, 1300);

                });

                /*
                Gera Cartão em Jpeg
                 */
                document.getElementById('gerarCard').addEventListener('click', function() {
                    html2canvas(document.querySelector('.card'), {
                        onrendered: function(canvas) {
                            // document.body.appendChild(canvas);
                            return Canvas2Image.saveAsJPEG(canvas);
                        }
                    });
                });
            </script>


    </body>
    </html>
