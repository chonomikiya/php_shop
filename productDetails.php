<?php
session_start();
require_once("./lib/util.php");
$gobackURL = "index.php";
$mydata = $_POST;

if(!cken($_POST)){
    header("Location:{$gobackURL}");
    exit();
}
if(empty($_POST)){
    header("Location:{$gobackURL}");
    exit();
};

$user = 'root';
$password = 'root';
$db = 'php_shop';
$host = 'localhost:3306';
$port = 3306;
$link = mysqli_init();
$dsn ="mysql:host={$host};dbname={$db};charset=utf8";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/details.css">
    <title>Document</title>
</head>
<?php
    // Acsses
    try {
        //code...
        $pdo = new PDO($dsn,$user,$password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        //例外処理
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // type_list query
        $sql = "SELECT type_id,type FROM type_list";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $type_result = $stm->fetchAll(PDO::FETCH_ASSOC);
        // area_list query
        $sql = "SELECT area_id,area FROM area_list";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $area_result = $stm->fetchAll(PDO::FETCH_ASSOC);
        //details query
        $sql = "SELECT goods_id,name,price,area_id,type_id,img_path FROM goods WHERE goods_id = \"{$mydata["details"]}\"";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $goods_result = $stm->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT type_id,type FROM type_list WHERE type_id = \"{$goods_result["type_id"]}\"";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $goods_result["type"] = $stm->fetch(PDO::FETCH_OBJ)->type;

        $sql = "SELECT area_id,area FROM area_list WHERE area_id = \"{$goods_result["area_id"]}\"";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $goods_result["area"] = $stm->fetch(PDO::FETCH_OBJ)->area;

        $sql = "SELECT goods_id,stock FROM inventory WHERE goods_id = \"{$mydata["details"]}\"";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $goods_result["stock"] = $stm->fetch(PDO::FETCH_OBJ)->stock;
        $pdo = NULL;
    } catch (Exception $e) {
        //throw $th;
        echo '<span class="error">エラーがありました</span><br>';
        echo $e->getMessage();
        exit();
    }
    ?>
<body>
<div class="root">
<div class="page-wrapper">
    <header class="debug-color">header</header>
    <div class="container">
                        <div class="sidebar">
                            <form method="POST" action="search.php" >
                                <div class="side-child search-form debug-color">

                                        <input type="text" name="name_data" placeholder="商品の検索">
                                        <input type="submit" value="検索">
                                </div>
                            </form>

                                <div class="side-child side-border">
                                    <h3 class="side-list-title">絞り込み</h3>
                                    <?php
                                    // echo "<ul>";
                                    echo "<form method=\"post\" name=\"type_data\" action=\"search.php\">";
                                    foreach($type_result as $row){
                                        echo "<div class=\"row\"><a href=\"javascript:document.type_data.submit()\">";
                                        echo "<input type=\"radio\" name=\"type_data\" value=",es($row['type_id']),">";
                                        echo es($row['type']);
                                        echo "</input>";
                                        echo "</a></div>";
                                    };
                                    echo "</form>";
                                    // echo "</ul>";
                                    ?>

                                </div>
                                <div class="side-child side-border">
                                    <h3 class="side-list-title">産地</h3>
                                    <?php
                                    echo "<form method=\"post\" name=\"area_data\" action=\"search.php\">";
                                    foreach($area_result as $row){
                                        echo "<div class=\"row\"><a href=\"javascript:document.area_data.submit()\">";
                                        echo "<input type=\"radio\" name=\"area_data\" value=",es($row['area_id']),">";
                                        echo es($row['area']);
                                        echo "</input>";
                                        echo "</a></div>";
                                    };
                                    echo "</form>";

                                    // echo "</ul>";
                                    ?>
                                </div>
                        </div>
        <div class="main-content">
            <ul class="breadcrumb">
                <li><a href="#">HOME</a></li>
                <li>DETAILS</li>
            </ul>
            <h3 class="main-header">商品詳細</h3>
            <div class="product-details">
                <div class="details-container">
                    <?php
                        echo "<product-img><img src=\"",es($goods_result['img_path']),"\" alt=\"\"></product-img>";
                        echo "<namehead>商品名</namehead>";
                        echo "<namebody>",es($goods_result['name']),"</namebody>";
                        echo "<categoryh>商品名</categoryh>";
                        echo "<categoryb>",es($goods_result['type']),"</categoryb>";
                        echo "<areahead>焼き物産地</areahead>";
                        echo "<areabody>",es($goods_result['area']),"</areabody>";
                        echo "<product-price>",es($goods_result['price']),"</product-price>";
                        echo "<form action=\"cart.php\" method=\"post\">";
                        echo "<add-cart><input type=\"submit\" value=\"カートに入れる\"></add-cart>";
                        echo "<see-the-cart><input type=\"button\" value=\"購入画面に移る\"></see-the-cart>";
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
    <footer class="debug-color">footer</footer>
</div>
</div>    
</body>
</html>