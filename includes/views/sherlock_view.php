<?php

    // if started session data is not true
    if ( !isset( $_SESSION ) ) {
        
        // redirect to 404 page
        header( 'HTTP/1.0 404 File Not Found', 404 );
        include '404.php';
        exit();

    }

    require_once 'includes/exercise.php';
    require_once 'includes/functions.php';
    
    // if the request is an exercise with a LTI outcome URL
    if ( isset( $_REQUEST['exercise'] ) && isset( $_REQUEST['ext_ims_lis_basic_outcome_url'] ) ) {
        if ( $exercise_info = DB::getLTIExercise( $_REQUEST['exercise'], getLTICourseID( $_REQUEST ),
                                                  $_REQUEST['tool_consumer_info_product_family_code'] ) ) {
            
            $exercise_exists = true;
            
        } else {
            
            $exercise_exists = false;
            
        }
        
    // exercise currently stored in session
    } else {
        
        $exercise_info = unserialize( $_SESSION['exercise_info'] );
        $exercise_exists = true;
        
    }
    
    if ( $exercise_exists ) {
        
        $exercise = new Exercise( $exercise_info['markup_src'] );
        $actions = $exercise->getActions();
        $rewindAction = $exercise->getRewindAction();
        
    }

?>

<?php if ( $exercise_exists ) { ?>
<section class="sherlock_view">

    <div class="sherlock_status_msg hide"></div>

    <h1><?php echo $exercise->name; ?></h1>

    <div class="sherlock_interaction_wrapper">

        <div class="sherlock_media">
            <div class="overlay"><div id="videoPlayBtn">START</div></div>
            <div id="ytv" data-video-id="<?php echo $exercise_info['video_src']; ?>" data-start="<?php echo $exercise->videoStart; ?>" data-end="<?php echo $exercise->videoEnd; ?>"></div>
        </div>

        <div class="sherlock_actions">

            <h4><?php echo $exercise->actionHeading; ?></h4>

            <?php


                foreach( $actions as $action ) {

                    $button = '<div class="btn disabled" data-cooldown="' . $action->cooldown . '" data-action-id="' . $action->id . '">';
                    
                    if ( $exercise->displayLimits ) {
                        
                        $button .= '<span class="limits" data-limit="' . $action->limits . '">' . $action->limits . '</span>';
                        
                    } else {
                        
                        $button .= '<span class="limits hide" data-limit="' . $action->limits . '">' . $action->limits . '</span>';
                        
                    }

                    if ( strlen( trim( $action->icon ) ) ) {

                        $button .= '<span class="icon"><span class="icon-' . $action->icon . '"></span></span>';

                    } else {

                        $button .= '<span class="icon">' . initialism( $action->name ) . '</span>';

                    }

                    if ( strlen( $action->name ) > 20 ) {

                        $button .= '<span class="action_name long">' . $action->name . '</span>';

                    } else {

                        $button .= '<span class="action_name">' . $action->name . '</span>';

                    }

                    $button .= '<span class="cooldown"><span class="progress"></span></span></div>';

                    echo $button;

                }

            ?>

        </div>

    </div>

</section>

<nav class="sherlock_controls">

    <div class="progress_bar_holder">

        <!-- Tags go here -->

        <div class="progress_bar">
            <span class="progressed"></span>
            <?php

                if ( $exercise->showVideoTimecode ) {

                    echo '<div class="time"><span class="elapsed">--:--</span><span class="duration">--:--</span></div>';

                }

            ?>
        </div>
    </div>

    <div class="main_controls">

        <?php

            if ( $rewindAction->enabled ) {

                $rewindButton = '<div class="btn rewind' . ( ( $rewindAction->graded ) ? ' graded ' : ' ' ) . 'disabled" data-cooldown="' . $rewindAction->cooldown . '" data-action-id="' . $rewindAction->id . '" data-length="' . $rewindAction->length . '">';
                
                if ( $exercise->displayLimits ) {
                    
                    $rewindButton .= '<span class="limits" data-limit="' . $rewindAction->limits . '">' . $rewindAction->limits . '</span>';
                    
                } else {
                    
                    $rewindButton .= '<span class="limits hide" data-limit="' . $rewindAction->limits . '">' . $rewindAction->limits . '</span>';
                    
                }
                
                $rewindButton .= '<span class="icon"><span class="icon-' . $rewindAction->icon . '"></span></span>';
                $rewindButton .= '<span class="action_name">' . $rewindAction->name . '</span>';
                $rewindButton .= '<span class="cooldown"><span class="progress"></span></span></div>';

                echo $rewindButton;

            }

        ?>

    </div>

</nav>
<?php } else { ?>

    <script>
        $( function() { 
            $( '.sherlock_wrapper' ).showTransition( 'Exercise Not Found!', 'The exercise that you requested cannot be found or may not be available yet.<br /><a href="javascript:window.close();">&times; close</a>', true );
        });
    </script>

<?php } ?>