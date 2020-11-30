<?php
/****************************************CONTROLLER/BACKEND/CONTROLLER.PHP****************************************/


namespace Bosongo\Blog_Forteroche\Controller;

require_once('core/Autoloader.php');
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/MemberManager.php');
require_once('model/AdminManager.php');
require_once('model/ReportManager.php');
require_once('class/Helper.php');

// We charge classes 

use \Bosongo\Blog_Forteroche\Controller\ControllerHelper;
use \Bosongo\Blog_Forteroche\Model\AdminManager;
use \Bosongo\Blog_Forteroche\Model\PostManager;
use \Bosongo\Blog_Forteroche\Model\CommentManager;
use \Bosongo\Blog_Forteroche\Model\MemberManager;
use \Bosongo\Blog_Forteroche\Model\ReportManager;
use \Bosongo\Blog_Forteroche\Core\Autoloader;
use \Bosongo\Blog_Forteroche\Classes\Helper;



Autoloader::register();


class BackendController
{
        /**
         * member
         *
         * @param  string $log We call this function wich allowed us to get a admin
         *
         * @return $admin
         */
        

public function __construct() {

    $helper;
    
    $helper = new Helper();

}
    
    // Authentification de l'admin
     function auth($pseudo) {
        $adminManager = new AdminManager();
        $admin = $adminManager->getPseudo($pseudo);
        
        // Vérification du mot de passe saisi en le comparant à la base de donnée
        $pass_true = password_verify($_POST['pseudo'], $admin['pass']);

        if (!$admin) {
            header('Location: index.php?action=listPost');
        } else {
            if ($pass_true) {
                $_SESSION['id'] = $admin['id'];
                $_SESSION['pseudo'] = $pseudo;
                header('Location: index.php?action=admin');
            } 
        }
    
   
    // Accès à la page profil si l'utilisateur est connecté
    function admin(){

        $postsManager = new PostManager();
        $commentManager = new CommentManager();        
        $reportManager = new ReportManager();

        $post = $postManager->getPost();
        $comments = $commentManager->lastPostAndComments();

        $numberReport = $reportManager->numberReports();
        $numberComment = $commentManager->numberComment();
        $numberPosts =$postManager->numberPost();
        
        require('views/backend/AdminView.php');
    }

    function verifyAdmin()
    {
        $adminManager = new AdminManager();
        $loginAdmin = htmlspecialchars($_POST['login']);
        $passAdmin = htmlspecialchars($_POST['pass']);

        if(isset($_POST['submit']))
        {
            if(!empty($loginAdmin) AND !empty($passAdmin))
            {
                $verifyAdmin = $adminManager->getAdmin($loginAdmin);
                $isPasswordCorrect = password_verify($passAdmin, $verifyAdmin['password']);
                $right = true;  
                
               // if($verifyAdmin['pseudo'] ==='admin' AND $isPasswordCorrect === 'babaro211')
                //{

                    if($verifyAdmin['login'] == $loginAdmin AND $isPasswordCorrect === $right){
                    session_start();
                    $result = $this->admin($loginAdmin);
                    $_SESSION['loginSession'] = $result['log'];
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['registration_date'] = $result['registration_date'];

                    header('location: index.php?action=admin');
                }
                else
                {

                    
                    $errorMessage = '<div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Mauvais mot de passe ou pseudo inconnu
                                    </div>';
                    require('views/backend/adminConnexionView.php');
                }
            }
            else
            {
                $errorMessage = '<div class="alert alert-warning" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Veuillez renseignez tout les champs
                                    </div>';
                                    require('views/backend/adminConnexionView.php');
            }
        }
        else
        {
            $errorMessage = '<p>Formulaire n\'a pas été envoyé</p>';
            require('views/backend/adminConnexionView.php');
        }
    }
}

    function adminDashboard()
    {
        $postManager = new PostManager();
        $commentManager = new CommentManager();
        $memberManager = new MemberManager();
        $backendController = new BackendController();

        $memberNumber = $memberManager->countMembers();
        $postNumber = $postManager->countPosts();
        $reportedComNumber = $commentManager->countReportedComment();
        
        $totalMemberReq = $memberManager->numberOfMembers();
        $totalMember = $totalMemberReq['total'];
        $memberPerPage = 4;
        
        $totalPage = ceil($totalMember / $memberPerPage);
        
        if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalPage)
        {
            $_GET['page'] = intval($_GET['page']);
            $currentPage = $_GET['page'];
        }
        else
        {
            $currentPage = 1;
        }

        $start = ($currentPage - 1) * $memberPerPage;

        $members = $memberManager->getLastMembers($start, $memberPerPage);
        
