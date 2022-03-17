<?php $index = 0;
/*
Для какой версии PHP будет работать этот скрипт?
Что выведет этот скрипт?
*/
class Test{
private $var;
function setMe($value){
$this->var = $value;
}
}
class More extends Test{
public $var;
}
$oTest = new Test;
$oMore = new More;
echo $oTest->setMe(‘foo’);
echo $oMore->setMe(‘foo’);
echo $oMore->var;
//echo $oTest->var;
?>


