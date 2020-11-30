<?php

namespace Bosongo\Blog_Forteroche\Classes;




class Helper {

// Méthode qui extrait une partie d'un texte
public function extract($text) {

    if (preg_match('/^.{1,180}\b/s', $text, $output)) {
        $text = $output[0].'...';
    }
    
    return $text;
}

// Méthode permettant de vérifier à admin
public function is_connected() {
    if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
        return true;
    } else {
        return false;
    }
}
}