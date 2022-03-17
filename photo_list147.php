<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "functions147.php";
  include "menu.php";
  if ($_GET ["id"] > 0)
  {
    $isPhotos = false;
    onBD ($result, "PHOTO");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($_GET ["id"] == $row [2])
        $isPhotos = true;
     if ($isPhotos)
     {
       onBD ($result, "ALBUM");
       while ($row = mysqli_fetch_array($result))
         if ($_GET ["id"] == $row [0])
           echo "<h3>"
             .$row [1]." - детальный просмотр
             </h3>
               <p>
   	         <table class='photo-list'>";
       $i = 0;
       onBD ($result, "PHOTO");
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
             if (strstr ($file, "PHOTO".$row [0].".") == true)
             {
               echo "<a href='detail_photo.php?id=".$row [0]."'><img src ='Albums/".$file."' style='width: 180'/>
                 </a>";
               break;
             }
           echo "</p>
             </td>";
           $i++;
           if (($i % 4) == 0)
             echo "</tr>";
         }
       echo "</table>
         </p>";   
     }
     else
       echo "<p>
         Альбом пока пуст.
         </p>";
  }
  else
    echo "<p>
      Кажется, вы ошиблись страницей.
      </p>";
  include "footer.php";
?>