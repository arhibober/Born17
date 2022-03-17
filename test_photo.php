<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="res/css/photolabel.css"> <!-- стили jQuery.photolabel -->
<link rel="stylesheet" type="text/css" href="res/css/ui-lightness/jquery-ui-1.8.22.custom.css"> <!-- стили jQuery.ui -->

<script type="text/javascript" src="res/js/jquery/jquery-1.7.2.min.js"></script> <!-- jQuery -->
<script type="text/javascript" src="res/js/jquery/jquery-ui-1.8.22.custom.min.js"></script> <!-- jQuery.ui -->
<script type="text/javascript" src="res/js/jquery.photolabel.js"></script> <!-- плагин jQuery.photolabel-->

<style>
    body {
        font-size: 12px;
        font-family: Tahoma;
        background: #000;
        color: white;
    }
    
    a {
        color: #0080FF;
    }
    
    .center {
        margin:0 auto;
        width:700px;
    }
    
    .tools {
        margin-top:10px;
        background: #333;        
        border:1px solid #ACACAC;
        border-radius:3px;
        padding:10px;
        text-align:center;
    }
    .tools a{
        color: white;
    }
    
    .info {
        margin-bottom:10px;
        text-align:center;
        padding:10px;
        background: #333;        
        border:1px solid #ACACAC;
        border-radius:3px;
        display:none;
    }
</style>

</head>
<body>
<div class="center">
    <h2>Отметки на фото. Пример использования jQuery.photoLabel</h2>
    <!-- Блок с фотографией, на которой есть отметки -->
    <div id="block-1" class="photoLabel">
        <div class="info">
            Отметьте знакомых Вам людей на фотографии. <a href="JavaScript:;" onclick="$('#block-1 .imgWrap').photoLabel('stop')">Готово</a>
        </div>

        <div class="imgWrap" style="width:700px;"> <!-- Плагин навешивается на этот элемент. Он должен иметь фиксированную ширину и внутреннее выравнивание по центру -->
            <img src="res/img/Russia.jpg">
        </div>
        
        <!-- Блок со списком отметок -->
        <div class="labelBox">
            <div class="recoverTags"><!-- здесь будет ссылка на восстановление тега --></div>
            <div class="labelList"> <!-- этот блок будет скрываться, если отметок нет -->
                На этой фотографии: 
                <ul class="labels">
                    <!-- здесь будут перечилены отметки на фото -->
                </ul>
            </div>
        </div>
        <!-- Конец блока со списком отметок -->
        
        <!-- Блок с кнопками -->
        <div class="tools">
            <a href="JavaScript:;" onclick="$('#block-1 .imgWrap').photoLabel('start')" class="turnOn">Отметить человека на фото</a>
            <a href="JavaScript:;" onclick="$('#block-1 .imgWrap').photoLabel('stop')" style="display:none" class="turnOff">Готово</a>
        </div>
        <!-- Конец блока с кнопками -->
    </div>
    <!-- Конец блока с фотографией, на которой есть отметки -->
</div>

<script>
$(function() {
    $('#block-1 .imgWrap').photoLabel({
        onStart: function() { //Обработчик на событие - "start" (начало процедуры отметок на фото)
            $('#block-1 .turnOn').hide();
            $('#block-1 .turnOff').show();
            $('#block-1 .info').show();            
        },
        onStop: function() { //Обработчик на событие - "stop" (завершение процедуры отметок на фото)
            $('#block-1 .turnOn').show();
            $('#block-1 .turnOff').hide();            
            $('#block-1 .info').hide();            
        },
        recoverContainer: '#block-1 .recoverTags', //Контейнер для ссылки "восстановить тег"
        labelListContainer: '#block-1 .labelList', //Общий контейнер, для списка отметок.
        labelContainer: '#block-1 .labels', //UL контейнер для списка отметок
        
        addTagUrl: "php/tags.php?Act=addTag", //Адрес скрипта, который будет вызван при добавлении метки
        removeTagUrl: "php/tags.php?Act=removeTag", //Адрес скрипта, который будет вызван при удалении метки
        recoverTagUrl: "php/tags.php?Act=recoverTag", //Адрес скрипта, который будет вызван при восстановлении метки
        
        friends: {
            "1": {id: 1, fullname:"Татьяна Сидорова", url: "JavaScript: alert('здесь может быть переход на страницу Татьяны Сидоровой')"},
            "2": {id: 2, fullname:"Петр Иванов", url: "JavaScript: alert('здесь может быть переход на страницу Петра Иванова')"},
            "52": {id: 52, fullname: "Артём Полторанин", url: "JavaScript: alert('здесь может быть переход на страницу Артема Полторанина')"}
        },
        isAdmin: 1, //1 - если фото просматривает модератор, 0 - если обычный пользователь
        viewerId: -1, //id текущего пользователя в вашей системе
        areas: //Список отмеченных областей на изображении
        [{
            "id":"100",
            "leftTopX":"0.21143",
            "leftTopY":"0.39140",
            "rightBottomX":"0.50143",
            "rightBottomY":"0.86237",
            "item_id":1,
            "creator_id":"1447",
            "item_url":"JavaScript: alert('здесь может быть переход на страницу Татьяны Сидоровой')",
            "item_title":"Татьяна Сидорова"
        }, {
            "id":"101",
            "leftTopX":"0.37714",
            "leftTopY":"0.03226",
            "rightBottomX":"0.71429",
            "rightBottomY":"0.59570",
            "item_id":2,
            "creator_id":"1447",
            "item_url":"JavaScript: alert('здесь может быть переход на страницу Петра Иванова')",
            "item_title":"Петр Иванов"
        }, {
            "id":"102",
            "leftTopX":"0.19429",
            "leftTopY":"0.18710",
            "rightBottomX":"0.35000",
            "rightBottomY":"0.36989",
            "item_id":0,
            "creator_id":"1447",
            "item_url":"",
            "item_title":"Рожки"
            }]
    });
});

</script>
  
</body>
</html>