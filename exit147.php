<?php
  $index = 0;
  ob_start();
  setcookie ("account", "");
  include "functions147.php";
  $index = 1;
  include "menu.php";
  echo "<h3>
    Добро пожаловать на редактор для генеалогических деревьев!
    </h3>
    <h4>
    Добавьте сюда себя и своих родственников! Стройте их деревья!
    </h4>
    <h4>
    Может, с помощью этого сайта Вам удастся установить родство со своими старыми друзьями или
    знаменитостями. С Вашей стороны это может оказаться весьма даже забавно!
    <h4>
    </h4>
    <h4>
    Для работы с контентом сайта, пожалуйста, войдите или зарегистрируйтесь.
    </h4>
    <br/>
    <form name = 'enter' action='enter.php'>
    <p>
      <input type = 'submit' value='Вход'/>
    </p>
    </form>
    <form name = 'registration' action='registration.php'>
      <p>
        <input type = 'submit' value='Регистрация'/>
      </p>
    </form>";
  include "footer.php";
?>