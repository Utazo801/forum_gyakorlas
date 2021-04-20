<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>MyForum</title>
    <style>
        .tartalom {
            display: flex;
            margin-top: 20px;

        }

        #focim {
            margin: auto;
            padding: 20px;
            background-color: lightcyan;
            border-bottom: 2px solid black;
        }

        #focim h1 {
            text-align: center;
        }

        #oldalsav {
            width: 10%;
            padding: 15px;

            background-color: lightgray;
        }

        #forum {
            width: 85%;
            margin-right: 15px;
            background-color: lightskyblue;
            padding: 10px;
        }

        #forum hr {
            height: 2px;
            border-width: 0px;
            color: gray;
            background-color: black;
        }

        #bevitel {
            border: 1px solid gray;
            width: 50%;
            margin: auto;
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

        .thread {
            border: 1px solid black;
            background-color: lightyellow;
            margin-bottom: 10px;
        }

        .thread a {
            text-decoration: none;
            color: black;
        }

        .thread h3,
        h4,
        h5,
        p {
            margin: 0;
            padding: 2px;
        }
    </style>
</head>

<body>
    <div id='focim'>
        <h1>My Forum</h1>
    </div>
    <div class='tartalom'>

        <div id='forum'>
            <?php
            session_start();
            require 'connect.php';
            $sql = "SELECT `user_id`, `user_name` 
                    FROM `users` ";
            $felhasznalok = $conn->query($sql);
            echo "<div id='bevitel'>
                    <form action='insert.php'  method='post'>
                        <label for='user_id'>Felhasználó:</label>
                        <select name='user_id' id='user_id'>";
            while ($sor = $felhasznalok->fetch_object()) {
                echo "<option value='" . $sor->user_id . "'>" . $sor->user_name . "</option>\n";
            }

            echo "</select>
                        </br>
                        <label for='thread_title'>Bejegyzés címe:</label>
                        <input type='text' name='thread_title' maxlength='140'>
                        <sub>max. 140 karakter</sub>

                        </br>
                        <label id='thread_text' for='thread_text'>Bejegyzés szövege:</label>
                        </br>

                        <textarea name='thread_text' id='thread_text' maxlength='280' cols='30' rows='10'></textarea>
                        <sub>max. 280 karakter</sub>

                        </br>
                        <label for='thread_date'>Bejegyzés címe:</label>
                        <input type='date' name='thread_date' max='140'>
                        </br>
                    <input type='submit' value='Poszt feltöltése'>
                    </form>
                 </div>
                 <hr>";

            //posztok lekérése
            $thread_sql = "SELECT `thread_id`, threads.user_id,users.user_name, `thread_date`, `thread_title`, 
                 `thread_text` 
             FROM `threads` INNER JOIN users 
             ON threads.user_id = users.user_id ";
            $thread = $conn->query($thread_sql);
            while ($thread_sor = $thread->fetch_object()) {
                echo "
                <div class='thread'>
                    <a href='thread.php?thread_id=" . $thread_sor->thread_id . "'>
                    <div id='thread_head'>
                        <h3>" . $thread_sor->thread_title . "</h3>
                        <h4>" . $thread_sor->user_name . "</h4>
                        <h5>" . $thread_sor->thread_date . "</h5>
                    </div>
                    <div id='thread_body'>
                        <p>" . $thread_sor->thread_text . "</p>
                    </div>
                    <div id=1thread_footer'>";
                $comment_count_sql = "SELECT COUNT(comment_id) 
                                  as comment_count 
                                  FROM comments 
                                  WHERE thread_id = ?";
                $stmt = $conn->prepare($comment_count_sql);
                $thread_id = $thread_sor->thread_id;

                $stmt->bind_param("d", $thread_id);
                $stmt->execute();
                $count = $stmt->get_result()->fetch_assoc();
                echo " <p><b>" . $count["comment_count"] . " comments</b></p>
                    </div>
                    </a>
                </div>
            ";
            }
            ?>

        </div>
        <div id='oldalsav'>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nulla aliquam dolore asperiores architecto cum quam, odio porro odit ut, ab fugit atque optio incidunt maxime iste quo dignissimos, eos quidem!</p>
        </div>
    </div>





</body>

</html>