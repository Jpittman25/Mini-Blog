<?php
use App\src\controller\FrontController;
/*
// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si le bouton "submit" a été cliqué et qu'il s'agit de "Ajouter"
    if (isset($_POST['submit']) && $_POST['submit'] === 'Ajouter') {
        // Assurez-vous d'avoir les données nécessaires ici
        $pseudo = isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : '';
        $content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
        $articleId = isset($_GET['articleId']) ? htmlspecialchars($_GET['articleId']) : '';

        // Instanciation du FrontController pour accéder à la méthode addComment
        $frontController = new FrontController();

        // Utilisation de la méthode pour valider les données du commentaire
        if ($frontController->validateCommentData($articleId, $pseudo, $content)) {
            $frontController->addComment($articleId, $pseudo, $content);

            // Redirection vers la même page pour voir le commentaire ajouté
            header("Location: {$_SERVER['PHP_SELF']}?articleId=$articleId");
            exit();
        } else {
            // Gérez le cas où des données sont manquantes
            echo "Veuillez remplir tous les champs du formulaire.";
        }
    }
}*/



$route = isset($post) && $post->get('id') ? 'editComment' : 'addComment';
$submit = $route === 'addComment' ? 'Ajouter' : 'Mettre à jour';
?>
<form action="../public/index.php?route=<?= $route; ?>&articleId=<?= htmlspecialchars($article->getId()) ?>"
      method="post">
    <label for="pseudo">
        <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo"
               value="<?= isset($post) ? htmlspecialchars($post->get('pseudo')) : ''; ?>" required>
    </label><br>
    <?= isset($errors['pseudo']) ? $errors['pseudo'] : ''; ?>
    <label for="content">
        <textarea name="content" id="content" cols="30" rows="10" placeholder="Votre commentaire"><?= isset($post) ? htmlspecialchars($post->get('content')): ''; ?> </textarea>
        <?= isset($errors['content']) ? $errors['content'] : ''; ?>
    </label><br>
    <input type="submit" value="<?= $submit; ?>" name="submit" id="submit">
</form>
