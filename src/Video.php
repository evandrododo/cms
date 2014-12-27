<?php
/**
 * @Entity @Table(name="videos")
 **/
class Video
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $titulo;
    /** @Column(type="string") **/
    protected $fonte;
    /** @Column(type="integer") **/
    protected ordem;

    public function getId()
    {
        return $this->id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getFonte()
    {
        return $this->fonte;
    }

    public function setFonte($fonte)
    {
        $this->fonte = $fonte;
    }
    
    public function getOrdem()
    {
        return $this->ordem;
    }

    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
    }
    
    public function getHTML($width = 1280, $height = 720)
    {
        if (preg_match("/youtu/i", $this->fonte)) {
            //Vídeo do Youtube
            //regexp que pega o id do video
            preg_match('/(http).?.?\/?\/?.*\/(?P<idVideo>\w+)/', $this->fonte, $matches);
            $idVideo = $matches['idVideo'];
            $html = "
            <div class='embed-container'>
                <iframe src='//www.youtube.com/embed/".$idVideo."' frameborder='0' allowfullscreen></iframe>
            </div>";
        } elseif (preg_match("/vimeo/i", $this->fonte)) {
            //Vídeo do Vimeo
            //regexp que pega o id do video
            preg_match('/(http).?.?\/?\/?.*\/(?P<idVideo>\w+)/', $this->fonte, $matches);
            $idVideo = $matches['idVideo'];
            $html = "
            <div class='embed-container'>
                <iframe src='//player.vimeo.com/video/".$idVideo."' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> <p><a href='http://vimeo.com/".$idVideo."'>".$this->titulo."</a> from <a href='http://vimeo.com/neuronio'>Neur&ocirc;nio Produtora</a> on <a href='https://vimeo.com'>Vimeo</a>.</p>
            </div>";
        } else {
            $html = "";
        }
        return $html;
    }
}