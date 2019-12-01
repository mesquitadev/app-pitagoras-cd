<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Faculdade Pitágoras - SGC| Login</title>

    <link href="<?=base_url('/assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('/assets/font-awesome/css/font-awesome.css')?>" rel="stylesheet">

    <link href="<?=base_url('/assets/css/animate.css')?>" rel="stylesheet">
    <link href="<?=base_url('/assets/css/style.css')?>" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="<?=base_url('/assets/css/plugins/sweetalert/sweetalert.css')?>" rel="stylesheet">

</head>

<body class="gray-bg" style=" margin-top: -60px;">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">SGC+</h1>

        </div>
        <h3>Bem vindo ao Sistema de Gerenciamento de Chaves | Faculdade Pitágoras</h3>
        <div class="col-md-12">

        </div>
        <form class="m-t" role="form" id="formLogin" action="<?=base_url('auth/login')?>" method="POST">
            <?php if ($this->session->flashdata('error') != null) {?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $this->session->flashdata('error');?>
                </div>
            <?php }?>

            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite o Email..." >
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Digite a Senha..." >
            </div>

            <button id="btn-acessar" class="btn btn-primary block full-width m-b">Entrar no Sistema</button>

            <a href="<?=base_url('/auth/forgot-password')?>"><small>Esqueceu a Senha?</small></a>
        </form>
        <p class="m-t"> <small>SGC - Faculdade Pitágoras &copy; 2018 - Todos os direitos Reservados.</small> | Desenvolvido pelo ESC</p>
    </div>
</div>

<!-- Sweet alert -->
<script src="<?=base_url('assets/js/plugins/sweetalert/sweetalert.min.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery-1.10.2.min.js')?>"></script>
<script src="<?php echo base_url('/assets/js/validate.js')?>"></script>


<script type="text/javascript">
    $(document).ready(function(){

        $('#email').focus();
        $("#formLogin").validate({
            rules :{
                email: { required: true, email: true},
                password: { required: true}
            },
            messages:{
                email: { required: 'Campo Requerido.', email: 'Insira Email válido'},
                password: {required: 'Campo Requerido.'}
            },
            submitHandler: function( form ){
                var dados = $( form ).serialize();

                $('#btn-acessar').addClass('disabled');

                $.ajax({
                    type: "POST",
                    url: "<?=base_url('auth/login?ajax=true');?>",
                    data: dados,
                    dataType: 'json',
                    success: function(data)
                    {

                        if(data.result == true){
                            window.location.href = "<?=base_url('dashboard');?>";
                        }
                        else{
                            swal({
                                title: "Erro!",
                                text: data.message,
                                type: data.status,
                                confirmButtonColor: "#DD6B55",
                                closeOnConfirm: false
                            });

                            $('#btn-acessar').removeClass('disabled');
                        }
                    }
                });

                return false;
            }
        });

    });

</script>
