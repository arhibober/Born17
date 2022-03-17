<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
  if ($_POST ["account"] != "")
  {
    $id = 0;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [9] > $id)
        $id = $row [9];
    if ($_POST ["r_name"] != "")
      $name = $_POST ["r_name"];
    else
      $name = "NULL";
    if ($_POST ["patronymic"] != "")
      $patronymic = $_POST ["patronymic"];
    else
      $patronymic = "NULL";
    if ($_POST ["sername"] != "")
      $sername = $_POST ["sername"];
    else
      $sername = "NULL";
    if ($_POST ["year_born"] != "")
      if ($_POST ["ybl"] != "")
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
    if ($_POST ["ybl"] != "")
      $ybl = $_POST ["ybl"];
    else
      $ybl = 0;      
    if ($_POST ["year_born"] == "")
    {  
      if (($year_born == 0) && ($_POST ["mother"] > 0))
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
		echo " n: ".$n;
        addYearBorn ($_POST ["father"], 0, 0, 1, $yearSum, $genQuant, $n);
        if ($genQuant > 0)
          $yearBorn = (integer)($yearSum / $genQuant);
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
    if ($_POST ["year_die"] != "")
      if ($_POST ["ydl"] != "")
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
    if ($_POST ["ydl"] != "")
      $ydl = $_POST ["ydl"];
    else
      $ydl = 0;
    if ($_POST ["month_die"] != "none")
      $month_die = $_POST ["month_die"];
    else
      $month_die = "NULL";
    if ($_POST ["day_die"] != "none")
      $day_die = $_POST ["day_die"];
    else
      $day_die = 0;
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
    if ($_POST ["town_born"] != "")
      $town_born = $_POST ["town_born"];
    else
      $town_born = "NULL";
    if ($_POST ["town_die"] != "")
      $town_die = $_POST ["town_die"];
    else
      $town_die = "NULL";
  	$hdl = fopen ("bio".($id + 1).".txt", "w+");  	  
    $hdl1 = opendir ("links");
    $bio_text = $_POST ["bio"];
    if (strlen ($bio_text) > 0)
      fwrite ($hdl, $bio_text);
  	fclose ($hdl);  	
    if (strlen ($bio_text) == 0)
      unlink ("bio".($id + 1).".txt");
    if (strlen($_FILES ["myfile"]["name"]) > 0)
    {
      if($_FILES ["myfile"]["size"] > 1048756)
      {
        echo "<p>
          Размер портрета превышает один мегабайт
          </p>";
        exit;
      }
      // Проверяем загружен ли файл
      if (is_uploaded_file ($_FILES ["myfile"]["tmp_name"]))
      {
        // Если файл загружен успешно, перемещаем его
        // из временной директории в конечную
        move_uploaded_file ($_FILES ["myfile"]["tmp_name"],
          "C:/xampp/htdocs/Born17/portraits/PHOTO".($id + 1).substr($_FILES["myfile"]["name"],
          strlen ($_FILES ["myfile"]["name"]) - 4, 4));
        echo "<p>
          Портрет успешно загружен.
          </p>";
      } 	
      else
      {
        echo "<p>
          Ошибка загрузки портрета.
          </p>";
        exit;
      }
    }    
    toBD ($result, $name, $patronymic, $sername, $year_born, $month_born, $day_born, $year_die, $month_die,
      $day_die, $id + 1, $mother, $father, $is_man, $town_born, $town_die, $_POST ["account"], $ybl, $ydl,
      $born_even, $die_even);
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";  
  include "footer.php";
  function toBD ($result, $name, $patronymic, $sername, $year_born, $month_born, $day_born, $year_die,
    $month_die, $day_die, $id, $mother, $father, $is_man, $town_born, $town_die, $account, $ybl, $ydl,
    $born_even, $die_even)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ($conn, "INSERT INTO PEOPLE VALUES('".$name."', '".$patronymic."', '".$sername."', '".
      $year_born."', '".$month_born."', '".$day_born."', '".$year_die."', '".$month_die."', '".$day_die."', '".
      $id."', '".$mother."', '".$father."', '".$is_man."', '".$town_born."', '".$town_die."', '".$account.
      "', '".$ybl."', '".$ydl."', '".$born_even."', '".$die_even."')");
    if (!$result)
    {
      echo "Can't insert into PEOPLE";
      return;
    }
    echo "<p>
      Информация о человеке успешно загружена.
      </p>";
  }
?>