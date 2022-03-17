<?php
  function onBD (&$result, $table_name)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ($conn, "SELECT * FROM ".$table_name);
    if (!$result)
    {
      echo " Can't select from ".$table_name;
      return;
    }
  }
  
  function fromBD (&$result, $table_name, $number)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ($conn, "DELETE FROM ".$table_name." WHERE ID ='".$number."'");
    if (!$result)
    {
      echo "Can't delete from ".$table_name;
      return;
    }
  }  
  
  function editDB (&$result, $table, $id, $field_name, $field_value)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ($conn, "UPDATE ".$table." SET ".$field_name."='".$field_value.
      "' WHERE ID=".$id);
    if (!$result)
    {
      echo "Can't update";
      return;
    }
  }
  
  function onBDData (&$result)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ($conn, "SELECT * FROM PEOPLE ORDER BY year_born, month_born, day_born");
    if (!$result)
    {
      echo "Can't select from PEOPLE";
      return;
    }
  }
  
  function onBDName (&$result)
  {
    connect_to_DB ($conn);
    $result = mysqli_query($conn, "SELECT * FROM PEOPLE ORDER BY sername, name, patronymic");
    if (!$result)
    {
      echo "Can't select from PEOPLE";
      return;
    }
  }
  
  function addLink ($text)
  {
    $temp4 = "";
    $temp = $text;
    while (strstr ($temp, "='http://") && (strstr ($temp, "='http://", true) == substr (strstr ($temp,
  	  "http://", true), 0, strlen (strstr ($temp, "http://", true)) - 2)))
    {
      $temp5 = $temp;
      $temp = substr (strstr ($temp5, "http://"), 1, strlen (strstr ($temp5, "http://")) - 1);
      $temp4 = $temp4.substr ($temp5, 0, strlen ($temp5) - strlen ($temp));
    }
    while (strstr ($temp, "=\"http://") && (strstr ($temp, "=\"http://", true) == substr (strstr ($temp, "http://", true), 0, strlen (strstr ($temp, "http://", true)) - 2)))
    {
      $temp5 = $temp;
      $temp = substr (strstr ($temp5, "http://"), 1, strlen (strstr ($temp5, "http://")) - 1);
      $temp4 = $temp4.substr ($temp5, 0, strlen ($temp5) - strlen ($temp));
    }
    if (strstr ($temp, "http://"))
    {
      $temp1 = strstr ($temp, "http://", true);
      if (strstr (substr ($temp, strlen ($temp1), strlen ($temp) - strlen ($temp1)), " "))
      {
        $temp2 = strstr (substr ($temp, strlen ($temp1), strlen ($temp) - strlen ($temp1)), " ", true);
  	    $temp3 = substr ($temp, strlen ($temp1) + strlen ($temp2), strlen ($temp) - strlen ($temp1) - strlen ($temp2));
  	    return $temp4.$temp1."<a href = '".$temp2."'>".$temp2."</a>".addLink ($temp3);
      }
      else
      {
        $temp2 = substr ($text, strlen ($temp1), strlen ($text) - strlen ($temp1));
        return $temp1."<a href = '".$temp2."'>".$temp2."</a>";
      }
    }
    return $temp4.$temp;
  }
  
  function addYearBorn ($root, $rootOld, $gen, $genCur, &$yearSum, &$genQuant, $number)
  {
    $od = file_get_contents ("ayb.txt");
	$curRels = explode ("<br/>", $od);
    $wasRoot = false;
    foreach ($curRels as $curRel)
      if ((strstr ($curRel, "_", true) == $number) && (substr (strstr ($curRel, "_"), 1,
        strlen (strstr ($curRel, "_")) - 1) == $root))
        $wasRoot = true;
    if ((!$wasRoot) && ($genQuant <= 20))
    {
		echo " n: ".$number." r: ".$root;
	    if (!$handle = fopen ("ayb.txt", "a"))
	    {
			echo "Не открывается список связей!";
			exit;
		}
		// Записываем $somecontent в наш открытый файл.
		if (fwrite ($handle, $number."_".$root."<br/>") === FALSE)
		{
			echo "Не получается записать новую связь!";
			exit;
		}
		onBD ($result, "PEOPLE");
		while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
			if ($row [9] == $root)
			{
				if (($gen == $genCur) && ($row [3] > 0))
				{
					$yearSum += $row [3];
					$genQuant++; 
				}
				onBD ($result1, "PEOPLE");
				while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
				{
					if (($row [10] == $row1 [9]) && ($row1 [9] != $rootOld))
						addYearBorn ($row [10], $root, $gen, $genCur + 1, $yearSum, $genQuant, $number);
					if (($row [11] == $row1 [9]) && ($row1 [9] != $rootOld))
						addYearBorn ($row [11], $root, $gen, $genCur + 1, $yearSum, $genQuant, $number);
					if ((($row1 [11] == $row [9]) || ($row1 [10] == $row [9])) && ($row1 [9] != $rootOld))
						addYearBorn ($row1 [9], $root, $gen, $genCur - 1, $yearSum, $genQuant, $number);
				}
			}
    }
  }
  
  function connect_to_DB (&$conn)
  {  
    $conn = mysqli_connect ("localhost:3306", "root", "", "test")
      or die ("Невозможно установить соединение: ".mysqli_error ());
    mysqli_query ($conn, 'SET NAMES "utf8" COLLATE "utf8_general_ci"');
    if (!mysqli_set_charset ($conn, "utf8"))
    {
      echo "Ошибка при загрузке набора символов utf8: ".mysqli_error ($link);
      exit ();
    }
    $database = "Born17";
    mysqli_select_db ($conn, $database); // выбираем базу данных
  }
?>