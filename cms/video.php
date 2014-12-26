<?php
require_once "../entitymanager.php";

//recebe acao ( show/update/insert)
$acao = $_REQUEST['acao'];
$mensagem = "";

if ($acao == "show") {
    
    $idVideo = $_GET['idVideo']; //recebe o id da url
    $Video = $entityManager->find('Video', $idVideo);

    if ($Video === null) {
        $mensagem = "Vídeo não encontrado. :(";
    } else {
        $tituloVideo = $Video->getTitulo();
    }
    
    $acao = "update";
    
} elseif ($acao == "update") {
    
    $idVideo = $_POST['idVideo']; //recebe o id do formulario
    $Video = $entityManager->find('Video', $idVideo);
    
    if ($Video === null) {
        $mensagem = "Vídeo não encontrado. :(";
    } else {
        $tituloVideo = $_REQUEST['titulo']; //recebe novo titulo do formulario
        $product->setName($tituloVideo);
        $entityManager->flush(); //salva no banco
    }
    header("Location: ./videos.php");  //manda pra visualização de todos os vídeos  
    
} elseif ($acao == "insert") {

    $tituloVideo = $_REQUEST['titulo']; //titulo vindo do formulario

    $Video = new Video();
    $Video->setTitulo($tituloVideo);

    $entityManager->persist($Video); //persistencia (caso dê merda ele mantém os dados salvos)
    $entityManager->flush(); //salva no bd

    $mensagem = $Video->getTitulo()." foi adicionado aos vídeos.";
}

?>
<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title> Título da Página </title>
        </head>
    <body>
    <?php
    if($mensagem != ""){
    ?>
    <div class="alert success">
        <?=$mensagem?>
    </div>
    <?php
    }
    ?>
    <h1>Alterar Vídeo</h1>
    <h2><?=$tituloVideo?></h2>
    <form action="" method="post">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" value="<?=$tituloVideo?>">
        <input type="submit" value="Salvar">
        <input type="hidden" value="<?=$acao?>" name="acao">
        <input type="hidden" value="<?=$idVideo?>" name="idVideo">
    </form>
</body>
</html>