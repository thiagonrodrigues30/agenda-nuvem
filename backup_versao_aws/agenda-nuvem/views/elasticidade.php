<?php
    /*
    if($process->res == null)
    {
        $process->res = 0;
    }*/
?>

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
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--<link href="../css/hover-master/css/hover-min.css" rel="stylesheet" media="all">-->
    <script src="../css/sweetalert-master/dist/sweetalert.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="../css/sweetalert-master/dist/sweetalert.css">
</head>
<body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">Agenda</span>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li class="active">
                        <a href="#">
                            <i class="fa fa-sign-in"></i><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            Novo Contato
                        </a>
                    </li>
                    <li class="">
                        <a href="list-contacts.php">
                            <i class="fa fa-sign-in"></i><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                            Listar Contatos
                        </a>
                    </li>
                    <li class="">
                        <a href="search-contacts.php">
                            <i class="fa fa-sign-in"></i><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            Buscar Contato
                        </a>
                    </li>
                </ul>
                <!--
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="perfil.php">
                            <i class="fa fa-sign-in"></i><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <?php echo $_SESSION['user_fullname']; ?>
                        </a>
                    </li>
                    <li>
                        <a href="../index.php?logout">
                            <i class="fa fa-sign-in"></i><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                            Sair
                        </a>
                    </li>
                </ul>
                -->
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>


    <!-- Corpo do Site -->
    <div class="container-fluid" style="margin-top: 6em;">
        <div class="row"> 
                
            <div class="col-md-10 col-md-offset-1">

                <form action="elasticidade.php" name="form1" id="form1" method="POST" enctype="multipart/form-data">
                    
                    <center>
                        <input type="submit" value="Gerar Sobrecarga de Processamento" class="btn btn-primary" name="process" 
                        id="process" />
                    </center>

                </form>

            </div>

        </div>
    </div>



</body>
</html>