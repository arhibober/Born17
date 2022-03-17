<?php
  $index = 4;
  include "menu.php";
  include "functions147.php";
  echo "<h3>
    Темы форума:
    </h3>
    <p>";
  onBD ($result, "TOPICS");
  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
    echo "<a href = 'topics.php?id=".$row [0]."'>".$row [1]."</a><br/>";
  echo "<br/>
    <a href = 'new_topic.php'>Открыть новую тему</a>
    </p>";
  include "footer.php";
?>