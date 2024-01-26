<?php

namespace App\Repository;

use App\Entity\User;
use Core\Attributes\TargetEntity;
use Core\Repository\Repository;

#[TargetEntity(name: User::class)]
class UserRepository extends Repository
{
    public function findByUsername($username)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->tableName WHERE username = :username");
        $query->execute(['username' => $username]);
        $query->setFetchMode(\PDO::FETCH_CLASS,get_class(new $this->targetEntity()));

        return $query->fetch();
    }

    public function save($user)
    {
        $query = $this->pdo->prepare("INSERT INTO $this->tableName SET username = :username , password = :password");
        $query->execute(['username'=>$user->getUsername(),"password"=>$user->getPassword()]);
    }

}