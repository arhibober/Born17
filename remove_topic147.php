<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
  echo "<form method='post' name='form' action='rtfbd147.php' onsubmit='return submitRemove (this)'>
    <p class='cent'>
    Выберите тему форума, которую Вы хотите удалить<br/>
    <select size='1' name='topics' id='ind' onchange='submitForm (\"remove147\")'>";
  onBD ($result, "TOPICS");
  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
    echo "<option value='".$row [0]."'>".$row [1]; 
  echo "</select><br/>
  <input type='submit' value='Удалить тему'/>
  </p>
  </form>";
  include "footer.php";  
?>

<script language='javascript'>
  function submitRemove (f)
  {
	if (confirm ("Вы уверены, что хотите удалить тему \"" + f.topics.options [f.topics.selectedIndex].text + "\"?"))
	  return true;
	else
	  return false;
  }
</script>