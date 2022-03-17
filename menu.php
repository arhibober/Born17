<?php
  ob_start ();
  set_time_limit (100000);
  header ("Content-Type: text/html; charset=utf-8");
  echo "<!DOCTYPE>
  <html>
    <head>
      <title>
        Родословная
      </title>
      <meta http-equiv='Content-Type'
	    content='text/html'; charset='windows-1251'/>
	  <link rel='stylesheet' TYPE='text/css' HREF='style.css'/>
    </head>
    <body>
      <b style='font-size: 50px;'>
      <p>
      Генеалогическое</br>
      древо
      </p>
      </b>
      <p>
      <table id='main-table'>
        <tr>
          <td style='width: 200px;'>";
            if ($index != 1)
              echo "<a href='index.php' style='text-decoration: none;'>";
            echo "<table class='menu'";
              if ($index != 1)
                echo " style='background: #cc9999;'";
              echo ">
                <tr>";
                if ($index != 1)
                  echo "<a href='index.php' style='text-decoration: none;'>";
                echo "<td>
                    <h3>
                    Главная
                    </h3>
                    </td>
                    </tr>
                    </table>";
                    if ($index != 1)
                      echo "</a>";
                    echo "</td>
                    <td style='width: 20px;'>
                      &nbsp;
                    </td>
                    <td style='width: 200px;'>";
                  if ($index != 2)
                    echo "<a href='rel_list.php' style='text-decoration: none;'>";
                  echo "<table class='menu'";           
                  if ($index != 2)
                    echo " style='background: #cc9999;'";
                  echo ">
                    <tr>";
                  if ($index != 2)
                    echo "<a href='rel_list.php' style='text-decoration: none;'>";
                  echo "<td>
                    <h3>
                    Каталог членов всех деревьев
                    </h3>
                    </td>
                    </tr>
                    </table>";
                    if ($index != 2)
                      echo "</a>";
                    echo "</td>
                    <td style='width: 20px;'>
                      &nbsp;
                    </td>
                    <td style='width: 200px;'>";
                  if ($index != 3)
                    echo "<a href='find.php' style='text-decoration: none;'>";
                  echo "<table class='menu'";           
                  if ($index != 3)
                    echo " style='background: #cc9999;'";
                  echo ">
                    <tr>";
                  if ($index != 3)
                    echo "<a href='find.php' style='text-decoration: none;'>";
                  echo "<td>
                    <h3>
                    Поиск
                    </h3>
                    </td>
                    </tr>
                    </table>";
                    if ($index != 3)
                      echo "</a>";
                    echo "</td>
                    <td style='width: 20px;'>
                      &nbsp;
                    </td>
                    <td style='width: 200px;'>";
                  if ($index != 4)
                    echo "<a href='forum.php' style='text-decoration: none;'>";
                  echo "<table class='menu'";           
                  if ($index != 4)
                    echo " style='background: #cc9999;'";
                  echo ">
                    <tr>";
                  if ($index != 4)
                    echo "<a href='forum.php' style='text-decoration: none;'>";
                  echo "<td>
                    <h3>
                    Форум
                    </h3>
                    </td>
                    </tr>
                    </table>";
                    if ($index != 4)
                      echo "</a>";
                    echo "</td>
                    <td style='width: 20px;'>
                      &nbsp;
                    </td>
                    <td style='width: 200px;'>";
                  if ($index != 5)
                    echo "<a href='news.php' style='text-decoration: none;'>";
                  echo "<table class='menu'";           
                  if ($index != 5)
                    echo " style='background: #cc9999;'";
                  echo ">
                    <tr>";
                  if ($index != 5)
                    echo "<a href='news.php' style='text-decoration: none;'>";
                  echo "<td>
                    <h3>
                    Новости сайта
                    </h3>
                    </td>
                    </tr>
                    </table>";
                    if ($index != 5)
                      echo "</a>";
                    echo "</td>
                    <td style='width: 20px;'>
                      &nbsp;
                    </td>
                    </tr>
                    <tr>
                    <td colspan='9'>
                    &nbsp;
                    </td>
                    </tr>
                    <tr>
                    <td colspan='9'>
                    <table width='100%'>
                    <tr>
                    <td>";
  ob_end_flush ();                
?>