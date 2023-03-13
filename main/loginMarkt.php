<?php

session_start();
require "db.php";


if (validSessionCons()) {

    header("Location: cons.php");
    exit;
}




// auto login (homework)
if (validSessionMarkt()) {
    $db->query("update market_user set Auth_Code = 1 where email=$email");
    header("Location: markt.php");
    exit;
}




?>

<?php
if (!empty($_POST)) {
    extract($_POST);


    if (checkUserMarkt($email, $pass)) {


        $_SESSION["MarktUser"] = getUserMarkt($email);
        $userData = $_SESSION["MarktUser"];

        if ($userData["Flag"] == false) {
            header("Location: mail.php?email=$email");
        } else {

            header("Location: markt.php?email=$email");
        }

        exit;
    }
    echo "<script>alert('Wrong email or password')</script>";
}
?>

<!--<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Market Login</h1>
    <form action="?" method="post">
        Email : <input type="text" name="email">
        <br><br>
        Password : <input type="password" name="pass">
        <br><br>
        <button type="submit">Enter</button>
    </form>

</body>

</html>-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\stylenew.css">
    <title>Login Market</title>
    <style>
    .bounce-in-bck {
        -webkit-animation: bounce-in-bck 1.1s both;
        animation: bounce-in-bck 1.1s both
    }

    /* ----------------------------------------------
 * Generated by Animista on 2022-5-15 17:28:36
 * Licensed under FreeBSD License.
 * See http://animista.net/license for more info. 
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

    @-webkit-keyframes bounce-in-bck {
        0% {
            -webkit-transform: scale(7);
            transform: scale(7);
            -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in;
            opacity: 0
        }

        38% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out;
            opacity: 1
        }

        55% {
            -webkit-transform: scale(1.5);
            transform: scale(1.5);
            -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in
        }

        72% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out
        }

        81% {
            -webkit-transform: scale(1.24);
            transform: scale(1.24);
            -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in
        }

        89% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out
        }

        95% {
            -webkit-transform: scale(1.04);
            transform: scale(1.04);
            -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in
        }

        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out
        }
    }

    @keyframes bounce-in-bck {
        0% {
            -webkit-transform: scale(7);
            transform: scale(7);
            -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in;
            opacity: 0
        }

        38% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out;
            opacity: 1
        }

        55% {
            -webkit-transform: scale(1.5);
            transform: scale(1.5);
            -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in
        }

        72% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out
        }

        81% {
            -webkit-transform: scale(1.24);
            transform: scale(1.24);
            -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in
        }

        89% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out
        }

        95% {
            -webkit-transform: scale(1.04);
            transform: scale(1.04);
            -webkit-animation-timing-function: ease-in;
            animation-timing-function: ease-in
        }

        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-animation-timing-function: ease-out;
            animation-timing-function: ease-out
        }
    }

    #head {
        width: 100%;
        background-color: orangered;
        color: white;
        padding: 10px 10px;
    }

    body {
        margin: 0px 0px;
    }

    #head h1 {
        margin: 0px 0px;
        font-family: 'Righteous', cursive;
        font-size: 50px;
    }

    span {
        font-size: 20px;
        color: lightgreen;
    }

    #main {
        font-size: 20px;
        font-family: 'Oxygen', sans-serif;
        margin: 30vh auto;
        margin-bottom: 10vh;
        border: 1px solid black;
        border-radius: 7px;
        background-color: #444;
        color: white;
    }

    #main td {
        padding: 10px 10px;
    }

    input {
        border-radius: 7px;
    }

    button {
        background-color: #444;
        color: white;
        border-radius: 7px;

    }

    #back {
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header_section_top">
            <div class="row">
                <div class="col-sm-12">
                    <div class="custom_menu">
                        <h1 class="fashion_taital" style=" font-family: 'Roboto', sans-serif;">GigaMarkt&trade;</h1>
                        <h3 class="fashion_taital" style="font-size:large; font-family: 'Roboto', sans-serif;">Market
                            User</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="?" method="post" class="bounce-in-bck">
        <table id="main">
            <tr>
                <td>E-mail:</td>
                <td><input type="text" name="email" value="<?= isset($email) ?  $email : '' ?>"></input></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="pass" value="<?= isset($pass) ?  $pass : '' ?>"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><button type="submit">Login</button></a></td>
            </tr>
            <tr>

            </tr>
        </table>
    </form>
    <div id="back"><a href="index.php">Go Back</a></div>

</body>

</html>