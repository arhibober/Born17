<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
  onBD ($result, "PEOPLE");
  $isCorrect = false;
  $isIndex = false;
  onBD ($result, "PEOPLE");
  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
    if ($row [9] == $_GET ["id"])
      $isIndex = true;
  onBD ($result, "PEOPLE");
  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))  
    if (($row [9] == $_GET ["id"]) && ($row [0] != "virt") && ($isIndex))
    {     
      $isCorrect = true;
      echo "<table style='border: 0' align='center'>
        <tr>
          <td colspan='2'>
            <h3>";
      if ($row [2] != "NULL")
        echo $row [2];
      else
        echo "?";
      onBD ($result1, "HUSBEND_SERNAMES");
      $fs = true;
      while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
        if ($row [9] == $row1 [1])
          if ($fs)
          {
            echo " (".$row1 [2];
            $fs = false;
          }
          else
            echo ", ".$row1 [2];
      if (!$fs)
        echo ") ";
      if ($row [0] != "NULL")
        echo " ".$row [0];
      else
        if ($row [2] != "NULL")
          echo " ?";
      if ($row [1] != "NULL")
        echo " ".$row [1];
      else
        echo "";
      echo "</h3>
      </td>
      </tr>";
      if (($row [3] != 0) || ($row [6] != 0))
        echo "<tr>
        <td>
          Время жизни:
        </td>
        <td>";
      if ($row [3] != 0)
      {
        if ($row [16] != 0)
        {
          echo "Р. в период ".(2 * $row [3] - $row [16] - $row [18])."-".$row [16];
          if ($row [13] != "NULL")
            echo ", ".$row [13];
          if ($row [6] != 0)
            echo ". ";
        }
        else
        {
          if ($row [6] == 0)
            echo "Р. ";
          if ($row [4] != 0)
          {
            if ($row [5] != 0)
              echo $row [5].".";
            echo $row [4].".";	
          }
          echo $row [3];
          if ($row [13] != "NULL")
            echo ", ".$row [13];
          if ($row [6] != 0)
            if ($row [17] == 0)
              echo "-";
            else
              echo ". ";
        }
      }
      if ($row [6] != 0)
      {
        if ($row [17] != 0)
          echo "Ум. в период ".(2 * $row [6] - $row [17] - $row [19])."-".$row [17];
        else
        {          
          if (($row [3] == 0) || ($row [16] != 0))
            echo "Ум. ";
          if ($row [7] != 0)
          {
            if ($row [8] != 0)
              echo $row [8].".";
            echo $row [7].".";	
          }
          echo $row [6];
        }
        if ($row [14] != "NULL")
          echo ", ".$row [14];
      }
      if ($row [3] != 0 || $row [6] != 0)
        echo "</td>
          </tr>";
      if ($row [12] != 0)
        echo "<tr>
          <td>
            Пол:
           </td>";
      if ($row [12] == 1)
        echo "<td>
          мужской";
      if ($row [12] == 2)
        echo "<td>
          женский";      
      if ($row [12] != 0)
        echo "</td>
          </tr>";
      onBD ($result1, "PEOPLE");
      while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
      {
        if (($row1 [9] == $row [10]) && ($row1 [0] != "virt"))
        {
          echo "<tr>
            <td>
              Мать:
            </td>
            <td>
              <a href='data.php?id=".$row1 [9]."'>";
          if ($row1 [2] != "NULL")
            echo $row1 [2];
          else
            echo "?";
          if ($row1 [0] != "NULL")
            echo " ".$row1 [0];
          else
            if ($row1 [2] != "NULL")
              echo " ?";
          if ($row1 [1] != "NULL")
            echo " ".$row1 [1];
          else
            echo "";
          echo "</a>
            </td>
            </tr>";
        }
        if (($row1 [9] == $row [11]) && ($row1 [0] != "virt"))
        {
          echo "<tr>
            <td>
              Отец:
            </td>
            <td>
              <a href='data.php?id=".$row1 [9]."'>";
          if ($row1 [2] != "NULL")
            echo $row1 [2];
          else
            echo "?";
          if ($row1 [0] != "NULL")
            echo " ".$row1 [0];
          else
            if ($row1 [2] != "NULL")
              echo " ?";
          if ($row1 [1] != "NULL")
            echo " ".$row1 [1];
          else
            echo "";
          echo "</a>
            </td>
            </tr>";
        }
      }
      $b = false;
      onBD ($result1, "PEOPLE");
      while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
        if ((($row1 [10] == $row [9]) || ($row1 [11] == $row [9])) && ($row1 [0] != "virt"))
        {
          echo "<tr>
            <td>";
          if ($b)
            $children = "Дети: ";
          else
          {
            switch ($row1 [12])
			{
			  case 0:
                $children = "Ребёнок: ";
				break;
              case 1:
                $children = "Сын: ";
				break;
			  case 2:
                $children = "Дочь: "; 
				break;
			}
            $b = true;
          }
        }
      $b = false;
      onBD ($result1, "PEOPLE");
      while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
        if (($row1 [10] == $row [9] || $row1 [11] == $row [9]) && ($row1 [0] != "virt"))
        {
          if (!$b)
            echo $children.
              "</td>
            <td>";
          else
            echo ", ";
          $b = true;          
          echo "<a href='data.php?id=".$row1 [9]."'>";
          if ($row1 [2] != "NULL")
            echo $row1 [2];
          else
            echo "?";
          if ($row1 [0] != "NULL")
            echo " ".$row1 [0];
          else
            if ($row1 [2] != "NULL")
              echo " ?";
          if ($row1 [1] != "NULL")
            echo " ".$row1 [1];
          else
            echo "";
              echo "</a>";
        }
      if ($b)
        echo "</td>
          </tr>";
      onBD ($result1, "PEOPLE");
      $b = false;
      $b1 = false;
      if ($row [12] == 1)
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row1 [11] == $row [9])
          {
            onBD ($result2, "PEOPLE");
            while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
              if ($row1 [10] == $row2 [9])
              {
            	onBD ($result3, "PEOPLE");
            	while ($row3 = mysqli_fetch_array ($result3, MYSQLI_NUM))
           	  if (($row3 [10] == $row1 [10]) && ($row3 [11] == $row1 [11]))
            	  {
                    if ($row3 [9] == $row1 [9])
          	    {
          	      if ($b)          	
                      $b1 = true; 
                      $b = true;
              	    }
              	    break;
          	  }
              }
          }
      if ($row [12] == 2)
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row1 [10] == $row [9])
          {
            onBD ($result2, "PEOPLE");
            while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
              if ($row1 [11] == $row2 [9])
              {
            	onBD ($result3, "PEOPLE");
            	while ($row3 = mysqli_fetch_array ($result3, MYSQLI_NUM))
            	  if (($row3 [10] == $row1 [10]) && ($row3 [11] == $row1 [11]))
            	  {
                    if ($row3 [9] == $row1 [9])
          	    {
          	      if ($b)
          	        $b1 = true;             
                      $b = true;
              	    }
              	    break;
          	  }
              }
          };
      onBD ($result1, "PEOPLE");
      $b = false;
      if ($row [12] == 1)
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row1 [11] == $row [9])
          {
            onBD ($result2, "PEOPLE");
            while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
              if ($row1 [10] == $row2 [9])
              {
            	onBD ($result3, "PEOPLE");
            	while ($row3 = mysqli_fetch_array ($result3, MYSQLI_NUM))
            	  if (($row3 [10] == $row1 [10]) && ($row3 [11] == $row1 [11]))
            	  {
                    if ($row3 [9] == $row1 [9])
          	    {
          	      if (!$b)
          	      {
          	        echo "<tr>
          	          <td>";
          	        if ($b1)          	
                          echo "Жёны: ";
                        else
                          echo "Жена: ";
                        echo "</td>
                          <td>";
          	      }
                    else
                      echo ", "; 
                    $b = true;         
                    echo "<a href='data.php?id=".$row2 [9]."'>";
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
                    echo "</a>";
              	  }
              	  break;
          	}
              }
          }
      if ($row [12] == 2)
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row1 [10] == $row [9])
          {
            onBD ($result2, "PEOPLE");
            while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
              if ($row1 [11] == $row2 [9])
              {
          	onBD ($result3, "PEOPLE");
          	while ($row3 = mysqli_fetch_array ($result3, MYSQLI_NUM))
          	  if (($row3 [10] == $row1 [10]) && ($row3 [11] == $row1 [11]))
          	  {
          	    if ($row3 [9] == $row1 [9])
          	    {
          	      if (!$b)
          	      {
          	       	echo "<tr>
          	       	  <td>";
          	        if ($b1)        	
                          echo "Мужья: ";
                        else
                          echo "Муж: ";
                        echo "</td>
                          <td>";
          	      }
                      else
                        echo ", ";              
                      $b = true;         
                        echo "<a href='data.php?id=".$row2 [9]."'>";
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
                      echo "</a>";
              	    }
              	    break;
                }
              }
          };
      if ($b)
        echo "</td>
          </tr>";
      $dirct = "portraits";
      $hdl = opendir ($dirct);
      while ($file = readdir ($hdl)) 
        if (strstr ($file, "PHOTO".$_GET["id"].".") == true)
        {
          echo "<tr>
            <td colspan='2'>
              <p class='cent'>
                <img src ='portraits/".$file."' width='300' alt=''/>
              </p>
            </td>
            </tr>";
          break;
        }
      echo "</p>";
      onBD ($result1, "PHOTO_PEOPLE");
      while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
        if ($row1 [2] == $row [9])
        {
          echo "<tr>
            <td colspan='2'>
            <p class='cent'>
            <a href='mark_list147.php?id=".$row [9]."'>";          
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
            echo " - фотографии</a>
            </td>
            </tr>";
          break;
        }
      if (file_exists ("bio".$_GET ["id"].".txt"))
      {
      	echo "<tr>
      	<td colspan='2'>";
        $file = fopen ("bio".$_GET ["id"].".txt", "r");
        $text = "";      
        while (!feof ($file))
        {
      	  $k = 0;
          $temp = fgets ($file, 10000);
      	  while (substr ($temp, $k, 1) == " ")
      	    $k++;
      	  for ($j = 0; $j < $k; $j++)
      	    $text = $text."&nbsp";
          $text = $text.addLink (substr ($temp, $k, strlen ($temp) - $k))."</br>";
        }
        echo $text."</td></tr>";
      }        
      echo "<tr>
        <td colspan='2'>
          <p class='cent'>          
            <form method='post' action='tree.php#root'>
              <input type='hidden' name='gen' value='5'/><br/>
              <input type='hidden' name='id' value='".$_GET ["id"]."'/>
              <input type='submit' value='";          
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
            echo " - основное генеалогическое древо' class='cent'>
            </form>
            </td>
            </tr><tr>
            <td colspan='2'>
            <p class='cent'>
            <form method='post' action='tree.php#root' onsubmit='return overify (this)'>
              Развёрнутое генеалогическое древо (введите число поколений)
              <input type='text' name='gen'/><br/>
              <input type='hidden' name='id' value='".$_GET ["id"]."'/>
              <input type='submit' value='Показать древо'/>
            </form>
          </p>
        </td>
        </tr>
        <tr>
        <td>
          Установите связь родственника с каким-либо другим членом древа
        </td>
        <td>
          <form action='rel_con147.php' method='post'>
            <select name='rel_con'>";
        onBD ($result, "PEOPLE");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          if ($row [9] != $_GET ["id"])
          {
          	echo "<option value='".$row [9]."'/>";
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
          }
        echo "</select><br/>
        <input type='hidden' value='".$_GET ["id"]."' name='root'/>
        <input type='submit' value='OK' style='margin-top: 10px;'/>
        </form>
        </td>
        </table>";
    }
  if (!$isCorrect)
    echo "Эта страница предназначена для вывода информации о персоналях, хранящихся в базе данных программы, но
      сейчас они загружены быть не могут. Вероятно, Вы попали сюда вообще не с главной страницы.";  
  include "footer.php";
?>
<script language="javascript">
  function overify (f)
  {
    b = true;
    if (f.gen.value.length == 0)
    {
      alert ("Введите число поколений!");
      b = false;
    }
    if ((f.gen.value.length > 0) && !(f.gen.value.match (/^\d*$/)))
    {
      alert ("В ячейке для числа поколений Вы ввели не число!");
      b = false;
    }
    return b;
  }
</script>