<?php
session_start();

    if($_REQUEST["login"]) {
        require_once "../entitymanager.php";

        $login = $_REQUEST['login'];
        $senha = $_REQUEST['senha'];

        $Usuario  = $entityManager->getRepository('Usuario')->findOneBy(array('login' => $login));
        
        if($Usuario) {
            $idUsuario = $Usuario->getId();
            //testa senha
            $senhaUsuario = $Usuario->getSenha();
            $salt = substr($senhaUsuario, 0, 12);
            if(crypt($senha,$salt) == $senhaUsuario) {
                $_SESSION['idUsuario'] = $idUsuario;
                header("Location: home.php");
            }else{
                $erro = 401;
            }
        } else {
            //Não encontrou o login, vai tentar pelo email
            $Usuario  = $entityManager->getRepository('Usuario')->findOneBy(array('email' => $login));
            if($Usuario) {            
                $idUsuario = $Usuario->getId();

                $senhaUsuario = $Usuario->getSenha();
                $salt = substr($senhaUsuario, 0, 12);
                if(crypt($senha,$salt) == $senhaUsuario) {
                    $_SESSION['idUsuario'] = $idUsuario;
                    header("Location: home.php");
                } else {
                    $erro = 401;
                }
            }else{
                $erro = 401;
            }
        }
        if($erro == 401) {
            //$session['msg'] = "Login ou senha incorretos!";
        }
    } elseif ($_REQUEST["logoff"]) {
        unset($_SESSION['idUsuario']);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="../img/favicon-tesseract-16.png" sizes="16x16">
    <link rel="icon" href="../img/favicon-tesseract-32.png" sizes="32x32">

    <title>Neurônio Produtora [CMS] - Faça login</title>

    <!-- Bootstrap core CSS -->
    <link href="../plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <div class="container">
        <?php
        if($erro == 401) {
        ?>
            <div class="alert alert-danger" role="alert">
                Login ou senha incorretos!
            </div>
        <?php
        }
        ?>
        <form class="form-signin" method="post">
            <h2 class="form-signin-heading">Olá :)</h2>
            <label for="login" class="sr-only">Usuário ou E-mail</label>
            <input type="user" id="login" name="login" class="form-control" placeholder="Usuário ou E-mail" required autofocus>
            <label for="senha" class="sr-only">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
        </form>

    </div>
    <!-- /container -->

</body>

</html>
