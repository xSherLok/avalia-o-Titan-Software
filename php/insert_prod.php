<?php
include_once("conexaobd.php");

//recebendo informações do formulario
$produto = $_POST["descricao"];
$preco = $_POST["preco"];
$cor = $_POST["cor"];

//SQL PARA INSERIR NO BANCO

$inserir_produto = "INSERT INTO produto (nome, cor) VALUES ('$produto', '$cor')";
$insert_preco ="INSERT INTO preco (preco) VALUES ('$preco')";

if(mysqli_query($link, $insert_preco)){
    $status_preco = 1;
    if(mysqli_query($link, $inserir_produto)){
        $produto_ok = 1;
            }
        else{
    die("Erro ao inserir produto! " . mysqli_error($link) . "<br>" . $inserir_produto);
        $produto_ok = 0;
        }
        header("Location:..\index.php?statusprod=$produto_ok");
}
else{
    die("Erro ao inserir valor! " . mysqli_error($link) . "<br>" . $insert_preco);
        $produto_ok = 0;
        }
?>