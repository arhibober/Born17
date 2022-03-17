<meta name="robots" content="noindex"/>
<script type="text/javascript" src="ajax.js"></script>
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
    if (!isset ($_GET ["news"]))
      $ind = 1;
    else
	  $ind = $_GET ["news"];
  ?>  
  <form method="post" name="form" action="<?php $index = 0; echo ("remove_new_from_file147.php"); ?>"
    onSubmit="return overify(this)">
  <?php     
    $dirct = "news"; 
    $nom = "new";
    $hdl = opendir ($dirct); 
    $i = 0;
    while ($file = readdir( $hdl))
      if (strstr ($file, $nom) == true)
        $i++;
    if ($i > 0)
    {
      echo "<p>
        Выберите индекс новости, которую Вы хотите удалить<br/>
        <select name='news' SIZE='1' id='ind' onchange='submitForm(\"removeNew147\")'>";  
      $hdl = opendir ($dirct);
      $j = 0;
      while ($file = readdir ($hdl))
        if (strstr ($file, $nom) == true)
        {
       	  $j++;
          echo "<option value='".$j."'/>".$j;
        }
      echo "</select>
      </p>
      <div id='dest'>";
      $hdl = opendir ($dirct);
      $j = 0;
      while ($file = readdir ($hdl))
  	    if (strstr ($file, $nom) == true)
        {
      	  $j++;
          if ($ind == $j)
          {
            echo "<table width='100%' align='center'>
              <tr>
              <td width='150'>
              <p>
              №".$j;
      	    $file1 = fopen ($dirct."/".$file, "r");
            echo fgets ($file1, 10000);
            while (!feof ($file1))
            {
      	      $i = 0;
              $temp = fgets ($file1, 10000);
      	      while (substr ($temp, $i, 1) == " ")
                $i++;
      	      for ($k = 0; $k < $i; $k++)
                echo "&nbsp";
              echo substr ($temp, $i, strlen ($temp) - $i).
                "<br/>";
            }
          }
        }   
      echo "</div>
      <br/>
      <p>
        <input name= 'submit' type='submit' value='Удалить'/>
      </p>"; 
    }
    else
      echo "<p>
        На данный момент новостей нет.
        </p>";
  }
  else
    echo "Кажется, вы ошиблись страницей.";
  include "footer.php";
?>
</form>
<script language="javascript">
  function overify (f)
  {
    if (confirm ('Вы действительно хотите удалить новость №' + f.news.options[f.news.selectedIndex].text + '\?'))
      return true;
    else
      return false;
  }
</script>