<?php
  $uriCliente = "/var/www/webroot/TB-ROOT/model/Cliente.php";
  $uriCatalogo = "/var/www/webroot/TB-ROOT/model/Catalogo.php";
  $uriIndexPic = "/TB-ROOT/view/resources/tecnobay.jpg";
   
  $uriIcon =  "/favicon.ico";
  require_once($uriCliente);
  require_once($uriCatalogo);
  if (session_status() == 1)
    session_start();    
  $cliente = new Cliente(); 
  if (isset($_SESSION['correo']))
    $cantProductosCarrito = $cliente -> cantidadCarrito($_SESSION['correo']);
  if (!isset($cantProductosCarrito))
    $cantProductosCarrito = 0;
  $catalogo = new Catalogo();
  $cats = $catalogo -> listar_catalogos();
 ?>

<link rel="icon" type="image/x-icon" href="<?php echo $uriIcon ?>">
<title>Tecno-Bay</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html">
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">          
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Maven+Pro&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet"/>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<style>

.card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: contain;
}

  h1,h2,h3,h4,h5,td,th {
    font-family: 'Maven Pro', sans-serif;
    text-align: center;
    color: white;
  }		
  a { font-family: 'Maven Pro', sans-serif; }
  span { font-family: "Maven Pro", cursive; }		
  body, p { font-family: "Maven Pro", sans-serif;}		
  body { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.com/svgjs' width='1920' height='720' preserveAspectRatio='none' viewBox='0 0 1920 720'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1012%26quot%3b)' fill='none'%3e%3crect width='1920' height='720' x='0' y='0' fill='rgba(5%2c 19%2c 33%2c 1)'%3e%3c/rect%3e%3cpath d='M518.740956376337 335.649499301952L504.6448887135138 537.2326584800154 720.3241155544004 349.74556696477515z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1021.2196349408135 662.2183377461382L1127.8661386147683 592.9612884723058 951.9625856669811 555.5718340721835z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M1208.307%2c138.631C1230.003%2c137.704%2c1246.658%2c122.552%2c1258.504%2c104.352C1271.931%2c83.724%2c1284.877%2c59.498%2c1274.271%2c37.287C1262.547%2c12.734%2c1235.485%2c-2.06%2c1208.307%2c-0.774C1182.937%2c0.426%2c1164.237%2c20.618%2c1152.335%2c43.055C1141.29%2c63.876%2c1138.173%2c88.648%2c1150.084%2c108.986C1161.88%2c129.128%2c1184.986%2c139.628%2c1208.307%2c138.631' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M953.7404876913472 175.95357409975225L961.0472111190153 36.532985636990674 814.3198992285857 168.64685067208416z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M464.9824785081747 8.07528105597591L316.67680643147264 77.23135169316602 385.8328770686628 225.53702376986809 534.1385491453648 156.38095313267797z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float2'%3e%3c/path%3e%3cpath d='M445.386%2c779.545C481.894%2c779.606%2c518.889%2c770.373%2c539.797%2c740.445C564.096%2c705.662%2c575.457%2c659.825%2c554.988%2c622.659C533.957%2c584.473%2c488.932%2c566.975%2c445.386%2c569.021C405.235%2c570.908%2c371.615%2c596.943%2c352.283%2c632.184C333.735%2c665.997%2c330.923%2c707.526%2c351.522%2c740.13C370.949%2c770.878%2c409.015%2c779.484%2c445.386%2c779.545' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M344.23905417939005 24.294999774992462L554.169440051087 109.34519767439954 530.0392387834041-87.17952082636248z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1816.248%2c749.736C1844.069%2c751.435%2c1873.868%2c743.922%2c1888.442%2c720.163C1903.551%2c695.532%2c1899.165%2c663.958%2c1883.926%2c639.407C1869.522%2c616.202%2c1843.532%2c602.614%2c1816.248%2c603.855C1790.905%2c605.008%2c1770.491%2c622.782%2c1758.456%2c645.115C1747.088%2c666.21%2c1746.28%2c691.211%2c1757.867%2c712.187C1769.858%2c733.894%2c1791.495%2c748.224%2c1816.248%2c749.736' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M282.8385941202357 446.26094349115834L122.11745686771059 554.6687194045871 230.52523278113938 715.3898566571122 391.2463700336645 606.9820807436835z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M1314.07 26.99 a175.6 175.6 0 1 0 351.2 0 a175.6 175.6 0 1 0 -351.2 0z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M779.0412291594891 638.0938345305394L907.4071761721382 580.9416327037126 757.4958999255732 416.9688130981525z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3cpath d='M942.9951789594198 172.88148241442946L781.8358767071974 273.37155962349726 927.0421489268625 353.86071064257237z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float1'%3e%3c/path%3e%3cpath d='M1169.91 393.92 a157.07 157.07 0 1 0 314.14 0 a157.07 157.07 0 1 0 -314.14 0z' fill='rgba(28%2c 83%2c 142%2c 0.4)' class='triangle-float3'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1012'%3e%3crect width='1920' height='720' fill='white'%3e%3c/rect%3e%3c/mask%3e%3cstyle%3e %40keyframes float1 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-10px%2c 0)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float1 %7b animation: float1 5s infinite%3b %7d %40keyframes float2 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(-5px%2c -5px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float2 %7b animation: float2 4s infinite%3b %7d %40keyframes float3 %7b 0%25%7btransform: translate(0%2c 0)%7d 50%25%7btransform: translate(0%2c -10px)%7d 100%25%7btransform: translate(0%2c 0)%7d %7d .triangle-float3 %7b animation: float3 6s infinite%3b %7d %3c/style%3e%3c/defs%3e%3c/svg%3e"); }

  #circle {
	  border-radius: 50%;		  
	  object-fit: cover;
  }

  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
  }   
      
  .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: auto;
  }
    
  .form-signin .form-floating:focus-within {
    z-index: 2;
  }
    
  .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }
    
  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }

  .cart {
    position: relative;
  }

  #cart_menu_num {
    position: absolute;
    top: 0;
    left: 55%;
    background: red;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    padding: 2px;
    font-size: 11px;
  }
  .sidebar-social li {
    text-align: center;
    width: 31.9%;
    margin-bottom: 3px !important;
    display: inline-block;
    font-size: 10px;
    padding: 0;
  }

