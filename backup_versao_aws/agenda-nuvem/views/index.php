


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Agenda para Contatos em Nuvem</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src='http://code.jquery.com/jquery-latest.js'/>
    <script>
        $(document).ready(function(){
            var altura_tela = $(window).height();/*cria variável com valor do altura da janela*/   
            $("#bloco").height(altura_tela); /* aplica a variável a altura da div*/  
            $( window ).resize(function() { /*quando redimensionar a janela faz a mesma coisa */  
                var altura_tela = $(window).height();
                $("#bloco").height(altura_tela);
            });
        }); 
    </script>  
</head>

<body id="bloco" class="back-ini">


    <div class="container-fluid">
        <div class="row">


            <div class="col-md-11"></div>

            <div class="col-md-1 vertical-align">
                <center>
                <a href="new-contact.php" class="pulse-grow">
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                    <span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span><br />
                </a>
                </center>
            </div>

            
            <!-- Caixa de Login --><!--
            <div class="col-md-6 col-md-offset-3 caixaLogin">

                <!-- Parte superior da caixa de login--><!--
                <div class="col-md-12 cimaLogin">
                    <h3><center>SiGE - Sistema de Gerenciamento de Eventos</center></h3>
                    <center style="color:red;">
                    <?php
                    // show potential errors / feedback (from login object)
                    if (isset($login)) {
                        if ($login->errors) {
                            foreach ($login->errors as $error) {
                                echo $error;
                            }
                        }
                        if ($login->messages) {
                            foreach ($login->messages as $message) {
                                echo $message;
                            }
                        }
                    }
                    ?>
                    </center>
                    <br />
                </div>

                <!-- Parte central da caixa de login--><!--
                <div class="col-md-12 centroLogin">
                    <form method="post" action="index.php" name="loginform">

                        <div class="col-md-12 form-group">
                            <input id="login_input_username" class="login_input form-control input-lg" placeholder="CPF" type="text" name="user_name" required /> <!-- autocomplete="off" --><!--
                        </div>

                        <div class="col-md-8 form-group">
                            <input id="login_input_password" class="login_input form-control input-lg" placeholder="Senha" type="password" name="user_password" autocomplete="off" required />
                        </div>
                       
                        <div class="col-md-4">
                            <input type="submit" class="btn btn-primary btn-lg btn-success btn-block" name="login" value="Entrar" />
                        </div>

                    </form>
                </div>

                <div class="col-md-12 baixoLogin">
                    <center>
                        <a href="register.php"><span class="glyphicon glyphicon-pencil"></span> Inscreva-se</a>
                    </center>
                </div>

            </div>
            -->

        </div>

    </div>

</body>
</html>