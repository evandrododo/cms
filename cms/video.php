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
$tituloVideo = "";
if ($acao == "show") {
    
    $idVideo = $_GET['idVideo']; //recebe o id da url
    $Video = $entityManager->find('Video', $idVideo);

    if ($Video === null) {
        $mensagem = "Vídeo não encontrado. :(";
    } else {
        $tituloVideo = $Video->getTitulo();
        $fonteVideo = $Video->getFonte();
        $html = $Video->getHTML();

    }
    
    $acao = "update";
    $subtitulo = "Alterar Vídeo";
    
} elseif ($acao == "update") {
    
    $idVideo = $_POST['idVideo']; //recebe o id do formulario
    $Video = $entityManager->find('Video', $idVideo);
    
    if ($Video === null) {
        $mensagem = "Vídeo não encontrado. :(";
    } else {
        $tituloVideo = $_REQUEST['titulo']; //recebe novo titulo do formulario
        $fonteVideo = $_REQUEST['fonte'];  //recebe nova fonte do formulario

        $Video->setTitulo($tituloVideo);
        $Video->setFonte($fonteVideo);

        $html = $Video->getHTML();
        $entityManager->flush(); //salva no banco
    }
    header("Location: ./videos.php");  //manda pra visualização de todos os vídeos  
    
} elseif ($acao == "insert") {

    $tituloVideo = $_REQUEST['titulo']; //titulo vindo do formulario
    $fonteVideo = $_REQUEST['fonte'];  //recebe nova fonte do formulario


    $Video = new Video();
    $Video->setTitulo($tituloVideo);
    $Video->setFonte($fonteVideo);

    $html = $Video->getHTML();

    $entityManager->persist($Video); //persistencia (caso dê merda ele mantém os dados salvos)
    $entityManager->flush(); //salva no bd

    $mensagem = $Video->getTitulo()." foi adicionado aos vídeos.";
    $subtitulo = "Alterar Vídeo";

} elseif ($acao == "") { //veio sem acao, inserir um novo vídeo
    $acao = "insert";
    $subtitulo = "Insira os dados do Vídeo";

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
        
        <link rel="icon" href="../img/favicon-tesseract-16.png" sizes="16x16">
        <link rel="icon" href="../img/favicon-tesseract-32.png" sizes="32x32">
        
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
                        <li class="<?=$acao == "insert"?'active':''?>">
                          <a href="video.php">
                              <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                              Adicionar Vídeo
                          </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                      <li class=""><a href="config.php">
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
                <h1><?=$tituloVideo?></h1>
                <h2><?=$subtitulo?></h2>
                
                
                <div class="col-md-6">
                    <?=$html?>
                </div>
                
                <form action="" method="post" class="col-md-6">
                    <div class="row form-group">
                        <label class="col-md-4" for="titulo">Título</label>
                        <input class="col-md-8 form-control" type="text" name="titulo" id="titulo" value="<?=$tituloVideo?>" required>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4" for="fonte">Link do Vídeo</label>
                        <input class="col-md-8 form-control" type="text" name="fonte" id="fonte" value="<?=$fonteVideo?>" required>
                    </div>
                    <div class="row">
                        <input type="submit" value="Salvar" class="pull-right btn btn-primary">
                        <input type="hidden" value="<?=$acao?>" name="acao">
                        <input type="hidden" value="<?=$idVideo?>" name="idVideo">
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