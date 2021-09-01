<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.min.css">
    <link rel="stylesheet" href="css/main.css" >
    <title>工芸品ショップ</title>
</head>
<body>
<?php
    require_once("./lib/util.php");
    $user = 'root';
    $password = 'root';
    $db = 'php_shop';
    $host = 'localhost:3306';
    $port = 3306;
    $link = mysqli_init();
    $dsn ="mysql:host={$host};dbname={$db};charset=utf8";
    
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
        // goods query
        $sql = "SELECT goods_id,name,price,area_id,type_id,img_path FROM goods";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $goods = $stm->fetchAll(PDO::FETCH_ASSOC);
        $pdo = NULL;
    } catch (Exception $e) {
        //throw $th;
        echo '<span class="error">エラーがありました</span><br>';
        echo $e->getMessage();
        exit();
    }
    ?>
    <div class="root">
        <div class="page-wrapper">
            <header class="debug-color">
                <div>header</div>
            </header>
            <div class="main-visual ">
                <div class="main-image debug-color">メイン画像</div>
            </div>
            <div>
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
                                ?>
                            </div>
                    </div>
                    <div class="main-content">
                        <ul class="breadcrumb">
                            <li><a href="#">HOME</a></li>
                        </ul>
                        <h3 class="main-header">メインコンテンツ</h3>
                        <div class="main-container">
                            <?php
                            $i=0;
                            foreach($goods as $row){
                                echo "<div class=\"main-item \">";
                                echo "<a href=\"javascript:document.form",$i,".submit()\">";
                                echo "<form method=\"post\" name=\"form",$i,"\" action=\"productDetails.php\">";
                                echo "<input type=\"hidden\" name=\"details\" value=",es($row['goods_id']),">";
                                echo "<img src=\"",es($row['img_path']),"\" alt=\"\">";
                                echo "<p>",es($row['name']),"</p>";
                                echo "</form>";
                                echo "</a>";
                                echo "</div>";
                                $i++;
                            };
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="debug-color">footer</footer>
        </div>
    </div>
</div>
</body>
</html>
