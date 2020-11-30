<?php

namespace Bosongo\Blog_Forteroche\Model;

require_once("model/Manager.php");


/*
class AdminManager extends Manager {
    
    public function __construct() {
        $this->db = $this->dbConnect();
    }
    

         function getAdmin($log) 
        {
            $db = $this->dbConnect();
            $admin = $db->prepare('SELECT id, log, password, date_format(registration_date, \'%d/%m/%Y à %Hh%imin%ss\') AS registration_date_fr FROM members WHERE log = ?');
            $admin->execute(array($log));
            $result = $admin->fetch();

            return $result;
        }

        public function getVerifyAdmin($log)
        {
            
                $db = $this->dbConnect();
                $req = $db->prepare('SELECT log FROM members WHERE log = ?');
                $req->execute(array($log));
                $verifyAdmin = $req->rowCount();
               
                return $verifyAdmin;
        }
    }  */     



    class AdminManager extends Manager {
    
        public function __construct() {
            $this->db = $this->dbConnect();
        }
        
        // Récupération du pseudo 
        public function getPseudo($pseudo) {
    
            $req = $this->db->prepare('SELECT id, mdp FROM members WHERE pseudo = ?')
            or die(var_dump($this->db->errorInfo()));
            $req->execute(array($pseudo));
            $result = $req->fetch();
    
            return $result;
        }
    }
