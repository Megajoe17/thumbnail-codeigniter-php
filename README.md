thumbnail-codeigniter-php
=========================

Создание thumbnail из картинки оригинального размера на лету<br>
<br>
Используется для создания уменьшенных копий картинок на лету. <br>
Пример использования, в тег img вставляете картинку <br>
например <br>
$img_name_from_db = 'car.jpg'; <br>
define('NEWS_PATH', 'media/upload/news/');<br>
парамметры по умолчанию:<br>
$defaults = [<br>
&nbsp&nbsp&nbsp&nbsp'file' => false, - имя файла<br>
   'path' => false, - путь к фалу<br>
   'size' => false, - размеры создаваемой картинки, массив array(widht, height)<br>
   'with_http' => false, - возвращать путь с http и доменом или без<br>
   'need_crop' => true, - делать обрезку crop картинки<br>
        'center' => true, - центрировать во время crop-a<br>
        'orientation' => 'inside', - возможные значения inside или outside, определяет принцип обрезки, inside - обе оси                                        входили в предполагаемую область, outside при достижении одной оси останавливается                                         уменьшение<br>
        'file_no_image' => 'noimage.png', - картинка заставка, если нет картинки file<br>
        'path_no_image' => 'media/upload/no_image/' - путь к картинке заставке<br>
    ];<br>
< img src="<?=get_img(array('file'=>$img_name_from_db, 'path'=>NEWS_PATH, 'size'=>array(100, 200)))?>' />
<br/>
<br/>
Для работы хелпера нужны две стандартные библиотеки Codeigniter <br/>

image_lib и image_moo

