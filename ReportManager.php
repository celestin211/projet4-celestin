<?php

namespace Bosongo\Blog_Forteroche\Model;

require_once('model/CommentManager.php');

class ReportManager extends CommentManager {
    
    public function __construct() {
        $this->db = $this->dbConnect();
    }
    
    // Récupération des commentaires signalés associé à l'id du commentaire
    public function getIdReport() {

        $reportId = $this->db->query('SELECT c.id id_comm, c.post_id post_id, c.author author, c.comment comment, 
        DATE_FORMAT(c.comment_date, "%d/%m/%Y %Hh%imin%ss") date_create, 
        r.id_comment id_comm, DATE_FORMAT(r.date_reporting, "%d/%m/%Y %Hh%imin%ss") date_report
        FROM comments AS c 
        INNER JOIN reported AS r 
        ON c.id = r.id_comm')
        or die(var_dump($this->db->errorInfo()));
        
        return $reportId->fetchAll();
    }

    // Insertion des commentaires signalés en base
    public function insert_report($commentId) {

        $report = $this->db->prepare('INSERT INTO reported(id_comm,
        date_reporting) VALUES(?, NOW())') or die(var_dump($this->db->errorInfo()));

        $report->execute(array($commentId));

        return $report;
    } 

    // Nombre de commentaires signalés
    public function numberReports() {
        $number = $this->db->query('SELECT COUNT(*) AS nb FROM comments')
        or die(var_dump($this->db->errorInfo()));

        return $number->fetch();
    }

    // Suppression d'un commentaire signalé
    public function deleteReport($commentId) {
        $report = $this->db->prepare('DELETE FROM reported WHERE id_comment = ?')
        or die(var_dump($this->db->errorInfo()));

        $deleteReport = $report->execute(array($commentId));

        return $deleteReport;
    }

    // Suppression d'un commentaire signalé si celui ci n'existe plus dans la table des commentaires
    public function deleteReportComment() {
        $report = $this->db->prepare('DELETE FROM reported WHERE id_comment NOT IN (SELECT id FROM comments)')
        or die(var_dump($this->db->errorInfo()));

        $deleteReport = $report->execute(array());

        return $deleteReport;
    }
}