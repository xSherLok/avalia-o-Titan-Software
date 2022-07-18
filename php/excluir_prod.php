<?php
include_once("conexaobd.php");

$id_prod = $_POST['id-produto'];

echo $id_prod;

$delet_preco = "DELETE FROM `preco` WHERE idpreco = $id_prod";
$delet_prod = "DELETE FROM `produto` WHERE idprod = $id_prod";


if(mysqli_query($link, $delet_preco)){
    $status_preco = 2;
    if(mysqli_query($link, $delet_prod)){
        $status_prod =2;
    }
    else{
        die("Erro ao excluir produto! " . mysqli_error($link) . "<br>" . $delet_prod);
            $status_prod = 3;
            }
            header("Location:..\index.php?statusprod=$status_prod");
    }
    else{
        die("Erro ao excluir produto! " . mysqli_error($link) . "<br>" . $delet_preco);
            $status_prod = 0;
            }

?>
