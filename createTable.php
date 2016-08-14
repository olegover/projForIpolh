<?php
// извлекаем
$catalog = [];
$page = file_get_contents('http://demo12.om-sv.ru/progtest/arData.txt');
$data = json_decode($page);
// извлекаем данные в ассоциативный массив
foreach($data->SECTIONS as $key => $value) {
    $name = $value->NAME ;
    $id = $value->SECTION_PAGE_URL;
    $catalog[$id]=$name;
}
// сортируем в алфавитном порядке с сохранением ключей
asort($catalog);
// получаем массив выделенными буквами
$arrFirstLetter=[];
$sFirstLetterLastRow = null;
foreach($catalog as $key=>$val){
    $sFirstLetter = mb_substr($catalog[$key], 0, 1);
    if ($sFirstLetter !== $sFirstLetterLastRow) {
        $sFirstLetterLastRow = $sFirstLetter;
        array_push($arrFirstLetter, $sFirstLetter);
    }
}
// объедеияем массив с данными, с массивом выделенных букв
$final = array_merge($catalog,$arrFirstLetter);
asort($final);
// делаем из ассоциативного массива массив с ключами и массив со значениями
$link=[];
$name=[];
foreach($final as $key=>$value){
    $link[] = $key;
    $name[] = $value;
}
// получаем массивы "столбцов"
$column = count($final)/3 + 1;
$td = (array_chunk($name, $column));
$a = (array_chunk($link, $column));
// вывод данных в таблице
echo '<table>';
for( $i=0; $i<count($td[0]); $i++){
    echo '<tr>';
        if(!is_numeric($a[0][$i]))
            echo '<td style="padding: 4px"><a href="'.$a[0][$i].'">'.$td[0][$i].'</a></td>';
        else
            echo '<td style="padding: 4px">'.$td[0][$i].'</a></td>';
        if(!is_numeric($a[1][$i]))
            echo '<td style="padding: 4px"><a href="'.$a[1][$i].'">'.$td[1][$i].'</a></td>';
        else
            echo '<td style="padding: 4px">'.$td[1][$i].'</a></td>';
        if(isset($td[2][$i])) {
            if(!is_numeric($a[2][$i]))
                echo '<td style="padding: 4px"><a href="'.$a[2][$i].'">'.$td[2][$i].'</a></td>';
            else
                echo '<td style="padding: 4px">'.$td[2][$i].'</a></td>';
        }
    echo '</tr>';
}
echo '</table>';

?>

<!--Можно вместо записи в <td>
<style>
    td{
        padding: 4px;
    }
</style>
-->