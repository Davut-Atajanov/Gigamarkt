<?php
session_start();
require "db.php";


if (validSessionMarkt()) {
    header("Location: markt.php");
    exit;
}

// check if the user authenticated before
if (!validSessionCons()) {
    header("Location: loginCons.php");
    exit;
}


$userData = $_SESSION["ConsUser"];

if (!empty($_POST))
    extract($_POST);

if (isset($change)) {

    if (getUserCons($email) and !(getUserCons($email)["email"] == $userData["email"]))
        $error = true;
    else {
        $stmt = $db->prepare('update consumer_user set email = ?, fullname = ?, city = ?, district = ?, address = ?, token = ? where email = ?');
        $stmt->execute([$email, $name, $city, $dis, $address, 1, $userData["email"]]);
        $_SESSION["ConsUser"] = getUserCons($email);
        $userData = $_SESSION["ConsUser"];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <title>cons</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Oxygen&family=Righteous&display=swap');

    #head {
        width: 100%;
        background-color: orangered;
        color: white;
        padding: 10px 10px;
        background-color: #444;
        display: flex;
    }

    body {
        margin: 0px 0px;
        background-image: url(BackgroundP.png);
        font-family: 'Oxygen', sans-serif;
    }

    h2 {
        color: white;
    }

    #head h1 {
        margin: 0px 0px;
        font-family: 'Righteous', cursive;
        font-size: 50px;
    }

    #fill {
        width: 20%;
    }

    span {
        font-size: 20px;
        color: lightskyblue;
    }

    #head #select {
        width: 39%;
        padding: 0px;
        font-family: 'Oxygen', sans-serif;
        text-align: center;
        height: 20px;
        padding-top: 20px;
    }

    #head #select td {
        padding: 0px;
        border-radius: 15px;
        cursor: pointer;
        width: 50px;
    }

    div #out {
        width: 10%;
    }

    h2 {
        text-align: center;
    }

    #menu #list {
        background-color: lightskyblue;
        color: black;
    }

    #profileData {
        display: hidden;
    }

    #main {
        background-color: #444;
        color: white;
        border-radius: 15px;
    }

    #main td {
        padding: 10px;
    }

    #products {
        display: flex;
    }

    #oot {
        display: flex;
        color: white;
    }

    #oot a {
        color: white;
        text-decoration: none;
    }

    #inleft {
        width: 40%;
    }

    #in {
        background-color: #444;
        color: white;
        width: 20%;
        border-radius: 15px;
    }

    #welcome {
        color: white;
        margin-left: 10px;
    }

    #list {
        background-color: white;
        color: black;
    }

    h3 {
        text-align: center;
    }

    #item {
        background-color: white;
        border-radius: 10px;
        padding: 5px;
        align-items: center;
    }

    #cnt {
        align-items: center;
        text-align: center;
    }

    #thru {
        color: black;
        text-decoration: line-through;
    }

    #Lside {
        width: 10%;
    }
    </style>
</head>

