<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Agenda para Contatos em Nuvem</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <!--<link rel="stylesheet" href="css/bootstrap-responsive.css" />-->
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--<link href="../css/hover-master/css/hover-min.css" rel="stylesheet" media="all">-->
    <script src="css/sweetalert-master/dist/sweetalert.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="css/sweetalert-master/dist/sweetalert.css">
    <script language="javascript" type="text/javascript">
        var gId = "1";

        function deleteCont(id)
        {
            gId = id;
            mostrarAviso();
            //window.location = "delete-contact.php?source=search&id=" + id
        }

        function editCont(id)
        {
            gId = id;
            mostrarAvisoEdit();
            //window.location = "delete-contact.php?source=search&id=" + id
        }

        function mostrarAviso()
        {
            swal({   
                title: "Deletar esse contato?",   
                text: "Você não será capaz de recuperar esse contato!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Sim, quero deletar!",   
                closeOnConfirm: false }, 
                function(){ 
                    window.location = "delete-contact.php?source=list&id=" + gId; 
                    });
        }

        function mostrarAvisoEdit()
        {
            swal({   
                title: "Alterar esse contato?",     
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Sim, quero alterar!",   
                closeOnConfirm: false }, 
                function(){ 
                    window.location = "edit-contact.php?id=" + gId; 
                    });
        }
    </script>
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
                    <li class="">
                        <a href="new-contact.php">
                            <i class="fa fa-sign-in"></i><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            Novo Contato
                        </a>
                    </li>
                    <li class="active">
                        <a href="#">
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
                <?php
                    // show potential errors / feedback (from registration object)
                    if (isset($list)) {
                        if ($list->errors) {
                            foreach ($list->errors as $error) {
                                echo '<div class="alert alert-warning" role="alert">'. $error .'</div>';
                            }
                        }
                    }
                ?>
                
                <h3>Listar Contatos</h3>

                <HR width="100%" align="center" class="line" noshade/>
                <!--<center><p><?php echo $list->time . " milisegundos"; ?></p></center>-->

                <?php if($list->numContacts == 0){ ?>

                    <center><p>Não há nenhum contato salvo</p></center>

                <?php } else { foreach($list->contactsList as $contact): ?>
                    
                    <div class="col-md-12">

                        <div class="col-md-3">
                            <img class="contact-img-size" src="<?php echo $contact['photo_url']; ?>" alt=""><br /><br />
                        </div>

                        <div class="col-md-7">
                            <h4><?php echo $contact['name']; ?></h4>
                            <p><span class="glyphicon glyphicon-user"></span>  <?php echo $contact['nickname']; ?></p>
                            <p><span class="glyphicon glyphicon-envelope"></span>  <?php echo $contact['email']; ?></p>
                            <p><span class="glyphicon glyphicon-earphone"></span>  <?php echo $contact['telephone']; ?></p>
                            <p><span class="glyphicon glyphicon-gift"></span>  <?php echo date('d/m', strtotime($contact['date'])); ?></p>
                        </div>

                        <div class="col-md-2">
                            <a href="#" onclick="editCont(<?php echo $contact['id']; ?>)" class="btn btn-primary" title="Alterar"><span class="glyphicon glyphicon-pencil big-icon"></span></a>
                            <a href="#" onclick="deleteCont(<?php echo $contact['id']; ?>)" class="btn btn-primary" title="Excluir"><span class="glyphicon glyphicon-trash big-icon"></span></a>
                        </div>

                    </div>

                    <HR width="100%" align="center" class="line" noshade/>

                <?php endforeach; } ?>

            </div>
            
        </div>
    </div>



</body>
</html>