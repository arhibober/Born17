<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
  if (isset ($_COOKIE ["account"]))
  {
    $i = 0;
    while (substr ($_COOKIE ["account"], $i, 1) != " ")
      $i++;
    $login = substr ($_COOKIE ["account"], 0, $i);
  }
  if ($login == "Архибобёр")
  {
    if (!isset ($_GET ["messages"]))
      $ind = 1;
    else
      $ind = $_GET ["messages"];
    $ind1 = $_POST ["topics"];
  ?>
  <form method="post" name="form" action="<?php $index = 0; echo ("edit_message_in_file147.php"); ?>"
    onSubmit="return overify(this)">
    <?php $index = 0;
      $nom = "connection";
      $dirct = "gb".$_POST ["topics"];
      $hdl = opendir ($dirct);
      $i = 0;
      while ($file = readdir ($hdl))
        if (strstr ($file, $nom) == true)
          $i++;
      if ($i > 0)
      {
        echo "<p>
          Выберите индекс сообщения, которое Вы хотите корректировать:<br/>
          <input type='hidden' name='topic' id='ind1' value='".$ind1."'/>
          <select name='messages' SIZE='1' id='ind' onchange='submitForm1(\"editMessageInTopic147\")'>";
        $hdl = opendir ($dirct);
        $j = 0;
        while ($file = readdir ($hdl))
          if (strstr ($file, $nom) == true)
          {
      	    $j++;
            echo "<option value='".$j."'/>".$j;
      	  }
        echo "</select></p>
          <div id='dest1'>";
        $hdl = opendir ($dirct);
        $k = 0;
        while ($file = readdir ($hdl))
          if (strstr ($file, $nom) == true)
      	  {
      	    $text = file_get_contents ($dirct."/".$file);
      	    $k++;
            if ($k == $ind)
            {
              echo "<p>
          	      Исправьте ошибку в тексте сообщения:<br/> 
                  <textarea name='message_text' cols='60' rows='10' wrap='virtual'>";
                    include $dirct."/".$file;
          	        echo "</textarea><br/>
          	      <br/>
                  <input name='submit' type='submit' value='Редактировать'/>
                </p>";        	 
            }
      	  }
       echo "</div>";
    }
    else
      echo "<p class='cent'>На данный момент тема пуста.</p>"
    ?>
  </form>
<?php $index = 0; 
  }
  else
    echo "Кажется, вы ошиблись страницей.";
  include "footer.php";
?>
<script language="javascript">
  function overify (f)
  {
    b = true;
    if (f.new_text.value.length == 0)
    {
      alert ("Вы удалили текст сообщения вообще!");
      b = false;
    }
   	return b;
  }
</script>