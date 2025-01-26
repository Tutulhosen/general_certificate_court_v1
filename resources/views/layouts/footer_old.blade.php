<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style type="text/css">
    .fab-container{
position:fixed;
bottom:50px;
right:50px;
cursor:pointer;
}
.iconbutton{
width:50px;
height:50px;
border-radius: 100%;
background: #FF4F79;
box-shadow: 10px 10px 5px #aaaaaa;
}
.button{
width:60px;
height:60px;
background:#A11692;
}
.iconbutton i{
display:flex;
align-items:center;
justify-content:center;
height: 100%;
color:white;
}
</style>
<body>
<div>
    <ul class="options">
        <li>
            <span class="btn-label">telegram</span>
            <div class="iconbutton">
            <i class="fa-brands fa-telegram"></i>
            </div>
        </li>
        <li>
            <span class="btn-label">instagram</span>
            <div class="iconbutton">
            <i class="fa-brands fa-instagram"></i>
            </div>
        </li>
        <li>
            <span class="btn-label">twitter</span>
            <div class="iconbutton">
            <i class="fab fa-twitter"></i>
            </div>
        </li>
        <li>
            <span class="btn-label">facebook</span>
            <div class="iconbutton">
            <i class="fab fa-facebook"></i>
            </div>
        </li>
    </ul>
</div>
<div class="fab-container">
<div class="button iconbutton">
<i class="fa-solid fa-plus"></i>
</div>
</div>
</body>
</html>