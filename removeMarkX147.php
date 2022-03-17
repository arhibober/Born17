<script type="text/javascript" src="ajax.js"></script>
<?php
  $index = 0;
  if ($_GET [photo] > 0)
  {
    include "functions147.php";
    onBD ($result1, "PHOTO_PEOPLE");
    while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
      if (($row1 [1] == $_GET [photo]) && ($row1 [2] == $_GET [relative]))
        fromBD ($result, "PHOTO_PEOPLE", $row1 [0]);
    echo "<div id='dest5'>";
    $isPeople = false;
    $i = 0;
    onBD ($result1, "PHOTO_PEOPLE");
    while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
      if ($row1 [1] == $_GET [photo])
        $i++;
    onBD ($result1, "PHOTO_PEOPLE");
    $j = 0;
    while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
      if ($row1 [1] == $_GET [photo])
      {
        if (!$isPeople)
          echo "<table style='width: 900px; border: 0'><tr>
          <td>
          На этой фотографии: ";
        echo "<a href='data.php?id=".$row1 [2]."'>";
        onBD ($result2, "PEOPLE");
        while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
          if ($row2 [9] == $row1 [2])
          {
            if ($row2 [2] != "NULL")
              echo $row2 [2];
            else
              echo "?";
            if ($row2 [0] != "NULL")
              echo " ".$row2 [0];
            else
              if ($row2 [2] != "NULL")
                echo " ?";
            if ($row2 [1] != "NULL")
              echo " ".$row2 [1];
            else
              echo "";
          }
          echo "</a> <a href='javascript:h()'>x</a>";
          $isPeople = true;
          if ($j == $i - 1)
            echo "</td>
              </tr>
              </table>"; 
          else
            echo ", ";       
          $j++;
      }
    echo "</div>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
?>