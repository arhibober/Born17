<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  if (isset ($_COOKIE ["account"]))
  {
    $i = 0;
    while (substr ($_COOKIE ["account"], $i, 1) != " ")
      $i++;
    $login = substr ($_COOKIE ["account"], 0, $i);
  }
  if ($login == "Архибобёр")
  {
  	echo "<form method='post' name='form' action='add_new_to_file147.php' onSubmit='return overify (this)'>
    <h3>
      Текст новости:
    </h3>
    <p>
    <textarea name='new_text' cols='60' rows='10'></textarea>
    <br/>
    <br/> 
    <input name='submit' type='submit' value='Добавить'/>
    </p>
    </form>";
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
      alert ("Введите текст новости!");
      b = false;
    }
    if (f.new_text.value.indexOf (">") != -1)
    {
      alert ("Текст новости содержит закрывающийся тег XML!");
      b = false;
    }
    if (f.new_text.value.indexOf ("<") !=-1)
    {
      alert("Текст новости содержит открывающийся тег XML!");
      b = false;
    }
    if (f.new_text.value.indexOf ("'") !=-1)
    {
      alert ("Текст новости содержит одинарные кавычки!");
      b = false;
    }
    if (f.new_text.value.indexOf("\"")!=-1)
    {
      alert ("Текст новости содержит двойные кавычки!");
      b = false;
    }
    if (f.new_text.value.indexOf("&")!=-1)
    {
      alert ("Текст новости содержит амперсант!");
      b = false;
    }
    return b;
  }
</script>