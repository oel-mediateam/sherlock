<?php
    
    session_start();
    
    require_once 'admin/lti/LTI_Tool_Provider.php';
    
    $db_connector = LTI_Data_Connector::getDataConnector('', 'none');
    
    // Initialise tool consumer record if it does not already exist
    $consumer = new LTI_Tool_Consumer('ptdlbplus', $db_connector);
    
    if (is_null($consumer->created)) {
      $consumer->name = 'ceLTIc';
      $consumer->secret = 'secret';
      $consumer->enabled = TRUE;
      $consumer->save();
    }
    
    class My_LTI_Tool_Provider extends LTI_Tool_Provider {
 
      function onLaunch() {
     
        // Insert code here to handle incoming launches - use the user
        // and resource_link properties of the $tool_provider parameter
        // to access the current user and resource link.
        
        $_SESSION['lti_user'] = $this->user->email;
        
        header( 'Location: ./' );
        
/*
        echo '<pre>';
        print_r($this->user->email);
        echo '</pre>';
*/
     
      }
     
      function onConfigure() {
     
        // Insert code here to handle incoming configuration message requests - this
        // is an extension of the IMS specification supported by the BasicLTI Building
        // Block for Blackboard Learn 9.  It can be generated by a system administrator.
     
      }
     
      function onDashboard() {
     
        // Insert code here to handle incoming dashboard message requests - this
        // is an extension of the IMS specification supported by the BasicLTI Building
        // Block for Blackboard Learn 9.  It is a server-to-server request with the
        // response (typically HTML or RSS XML) being used to populate a portlet
        // (Blackboard module) displayed to the user.
     
      }
     
      function onContentItem() {
     
        // Insert code here to handle incoming content-item requests - use the user
        // property of the $tool_provider parameter to access the current user.
     
      }
     
      function onError() {
     
        // Insert code here to handle errors on incoming connections - do not expect
        // the user and resource_link properties to be populated but check the reason
        // property for the cause of the error.  Return TRUE if the error was fully
        // handled by this function.
     
      }
     
    }
     
    $tool = new My_LTI_Tool_Provider($db_connector);
    $tool->execute();
    
?>