<?php

namespace App\src\DAO;

use App\src\model\Comment;
use App\config\Parameter;
class CommentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setPseudo($row['pseudo']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['createdAt']);
        $comment->setArticleid($row['article_id']);

        return $comment;
    }

    public function getComment($commentId)
    {
        $sql = 'SELECT id, pseudo, content, createdAt, article_id FROM comment
WHERE article_id = ?';
        $result = $this->createQuery($sql, [$commentId]);
        $comments = [];
        while ($comment = $result->fetch()) {
            $comments [] = $this->buildObject($comment);
        };
        $result->closeCursor();
        return $comments;
    }

    public function addComment($articleId, $pseudo, $content)
    {
        $sql = 'INSERT INTO comment (pseudo, content, createdAt, article_id) VALUES (?, ?, NOW(), ?)';
        $this->createQuery($sql, [$pseudo, $content, $articleId]);
    }

}