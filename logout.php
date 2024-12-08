<?php
  session_start();

  unset($_SESSION["username"]);
  unset($_SESSION["nickname"]);
  unset($_SESSION["isadmin"]);
  unset($_SESSION["userpoint"]);
  unset($_SESSION["profile_image"]);

  session_destroy();
  
  echo("
       <script>
          location.href = 'index.php';
         </script>
       ");
?>
