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
use \Bosongo\Blog_Forteroche\Model\AdminManager;
use \Bosongo\Blog_Forteroche\Model\PostManager;
use \Bosongo\Blog_Forteroche\Model\CommentManager;
use \Bosongo\Blog_Forteroche\Model\MemberManager;
use \Bosongo\Blog_Forteroche\Model\ReportManager;
use \Bosongo\Blog_Forteroche\Core\Autoloader;
use \Bosongo\Blog_Forteroche\Classes\Helper;


class FrontendController
{
 /**
     * sideNavAdminData
     *
     * @param  mixed $requirePage Allows us to see admin display
     *
     * @return void
     */
    function sideNavAdminData($requirePage)
    {
        $postManager = new PostManager();
        $commentManager = new CommentManager();
        $memberManager = new MemberManager();

        $memberNumber = $memberManager->countMembers();
        $postNumber = $postManager->countPosts();
        $reportedComNumber = $commentManager->countReportedComment();
        require($requirePage);
    }
    /**
     * countAll
     * 
     * We call this function wich allowed us to count members 
     *
     * @return $memberNumber
     */
    function countAllMember()
    {
        $membersManager = new MemberManager(); 
        $memberNumber = $membersManager->countMembers();

        return $memberNumber;
    }
    /**
     * countAllPost
     *
     * We call this function wich allowed us to count posts
     * 
     * @return $postNumber
     */
    function countAllPost()
    {
        $postsManager = new PostManager(); 
        $postNumber = $postsManager->countPosts();

        return $postNumber;
    }
    /**
     * countAllReportedCom
     *
     * We call this function wich allowed us to count reported comments
     * 
     * @return $reportedComNumber
     */
    function countAllReportedCom()
    {
        $commentsManager = new CommentManager();
        $reportedComNumber = $commentsManager->countReportedComment();
     
        return $reportedComNumber;
        
    }


    function member($log)
        {
            $memberManager = new MemberManager();
            $member = $memberManager->getMember($log);
            
            return $member;
        }


       
        /**
         * getMembersAdmin
         * 
         * We call this function wich allowed us to show the members in admin dashboard with pagination
         *
         * @return $members
         */
      
        
        /**
         * subscribe
         *
         * @param  string $log
         * @param  string $password
         * 
         * We call this function wich allowed us to subscribe  a new memeber
         *
         * @return void
         */
        function subscribeMember($log, $password)
        {
            $memberManager = new MemberManager();
            $member = $memberManager->addMember($log, $password);
            
        }
    
        /**
         * verify
         *
         * @param  string $log We call this function wich allowed us to check if a member log is already used
         *
         * @return $member
         */
        function memberRegistration()
        {
            $memberManager = new MemberManager();
            $username =  htmlspecialchars($_POST['username']);
            $pass =  htmlspecialchars($_POST['pass']);
            $re_pass =  htmlspecialchars($_POST['re_pass']);

            if(isset ($_POST['submit']))
            {
                if(!empty($username) AND 
                !empty($pass) AND
                !empty($re_pass))
                {
                    if(preg_match('#^[a-zA-Z0-9_]{2,16}$#i', ($username))) 
                    {
                        $verifyUsername = $memberManager->verifyIfMemberExist($username);
                       
                        if($verifyUsername == 0) // if log doesnt exist in database
                        {
                            if(preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$#', ($pass))) 
                            {
                                if($pass === $re_pass)
                                {
                                    $this->subscribeMember($username, $pass);
                                    $succesMessage = '<div class="alert alert-success" role="alert">
                                    Vous êtes enregistré(e), vous pouvez vous connecter!
                                    </div>';
                                    
                                    require('views/frontend/loginView.php');
                                }
                                else
                                {
                                    $errorMessage = '<div class="alert alert-warning" role="alert">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Mot de passe différents
                                    </div>';
                                    require('views/frontend/subscribeView.php');
                                }
                            }
                            else
                            {
                                $errorMessage = '<div class="alert alert-warning" role="alert">
                                <i class="fas fa-exclamation-triangle"></i>
                                Mot de passe 8 caractères minimum avec au moins 1 minuscule, 1 majuscule et 1 chiffre
                                </div>';
                                require('views/frontend/subscribeView.php');
                            }
                        }
                        else
                        {
                            $errorMessage = '<div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            Ce pseudo existe déjà, choisir un autre ou vous connectez
                            </div>';
                            require('views/frontend/subscribeView.php');
                            
                        }
                    }
                    else
                    {
                        $errorMessage = '<div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        Votre pseudo doit comporter au moins 2 lettres
                        </div>';
                        require('views/frontend/subscribeView.php');
                    }
                }
                else
                {
                    $errorMessage = '<div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    Veuillez renseigner tout les champs !
                    </div>';
                    require('views/frontend/subscribeView.php');
                }
            }
            else
            {
                $errorMessage = '<div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
                Formulaire n\'a pas été envoyé
                </div>';
                require('views/frontend/subscribeView.php');
            }

            
        }
        
        /**
         * verifyConnection
         *
         * We call this function wich allowed us to connect with log and password
         * 
         * @return void
         */
        function verifyConnection()
        {
            $memberManager = new MemberManager();
            
            $loginConnex = htmlspecialchars($_POST['login']);
            $passConnex = htmlspecialchars($_POST['pass']);
 
            if(isset($_POST['submit']))
            {
                if(!empty($loginConnex) AND !empty($passConnex))
                {
                    $verifyMember = $memberManager->getMember($loginConnex);
                    $isPasswordCorrect = password_verify($passConnex, $verifyMember['password']);
                    $right = true;  
                    
                    if($verifyMember['log'] == $loginConnex AND $isPasswordCorrect === $right)
                    {
                        session_start();
                        $result = $this->member($loginConnex);
                        $_SESSION['loginSession'] = $result['log'];
                        $_SESSION['id'] = $result['id'];
                        $_SESSION['registration_date'] = $result['registration_date_fr'];

                        header('location: index.php?action=listPosts');
                    }
                    else
                    {
                        
                        $errorMessage = '<div class="alert alert-warning" role="alert">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Mauvais mot de passe ou pseudo inconnu
                                        </div>';
                        require('views/frontend/loginView.php');
                    }
                }
                else
                {
                    $errorMessage = '<div class="alert alert-warning" role="alert">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Veuillez renseignez tout les champs
                                        </div>';
                    require('views/frontend/loginView.php');
                }
            }
            else
            {
                $errorMessage = '<p>Formulaire n\'a pas été envoyé</p>';
                require('views/frontend/loginView.php');
            }
        }
    

    /**
         * post
         *
         * @param  int $postId We call this function wich allowed us to show a post with its comments
         *
         * @return compact('post', 'comments')
         */
        function post()
        {           
            $postManager = new PostManager();
            $commentManager = new CommentManager();
            
            if(isset($_GET['id']) && $_GET['id'] > 0)
            {
                $post = $postManager->getPost($_GET['id']);
        
                $totalCommentReq = $commentManager->numberOfCommentByPost($_GET['id']);
                $totalComment = $totalCommentReq['total'];
                $commentPerPage = 6;
                        
                $totalPage = ceil($totalComment / $commentPerPage);
                        
                if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalPage)
                {
                    $_GET['page'] = intval($_GET['page']);
                    $currentPage = $_GET['page'];
                }
                else
                {
                    $currentPage = 1;
                }
                $start = ($currentPage - 1) * $commentPerPage;
            
                $comments = $commentManager->getComments($_GET['id'], $start, $commentPerPage);

                if($post == false)
                {
                    $errorMessage = 'Ce chapitre n\'existe pas';
                    require('views/frontend/errorView.php');
                }
                else
                {
                    require('views/frontend/postView.php');                     
                }                 
            }
            else 
            {
            $errorMessage = 'Cette page n\'existe pas';
            require('views/frontend/errorView.php');
            }                     
        }


