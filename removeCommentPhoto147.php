<meta name="robots" content="noindex"/>
<script type="text/javascript" src="ajax.js"></script>
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
    if (!isset($_GET ["comment"]))
      $ind = 1;
    else 
      $ind = $_GET ["comment"];
    $ind1 = $_POST ["photo"];
?>

<form method="post" action="<?php $index = 0; echo ("remove_comment_from_file147.php"); ?>" name="form" onSubmit="return overify(this)">
<?php $index = 0;
    $hdl = opendir ("Albums");
    while ($file = readdir ($hdl)) 
      if (strstr ($file, "PHOTO".$_POST ["photo"].".") == true)
        echo "<p>
          <img src='Albums/".$file."' style='width: 600px'/></br>";
    $dirct = "photo".$_POST ["photo"]; 
    $nom = "comment";
    $hdl = opendir ($dirct); 
    $i = 0;
    while ($file = readdir ($hdl))
      if (strstr ($file, $nom) == true)
        $i++;
    if ($i > 0)
    {
      echo "<p>
        Выберите номер комментария, который Вы хотите удалить<br/>
        <input type='hidden' name='photo' id='ind1' value='".$ind1."'/>
          <select name='comment' size='1' id='ind' onchange='submitForm1(\"removeCommentPhoto147\")'>";
      $hdl = opendir ($dirct);
      $j = 0;
      while ($file = readdir ($hdl))          
        if (strstr ($file, $nom) == true)
        {
       	  $j++;
          echo "<option value='".$j."'>".$j;
        }
      echo "</select><br/>
      </p>
      <div id='dest1'>";
      $hdl = opendir ($dirct);
      $j = 0;
      while ($file = readdir ($hdl))
        if (strstr ($file, $nom) == true)
        {      	
          $j++;
          if ($ind == $j)
          {
            echo "<table style='border: 0' align='center'>
              <tr>
              <td width='200'>
              <p>
              №".$j;
            $text = fopen ($dirct."/".$file, "r");
            onBD ($result, "ACCOUNTS");
            while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
              if ($row [3] == substr ($file, 18, strlen ($file) - 18))
              {
                echo "&nbsp;&nbsp;".date("d/m/Y H:i", substr ($file, 7, 10)).
                  "</p>
                  </td>
                  <td width='700' rowspan='2'>
                  \n";
                echo fgets ($text, 10000);
                while (!feof ($text))
                {
                  $i = 0;
                  $temp = fgets ($text, 10000);
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
                    $row [0]
                  ."
                  </p>
                  </td>
                  </tr>
                  </table>";
              }
            fclose ($text);
          }
        }
      echo "</div><br/>
      <p>
        <input type='submit' name='Remove' value='Удалить комментарий'>
      </p>";
    }  
    else
      echo "<p>
      К данной фотографии комментарий пока никто не оставлял.
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
    if (confirm ('Вы действительно хотите удалить этот комментарий?'))
      return true;
    else
      return false;
  }
</script>