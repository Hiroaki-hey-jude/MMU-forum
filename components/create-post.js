/***
  **********************************************************************************************
  ** 1. An image dropped in the text area is read 
        in by FileReader and previewed by generating an <img> 
        element inside a <div contenteditable="true">.
     2. When uploading, the <img> element is incorporated into the FormData and sent using
        XMLHttpRequest.send().
  **********************************************************************************************
****/
//Disable the browser default drag and drop functionality.
const area = document.getElementById('text-area');
area.addEventListener('dragover',function(event){
    event.preventDefault();
}, false);
area.addEventListener('drop',function(event){
event.preventDefault();
}, false);

//Behaviour when dragging into a div element.
const div = document.getElementById('create_post_textarea');
div.addEventListener('dragover', function(){
    //Behaviour when dragging away.
    div.addEventListener('dragleave',function(){
        div.style.border = '';
    }, false);
    div.style.border = '7px coral dashed';
    }, false);
    //Behaviour when dropped
    div.addEventListener('drop', function(event){
    //current cursor position
    let getSelect = window.getSelection();
    if (getSelect.anchorNode === null) {
        alert('Move the cursor over the text area');
        div.style.border = '';
        return;
    }
    event.preventDefault();
    div.style.border = '';
    //DataTransfer object, to retrieve a file list.
    let files = event.dataTransfer.files;
    if(files == null) { 
        return;
    }
    for(let i = 0; i < files.length;i++){
        //Retrieving files
        if (!files[i].type.match('image.*')) {
        alert('uploade the image');
        return;
        }
        let reader = new FileReader();
        //error handling
        reader.addEventListener('error', function (event){
        console.log('error' + event.target.error);
        }, false);
        //Processing after loading
        reader.addEventListener('load', function (event){
        let img = document.createElement('img');
        img.width = 400;
        img.src = event.target.result;
        let range = getSelect.getRangeAt(0);
        range.insertNode(img);
        }, false);
        reader.readAsDataURL(files[i]);
    }
}, false);

/***
  ***********************************************
  ** Behaviour when the submit button is pressed.
  ***********************************************
****/
let form = document.forms[0];

form.addEventListener('submit', function(event) {
    event.preventDefault();
    this.submit.disabled = true;
    let defaultValue = this.submit.value;
    this.submit.value = 'submitting';
    let div = document.getElementById('create_post_textarea');
    let div_tmp = document.createElement('div');
    div_tmp.innerHTML = div.innerHTML;
    // Array.prototype.slice.call() is used to eliminate the following of the retrieved element.
    let images = Array.prototype.slice.call(div_tmp.getElementsByTagName('img'));
    let form_data = new FormData(this);
    //The reason for adding images to the FormData while replacing the text strings 
    //in the text area is to facilitate server-side processing when the uploaded articles are later displayed.
    //  articleImage_1 => <img src="hogehoge1.jpg">
    //  articleImage_2 => <img src="hogehoge2.jpg"></img>
    for (let i = 0; i < images.length; i++) {
        let altImage = document.createTextNode("articleImage_" + i);
        images[i].parentNode.insertBefore(altImage,images[i]);
        images[i].parentNode.removeChild(images[i]);
        form_data.append('eyecatch[]',images[i].src);
    };
    let xhr = new XMLHttpRequest();
    form_data.append('body',div_tmp.innerHTML);
    //error handling
    xhr.addEventListener('error', function (e){
        console.log('error' + e.target.error.code);
    },false);
    xhr.addEventListener('load', function (e){
        if (this.status == 200) {
            let url = 'redirect/url';
        window.location.href = url;
        } else {
        form.submit.disabled = false;
        form.submit.value = defaultValue;
        console.log('input is wrong');
        }
    }, false);
    xhr.open("POST" , this.getAttribute('action'));
    xhr.send(form_data);
}, false);
