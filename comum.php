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

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="styles.css">
        <title>App • Call Center</title>
    </head>

<body>
    <nav id="sidebar" class="shadow">
        <div id="sidebar_content">
            <div id="user">
                <img src="src/images/avatar.png" id="user_avatar" alt="Avatar">

                <p id="user_infos">
                    <span class="item-description">
                        <?php echo $logado ?>
                    </span>
                    <span class="item-description">
                        Administrador
                    </span>
                </p>
            </div>

            <div id="side_items">
                <li class="side-item active">
                    <a href="#">
                        <i class="fa-solid fa-chart-line"></i>
                        <span class="item-description">
                            Dashboard
                        </span>
                    </a>
                </li>
                <li class="side-item">
                    <a class="dropdown-toggle active" href="#" data-toggle="dropdown">
                        <i class="fas fa-mobile-alt"></i><span class="item-description">Endpoints</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="Ramal.php">Criar Ramais</a></li>
                        <li><a class="dropdown-item" href="RamalEdit.php">Editar Ramal</a></li>
                        <li><a class="dropdown-item" href="RamalDel.php">Excluir Ramal</a></li>
                    </ul>
                </li>
                <li class="side-item dropdown">
                    <a class="dropdown-toggle active" href="#" data-toggle="dropdown">
                        <i class="fas fa-phone-slash"></i><span class="item-description">Chamadas</span>
                    </a>
                    <ul class="dropdown-menu">
                        <a class="dropdown-item bg-light" href="#">
                            <h6>Roteamento Interno</h6>
                        </a>

                        <li><a class="dropdown-item" href="formularioCriarDiscagem.php">Criar Discagem</a></li>
                        <li><a class="dropdown-item" href="formularioConsChamada.php">Editar Discagem</a></li>
                        <li><a class="dropdown-item" href="formularioDiscagemDel.php">Excluir Discagem</a></li>
                        <a class="dropdown-item bg-light" href="#">
                            <h6>Roteamento Externo</h6>
                        </a>

                        <li><a class="dropdown-item" href="formularioIpTrunk.php">Criar Discagem Ip Trunk</a></li>
                        <li><a class="dropdown-item" href="formularioConsCallIpTrunk.php">Edit Discagem Ip Trunk</a>
                        </li>
                        <li><a class="dropdown-item" href="formularioIpTrunkDell.php">Delete Discagem Ip Trunk</a></li>
                    </ul>
                </li>
                <li class="side-item dropdown">
                    <a class="dropdown-toggle active" href="#" data-toggle="dropdown">
                        <i class="fas fa-headset"></i><span class="item-description">Call Center</span>
                    </a>
                    <ul class="dropdown-menu">
                        <a class="dropdown-item bg-light" href="#">
                            <h6>Filas</h6>
                        </a>
                        <li><a class="dropdown-item" href="formularioCriarFila.php">Criar filas</a></li>
                        <li><a class="dropdown-item" href="formularioConsFila.php">Editar Fila</a></li>
                        <li><a class="dropdown-item" href="formularioDelFila.php">Deletar Fila</a></li>
                        <li><a class="dropdown-item" href="formularioCriarPiloto.php">Criar Numero Piloto</a></li>
                        <li><a class="dropdown-item" href="formularioDelPiloto.php">Deletar Numero Piloto</a></li>
                        <li><a class="dropdown-item" href="formularioFilaRamal.php">Cadastrar ramal na fila</a></li>
                        <li><a class="dropdown-item" href="formularioConsFilaRamal.php">Retirar ramal da fila</a></li>
                    </ul>
                </li>
                <li class="side-item dropdown">
                    <a class="dropdown-toggle active" href="#" data-toggle="dropdown">
                        <i class="fa-solid fa-robot"></i><span class="item-description">Ura</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="formularioUraFileUpload.php">Carregar Áudio</a></li>
                        <li><a class="dropdown-item" href="consultaAudioUra_2.php">Listar arquivos de Áudio</a></li>
                        <li><a class="dropdown-item" href="formularioCriarMenu.php">Configurar Menu</a></li>
                    </ul>
                </li>
                <li class="side-item dropdown">
                    <a class="dropdown-toggle active" href="#" data-toggle="dropdown">
                        <i class="fas fa-chart-line"></i><span class="item-description">Relatórios</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="formularioChamadas.php">Relatorio de Chamadas</a></li>
                        <li><a class="dropdown-item" href="formularioGravacao.php">Relatorio de Gravações </a></li>
                        <li><a class="dropdown-item" href="formularioGraficoTotAnsBusNoans.php">Grafico por ramal</a>
                        </li>
                    </ul>
                </li>

                <li class="side-item">
                    <a href="#">
                        <i class="fa-solid fa-user"></i>
                        <span class="item-description">
                            Usuários
                        </span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="#">
                        <i class="fa-solid fa-gear"></i>
                        <span class="item-description">
                            Configurações
                        </span>
                    </a>
                </li>
            </div>

            <button id="open_btn">
                <i id="open_btn_icon" class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <div id="logout">
            <button id="logout_btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                <a class="item-description" href="logout.php">
                    Logout
                </a>
            </button>
        </div>
    </nav>

    <?php
	if (isset($_GET['cadastro'])){  // dados recebidos de para validar a criação do ramal
		switch ($_GET['cadastro']) {
			case "ok": // caso ok mostra o alert success
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <?php 
		
	?>
        <strong class="d-flex justify-content-center">Ramal <?php echo $_GET['ramal'] ;?> criado com sucesso na base de
            dados </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados recebidos de verifica_usuario_logado.php
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <?php 
		
	?>
        <strong class="d-flex justify-content-center">Ramal <?php echo $_GET['ramal'] ;?> Ja exixtente na base de dados.
        </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['update'])){  // dados recebidos atualizado com sucesso
		switch ($_GET['update']) {
			case "ok": // dados recebidos atualizado com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Ramal "<?php echo $_GET['numero'] ;?>" atualizado com sucesso !
        </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados recebidos atualizado com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao Atualizar Ramal <?php echo $$_GET['numero'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['deletado'])){  // dados deletado com sucesso
		switch ($_GET['deletado']) {
			case "ok": // dados deletado com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Ramal <?php echo $_GET['numero'] ;?> deletado com sucesso
        </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados dados deletado com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao deletar Ramal <?php echo $_GET['numero'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['discagem'])){  // dados regra criada com sucesso
		switch ($_GET['discagem']) {
			case "ok": // dados regra criada com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Discagem <?php echo $_GET['regra'] ;?> criada com sucesso
        </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar a discagem <?php echo $_GET['regra'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['discagem_update'])){  // dados regra criada com sucesso
		switch ($_GET['discagem_update']) {
			case "ok": // dados regra criada com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Discagem <?php echo $_GET['regra'] ;?> alterada com sucesso
        </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao editar a discagem <?php echo $_GET['regra'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['exten_del'])){  //regra deletada com sucesso
		switch ($_GET['exten_del']) {
			case "ok": // regra deletada com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Discagem <?php echo $_GET['exten'] ;?> deletada com sucesso
        </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao deletar a discagem <?php echo $_GET['exten'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['sip_trunk'])){  //regra sip trunk  com sucesso
		switch ($_GET['sip_trunk']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Discagem Sip Trunk <?php echo $_GET['discagem_out'] ;?> criada com
            sucesso </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar a discagem <?php echo $_GET['discagem_out'] ;?>
        </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['update_trunk'])){  //regra sip trunk  com sucesso
		switch ($_GET['update_trunk']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Discagem Sip Trunk <?php echo $_GET['numero'] ;?> atualizada com
            sucesso </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao deletar a discagem <?php echo $_GET['numero'] ;?>
        </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['delete_trunk'])){  //regra sip trunk  com sucesso
		switch ($_GET['delete_trunk']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Discagem Sip Trunk <?php echo $_GET['exten_ip_trunk'] ;?> deletada
            com sucesso </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao deletar a discagem <?php echo $_GET['exten_ip_trunk'] ;?>
        </strong>
    </div>

    <?php  
        break;
        }
    }
	if (isset($_GET['fila'])){  //regra sip trunk  com sucesso
		switch ($_GET['fila']) {
			case "ok": // regra sip trunk  com sucesso
	?>


    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Fila <?php echo $_GET['piloto'] ;?> criado com sucesso </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar o <?php echo $$_GET['piloto'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
	
	?>

    <?php
	if (isset($_GET['update_fila'])){  //regra sip trunk  com sucesso
		switch ($_GET['update_fila']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Numero de fila <?php echo $_GET['piloto_fila'] ;?> atualizado com
            sucesso </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar o <?php echo $$_GET['piloto'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>

    <?php
	if (isset($_GET['fila_del'])){  //regra sip trunk  com sucesso
		switch ($_GET['fila_del']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Fila <?php echo $_GET['fila'] ;?> deletado com sucesso </strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar o <?php echo $_GET['name'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['fila_com_ramal'])){  //regra sip trunk  com sucesso
		switch ($_GET['fila_com_ramal']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Ramal <?php echo $_GET['ramal_fila'] ;?> vinculado a
            <?php echo $_GET['fila_select']?></strong>
    </div>

    <?php     
        break;
       // case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar o <?php echo $$_GET['name'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['ramal_retirado_fila'])){  //regra sip trunk  com sucesso
		switch ($_GET['ramal_retirado_fila']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Ramal <?php echo $_GET['ramal_fila'] ;?> Retirado da fila
            <?php echo $_GET['nome_fila']?></strong>
    </div>

    <?php     
        break;
       // case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar o <?php echo $$_GET['name'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['piloto_da_fila'])){  //regra sip trunk  com sucesso
		switch ($_GET['piloto_da_fila']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Piloto <?php echo $_GET['numero'] ;?> da fila
            <?php echo $_GET['nome_da_fila']?> criado com sucesso </strong>
    </div>

    <?php     
        break;
       // case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar o <?php echo $$_GET['name'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['piloto_del'])){  //regra sip trunk  com sucesso
		switch ($_GET['piloto_del']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Numero piloto <?php echo $_GET['piloto_deletado'] ;?> da fila
            <?php echo $_GET['fila_name']?></strong>
    </div>

    <?php     
	break;
       // case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar o <?php echo $$_GET['name'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['audio_upload'])){  //regra sip trunk  com sucesso
		switch ($_GET['audio_upload']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Audio <?php echo $_GET['arquivo_audio'] ;?> Carregado com
            sucesso</strong>
    </div>

    <?php     
        break;
        case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao Carregar o Audio <?php echo $_GET['arquivo_audio'] ;?>
        </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['arquivo_deletado'])){  //regra sip trunk  com sucesso
		switch ($_GET['arquivo_deletado']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Audio <?php echo $_GET['arquivo_nome'] ;?> excluido com
            sucesso</strong>
    </div>

    <?php     
        break;
       // case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar o <?php echo $$_GET['name'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>
    <?php
	if (isset($_GET['opcoes_ura'])){  //regra sip trunk  com sucesso
		switch ($_GET['opcoes_ura']) {
			case "ok": // regra sip trunk  com sucesso
				?>
    <div class="alert alert-success offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>
        <strong class="d-flex justify-content-center">Opções da URA configuradas com sucesso</strong>
    </div>

    <?php     
        break;
       // case "fail":  // dados regra criada com sucesso
    ?>
    <div class="alert alert-danger offset-2 w-50 dismissable">
        <button class="close" type="button" data-dismiss="alert">&times;</button>

        <strong class="d-flex justify-content-center">Erro ao criar o <?php echo $$_GET['name'] ;?> </strong>
    </div>

    <?php  
        break;
        }
    }
?>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables DateTime Picker CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css">

    <!-- DataTables DateTime Picker JS -->
    <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>

    <!-- DataTables Buttons CSS (Version 2.2.9) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.9/css/buttons.dataTables.min.css">

    <!-- DataTables Buttons JS (Version 2.2.9) -->
    <script src="https://cdn.datatables.net/buttons/2.2.9/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.9/js/buttons.html5.min.js"></script>

    <!-- DataTables Buttons CSS (Version 2.2.3) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    <!-- DataTables Buttons JS (Version 2.2.3) -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>

    <script src="src/javascript/script.js"></script>


</body>

</html>