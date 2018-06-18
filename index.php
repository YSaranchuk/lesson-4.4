<!doctype html>
<html lang="ru">
<head>
<title>урок 4.4 </title>
</head>
<body>
<?php
    header("Content-Type: text/html; charset=utf-8");
    $host="localhost";    
    $user="root";        
    $pass="";             
    $db_name="test"; 
    $link=mysql_connect($host, $user, $pass); 
    mysql_select_db($db_name, $link);       

    mysql_query("CREATE TABLE IF NOT EXISTS `products`(
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `Name` text NOT NULL,
        `Price` int(11) NOT NULL,
        PRIMARY KEY(`id`))
        ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ")
         or die(mysql_error());
    
    
?>
<?php
    $link=mysql_connect($host, $user, $pass); 
    or die(mysql_error()); 
    $sql = mysql_query($db_name, "SHOW TABLES FROM `test`"); 
    while ($row = mysql_fetch_array($sql)) { 
    echo "Таблица: <a href='?id_table={$row[0]}'>{$row[0]}</a><br>"; 
}
 
echo "В базе `test`: ".mysql_num_rows($sql)." таблиц"; 
 
if (isset($_GET['id_table'])) {
    $rs = mysql_query($db_name, "SELECT * FROM ".$_GET['id_table'].""); 

    if (isset($_GET['del_id'])) { //проверяем, есть ли переменная на удаление
        $sql = mysql_query('DELETE FROM `products` WHERE `ID` = '.$_GET['del_id']); //удаляем строку из таблицы
    }
    
    if (isset($_GET['red_id'])) { //Проверяем, передана ли переменная на редактирования
        if (isset($_POST['Name'])) { //Если новое имя предано, то обновляем и имя и цену
            $sql = mysql_query('UPDATE `products` SET '
                    .'`Name` = "'.$_POST['Name'].'",'
                    .'`Price` = '.$_POST['Price'].' '
                    .'WHERE `ID` = '.$_GET['red_id']);
        }
    }
    ?>
     <table border='1'>
    <?php
    while($row_rs = mysql_fetch_assoc($rs)) 
    {
    ?>
        <tr>
    <?php
        foreach($row_rs as $val) //перебор массива в цикле
        {
 
            echo "<td>".$val."</td>"; //вывод данных
               
        }
    ?>
        </tr>
 
    <?php }?>
 
</table>
    
<?php }
?>
<table border='1'>
<tr>
    <td>Идентификатор</td>
    <td>Наименование</td>
    <td>Цена</td>
</tr>
<?php
$sql = mysql_query("SELECT `ID`, `Name`, `Price` FROM `products`", $link);
while ($result = mysql_fetch_array($sql)) {
    echo     '<tr><td>'.$result['ID'].'</td>'.
             '<td>'.$result['Name'].'</td>'.
             '<td>'.$result['Price'].' рублей</td>'.
             '<td><a href="?del_id='.$result['ID'].'">Удалить</a></td>'.
             '<td><a href="?red_id='.$result['ID'].'">Редактировать</a></td></tr>';
}
?>
</table>

<?php
    if (isset($_GET['red_id'])) { //Если передана переменная на редактирование
        $sql = mysql_query("SELECT `ID`, `Name`, `Price` FROM `products` WHERE `ID`=".$_GET['red_id'], $link);  
        $result = mysql_fetch_array($sql); //получение самой записи
        ?>
<table>
<form action="" method="post">
    <tr>
        <td>Наименование:</td>
        <td><input type="text" name="Name" value="<?php echo ($result['Name']); ?>"></td>
    </tr>
    <tr>
        <td>Цена:</td>
        <td><input type="text" name="Price" size="3" value="<?php echo ($result['Price']); ?>"> руб.</td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="OK"></td>
    </tr>
</form>
</table>
        <?php
    }
?>

</body>
</html>
