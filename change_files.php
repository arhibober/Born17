<meta name="robots" content="noindex"/>
<?php
  $index = 0;  
  $dirct = "./";
  $hdl = opendir ($dirct);
  while ($file = readdir ($hdl))
  {
    echo " f: ".$file;
    if (strstr ($file, ".txt"))
	{
      $text = file_get_contents ($file);
      $text = mb_convert_encoding ($text, "utf-8", "cp1251");
      unlink ($file);
      $fp = fopen ($file, "w");
      fwrite ($fp, $text);
      fclose ($fp);
	}
  }
?>