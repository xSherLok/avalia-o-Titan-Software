<?php
include_once("conexaobd.php");

$id_prod = $_POST['id-produto'];
$nome = $_POST['descricao'];
$preco = $_POST['preco'];

echo $id_prod;
echo $nome;
echo $preco;


$update_preco = "UPDATE preco SET preco = '$preco' WHERE idpreco= '$id_prod'";
$update_prod = "UPDATE produto SET nome = '$nome' WHERE idprod = '$id_prod'";


if(mysqli_query($link, $update_preco)){
    $status_preco = 4;
    if(mysqli_query($link, $update_prod)){
        $status_prod =4;
    }
    else{
        die("Erro ao atualizar produto! " . mysqli_error($link) . "<br>" . $update_prod);
            $status_prod = 5;
            }
            header("Location:..\index.php?statusprod=$status_prod");
    }
    else{
        die("Erro ao atualizar produto! " . mysqli_error($link) . "<br>" . $update_preco);
            $status_prod = 0;
            }

?>
