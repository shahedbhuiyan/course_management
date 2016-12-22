<!DOCTYPE html>
<html>
  <head>
    <title>Child Frame</title>
    <script>
      window.addEventListener('focus', function(event) {
        console.log('I am the 2nd one.');
      });
      window.addEventListener('blur', function(event) {
        alert('dont move');
      });
    </script>
  </head>
  <body>
      
  </body>
</html>

<?php

$today = date("Ymd");
$rand = strtoupper(substr(uniqid(sha1(time())),0,4));
echo $unique = $today . $rand;
