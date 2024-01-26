<?php

namespace App\Repository;

use App\Entity\Article;
use Core\Attributes\TargetEntity;
use Core\Repository\Repository;

#[TargetEntity(name: Article::class)]
class ArticleRepository extends Repository
{
    public function save(Article $article)
    {
        $query = $this->pdo->prepare("INSERT INTO $this->tableName SET titre = :titre , content = :content , user_id = :userId");
        $query->execute([
            "titre" => $article->getTitre(),
            "content" => $article->getContent(),
            "userId" => $article->getUserId(),
        ]);
        return $this->find($this->pdo->lastInsertId());
    }
    public function update(Article $article)
    {
        $query = $this->pdo->prepare("UPDATE $this->tableName SET titre = :titre , content = :content  WHERE id = :id");
        $query->execute([
            "titre" => $article->getTitre(),
            "content" => $article->getContent(),
            "id" => $article->getId(),
        ]);
        return $this->find($this->pdo->lastInsertId());
    }

}