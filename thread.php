<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: lightblue;
        }

        #backArrow {
            font-size: 50px;
            text-decoration: none;
            font-weight: bold;
        }

        #content {
            width: 66%;
            margin: auto;
        }

        #post {
            margin-top: 25px;
            padding: 25px;
            background-color: lightcyan;
        }

        #post h1,
        h3,
        h4 {
            margin: 0px;
            padding: 2px;
        }

        #post_body {
            padding: 25px;
        }

        #bevitel {
            border: 1px solid gray;
            width: 50%;
            margin: auto;
            margin-top: 25px;
            padding: 20px;
        }

        #bevitel input[type=text],
        input[type=date] {
            margin-left: 70px;
            margin-bottom: 5px;

        }

        #bevitel input[type=submit] {
            border-radius: 5px;
            font-weight: bold;
        }

        #bevitel select {
            margin-left: 95px;
            margin-bottom: 5px;

        }

        #bevitel textarea {
            margin-left: 180px;
            margin-bottom: 5px;

        }

        .comment {
            background-color: lightskyblue;
            margin-top: 5px;
            padding: 10px 25px 10px 25px;
        }
    </style>
    <?php
    session_start();
    require "connect.php";
    $sql = " SELECT Max(thread_id) FROM `threads`";
    $thread_count = $conn->query($sql);
    if (isset($_GET["thread_id"]) && $_GET["thread_id"] <= $thread_count) {
        $thread_id = $conn->real_escape_string($_GET["thread_id"]);
    } else {
        header("Location: index.php");
    }
    $thread_sql = "SELECT `thread_id`, threads.`user_id`,users.user_name, `thread_date`, `thread_title`, 
                  `thread_text` 
                   FROM `threads` 
                   Inner JOIN users 
                   On users.user_id = threads.user_id  
                   WHERE thread_id = ?";
    $stmt = $conn->prepare($thread_sql);
    $stmt->bind_param("d", $thread_id);
    if ($stmt->execute()) {
        $thread = $stmt->get_result()->fetch_assoc();
        echo "<title>" . $thread["thread_title"] . "</title>";
        echo "</head>";

        echo "<body>";

        echo "<a href='index.php' id='backArrow'>
        &#8592 </a>
        <div id='content'>
        <div id='post'>
            <h1>" . $thread["thread_title"] . "</h1>
            <h3>" . $thread["user_name"] . "</h3>
            <h4>" . $thread["thread_date"] . "</h4>

            <div id='post_body'>
                <p>" . $thread["thread_text"] . "</p>
            </div>
        </div>";


        $sql = "SELECT `user_id`, `user_name` 
                    FROM `users` ";
        $felhasznalok = $conn->query($sql);
        echo "<div id='bevitel'>
                    <form action='insert_comment.php'  method='post'>
                        <input type='hidden' name='thread_id' value='" . $thread_id . "';
                        <label for='user_id'>Felhasználó:</label>
                        <select name='user_id' id='user_id'>";
        while ($sor = $felhasznalok->fetch_object()) {
            echo "<option value='" . $sor->user_id . "'>" . $sor->user_name . "</option>\n";
        }

        echo "</select>
                        </br>
                        <label id='comment_text' for='comment_text'>Bejegyzés szövege:</label>
                        </br>

                        <textarea name='comment_text' id='comment_text' maxlength='280' cols='30' rows='10'></textarea>
                        <sub>max. 280 karakter</sub>
                        </br>
                    <input type='submit' value='Komment feltöltése'>
                    </form>
                 </div>
                 <hr>";

        //kommentek betöltése
        $comment_sql = "SELECT `comment_id`, comments.`user_id`,users.user_name, `thread_id`, `datum`, 
                    `comment_text` 
                    FROM `comments` 
                    Inner JOIN users 
                    On comments.user_id = users.user_id 
                    WHERE thread_id = " . $thread_id;
        $comment_result = $conn->query($comment_sql);
        while ($sor = $comment_result->fetch_object()) {
            echo "<div class='comment'>
            <div>
                <div>
                    " . $sor->user_name . " - " . $sor->datum . "
                </div>
                <p>" . $sor->comment_text . "</p>
            </div>
            </div>";
        }
        echo "
        </div>";

        echo "</body>";
    } else {
        echo "<h1>Nincs ilyen poszt<h1>";

        echo "<a href='index.php'>Vissza a főoldalra</a>";
    }
    ?>

</html>