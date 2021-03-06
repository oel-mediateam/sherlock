<?php
    
    if ( !isset( $_POST['begin'] ) ) {

        header( 'HTTP/1.0 404 File Not Found', 404 );
        include 'views/404.php';
        exit();

    }
    
    // ↓↓↓↓↓ prepared the database before starting the exercise (called with AJAX) ↓↓↓↓↓
    
    if ( !isset( $_SESSION ) ) {

        session_start();
        
        require_once 'functions.php';
        
        if ( !isLTIUser() ) {
            
            require_once 'config.php';
            require_once 'db.php';
            
        }
        
        $exercise_info = unserialize( $_SESSION['exercise_info'] );
        
        if ( isset( $_SESSION['isReview'] ) ) {
            
            unset( $_SESSION['isReview'] );
            
        }
        
        if ( isset( $_SESSION['student_data'] ) ) {
            
            unset( $_SESSION['student_data'] );
            
        }
        
        if ( !isLTIUser() ) {
            
            $attempt = DB::getAttempted( $_SESSION['signed_in_user_id'], $exercise_info['exercise_id'] );
            
            if ( !$exercise_info['allow_retake'] ) {
                
                if ( $attempt >= $exercise_info['attempts'] ) {
                
                    exit( 0 );
                    
                } 
                
            }
            
            if ( $exercise_info['exrs_type_id'] != 3 ) {
                
                $_SESSION['user_exercise_id'] = DB::setUserExercise( $_SESSION['signed_in_user_id'],
                                     $exercise_info['exercise_id'], ( $attempt + 1 ) );
                
            }
                                         
            echo true;
            
        } else {
            
            echo true;
            
        }
                                          
    }
    
?>