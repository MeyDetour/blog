<?php

namespace App\Entity;


use App\Repository\UserRepository;
use Core\Attributes\Table;
use Core\Attributes\TargetRepository;
use Core\Security\UserAuthentication;

#[TargetRepository(name:UserRepository::class)]
#[Table(name: 'users')]
class User extends UserAuthentication
{
    protected int $id;
    protected string $username;
    protected string $password;

    // Constructeur
    public function getAuthenticator()
    {
        return $this->getUsername();
    }

    // Getter pour l'id
    public function getId()
    {
        return $this->id;
    }

    // Getter et Setter pour le nom d'utilisateur (username)
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    // Getter et Setter pour le mot de passe (password)
    public function getPassword()
    {
        return $this->password;
    }


}

