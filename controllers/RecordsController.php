<?php

require_once '../libs/RedBean/rb-mysql.php';
require_once 'dbConnect.php';

session_start();

$data = $_POST;
$name = $data['name'];
$reviews = $data['reviews'];
$_SESSION['insert_name'] = $name;
$_SESSION['insert_reviews'] = $reviews;
$errors = [];

if ($name == '') {
    $errors[] = 'Введите имя!';
}

if ($reviews == '') {
    $errors[] = 'Введите отзыв!';
}

if (empty($errors)) {

    $records = R::dispense('records');
    $records->name = $name;
    $records->reviews = $reviews;
    $records->date = date('Y-m-d H:i:s');
    R::store($records);

    $ok_addition = 'Запись успешно сохранена!';
    $_SESSION['success'] = $ok_addition;

} else {

    $error = array_shift($errors);
    $_SESSION['error'] = $error;

}

header('location: ../index.php');