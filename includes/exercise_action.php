<?php

    if ( !defined( "LBPATH" ) ) {

        header( 'HTTP/1.0 404 File Not Found', 404 );
        include 'views/404.php';
        exit();

    }

    class ExerciseAction {

        protected $id;
        protected $name;
        protected $icon;
        protected $cooldown;
        protected $limits;

        // getter
        public function __get( $property ) {

            if ( property_exists( $this, $property ) ) {

                return $this->$property;

            }

        }

        // setter
        public function __set( $property, $value ) {

            if ( property_exists( $this, $property ) ) {

                $this->$property = $value;

            }

            return $this;

        }

    }

?>