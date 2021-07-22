<?php
require "controllerDB.php";

// Создание таблиц
createTablePosts();
createTableComments();

// Проверка, если не существует таблицы, их создание
if(!havePosts()) {
    $dataPosts = getData("https://jsonplaceholder.typicode.com/posts");
    setPost($dataPosts);
}
if(!haveComments()) {
    $dataComments = getData("https://jsonplaceholder.typicode.com/comments");
    setComments($dataComments);
}

/**
 * @param $url
 *
 * Получение данных
 *
 * @return mixed
 */
function getData($url)
{
    $json_url = $url;
    $data = file_get_contents($json_url);
    $json = json_decode($data, true);

    return $json;
}

// Проверка на существование поискового запроса
if(mb_strlen($_POST["search"]) >= 3) {
    search($_POST["search"]);
}
else if(mb_strlen($_POST["search"]) >= 1) {
    echo "Введите минимум 3 символа";
}
?>

<!-- Поисковая строка с кнопкой -->
<form method="post">
    <div style="display:flex; justify-content:center;">
        <input type="text" name="search" placeholder="Введите ваш запрос" style="border:1px solid #d9d9d9; border-radius: 11px 0px 0px 11px; padding: 15px; width:500px">
        <input type="submit" value="Найти" style="border-radius: 0px 11px 11px 0px; border:1px solid #d9d9d9; background: #f0ff47; padding:10px 50px 10px 50px">
    </div>
</form>
