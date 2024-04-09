
<?php
session_start();

if(!isset ($_SESSION['usuario']) == true )
{

unset($_SESSION['login']);
header('Location:login_pabx2.php');

}
$logado = $_SESSION['usuario'];

?>




<!DOCTYPE HTML>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>App Call Center</title>

<!-- <link rel="stylesheet" href="bootstrap/css/theme_hello_kiddie.min.css" /> -->
<link rel="stylesheet" href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bibliotecas/datatables/dataTables.bootstrap4.css">
<link rel="stylesheet" href="fontawesome/css/all.css" >
<link rel="stylesheet" href="bootstrap-4.1.1-dist/css/estilocustom.css">
<link rel="stylesheet" href="style.css">

</head>
<body>

<header class="section-header py-3 bg-primary">
<div class="d-flex px-5">
	<h2 class="text-light"><i class="fas fa-asterisk"></i>&nbsp;&nbsp;App Call Center </h2>
</div>
</header>
 <!-- section-header.// -->
<!-- ========================= SECTION CONTENT ========================= -->

<nav class="navbar navbar-expand-lg navbar-dark sticky-top bg-primary">
	<div class="container-fluid">
		<a class="navbar-brand" href="#"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
			<span class="navbar-toggler-icon"></span>
		</button>
	<div class="collapse navbar-collapse" id="main_nav">
		<ul class="navbar-nav">
			<li class="nav-item active"> <a class="nav-link" href="home.php"><i class="fas fa-home"></i>&nbsp;&nbsp;Home</a> </li>
		
			<li class="nav-item dropdown">
				<a class="nav-link  dropdown-toggle active" href="#" data-toggle="dropdown"><i class="fas fa-mobile-alt"></i></i>&nbsp;&nbsp;End Points </a>
				<ul class="dropdown-menu">
				  <h6 class="dropdown-header drop-header-color text-white" >Ramais</h6>
				  <li><a class="dropdown-item" href="formularioEndRamal.php">Criar Ramais</a></li>
				  <li><a class="dropdown-item" href="formularioEndRamalEdit.php">Editar Ramal</a></li>
				  <li><a class="dropdown-item" href="formularioEndRamalDel.php">Excluir Ramal</a></li>
				</ul>
			</li>		
		<li class="nav-item dropdown">
			<a class="nav-link  dropdown-toggle active" href="#" data-toggle="dropdown"><i class="fas fa-phone-slash"></i></i>&nbsp;&nbsp;Roteamento de chamadas</a>
			<ul class="dropdown-menu">
				<h6 class="dropdown-header drop-header-color text-white" >Roetamento Interno</h6>
				<li><a class="dropdown-item" href="formularioCriarDiscagem.php">Criar Discagem</a></li>
				<li><a class="dropdown-item" href="formularioConsChamada.php">Editar Discagem</a></li>
				<li><a class="dropdown-item" href="formularioDiscagemDel.php">Excluir Discagem</a></li>
				<h6 class="dropdown-header drop-header-color text-white" >Roteamento Externo</h6>
				<li><a class="dropdown-item" href="formularioIpTrunk.php">Criar Discagem Ip Trunk</a></li>
				<li><a class="dropdown-item" href="formularioConsCallIpTrunk.php">Edit Discagem Ip Trunk</a></li>
				<li><a class="dropdown-item" href="formularioIpTrunkDell.php">Delete Discagem Ip Trunk</a></li>
			</ul>
		</li>	
		
		<li class="nav-item dropdown">
			<a class="nav-link  dropdown-toggle active" href="#" data-toggle="dropdown"><i class="fas fa-headset"></i></i>&nbsp;&nbsp; Call center</a>
			<ul class="dropdown-menu">
				<li class="dropdown-submenu">
					<a class="dropdown-item dropdown-toggle" href="#">Filas</a>
					<ul class="dropdown-menu">
					 <h6 class="dropdown-header drop-header-color text-white" >Filas de atendimento</h6>
					 <li><a class="dropdown-item" href="formularioCriarFila.php">Criar filas</a></li>
				  	 <li><a class="dropdown-item" href="formularioConsFila.php">Editar Fila</a></li>
				  	 <li><a class="dropdown-item" href="formularioDelFila.php">Deletar Fila</a></li>
					 <h6 class="dropdown-header drop-header-color text-white" >Numeros Piloto de Fila</h6>
					 <li><a class="dropdown-item" href="formularioCriarPiloto.php">Criar Numero Piloto</a></li>
					 <li><a class="dropdown-item" href="formularioDelPiloto.php">Deletar Numero Piloto</a></li>
        		     </ul>
        		  </li>
				  <li class="dropdown-submenu">
					  <a class="dropdown-item dropdown-toggle" href="#">Ramais na fila</a>
        		      <ul class="dropdown-menu">
						  <li><a class="dropdown-item" href="formularioFilaRamal.php">Cadastrar ramal na fila</a></li>
						  <li><a class="dropdown-item" href="formularioConsFilaRamal.php">Retirar ramal da fila</a></li>
						  
						</ul>
					</li>
					
					<li class="dropdown-submenu">
						<a class="dropdown-item dropdown-toggle" href="#">Ura</a>
						<ul class="dropdown-menu">
						 <h6 class="dropdown-header drop-header-color text-white" >Audio da URA</h6>
						 <li><a class="dropdown-item" href="formularioUraFileUpload.php">Carregar Áudio</a></li>
						 <li><a class="dropdown-item" href="consultaAudioUra_2.php">Listar arquivos de  Áudio</a></li>
						 <h6 class="dropdown-header drop-header-color text-white" >Menu de atendimento</h6>
						  <li><a class="dropdown-item" href="formularioCriarMenu.php">Configurar Menu</a></li>
						
						</ul>
					</li>
				
				</ul>
			</li>

		
		<li class="nav-item dropdown">
			<a class="nav-link  dropdown-toggle active" href="#" data-toggle="dropdown"><i class="fas fa-chart-line"></i></i>&nbsp;&nbsp; Relatorios e gravações </a>
			<ul class="dropdown-menu">
				<h6 class="dropdown-header drop-header-color text-white" >Gravações & CDR</h6>
				<li><a class="dropdown-item" href="formularioChamadas.php">Relatorio de Chamadas</a></li>
				<li><a class="dropdown-item" href="formularioGravacao.php">Relatorio de Gravações </a></li>
				<h6 class="dropdown-header drop-header-color text-white" >Grafico</h6>
				<li><a class="dropdown-item" href="formularioGraficoTotAnsBusNoans.php">Grafico por ramal</a></li>

			</ul>
			</li>
			
			<li class="nav-item "><p class="nav-link text-white"> <strong> | Usuario Logado : <?php echo $logado ?></strong> </p></li>
			<li class="nav-item "><a class="nav-link  text-white btn btn-outline-warning  py-2" href="logout.php"><i class="fas fa-walking ">&nbsp;&nbsp;Sair</i></a></li>
	</div>
	
</div> 
</nav>


<div class="row  justify-content-center mt-4 p-0">
	<img src="imagens/uNGdWHi.png" class="">
</div>




<script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<!-- bootstrap-tablelas -->
<script type="text/javascript" src="bootstrap/js/sb-admin.min.js"></script>
<script type="text/javascript" src="bootstrap/js/sb-admin-datatables.min.js"></script>

<script type="text/javascript" src="bibliotecas/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="bibliotecas/datatables/dataTables.bootstrap4.js"></script>

<script>
// script para o submenus
$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  if (!$(this).next().hasClass('show')) {
    $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
  }
  var $subMenu = $(this).next('.dropdown-menu');
  $subMenu.toggleClass('show');


  $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    $('.dropdown-submenu .show').removeClass('show');
  });


  return false;
});
</script>




</body>
</html>