<?php

/**
 * Created by PhpStorm.
 * User: student
 * Date: 29.10.2015
 * Time: 15:41
 */
class cKraje {

    /**
     * @var Db
     */
    private $DB;

    public function __construct() {
        require_once 'Db.php';
        $this->DB = new Db();
    }

    public function vratKraje() {
        return $this->DB->vratKraje();
    }

    public function vratObce($kraj) {
        $q = $this->DB->spojeni->prepare("SELECT obec.nazev, obec_kod as kod FROM obec LEFT JOIN okres USING (okres_kod)
WHERE kraj_kod = ?;");
        $q->execute(array($kraj));
        return $q->fetchAll(PDO::FETCH_OBJ);
    }
}