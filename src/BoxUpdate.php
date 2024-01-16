<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta http-equiv="Cache-Control" content="no-cache">
		<meta charset="UTF-8">
		<title>Box更新画面</title>
        <link rel="stylesheet" href="css/Register.css">
        <script src="./script/Update.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function goBack() {
                location.href='BoxList.php';
            }
        </script>
	</head>
	<body>
    <?php
    require 'db-connect.php';
    ?>
        <div class="wrapper">
            <section class="head">
                <h2>BOX更新</h2>
            </section>
            <?php
                $l = "location.href='BoxList.php'";
                $file = "fileInput";
                $s = "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g,'$1');";
                $pdo=new PDO($connect, USER, PASS);
                $sql=$pdo->prepare('select pokemon_box. * , regulation from pokemon_box inner join category on pokemon_box.category_id = category.category_id where box_id=?');
	            $sql->execute([$_POST['id']]);
                foreach($sql as $row){
                    echo '<form action = "BoxUpdateFinish.php" method = "post" enctype="multipart/form-data">';
                    echo     '<input type="hidden" name="id" value="'.$row['box_id'].'">';
                    echo     '<input type="hidden" name="OldCategory" value="'.$row['category_id'].'">';
                    echo     '<input type="hidden" name="OldName" value="'.$row['box_name'].'">';
                    echo     '<section class="body">';
                    echo         '<div class="image">';
                    echo             '<label>画像：</label>';
                    $category=$row['regulation'];
                    $id=$row['box_name'];
                    $imageDirectory = 'img/' . $category . '/'.$id.'/';
                    $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                    if (!empty($images)) {
                        foreach ($images as $image) {
                            $fileName = basename($image);
                        echo '<img src="' . $image . '" class="UpdatedImages" alt="' . $fileName . '" width="65" height="65">';
                        }
                    }else{
                        echo 'No images';
                    }
                    echo             '<label style="margin-left: 20px;">新しい画像：</label>';
                    echo             '<span id="imagePreviews" width=""></span>';
                    echo             '<input type="button" id="loadFileXml" value="画像" class="imageButton" onclick="document.getElementById(\'' . $file . '\').click();" />';
                    echo             '<input type="file" style="display:none;" name="files[]" id="fileInput" multiple="multiple" onchange="previewImages()">';
                    echo         '</div>';
                    echo         '<div>';
                    echo             '<label>BOX名：</label><input name="name" class="input-box" type="text" style="padding: 5px;" placeholder="BOX名を入力してください" maxlength="30" value="'.$row['box_name'].'" required="required">';
                    echo         '</div>';
                    echo          '<div>';
                    echo              '<label>型番：</label><input name="model" class="input-box" type="text" style="padding: 5px;" placeholder="型番を入力してください" maxlength="8" value="'.$row['model'].'" required="required">';
                    echo          '</div>';
                    echo         '<div>';
                    echo             '<label>相場価格：</label><input type="text" class="input-box-number" style="padding: 5px;"  required="required" name="price" maxlength="8" oninput="'.$s.'" value="'.$row['price'].'"/>円';
                    echo         '</div>';
                    echo         '<div>';
                    echo         '<label>レギュレーション：</label>';
                    echo             '<select name="category" class="input-box-option" style="padding: 5px;">';
                    echo               '<option value="'.$row['category_id'].'" selected>'.$row['regulation'].'</option>';
                                        $cate =[
                                            1 => 'A',
                                            2 => 'B',
                                            3 => 'C',
                                            4 => 'D',
                                            5 => 'E',
                                            6 => 'F',
                                            7 => 'G',
                                            8 => 'H'
                                        ];
                                        foreach($cate as $CateId => $CateName){
                    echo               '<option value="'.$CateId.'">'.$CateName.'</option>';
                                        }
                    echo             '</select>';
                    echo         '</div>';
                    echo     '</section>';
                    echo     '<section class="foot">';
                    echo         '<input type="button" value="戻る" class="register" onclick="'.$l.'">';
                    echo         '<button class="register" type="submit">更新</button>';
                    echo     '</section>';
                    echo '</form>';
                }
            ?>
        </div>
    </body>
</html>
