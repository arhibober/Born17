<?php
  $index = 0;
  include "functions147.php";
  echo "<p>
    Кажется, Вы ошиблись страницей
    </p>";
  class Controller
  {
    function addTag ()
    {
      if ($_POST ["item_id"] > 0)
      {
        $id = 0;
        onBD ($result, "PHOTO_PEOPLE");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	  if ($row [0] > $id)
  	    $id = $row [0];
  	  toBD ($result, ($id + 1), $_POST ["item_id"], $_POST ["top"], $_POST ["top"] + $_POST ["height"], $_POST ["left"], $_POST ["left"] + $_POST ["width"]);
      }
    }
    function _bind ()
    {
      $act = $_GET ["Act"];
      if ($act{0} != '_' && is_callable (array ($this, $act))) {
        return $this->$act();
      }
      die ("Not found");
    }
  }
  $photoLabelController = new Controller ();
  echo $photoLabelController->_bind ();
  function toBD ($result, $id, $people, $top, $bottom, $left, $right)
  {
    $conn = mysqli_connect ("localhost:3306", "root", "", "test")
    or die ("Невозможно установить соединение: ".mysqli_error ());
    $database = "Born17";
    mysqli_select_db ($database); // выбираем базу данных
    $result = mysqli_query ($conn, "INSERT INTO PHOTO_PEOPLE VALUES('".$id."', 0, '".$people."', '".$top."', '".$bottom."', '".$left."', '".$right."')");
    if (!$result)
    {
      echo "Can't insert into ALBUM";
      return;
    }
    echo "<p>
      Человек успешно отмечен на фотографии.
      </p>";
  }
?>