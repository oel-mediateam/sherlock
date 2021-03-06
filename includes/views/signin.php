<?php
    
    if ( !isset( $_SESSION ) ) {
        
        header( 'HTTP/1.0 404 File Not Found', 404 );
        include '404.php';
        exit();
        
    }
    
?>
 <section class="sherlock_view">
     
     <div class="signin_view">
        
        <?php
                        
            if ( isset( $authUrl ) ) {
                
                echo '<h1>Welcome!</h1>';
                echo '<p><span class="icon-user bigicon"></span></p>';
                echo '<p>Please <strong><span class="icon-signin"></span> sign in</strong> with your Google Account.</p>';
                echo '<a class="btn signin" href="' . $authUrl . '"><span class="icon-signin"></span> Sign In</a>';
                echo '<p><small>If you do not have a Google Account, you can create one at <a href="https://accounts.google.com/signup" target="_blank">Google</a>.</small></p>';
                
            } else {
                
                echo '<h1>Hello, ' . $userData['givenName'] . '!</h1>';
                echo '<p class="profile_img"><img src="' . $userData['picture'] . '" /></p>';
                echo '<p><strong>' . $userData['email'] . '</strong></p>';
                
                if ( DB::getRole( $_SESSION['signed_in_user_id'] ) >= 0 ) {
                    
                    echo '<p><a class="btn" href="?page=exercises"><span class="icon-selection"></span> Exercises</a></p>';
                    
                } else {
                    
                    echo '<p><em>You have no permission to see available exercises.</em></p>';
                    
                }
                
                echo '<p><small><a href="?logout"><span class="icon-signout"></span> Sign Out</a></small></p>';
                echo '<p><small><a id="google_revoke_connection" href="#"><span class="icon-user-cancel"></span> disconnect this app from your Google Account</a></small></p>';
                
            }
            
        ?>
        
        <div id="disconnect-confirm">
            <p>Your user and exercise data will not be deleted. If you decided to come back, you may have to go through the consent screen for authorization again. Are you sure?</p>
        </div>
    
    </div>
 </section>
 <nav class="sherlock_controls"></nav>