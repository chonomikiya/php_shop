<?php
session_start();
require_once("./lib/util.php");
$gobackURL = "index.php";
$mydata = $_POST;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/cart.css">

    <title>Document</title>
</head>
<body>
<div class="root">
<div class="page-wrapper">
    <header class="debug-color">header</header>
    <div class="container">
            <ul class="breadcrumb">
                <li><a href="#">HOME</a></li>
                <li><a href="#">CART</a></li>
            </ul>
            <h3 class="main-header">カート内の確認</h3>
            <div class="cart-wrap">
                <cart-img><img src="" alt=""></cart-img>
                <cart-name><h2>商品名ほげほげ</h2></cart-name>
                <cart-category><p>商品カテゴリ：hogehoge</p></cart-category>
                <cart-num>数量
                    <select name="cart_num" id="">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </cart-num>
                <cart-price><h2>&yen;12,345</h2></cart-price>
            </div>
            <!-- _
       .__(.)< (MEOW)
        \___)   
 ~~~~~~~~~~~~~~~~~~ 
            -->
            <div class="sum">
                <h2>&yen;12,345</h2>
            </div>
            <div class="go-order">
                <input type="button" value="購入画面へ進む" >
            </div>
    </div>
    <footer class="debug-color">footer</footer>
</div>
</div>    
</body>
</html>