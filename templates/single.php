<?php
//require '../vendor/autoload.php';
//require '../config/Autoloader.php';
//use \App\config\Autoloader;
//Autoloader::register();
//use App\src\DAO\ArticleDAO;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../public/css/style.css">
    <meta charset="utf-8">
    <title>Mon blog</title>
</head>
<body>
<div class="container">
    <?php $this->title = 'Article'; ?>
    <h1>Mon blog</h1>
    <p>En construction</p>
    <div>
        <h2><?= htmlspecialchars($article->getTitle()); ?></h2>
        <p><?= nl2br(htmlspecialchars($article->getContent())); ?></p>
        <p><?= htmlspecialchars($article->getAuthor()); ?></p>
        <p>Créé le : <?= htmlspecialchars($article->getCreatedAt()); ?></p>
    </div>
    <br>
    <div id="comments">
        <h2>Commentaires</h2>
        <?php
        foreach ($comments as $comment) {
            ?>
            <div class="comment">
                <h3><?= htmlspecialchars($comment->getPseudo()); ?></h3>
                <p><?= htmlspecialchars($comment->getContent()); ?></p>
                <p class="created-at">Ecrit le : <?= htmlspecialchars($comment->getCreatedAt()); ?></p>
            </div>
            <?php
        }
        ?>

        <h2>Ajouter un commentaire</h2>
        <?php include 'form_comment.php'; ?>
    </div>

    <br>
    <a href="../public/index.php" class="back-link">Retour à l'accueil</a>
</div>
</body>
</html>
