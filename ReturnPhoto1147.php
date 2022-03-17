<link rel="stylesheet" type="text/css" href="res/css/photolabel.css"> <!-- стили jQuery.photolabel -->  
<link rel="stylesheet" type="text/css" href="res/css/ui-lightness/jquery-ui-1.8.22.custom.css">
<!-- стили jQuery.ui -->  
<?php
  $index = 0;
  include "functions147.php";
  include "menu.php";
  echo "<p>";
  if ($_GET [photo] == 0)
    echo "Кажется, Вы ошиблись страницей.";
  else
  { 
    echo 9;
    $id = 0;
    onBD ($result, "PHOTO_PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] > $id)
        $id = $row [0];
    onBD ($result, "PHOTO");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $_GET [photo])
      {
        echo "<table style='width: 900px; border: 0'>
          <tr>
          <td>
          <p>
          <div id='dest6'>
          <div class='center'>
          <div id='block-1' class='photoLabel'>
          <div class='imgWrap'>";
        $dirct = "Albums";
        $hdl = opendir ($dirct);
        while ($file = readdir ($hdl)) 
        if (strstr ($file, "PHOTO".$row [0].".") == true)
        {  
          echo "<div id='Canvas'></div>";      	 	
  	      echo "
  	        <img src ='Albums/".$file."' style='width: 600' usemap='#map1' alt=''/><br/>  	      
            <map name='map1'>";
  	      onBD ($result6, "PHOTO_PEOPLE");
          while ($row6 = mysqli_fetch_array ($result6))
            if ($row6 [1] == $_GET [photo])
            {
              echo "<area href='data.php?id=".$row6 [2]."' shape='rect' coords='".$row6 [5].", ".$row6 [3].
                ", ".$row6 [6].", ".$row6 [4]."'  onMouseOver='drawBorder(".$row6 [3].", ".$row6 [4].", ".
                $row6 [5].", ".$row6 [6].")' onMouseOut='returnPhoto1(".$_GET [photo].")' title='";
              onBD ($result7, "PEOPLE");
              while ($row7 = mysqli_fetch_array ($result7))
                if ($row7 [9] == $row6 [2])
                {
                  if ($row7 [2] != "NULL")
                    echo $row7 [2];
                  else
                    echo "?";
                  if ($row7 [0] != "NULL")
                    echo " ".$row7 [0];
                  else 
                    if ($row7 [2] != "NULL")
                      echo " ?";
                  if ($row7 [1] != "NULL")
                    echo " ".$row7 [1];
                  else
                    echo "";
                }
              echo "'/>";
            }
            echo "</map>";
            break;
        }
        if (isset ($_COOKIE ["account"]))
        {
          $i = 0;
          while (substr ($_COOKIE ["account"], $i, 1) != " ")
            $i++;
          $login = substr ($_COOKIE ["account"], 0, $i);
          $password = substr ($_COOKIE ["account"], $i + 1, strlen ($_COOKIE ["account"]) - $i - 1);
          $login_exist = false;
          $ownPhoto = false;
          onBD ($result1, "ACCOUNTS");
          while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
            if ($row1 [0] == $login)
            {
      	      $login_exist = true;
              if ($row1 [2] == $password)
              {
                onBD ($result, "ALBUM");
                while ($row4 = mysqli_fetch_array($result))
                  if (($row [2] == $row4 [0]) && ($row4 [2] == $row1 [3]))
                  {
                  	$ownPhoto = true;
               	    change_json ($row1 [3]);
                    echo "<a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"start\")'
                      class='turnOn'>Отметьте родственника на фото</a>
                      <a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"stop\")' style=
                      'display:none' class='turnOff' onMouseDown='addPhoto (".$_GET ["id"].", ".$row1 [3].", "
                      .$id.")'>Готово</a>
                      </div>
                      </div>
                      </div>";
                  }
              }
              else
                if (strlen ($row3 [0]) > 0)
                {
                  onBD ($result, "ALBUM");
                  while ($row4 = mysqli_fetch_array($result))
                    if (($row [2] == $row4 [0]) && ($row4 [2] == $row3 [3]))
                    {
                      $ownPhoto = true;
                      change_json ($row3 [3]);
                      echo "<a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"start\")' class='turnOn'>Отметьте родственника на фото</a>
                        <a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"stop\")' style='display:none' class='turnOff' onMouseDown='addPhoto (".$_GET ["id"].", ".$row1 [3].", ".$id.")'>Готово</a>";
                    }
               }
            }
            if (!$login_exist)
              if (strlen ($row3 [0]) > 0)
              {
                onBD ($result, "ALBUM");
                while ($row4 = mysqli_fetch_array($result))
                  if (($row [2] == $row4 [0]) && ($row4 [2] == $row3 [3]))
                  {                  	
                    $ownPhoto = true;
               	    change_json ($row3 [3]);
                    echo "<a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"start\")'
                      class='turnOn'>Отметьте родственника на фото</a>
                      <a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"stop\")' style=
                        'display:none' class='turnOff' onMouseDown='addPhoto (".$_GET ["id"].", ".$row1 [3].
                        ", ".$id.")'>Готово</a>";
                  }
              }
          }
          else
            if (strlen ($row3 [0]) > 0)
            {
              onBD ($result, "ALBUM");
              while ($row4 = mysqli_fetch_array($result))
                if (($row [2] == $row4 [0]) && ($row4 [2] == $row3 [0]))
                {
                  change_json ($row3 [3]);
                  echo "<a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"start\")'
                    class='turnOn'>Отметьте родственника на фото</a>
                    <a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"stop\")' style=
                      'display:none' class='turnOff' onMouseDown='addPhoto (".$_GET ["id"].", ".$row1 [3].
                      ", ".$id.")'>Готово</a>";
                }
            }
            echo "</div>
              </div>
              </div>
              </div>
              </p>
              </td>
              </tr>";
        if ($row [1] != "NULL")
          echo "<tr>
            <td>".
            $row [1].
            "</td>
            </tr>";
        echo "</table>
          <div id='dest5'>";
        $isPeople = false;
        $i = 0;
        onBD ($result1, "PHOTO_PEOPLE");
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row1 [1] == $_GET ["id"])
            $i++;
        onBD ($result1, "PHOTO_PEOPLE");
        $j = 0;
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row1 [1] == $_GET ["id"])
          {
            if (!$isPeople)
              echo "<table style='width: 900px; border: 0'>
              <tr>
              <td>
              На этой фотографии: ";
          	echo "<a href='data.php?id=".$row1 [2]."' onMouseOver='drawBorder(".$row1 [3].", ".$row1 [4].", ".
          	  $row1 [5].", ".$row1 [6].")' onMouseOut='returnPhoto(".$_GET ["id"].")'>";
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
            if ($ownPhoto)
              echo "&nbsp;<a href='javascript:removeMark (".$row1 [2].", ".$_GET ["id"].")'>x</a>";
            $isPeople = true;
            if ($j == $i - 1)
              echo "</td>
                </tr>
                </table>"; 
            else
              echo ", ";       
            $j++;
         }                
         echo "</div><table style='width: 900px; border: 0'><tr>
           <td>
           <p>";
         $temp = 0;
         $temp1 = 0;
         $temp2 = 0;
         onBD ($result1, "PHOTO");
         while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
           if ($row1 [2] == $row [2])
           {
             if (($row1 [0] == $row [0]) && ($temp != 0))
               $temp1 = $temp;
             if ($temp == $row [0])
               $temp2 = $row1 [0];
             $temp = $row1 [0];
           }
         if ($temp1 > 0)
           echo "<a href='detail_photo.php?id=".$temp1."'><img src='lb-previous-active.png' style='border: 0'>
             </a>";
         echo "<a href='photo_list147.php?id=".$row [2]."'>Перейти к альбому</a>";
         if ($temp2 > 0)
           echo "&nbsp;<a href='detail_photo.php?id=".$temp2."'><img src='lb-next-active.png'
             style='border: 0'></a> ";
         echo "</p>
           </td>
           </tr>";
         $nom = "comment";
         $dirct = "photo".$_GET ["id"];
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
               <td width='20%'>
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
         $accountID = 0;
         if (isset ($_COOKIE ["account"]))
         {
           $i = 0;
           while (substr ($_COOKIE ["account"], $i, 1) != " ")
             $i++;
           $login = substr ($_COOKIE ["account"], 0, $i);
           $password = substr ($_COOKIE ["account"], $i + 1, strlen ($_COOKIE ["account"]) - $i - 1);
           $login_exist = false;
           onBD ($result1, "ACCOUNTS");
           while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
             if ($row1 [0] == $login)
             {
      	       $login_exist = true;
               if ($row1 [2] == $password)
               {
                 echo "<tr>
                 <td>
                 <form method='post' action='add_comment147.php' name='form' onsubmit=
                   'return overify (this)'>
                 <p>
                   Вы зашли на сайт как ".$row1 [0]."<br>
                   <input type='hidden' name='nickName' value='".$row1 [0]."'/>
                   <input type='hidden' name='password' value='".$row1 [2]."'/><br/>
                   Добавьте свой комментарий:<br/>
                   <textarea name='otziv' cols='60' rows='10'></textarea><br/>
                   <br/>
                   <input type='hidden' name='photo_id1' value=".$_GET [photo].">
                   <input name='submit' type='submit' value='Добавить'/>
                   </p>
                   </form>
                   <form action='exit3147.php'>
      	           <p>
      	           <input type='hidden' name='photo_id' value='".$_GET [photo]."'/>
      	           <input type='submit' name='exit' value='Выйти из системы'/>
      	           </p>
      	           </form>";
          	     $accoutntID = $row1 [3];
               }
               else
                 if (strlen ($row3 [0]) > 0)
                 {
                   echo "<tr>
          	         <td>
          	         <form method='post' action='add_comment147.php' name='form' onsubmit=
          	           'return overify (this)'>
          	         <p>
                     Вы зашли на сайт как ".$row3 [0]."<br>
                     <input type='hidden' name='nickName' value='".$row3 [0]."'/>
                     <input type='hidden' name='password' value='".$row3 [2]."'/><br/>
                     Добавьте свой комментарий:<br/>
                     <textarea name='otziv' cols='60' rows='10'></textarea><br/>
                     <br/>
                     <input type='hidden' name='photo_id1' value=".$_GET ["id"].">
                     <input name='submit' type='submit' value='Добавить'/>
                     </p>
                     </form>
                     <form action='exit3147.php'>
      	             <p>      	             
                     <input type='hidden' name='photo_id' value='".$_GET ["id"]."'/>
                     <input type='submit' name='exit' value='Выйти из системы'/>
      	             </p>
      	             </form>";
          	       $accoutntID = $row3 [3];
                 }
                 else
                   echo "<tr>
                     <td>
                     <form method='post' action='add_comment147.php' name='form'
                       onsubmit='return overify (this)'>
                     <p>
                     Чтоб иметь возможность комментировать фотографии либо отмечать на них своих
                       родственников, войдите на сайт под своим аккаунтом.<br/>
                     Никнейм:<br/>
                     <input type='text' name='nickName'/><br/>
                     Пароль:<br/>
                     <input type='password' name='password'/><br/>
                     Текст сообщения:<br>
                     <textarea name='otziv' cols='60' rows='10'></textarea><br/>
                     <br/>
                     <input type='hidden' name='photo_id1' value='".$_GET ["id"]."'/>
                     <input name='submit' type='submit' value='Добавить'/>
                     </p>
                     </form>";
            }
            if (!$login_exist)
              if (strlen ($row3 [0]) > 0)
              {
                echo "<tr>
          	      <td>
          	      <form method='post' action='add_comment147.php' name='form'
          	        onsubmit='return overify (this)'>
          	      <p>
                  Вы зашли на сайт как ".$row3 [0]."<br>
                  <input type='hidden' name='nickName' value='".$row3 [0]."'/>
                  <input type='hidden' name='password' value='".$row3 [2]."'/><br/>
                  Добавьте свой комментарий:<br/>
                  <textarea name='otziv' cols='60' rows='10'></textarea><br/>
                  <br/>
                  <input type='hidden' name='photo_id1' value=".$_GET [photo].">
                  <input name='submit' type='submit' value='Добавить'/>
                  </p>
                  </form>
                  <form action='exit3147.php'>
      	          <p>
      	          <input type='hidden' name='photo_id' value='".$_GET [photo]."'/>
      	          <input type='submit' name='exit' value='Выйти из системы'/>
      	          </p>
      	          </form>";                
          	     $accoutntID = $row3 [3];
              }
              else         
                echo "<tr>
                  <td>
                  <form method='post' action='add_comment147.php' name='form'
                    onsubmit='return overify (this)'>
                    <p>
                      Чтоб иметь возможность комментировать фотографии либо отмечать на них своих
                        родственников, войдите на сайт под своим аккаунтом.<br/>
                      Никнейм:<br/>
                      <input type='text' name='nickName'/><br/>
                      Пароль:<br/>
                    <input type='password' name='password'/><br/>
                    Текст сообщения:<br/>
                    <textarea name='otziv' cols='60' rows='10'></textarea><br/>
                    <br/>
                    <input type='hidden' name='photo_id1' value='".$_GET [photo]."'/>
                    <input name='submit' type='submit' value='Добавить'/>
                    </p>
                    </form>";
          }
          else
            if (strlen ($row3 [0]) > 0)
            {
              echo "<tr>
                <td>
                <form method='post' action='add_comment147.php' name='form' onsubmit='return overify (this)'>
                <p>
                Вы зашли на сайт как ".$row3 [0]."<br>
                <input type='hidden' name='nickName' value='".$row3 [0]."'/>
                <input type='hidden' name='password' value='".$row3 [2]."'/><br/>
                Добавьте свой комментарий:<br/>
                <textarea name='otziv' cols='60' rows='10'></textarea><br/>
                <br/>
                <input type='hidden' name='photo_id1' value=".$_GET [photo].">
                <input name='submit' type='submit' value='Добавить'/>
                </p>
                </form>
                <form action='exit3147.php'>
      	        <p>
      	        <input type='hidden' name='photo_id' value='".$_GET [photo]."'/>
      	        <input type='submit' name='exit' value='Выйти из системы'/>
      	        </p>
      	        </form>";              
          	  $accoutntID = $row3 [3];
            }
            else
              echo "<tr>
                <td>
                <form method='post' action='add_comment147.php' name='form' onsubmit='return overify (this)'>
                <p>
                Чтоб иметь возможность комментировать фотографии либо отмечать на них своих родственников,  войдите на сайт под своим аккаунтом.<br/>
                Никнейм:<br/>
                <input type='text' name='nickName'/><br/>
                Пароль:<br/>
                <input type='password' name='password'/><br/>
                Текст сообщения:<br/>
                <textarea name='otziv' cols='60' rows='10'/></textarea><br/>
                <br/>
                <input type='hidden' name='photo_id1' value='".$_GET [photo]."'/>
                <input name='submit' type='submit' value='Добавить'/>
                </p>
                </form>";
            echo "</td>
            </tr>
            </table>
            <script>
            function f()
            {
              return {";
             if ($accounID > 0)
             {
               $i = 1;
              onBD ($result, "PEOPLE");
              while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
              {
                echo "\"1\": {id: ".$i.", fullname:";
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
                echo ", url: \"JavaScript: alert('data.php?id=".$row [9]."')\"}, ";
                  $i++;
              }
            }
            echo "};
      }
    </script>";            
    }
  }
  include "footer.php";
  function change_json ($aid)
  {
    $i = 0;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if (($row [0] != "virt") && ($aid = $row [15]))
      {
        $n [($i + 1).""]["id"] = $row [9];
        $n [($i + 1).""]["fullname"] = "";
        if ($row [2] != "NULL")
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"].$row [2];
        else
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]."?";
        if ($row [0] != "NULL")
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]." ".$row [0];
        else
          if ($row [2] != "NULL")
            $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]." ?";
        if ($row [1] != "NULL")
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]." ".$row [1];
        else
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]."";
        $n [($i + 1).""]["url"] = "data.php?id=".$row [9];
        $i++;
      }
    $f = fopen("photo.json", "w");
    fwrite ($f, json_encode(json_fix_cyr($n)));   
    fclose ($f);
  }
  function json_fix_cyr($var)
  {
    if (is_array ($var))
    {
      $new = array ();
      foreach ($var as $k => $v)
        $new [json_fix_cyr ($k)] = json_fix_cyr ($v);
      $var = $new;
    }
    elseif (is_object($var))
    {
      $vars = get_object_vars($var);
      foreach ($vars as $m => $v)
        $var->$m = json_fix_cyr($v);
    }
    elseif (is_string($var))
       $var = iconv('cp1251', 'utf-8', $var);
    return $var;
  }