        require('views/backend/adminUsersView.php');
    }

    function updatePost()
        {
            $postManager = new PostManager();
            $commentManager = new CommentManager();
            $memberManager = new MemberManager();

            $chapter = $_POST['newChapter'];
            $title = htmlspecialchars($_POST['newTitle']);
            $content = $_POST['newContent'];
            $postId = $_GET['id'];
            
            if(isset($postId))
            {
                if(isset($_POST['edit']))
                {
                    if(!empty($chapter) && !empty($title) && !empty($content))
                    {
                        $postManager->editPost($chapter, $title, $content, $postId);
                        $succesMessage = '<div class="alert alert-success" role="alert">
                        Chapitre modifié avec succès !
                        </div>';
                        header('Location: index.php?action=adminArticle');
                    }
                    else
                    {
                        $errorMessage ='<div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        Vous devez remplir tout les champs
                        </div>';

                        $post = $postManager->getPost($postId);
                        $memberNumber = $memberManager->countMembers();
                        $postNumber = $postManager->countPosts();
                        $reportedComNumber = $commentManager->countReportedComment();

                        require('views/backend/adminEditView.php');
                    }
                }
                
                elseif(isset($_POST['delete']))
                {
                    $postManager->deletePost($postId);
                    $succesMessage = '<div class="alert alert-success" role="alert">
                                    Chapitre bien supprimé !
                                    </div>';
                                    
                    $memberNumber = $memberManager->countMembers();
                    $postNumber = $postManager->countPosts();
                    $reportedComNumber = $commentManager->countReportedComment();
                    require('views/backend/adminCreateView.php');
                } 
            }
            else
            {
                $errorMessage = 'Cette page n\'existe pas';
                require('views/errorView.php');
            }
        }
        function listPostsAdmin()
        {
            $postManager = new PostManager();
            $commentManager = new CommentManager();
            $memberManager = new MemberManager();
    
            $memberNumber = $memberManager->countMembers();
            $postNumber = $postManager->countPosts();
            $reportedComNumber = $commentManager->countReportedComment();

            $totalPostReq = $postManager->numberPost();
            $totalPost = $totalPostReq['total'];
            $postPerPage = 6;
            
            $totalPage = ceil($totalPost / $postPerPage);
            
            if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalPage)
            {
                $_GET['page'] = intval($_GET['page']);
                $currentPage = $_GET['page'];
            }
            else
            {
                $currentPage = 1;
            }

            $start = ($currentPage - 1) * $postPerPage;

            $posts = $postManager->getPostsAdmin($start, $postPerPage); 
            
            require('views/backend/adminArticlesView.php');
        }
    // ---------------------------------------------------------------------

    // Accès à la page 'gestion' des Chapitres
     function post() {
        $postManager = new PostsManager();
        $post = $postManager->totalPosts();

        require('view/backend/AdminArticlesView.php');
    }



    function newPost()
    {
        $postManager = new PostManager();
       
        $newTitle = htmlspecialchars($_POST['title']);
        $newChapter = htmlspecialchars($_POST['chapter']);
        $newContent = $_POST['content'];

        if(isset($_POST['submit']))
        {
            if(!empty($newTitle) && !empty($newChapter) && !empty($newContent))
            { 
                $postManager->addPost($newTitle, $newChapter, $newContent);
                header('Location: index.php?action=adminArticle'); 
            }
            else
            {
                $errorMessage = '<div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> Veuillez renseigner les différents champs
                        </div>';
                require('views/backend/adminCreateView.php');
            }
        }
        else
        {
            $errorMessage = '<div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> Formulaire n\'a pas été envoyé
                        </div>';
            require('views/backend/adminCreateView.php');
        }
    }
    

    // accès à la page des modifications d'un chapitre
    function editPost($postId) {
        $postManager = new PostManager();
        $chapter_single = $postManager->getPosts($_GET['id']);

        require('views/backend/AdminEditView.php');
    }

    function getMembersAdmin()
    {
        $postManager = new PostManager();
        $commentManager = new CommentManager();
        $memberManager = new MemberManager();

        $members = $memberManager->getMembers(); 
        $memberNumber = $memberManager->countMembers();
        $postNumber = $postManager->countPosts();
        $reportedComNumber = $commentManager->countReportedComment();

        $totalMemberReq = $memberManager->numberOfMembers();
        $totalMember = $totalMemberReq['total'];
        $memberPerPage = 5;
        
        $totalPage = ceil($totalMember / $memberPerPage);
        
        if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalPage)
        {
            $_GET['page'] = $_GET['page'];
            $currentPage = $_GET['page'];
        }
        else
        {
            $currentPage = 1;
        }

        $start = ($currentPage - 1) * $memberPerPage;

        $members = $memberManager->getLastMembers($start, $memberPerPage); 

        require('views/backend/adminView.php');   
    }


    // Suppression du chapitre
    /*function deletePost($postId) {
        $postManager = new PostsManager();
        $commentManager = new CommentsManager();
        $reportManager = new ReportManager();
        $deletePost = $postManager->deletePost($postId);
        $deleteComment = $commentManager->deletecomment($postId);
        $deleteReport = $reportManager->deleteReportComment();

        if ($deletePost === false || $deleteComment === false || $deleteReport === false) {
            throw new Exception('Impossible de supprimer ce chapitre.');
        } else {
            header('Location: index.php?action=pageChapter&chap=delete');
        }
    //}*/
    
    // ---------------------------------------------------------------------

    // Accès à la page des commentaires
     function comment() {
        $commentManager = new CommentsManager();
        $reportManager = new ReportManager();
        $comments = $commentManager->allComments();
        $report = $reportManager->getIdReport();

        require('views/backend/AdminComView.php');
    }

    // Accès à la page traitant d'un commentaire signalé
     function viewComment($commentId) {
        $commentManager = new CommentsManager();

        $comment = $commentManager->getComment($_GET['id']);
        require('views/backend/AdminComView.php');
    }
    
    /* Valide le commentaire signalé
     function validComment($commentId) {
        $reportManager = new ReportManager();
        $commentManager = new CommentsManager();

        // Supprime le commentaire de la table des reports
        $reportValid = $reportManager->deleteReport($_GET['id']);

        // Initialise le commentaire en tant que "non signalé"
        $commentValid = $commentManager->validateComment($_GET['id']);

        if ($reportValid === false || $commentValid === false) {
            throw new Exception('Impossible de valider le commentaire.');
        } else {
            header('Location: index.php?action=comment&comm=validate');
        }
    }*/


    function commentStatusAdmin() 
    {
        $commentManager = new CommentManager();
        $reported = 0;
        $commentId = $_GET['id'];

        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $commentManager->updateComStatus($reported, $commentId);

            header('Location: index.php?action=adminCom');
        }
        

    }

    // Suppression d'un commentaire
   
     function eraseReportedCom($commentId) {
        $reportManager = new ReportManager();
        $commentManager = new CommentManager();

        // Supprime le commentaire dans l'ensemble de la base
        $reportDelete = $reportManager->deleteReportedComment($_GET['id']);
        $commentDelete = $commentManager->eraseReportedCom($_GET['id']);

        if(isset($_GET['id']) AND $_GET['id'] > 0)
        {
            throw new Exception('Impossible de supprimer le commentaire.');
        } else {
            header('Location: index.php?action=adminCom');
        }
    }



    function postEditAdmin()
    {
        $postManager = new PostManager();
        $commentManager = new CommentManager();
        $memberManager = new MemberManager();
        $reportManager = new ReportManager();

        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $post = $postManager->getPost($_GET['id']);
            $memberNumber = $memberManager->countMembers();
            $postNumber = $postManager->countPosts();
            $reportedComNumber = $commentManager->countReportedComment();

            if($post == false)
            {
                $errorMessage = '<div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                Pas de chapitre à éditer !
                </div>';
                require('views/backend/adminEditView.php');
            }
            else
            {
                require('views/backend/adminEditView.php');
            }
        }
        else
        {
            $errorMessage = 'Cette page n\'existe pas';
            require('views/frontend/errorView.php');
        }
    }
    function reportedCommentAdminList()
    {
        $commentManager = new CommentManager();
        $postManager = new PostManager();
        $memberManager = new MemberManager();

        
        $memberNumber = $memberManager->countMembers();
        $postNumber = $postManager->countPosts();
        $reportedComNumber = $commentManager->countReportedComment();

        $totalRepotedCommentReq = $commentManager->numberOfReportedComment();
        $totalRepotedComment = $totalRepotedCommentReq['total'];
        $repotedCommentPerPage = 4;
            
        $totalPage = ceil($totalRepotedComment / $repotedCommentPerPage);
            
        if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalPage)
        {
            $_GET['page'] = intval($_GET['page']);
            $currentPage = $_GET['page'];
        }
        else
        {
            $currentPage = 1;
        }
        $start = ($currentPage - 1) * $repotedCommentPerPage;

        $repotedComments = $commentManager->reportedListComments($start, $repotedCommentPerPage);

        require('views/backend/adminComView.php');
    }
         // Déconnexion de l'admin 
     function sessionFinish() {

        $_SESSION = array();
        setcookie(session_name(), '', time());
        session_destroy();
        header('Location: index.php?action=disconnect');
    }
}




    
   