<?php

namespace Models;

class Manager
{
    protected function getPdo(): \PDO
    {
        /**
         * Connexion à la base de données avec PDO
         * On précise ici deux options :
         * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une connerie ;-)
         * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
         * @return PDO
         */
        $bdd = new \PDO('mysql:host=localhost;dbname=memory;charset=utf8', 'root', '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
        return $bdd;

        // $bdd = new \PDO('mysql:host=mysql-fokemon.alwaysdata.net;dbname=fokemon_memory;charset=utf8', 'fokemon', 'Trampoline2021.', [
        //     \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        //     \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        // ]);
        // return $bdd;

        // $bdd = new \PDO('mysql:host=91.216.107.183;dbname=kames1940726;charset=utf8', 'kames1940726', '8kjygn1bqy', [
        //     \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        //     \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        // ]);
        // return $bdd;
    }
}