<body>
    <div id="head">
        <h1>GigaMarkt.com <span>Customer</span> </h1>
        <div id="fill"></div>
        <table id="select">
            <tr>
                <td id="list">Browse Items</td>
                <td id="add">Shopping Cart</td>
                <td id="prof">My Profile</td>
                <td id="out">Log Out</td>
            </tr>
        </table>
    </div>
    <h1 id="welcome">Welcome <?= $userData["fullname"] ?></h1>

    <div id="body"><?php echo "<h2>List of Items</h2>"; ?></div>

    <?php if (isset($error)) : ?>
    <div id="warning">
        <h1 style="color:red;">
            EMAIL ALREADY EXISTS
        </h1>
    </div>
    <?php endif; ?>

    


    <div id="products">
        <div id="Lside"></div>
        <?php

        // $products = ;
        $products_list = getAllProducts($userData["email"]);
        $expirted_products_list = getAllExpiredProducts($userData["email"]);

        // var_dump(($products_list));
        // var_dump(($expirted_products_list));

        $newRow = 0;
        echo '<div><table id = "products_table">';
        foreach ($products_list as $list) {
            // var_dump($newRow);
            if ($newRow % 3 === 0)
                echo '<tr>';
            if ($list["normal_price"] != 0)
                $discount = round(100 - $list["discounted_price"] * 100 / $list["normal_price"], 2);
            else
                $discount = 0;
            echo '<td>';
            /*echo "<div id='tit' style='display : inline-block;'> {$list['title']} </div>";
            echo "<div id='disc' style='display : inline-block;'>Discount {$discount}%</div>";
            echo "<div id='imag' class = 'img_div'><img src='../images/{$list['img_name']}' alt='' width = '200px' height = '200px'></div>";
            echo "<div id='prc' style='display : inline-block; text-decoration-line: line-through;'>{$list['normal_price']}&#8378;</div>";
            echo "<div id='disprc' style='display : inline-block;'> {$list['discounted_price']}&#8378; </div>";
            echo "<br>";
            echo "<div style='display : inline-block;'>Expiry Date: {$list['exp_date']} </div>";
            echo "<button type='button'>+</button>";
            echo "<button type='button'>-</button>";*/
            echo "<div id='item'>
                <h3>{$list['title']}</h3>
                <h3 id='disc'>{$discount} %</h3>
                <div id='cnt'><img id='imag' src='../images/{$list['img_name']}' alt='' width = '150px' height = '150px'></div>
                <h3><span id='thru'>{$list['normal_price']}&#8378;</span> {$list['discounted_price']}&#8378; </h3>
                <h3 id='exp'>Expires on {$list['exp_date']}</h3>
                <a href='?add= {$list['img_name']}' >Add</a>
        <div>";
            echo '</td>';

            if ($newRow % 3 === 2)
                echo '</tr>';
            $newRow++;
        }

        if ($newRow % 3 === 2)
            echo '</tr>';
        $newRow++;

        echo '</table>
        </div>';
        ?>

        <div id="Rside"></div>
    </div>

    <div id="profileData">
        <form action="?" method="post">
            <table id="main" style="margin:10px auto;">
                <tr>
                    <td>E-mail:</td>
                    <td><input type="text" name="email" value="<?= isset($email) ?  $email : '' ?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>Name: </td>
                    <td><input type="text" name="name" value="<?= isset($name) ?  $name : '' ?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>City: </td>
                    <td><input type="text" name="city" value="<?= isset($city) ?  $city : '' ?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>District: </td>
                    <td><input type="text" name="dis" value="<?= isset($dis) ?  $dis : '' ?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td><input type="text" name="address" value="<?= isset($address) ?  $address : '' ?>"></input></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button>Update Profile</button>
                    </td>
                </tr>
                <input type="hidden" name="change" value="1" />
            </table>
        </form>
    </div>

    <script>
    //$(function() {

    /*        $("#select td").click(function() {
                $("#select td").css("background-color", "#444");
                $("#select td").css("color", "white");
                $(this).css("background-color", "white");
                $(this).css("color", "black");
                var x = $(this).attr('id');
                switch (x) {
                    case 'list':

                        $("#body").html("<?php // echo "<h2>List of Items</h2>";$showProfile = false; 
                                            ?>");
                        $("#profileData").css("display", "none");
                        $("#warning").css("display", "none");
                        $("#products").css("display", "block");
                        break;
                    case 'cart':

                        $("#body").html("<?php // echo "<h2>Shopping Cart</h2>";$showProfile = false; 
                                            ?>");
                        $("#profileData").css("display", "none");
                        $("#warning").css("display", "none");
                        $("#products").css("display", "none");
                        break;
                    case 'prof':


                        $("#body").html(<?php // echo "<h2>My Profile</h2>"; 
                                        ?>);
                        $("#profileData").css("display", "block");
                        $("#warning").css("display", "block");
                        $("#products").css("display", "none");

                        break;
                    case 'out':

                        $("#body").html(<?php //echo "<a href='logout.php'><h2>Exit</h2></a>";
                                        //$showProfile = false;
                                        // echo "<h2>Do You want to log out?</h2><br><div id='oot'><div id='inleft'></div><div id='in'><a href='logout.php'><h2>Yes</h2></a><a href='cons.php'><br><h2>No</h2></a></div>"; 
                                        ?> ?>);
                        $("#profileData").css("display", "none");
                        $("#warning").css("display", "none");
                        $("#products").css("display", "none");
                        break;
                }
            })
        })*/
    $(function() {
        $("#profileData").css("display", "none");
        $("#select td").click(function() {
            $("#select td").css("background-color", "#444");
            $("#select td").css("color", "white");
            $(this).css("background-color", "white");
            $(this).css("color", "black");
            var x = $(this).attr('id');
            switch (x) {
                case 'list':
                    $("#body").html("<h2>Products</h2>");
                    $("#profileData").css("display", "none");
                    $("#warning").css("display", "none");
                    $("#addP").css("display", "none");
                    $("#fillAll").css("display", "none");
                    $("#wrongFormat").css("display", "none");
                    $("#products").css("display", "flex");
                    $("#welcome").css("display", "none");
                    break;
                case 'add':
                    $("#body").html("<?php echo "<h2>Shopping Cart</h2>"; ?>");
                    $("#profileData").css("display", "none");
                    $("#warning").css("display", "none");
                    $("#addP").css("display", "block");
                    $("#fillAll").css("display", "none");
                    $("#wrongFormat").css("display", "none");
                    $("#products").css("display", "none");
                    $("#welcome").css("display", "none");
                    break;
                case 'prof':
                    $("#body").html("<?php echo "<h2>Edit Profile</h2>"; ?>");
                    $("#profileData").css("display", "block");
                    $("#warning").css("display", "none");
                    $("#addP").css("display", "none");
                    $("#fillAll").css("display", "none");
                    $("#wrongFormat").css("display", "none");
                    $("#products").css("display", "none");
                    $("#welcome").css("display", "none");
                    break;
                case 'out':
                    $("#body").html(
                        "<?php echo "<h2>Do You want to log out?</h2><br><div id='oot'><div id='inleft'></div><div id='in'><a href='logout.php'><h2>Yes</h2></a><a href='markt.php'><br><h2>No</h2></a></div>"; ?>"
                    );
                    $("#profileData").css("display", "none");
                    $("#warning").css("display", "none");
                    $("#addP").css("display", "none");
                    $("#fillAll").css("display", "none");
                    $("#wrongFormat").css("display", "none");
                    $("#products").css("display", "none");
                    $("#welcome").css("display", "none");
                    break;
            }
        })
    })
    </script>
</body>