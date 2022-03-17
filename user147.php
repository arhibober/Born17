<?php
  $index = 0;
  $nickNameExist = false;
  onBD ($result, "ACCOUNTS");
  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
    if ($row [0] == $_POST ["nickName"])
    {
      $nickNameExist = true;
      if ($row [2] == $_POST ["password"])
      {
        ob_start ();
      	setcookie ("account", $_POST ["nickName"]." ".$_POST ["password"]);
      	include "menu.php";
      	echo "<meta name='robots' content='noindex'/>";
      	echo "<h3>
      	  Вы зашли на сайт как ".$row [0]."
      	  </h3>
      	  <form method='post' name='list_abc' action='rel_user147.php'>
      	    <input type='hidden' name='list_abc' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='list_age' action='rlua147.php'>
      	    <input type='hidden' name='list_age' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='add' action='add147.php'>
      	    <input type='hidden' name='add' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='edit' action='edit147.php'>
      	    <input type='hidden' name='edit' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='remove' action='remove147.php'>
      	    <input type='hidden' name='remove' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='add_brak' action='add_brak147.php'>
      	    <input type='hidden' name='add_brak' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='remove_brak' action='remove_brak147.php'>
      	    <input type='hidden' name='remove_brak' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='ahs' action='addHusbendSername147.php'/>
      	    <input type='hidden' name='ahs' value='".$row [3]."'>
      	  </form>
      	  <form method='post' name='rhs' action='removeHusbendSername147.php'/>
      	    <input type='hidden' name='rhs' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='efu' action='editForumUser147.php'>
      	    <input type='hidden' name='efu' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='rfu' action='removeForumUser147.php'>
      	    <input type='hidden' name='rfu' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='add_album' action='addAlbum147.php'>
      	    <input type='hidden' name='add_album' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='edit_album' action='editAlbum147.php'>
      	    <input type='hidden' name='edit_album' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='remove_album' action='removeAlbum147.php'>
      	    <input type='hidden' name='remove_album' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='add_photo' action='addPhoto147.php'>
      	    <input type='hidden' name='add_photo' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='edit_photo' action='editPhoto147.php'>
      	    <input type='hidden' name='edit_photo' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='remove_photo' action='removePhoto147.php'>
      	    <input type='hidden' name='remove_photo' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='albums_list' action='albumsList147.php'>
      	    <input type='hidden' name='albums_list' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='eccpu' action='eccpu147.php'>
      	    <input type='hidden' name='eccpu' value='".$row [3]."'/>
      	  </form>
      	  <form method='post' name='rccpu' action='rccpu147.php'>
      	    <input type='hidden' name='rccpu' value='".$row [3]."'/>
      	  </form>
      	  <p>
      	    <a href ='javascript:document.forms[\"list_abc\"].submit();'>Список Ваших родственников по алфавиту</a>
      	    <br/>
      	    <a href ='javascript:document.forms[\"list_age\"].submit();'>Список Ваших родственников в хронологическом порядке</a><br/>
      	    <a href ='javascript:document.forms[\"add\"].submit();'>Добавить своего родственника</a><br/>
      	    <a href ='javascript:document.forms[\"edit\"].submit();'>Редактировать свою родословную</a><br/>
      	    <a href ='javascript:document.forms[\"remove\"].submit();'>Удалить сведенья о своих родственниках
      	    </a><br/>
      	    <a href ='javascript:document.forms[\"add_brak\"].submit();'>Добавить информацию о бездетном браке
      	    </a><br/>
      	    <a href ='javascript:document.forms[\"remove_brak\"].submit();'>Удалить информацию о бездетном браке</a><br/>
      	    <a href ='javascript:document.forms[\"ahs\"].submit();'>Добавить дополнительную фамилию для своих родственников</a><br/>
      	    <a href ='javascript:document.forms[\"rhs\"].submit();'>Удалить дополнительные фамилии своих родственников</a><br/>
      	    <a href ='javascript:document.forms[\"efu\"].submit();'>Редактировать свои сообщения на форуме</a>
      	      <br/>
      	    <a href ='javascript:document.forms[\"rfu\"].submit();'>Удалить своё сообщение на форуме</a><br/>
      	    <a href ='javascript:document.forms[\"add_album\"].submit();'>Добавить новый альбом с фотографиями родственников</a><br/>
      	    <a href ='javascript:document.forms[\"edit_album\"].submit();'>Отредактировать названия своих фотоальбомов</a><br/>
      	    <a href ='javascript:document.forms[\"remove_album\"].submit();'>Удалить свои лишние
      	      фотоальбомы</a><br/>
      	    <a href ='javascript:document.forms[\"add_photo\"].submit();'>Добавить новую фотографию с родственниками в свой альбом</a><br/>
      	    <a href ='javascript:document.forms[\"edit_photo\"].submit();'>Отредактировать данные о своих фотографиях</a><br/>
      	    <a href ='javascript:document.forms[\"remove_photo\"].submit();'>Удалить лишние свои фотографии</a>
      	      <br/>
      	    <a href ='javascript:document.forms[\"albums_list\"].submit();'>Перейти к своим фотоальбомам</a>
      	      </br>
      	    <a href ='javascript:document.forms[\"eccpu\"].submit();'>Редактировать оставленные Вами ранее комментарии к фотографиям</a><br/>
      	    <a href ='javascript:document.forms[\"rccpu\"].submit();'>Удалить свои лишние комментарии к фотографиям</a><br/>
      	    <br/>
      	  </p>
      	  <form action='exit147.php'>
      	    <p>
      	      <input type='submit' name='exit' value='Выйти из системы'/>
      	    </p>
      	  </form>";   
        ob_end_flush ();
        include "footer.php";
      }
      else
      {
      	include "menu.php";
      	echo "<meta name='robots' content='noindex'/>";
      	echo "<p>
      	  Ошибка: неверный пароль!
      	  </p>";
      	break;
        include "footer.php";
      }
    }
  if (!$nickNameExist)
  {
    include "menu.php";
    echo "<meta name='robots' content='noindex'/>";
    echo "<p>
      Ошибка: данный никнейм не зарегистрирован.
      </p>";
    include "footer.php";
  }
  function onBD (&$result, $table_name)
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
    $result = mysqli_query ($conn, "SELECT * FROM ".$table_name);
    if (!$result)
    {
      echo "Can't select from (".$table_name.")";
      return;
    }
  } 
?>