<meta name="robots" content="noindex"/>
<?php $index = 0;
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
    if (!isset ($_GET ["news"]))
      $ind = 1;
    else
      $ind = $_GET ["news"];
  ?>
  <form method="post" name="form" action="<?php $index = 0; echo ("edit_new_in_file147.php"); ?>" onSubmit="return overify (this)">
      <?php $index = 0;
        $nom = "new";
        $dirct = "news";
        $hdl = opendir ($dirct);
        $i = 0;
        while ($file = readdir ($hdl))
      	  if (strstr ($file, $nom) == true)
            $i++;
        if ($i > 0)
        {
          echo "<p>
            Выберите индекс новости, которую Вы хотите корректировать:<br/>
            <select name='news' size='1' id='ind' onchange='submitForm(\"editNew147\")'>";
          $hdl = opendir ($dirct);
          $j = 0;
          while ($file = readdir ($hdl))
      	    if (strstr ($file, $nom) == true)
      	    {
      	  	  $j++;
              echo "<option value='".$j."'>".$j;
      	    }
          echo "</select></p>
            <div id='dest'>";
          $hdl = opendir ($dirct);
          $k = 0;
          while ($file = readdir ($hdl))
      	    if (strstr ($file, $nom) == true)
      	    {
      	      $text = file_get_contents ($dirct."/".$file);
      	  	  $k++;
              if ($k == $ind)
              {
          	echo "<form method='post' action='edit_new_if_file.php' onSubmit='return overify(this)' enctype='multipart/form-data'>
          	      <p>
                    Исправьте ошибку в тексте новости:<br/> 
                    <textarea name='new_text' cols='60' rows='10' wrap='virtual'>";
          	        $new_text = file_get_contents ($dirct."/".$file);
          	        $j = strlen ($new_text) - 19;
          	        while (substr ($new_text, $j, 1) != ">")
                      $j--;
          	        echo substr ($new_text, $j + 1, strlen ($new_text) - 19 - $j);
          	        echo "</textarea><br/>
          	        <br/>
                    <input name='submit' type='submit' value='Редактировать'/>
                  </p>
                </form>";        	 
              }
      	    }
      	  echo "</div>";
        }
        else
          echo "<p>
            На данный момент новостей нет.
            </p>"
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
      alert ("Вы удалили текст новости вообще!");
      b = false;
    }
    if (f.new_text.value.indexOf (">") != -1)
    {
      alert ("Текст новости содержит закрывающийся тег XML!");
      b = false;
    }
    if (f.new_text.value.indexOf ("<") != -1)
    {
      alert ("Текст новости содержит открывающийся тег XML!");
      b = false;
    }
    if (f.new_text.value.indexOf (".") != -1)
    {
      alert ("Текст новости содержит точку!");
      b = false;
    }
    if (f.new_text.value.indexOf ("'") != -1)
    {
      alert ("Текст новости содержит одинарные кавычки!");
      b = false;
    }
    if (f.new_text.value.indexOf ("\"") != -1)
    {
      alert ("Текст новости содержит двойные кавычки!");
      b = false;
    }
    if (f.new_text.value.indexOf ("&") != -1)
    {
      alert ("Текст новости содержит амперсант!");
      b = false;
    }
    return b;
  }
</script>