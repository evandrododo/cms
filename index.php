<?php
session_start();
require_once "./entitymanager.php";

$videoRepository = $entityManager->getRepository('Video');
$videos = $videoRepository->findAll();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="img/favicon-16.png" sizes="16x16">
    <link rel="icon" href="img/favicon-32.png" sizes="32x32">

    <title>Neurônio Produtora</title>

    <link rel="stylesheet" href="css/fertigopro_regular/stylesheet.css" type="text/css" charset="utf-8">
    
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    


	<!-- Add jQuery library --> <script src="plugins/jquery.min.js"></script>


	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="./plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="./plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="./plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="./plugins/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

  
  
</head>

<body>
    <div id="container"  >
        <?php
        $i = 0; //índice de quando deve colocar os vídeo de calção (que ficam atrás do logo)
        foreach ($videos as $Video) {
        ?>
        <a href="<?=$Video->getFonte()?>" class="fancybox-media">
          <div id="video<?=$Video->getId()?>" class="video" style="background-image:url('<?=$Video->getImg()?>');">
            <h2><?=$Video->getTitulo()?></h2>
          </div>
        </a>
        <?php
          if($i == 1)
            echo '<div class="video only-small"></div>  
                  <div class="video only-small"></div>
                  <div class="video only-small"></div>
                  <div class="video only-small"></div>';
          if($i == 2)
            echo '<div class="video only-medium"></div>  
                  <div class="video only-medium"></div>  
                  <div class="video only-medium"></div>   
                  <div class="video only-medium"></div>  
                  <div class="video only-medium"></div>   
                  <div class="video only-medium"></div>';
          if($i == 4 || $i == 6)
            echo '<div class="video only-big"></div>  
                  <div class="video only-big"></div>';
          $i++;

        }
        ?>
      
        <div class="video logo"><img src="/img/logo.png" alt="Neurônio Produtora">
      
      	<ul>
            <li><a class="fancybox-media" href="http://www.youtube.com/watch?v=opj24KnzrWo">Youtube</a></li>
            <li><a class="fancybox-media" href="http://vimeo.com/47480346">Vimeo</a></li>
            <li><a class="fancybox-media" href="http://www.metacafe.com/watch/7635964/">Metacafe</a></li>
            <li><a class="fancybox-media" href="http://www.dailymotion.com/video/xoeylt_electric-guest-this-head-i-hold_music">Dailymotion</a></li>
            <li><a class="fancybox-media" href="http://twitvid.com/QY7MD">Twitvid</a></li>
            <li><a class="fancybox-media" href="http://twitpic.com/7p93st">Twitpic</a></li>
            <li><a class="fancybox-media" href="http://instagr.am/p/IejkuUGxQn">Instagram</a></li>
        </ul>
        </div>
      
    </div>



	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			/*
			 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
			*/
			$('.fancybox-media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});


		});
	</script>
	<style type="text/css">
		.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
		}
	</style>
</body>

</html>
