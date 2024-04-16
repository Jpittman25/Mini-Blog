<?php
namespace App\src\controller;

// Démarrer la session au début du fichier
session_start();


use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;
use App\src\model\View;

class FrontController
{
    private $articleDAO;
    private $commentDAO;
    private $view;

    public function __construct()
    {
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
        $this->errorController = null; // Initialisation de $errorController
    }

    // Génère un token CSRF, le stocke dans la session utilisateur et le retourne
    public function generateCsrfToken() {
        $csrfToken = bin2hex(random_bytes(32)); // Génère un token aléatoire de 32 caractères

        // Stocke le token dans la session utilisateur
        $_SESSION['csrf_token'] = $csrfToken;

        return $csrfToken;
    }

    public function home()
    {
        $articles = $this->articleDAO->getArticles();
        return $this->view->render('home', ['articles' => $articles]);
    }

    public function article($articleId)
    {
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getComment($articleId);
        return $this->view->render('single', ['article' => $article, 'comments' => $comments]);
    }

    public function addComment($articleId, $pseudo, $content) {
        // Vérifie d'abord le token CSRF
        if (!$this->validateCommentData($articleId, $pseudo, $content) || !$this->validateCsrfToken()) {
            // Gestion de l'erreur si le token CSRF est invalide
            // Par exemple, rediriger vers une page d'erreur CSRF
            header('Location: ../public/error_csrf.php');
            exit;
        }
    
        $this->commentDAO->addComment($articleId, $pseudo, $content);
    
        // Rediriger vers l'article pour voir le commentaire ajouté
        header('Location: index.php?route=article&articleId=' . $articleId);
        exit;
    }
    

    // Méthode pour valider les données du commentaire
    public function validateCommentData($articleId, $pseudo, $content) {
        return !empty($pseudo) && !empty($content) && !empty($articleId) && $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Méthode pour valider le token CSRF
    public function validateCsrfToken() {
        if (!empty($_POST['csrf_token'])) {
            // Récupère le token CSRF stocké dans la session utilisateur
            $storedCsrfToken = $_SESSION['csrf_token'];

            // Récupère le token CSRF soumis dans le formulaire
            $submittedCsrfToken = $_POST['csrf_token'];

            // Compare les tokens pour vérifier s'ils correspondent
            if ($storedCsrfToken === $submittedCsrfToken) {
                // Les tokens correspondent, le formulaire est valide
                return true;
            } else {
                // Les tokens ne correspondent pas, probable attaque CSRF
                return false;
            }
        } else {
            // Le token CSRF est manquant dans les données POST
            return false;
        }
    }
}
?>
