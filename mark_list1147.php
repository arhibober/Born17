<?php
  $index = 0;
  header('Content-type: text/html; charset=windows-1251');
  include "functions147.php";
  $accountID = $_GET ["ind"];
  if ($accountID > 0)
  {
    $i = 0;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] != "virt")
      {
        $n [($i + 1).""]["id"] = $i + 1;
        $n [($i + 1).""]["fullname"] = "";
        if ($row [2] != "NULL")
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"].$row [2];
        else
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]."?";
        if ($row [0] != "NULL")
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]." ".$row [0];
        else
          if ($row [2] != "NULL")
            $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]." ?";
        if ($row [1] != "NULL")
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]." ".$row [1];
        else
          $n [($i + 1).""]["fullname"] = $n [($i + 1).""]["fullname"]."";
        $n [($i + 1).""]["url"] = "data.php?id=".$row [9];
        $i++;
      }
  }
  $f = fopen("photo.json", "w");
  fwrite ($f, json_encode(json_fix_cyr($n)));   
  fclose ($f);
  function json_fix_cyr ($var)
  {
    if (is_array ($var))
    {
       $new = array ();
       foreach ($var as $k => $v)
          $new [json_fix_cyr ($k)] = json_fix_cyr ($v);
       $var = $new;
    }
    elseif (is_object ($var))
    {
       $vars = get_object_vars ($var);
       foreach ($vars as $m => $v)
          $var->$m = json_fix_cyr($v);
    }
    elseif (is_string ($var))
       $var = iconv ("cp1251", "utf-8", $var);
    return $var;
  }    
?>