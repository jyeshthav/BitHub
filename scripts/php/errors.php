<?php
  session_start();
  function displayErrors($errors){
    if(count($errors) > 0){
      echo('<div class="error"');
      foreach ($errors as $error) {
        echo('<p>'.$error.'</p>'); 
      }
      echo('</div>');
    }  
  }
?>