<?php
  $index = 2;
  include "menu.php";
  include "functions147.php";
  echo "<h3>
    Каталог членов всех деревьев (в хронологическом порядке)
    </h3>
  <p>";
  onBDData ($result);
  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  if (($row [0] != "virt") && ($row [0] != "NULL") && ($row [2] != "NULL"))
  {
    echo "<a href='data.php?id=".$row [9]."'>".$row [2]." ".$row [0];
    if ($row [1] != "NULL")
      echo " ".$row [1];
    if ($row [3] != 0)
    {
      echo " (";
        if ($row [6] == 0)
          echo "р. ";
      echo $row [3];
      if ($row [6] != 0)
        echo "-";
      else
      {
        if ($row [16] != 0)
          echo "-?";
        echo ")";
      }
    }
    if ($row [6] != 0)
    {
      if ($row [3] == 0)
        echo " (ум. ";
      echo $row [6];        
      if (($row [16] != 0) || ($row [17] != 0))
        echo "-?";
      echo ")";
    }
    echo "<br/>";
  }
  echo "<br/>
  <br/>
  <a href='rel_list.php'>Каталог членов всех деревьев по алфавиту</a>
  </p>";
  include "footer.php";
?>