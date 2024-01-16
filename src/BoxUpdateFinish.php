<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOX更新完了画面</title>
    <link rel="stylesheet" href="css/Finish.css">
    <script src="./script/Register.js"></script>
</head>
<body>
    <?php
    require 'db-connect.php';
    ?>
    <main class="wrapper">
        <section class="body">
        <?php
                $categories = array(
                    1 => 'A',
                    2 => 'B',
                    3 => 'C',
                    4 => 'D',
                    5 => 'E',
                    6 => 'F',
                    7 => 'G',
                    8 => 'H'
                );
                $id=$_POST['id'];
                $key=$_POST['category'];
                $Okey=$_POST['OldCategory'];
                $category=$categories[$key];
                $Ocategory=$categories[$Okey];
                $name=$_POST['name'];
                $Oname=$_POST['OldName'];
                $OldPath="./img/{$Ocategory}";
                $OldPath1="./img/{$Ocategory}/{$Oname}";
                $path="./img/{$category}";
                $path1="./img/{$category}/{$name}";
                $imageDirectory = 'img/' . $category . '/'.$name.'/';
                $OldimageDirectory = 'img/' . $Ocategory . '/'.$Oname.'/';
                $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                $Oimages = glob($OldimageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                
                    
                    if(!file_exists($path)){
                        mkdir("./img/{$category}", 0777);
                    }
                    if(!file_exists($path1)){
                        mkdir("./img/{$category}/{$name}", 0777);
                    }
                $target_dir = $path1."/";

                // ファイルが複数アップロードされた場合の処理
                $numFiles = count($_FILES['files']['name']);
                
                for ($i = 0; $i < $numFiles; $i++) {
                    $currentFile = $_FILES['files']['tmp_name'][$i];
                    $currentTarget = $target_dir . basename($_FILES['files']['name'][$i]);

                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($currentTarget, PATHINFO_EXTENSION));

                    if (file_exists($currentTarget)) {
                        $uploadOk = 0;
                    }

                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $uploadOk = 0;
                    }

                    if ($uploadOk == 1) {
                        move_uploaded_file($currentFile, $currentTarget);
                    }
                }
                if($uploadOk == 1){
                    if(file_exists($OldPath1)){
                        foreach ($Oimages as $Oimage) {
                            unlink($Oimage);
                        }
                    }
                }else{
                        foreach ($Oimages as $i => $file) {
                            rename($file, $path1.'/'.pathinfo($file,PATHINFO_FILENAME).'.'.pathinfo($file,PATHINFO_EXTENSION));

                        }
                }
                echo '<label>更新に成功しました</label>';
                $pdo = new PDO($connect, USER, PASS);
                $sql=$pdo->prepare('update pokemon_box set box_name = ?,model = ?,price = ?,category_id = ? where box_id=?');
                $sql->execute([$_POST['name'],$_POST['model'],$_POST['price'],$_POST['category'],$id]);
                ?>
        </section>
        <section class="foot">
            <form action="BoxList.php" method="post">
                <button class="register" type="submit">Box一覧へ</button>
            </form>
        </section>
    </main>
</body>
</html>