        function lastPostAndComments()
        { 
            $lastPostManager = new PostManager(); 
            $lastCommentManager = new CommentManager();

            $lastPost = $lastPostManager->getLastPost(); 
            $lastComments = $lastCommentManager->allLastComments();
            
            require_once('views/frontend/homeView.php');
        }

        /**
         * listPosts
         *
         * We call this function wich allowed us to show a list of posts with pagination
         * 
         * @return $posts
         */
        function listPosts()
        {       
            $postsManager = new PostManager(); 
            
            $totalPostReq = $postsManager->numberPost();
            $totalPost = $totalPostReq['total'];
            $postPerPage = 6;
            
            $totalPage = ceil($totalPost / $postPerPage);
            
            if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $totalPage)
            {
                $_GET['page'] = $_GET['page'];
                $currentPage = $_GET['page'];
            }
            else
            {
                $currentPage = 1;
            }

            $start = ($currentPage - 1) * $postPerPage;

            $posts = $postsManager->getPosts($start, $postPerPage); 
            
            require('views/frontend/listPostsView.php');
        }



    function newComment()
    {
        $commentManager = new CommentManager();
        $postManager = new PostManager();

        $postId = $_GET['id'];
        $author = strip_tags($_POST['login']);
        $newMessage = strip_tags($_POST['story']);
                
        if(isset($_POST['submit']))
        {
            if(isset($postId) AND $postId > 0)
            {
                if(!empty($newMessage))
                {
                    $comment = $commentManager->addComment($postId, $author, $newMessage);
                    header('Location: index.php?action=post&id='.$postId);
                }
                else
                {
                    $post = $postManager->getPost($postId);
                    $comments = $commentManager->getComments($postId);
                    if($post == false)
                    {
                    $errorMessage = 'Ce chapitre n\'existe pas';
                    require('views/errorView.php');
                    }
                    else
                    {
                    $errorMessageSend = '<div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> Message vide, veuillez entrer un commentaire !
                    </div>';
                    require_once('views/frontend/postView.php');                     
                    }                 
                }
            }
            else
            {
                $errorMessage = 'Aucun identifiant de chapitre envoyé';   
                require('views/frontend/errorView.php');
            }
        }
        else
        {
            $errorMessage = 'Formulaire n\'a pas été envoyé';   
            require('views/frontend/errorView.php');            
        }
    }
    function commentStatus() 
    {
        $commentManager = new CommentManager();
        $reported = 1;
        $commentId = $_GET['id'];
        $postId = $_GET['postId'];

        if(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['postId']) && $_GET['postId'] > 0)
            {
                $updateReported = $commentManager->updateComStatus($reported, $commentId);
                
                header('Location: index.php?action=post&id=' . $postId);
            }   
    }
}