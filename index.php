<?php $index = 0;
  include "functions147.php";
  $index = 1;
  include "menu.php";
  if (isset ($_COOKIE ["account"]))
  {
    $i = 0;
    while (substr ($_COOKIE ["account"], $i, 1) != " ")
      $i++;
    $login = substr ($_COOKIE ["account"], 0, $i);
    $password = substr ($_COOKIE ["account"], $i + 1, strlen ($_COOKIE ["account"]) - $i - 1);
    $login_exist = false;
    onBD ($result, "ACCOUNTS");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $login)
      {
      	$login_exist = true;
        if ($row [2] == $password)
        {
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
      	      <a href ='javascript:document.forms[\"list_abc\"].submit();'>Список Ваших родственников по
      	        алфавиту</a><br/>
      	      <a href ='javascript:document.forms[\"list_age\"].submit();'>Список Ваших родственников в
      	        хронологическом порядке</a><br/>
      	      <a href ='javascript:document.forms[\"add\"].submit();'>Добавить своего родственника</a><br/>
      	      <a href ='javascript:document.forms[\"edit\"].submit();'>Редактировать свою родословную</a><br/>
      	      <a href ='javascript:document.forms[\"remove\"].submit();'>Удалить сведенья о своих
      	        родственниках</a><br/>
      	      <a href ='javascript:document.forms[\"add_brak\"].submit();'>Добавить информацию о бездетном
      	        браке</a><br/>
      	      <a href ='javascript:document.forms[\"remove_brak\"].submit();'>Удалить информацию о бездетном
      	        браке</a><br/>
      	      <a href ='javascript:document.forms[\"ahs\"].submit();'>Добавить дополнительную фамилию для своих
      	        родственников</a><br/>
      	      <a href ='javascript:document.forms[\"rhs\"].submit();'>Удалить дополнительные фамилии своих
      	        родственников</a><br/>
      	      <a href ='javascript:document.forms[\"efu\"].submit();'>Редактировать свои сообщения на форуме
      	        </a><br/>
      	      <a href ='javascript:document.forms[\"rfu\"].submit();'>Удалить своё сообщение на форуме</a><br/>
      	      <a href ='javascript:document.forms[\"add_album\"].submit();'>Добавить новый альбом с
      	        фотографиями родственников</a><br/>
      	      <a href ='javascript:document.forms[\"edit_album\"].submit();'>Отредактировать названия своих
      	        фотоальбомов</a><br/>
      	      <a href ='javascript:document.forms[\"remove_album\"].submit();'>Удалить свои лишние
      	        фотоальбомы</a><br/>
      	      <a href ='javascript:document.forms[\"add_photo\"].submit();'>Добавить новую фотографию с
      	        родственниками в свой альбом</a><br/>
      	      <a href ='javascript:document.forms[\"edit_photo\"].submit();'>Отредактировать данные о своих
      	        фотографиях</a><br/>
      	      <a href ='javascript:document.forms[\"remove_photo\"].submit();'>Удалить лишние свои фотографии
      	        </a><br/>
      	      <a href ='javascript:document.forms[\"albums_list\"].submit();'>Перейти к своим фотоальбомам</a>
      	        <br/>
      	      <a href ='javascript:document.forms[\"eccpu\"].submit();'>Редактировать оставленные Вами ранее
      	        комментарии к фотографиям</a><br/>
      	      <a href ='javascript:document.forms[\"rccpu\"].submit();'>Удалить свои лишние комментарии к
      	        фотографиям</a><br/>
      	    </p>
      	      <form action='exit147.php'>
      	        <p class='cent'>
      	          <input type='submit' name='exit' value='Выйти из системы'/>
      	        </p>
      	      </form>";      	
      }
      else
        echo "<h3>
          Добро пожаловать на редактор для генеалогических деревьев!
          </h3>
          <h4>
          Добавьте сюда себя и своих родственников! Стройте их деревья!
          </h4>
          <h4>
          Может, с помощью этого сайта Вам удастся установить родство со своими старыми друзьями или
          знаменитостями. С Вашей стороны это может оказаться весьма даже забавно!
          <h4>
          </h4>
          <h4>
          Для работы с контентом сайта, пожалуйста, войдите или зарегистрируйтесь.
          </h4>
          <br/>
          <form name = 'enter' action='enter.php'>
            <p>
              <input type = 'submit' value='Вход'/>
            </p>
            </form>
            <form name = 'registration' action='registration.php'>
            <p>
              <input type = 'submit' value='Регистрация'/>
            </p>
          </form>";
    }
    if (!$login_exist)
      echo "<h3>
        Добро пожаловать на редактор для генеалогических деревьев!
        </h3>
        <h4>
        Добавьте сюда себя и своих родственников! Стройте их деревья!
        </h4>
        <h4>
        Может, с помощью этого сайта Вам удастся установить родство со своими старыми друзьями или
        знаменитостями. С Вашей стороны это может оказаться весьма даже забавно!
        <h4>
        </h4>
        <h4>
        Для работы с контентом сайта, пожалуйста, войдите или зарегистрируйтесь.
        </h4>
        <br/>
        <form name = 'enter' action='enter.php'>
          <p>
            <input type = 'submit' value='Вход'/>
          </p>
        </form>
        <form name = 'registration' action='registration.php'>
          <p>
            <input type = 'submit' value='Регистрация'/>
          </p>
        </form>";
  }
  else
  {
    echo "<h3>
      Добро пожаловать на редактор для генеалогических деревьев!
      </h3>
      <h4>
      Добавьте сюда себя и своих родственников! Стройте их деревья!
      </h4>
      <h4>
      Может, с помощью этого сайта Вам удастся установить родство со своими старыми друзьями или
      знаменитостями. С Вашей стороны это может оказаться весьма даже забавно!
      <h4>
      </h4>
      <h4>
      Для работы с контентом сайта, пожалуйста, войдите или зарегистрируйтесь.
      </h4>
      <br/>
      <form name = 'enter' action='enter.php'>
        <p>
          <input type = 'submit' value='Вход'/>
        </p>
      </form>
      <form name = 'registration' action='registration.php'>
        <p>
          <input type = 'submit' value='Регистрация'/>
        </p>
      </form>";
  }
  include "footer.php";
?>