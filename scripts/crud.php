<?php
require_once('../conn.php');


$acao = mysqli_real_escape_string($conn, $_POST['acao']);
switch ($acao) {

		//Cadastrar Equipamento
	case 'cadastrar':
		sleep(1);

		if (isset($_POST['tipo'])) {

			if ($_POST['marca'] == "Outro") {
				$marca = $_POST['outraMarca'];
			} else {
				$marca = $_POST['marca'];
			}

			$serie = $_POST['num_serie'];
			$serie = str_replace(" ", "", $serie);

			if ($serie != "") {
				$sql = "INSERT INTO equipamento (num_serie,tipo,descricao,status,condicao_entrada,marca,modelo) VALUES ('" . $serie . "','" . $_POST['tipo'] . "','" . $_POST['descricao'] . "',0,'" . $_POST['condicao_entrada'] . "','" . $marca . "','" . $_POST['modelo'] . "')";
				$consulta = mysqli_query($conn, $sql);
				if ($consulta) {
					echo 1;
				} else {
					echo 2;
				}
			} else {
				echo 3;
			}
		}

		break;

		//consulta equipamentos para listagem
	case 'consulta':

		$idedit = $_POST['idedit'];
		$sql = "SELECT * FROM equipamento WHERE num_serie ='" . $idedit . "'";
		$query = mysqli_query($conn, $sql);
		$st = mysqli_fetch_assoc($query);
		echo json_encode($st);


		break;


	case 'cadastrarUsuario':

		$senha = sha1(md5($_POST['senha']));
		$dados = [$_POST['nome'], $_POST['titulo'], $senha, $_POST['nivel']];

		if (strlen($dados[1]) != 14) {
			echo 3;
		} else {
			if ($dados[3] != "") {
				$query = "INSERT INTO usuario(nome,titulo,senha,nivel) VALUES('" . $dados[0] . "','" . $dados[1] . "','" . $dados[2] . "'," . $dados[3] . ")";

				if (mysqli_query($conn, $query))
					echo 1;
				else
					echo 2;
			}
		}


		break;


	case 'consultaUsuario':

		$idedit = $_POST['ideditUsu'];
		$sql = "SELECT * FROM usuario WHERE titulo ='" . $idedit . "'";
		$query = mysqli_query($conn, $sql);
		/*if($query){
		echo "foi";
	}else{
		echo "nao foi";
	}*/
		$st = mysqli_fetch_assoc($query);
		echo json_encode($st);


		break;


		/* */
		//Editar equipamentos da listagem
	case 'editar':
		sleep(1);

		if ($_POST['marca'] == "Outro") {
			$marca = $_POST['outraMarca'];
		} else {
			$marca = $_POST['marca'];
		}

		$editID = $_POST['idserie'];
		$marca = mysqli_real_escape_string($conn, $marca);
		$tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
		$status = mysqli_real_escape_string($conn, $_POST['status']);
		$modelo = mysqli_real_escape_string($conn, $_POST['modelo']);
		$serie = mysqli_real_escape_string($conn, $_POST['num_serie']);
		$descricao = mysqli_real_escape_string($conn, $_POST['descricao']);

		$query = "SELECT status FROM equipamento WHERE num_serie=" . $editID;
		$result = mysqli_query($conn, $query);
		$statusAtual = mysqli_fetch_object($result);
		if ($statusAtual == 1)
		{
			echo 3;
		} else {
			$sql = "UPDATE equipamento SET num_serie = '" . $serie . "',tipo = '" . $tipo . "', status=" . $status . ",marca = '" . $marca . "',modelo = '" . $modelo . "',descricao = '" . $descricao . "' WHERE num_serie ='" . $editID . "'";
			$query = mysqli_query($conn, $sql);
			if ($query) {
				echo 1;
			} else {
				echo 2;
			}
		}

		break;
		// Fim do case Edit

	case 'editarUsuario':
		sleep(1);
		$editIDusu = $_POST['IdEditUsuario'];
		$nome = mysqli_real_escape_string($conn, $_POST['nome']);
		$titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
		$nivel = mysqli_real_escape_string($conn, $_POST['nivel']);

		$sql = "UPDATE usuario SET nome = '" . $nome . "',titulo = '" . $titulo . "'
	,nivel = '" . $nivel . "'";
		if ($_POST['senha'] != "") {
			$senha = mysqli_real_escape_string($conn, sha1(md5($_POST['senha'])));
			$sql .= ", senha='" . $senha . "'";
		}

		$sql .= " WHERE titulo ='" . $editIDusu . "'";
		$query = mysqli_query($conn, $sql);
		if ($query) {
			echo 1;
		} else {
			echo 2;
		}

		break;

	case 'deletar':
		sleep(1);
		$idexcluir = $_POST['idexcluir'];
		$flag = true;

		// SETA PARA NULO A CHAVE EXTRANGEIRA //Cley
		$query = "SELECT lot_status FROM ligacao WHERE e_num_serie='" . $idexcluir . "'";
		$result = mysqli_query($conn, $query);
		if (mysqli_fetch_object($result)->lot_status == 0) {
			$flag = false;
			echo 2;
		} else {
			$query = "SELECT lot_status FROM ligacao WHERE e_num_serie='" . $idexcluir . "'";
			$result = mysqli_query($conn, $query);
			if (mysqli_fetch_object($result)->lot_status == 0) {
				$flag = false;
				echo 2;
			}
		}
		if ($flag) {
			$sql = "DELETE FROM equipamento WHERE num_serie ='" . $idexcluir . "'";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				echo 1;
			} else {
				echo 2;
			}
		}


		break;

	case 'deletarUsuario':
		sleep(1);
		$idexcluirUsu = $_POST['idexcluir'];
		$sql = "DELETE FROM usuario WHERE titulo ='" . $idexcluirUsu . "'";
		$query = mysqli_query($conn, $sql);
		if ($query) {
			echo 1;
		} else {
			echo 2;
		}


		break;

	default:
}//fim switch
