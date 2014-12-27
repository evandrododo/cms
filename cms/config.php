<?php
session_start();
if(isset($_SESSION['idUsuario'])) {
    require_once "../entitymanager.php";
    $Usuario = $entityManager->find('Usuario', $_SESSION['idUsuario']);
    if(!$Usuario){
        header('Location: ./index.php');
        exit();
    }
} else {
    header('Location: ./index.php');
    exit();
}
    

//recebe acao ( show/update/insert)
$acao = $_REQUEST['acao'] ? $_REQUEST['acao'] : "";
$mensagem = "";
if ($acao == "show" || $acao == "") {
    
    $Config = $entityManager->find('Config',1); //pega o primeiro registro (ta feio, da pra melhorar isso rs)

    if ($Config === null) {
        $mensagem = "Dados não encontrados, insira os dados referentes ao site. <br>
                    Enviamos o erro para ser analisado por nossos satélites.";
    } else {
        $emailContato = $Config->getEmailContato();
        $facebook = $Config->getFacebook();
        $telefone = $Config->getTelefone();

        $acao = "update";
        $subtitulo = "Alterar Dados";
    }
} elseif ($acao == "update") {
    
    $Config = $entityManager->find('Config',1); //pega o primeiro registro (ta feio, da pra melhorar isso rs)

    if ($Config === null) {
        $mensagem = "Os dados antigos não foram encontrados para serem atualizados.<br>
                    O Erro foi enviado para a Central Espacial de Processamento de Erros.";
    } else {
        $emailContato = $_REQUEST['emailContato']; 
        $facebook = $_REQUEST['facebook'];
        $telefone = $_REQUEST['telefone'];

        $Config->setEmailContato($emailContato);
        $Config->setFacebook($facebook);
        $Config->setTelefone($telefone);

        $entityManager->flush(); //salva no banco
        
        $subtitulo = "Alterar Dados";

    }
} elseif ($acao == "insert") {

    $emailContato = $_REQUEST['emailContato']; 
    $facebook = $_REQUEST['facebook'];
    $telefone = $_REQUEST['telefone'];

    $Config = new Config();
    $Config->setEmailContato($emailContato);
    $Config->setFacebook($facebook);
    $Config->setTelefone($telefone);

    $entityManager->persist($Config); //persistencia (caso dê merda ele mantém os dados salvos)
    $entityManager->flush(); //salva no bd

    $mensagem = "Configurações do site inseridas com cuidado e carinho. <3";
    $subtitulo = "Alterar Configurações";
    
    $acao = "update";
}

//Se chegou até aqui sem uma ação, nenhum dado foi encontrado
//Se o form for submetido vai inserir uma row com os dados de contato
if($acao == "") {
    $acao = "insert";
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/responsivevideo.css">
        
        <!-- Bootstrap -->
        <link href="../plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <link rel="icon" href="../img/favicon-16.png" sizes="16x16">
        <link rel="icon" href="../img/favicon-32.png" sizes="32x32">
        
        <title> Neurônio Produtora - [CMS] <?=$subtitulo?></title>

        </head>
    <body>
        <div class="container ">
        
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="home.php">
                        <i class="glyphicon glyphicon-th" aria-hidden="true"></i>
                        CMS
                    </a>
                  </div>
                  <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                          <a href="videos.php">
                            <span class="glyphicon glyphicon-film" aria-hidden="true"></span>
                            Vídeos
                          </a>
                        </li>
                        <li class="">
                          <a href="video.php">
                              <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                              Adicionar Vídeo
                          </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                      <li class="active"><a href="config.php">
                          <i class="glyphicon glyphicon-cog" aria-hidden="true"></i>
                          Configurações</a></li>
                      <li class=""><a href="index.php?logoff=true">
                          <i class="glyphicon glyphicon-off" aria-hidden="true"></i>
                          Logout</a></li>
                    </ul>
                  </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
            
            <div class="jumbotron row">
                <?php
                if($mensagem != ""){
                ?>
                <div class="alert success">
                    <?=$mensagem?>
                </div>
                <?php
                }
                ?>
                <h1>Configurações</h1>
                <h2><?=$subtitulo?></h2>
                
                
                
                <form action="" method="post" class="col-md-12">
                    <div class="row form-group">
                        <label class="col-md-4" for="emailContato">Email Contato</label>
                        <input class="col-md-8 form-control" type="text" name="emailContato" id="emailContato" value="<?=$emailContato?>" required>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4" for="facebook">Página do facebook</label>
                        <input class="col-md-8 form-control" type="text" name="facebook" id="facebook" value="<?=$facebook?>" required>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4" for="telefone">Telefone para Contato</label>
                        <input class="col-md-8 form-control" type="text" name="telefone" id="telefone" value="<?=$telefone?>" required>
                    </div>
                    <div class="row">
                        <input type="submit" value="Salvar" class="pull-right btn btn-primary">
                        <input type="hidden" value="<?=$acao?>" name="acao">
                    </div>
                </form>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>