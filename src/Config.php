<?php
/**
 * @Entity @Table(name="configs")
 **/
class Config
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $emailContato;
    /** @Column(type="string") **/
    protected $facebook;
    /** @Column(type="string") **/
    protected $telefone;

    public function getId()
    {
        return $this->id;
    }

    public function getEmailContato()
    {
        return $this->emailContato;
    }

    public function setEmailContato($emailContato)
    {
        $this->emailContato = $emailContato;
    }
    
    public function getFacebook()
    {
        return $this->facebook;
    }

    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }
    
    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }
}