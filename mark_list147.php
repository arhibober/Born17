<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "functions147.php";
  include "menu.php";
  if ($_GET ["id"] > 0)
  {
    $isPhotos = false;
    onBD ($result, "PHOTO_PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($_GET ["id"] == $row [2])
        $isPhotos = true;
     if ($isPhotos)
     {
       onBD ($result, "PEOPLE");
       while ($row = mysqli_fetch_array($result))
         if ($_GET ["id"] == $row [9])
         {
           echo "<h3>
             Фотографии с членом древа ";
           if ($row [2] != "NULL")
             echo $row [2];
           else
             echo "?";
           if ($row [0] != "NULL")
             echo " ".$row [0];
           else
             if ($row [2] != "NULL")
               echo " ?";
           if ($row [1] != "NULL")
             echo " ".$row [1];
           else
             echo "";
           echo "</h3>";
         }
         echo "<p>
         <table class='photo-list'>";
         $i = 0;
         onBD ($result, "PHOTO_PEOPLE");
         while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
           if ($_GET ["id"] == $row [2])
           {
             if (($i % 4) == 0)
               echo "<tr>";
             echo "<td class='photo-link'>
               <p>";
             $dirct = "Albums";
             $hdl = opendir ($dirct);
             while ($file = readdir ($hdl)) 
               if (strstr ($file, "PHOTO".$row [1].".") == true)
               {
                 echo "<a href='detail_photo.php?id=".$row [1]."'><img src ='Albums/".$file
                   ."' style='width: 180'/></a>";
                 break;
               }
             echo "</p>
               </td>";
             $i++;
             if (($i % 4) == 0)
               echo "</tr>";
           }
           echo "</table>";
     }
     else
       echo "<p>
         С данным человеком фотографий на сайте пока нет.
         </p>";
  }
  else
    echo "Кажется, вы ошиблись страницей.";
  include "footer.php";
?>