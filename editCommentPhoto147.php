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
    if (!isset ($_GET ["comments"]))
      $ind = 1;
    else
	  $ind = $_GET ["comments"];
    $ind1 = $_POST ["photo"];
  ?>
  <form method="post" name="form" action="<?php $index = 0; echo ("edit_comment_in_file147.php"); ?>"
    onSubmit="return overify(this)">
    <?php $index = 0;
      $hdl = opendir ("Albums");
      while ($file = readdir ($hdl)) 
        if (strstr ($file, "PHOTO".$_POST ["photo"].".") == true)
          echo "<p>
            <img src='Albums/".$file."' style='width: 600px'/></br>";
      $nom = "comment";
      $dirct = "photo".$_POST ["photo"];
      $hdl = opendir ($dirct);
      $i = 0;
      while ($file = readdir ($hdl))
        if (strstr ($file, $nom) == true)
          $i++;
      if ($i > 0)
      {
        echo "Выберите индекс комментария, который Вы хотите корректировать:<br/>
          <input type='hidden' name='photo' id='ind1' value='".$ind1."'/>
          <select name='comments' SIZE='1' id='ind' onchange='submitForm1(\"editCommentPhoto147\")'>";
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
                  Исправьте ошибку в тексте комментария:<br/> 
                  <textarea name='comment_text' cols='60' rows='10' wrap='virtual'>";
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
        echo "<p>
          К данной фотографии комментарий пока никто не оставлял.
          </p>";
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
      alert ("Вы удалили текст комментария вообще!");
      b = false;
    }
  }
</script>