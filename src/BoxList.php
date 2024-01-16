<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>所持BOX一覧</title>
    <link rel="stylesheet" href="css/List.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
</head>

<body>
    <?php
    require 'db-connect.php';
    $pdo = new PDO($connect, USER, PASS);

    echo '<main class="wrapper">';
    echo    '<section class="head">';
    echo        '<nav class="level">';
    echo            '<div class="level-left">';
    echo                '<h1>ポケカBOX所持一覧</h1>';
    echo            '</div>';
    echo            '<div class="level-right">';
    echo                '<form action="BoxList.php" method="post">';
    echo                    '<select name="category" class="input-box-option" style="padding: 10px;" required="required">';
    echo                        '<option value="0">全レギュレーション</option>';
                                $cate = [
                                    1 => 'A',
                                    2 => 'B',
                                    3 => 'C',
                                    4 => 'D',
                                    5 => 'E',
                                    6 => 'F',
                                    7 => 'G',
                                    8 => 'H',
                                ];
                                foreach ($cate as $CateId => $CateName) {
                                    $selected = (isset($_POST['category']) && $_POST['category'] == $CateId) ? 'selected' : '';
                                    echo  '<option value="' . $CateId . '" ' . $selected . '>' . $CateName . '</option>';
                                }
    echo                    '</select>';
    echo                    '<button class="btn" type="submit">検索</button>';
    echo                '</form>';
    echo            '</div>';
    echo        '</nav>';
    echo    '</section>';
    echo    '<section class="body">';
    
    $delete = "return confirm('削除しますか？')";
    echo '<table><thead><tr><th width="15%">BOX画像</th><th width="3%">BOXID</th><th  width="10%">BOX名</th><th  width="5%">型番</th><th  width="5%">相場価格</th><th  width="10%">レギュレーション</th><th  width="10%">操作項目</th></tr></thead>';
    echo '<tbody>';

    // カテゴリーの検索条件がある場合
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category'])) {
        $selectedCategory = $_POST['category'];
        if ($selectedCategory == 0) {
            // すべてのカテゴリーを表示する場合
            $stmt = $pdo->query('SELECT pokemon_box.*, regulation FROM pokemon_box INNER JOIN category ON pokemon_box.category_id = category.category_id ORDER BY box_id');
        } else {
            // 特定のカテゴリーを表示する場合
            $stmt = $pdo->prepare('SELECT pokemon_box.*, regulation FROM pokemon_box INNER JOIN category ON pokemon_box.category_id = category.category_id WHERE pokemon_box.category_id = :category ORDER BY box_id');
            $stmt->bindParam(':category', $selectedCategory, PDO::PARAM_INT);
            $stmt->execute();
        }
    } else {
        // カテゴリーの検索条件がない場合は全てのアイテムを表示
        $stmt = $pdo->query('SELECT pokemon_box.*, regulation FROM pokemon_box INNER JOIN category ON pokemon_box.category_id = category.category_id ORDER BY box_id');
    }

    foreach ($stmt as $row) {
        echo '<tr>';
        $category = $row['regulation'];
        $id = $row['box_name'];
        $path = "./img/{$category}";
        $path1 = "./img/{$category}/{$id}";
        if (!file_exists($path)) {
            mkdir("./img/{$category}", 0777);
        }
        if (!file_exists($path1)) {
            mkdir("./img/{$category}/{$id}", 0777);
        }

        echo '<td style="word-break: break-word">';
        $imageDirectory = 'img/' . $category . '/' . $id . '/';

        // 画像ファイルを取得
        $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        if (!empty($images)) {
            foreach ($images as $image) {
                $fileName = basename($image);
                echo '<a style="cursor:zoom-in;" href="' . $image . '" data-lightbox="group"><img src="' . $image . '" alt="' . $fileName . '" width="65" height="65"></a>';
            }
        } else {
            echo 'No images';
        }
        echo '</td>';
        echo '<td class="center"  style="word-break: break-word">' . $row['box_id'] . '</td>';
        echo '<td style="word-break: break-word">' . $row['box_name'] . '</td>';
        echo '<td style="word-break: break-word">' . $row['model'] . '</td>';
        echo '<td style="word-break: break-word"><strong>' . $row['price'] . '</strong></td>';
        echo '<td class="center" style="word-break: break-word">' . $row['regulation'] . '</td>';
        echo '<td class="center">';
        echo '<form action="BoxUpdate.php" method="post">';
        echo '<input type="hidden" name="id" value="' . $row['box_id'] . '">';
        echo '<button class="up" type ="submit">更新</button>';
        echo '</form>';
        echo '<form action="BoxDeleteFinish.php" method="post">';
        echo '<input type="hidden" name="delcategory" value="' . $row['regulation'] . '">';
        echo '<input type="hidden" name="delname" value="' . $row['box_name'] . '">';
        echo '<input type="hidden" name="delid" value="' . $row['box_id'] . '">';
        echo '<button onclick="' . $delete . '" class="del" type ="submit">削除</button>';
        echo '</form>';
        echo '</td></tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</section>';
    echo '<section class="foot">';
    echo '<form action="BoxRegister.php" method="post">';
    echo '<button class="register" type="submit">登録</button>';
    echo '</form>';
    echo '</section>';
    echo '</main>';
    ?>
</body>

</html>
