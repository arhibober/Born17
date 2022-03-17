<link rel="stylesheet" type="text/css" href="res/css/photolabel.css"> <!-- стили jQuery.photolabel -->  
<link rel="stylesheet" type="text/css" href="res/css/ui-lightness/jquery-ui-1.8.22.custom.css">
<?php
  $row3 = array (0);
  $row1 = array (0, 0, 0);
  $index = 0;
  if ($_GET ["photo"] == 0)
    echo "Кажется, Вы ошиблись страницей.";
  else
  {
    include "functions147.php";
    echo "<div id='dest6'>
    <div class='center'>
      <div id='block-1' class='photoLabel'>
      <div class='imgWrap'>";
    $dirct = "Albums";
    $hdl = opendir ($dirct);
    while ($file = readdir ($hdl))
      if (strstr ($file, "PHOTO".$_GET ["photo"].".") == true)
      {  
        echo "<div id='Canvas'></div>";      	 	
  	echo "<img src ='Albums/".$file."' style='width: 600' usemap='#map1' alt=''/><br/>
  	  <map name='map1'>";
  	onBD ($result6, "PHOTO_PEOPLE");
        while ($row6 = mysqli_fetch_array ($result6))
          if ($row6 [1] == $_GET ["photo"])
          {
            echo "<area href='data.php?id=".$row6 [2]."' shape='rect' coords='".$row6 [5].", ".$row6 [3].", ".$row6 [6].", ".$row6 [4]."'  onMouseOver='drawBorder(".$row6 [3].", ".$row6 [4].", ".$row6 [5].", ".$row6 [6].")' onMouseOut='returnPhoto(".$_GET ["photo"].")' title='";
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
			$row1 = mysqli_fetch_array ($result1, MYSQLI_NUM);
            while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
              if ($row1 [0] == $login)
              {
      	        $login_exist = true;
                if ($row1 [2] == $password)
                {
                  onBD ($result, "ALBUM");
                  while ($row4 = mysqli_fetch_array($result))
                  {
                    onBD ($result2, "PHOTO");
                    while ($row5 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                      if ($row5 [0] == $_GET ["photo"])
                        if (($row5 [2] == $row4 [0]) && ($row4 [2] == $row1 [3]))
                        {
                          $ownPhoto = true;
               	          change_json ($row1 [3]);
						  $id = 0;
                          echo "<a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"start\")'
                            class='turnOn'>
                            Отметьте родственника на фото</a>
                            <a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"stop\")'
                              style='display:none' class='turnOff' onMouseDown='addPhoto (".$_GET ["id"].", ".
                              $row1 [3].", ".$id.")'>Готово</a>
                            </div>
                            </div>
                            </div>";
                        }
                    }
                }
                else
                  if (strlen ($row3 [0]) > 0)
                  {
                    onBD ($result, "ALBUM");
                    while ($row4 = mysqli_fetch_array($result))
                    {
                      onBD ($result2, "PHOTO");
                      while ($row5 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                        if ($row5 [0] == $_GET [photo])
                          if (($row5 [2] == $row4 [0]) && ($row4 [2] == $row1 [3]))
                          {
                            $ownPhoto = true;
               	            change_json ($row3 [3]);
				            $id = 0;
                            echo "<a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").
                              photoLabel(\"start\")' class='turnOn'>Отметьте родственника на фото</a>
                              <a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"stop\")'
                                style='display:none' class='turnOff' onMouseDown='addPhoto (".$_GET ["id"].", ".$row1 [3].", ".$id.")'>Готово</a>
                              </div>
                              </div>
                              </div>";
                          }
                    }
                  }
              }
              if (!$login_exist)
                if (strlen ($row3 [0]) > 0)
                {
                  onBD ($result, "ALBUM");
                  while ($row4 = mysqli_fetch_array($result))
                  {
                    onBD ($result2, "PHOTO");
                    while ($row5 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                      if ($row5 [0] == $_GET ["photo"])
                        if (($row5 [2] == $row4 [0]) && ($row4 [2] == $row1 [3]))
                        {
                          $ownPhoto = true;
               	          change_json ($row3 [3]);
                          echo "<a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"start\")'
                          class='turnOn'>Отметьте родственника на фото</a>
                          <a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"stop\")'
                            style='display:none' class='turnOff' onMouseDown='addPhoto (".$_GET ["id"].", ".
                            $row1 [3].", ".$id.")'>Готово</a>
                          </div>
                          </div>
                          </div>";
                        }
                  }
                }
          }
          else
            if (strlen ($row3 [0]) > 0)
            {
              onBD ($result, "ALBUM");
              while ($row4 = mysqli_fetch_array($result))
              {
                onBD ($result2, "PHOTO");
                while ($row5 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                  if ($row5 [0] == $_GET ["photo"])
                    if (($row5 [2] == $row4 [0]) && ($row4 [2] == $row1 [3]))
                    {
                      $ownPhoto = true;
               	      change_json ($row3 [3]);
                      echo "<a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"start\")' class='turnOn'>Отметьте родственника на фото</a>
                        <a href='JavaScript:;' onclick='$(\"#block-1 .imgWrap\").photoLabel(\"stop\")' style='display:none' class='turnOff' onMouseDown='addPhoto (".$_GET ["id"].", ".$row1 [3].", ".$id.")'>Готово</a>
                        </div>
                        </div>
                        </div>";
                    }
              }
            echo "</div>
              </div>
              </div>
              </div>";
    }
  }
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
  function json_fix_cyr ($var)
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
       $var = mb_convert_encoding ($var, "utf-8", "cp1251");
    return $var;
  }
?>
  
<script type="text/javascript" src="res/js/jquery/jquery-1.7.2.min.js"></script> <!-- jQuery -->  
<script type="text/javascript" src="res/js/jquery/jquery-ui-1.8.22.custom.min.js"></script> <!-- jQuery.ui -->
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
  function drawBorder (top, bottom, left, right)
  {
      var jg = new jsGraphics ('Canvas');
      document.body.style.cursor = 'default';
      //jg.strokeRect (left, top, right - left, bottom - top);
      jg.drawLine (left + 130, top, left + 130, bottom);
      jg.drawLine (left + 130, bottom, right + 130, bottom);
      jg.drawLine (right + 130, bottom, right + 130, top);
      jg.drawLine (right + 130, top, left + 130, top);
      //jg.drawLine (0, 0, 1000, 1000);
      jg.paint ();
  }
 </script>