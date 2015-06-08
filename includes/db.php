<?php

    if ( !defined( "LBPATH" ) ) {

        header( 'HTTP/1.0 404 File Not Found', 404 );
        include 'views/404.php';
        exit();

    }

class DB {

    private static function getDB() {

        return new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME , DB_USER, DB_PWD );

    }

}