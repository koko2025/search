<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>検索</title>
</head>
<body>
    <img src="img/icon.png" width="130" height="120">
    <h1>マンガ検索</h1>
        <div id="a1">
            <form action="result.php" method="post">
            <div id = "text">検索方法</div>
            <div id = "r1"><input type="radio" name='type' value=0 checked style="transform:scale(1.5);"> 全件</div>
            <div id="r2"><input type="radio" name='type' value=1 style="transform:scale(1.5);"> 指定</div>
        </div>
        <div id="a2">
            <dl>
                <dt>作品名</dt>
                <dd><input type="text" name="title" height="20px"></dd>
                <dt>ジャンル</dt>
                <dd>
                    <select name="category">
                    <?php
                        $Category = [
                            0 => '選択してください',
                            1 => '少年マンガ・コミック',
                            2 => '青年マンガ・コミック',
                            3 => '少女マンガ・コミック',
                            4 => '女性マンガ・コミック'
                        ];
                
                        foreach($Category as $key=>$value){
                            echo '<option value=',$value,'>',$value,'</option>';
                        }
                    ?>
                    </select>
                </dd>
                <dt>価格</dt>
                <dd><input type="number" name="price1" height="20px">円～<input type="number" name="price2" height="20px">円</dd>
            </dl>
                <button type="submit" class="btn">検索</button>
        </div>
</body>
</html>