<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET [ind] > 0)
  {
    include "functions147.php";
    $ind = $_GET [ind];
    $ind1 = $_GET [ind1];
    $nom = "connection";
    $dirct = "gb".$ind1; 
    $hdl = opendir ($dirct);
    $k = 0;
    while ($file = readdir ($hdl))
      if (strstr ($file, $nom) == true)
      {
        $k++;
        if ($k == $ind)
        {
          $text = file_get_contents ($dirct."/".$file);
          echo "<p>
              Исправьте ошибку в тексте сообщения:<br/> 
              <textarea name='message_text' cols='60' rows='10' wrap='virtual'>";
                include $dirct."/".$file;
                echo "</textarea><br/>
              <br/>
              <input name='submit' type='submit' value='Редактировать'/>
              </p>
            </form>";        	 
          }
        }
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>