<?php

namespace App\Repository;
use App\Entity\Article;
use App\Entity\Comment;
use Core\Attributes\TargetEntity;
use Core\Repository\Repository;
use Core\Session\Session;

#[TargetEntity(name:Comment::class)]
class CommentRepository extends Repository
{
    public function findByArticleId($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->tableName WHERE article_id = :id");
        $query->execute([
            'id'=>$id
        ]);
       return $query->fetchAll(\PDO::FETCH_CLASS,get_class(new $this->targetEntity()));
    }
    public function save(Comment $comment)
    {
        $query = $this->pdo->prepare("INSERT INTO $this->tableName SET content = :content , article_id = :articleId , user_id = :userId");
        $query->execute([
            "content" => $comment->getContent(),
            "articleId" => $comment->getArticleId(),
            "userId" => $comment->getUserId(),
        ]);

    }


}