?>
  
<script type="text/javascript" src="res/js/jquery/jquery-1.7.2.min.js"></script> <!-- jQuery -->  
<script type="text/javascript" src="res/js/jquery/jquery-ui-1.8.22.custom.min.js"></script>
<!-- jQuery.ui -->  
<script type="text/javascript" src="res/js/jquery.photolabel.js"></script> <!-- плагин jQuery.photolabel-->
<script language="javascript">
  $(function ()
  {  
    $('#block-1 .imgWrap').photoLabel(
    {  
      onStart: function()
      { //Обработчик на событие - "start" (начало процедуры отметок на фото)
        $('#block-1 .turnOn').hide();  
        $('#block-1 .turnOff').show();
      },  
      onStop: function()
      { //Обработчик на событие - "stop" (завершение процедуры отметок на фото)  
        $('#block-1 .turnOn').show();  
        $('#block-1 .turnOff').hide();  
      },  
      recoverContainer: '#block-1 .recoverTags', //Контейнер для ссылки "восстановить тег"  
      labelListContainer: '#block-1 .labelList', //Общий контейнер, для списка отметок.  
      labelContainer: '#block-1 .labels', //UL контейнер для списка отметок  
      addTagUrl: "mark_reaction147.php?Act=addTag",
      //Адрес скрипта, который будет вызван при добавлении метки  
      removeTagUrl: "mark_reaction147.php?Act=removeTag",
      //Адрес скрипта, который будет вызван при удалении метки  
      recoverTagUrl: "mark_reaction147.php?Act=recoverTag", 
      //Адрес скрипта, который будет вызван при восстановлении метки  
      friends: "photo.json",
      areas: "photo1.json"
      });  
  });  

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
      alert ("Никнейм содержит закрывающийся тег XML!");
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
  function drawBorder (top, bottom, left, right)
  {
    var jg = new jsGraphics ('Canvas');
    document.body.style.cursor = 'default';
    jg.drawLine (left + 130, top, left + 130, bottom);
    jg.drawLine (left + 130, bottom, right + 130, bottom);
    jg.drawLine (right + 130, bottom, right + 130, top);
    jg.drawLine (right + 130, top, left + 130, top);
    jg.paint ();
  }
</script>