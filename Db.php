<?php

/**
 * Created by PhpStorm.
 * User: student
 * Date: 22.10.2015
 * Time: 15:29
 */
class Db
{
    public $spojeni;

    public function __construct() {
        $dbname = "uiradr";
        $user = "";
        $pass = "";
        $dsn = "mysql:host=localhost;dbname=$dbname;port=3336";
        $options = array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                        );
        $this->spojeni = new PDO($dsn, $user, $pass, $options);
    }

    /**
     * Metoda vrací tabulky z DB
     * @return array
     */
    public function ukazTabulky() {
        /** @var  PDOStatement */
        $dotaz = $this->spojeni->prepare("SHOW tables");
        $dotaz->execute();
        return $dotaz->fetchAll();
    }

    public function vratKraje($serad = 'nazev') {
        $dotaz = $this->spojeni->prepare("SELECT kraj_kod as kod, nazev FROM kraj order by ?");
        $dotaz->execute(array($serad));
        return $dotaz->fetchAll(PDO::FETCH_OBJ);
        /*return $dotaz->fetchAll(PDO::FETCH_FUNC,
                function($k,$n) {
                    return "Kraj $n s kódem $k";
                }
        );*/
    }

    public function pridejKraj($nazev, $kod) {
        $dot = $this->spojeni->prepare("INSERT INTO kraj (kraj_kod, nazev) VALUES (?,?)");
        $dot->bindValue(2, $nazev);
        $dot->bindValue(1, $kod, PDO::PARAM_INT);
        $dot->execute();
    }

    public function closeConnection() {
        $this->spojeni = null;
    }
}
?>