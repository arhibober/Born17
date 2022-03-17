<meta name="robots" content="noindex"/>
<script type="text/javascript" src="ckeditor.js"></script>  
<script src="sample.js" type="text/javascript"></script>  
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="wz_jsgraphics.js"></script>
<script type="text/javascript" src="js/jquery.scrollTo-min.js"></script>
<?php
  $index = 0;
  $monthes = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль",
  "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
  include "functions147.php";
  if ($_GET ["ind"] > 0)
  {
    $ind = $_GET ["ind"];
    $ind1 = $_GET ["ind1"];
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [9] == $ind)
      {
        echo "<table style='border: 0' align='center' id='edit'>
          <tr>
          <td style='width: 335px'>
          Пол родственника:
          </td>
          <td>
          <input type='radio' name='sex' value='none'";
        if ($row [12] == 0)
          echo " checked";
        echo "/>Не указан<br/>
          <input type='radio' name='sex' value='male'";
        if ($row [12] == 1)
          echo " checked";
        echo "/>Мужской<br/>
          <input type='radio' name='sex' value='female'";
        if ($row [12] == 2)
          echo " checked";
        echo "/>Женский<br/>
          </td>
          </tr>
          <tr>
          <td>
          Имя родственника:
          </td>
          <td>
          <input type='text' name='r_name' value='";
        if ($row [0] != "NULL")
          echo $row [0];
        else
          echo "Не задано";
        echo "'></input>
          </td>
          </tr>
          <tr>
          <td>
          Отчество родственника:
          </td>
          <td>
          <input type='text' name='patronymic' value='";
        if ($row [1] != "NULL")
          echo $row [1];
        else
          echo "Не задано";
        echo "'></input>
          </td>
          </tr>
          <tr>
          <td>
          Фамилия родственника:
          </td>
          <td>
          <input type='text' name='sername' value='";
          if ($row [2] != "NULL")
            echo $row [2];
          else
            echo "Не задана";
          echo "'></input>
            </td>
            </tr><tr>
              <td>
              Год рождения родственника (достоверный, или его оценка снизу):
              </td>
              <td>
              <input type='text' name='year_born' value='";
            if ($row [3] != 0)
            {
              if ($row [16] == 0)
                echo $row [3];
              else
                echo (2 * $row [3] - $row [16] - $row [18]);
            }
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Оценка сверху года рождения рождения (в случае отличия от оценки снизу):
              </td>
              <td>
              <input type='text' name='ybl' value='";
            if ($row [16] != 0)
              echo $row [16];
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Месяц рождения родственника:
              </td>
              <td>
              <select name='month_born' size='1'>
              <option value='none'";
            if ($row [4] == 0)
              echo " selected";
            echo "/>Не указан";
            for ($i = 1; $i < 13; $i++)
            {
              echo "<option value='".$i."'";
              if ($i == $row [4])
                echo " selected";
              echo "/>".$monthes[$i - 1];
            }
            echo "</select>
              </td>
              </tr>
              <tr>
              <td>  
              День рождения родственника:
              </td>
              <td>
              <select name='day_born' size='1'>
              <option value='none'";
            if ($row [5] == 0)
              echo " selected";
            echo "/>Не указан";
            for ($i = 1; $i <= 31; $i++)
            {
              echo "<option value='".$i."'";
              if ($row [5] == $i)
                echo " selected";
              echo"/>".$i;
            }
            echo "</select>
              </td>
              </tr>
              <tr>
              <td>
              Город рождения родственника:
              </td>
              <td>
              <input type='text' name='town_born' value='";
            if ($row [13] != "NULL")
              echo $row [13];
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Год смерти родственника (достоверный, или его оценка снизу):
              </td>
              <td>
              <input type='text' name='year_die' value='";
            if ($row [6] != 0)
            {
              if ($row [17] == 0)
                echo $row [6];
              else
                echo (2 * $row [6] - $row [17] - $row [18]);
            }
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Оценка сверху года смерти рождения (в случае отличия от оценки снизу):
              </td>
              <td>
              <input type='text' name='ydl' value='";
            if ($row [17] != 0)
              echo $row [17];
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
             <tr>
             <td>
             Месяц смерти родственника:
             </td>
             <td>
             <select name='month_die' size='1'>
             <option value='none'";
           if ($row [7] == 0)
             echo " selected";
           echo "/>Не указан";
           for ($i = 1; $i < 13; $i++)
           {
             echo "<option value='".$i."'";
             if ($i == $row [7])
               echo " selected";
             echo "/>".$monthes [$i - 1];
           }
           echo "</select>
             </td>
             </tr>
             <tr>
             <td>  
             День смерти родственника:
             </td>
             <td> 
             <select name='day_die' size='1'>
             <option value='none'";
           if ($row [8] == 0)
             echo " selected";
           echo "/>Не указан";
           for ($i = 1; $i <= 31; $i++)
           {
             echo "<option value='".$i."'";
             if ($row [8] == $i)
               echo " selected";
             echo "/>".$i;
           }
           echo "</select>
             </td>
             </tr>
             <tr>
             <td>
             Город смерти родственника:
             </td>
             <td>
             <input type='text' name='town_die' value='";
           if ($row [14] != "NULL")
             echo $row [14];
           else
             echo "Не задан";
           echo "'></input>
             </td>
             </tr>
             <tr>
             <td>
             Здесь Вы можете исправить выбор матери родственника:
             </td>
             <td> 
             <select name='mother' size='1'>
             <option value='none'/>Не указана";
           onBD ($result1, "PEOPLE");
           while ($row1 = mysqli_fetch_array($result1))
             if (($row1 [12] == 2) && ($row1 [0] != "virt") && ($row [15] == $ind1))
             {
               echo "<option value='".$row1 [9]."'";
               if ($row1 [9] == $row [10])
                 echo " selected";
               echo "/>";
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
             }
           echo "</select>
             </td>
             </tr>
             <tr>
             <td>
             Здесь Вы можете исправить выбор отца родственника:
             </td>
             <td>  
             <select name='father' size='1'>
             <option value='none'/>Не указан";
           onBD ($result1, "PEOPLE");
           while ($row1 = mysqli_fetch_array($result1))
             if (($row1 [12] == 1) && ($row1 [0] != "virt") && ($row [15] == $ind1))
             {
               echo "<option value='".$row1 [9]."'";
               if ($row1 [9] == $row [11])
                 echo " selected";
               echo "/>";
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
             }
           echo "</select>
             </td>
             </tr>
             <tr>
             <td>";
            if (file_exists ("bio".$row [9].".txt"))
            {
              echo "Здесь Вы можете отредактировать биографические сведенья о родственнике.<br/> 
                </td>
                <td>
                <textarea name='bio' cols='60' rows='10' id='bio'>";
              include "bio".$row [9].".txt";
              echo "</textarea>
                </td>
                </tr>
                <tr>
                <td>";
            }
            else
              echo "Здесь Вы можете ввести биографические сведенья о родственнике (ВУЗ, работу, ссылки на
                первоисточники и т. п.).
                </td>
                <td>
                  <textarea name='bio' cols='60' rows='10' id='bio'></textarea>
                </td>
              </tr>
              <tr>
        		<td>";
            $b = false;    
            $dirct = "portraits";
            $hdl = opendir ($dirct);
            while ($file = readdir ($hdl)) 
              if (strstr ($file, "PHOTO".$row [9].".") == true)
              {
                $b = true;
                echo "Здесь Вы можете обновить фотографию родственника:<input name='myfile' TYPE='file'/>
                  </td>
                  <td>
                  <img src ='portraits/".$file."' width='300px' alt=''/><br/>
                  <input type='checkbox' name='removePhoto'/>Удалить фотографию вообще
                  </td>
                  </tr>
                  <tr>
                  <td>";
                break;
            }
			else
			  echo "<input type='hidden' name='removePhoto' value='false'/>";
            if (!$b)
              echo "Здесь Вы можете загрузить фотографию родственника:<input name='myfile' TYPE='file'/>
                </td>
                <td>
                  &nbsp;
                </td>
                </tr>
                </table>";  
            echo "<input type='hidden' name='n' value='".$row [9]."'/>";
        }
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>

<script language="javascript">
  CKEDITOR.replace ("bio");
</script>