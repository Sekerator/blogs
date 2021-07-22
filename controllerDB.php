<?php
require "connect_db.php";

/**
 * Создание таблицы posts
 */
function createTablePosts()
{
    $stmt = getConn()->prepare("
                                        create table posts
                                        (
                                             id integer not null auto_increment primary key,
                                             user_id integer,
                                             title varchar(127),
                                             body varchar(511)
                                        );
                                    ");
    $stmt->execute();

}

/**
 * Создание таблицы comments
 */
function createTableComments()
{
    $stmt = getConn()->prepare("
                                        create table comments
                                        (
                                             id integer not null auto_increment primary key,
                                             post_id int references posts(id),
                                             name varchar(127),
                                             email varchar(127),
                                             body varchar(511)
                                        );
                                    ");
    $stmt->execute();
}

/**
 * @param $data
 *
 * Загрузка данных post в таблицу
 */
function setPost($data)
{
    foreach ($data as $post)
    {
        $stmt = getConn()->prepare("INSERT INTO posts(user_id, title, body) VALUES(:user_id, :title, :body)");
        $stmt->execute([
            "user_id" => $post["userId"],
            "title" => $post["title"],
            "body" => $post["body"]
        ]);
    }
    echo "<h3>Загружено " . count($data) . " записей<br></h3>";
}

/**
 * @param $data
 *
 * Загрузка данных comment в таблицу
 */
function setComments($data)
{
    foreach ($data as $post)
    {
        $stmt = getConn()->prepare("INSERT INTO comments(post_id, name, email, body) VALUES(:post_id, :name, :email, :body)");
        $stmt->execute([
            "post_id" => $post["postId"],
            "name" => $post["name"],
            "email" => $post["email"],
            "body" => $post["body"]
        ]);
    }
    echo "<h3>Загружено " . count($data) . " комментариев<br></h3>";
}

/**
 * Проверка на существование таблицы posts
 *
 * @return bool
 */
function havePosts()
{
    $stmt = getConn()->prepare("SELECT * FROM posts");
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (!$result) {
        return false;
    }


    echo "<h3>Данные уже были загружены ранее<br></h3>";
    return true;
}

/**
 * Проверка на существование таблицы comments
 *
 * @return bool
 */
function haveComments()
{
    $stmt = getConn()->prepare("SELECT * FROM comments");
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (!$result) {
        return false;
    }

    return true;
}

/**
 * @param $query
 *
 * Поиск по комментариям
 */
function search($query)
{
    $stmt = getConn()->prepare("SELECT * FROM comments WHERE body LIKE ?");
    $stmt->execute([
        "%". $query. "%",
    ]);
    $result = $stmt->fetchAll();

    if(!$result)
        echo "<h3>Ничего не найдено<br></h3>";
    foreach ($result as $res)
    {
        $stmt = getConn()->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([
            $res["post_id"]
        ]);
        $r = $stmt->fetch();
        echo "<span style='font-weight:bold;'>". $r["title"] ."</span><br>";
        echo "<span style='margin-left:20px'>". $res["body"] ."</span><br><br>";
    }
}
