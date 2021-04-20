<?php
require "connect.php";

$thread_id = $conn->real_escape_string($_POST["thread_id"]);
$user_id = $conn->real_escape_string($_POST["user_id"]);
$comment_text = $conn->real_escape_string($_POST["comment_text"]);


$sql = "INSERT INTO `comments`(`user_id`, `thread_id`,`comment_text`) VALUES (?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user_id, $thread_id, $comment_text);
$stmt->execute();

header("Location: thread.php?thread_id=" . $thread_id);
