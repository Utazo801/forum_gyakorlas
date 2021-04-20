<?php
require "connect.php";

$user_id = $conn->real_escape_string($_POST["user_id"]);
$thread_date = $conn->real_escape_string($_POST["thread_date"]);
$thread_title = $conn->real_escape_string($_POST["thread_title"]);
$thread_text = $conn->real_escape_string($_POST["thread_text"]);


$sql = "INSERT INTO `threads`(`user_id`, `thread_date`, `thread_title`, `thread_text`) 
        VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("dsss", $user_id, $thread_date, $thread_title, $thread_text);
$stmt->execute();

header("Location: index.php");
