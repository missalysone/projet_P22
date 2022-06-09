<?php

require_once 'Model.php';

class ModelEvent {

    private $famille_id, $id, $iid, $event_type, $event_date, $event_lieu;

    public function __construct($famille_id = NULL, $id = NULL, $iid = NULL, $event_type = NULL, $event_date = NULL, $event_lieu = NULL) {
        if (!is_null($famille_id)) {
            $this->famille_id = $famille_id;
            $this->id = $id;
            $this->iid = $iid;
            $this->event_type = $event_type;
            $this->event_date = $event_date;
            $this->event_lieu = $event_lieu;
        }
    }

    function setFamille_id($famille_id) {
        $this->famille_id = $famille_id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIid($iid) {
        $this->iid = $iid;
    }

    function setEvent_type($event_type) {
        $this->event_type = $event_type;
    }

    function setEvent_date($event_date) {
        $this->event_date = $event_date;
    }

    function setEvent_lieu($event_lieu) {
        $this->event_lieu = $event_lieu;
    }

    function getFamille_id() {
        return $this->famille_id;
    }

    function getId() {
        return $this->id;
    }

    function getIid() {
        return $this->iid;
    }

    function getEvent_type() {
        return $this->event_type;
    }

    function getEvent_date() {
        return $this->event_date;
    }

    function getEvent_lieu() {
        return $this->event_lieu;
    }

    public static function eventGetAll() {
        try {
            $database = Model::getInstance();
            $query = "select * from evenement where famille_id = :famille";
            $statement = $database->prepare($query);
            $statement->execute(['famille' => $_SESSION['id']]);
            $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelEvent");
            return $results;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return NULL;
        }
    }

    public static function insert($iid, $event_type, $event_date, $event_lieu) {
        try {
            
            $database = Model::getInstance();
            $query = "select max(id) from evenement";
            $statement = $database->query($query);
            $tuple = $statement->fetch();
            $id = $tuple['0'];
            $id++;
            
            $query = "insert into evenement value(:famille, :id, :iid, :type, :date, :lieu";
            $statement = $database->prepare($query);
            $statement->execute([
                'famille' => $_SESSION['id'],
                'id' => $id,
                'iid' => $iid,
                'type' => $event_type,
                'date' => $event_date,
                'lieu' => $event_lieu,
            ]);
            return $id;
        } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return -1;
        }
    }

}
