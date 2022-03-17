<?php
  $index = 2;
  include "menu.php";
  include "functions147.php";
  echo "<h3>
    Каталог членов всех деревьев (по алфавиту)
    </h3>
  <p>";
  onBDName ($result);
  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	if (($row [0] != "virt") && ($row [0] != "NULL") && ($row [2] != "NULL"))
  	{
  	  echo "<a href='data.php?id=".$row [9]."'>".$row [2]." ".$row [0];
  	  if ($row [1] != "NULL")
  	    echo " ".$row [1];
  	  echo "<br/>";
    }
  echo "<br/>
  <br/>
  <a href='rel_age.php'>Каталог членов всех деревьев в хронологическом порядке</a>
  </p>";   
  include "footer.php";
?>