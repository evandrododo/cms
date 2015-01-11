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
    
    if($_GET['delete']) {
        $idVideo = $_GET['delete'];
        $Video = $entityManager->find('Video', $idVideo);
        $entityManager->remove($Video);
        $entityManager->flush();
    }

    $videoRepository = $entityManager->getRepository('Video');
    $videos = $videoRepository->findAll();
    
$mensagem = "";
?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        
        <!-- Bootstrap -->
        <link href="../plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <link rel="icon" href="../img/favicon-tesseract-16.png" sizes="16x16">
        <link rel="icon" href="../img/favicon-tesseract-32.png" sizes="32x32">
        
        <title> Neurônio Produtora - [CMS] Listar Vídeos </title>
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
                    <li class="active">
                      <a href="videos.php">
                        <span class="glyphicon glyphicon-film" aria-hidden="true"></span>
                        Vídeos
                      </a>
                    </li>
                    <li>
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
            <h1>Vídeos Cadastrados</h1>
            <?php
            if($mensagem != ""){
            ?>
            <div class="alert success">
                <?=$mensagem?>
            </div>
            <?php
            }
            ?>

            
            <div class="col-md-12">
                <table class="table table-striped">
                <thead>
                    <tr>
                    <th>Título</th>
                    <th>Link</th>
                    <th>Fonte</th>
                    <th><i class="glyphicon glyphicon-cog" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($videos as $Video) {
                ?>
                <tr>
                    <td>
                        <a href="./video.php?acao=show&idVideo=<?=$Video->getId()?>"><?=$Video->getTitulo()?></a>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <a href="videos.php?delete=<?=$Video->getId()?>">
                            <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                    <?php
                }
                    ?>
                <tr></tr>
            </tbody>
        </table>
    </div>

</div>
            </div>
        </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../plugins/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>