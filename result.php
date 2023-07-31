<?php
    const SERVER = 'mysql215.phy.lolipop.lan';
    const DBNAME = 'LAA1517810-shop';
    const USER = 'LAA1517810';
    const PASS = 'Pass0630';
    $connect = 'mysql:host='.SERVER.';dbname='.DBNAME.';charset=utf8';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>検索結果</title>
</head>
<body>
    <img src="img/icon.png" width="130" height="120">
    <h1>検索結果</h1>
    <div>
        <?php
            $Category = [
                0 => '選択してください',
                1 => '少年マンガ・コミック',
                2 => '青年マンガ・コミック',
                3 => '少女マンガ・コミック',
                4 => '女性マンガ・コミック'
            ];
            $pdo = new PDO($connect,USER,PASS);
            $error = "";
            if($_POST['type'] == 0){
                $str = 'select * from Shohin';
                $sql = $pdo->query($str);
                // $sql->execute([$_POST['price1'],$_POST['price2']]);
            }else{
                $str = 'select * from Shohin where ';
                $cnt = 0;
                $keyArray = array();

                if(strlen($_POST['title'])>0){//作品名が入力されているときの処理
                    $str = $str.'name like ? ';
                    $keyArray[$cnt] = '%'.$_POST['title'].'%';
                    $cnt += 1;
                }
                if($_POST['category']=='選択してください'){ //ジャンルが選択されていない
                    
                }else{//ジャンルが選択されている
                    if(strlen($_POST['title'])>=1){//作品名が入力されている
                        $str = $str . 'and category = ? ';
                    }else{//作品名が入力されていない
                        $str = $str . 'category = ? ';
                    } 
                    $keyArray[$cnt] = $_POST['category'];
                    $cnt += 1;
                }
                if(strlen($_POST['price1'])>0 || strlen($_POST['price2'])>0){//金額が入力されているときの処理
                    if(strlen($_POST['title'])>0){//商品名が入力されている
                        $str = $str . 'and price between ? and ?';
                    }else{//商品名が入力されていないとき
                        if($_POST['category']=='選択してください'){//金額のみ
                            $str = $str . 'price between ? and ?';
                        }else{//ジャンルと金額
                            $str = $str . 'and price between ? and ?';
                        }
                    }
                    for($i = 1; $i<=2; $i++){
                        // var_dump($i);
                        $keyArray[$cnt] = $_POST['price'.$i];
                        $cnt += 1;
                    }
                }
                if($cnt == 0){
                    $error = "条件が指定されていません";
                }else{
                    $sql = $pdo->prepare($str);
                    $sql->execute($keyArray);
                }
            }
            if($error == "" && $sql->rowCount()>0){
                echo '<table>';
                    echo '<tr>
                        <th>作品ID</th>
                        <th>作品名</th>
                        <th>ジャンル</th>
                        <th>価格</th>
                    </tr>';
                foreach($sql as $row){
                    echo '<tr><td>',$row['id'],'</td>';
                    echo '<td>',$row['name'],'</td>';
                    echo '<td>',$row['category'],'</td>';
                    echo '<td>',$row['price'],'</td></tr>';
                    echo "\n";
                }
                echo '</table>';
            }else if($error != ""){
                echo '<p>',$error,'<p>';
            }else{
                echo '<p>条件に合うデータが1件もありませんでした。</p>';
                echo '<p>指定した条件</p>';
                echo '<p>商品名：',$_POST['title'],'　ジャンル：',$_POST['category'],'　金額：';
                if(strlen($_POST['price1'])>0 && strlen($_POST['price2'])>0){
                    echo $_POST['price1'],'円～',$_POST['price2'],'円','</p>';
                }else{
                    echo '0円～0円</p>';
                }
            }
        ?>
        
    <p><a href="search.php"><button type="button" class="btn">戻る</button></a></p>
    </div>
</body>
</html>