.sidebar-social i {
  display: block;
  margin: 0 auto 10px auto;
  width: 32px;
  height: 32px;
  margin: 10px auto 0;
  line-height: 32px;
  text-align: center;
  font-size: 20px;
  color: white;
  margin-top: 0;
  padding-top: 5px;
}

.sidebar-social a {
  text-decoration: none;
  width: 100%;
  height: 100%;
  display: block;
  margin: 0;
  padding: 0;
}

.sidebar-social a span {
  color: black;
  font-size: 15px;
  padding: 5px 0 10px 0;
  display: block;
  text-transform: uppercase;
  font-family: 'Maven Pro';
  letter-spacing: 1px;
}

/* ESTILO DE CARRITO*/ 
.table>tbody>tr>td, .table>tfoot>tr>td{
    vertical-align: middle;
}
@media screen and (max-width: 600px) {
    table#cart tbody td .form-control{
		width:20%;
		display: inline !important;
	}
	.actions .btn{
		width:36%;
		margin:1.5em 0;
	}
	
	.actions .btn-info{
		float:left;
	}
	.actions .btn-danger{
		float:right;
	}
	
	table#cart thead { display: none; }
	table#cart tbody td { display: block; padding: .6rem; min-width:320px;}
	table#cart tbody tr td:first-child { background: #333; color: #fff; }
	table#cart tbody td:before {
		content: attr(data-th); font-weight: bold;
		display: inline-block; width: 8rem;
	}
	
	table#cart tfoot td{display:block; }
	table#cart tfoot td .btn{display:block;}
	
}
/*################*/

.card-inner{
    margin-left: 4rem;
}

.progressbarWrapper {
  height: 30px;
  width: 500px;
  max-width: 80%;
  display: block;
  margin: auto;
  position: relative;
  background: #555;
  padding: 3px;
  box-shadow: inset 0 -1px 1px rgba(255, 255, 255, 0.3);
}

#greenBar {
  display: block;
  height: 100%;
  width: 0px;
  background-color: rgb(43, 194, 83);
  background-image: linear-gradient(
    center bottom,
    rgb(43, 194, 83) 37%,
    rgb(84, 240, 84) 69%
  );
  position: relative;
  overflow: hidden;
  font-size: 15px;
  text-align: center;
  color: white;
  transition: all 700ms ease;
}

button {
  display: block;
  margin: auto;
  margin-top: 20px;
  border: none;
  border-radius: 2px;
  border: 1px solid #ccc;
  box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.2);
  padding: 10px 20px;
  cursor: pointer;
}

button:active {
  width: 58px;
  height: 28px;
}

.row {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    display: flex;
    flex-wrap: wrap;
    margin-top: calc(var(--bs-gutter-y) * -1);
    margin-right: calc(var(--bs-gutter-x) * -0);
    margin-left: calc(var(--bs-gutter-x) * -0);
}

.card-footer {
    padding: 0.5rem 1rem;
    background-color: rgba(0,0,0,.03);
    border-top: 1pxsolidrgba(0,0,0,.125);
    text-align: center;
}

.container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    width: 100%;
    padding-right: var(--bs-gutter-x,.0rem);
    padding-left: var(--bs-gutter-x,.0rem);
    margin-right: auto;
    margin-left: auto;
}

.bg-secondary {
    --bs-bg-opacity: 0;
    background-color: rgba(var(--bs-secondary-rgb),var(--bs-bg-opacity))!important;
}

.btn {
    padding: 0.3rem 0.4rem;
}

.table-success {
  --bs-bg-opacity: 0;
    background-color: rgba(var(--bs-secondary-rgb),var(--bs-bg-opacity))!important;
    --bs-table-bg: .;
    --bs-table-striped-bg: #c7dbd2;
    --bs-table-striped-color: #000;
    --bs-table-active-bg: #bcd0c7;
    --bs-table-active-color: #000;
    --bs-table-hover-bg: #c1d6cc;
    --bs-table-hover-color: #000;
    color: #000;
    border-color: #bcd0c7;
}

