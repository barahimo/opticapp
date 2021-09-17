<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    .search_wrap{
	width: 500px;
	margin: 38px auto;
}

.search_wrap .search_box{
	position: relative;
	width: 500px;
	height: 60px;
}

.search_wrap .search_box .input{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	padding: 10px 20px;
	border-radius: 3px;
	font-size: 18px;
}

.search_wrap .search_box .btn{
	position: absolute;
	top: 0;
	right: 0;
	width: 60px;
	height: 100%;
	background: #7690da;
	z-index: 1;
	cursor: pointer;
}

.search_wrap .search_box .btn:hover{
	background: #708bd2;	
}

.search_wrap .search_box .btn.btn_common .fas{
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%,-50%);
	color: #fff;
	font-size: 20px;
} 
  </style>
</head>
<body>
  




  <form action="{{route('commande.search')}}"  >
  

    <div class="container">
      <div class="search_wrap search_wrap_1">
        <div class="search_box">
          <input type="text" class="input" name="q"  placeholder="search...">
          <div class="btn btn_common">
            <button type="submit">
            <i class="fas fa-search"></i>
          </button>
          </div>
        </div>
    </div>
  
  </form>




</body>
</html>