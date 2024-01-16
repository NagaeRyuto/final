<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta http-equiv="Cache-Control" content="no-cache">
		<meta charset="UTF-8">
		<title>BOX登録画面</title>
        <link rel="stylesheet" href="css/Register.css">
        <script src="./script/Register.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        <div class="wrapper">
            <section class="head">
                <h2>BOX登録</h2>
            </section>
            <form action = "BoxRegisterFinish.php" method = "post" enctype="multipart/form-data">
                <section class="body">
                    <div class="image">
                        <label>画像：</label>
                        <span id="imagePreviews" width=""></span>
                        <input type="button" id="loadFileXml" value="画像" class="imageButton" onclick="document.getElementById('fileInput').click();" />
                        <input type="file" style="display:none;" name="files[]" id="fileInput" multiple="multiple" onchange="previewImages()">
                    </div>
                        
                    
                    <div>
                        <label>BOX名：</label>
                        <input name="name" class="input-box" type="text" style="padding: 5px;" placeholder="商品名を入力してください" maxlength="30" required="required">
                    </div>
                    <div>
                        <label>型番：</label>
                        <input name="model" class="input-box" type="text" style="padding: 5px;" placeholder="型番を入力してください" maxlength="8" required="required">
                    </div>
                    <div>
                        <label>相場価格：</label>
                        <input type="price" class="input-box-number" style="padding: 5px;" required="required" name="price" maxlength="8" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g,'$1');"/>円
                    </div>
                    <div>
                    <label>レギュレーション：</label>
                        <select name="category" class="input-box-option" style="padding: 5px;" required="required">
                          <option selected value="">選んでください</option>
                          <?php
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
                            echo  '<option value="'.$CateId.'">'.$CateName.'</option>';
                        }
                          ?>
                        </select>
                    </div>
                </section>
                <section class="foot">
                    <button class="register" onclick="location.href='BoxList.php'" type="submit">戻る</button>
                    <button class="register" type="submit">登録</button>
                </section>
            </form>
        </div>
    </body>
</html>