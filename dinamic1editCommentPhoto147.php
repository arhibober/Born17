<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET [ind] > 0)
  {
    $ind = $_GET [ind];
    $dirct = "photo".$_GET [ind1];
    $hdl = opendir ($dirct);
    $k = 0;
    while ($file = readdir ($hdl))
      if (strstr ($file, "comment") == true)
      {
        $k++;
        if ($k == $ind)
        {
          $text = file_get_contents ($dirct."/".$file);
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
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>