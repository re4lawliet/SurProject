<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ORDEN DE COMPRA</title>
   <style>

   .titulo {
    color: #1e80b6;
    padding-top: 20px;
    padding-bottom: 10px;
    padding-left: 20px;
    padding-right: 20px;
    }

    .body{
     background-color: #ECECEC;	
    }


    .div_contenido{
    color: #1e80b6;
    padding-top: 20px;
    padding-bottom: 10px;
    padding-left: 20px;
    padding-right: 20px;
    background-color: #ffffff !important;
   }

   </style>

</head> 

<body class="body">

<div class="titulo" > <h1><?= $contenido;   ?> </h1></div>
<hr>
<div class=".div_contenido" ></div>

<div class=".div_contenido" > Estimado/a Usuario :<b> <?= $nombre;   ?>  <br/><br/> Podrá encontrar la orden de compra adjunta en este mensaje de correo electrónico 
<br/><br/>Gracias.<br/><br/>NO OLVIDE VISITAR NUESTRO SISTIO WEB:<b>https://www.sur.gt/</b> </div>
	
</body>
</html>