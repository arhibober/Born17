<?php
  $index = 0;
  ob_start ();
  setcookie ("account", "");
  include "functions147.php";
  include "menu.php";
  echo "<p>";
  if ($_GET ["photo_id"] == 0)
    echo "Кажется, Вы ошиблись страницей.";
  else
  {
    onBD ($result, "PHOTO");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $_GET ["photo_id"])
      {
        echo "<table style='width: 900px; border: 0'>
          <tr>
          <td>
          <p>";
        $dirct = "Albums";
        $hdl = opendir ($dirct);
        while ($file = readdir ($hdl)) 
        if (strstr ($file, "PHOTO".$row [0].".") == true)
        {
          echo "<img src ='Albums/".$file."' style='width: 600'/>";
          break;
        }
        echo "</p>
          </td>
          </tr>";
        if ($row [1] != "NULL")
          echo "<tr>
          <td>".
          $row [1].
          "</td>
          </tr>";
        $isPeople = false;
        $i = 0;
        onBD ($result1, "PHOTO_PEOPLE");
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row1 [1] == $_GET ["photo_id"])
            $i++;
        onBD ($result1, "PHOTO_PEOPLE");
        $j = 0;
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row1 [1] == $_GET ["photo_id"])
          {
            if (!$isPeople)
              echo "<tr>
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
            echo "</a>";
            $isPeople = true;
            if ($j == $i - 1)
              echo "</td>
                </tr>"; 
            else
              echo ", ";       
            $j++;
         }                
         echo "<tr>
           <td>
           <p>
           <a href='photo_list147.php?id=".$row [2]."'>Перейти к альбому</a>
           </p>
           </td>
           </tr>";
         $temp = 0;
         onBD ($result1, "PHOTO");
         while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
         {
           if ($row1 [2] == $row [2])
           {
             if (($row1 [0] == $row [0]) && ($temp != 0))
               echo "<tr>
                 <td>
                 <p>
                 <a href='detail_photo.php?id=".$temp."'>Предыдущее фото</a>
                 </p>
                 </td>
                 </tr>";
             if ($temp == $row [0])
               echo "<tr>
                 <td>              
                 <p class='cent'>
                 <a href='detail_photo.php?id=".$row1 [0]."'>Следующее фото</a>
                 </p>
                 </td>
                 </tr>";
           }              
           $temp = $row1 [0];
         }
         $nom = "comment";
         $dirct = "photo".$_GET ["photo_id"];
         $hdl = opendir ($dirct);
         while ($file = readdir ($hdl)) 
           if (strstr ($file, $nom) == true)
             $a [] = $file;
         $l = sizeof ($a);
         if ($l != 0)
         {
           echo "<tr>
             <td>
             <p>
             Комментарии:
             </p>";
           rsort ($a);
           foreach ($a as $k)
           {
             echo "<div>
               <table cellpadding='5' style='border: 0'; width='100%' align='center'>
               <tr>
               <td>
               <p>
               №".$l;
             $file = fopen ($dirct."/".$k, "r");
             onBD ($result1, "ACCOUNTS");
             while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
               if ($row1 [3] == substr ($k, 18, strlen ($k) - 18))
               {
                 echo "&nbsp;&nbsp;".date ("d/m/Y H:i", substr ($k, 7, 10))."
                   </p>
                   </td>
                   <td width='600' rowspan='2'>\n";
                 echo fgets ($file, 10000);
                 while (!feof ($file))
                 {
      	           $i = 0;
                   $temp = fgets ($file, 10000);
      	           while (substr ($temp, $i, 1) == " ")
      	             $i++;
      	           for ($j = 0; $j < $i; $j++)
      	             echo "&nbsp";
                   echo substr ($temp, $i, strlen ($temp) - $i);
      	           $b = true;
      	           echo "<br/>";
                 }
                 echo "</td>
                   </tr>
                   <tr>
                   <td width='100'>
                   <p>".
                   $row1 [0]
                   ."</p>
                   </td>
                   </tr>
                   </table>
                   </div>";
               }
             fclose ($file);
             $l--;
           }
           echo "</td>
             </tr>";
         }
         echo "<tr>
           <td>
           <form method='post' action='add_comment147.php' name='form'
           onSubmit='return overify(this)'>
           <p>
           Чтоб иметь возможность комментировать фотографии либо отмечать на них своих родственников,
             войдите на сайт под своим аккаунтом.<br/>
           Никнейм:<br/>
           <input type='text' name='nickName'/><br/>
           Пароль:<br/>
           <input type='password' name='password'/><br/>
           Текст сообщения:<br/>
           <textarea name='otziv' cols='60' rows='10'/></textarea><br/>
           <br/>
           <input type='hidden' name='photo_id1' value='".$_GET ["photo_id"]."'/>
           <input name='submit' type='submit' value='Добавить'/>
           </p>
           </form>
           </td>
           </tr>
           </table>";
      }
  }
  include "footer.php";
?>

<script language="javascript">
  function overify (f)
  {
    b = true;
    if (f.nickName.value.length == 0)
    {
      alert ("Вы не ввели никнейм!");
      b = false;
    }
    if (f.password.value.length == 0)
    {
      alert ("Вы не ввели пароль!");
      b = false;
    }
    if (f.otziv.value.length == 0)
    {
      alert ("Вы не ввели текст комментария!");
      b = false;
    }
    if (f.nickName.value.indexOf (">") != -1)
    {
      alert("Никнейм содержит закрывающийся тег XML!");
      b = false;
    }
    if (f.nickName.value.indexOf ("<") != -1)
    {
      alert ("Никнейм содержит открывающийся тег XML!");
      b = false;
    }
    if (f.nickName.value.indexOf ("'") != -1)
    {
      alert ("Никнейм содержит одинарные кавычки!");
      b = false;
    }
    if (f.nickName.value.indexOf ("\"") != -1)
    {
      alert ("Никнейм содержит двойные кавычки!");
      b = false;
    }
    if (f.nickName.value.indexOf ("&") != -1)
    {
      alert ("Никнейм содержит амперсант!");
      b = false;
    }
    if (f.password.value.indexOf (">") != -1)
    {
      alert ("Пароль содержит закрывающийся тег XML!");
      b = false;
    }
    if (f.password.value.indexOf ("<") != -1)
    {
      alert ("Пароль содержит открывающийся тег XML!");
      b = false;
    }
    if (f.password.value.indexOf ("'") != -1)
    {
      alert ("Пароль содержит одинарные кавычки!");
      b = false;
    }
    if (f.password.value.indexOf ("\"") != -1)
    {
      alert ("Пароль содержит двойные кавычки!");
      b = false;
    }
    if (f.password.value.indexOf ("&") != -1)
    {
      alert ("Пароль содержит амперсант!");
      b = false;
    }
    return b;
  }
</script>