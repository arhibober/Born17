<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php"; 
  echo "<h3>
    Введите какие-либо параметры родственника
    </h3>
    <form action='find_rel147.php' onSubmit='return overify(this)' method='post'>
      <p>
        <input type='text' name='req'/>
        <button type='submit'>
          <img src='lupa.gif' width='20' height='20'/>
        </button>
      </p>
    </form>";
  include "functions147.php";
  if ($_POST ["req"] != "")
  {
    $k = 0;
    $words [0] = "";
    $req = str_replace ("ё", "е", $_POST ["req"]);
    $req = str_replace ("Ё", "е", $req);
    for ($i = 0; $i < strlen ($req); $i++)
      if (substr ($req, $i, 1) != " ")
        $words [$k] = $words [$k].substr ($req, $i, 1);
      else
        if (substr ($req, $i - 1, 1) != " ")
        {
          $k++;
          $words [$k] = "";
        } 
    $isFind = false;
    $isFindOne = false;
    echo "<p>";
    onBD($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
    {
      if ($row[0] != "virt")
      {
        $isFind = true;
        for ($i = 0; $i < sizeof ($words); $i++)
          if ($words [$i] != "")
          {
            $isFind = false;
            for ($j = 0; $j < sizeof ($row); $j++)
            {
              $wbd = explode (" ", $row [$j]);
              for ($k = 0; $k < sizeof ($wbd); $k++)
              {
                $w1 = str_replace ("ё", "е", $wbd [$k]);
                $w1 = str_replace ("Ё", "е", $w1);
                if (strtolower (strip_tags ($words [$i])) == strtolower ($w1))
                {
                  $isFind = true;
                  break;
                }
              }
            }
            if ((file_exists ("bio".$row [9].".txt")) && (filesize ("bio".$row[9].".txt") > 0))
            {
              $fr = fopen ("bio".$row[9].".txt", "r+");
              $ft = str_replace ("ё", "е", fread ($fr, filesize ("bio".$row[9].".txt")));
              $ft = str_replace ("Ё", "е", $ft);
              if (strstr (strtolower ($ft), strtolower (strip_tags ($words [$i]))))
              {
                $isFind = true;
                break;
              }
            }
            if (!$isFind)
              break;          
          }
        if ($isFind)
        {
          $isFindOne = true;
          echo "<a href='data.php?id=".$row [9]."'>";
          if ($row [2] != "NULL")
            echo $row [2];
          else
            echo "?";
          if ($row [0] != "NULL")
            echo " ".$row [0];
          else
            if ($row [2] != "NULL")
              echo " ?";
          if ($row [1] != "NULL")
            echo " ".$row [1];
          else
            echo "";
          echo "<br/>";
        }
      }
    }
    if (!$isFindOne)
      echo "Поиск не дал результатов";
    echo "</p>";
  }
  else
    echo "Кажется, вы ошиблись страницей.";
  include "footer.php";            
?>