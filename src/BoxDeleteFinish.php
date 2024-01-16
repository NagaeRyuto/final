<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOX削除画面</title>
    <link rel="stylesheet" href="css/Finish.css">
</head>
<body>
    <main class="wrapper">
        <section class="body">
        <?php
            require 'db-connect.php';
                $pdo=new PDO($connect, USER, PASS);
                $sql=$pdo->prepare("delete from pokemon_box where box_id=?");
                $sql->execute([$_POST['delid']]);
                echo '<label style="color:red;">所持ボックスを手放しました。</label>';
                $category=$_POST['delcategory'];
                $id=$_POST['delname'];
                $path1="./img/{$category}/{$id}";
                $imageDirectory = 'img/' . $category . '/'.$id.'/';
                $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                if(file_exists($path1)){
                    foreach ($images as $image) {
                       unlink($image);
                    }
                }
        ?>
        </section>
        <section class="foot">
            <form action="BoxList.php" method="post">
                <button class="register" type="submit">BOX一覧へ</button>
            </form>
        </section>
    </main>
</body>
</html>