.table-hover>tbody>tr:hover {
    --bs-table-accent-bg: #1d1e1e;
    color: var(--bs-table-hover-color);
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
  <a class="navbar-brand ms-3" href="/TB-ROOT/index.php"><img src="/TB-ROOT/view/resources/tecno-bay.jpg" class="img-thumbnail"/></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      

<?php if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) { ?>
  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        </li>
        <li class="nav-item">
        </li>
        <li class="nav-item">
        </li>
  </ul>
  <div class="d-flex">
    <a class="btn btn-outline-success" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">Iniciar sesión</a>
    <a class="btn btn-outline-success" style="margin-left: 5px" href="/TB-ROOT/view/registrarse.php" role="button">Registrarse</a>
  </div>

<?php } else if (isset($_SESSION["loggedin"]) && !strcmp($_SESSION["tipo"],"cliente")) { ?>
  <form id="formTodos" action="/TB-ROOT/controller/ProductoController.php" method="post">
    <input type="hidden" name="todosLosProductos"/>   
  </form>
  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="document.getElementById('formTodos').submit();" id="navbarDropdown" role="button">Ver todos los productos</a>       
    </li>
    
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorias</a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php foreach($cats as $c): {?>               
              <li><a href="/TB-ROOT/controller/ProductoController.php?cat=<?php echo $c['categoria'] ?>" class="dropdown-item"><?php echo $c['categoria'] ?></a></li>
          <?php } endforeach; ?>
        </ul>
    </li>     
  </ul>
  <div class="d-flex">
      <div class="cart-menu align-items-center d-flex">
        <div class="sidebar-social">
          <a href="/TB-ROOT/view/carrito.php" class="cart"><i class="fas fa-shopping-cart"></i><span style="color: white">Carrito</span>
            <span id="cart_menu_num" data-action="cart-can" class="badge rounded-circle"><?php echo $cantProductosCarrito ?></span>
          </a>          
        </div> 
      </div>
      <a href="/TB-ROOT/view/perfilCliente.php">  
      <?php $img = $_SESSION['img'];
          if (!($img == '')) { ?>
          <img src="data:image/jpg;base64,<?php echo $_SESSION['img']?>" width="58" height="58" id="circle" style="margin-left: 35px">
        <?php } else { ?>
            <img src="/TB-ROOT/view/resources/default.jpg" width="58" height="58" id="circle" style="margin-left: 35px">
        <?php } ?>
      </a>
      <div class="row g-0">                                
        <div class="col-2 mt-2">
            <ul>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle me-5" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <?php echo $_SESSION['username'] ?></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><form action="/TB-ROOT/controller/UsuarioController.php" name="cerrarSesion" method="post" >
                        <input type="hidden" name="cerrarSesion">
                        <input class="dropdown-item" type="submit" value="Cerrar sesion"/>
                        </form></li>				            
                    </ul>
                </li>	        
            </ul>
        </div>
      </div>
  </div>


<?php } else if (isset($_SESSION["loggedin"]) && !strcmp($_SESSION["tipo"],"admin")) { ?>
  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        </li>
        <li class="nav-item">
        </li>
        <li class="nav-item">
        </li>
  </ul>
  <div class="d-flex">
    <a href="/TB-ROOT/view/perfilAdmin.php"> 
      <img src="/TB-ROOT/view/resources/admin.png" width="58" height="58" id="circle">
    </a>
    <div class="row g-0">                                
      <div class="col-2 mt-2">
          <ul>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <?php echo $_SESSION['username'] ?></a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><form action="/TB-ROOT/controller/UsuarioController.php" name="cerrarSesion" method="post">
                <input type="hidden" name="cerrarSesion">
                <input class="dropdown-item" type="submit" value="Cerrar sesion"/>
                </form></li>			            
                </ul>
            </li>	        
          </ul>
      </div>
    </div>
  </div>
  <?php } ?>
  </div>
</nav>

<div class="alert alert-dark" role="alert">
    <div>
        <?php
        if (isset($_SESSION['message'])) {  
            echo  $_SESSION['message'];
            unset($_SESSION['message']);
        } 
        ?> 
    </div>
</div>	

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel" style="color:black;">Iniciar Sesión</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <main class="form-signin">
        <form action="/TB-ROOT/controller/UsuarioController.php" name="inicio" method="post">
          <img class="mb-4 center" src="/TB-ROOT/view/resources/tecnobay.jpg" width="300" height="149">
          <h1 class="h3 mb-3 fw-normal">Ingrese sus datos</h1>
      
          <div class="form-floating">
            <input class="form-control" id="floatingInput" name="id" required>
            <label for="floatingInput">Cedula / Correo</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" name="pass" required>
            <label for="floatingPassword">Contraseña</label>
          </div>
          
          <input type="hidden" name="iniciarS" value="ingresar">
          <input class="w-100 btn btn-lg btn-primary" type="submit" value="Ingresar">
          <p class="mt-5 mb-3 text-muted">&copy; Developed by MCM 2022</p>
        </form>
      </main>
  </div>
</div>