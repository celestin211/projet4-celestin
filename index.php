<?php
/****************************************INDEX.PHP****************************************/

//REQUIRING CLASSES
require_once('controller/FrontendController.php');
require_once('controller/BackendController.php');
require_once('class/Helper.php');

use \Bosongo\Blog_Forteroche\Controller\FrontendController;
use \Bosongo\Blog_Forteroche\Controller\BackendController;
use \Bosongo\Blog_Forteroche\Classes\Helper;


$helper = new Helper();


try 
{
    if(isset($_GET['action']))
    { 
        /* ---------------------------------------- */
        /* =============BLOG FREE ACCES============ */
        /*----------------------------------------- */
        
        //HOME PAGE DISPLAY

        if($_GET['action'] == "home")
        {
            $frontendController = new FrontendController();
            $frontendController->lastPostAndComments();
        }
        
        //ROMAN PAGE DISPLAY
    
        elseif($_GET['action'] == "listPosts") // This action send us to listPostsView = Roman
        {
            $frontendController = new FrontendController();
            $frontendController->listPosts();         
        }

        //SINGLE POST DISPLAY

        elseif($_GET['action'] == 'post')
        {   
            $frontendController = new FrontendController();
            $frontendController->post();        
        }

        //ABOUT ME PAGE DISPLAY
        elseif($_GET['action'] == 'aboutme')
        {
            require('views/frontend/aboutme.php');
        }
        /* ---------------------------------------- */
        /* =============BLOG CONNECTION============ */
        /*----------------------------------------- */

        // LOGIN PAGE DISPLAY

        elseif($_GET['action'] == "login") 
        {
            require('views/frontend/loginView.php');
        }

        //LOGIN  

        elseif($_GET['action'] == 'connect')
        {
            $frontendController = new FrontendController();
            $verifyLogin = $frontendController->verifyConnection();
        }

        // SUBSCRIBE PAGE DISPLAY

        elseif($_GET['action'] == "subscribe") // This action send us to loginView 
        { 
            require('views/frontend/subscribeView.php');
        }

        //SUBSCRIBE  

        elseif($_GET['action'] == "register")
        {
            $frontendController = new FrontendController();
            $frontendController->memberRegistration();
        }

        //DISCONNECT PAGE DISPLAY

        elseif($_GET['action'] == "disconnect")
        {
            require('views/frontend/disconnectView.php');
        }

        /* ---------------------------------------- */
        /* =============BLOG MEMBERS ACCES============ */
        /*----------------------------------------- */

        //REPORT A COMMENT POSTVIEW 

        elseif($_GET['action'] == "reportComment")
        {
            $frontendController = new FrontendController();
            $frontendController->commentStatus();
        }

        //SEND A COMMENT

        elseif($_GET['action'] == "sendComment")
        {
            $frontendController = new FrontendController();
            $frontendController->newComment();
            
        }

        /* ---------------------------------------- */
        /* =============BLOG ADMIN ACCES=========== */
        /*----------------------------------------- */
      elseif ($_GET['action']=='connected') {

        require('views/backend/adminConnexionView.php');
        
      }
 
    elseif ($_GET['action'] == 'auth') {
           $backendController= new BackendController();
        $backendController->auth($_POST['pseudo']);
    } 
    elseif ($_GET['action'] == 'admin') {
    
        if ($helper->is_connected()) {
            $backendController->adminDashboard();
            $backendController= new BackendController();
            $verifyAdmin=$backendController->verifyAdmin();
        } 
     
    
    
        //ADMIN DASHBOARD

       //elseif (htmlspecialchars($_POST['pseudo']=="admin" AND htmlspecialchars($_POST['mdp']=='babaro211'))) {
            
        /*elseif($_GET['action'] == "admin"){
        {
            //$frontendController = new FrontendController();
            //$blogController->adminDashboard();
            $backendController= new BackendController();
            $backendController->adminDashboard();
            //$verifyAdmin = $backendController->verifyAdmin();


        }*/
    
        //ADMIN: MEMBERS PAGE
        if($_GET['action'] == "adminUsers")
        {
            //$frontendController = new FrontendController();
            //$frontendController->getMembersAdmin();
            $backendController= new BackendController();
            $backendController->getMembersAdmin();
        }
        
        //ADMIN SEES CREATING CHAPTER PAGE
        elseif($_GET['action'] == "adminCreate")
        {
            $backendController=new BackendController();
            //$frontendController = new FrontendController();
            $requirePage = 'views/backend/adminCreateView.php';
           // $frontendController->sideNavAdminData($requirePage);
            $backendController->sideNavAdminData($requirePage);
        }
        
        //ADMIN SEES LIST POSTS 
        elseif($_GET['action'] == "adminArticle")
        {
            $backendController = new BackendController();
            //$frotendController->listPostsAdmin();
            $backendController->listPostsAdmin();
        }
        
        //ADMIN SEES EDIT PAGE
        elseif($_GET['action'] == 'goEditArticle')
        {
            //$postController = new PostController();
            $backendController = new BackendController();
            //$postController->postEditAdmin();
            $backendController->postEditAdmin();
        }
            
        //ADMIN EDIT A POST
        elseif($_GET['action'] == "editPost")
        {
            $backendController = new BackendController();
            //$postController = new PostController();
            //$postController->updatePost();
            $backendController->updatePost();
        }
        
        //ADMIN SEES REPORTED COMMENTS PAGE
        elseif($_GET['action'] == "adminCom")
        {
            //$commentController = new CommentController();
            //$commentController->reportedCommentAdminList();
            $backendController = new BackendController();
            $backendController->reportedCommentAdminList();
            //$backendController = new BackendController();

        }
        
        //DELETE REPORTED COMMENT ADMIN

        elseif($_GET['action'] == "deleteReportedCom") 
        {
            //$commentController = new CommentController();
            $backendController = new BackendController();
            //$commentController->eraseReportedCom();
            $backendController->eraseReportedCom(); 
        }
        
        //RESTORE REPORTED COMMENT ADMIN

        elseif($_GET['action'] == "restoreReportedCom")
        {
            //$commentController = new CommentController();
            $backendController = new BackendController();
            //$commentController->commentStatusAdmin();
            $backendController->commentStatusAdmin();
        }
        
        //ADMIN ADD A POST

        elseif($_GET['action'] == 'addpost')
        {
            //$postController = new PostController();
            $backendController = new BackendController();
            $backendController->neWPost();
            //$postController->newPost(); 
            require('views/backend/AdminArticles.php');
        }

        elseif ($_GET['action'] == 'sessionFinish') {
            $backendController= new BackendController();
            $backendController->sessionFinish();
        }
    }
        //IF PAGE DOESN'T EXIST
        else
        {
            throw new Exception('Vous n\'êtes pas autorisé à cette page.</br><a href="index.php?action=home">Revenir à l\'accueil</a>');
        }       
    }
    else //HOME PAGE DISPLAY
    {
        $frontendController = new FrontendController();
        $frontendController->lastPostAndComments();
    }    

}
//ERROR PAGE DISPLAY
catch (Exception $e)
{
    $errorMessage = $e->getMessage();
    require('views/frontend/errorView.php');

}