<?php
require_once('db.php');
require_once('config.php');
$db = new DB();
$db = $db->getDB();
mysqli_query($db, "SET NAMES utf8");
if (isset($_POST['id'])) {
    $id_package = $_POST['id'];
    $page = $_POST['page'];
    //lấy về câu hỏi
    $query = 'select * from 
	questions where id_package =' . $id_package . ' order by id asc limit ' . $page . ',1' or die('Error');
    $questions = mysqli_query($db, $query);
    $questions = $questions->fetch_assoc();
    //var_dump($questions);

    //lấy về câu trả lời
    $query = 'select * from answers where id_question =' . $questions['id'];
    $answers = mysqli_query($db, $query);
    $answers_array = [];
    while ($row = mysqli_fetch_assoc($answers)) {
        $answer = array(
            'id' => $row['id'],
            'content' => $row['content'],
            'is_correct' => $row['is_correct']
        );
        //$answers_array[] = $answer;
        array_push($answers_array, $answer);
    }

    //var_dump($answers_array);

    $result = [
        'question' => $questions,
        'answers' => $answers_array
    ];

    //var_dump($result);

    header('Content-Type: application/json');
    echo json_encode($result);
}
