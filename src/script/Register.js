
function previewImages() {
    const fileInput = document.getElementById('fileInput');
    const imagePreviews = document.getElementById('imagePreviews');
    console.log('fileInput:', fileInput);
    console.log('fileInput.files:', fileInput.files);
   
  
    for (let i = 0; i < fileInput.files.length; i++) {
        const reader = new FileReader();
        const img = document.createElement('img');
        const space = document.createTextNode(' '); // 半角スペースのテキストノードを作成
        const deleteButton = document.createElement('button');
        deleteButton.innerHTML = '×';
        deleteButton.className = 'delete-button';
        deleteButton.addEventListener('click', function() {
            // 削除ボタンがクリックされたときの処理
            imagePreviews.removeChild(imageContainer);
        });
       
        reader.onload = function (e) {
            img.src = e.target.result;
        };
       
        img.style.maxWidth = '100px';
        img.style.maxHeight = '100px';
        img.style.height='65px';
        img.style.width='65px';
        img.style.border= 'solid';
        img.style.borderRadius= '10px';
        deleteButton.style.height='25px';
        deleteButton.style.width='25px';
        deleteButton.style.background='red';
        deleteButton.style.color='#fff';
        deleteButton.style.border='solid red';
        deleteButton.style.borderRadius='5px';
  
  
        reader.readAsDataURL(fileInput.files[i]);
  
        const imageContainer = document.createElement('span');
        imageContainer.className = 'image-container';
        imageContainer.appendChild(img);
        imageContainer.appendChild(deleteButton);
        imagePreviews.appendChild(imageContainer);
        imageContainer.appendChild(space);
    }
  }