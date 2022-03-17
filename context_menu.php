<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<style>
/* Класс контекстного меню: */
 .context-menu
  {
       position: absolute;
/* Задаем абсолютное позиционирование для нашего меню */
     display: none; /* Изначально не показываем его */
          background-color: #fff;/* Цвет фона меню */
     border: 1px solid #333; 
-moz-box-shadow: -5px 2px 10px rgba(0,0,0,0.5);
-webkit-box-shadow: -5px 2px 10px rgba(0,0,0,0.5);
box-shadow: -5px 2px 10px rgba(0,0,0,0.5);
.context-menu ul { list-style: none; margin: 0; padding: 0; };
.context-menu ul li { margin: 0; padding: 0; background-color: #fff; };
.context-menu ul li { margin: 0; padding: 0; background-color: #fff;};
.context-menu ul li a { color: #333; text-decoration: none; font-size: 12px; display: block; padding: 5px; }
.context-menu ul li a:hover { background-color: #eee; }
}
</style>
<script>
$(document).ready(function() {      // Вешаем слушатель события нажатие кнопок мыши для вс 
	$(document).mousedown(function(event) { 
		$('*').removeClass('selected-html-element');
		$('.context-menu').remove(); 
		 if (event.which === 3)  { 
			 var target = $(event.target);    
			 target.addClass('selected-html-element');    
			 $('<div/>', {                 class: 'context-menu' 
			 })             
			 .css({                 left: event.pageX+'px', 
				 top: event.pageY+'px'
			 })             .appendTo('body')
			 .append(
					 $('<ul/>').append('<li><a href="#">Remove element</a></li>') 
					 .append('<li><a href="#">Add element</a></li>')
					 .append('<li><a href="#">Element style</a></li>') 
					 .append('<li><a href="#">Element props</a></li>')
					 .append('<li><a href="#">Open Inspector</a></li>')
			 )              .show('fast');}     }); });
</script>
<p>l</p>
<?php $index = 0;

?>