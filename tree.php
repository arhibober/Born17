<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
  $isIndex = false;
  $name = "";
  onBD ($result, "PEOPLE");
  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
    if ($row [9] == $_POST ["id"])
    {
      $isIndex = true;
      $name = $row [0];
    }
  if (($_POST ["id"] > 0) && ($isIndex) && ($name != "virt") && ($_POST ["gen"] > 0))
  {
    maxDeap ($_POST ["id"], $md);
    maxDeapChildren ($_POST ["id"], $mdc);
    echo "<div style='position: absolute; left: 0px; top: ".(220 * ($md + $mdc) + 650)."px;'>
      &nbsp;
    </div>";
    echo "
    <script language='javascript'>
      document.body.style.height = '".(220 * ($md + $mdc) + 650)."';
      document.body.style.cursor = 'wait';
      </script>
      <p>
        <b>
          </div>";
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [9] == $_POST ["id"])
      {
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
      }
    echo "</b> - основное генеалогическое древо
    </p>";
    $mqc = 0;
    $left = 0;
    $i = 0;
    relLeft ($_POST ["id"], $rl, $md);
    relLeft1 ($_POST ["id"], $rl1, $mdc);
    if ($rl > $rl1)
    {
      drawTable ($_POST ["id"], $md, 0, true, 0);
      drawTable1 ($_POST ["id"], $mdc, $rl - $rl1, $md + $mdc, true);
    }
    else
    {
      drawTable ($_POST ["id"], $md, $rl1 - $rl, true, 0);
      drawTable1 ($_POST ["id"], $mdc, 0, $md + $mdc, true);
    }
	/*echo " rl: ".$rl;	
	echo " rl1: ".$rl1;
	echo " md: ".$md;	
	echo " mdc: ".$mdc;*/
    echo "<script language='javascript'>
      window.onload = function ()
      {
        var jg = new jsGraphics ('Canvas');";
        if ($rl > $rl1)
        {
          drawLines ($_POST ["id"], $md, 0, true);
          drawLines1 ($_POST ["id"], $mdc, $rl - $rl1, $md + $mdc);
        }
        else
        {         
          drawLines ($_POST ["id"], $md, $rl1 - $rl, true);
          drawLines1 ($_POST ["id"], $mdc, 0, $md + $mdc);
        }
        echo "jg.paint ();
        document.body.style.cursor = 'default';
                
      }
    </script>
    <div id='Canvas'></div>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  include "footer.php";
  function maxDeap ($id, &$md)
  {
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [9] == $id)
        if ($row [10] == 0)
          if ($row [11] == 0)
            $md = 0;
          else
          {
            maxDeap ($row [11], $md1);
            if ($md1 != $_POST ["gen"])
              $md = $md1 + 1;
            else
              $md = $_POST ["gen"];
          }
        else
          if ($row [11] == 0)
          {
            maxDeap ($row [10], $md1);
            if ($md1 != $_POST ["gen"])
              $md = $md1 + 1;
            else
              $md = $_POST ["gen"];
          }
          else
          {
            maxDeap ($row [10], $md1);
            maxDeap ($row [11], $md2);
            if ($md1 > $md2)
              if ($md1 != $_POST ["gen"])
                $md = $md1 + 1;
              else
                $md = $_POST ["gen"];
            else              
              if ($md2 != $_POST ["gen"])
                $md = $md2 + 1;
              else
                $md = $_POST ["gen"];
          }        
  }
  function maxDeapChildren ($id, &$mdc)
  {
    $isChildren = false;
    onBD($result, "PEOPLE");
    $mdc2 = 0;
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
      {
      	$isChildren = true;
      	maxDeapChildren ($row [9], $mdc1);
      	if ($mdc1 > $mdc2)
      	  $mdc2 = $mdc1;
      }
    if ($isChildren)
      if ($mdc2 != $_POST ["gen"])
        $mdc = $mdc2 + 1;
      else
        $mdc = $_POST ["gen"];
    else
      $mdc = 0;
  }
  function drawTable ($id, $md, $bord, $isRoot, $gen)
  {
    relLeft ($id, $leftRel, $md);
    $left1 = $leftRel + $bord + 50;
    $top1 = 220 * $md + 520;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [9] == $id)
      {
        echo "<table style='position: absolute; left: ".$left1."px; top: ".$top1."px;' class='leave'>
          <tr>
          <td>
          <p>
            <a href = 'data.php?id=".$row [9]."' title='";
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
            if ($row [3] != 0)
            {
      	      echo " (";
              if ($row [6] == 0)
                echo "р. ";
              echo $row [3];
              if ($row [6] != 0)
                echo "-";
              else
              {
                if ($row [16] != 0)
                  echo "-?";
                echo ")";
              }
            }
            if ($row [6] != 0)
            {
              if ($row [3] == 0)
                echo " (ум. ";
              echo $row [6];
              if (($row [16] != 0) || ($row [17] != 0))
                echo "-?";
              echo ")";
            }
            echo "'>";
            if ($row [0] == "NULL")
	    {
              echo "?";
	      if ($row [2] != "NULL")
		echo "<br/>".
	      $row [2];
	    }
	    else
	    {
	      echo $row [0]."<br/>";
	      if ($row [2] == "NULL")
                echo "?";
              else			
	        echo $row [2];
	    }
            if ($row [3] != 0)
            {
      	      echo "<br/> 
      	      (";
              if ($row [6] == 0)
                echo "р. ";
              echo $row [3];
                if ($row [6] != 0)
                  echo "-";
                else
                {
                  if ($row [16] != 0)
                    echo "-?";
                  echo ")";
                }
            }
            if ($row [6] != 0)
            {
              echo "<br/>";
              if ($row [3] == 0)
                echo "(ум. ";
              echo $row [6];
              if (($row [16] != 0) || ($row [17] != 0))
                echo "-?";
              echo ")";
            }
            echo "</a>";
            echo "</p>
          </td>
          </tr>
          </table>";
          if ($md > 0)
            if ($row [10] != 0)
            {
              if ($row [11] != 0)
              {
                $ml = 0;
                maxLeft ($row [11], 0, $ml, $md - 1);
                drawTable ($row [11], $md - 1, $bord, false, $gen + 1);
                drawTable ($row [10], $md - 1, $bord + $ml + 110, false, $gen + 1);
                $i = 0;
                $j = 0;
                if ($isRoot)
                {
                  onBD ($result1, "PEOPLE");
                  while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                    if ((($row1 [10] == $row [9]) || ($row1 [11] == $row [9])) &&
                      ($row1 [10] != 0) && ($row1 [11] != 0))
                    {
                      onBD ($result2, "PEOPLE");
                      while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                        if (($row1 [10] == $row2 [10]) && ($row1 [11] == $row2 [11]))
                        {
                          if ($row1 [9] == $row2 [9])
                            $j++;
                          break;
                        }
                    }
                }
                onBD ($result1, "PEOPLE");
                while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                  if (($row1 [11] == $row [11]) && ($row1 [9] != $row [9]) && ($row1 [0] != "virt"))
                  {
                    $i++;
                    echo "<table style='position: absolute; left: ".($left1 + 110 * $i + 110 * $j)."px; top:
                      ".$top1."px;' class='leave'>
                        <tr>
                          <td>
                            <p>
                              <a href = 'data.php?id=".$row1 [9]."' title='";
                    if ($row1 [2] != "NULL")
                      echo $row1 [2];
                    else
                      echo "?";
                    if ($row1 [0] != "NULL")
                      echo " ".$row1 [0];
                    else 
                      if ($row1 [2] != "NULL")
                        echo " ?";
                    if ($row1 [1] != "NULL")
                      echo " ".$row1 [1];
                    else
                      echo "";
                    if ($row1 [3] != 0)
                    {
      	              echo " (";
                      if ($row1 [6] == 0)
                        echo "р. ";
                      echo $row1 [3];
                      if ($row1 [6] != 0)
                        echo "-";
                      else
                      {
                        if ($row1 [16] != 0)
                          echo "-?";
                        echo ")";
                      }
                    }
                    if ($row1 [6] != 0)
                    {
                      if ($row1 [3] == 0)
                        echo " (ум. ";
                      echo $row1 [6];
                      if (($row1 [16] != 0) || ($row1 [17] != 0))
                        echo "-?";
                      echo ")";
                    }
                    echo "'>";                    
					if ($row1 [0] == "NULL")
					{
					  echo "?";
					  if ($row1 [2] != "NULL")
						echo "<br/>".
					  $row1 [2];
					}
					else
					{
					  echo $row1 [0]."<br/>";
					  if ($row1 [2] == "NULL")
						echo "?";
					  else			
						echo $row1 [2];
				    }
					if ($row1 [3] != 0)
					{
      	              echo "<br/> 
      	              (";
                      if ($row1 [6] == 0)
                        echo "р. ";
                      echo $row1 [3];
                        if ($row1 [6] != 0)
                          echo "-";
                      else
                      {
                        if ($row1 [16] != 0)
                          echo "-?";
                        echo ")";
                      }
                    }
                    if ($row1 [6] != 0)
                    {
                      echo "<br/>";
                      if ($row1 [3] == 0)
                        echo "(ум. ";
                      echo $row1 [6];
                      if (($row1 [16] != 0) || ($row1 [17] != 0))
                        echo "-?";
                      echo ")";
                    }
                    echo "</a></p>
                      </td>
                      </tr>
					  </table>";
                  }
                  onBD ($result1, "PEOPLE");
                  while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                    if (($row1 [10] == $row [10]) && ($row1 [9] != $row [9]) && ($row1 [11] != $row [11]) && ($row1 [0] != "virt"))
                    {
                      $i++;
                      echo "<table style='position: absolute; left: ".($left1 + 110 * $i + 110 * $j)."px; top: ".
                        $top1."px'; class='leave'>
                          <tr>
                            <td>
                              <p>
                                <a href = 'data.php?id=".$row1 [9].
                                "' title='";
                                if ($row1 [2] != "NULL")
                                  echo $row1 [2];
                                else
                                  echo "?";
                                if ($row1 [0] != "NULL")
                                  echo " ".$row1 [0];
                                else
                                  if ($row1 [2] != "NULL")
                                    echo " ?";
                                if ($row1 [1] != "NULL")
                                  echo " ".$row1 [1];
                                else
                                  echo "";
                                if ($row1 [3] != 0)
                                {
      	                          echo " (";
                                  if ($row1 [6] == 0)
                                    echo "р. ";
                                  echo $row1 [3];
                                  if ($row1 [6] != 0)
                                    echo "-";
                                  else
                                  {
                                    if ($row1 [16] != 0)
                                      echo "-?";
                                    echo ")";
                                  }
                                }
                                if ($row1 [6] != 0)
                                {
                                  if ($row1 [3] == 0)
                                    echo " (ум. ";
                                  echo $row1 [6];
                                  if (($row1 [16] != 0) || ($row1 [17] != 0))
                                    echo "-?";
                                  echo ")";
                                }
                                echo "'>";                             
								if ($row1 [0] == "NULL")
								{
								  echo "?";
								  if ($row1 [2] != "NULL")
								  echo "<br/>".
								  $row1 [2];
								}
								else
								{
								  echo $row1 [0]."<br/>";
								  if ($row1 [2] == "NULL")
								    echo "?";
								  else
								    echo $row1 [2];
								}
                                if ($row1 [3] != 0)
                                {
      	                          echo "<br/> 
      	                            (";
                                  if ($row1 [6] == 0)
                                    echo "р. ";
                                  echo $row1 [3];
                                  if ($row1 [6] != 0)
                                    echo "-";
                                  else
                                  {
                                    if ($row1 [16] != 0)
                                      echo "-?";
                                    echo ")";
                                  }
                                }
                                if ($row1 [6] != 0)
                                {
                                  echo "<br/>";
                                  if ($row1 [3] == 0)
                                    echo "(ум. ";
                                  echo $row1 [6];
                                  if (($row1 [16] != 0) || ($row1 [17] != 0))
                                    echo "-?";
                                  echo ")";
                                }
                                echo "</a>
                              </p>
                            </td>
                          </tr>
                        </table>";
                    }
                  }
                  else
                  {
                    onBD ($result1, "PEOPLE");
                    $i = 0;
                    $j = 0;
                    if ($isRoot)
                    {
                      onBD ($result1, "PEOPLE");
                      while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                        if ((($row1 [10] == $row [9]) || ($row1 [11] == $row [9])) &&
                          ($row1 [10] != 0) && ($row1 [11] != 0))
                        {
                          onBD ($result2, "PEOPLE");
                          while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                            if (($row1 [10] == $row2 [10]) &&
                              ($row1 [11] == $row2 [11]))
                            {
                              if ($row1 [9] == $row2 [9])
                                $j++;
                              break;
                            }
                        }
                    }
                    onBD ($result1, "PEOPLE");
                    while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                      if ((($row [12] == 1) && ($row1 [10] == $row [9])) ||
                        (($row [12] == 2) && ($row1 [11] == $row [9])))
                      {
                  	    $i++;
                        echo "<table style='position: absolute; left: ".($left1 + 110 * $i + 110 * $j)."px; top: ".$top1."px;' class='leave'>
                          <tr>
                            <td>
                              <p>
                                <a href = 'data.php?id=".$row1 [9].
                                "' title='";
                                if ($row1 [2] != "NULL")
                                  echo $row1 [2];
                                else
                                  echo "?";
                                if ($row1 [0] != "NULL")
                                  echo " ".$row1 [0];
                                else
                                  if ($row1 [2] != "NULL")
                                    echo " ?";
                                if ($row1 [1] != "NULL")
                                  echo " ".$row1 [1];
                                else
                                  echo "";
                                if ($row1 [3] != 0)
                                {
      	                          echo " (";
                                  if ($row1 [6] == 0)
                                    echo "р. ";
                                  echo $row1 [3];
                                  if ($row1 [6] != 0)
                                    echo "-";
                                  else                            
                                  {
                                    if ($row1 [16] != 0)
                                      echo "-?";
                                    echo ")";
                                  }
                                }
                                if ($row1 [6] != 0)
                                {
                                  if ($row1 [3] == 0)
                                    echo " (ум. ";
                                  echo $row1 [6];
                                  if (($row1 [16] != 0) || ($row1 [17] != 0))
                                    echo "-?";
                                  echo ")";
                                }
                                echo "'>";                                
								if ($row1 [0] == "NULL")
								{
								  echo "?";
								  if ($row1 [2] != "NULL")
									echo "<br/>".
								  $row1 [2];
								}
								else
								{
								  echo $row1 [0]."<br/>";
								  if ($row1 [2] == "NULL")
									echo "?";
								  else			
									echo $row1 [2];
								}
                                if ($row1 [3] != 0)
                                {
      	                          echo "<br/> 
      	                            (";
                                  if ($row1 [6] == 0)
                                    echo "р. ";
                                  echo $row1 [3];
                                  if ($row1 [6] != 0)
                                    echo "-";
                                  else
                                  {
                                    if ($row1 [16] != 0)
                                      echo "-?";
                                    echo ")";
                                  }
                                }
                                if ($row1 [6] != 0)
                                {
                                  echo "<br/>";
                                  if ($row1 [3] == 0)
                                    echo "(ум. ";
                                  echo $row1 [6];
                                  if (($row1 [16] != 0) || ($row1 [17] != 0))
                                    echo "-?";
                                  echo ")";
                                }
                                echo "</a>
                              </p>
                            </td>
                          </tr>
                        </table>";
                      }                
              	      if ($i > 0)   
                        drawTable ($row [10], $md - 1, $bord + 55, false, $gen + 1);
                      else
                        drawTable ($row [10], $md - 1, $bord, false, $gen + 1);
                  }
                }
                else
                  if ($row [11] != 0)
                  {
                    onBD ($result1, "PEOPLE");
                    $i = 0;
                    $j = 0;
                    if ($isRoot)
                    {
                      onBD ($result1, "PEOPLE");
                      while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                        if ((($row1 [10] == $row [9]) || ($row1 [11] == $row [9])) &&
                          ($row1 [10] != 0) && ($row1 [11] != 0))
                        {
                          onBD ($result2, "PEOPLE");
                          while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                            if (($row1 [10] == $row2 [10]) &&
                              ($row1 [11] == $row2 [11]))
                            {
                              if ($row1 [9] == $row2 [9])
                                $j++;
                              break;
                            }
                        }
                    }
                    onBD ($result1, "PEOPLE");
                    while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                      if (($row1 [11] == $row [11]) && ($row1 [9] != $row [9])
                        && ($row1 [0] != "virt"))
                      {
                  	    $i++;
                        echo "<table style='position: absolute; left: ".($left1 + 110 * $i + 110 * $j)."px; top:".$top1."px;' class='leave'>
                          <tr>
                            <td>
                              <p>
                                <a href = 'data.php?id=".$row1 [9].
                                "' title='";
                                if ($row1 [2] != "NULL")
                                  echo $row1 [2];
                                else
                                  echo "?";
                                if ($row1 [0] != "NULL")
                                  echo " ".$row1 [0];
                                else
                                  if ($row1 [2] != "NULL")
                                    echo " ?";
                                if ($row1 [1] != "NULL")
                                  echo " ".$row1 [1];
                                else
                                  echo "";
                                if ($row1 [3] != 0)
                                {
      	                          echo " (";
                                  if ($row1 [6] == 0)
                                    echo "р. ";
                                  echo $row1 [3];
                                  if ($row1 [6] != 0)
                                    echo "-";
                                  else
                                  {
                                    if ($row1 [16] != 0)
                                      echo "-?";
                                    echo ")";
                                  }
                                }
                                if ($row1 [6] != 0)
                                {
                                  if ($row1 [3] == 0)
                                    echo " (ум. ";
                                  echo $row1 [6];
                                  if (($row1 [16] != 0) || ($row1 [17] != 0))
                                    echo "-?";
                                  echo ")";
                                }
                                echo "'>";                                  
								if ($row1 [0] == "NULL")
								{
								  echo "?";
								  if ($row1 [2] != "NULL")
									echo "<br/>".
								  $row1 [2];
								}
								else
								{
								  echo $row1 [0]."<br/>";
								  if ($row1 [2] == "NULL")
									echo "?";
								  else			
									echo $row1 [2];
								}
								if ($row1 [3] != 0)
								{
								  echo "<br/> 
									(";
								  if ($row1 [6] == 0)
									echo "р. ";
								  echo $row1 [3];
								  if ($row1 [6] != 0)
									echo "-";
									  else
									  {
										if ($row1 [16] != 0)
										  echo "-?";
										echo ")";
									  }
								}
								if ($row1 [6] != 0)
								{
								  echo "<br/>";
								  if ($row1 [3] == 0)
									echo "(ум. ";
								  echo $row1 [6];
								  if (($row1 [16] != 0) || ($row1 [17] != 0))
									echo "-?";
								  echo ")";
								}
								echo "</a></p>
								</td>
								</tr>
								</table>";
              }                                 
              if ($i > 0)
              {                
                drawTable ($row [11], $md - 1, $bord + 55, false, $gen + 1); 
              }
              else
                drawTable ($row [11], $md - 1, $bord, false, $gen + 1);
            }
         }
  }
  function drawTable1 ($id, $mdc, $bord, $gmd, $isRoot)
  {
    relLeft1 ($id, $leftRel, $mdc);
    $left1 = $leftRel + $bord + 50;
    $top1 = 220 * $gmd - 220 * $mdc + 520;
    echo "<table style='position: absolute; left: ".$left1."px; top: ".$top1."px;' class='leave'>
    <tr>
      <td>";
        onBD ($result, "PEOPLE");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          if ($row [9] == $id)
          {
            echo "<p";
            if ($isRoot)
              echo " id='root'";
            echo ">
              <a href='data.php?id=".$row [9]."' title='";           
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
            if ($row [3] != 0)
            {
      	      echo " (";
              if ($row [6] == 0)
                echo "р. ";
              echo $row [3];
              if ($row [6] != 0)
                echo "-";
              else
              {
                if ($row [16] != 0)
                  echo "-?";
                echo ")";
              }
            }
            if ($row [6] != 0)
            {
              if ($row [3] == 0)
                echo " (ум. ";
              echo $row [6];
              if (($row [16] != 0) || ($row [17] != 0))
                echo "-?";
              echo ")";
            }
            echo "'>";
            if ($row [0] == "NULL")
            {
	      echo "?";
	      if ($row [2] != "NULL")
	        echo "<br/>".
	      $row [2];
	    }
	    else
	    {
	      echo $row [0]."<br/>";
	      if ($row [2] == "NULL")
		echo "?";
	      else			
	        echo $row [2];
	    }
            if ($row [3] != 0)
            {
      	      echo "<br/> 
      	        (";
              if ($row [6] == 0)
                echo "р. ";
              echo $row [3];
              if ($row [6] != 0)
                echo "-";
              else
              {
                if ($row [16] != 0)
                  echo "-?";
                echo ")";
              }
            }
            if ($row [6] != 0)
            {
              echo "<br/>";
              if ($row [3] == 0)
                echo "(ум. ";
              echo $row [6];
              if (($row [16] != 0) || ($row [17] != 0))
                echo "-?";
              echo ")";
            }
            echo "</a>
              </p>
              </td>
              </tr>
              </table>";
          }
        $j = 0;
    	onBD ($result, "PEOPLE");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          if ((($row [10] == $id) || ($row [11] == $id)) && ($row [10] != 0) &&
            ($row [11] != 0))
          {
            onBD ($result1, "PEOPLE");
            while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
              if (($row [10] == $row1 [10]) && ($row [11] == $row1 [11]))
              {
                if ($row [9] == $row1 [9])
                {
                  $j++;
              	  onBD ($result2, "PEOPLE");
              	  while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
              	    if (($row2 [9] == $row [10]) && ($id == $row [11]) ||
              	      ($row2 [9] == $row [11]) && ($id == $row [10]))
              	    {
                      echo "<table style='position: absolute; left: ".($left1 + 110 * $j)."px; top: ".$top1."px;' class='leave'>
                        <tr>
                          <td>
                            <p>
                            <a href = 'data.php?id=".$row2 [9]."' title='";
                              if ($row2 [2] != "NULL")
                                echo $row2 [2];
                              else
                                echo "?";
                              if ($row2 [0] != "NULL")
                                echo " ".$row2 [0];
                              else
                                if ($row2 [2] != "NULL")
                                  echo " ?";
                              if ($row2 [1] != "NULL")
                                echo " ".$row2 [1];
                              else
                                echo "";
                              if ($row2 [3] != 0)
                              {
      	                        echo " (";
                                if ($row2 [6] == 0)
                                  echo "р. ";
                                echo $row2 [3];
                                if ($row2 [6] != 0)
                                  echo "-";
                                else
                                {
                                  if ($row2 [16] != 0)
                                    echo "-?";
                                  echo ")";
                                }
                              }
                              if ($row2 [6] != 0)
                              {
                                if ($row2 [3] == 0)
                                  echo " (ум. ";
                                echo $row2 [6];
                                if (($row2 [16] != 0) || ($row2 [17] != 0))
                                  echo "-?";
                                echo ")";
                              }
                              echo "'>";
                              if ($row2 [0] == "NULL")
						      {
							    echo "?";
								if ($row2 [2] != "NULL")
								  echo "<br/>".
								$row2 [2];
							  }
							  else
							  {
								echo $row2 [0]."<br/>";
								if ($row2 [2] == "NULL")
								  echo "?";
			                    else			
								  echo $row2 [2];
							  }
                              if ($row2 [3] != 0)
                              {
      	                        echo "<br/> 
      	                          (";
                                if ($row2 [6] == 0)
                                  echo "р. ";
                                echo $row2 [3];
                                if ($row2 [6] != 0)
                                  echo "-";
                                else
                                {
                                  if ($row2 [16] != 0)
                                    echo "-?";
                                  echo ")";
                                }
                              }
                              if ($row2 [6] != 0)
                              {
                                echo "<br/>";
                                if ($row2 [3] == 0)
                                  echo "(ум. ";
                                echo $row2 [6];
                                if (($row2 [16] != 0) || ($row2 [17] != 0))
                                  echo "-?";
                                echo ")";
                              }
                              echo "</a></p>
                          </td>
                        </tr>
                      </table>";
              	    }
                }
                break;
              }
          }
          if ($mdc > 0)
          {
            $i = 0;
            onBD($result, "PEOPLE");
            while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
              if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
                $i++;
            if ($i == 1)
            {
              onBD($result, "PEOPLE");
              while ($row = mysqli_fetch_array($result))
                if ((($row [10] == $id) || ($row [11] == $id)) &&
                  ($row [0] != "virt"))
                  if ($j == 0)
                    drawTable1 ($row [9], $mdc - 1, $bord, $gmd, false);
                  else
                  {
            	    relLeft1 ($row [9], $rl, $mdc - 1);
            	    if ($rl > 0)
            	      drawTable1 ($row [9], $mdc - 1, $bord, $gmd, false);
            	    else
            	      drawTable1 ($row [9], $mdc - 1, $bord + 55, $gmd, false);
                  }
            }
            else
              if ($i != 0)
              {
                $ml = 0;
                onBDData ($result);
                while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
                  if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
                  {
                    drawTable1 ($row [9], $mdc - 1, $bord + $ml, $gmd, false);
                    $ml1 = 0;
                    maxLeft1 ($row [9], 0, $ml1, $mdc - 1);
                    $ml = $ml + $ml1 + 110;
                  }
              }
        }
  }
  function drawLines ($id, $md, $bord, $isRoot)
  {
    relLeft ($id, $leftRel, $md);
    $left1 = $leftRel + $bord + 50;
    $top1 = 220 * $md + 520;
	//echo " lr: ".$leftRel." b: ".$bord. " l1: ".$left1." md: ".$md." t1: ".$top1."')";
    if ($md > 0)
    {
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if ($row [9] == $id)
        {
          if ($row [10] != 0)
          {
            if ($row [11] != 0)
            {
              echo "jg.drawLine (".($left1 + 50).", ".$top1.", ".($left1 + 50).", ".($top1 - 40).");";
              $ml = 0;
              maxLeft ($row [11], 0, $ml, $md - 1);            	
              drawLines ($row [11], $md - 1, $bord, false);
              drawLines ($row [10], $md - 1, $bord + $ml + 110, false);
              onBD ($result1, "PEOPLE");
              $i = 0;
              $j = 0;
              if ($isRoot)
              {
                onBD ($result1, "PEOPLE");
                while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                  if ((($row1 [10] == $row [9]) || ($row1 [11] == $row [9])) &&
                    ($row1 [10] != 0) && ($row1 [11] != 0))
                  {
                    onBD ($result2, "PEOPLE");
                    while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                      if (($row1 [10] == $row2 [10]) &&
                        ($row1 [11] == $row2 [11]))
                      {
                        if ($row1 [9] == $row2 [9])
                          $j++;
                        break;
                      }
                    }
              }
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if (($row1 [11] == $row [11]) && ($row1 [9] != $row [9]) &&
                  ($row1 [0] != "virt"))
                {
                  $i++;
                  echo "jg.drawLine (".($left1 + 50 + $i * 110 + $j * 110).", ".$top1.", ".
                    ($left1 + 50 + $i * 110 + $j * 110).", ".($top1 - 40).");";
                }
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if (($row1 [10] == $row [10]) && ($row1 [9] != $row [9]) &&
                  ($row1 [11] != $row [11]) && ($row1 [0] != "virt"))
                {
                  $i++;
                  echo "jg.drawLine (".($left1 + 50 + $i * 110 + $j * 110).", ".$top1.", ".
                    ($left1 + 50 + $i * 110 + $j * 110).", ".($top1 - 40).");";
                }
                if ($i > 0)
                {
                  echo "jg.drawLine (".($left1 + 50).", ".($top1 - 40).", ".
                    ($left1 + 50 + $i * 110 + $j * 110).", ".($top1 - 40).");";
                  echo "jg.drawLine (".($left1 + 105).", ".($top1 - 40).", ".
                    ($left1 + 105).", ".($top1 - 80).");";
                  maxLeft ($row [11], 0, $ml1, $md - 1);
                  relLeft ($row [10], $rl1, $md - 1);              
                  echo "jg.drawLine (".($left1 + 50).", ".($top1 - 80).", ".
                    ($bord + $ml1 + $rl1 + 210).", ".($top1 - 80).");";              
                  echo "jg.drawLine (".($left1 + 50).", ".($top1 - 80).", ".
                    ($left1 + 50).", ".($top1 - 120).");";              
                  echo "jg.drawLine (".($bord + $ml1 + $rl1 + 210).", ".($top1 - 80).", ".
                    ($bord + $ml1 + $rl1 + 210).", ".($top1 - 120).");";
                }
                else
                {
                  echo "jg.drawLine (".($left1 + 50).", ".($top1 - 40).", ".($left1 + 50).
                    ", ".($top1 - 80).");";
                  maxLeft ($row [11], 0, $ml1, $md - 1);
                  relLeft ($row [10], $rl1, $md - 1);              
                  echo "jg.drawLine(".($left1 - 5).", ".($top1 - 80).", ".
                    ($bord + $ml1 + $rl1 + 210).", ".($top1 - 80).");";              
                  echo "jg.drawLine (".($left1 - 5).", ".($top1 - 80).", ".($left1-5).
                    ", ".($top1 - 120).");";              
                  echo "jg.drawLine (".($bord + $ml1 + $rl1 + 210).", ".($top1 - 80).", ".
                    ($bord + $ml1 + $rl1 + 210).", ".($top1 -120).");";
                }
            }
            else
            {
              echo "jg.drawLine (".($left1 + 50).", ".$top1.", ".($left1 + 50).", ".
          	    ($top1 - 40).");";
              onBD ($result1, "PEOPLE");
              $i = 0;
              $j = 0;
              if ($isRoot)
              {
                onBD ($result1, "PEOPLE");
                while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                  if ((($row1 [10] == $row [9]) || ($row1 [11] == $row [9])) &&
                    ($row1 [10] != 0) && ($row1 [11] != 0))
                  {
                    onBD ($result2, "PEOPLE");
                    while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                      if (($row1 [10] == $row2 [10]) && ($row1 [11] == $row2 [11]))
                      {
                        if ($row1 [9] == $row2 [9])
                          $j++;
                        break;
                      }
                    }
              }
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if (($row1 [10] == $row [10]) && ($row1 [9] != $row [9]) &&
                  ($row1 [0] != "virt"))
                {
                  $i++;
                  echo "jg.drawLine (".($left1 + 50 + $i * 110 + $j * 110).", ".$top1.", ".
                    ($left1 + 50 + $i * 110 + $j * 110).", ".($top1 - 40).");";
                }
              if ($i > 0)
              {
                echo "jg.drawLine (".($left1 + 50).", ".($top1 - 40).", ".
                  ($left1 + 50 + $i * 110 + $j * 110).", ".($top1 - 40).");";
                echo "jg.drawLine (".($left1 + 105).", ".($top1 - 40).", ".($left1 + 105).
                  ", ".($top1 - 120).");";				
				drawLines ($row [10], $md - 1, $bord + 55, false);
              }
              else
			  {				  
                echo "jg.drawLine (".($left1 + 50).", ".($top1 - 40).", ".($left1 + 50).
                  ", ".($top1 - 120).");";
                drawLines ($row [10], $md - 1, $bord, false);
			  }
            }
          }
          else
            if ($row [11] != 0)
            {
              echo "jg.drawLine (".($left1 + 50).", ".$top1.", ".($left1 + 50).", ".
                ($top1 - 40).");";    
              onBD ($result1, "PEOPLE");
              $i = 0;          
              $j = 0;
              if ($isRoot)
              {
                onBD ($result1, "PEOPLE");
                while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                  if ((($row1 [10] == $row [9]) || ($row1 [11] == $row [9])) &&
                    ($row1 [10] != 0) && ($row1 [11] != 0))
                  {
                    onBD ($result2, "PEOPLE");
                    while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                      if (($row1 [10] == $row2 [10]) &&
                        ($row1 [11] == $row2 [11]))
                      {
                        if ($row1 [9] == $row2 [9])
                          $j++;
                        break;
                      }
                  }
              }
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if (($row1 [11] == $row [11]) && ($row1 [9] != $row [9]) &&
                  ($row1 [0] != "virt"))
                {
                  $i++;
                  echo "jg.drawLine (".($left1 + 50 + $i * 110 + $j * 110).", ".$top1.", ".
                    ($left1 + 50 + $i * 110 + $j * 110).", ".($top1 - 40).");";
                }
              if ($i > 0)
              {
                echo "jg.drawLine (".($left1 + 50).", ".($top1 - 40).", ".
                  ($left1 + 50 + $i * 110 + $j * 110).", ".($top1 - 40).");";
                echo "jg.drawLine (".($left1 + 105).", ".($top1 - 40).", ".($left1 + 105).
                  ", ".($top1 - 120).");";				
                drawLines ($row [11], $md - 1, $bord + 55, false);
              }
              else
			  {
                echo "jg.drawLine (".($left1 + 50).", ".($top1 - 40).", ".($left1 + 50).
                  ", ".($top1 - 120).");";					
                drawLines ($row [11], $md - 1, $bord, false);
			  }
            }
        }
    }
  }
  function drawLines1 ($id, $mdc, $bord, $gmd)
  {
    relLeft1 ($id, $leftRel, $mdc);
    $left1 = $leftRel + $bord + 50;
    $top1 = 220 * $gmd - 220 * $mdc + 520;
    $i = 0;
    $j = 0;
	//echo " l1: ".$left1." id: ".$id." lr: ".$leftRel." mdc: ".$mdc." bord: ".$bord." gmd: ".$gmd." l1: ".$left1." t1 ".$top1;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ((($row [10] == $id) || ($row [11] == $id)) && ($row [10] != 0) && ($row [11] != 0))
      {
        onBD ($result1, "PEOPLE");
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if (($row [10] == $row1 [10]) && ($row [11] == $row1 [11]))
          {
            if ($row [9] == $row1 [9])
            {
              $j++;
              onBD ($result2, "PEOPLE");
              while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                if (($row2 [9] == $row [10]) && ($id == $row [11]) ||
                  ($row2 [9] == $row [11]) && ($id == $row [10]))
                  echo "jg.drawLine (".($left1 + 50 + $j * 110).", ".($top1 + 100).", ".
                    ($left1 + 50 + $j * 110).", ".($top1 + 140).");";
				  echo "console.log (".($left1 + 50 + $j * 110).", ".($top1 + 100).", ".
                    ($left1 + 50 + $j * 110).", ".($top1 + 140).");";
            }
            break;
          }
      }
    if ($j > 0)
    {
      echo "jg.drawLine (".($left1 + 50).", ".($top1 + 100).", ".($left1 + 50).", ".($top1 + 140).");
      jg.drawLine (".($left1 + 50).", ".($top1 + 140).", ".($left1 + 50 + $j * 110).", ".($top1 + 140).");";
    }
    if ($mdc > 0)
    {
      onBD($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
          $i++;
      if ($i == 1)
      {
        onBD($result, "PEOPLE");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
          {
            if ($j == 0)
            {
              echo "jg.drawLine (".($left1 + 50).", ".($top1 + 100).", ".($left1 + 50).", ".
                ($top1 + 220).");";
              drawLines1 ($row [9], $mdc - 1, $bord, $gmd);
            }
            else
            {
              relLeft1 ($row [9], $rl1, $mdc - 1);
              if ($rl1 > 0)
                drawLines1 ($row [9], $mdc - 1, $bord, $gmd);
              else
                drawLines1 ($row [9], $mdc - 1, $bord + 55, $gmd);
              echo "jg.drawLine (".($left1 + 105).", ".($top1 + 140).", ".($left1 + 105).", ".($top1 + 220).");";
            }
          }
      }
      else
        if ($i != 0)
        {
          if ($j == 0)
            echo "jg.drawLine (".($left1 + 50).", ".($top1 + 100).", ".($left1 + 50).", ".
              ($top1 + 180).");";
          else      	  
            echo "jg.drawLine (".($left1 + 105).", ".($top1 + 140).", ".($left1 + 105).", ".
      	      ($top1 + 180).");";
       	  onBDData ($result);
          $isFirst = true;
          $temp = 0;
          $ml = 0;
          while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
            if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
            {
  	      relLeft1 ($row [9], $leftRel1, $mdc - 1);
              if ($isFirst)
                $isFirst = false;
              else
           	echo "jg.drawLine (".($temp + 50).", ".($top1 + 180).", ".
          	  ($bord + $ml + $leftRel1 + 100).", ".($top1 + 180).");";
              echo "jg.drawLine (".($bord + $ml + $leftRel1 + 100).", ".($top1 + 180).", ".
                ($bord + $ml + $leftRel1 + 100).", ".($top1 + 220).");";
              drawLines1 ($row [9], $mdc - 1, $bord + $ml, $gmd);
              $ml1 = 0;
              maxLeft1 ($row [9], 0, $ml1, $mdc - 1);
              $temp = $bord + $ml + $leftRel1 + 50;
              $ml = $ml + $ml1 + 110;
            }
          }
        }
  }
  function relLeft ($id, &$left, $md)
  {
	//echo " md: ".$md." l: ".$left;
    if ($md > 0)
    {
      $i = 0;
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array($result))
  	    if ($row [9] == $id)
  	    {
  	      if ($row [11] != 0)
  	      {
  	        onBD ($result1, "PEOPLE");
  	        while ($row1 = mysqli_fetch_array($result1))
  	          if (($row1 [11] == $row [11]) && ($row1 [0] != "virt"))
  	            $i++;
  	      }
  	      if ($row [10] != 0)
  	      {
  	        onBD ($result1, "PEOPLE");
  	        while ($row1 = mysqli_fetch_array($result1))
  	          if (($row1 [10] == $row [10]) && ($row1 [0] != "virt") &&
  	            ($row1 [11] != $row [11]))
  	        $i++;
  	      }
  	    }
  	  onBD ($result, "PEOPLE");
  	  while ($row = mysqli_fetch_array($result))
  	    if ($row [9] == $id)
  	      if ($row [11] != 0)
  	      {
  	        relLeft ($row [11], $left1, $md - 1);
  	        if ($row [10] != 0)
  	        {
  	      	  if ($i > 1)
  	      	    $left = $left1;
  	      	  else
  	            $left = $left1 + 55;
  	        }
  	        else
  	          if ($i > 1)
  	            if ($left1 > 55)
  	              $left = $left1 - 55;
  	            else
  	              $left = 0;
  	          else
  	            $left = $left1;
  	      }
  	      else
  	        if ($row [10] != 0)
  	        {
  	          relLeft ($row [10], $left1, $md - 1);
  	          if ($i > 1)
  	            if ($left1 > 55)
                  $left = $left1 - 55;
  	            else
  	              $left = 0;
  	          else
  	            $left = $left1;
  	        }
  	        else
  	          $left = 0;
  	}
  	else
  	  $left = 0;
  }
  function relLeft1 ($id, &$left, $mdc)
  {
    if ($mdc > 0)
    {
      $i = 0;
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array($result))
        if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
          $i++;
      $isMarried = false;
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array($result))
        if ((($row [10] == $id) || ($row [11] == $id)) && ($row [10] != 0) && ($row [11] != 0))
  	  $isMarried = true;
      if ($i == 1)
      {
        onBD ($result, "PEOPLE");
        while ($row = mysqli_fetch_array($result))
          if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
          {
            relLeft1 ($row [9], $left1, $mdc - 1);
            if ($isMarried)
              if ($left1 < 55)
                $left = 0;
  	          else
  	            $left = $left1 - 55;
  	        else
  	          $left = $left1;
  	      }
  	  }
  	  else
  	    if ($i > 0)
  	    {
  	      onBDData ($result);
  	      while ($row = mysqli_fetch_array($result))
  	        if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
  	        {
  	          relLeft1 ($row [9], $left1, $mdc - 1);
  	          if ($isMarried)
  	            $left = $left1;
  	          else
  	            $left = $left1 + 55;
  	          break;
  	        }
  	    }
  	    else
  	      $left = 0;
    }
    else
  	  $left = 0;
  }
  
  function maxLeft ($id, $bord, &$ml, $md)
  {
    relLeft ($id, $leftRel, $md);
    $left1 = $leftRel + $bord;
    if ($left1 > $ml)
      $ml = $left1;
    if ($md > 0)
    {
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if ($row [9] == $id)
        {
          if ($row [10] != 0)
            if ($row [11] != 0)
            {
              $ml1 = 0;
              maxLeft ($row [11], 0, $ml1, $md - 1);
              $i = 0;
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if (($row1 [11] == $row [11]) && ($row1 [0] != "virt"))
                  $i++;            
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array($result1))
                if (($row1 [10] == $row [10]) && ($row1 [11] != $row [11]) &&
                  ($row1 [0] != "virt"))
              	  $i++;
              maxLeft ($row [10], $bord + $ml1 + 110, $ml, $md - 1);
              if ($left1 + ($i - 1) * 110 > $ml)
                $ml = $left1 + ($i - 1) * 110;
            }
            else
            {
              $i = 0;
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if (($row1 [10] == $row [10]) && ($row1 [0] != "virt"))
                  $i++;  
              if ($left1 + ($i - 1) * 110 > $ml)
                $ml = $left1 + ($i - 1) * 110;
              relLeft ($row [10], $leftRel1, $md - 1);
              if ($i > 1)
                maxLeft ($row [10], $bord + 55, $ml, $md - 1);
              else
                maxLeft ($row [10], $bord, $ml, $md - 1);
            }
          else
            if ($row [11] != 0)
            {
              $i = 0;
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if (($row1 [11] == $row [11]) && ($row1 [0] != "virt"))
                  $i++;  
              if ($left1 + ($i - 1) * 110 > $ml)
                $ml = $left1 + ($i - 1) * 110;
              if ($i > 1)
                maxLeft ($row [11], $bord + 55, $ml, $md - 1);
              else
                maxLeft ($row [11], $bord, $ml, $md - 1);
            }
        }
    }
  }  
  function maxLeft1 ($id, $bord, &$ml, $mdc)
  {
    relLeft1 ($id, $leftRel, $mdc);
    $left1 = $leftRel + $bord;
    if ($left1 > $ml)
      $ml = $left1;
    $j = 0;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ((($row [10] == $id) || ($row [11] == $id)) && ($row [10] != 0) && ($row [11] != 0))
      {
        onBD ($result1, "PEOPLE");
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if (($row [10] == $row1 [10]) && ($row [11] == $row1 [11]))
          {
            if ($row [9] == $row1 [9])
            $j++;
            break;
          }
      }
    if ($left1 + 110 * $j > $ml)
      $ml = $left1 + 110 * $j;
  	if ($mdc > 0)
  	{
	  $i = 0;
  	  onBD ($result, "PEOPLE");
  	  while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	    if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
  	      $i++;
  	  if ($i == 1)
  	  {
  	    onBD ($result, "PEOPLE");
  	    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	      if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
  	        if ($j == 0)
  	          maxLeft1 ($row [9], $bord, $ml, $mdc - 1);
  	        else
  	        {
  	      	  relLeft1 ($row [9], $rl, $mdc - 1);
  	      	  if ($rl > 0)  	      	  
  	            maxLeft1 ($row [9], $bord, $ml, $mdc - 1);
  	          else
  	            maxLeft1 ($row [9], $bord + 55, $ml, $mdc - 1);
  	        }
  	  }
  	  else
  	    if ($i > 0)
            {
  	      $ml1 = 0;
  	      onBDData ($result);
  	      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	        if ((($row [10] == $id) || ($row [11] == $id)) && ($row [0] != "virt"))
  	        {
  	      	  $ml2 = 0;
  	          maxLeft1 ($row [9], 0, $ml2, $mdc - 1);
  	          maxLeft1 ($row [9], $bord + $ml1, $ml, $mdc - 1);
  	          $ml1 = $ml1 + $ml2 + 110;
  	        }
  	    }
  	}
  }
?>