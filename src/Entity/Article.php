<?php

namespace App\Entity;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Core\Attributes\Table;
use Core\Attributes\TargetEntity;

#[TargetEntity(name:ArticleRepository::class)]
#[Table(name:'articles')]
class Article
{

    private $id;
    private $titre;
    private $content;
    private $user_id;
public function getAuthor(){
    $repo = new UserRepository();
    return $repo->find($this->user_id);
}
    public function getComments(){
        $repo = new CommentRepository();
        return $repo->findByArticleId($this->id);
    }
    // Getter pour l'id
    public function getId() {
        return $this->id;
    }

    // Getter et Setter pour le titre
    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    // Getter et Setter pour le contenu
    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    // Getter et Setter pour l'user_id
    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }


}