<?php
require_once('../conn.php');

    
$acao = mysqli_real_escape_string($conn,$_POST['acao']);
switch($acao){

        //cadastrar equipamento
        case 'cadastrar':
            if (isset($_POST['tipo']))
            {
            $marca = $_POST['marca'];
            if($_POST['outraMarca'])
            {
                $marca = $_POST['outraMarca'];
            }

            if ($_POST['qtdd']>1)
            {
                header("Location: cad_eq_multiplo.php?qtdd=".$_POST['qtdd']."&tipo=".$_POST['tipo']."&desc=".$_POST['descricao']."&marca=".$marca."&modelo=".$_POST['modelo']);
            }else{
                if($_POST['num_serie']!="")
                {
                $sql = "INSERT INTO equipamento (num_serie,tipo,descricao,status,marca,modelo) VALUES ('".$_POST['num_serie']."','".$_POST['tipo']."','".$_POST['descricao']."',0,'".$marca."','".$_POST['modelo']."')";
                $consulta = mysqli_query($conn,$sql);
                if ($consulta) echo "<script>alert('Equipamento cadastrado com sucesso')</script>";
                }else{
                echo "<script>alert('Preencha o campo de número de série')</script>";
                }
            }
            }

            if (isset($_POST['tipo']))
            {
            $marca = $_POST['marca'];
            if($_POST['outraMarca'])
            {
                $marca = $_POST['outraMarca'];
            }

            if ($_POST['qtdd']>1)
            {
                header("Location: cad_eq_multiplo.php?qtdd=".$_POST['qtdd']."&tipo=".$_POST['tipo']."&desc=".$_POST['descricao']."&marca=".$marca."&modelo=".$_POST['modelo']);
            }else{
                if($_POST['num_serie']!="")
                {
                $sql = "INSERT INTO equipamento (num_serie,tipo,descricao,status,marca,modelo) VALUES ('".$_POST['num_serie']."','".$_POST['tipo']."','".$_POST['descricao']."',0,'".$marca."','".$_POST['modelo']."')";
                $consulta = mysqli_query($conn,$sql);
                if ($consulta) echo "<script>alert('Equipamento cadastrado com sucesso')</script>";
                }else{
                echo "<script>alert('Preencha o campo de número de série')</script>";
                }
            }
            }
        
        break;

        //consulta equipamentos para listagem
        case 'consulta':

        $idedit = $_POST['idedit'];
        $sql = "SELECT * FROM equipamento WHERE num_serie ='".$idedit."'";
        $query = mysqli_query($conn,$sql);
		$st = mysqli_fetch_assoc($query);
        echo json_encode($st);


        break;
            /* */
        //Editar equipamentos da listagem
        case 'editar':
        sleep(1);
        $editID = $_POST['idserie'];
        $serie = mysqli_real_escape_string($conn,$_POST['num_serie']);
        $tipo = mysqli_real_escape_string($conn,$_POST['tipo']);
        $marca = mysqli_real_escape_string($conn,$_POST['marca']);
        $modelo = mysqli_real_escape_string($conn,$_POST['modelo']);
        $descricao = mysqli_real_escape_string($conn,$_POST['descricao']);

        $sql = "UPDATE equipamento SET num_serie = '".$serie."',tipo = '".$tipo."'
        ,marca = '".$marca."',modelo = '".$modelo."'
        ,descricao = '".$descricao."' WHERE num_serie ='".$editID."'"; 
        echo $sql;
        $query = mysqli_query($conn,$sql);
        if ($query){
             echo "foi";
        }else{
             echo "nao foi";
        }

        break;
        // Fim do case Edit

        case 'deletar':
        sleep(1);
        $idexcluir = $_POST['idexcluir'];
        
        $sql = "DELETE  from equipamento WHERE num_serie ='".$idexcluir."'";
        echo $sql;
        $query = mysqli_query($conn,$sql);
        

        break;

        default:

}//fim switch