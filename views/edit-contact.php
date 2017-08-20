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
                            <i class="fa fa-sign-in"></i><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            Editar Contato
                        </a>
                    </li>
                    <!--
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

                <form action="edit-contact.php" name="form1" id="form1" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <?php
                            // show potential errors / feedback (from registration object)
                            if (isset($edit)) {
                                if ($edit->errors) {
                                    foreach ($edit->errors as $error) {
                                        echo '<div class="alert alert-warning" role="alert">'. $error .'</div>';
                                    }
                                }
                            }
                        ?>

                        <h3>Editar Contato</h3>

                        <HR width="100%" align="center" class="line" noshade/>

                        <div class="form-group">
                            <label for="name">Nome Completo:</label><br/>
                            <input class="form-control" type="text" id="name" name="name" value="<?php echo $edit->contactsList['name']; ?>" pattern="[a-zA-Z\s]{2,64}" required title="Apenas letras e espaços. Caracteres especiais e acentos não são aceitos"/><br/>
                        </div>

                        <div class="form-group">
                            <label for="nickname">Apelido:</label><br/>
                            <input class="form-control" type="text" id="nickname" name="nickname" pattern="[a-zA-Z\s]{2,64}" required value="<?php echo $edit->contactsList['nickname']; ?>" title="Apenas letras e espaços. Caracteres especiais e acentos não são aceitos"/><br/>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label><br/>
                            <input class="form-control" type="text" id="email" name="email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php echo $edit->contactsList['email']; ?>" placeholder="email@example.com" title="email@example.com" required/><br/>
                        </div>

                        <div class="form-group">
                            <label for="telephone">Telefone para contato:</label><br/>
                            <input class="form-control" type="text" id="telephone" value="<?php echo $edit->contactsList['telephone']; ?>" name="telephone"  pattern="{6,15}" required/><br/>
                        </div>

                        <div class="form-group">
                            <label for="day">Data de aniversário:</label><br/>
                            <input class="form-control date-config" type="text" id="day" name="day" pattern="[0-9]{2,2}" placeholder="Dia" value="<?php echo date('d', strtotime($edit->contactsList['date'])); ?>" title="Dois números" required/>
                            <input class="form-control date-config" type="text" id="month" name="month" pattern="[0-9]{2,2}" placeholder="Mês" value="<?php echo date('m', strtotime($edit->contactsList['date'])); ?>" title="Dois números" required/>
                            <input class="form-control date-config" type="text" id="year" pattern="[0-9]{4,4}" name="year" placeholder="Ano" title="Quatro números" />
                        </div>

                        <div class="form-group" id="declaracao_socio_form">
                            <label for="photo">Foto Pessoal: Selecione uma nova foto caso deseje alterar a atual</label>
                            <input  class="form-control" type="file" id="photo" name="photo" /><br />
                        </div>

                        <input type="hidden" name="id" value="<?php echo $edit->contactsList['id']; ?>" />


                        <!--Botões-->
                        <div class="col-md-12">

                            <center>
                                <br />
                                <div class="col-md-4"></div>

                                <div class="col-md-2" >
                                <!--<input type="reset" class="btn btn-warning btn-size1" value="Limpar" />-->
                                <a href="new-contact.php" class="btn btn-warning btn-size1" >Cancelar</a>
                                </div>

                                <div class="col-md-2" >
                                <input type="submit" class="btn btn-primary btn-size1" name="edit" id="edit" value="Salvar" />
                                </div>

                                <div class="col-md-4"></div>
                            </center>

                        </div>

                    </fieldset>

                </form><br /><br />


            </div>

        </div>
    </div>



</body>
</html>