<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
  if ($_POST ["account"] > 0)
  {
    if (($_POST ["r_name"] != "Не задано") && ($_POST ["r_name"] != ""))
      $name = $_POST ["r_name"];
    else
      $name = "NULL";
    if (($_POST ["patronymic"] != "Не задано") && ($_POST ["patronymic"] != ""))
      $patronymic = $_POST ["patronymic"];
    else
      $patronymic = "NULL";
    if (($_POST ["sername"] != "Не задана") && ($_POST ["sername"] != ""))
      $sername = $_POST ["sername"];
    else
      $sername = "NULL";
    if (($_POST ["year_born"] != "Не задан") && ($_POST ["year_born"] != ""))
      if (($_POST ["ybl"] != "Не задан") && ($_POST ["ybl"] != ""))
      {
        $year_born = ($_POST ["ybl"] + $_POST ["year_born"]) / 2;
        $born_even = ($_POST ["ybl"] - $_POST ["year_born"]) % 2;
      }
      else
      {
        $year_born = $_POST ["year_born"];
        $born_even = 0;
      }
    else
    {
      $year_born = 0;
      $born_even = 0;
    }    
    if (($_POST ["ybl"] != "Не задан") && ($_POST ["ybl"] != ""))
      $ybl = $_POST ["ybl"];
    else
      $ybl = 0;
    $pyb = 0;
    $pc = 0;
    $cyb = 0;
    $cc = 0;
    if (($_POST ["year_born"] == "Не задан") || ($_POST ["year_born"] == ""))
    {
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      {
        if ((($row [9] == $_POST ["mother"]) || ($row [9] == $_POST ["father"])) && ($row [3] > 0))
        {
      	  $pyb += $row [3];
      	  $pc++;
        }
        if (($row [10] == $_POST ["n"]) || ($row [11] == $_POST ["n"]) && ($row [3] > 0))
        {
      	  $cyb += $row [3];
      	  $cc++;
        }
      }
      if (($pc > 0) && ($cc > 0))
      {
        $year_born = ($pyb / $pc + $cyb / $cc) / 2;
        $ybl = $year_born + 20; 
      }
      if (($year_born == 0) && ($_POST ["mother"] > 0))
      {
        $yearSum = 0;
        $genQuant = 0;
        $n = 0;
        $wasRoot = false;
  	$od = opendir ("ayb");
  	while ($file = readdir ($od))
  	  if ((integer)(strstr ($file, "_", true)) > $n)
  	    $n = (integer)(strstr ($file, "_", true));
  	$n++;
        addYearBorn ($_POST ["mother"], 0, 0, 1, $yearSum, $genQuant, $n);
        if ($genQuant > 0)
          $year_born = (integer)($yearSum / $genQuant);
        $ybl = $year_born + 50;
      }
      if (($year_born == 0) && ($_POST ["father"] > 0))
      {
        $yearSum = 0;
        $genQuant = 0;
        $n = 0;
        $wasRoot = false;      
  	$od = file_get_contents ("ayb.txt");
	$curRels = explode ("<br/>", "ayb.txt");
  	foreach ($curRels as $curRel)
          if ((integer)(strstr ($curRel, "_", true)) > $n)
  	        $n = (integer)(strstr ($curRel, "_", true));
  	$n++;
        addYearBorn ($_POST ["father"], 0, 0, 1, $yearSum, $genQuant, $n);
        if ($genQuant > 0)
          $year_born = (integer)($yearSum / $genQuant);
        $ybl = $year_born + 50;
      }
    }
    if ($_POST ["month_born"] != "none")
      $month_born = $_POST ["month_born"];
    else
      $month_born = "NULL";
    if ($_POST ["day_born"] != "none")
      $day_born = $_POST ["day_born"];
    else
      $day_born = 0;
    if (($_POST ["town_born"] != "Не задан") && ($_POST ["town_born"] != ""))
      $town_born = $_POST ["town_born"];
    else
      $town_born = "NULL";
    if (($_POST ["year_die"] != "Не задан") && ($_POST ["year_die"] != ""))
      if (($_POST ["ydl"] != "Не задан") && ($_POST ["ydl"] != ""))
      {
        $year_die = ($_POST ["ydl"] + $_POST ["year_die"]) / 2;
        $die_even = ($_POST ["ydl"] - $_POST ["year_die"]) % 2;
      }
      else
      {
        $year_die = $_POST ["year_die"];
        $die_even = 0;
      }
    else
    {
      $year_die = 0;
      $die_even = 0;
    }
    if (($_POST ["ydl"] != "Не задан") && ($_POST ["ydl"] != ""))
      $ydl = $_POST ["ydl"];
    else
      $ydl = 0;
    if ($_POST ["month_die"] != "none")
      $month_die = $_POST ["month_die"];
    else
      $month_die = 0;
    if ($_POST ["day_die"] != "none")
      $day_die = $_POST ["day_die"];
    else
      $day_die = 0;
    if (($_POST ["town_die"] != "Не задан") && ($_POST ["town_die"] != ""))
      $town_die = $_POST ["town_die"];
    else
      $town_die = "NULL";
    if ($_POST ["mother"] != "none")
      $mother = $_POST ["mother"];
    else
      $mother = 0;
    if ($_POST ["father"] != "none")
      $father = $_POST ["father"];
    else
      $father = 0;
    if ($_POST ["sex"] == "none")
      $is_man = 0;
    if ($_POST ["sex"] == "male")
      $is_man = 1;
    if ($_POST ["sex"] == "female")
      $is_man = 2;  
    if (file_exists ("bio".$_POST ["n"].".txt"))
      unlink ("bio".$_POST ["n"].".txt");
    if ($_POST ["removePhoto"] == "false")
    {
      if (strlen ($_FILES ["myfile"]["name"]) > 0)
      {
        $dirct = "portraits";
        $hdl = opendir($dirct);
        while ($file = readdir($hdl)) 
          if (strstr ($file, "PHOTO".$_POST["n"].".") == true)
          {
            unlink ("portraits/".$file);
            break;
          }
        if($_FILES ["myfile"]["size"] > 1048756)
        {
          echo "<p>
            Размер фотографии превышает один мегабайт
            </p>";
          exit;
        }
        // Проверяем загружен ли файл
        if (is_uploaded_file ($_FILES ["myfile"]["tmp_name"]))
        {
          // Если файл загружен успешно, перемещаем его
          // из временной директории в конечную
          move_uploaded_file ($_FILES ["myfile"]["tmp_name"],
            "C:/xampp/htdocs/Born17/portraits/PHOTO".$_POST ["n"].substr ($_FILES ["myfile"]["name"],
            strlen ($_FILES ["myfile"]["name"]) - 4, 4));
          echo "<p>
            Фотография успешно загружена.
            </p>";
        }	
        else
        {
          echo "<p>
            Ошибка загрузки фотографии.
            </p>";
          exit;
        } 	
      }
    }
    else
    {
      $dirct = "portraits";
      $hdl = opendir ($dirct);
      while ($file = readdir ($hdl)) 
        if (strstr ($file, "PHOTO".$_POST["n"].".") == true)
        {
          unlink ("portraits/".$file);
          break;
        }
    }
    if ($_POST ["bio"] != "")
    {
  	  $hdl = fopen ("bio".$_POST ["n"].".txt", "w+");
      $bio_text = $_POST ["bio"];
      if (strlen ($bio_text) > 0)
        fwrite ($hdl, $bio_text);
  	  fclose ($hdl);
    }
    editDB ($result, "PEOPLE", $_POST ["n"], "NAME", $name);    
    editDB ($result, "PEOPLE", $_POST ["n"], "PATRONYMIC", $patronymic);    
    editDB ($result, "PEOPLE", $_POST ["n"], "SERNAME", $sername);    
    editDB ($result, "PEOPLE", $_POST ["n"], "YEAR_BORN", $year_born);    
    editDB ($result, "PEOPLE", $_POST ["n"], "MONTH_BORN", $month_born);    
    editDB ($result, "PEOPLE", $_POST ["n"], "DAY_BORN", $day_born);    
    editDB ($result, "PEOPLE", $_POST ["n"], "YEAR_DIE", $year_die);    
    editDB ($result, "PEOPLE", $_POST ["n"], "MONTH_DIE", $month_die);    
    editDB ($result, "PEOPLE", $_POST ["n"], "DAY_DIE", $day_die);    
    editDB ($result, "PEOPLE", $_POST ["n"], "MOTHER", $mother);    
    editDB ($result, "PEOPLE", $_POST ["n"], "FATHER", $father);    
    editDB ($result, "PEOPLE", $_POST ["n"], "IS_MAN", $is_man);    
    editDB ($result, "PEOPLE", $_POST ["n"], "TOWN_BORN", $town_born);    
    editDB ($result, "PEOPLE", $_POST ["n"], "TOWN_DIE", $town_die);   
    editDB ($result, "PEOPLE", $_POST ["n"], "YBL", $ybl);    
    editDB ($result, "PEOPLE", $_POST ["n"], "YDL", $ydl);
    editDB ($result, "PEOPLE", $_POST ["n"], "BORN_EVEN", $born_even);    
    editDB ($result, "PEOPLE", $_POST ["n"], "DIE_EVEN", $die_even);
    echo "<p>
      Данные о родственнике успешно отредактированы.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  include "footer.php";
?>