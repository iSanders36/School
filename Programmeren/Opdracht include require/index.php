
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Opdracht _GET</title>
    <?php
    if(isset($_GET['header1']))
       {
             include('header1.php');
       }
       else {
         include('header.php');
       }
       ?>
  </head>
  <body>

<?php
if(isset($_GET['content1']))
   {
         include('content1.php');
   }
   else {
     include('content.php');
   }

   ?>

  </body>

  <footer><?php
  if(isset($_GET['footer1']))
     {
           include('footer1.php');
     }
     else {
       include('footer.php');
     }

     ?></footer>
</html>
