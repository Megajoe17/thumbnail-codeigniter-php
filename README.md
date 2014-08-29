thumbnail-codeigniter-php
=========================

Создание thumbnail из картинки оригинального размера на лету

Используется для создания уменьшенных копий картинок на лету. 
Пример использования, в тег img вставляете картинку 
например 
$img_name_from_db = 'car.jpg'; 
define('NEWS_PATH', 'media/upload/news/');
парамметры по умолчанию:
$defaults = [
        'file' => false, - имя файла
        'path' => false, - путь к фалу
        'size' => false, - размеры создаваемой картинки, массив array(widht, height)
        'with_http' => false, - возвращать путь с http и доменом или без
        'need_crop' => true, - делать обрезку crop картинки
        'center' => true, - центрировать во время crop-a
        'orientation' => 'inside', - возможные значения inside или outside, определяет принцип обрезки, inside - обе оси                                        входили в предполагаемую область, outside при достижении одной оси останавливается                                         уменьшение
        'file_no_image' => 'noimage.png', - картинка заставка, если нет картинки file
        'path_no_image' => 'media/upload/no_image/' - путь к картинке заставке
    ];<br>
< img src='".get_img(array('file'=>$img_name_from_db, 'path'=>NEWS_PATH, 'size'=>array(100, 200)))."' />
