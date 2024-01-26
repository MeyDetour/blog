<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Core\Attributes\Table;
use Core\Attributes\TargetEntity;

#[TargetEntity(name:CommentRepository::class)]
#[Table(name:'comments')]
class Comment
{

    private $id;
    private $user_id;
    private $content;
    private $article_id;


public function getAuthor(){
    $repo = new UserRepository();
    return $repo->find($this->user_id);

}
    // Getter pour l'id
    public function getId() {
        return $this->id;
    }

    // Getter et Setter pour user_id
    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    // Getter et Setter pour content
    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->article_id;
    }

    /**
     * @param mixed $article_id
     */
    public function setArticleId($article_id): void
    {
        $this->article_id = $article_id;
    }


}