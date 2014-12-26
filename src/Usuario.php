<?php
/**
 * @Entity @Table(name="usuarios")
 **/
class Usuario
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $login;
    /** @Column(type="string") **/
    protected $email;
    /** @Column(type="string") **/
    protected $senha;

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }
    
    public function getEmai()
    {
        return $this->email;
    }

    public function setEmai($email)
    {
        $this->email = $email;
    }
    
    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }
}