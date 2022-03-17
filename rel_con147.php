<?php
  $index = 0;
  echo "<meta name='robots' content='noindex'/>";
  include "menu.php";
  if ($_POST ["rel_con"] == 0)
    echo "<p>Кажется, Вы ошиблись страницей.</p>";
  else
  {
  	$rel = $_POST ["rel_con"];
  	$root = $_POST ["root"];
    include "functions147.php";
  	onBD ($result, "PEOPLE");
  	$success = false;
  	echo " r: ".$root;
  	$f = fopen ("Rel_con/".$rel."_".$root."_".$root, "w+");
  	fclose ($f);
  	while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	{
  	  if ($row [9] == $root)
  	  {
  	    if ($row [11] != 0)
  	    {
          lookGen ($rel, $root, $row [11], $success);
          if ($success)
          {          	
  	        $f = fopen ("ConSuccess/".$rel."_".$root."_".$row [11], "w+");
  	        fclose ($f);
            break;
          }
  	    }
  	    if ($row [10] != 0)
  	    {
          lookGen ($rel, $root, $row [10], $success);
          if ($success)  	    
          {          	
  	        $f = fopen ("ConSuccess/".$rel."_".$root."_".$row [10], "w+");
  	        fclose ($f);
            break;
          }
  	    }
  	  }
  	  if ($row [10] == $root)
  	  {
        lookGen ($rel, $root, $row [9], $success);
        if ($success)
  	    {          	
  	      $f = fopen ("ConSuccess/".$rel."_".$root."_".$row [9], "w+");
  	      fclose ($f);
          break;
        }
  	  }
  	  if ($row [11] == $root)
  	  {
        lookGen ($rel, $root, $row [9], $success);
        if ($success)
        {          	
  	      $f = fopen ("ConSuccess/".$rel."_".$root."_".$row [9], "w+");
  	      fclose ($f);
          break;
        }
  	  }
  	}
  	echo " all ";
    $gen = 0;
    $min_gen = 0;
    $cur = $_POST ["root"];
    while ($cur != $_POST ["rel_con"])
    {
  	  $f = fopen ("isGo/".$rel."_".$root."_".$cur, "w+");
  	  fclose ($f);
      echo " c1: ".$cur;
      $wasRel = false;
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      {
  	    $family = opendir ("ConSuccess");
  	    while ($file = readdir ($family))
  	    {  	      
  	      $file2 = substr (strstr (substr (strstr ($file, "_"), 1, strlen (strstr ($file, "_")) - 1), "_"), 1, strlen (strstr (substr (strstr ($file, "_"), 1, strlen (strstr ($file, "_")) - 1), "_")) - 1);
  	      $f = fopen ("temp/f".$rel."_".$root."_".$file2."c".$cur, "w+");
  	      fclose ($f);
  	      if ((($file2 == $row [10]) || ($file2 == $row [11])) && ($cur == $row [9]))
  	      {
  	      	$wasGo = false;
  	      	$isGo = opendir ("isGo");
  	      	while ($file1 = readdir ($isGo))
  	      	{
  	          $file3 = substr (strstr (substr (strstr ($file1, "_"), 1, strlen (strstr ($file1, "_") - 1)), "_"), 1,
  	            strlen (strstr (substr (strstr ($file1, "_"), 1, strlen (strstr ($file1, "_") - 1)), "_" - 1)) - 1);
  	      	  if ($file3 == $file2)
  	      	    $wasGo = true;
  	      	}
  	      	if (!$wasGo)
  	      	{
  	      	  $gen++;
  	      	  $cur = $file2;
  	      	  $wasRel = true;
  	      	  break;
  	      	}
  	      }
  	      if (($file == $row [9]) && (($cur == $row [10]) || ($cur == $row [11])))
  	      {
  	      	$wasGo = false;
  	      	$isGo = opendir ("isGo");
  	      	while ($file1 = readdir ($isGo))
  	      	  if ($file1 == $file)
  	      	    $wasGo = true;
  	      	if (!$wasGo)
  	      	{
  	      	  $gen--;
  	      	  if ($gen < $min_gen)
  	      	    $gen_min = $gen;
  	      	  $cur = $file;
  	      	  $wasRel = true;
  	      	  break;
  	      	}
  	      }
  	    }
  	    if ($wasRel == true)
  	      break;
      }
    }
  }
  include "footer.php";
  
  function lookGen ($rel, $root, $cur, &$success)
  {
  	echo "c ".$cur;
  	if ($cur == $rel)
  	{
  	  $success = true;
  	  return;
  	}
  	$od = opendir ("Rel_con");
  	$wasRoot = false;
  	while ($file = readdir ($od))
  	  if ($file == $cur)
  	    $wasRoot = true;
  	if (!$wasRoot)
  	{
  	  $f = fopen ("Rel_con/".$rel."_".$root."_".$cur, "w+");
  	  fclose ($f);
  	  onBD ($result, "PEOPLE");
  	  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	  {
  	    if ($row [9] == $cur)
  	    {
  	      if (($row [11] != 0) && (!file_exists ("Rel_con/".$rel."_".$root."_".$row [11])))
  	      {
            lookGen ($rel, $root, $row [11], $success);
            if ($success)
            {
  	          $f = fopen ("ConSuccess/".$rel."_".$root."_".$row [11], "w+");
  	          fclose ($f);
              echo " succ: ".$row [11];
              break;
            }
            echo " rel: ".$row [11];
  	      }
  	      if (($row [10] != 0) && (!file_exists ("Rel_con/".$rel."_".$root."_".$row [10])))
  	      {
            lookGen ($rel, $root, $row [10], $success);
            if ($success)
            {
  	          $f = fopen ("ConSuccess/".$rel."_".$root."_".$row [10], "w+");
  	          fclose ($f);
              echo " succ: ".$row [10];
              break;
            }
            echo " rel: ".$row [10];
  	      }
  	    }
  	    if (($row [10] == $cur) && (!file_exists ("Rel_con/".$rel."_".$root."_".$row [9])))
  	    {
  	      echo 77;
          lookGen ($rel, $root, $row [9], $success);
          if ($success)
          {
  	        $f = fopen ("ConSuccess/".$rel."_".$root."_".$row [9], "w+");
  	        fclose ($f);
            echo " succ: ".$row [9];
            break;
          }
          echo " rel: ".$row [9];
  	    }
  	    if (($row [11] == $cur) && (!file_exists ("Rel_con/".$rel."_".$root."_".$row [9])))
  	    {
          lookGen ($rel, $root, $row [9], $success);
          if ($success)
          {
  	        $f = fopen ("ConSuccess/".$rel."_".$root."_".$row [11], "w+");
  	        fclose ($f);
            echo " succ: ".$row [9];
            break;
          }
          echo " rel: ".$row [9];
  	    }
  	  }
    }
  }
?>