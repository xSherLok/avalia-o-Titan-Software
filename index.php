<?php
 include_once("php/conexaobd.php");
  //conexao do banco
  //sql consultando os produtos do banco de dados junto com os preços
  $pesquisar_produtos = "SELECT * FROM produto JOIN preco ON produto.idprod = preco.idpreco";
  if(isset($_POST['botao_filtrar'])){
    $cor = $link -> real_escape_string($_POST['cor']);
    $valor = $link -> real_escape_string($_POST['valor']);
    $filtrar_tabela = $link -> real_escape_string($_POST['nome']);

    $pesquisar_produtos = "SELECT * FROM produto JOIN preco ON produto.idprod = preco.idpreco WHERE nome = '{$filtrar_tabela}' OR cor = '{$cor}' OR preco = '{$valor}'";
    //$pesquisar_produtos .= " OR preco = '{$filtrar_tabela}'";
  }
  $result = mysqli_query($link, $pesquisar_produtos)  or die ("ERRO ao pesquisar dados. " . mysqli_error($link) );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <!--FORMULARIO-->
    <section id="form">
        <h2>Cadastrar Produto</h2>
        <form class="container form-group" method="post" name="produtos" action="php/insert_prod.php" enctype="multipart/form-data">
            <div id="produtos">
                <label class="form-label" for="descricao">PRODUTOS:</label>
                <input class="form-control" id="descricao" name="descricao" type="text">
            </div>
            <div id="produtos">
                <label class="form-label" for="preco">PREÇO:</label>
                <input class="form-control" id="preco" name="preco" type="text">
            </div>
            <div id="produtos">
                <label class="form-label" for="">COR: </label>
                <select class="form-control" name="cor" id="cor">
                    <option value="azul">AZUL</option>
                    <option value="vermelho">VERMELHO</option>
                    <option value="amarelo">AMARELO</option>
                </select>
            </div>
            <button id="cadastrar" class="btn btn-success" type="submit" id="inserir">CADASTRAR</button>
            
        </form>
    </section>
    
    
    <!--FILTRO-->

    <section>
        <h2>FILTRAR PRODUTO</h2>
        <form class="container form-group" method="POST" name="filtro_tabela" action="index.php" enctype="multipart/form-data">
            <div>
                <label for="cor" class="form-label" for="">SELECIONE UMA COR:</label>
                <select class="form-control" name="cor" id="cor">
                    <option value="amarelo">Amarelo</option>
                    <option value="azul">azul</option>
                    <option value="vermelho">vermelho</option>
                </select>
            </div>
            <div>
                <label class="form-label" for="nome">Filtro:</label>
                <input class="form-control"s id="nome" name="nome" type="text" placeholder="nome">
            </div>
            <div>
                <label class="form-label" for="valor">Preço:</label>
                <input class="form-control"s id="valor" name="valor" type="text" placeholder="valor do produto">
            </div>
            <button type="submit" name="botao_filtrar" id="botao_filtrar" class="btn btn-primary">Filtrar</button>
        </form>
               
    </section>


    <!--validacao de cadastro de produto-->
    <?php
        if(isset($_GET["statusprod"])){
            $status = $_GET["statusprod"];
            if($status == 1){
                echo "<p style='color:green; font-weight:bold;'>Produto cadastrado com êxito!</p>";
            }
            elseif($status == 2){
                echo "<p style='color:green; font-weight:bold;'>Produto apagado com sucesso!</p>"; 
            }
            elseif($status == 4){
                echo "<p style='color:green; font-weight:bold;'>Produto atualizado com sucesso!</p>"; 
            }
            elseif($status == 4){
                echo "<p style='color:green; font-weight:bold;'>Produto atualizado com sucesso!</p>"; 
            }
            elseif($status == 3){
                echo "<p style='color:red; font-weight:bold;'>Erro ao apagar produto!</p>";
            }
            elseif($status == 0){
                echo "<p style='color:red; font-weight:bold;'>Erro ao cadastrar produto!</p>";
            }
            elseif($status == 5){
                echo "<p style='color:red; font-weight:bold;'>Erro ao atualizar produto!</p>";
            }
            else{
                die("<p style='color:red; font-weight:bold;'>Erro ao tentar cadastrar produto<br>" . mysqli_error($link) . "<br>" . $inserir_produto). "</p>";
            }
        }
    ?>
    <!--TABELA-->
    
    <section>
        <h2>Produtos</h2>
        <table class="container table">
            <thead>
            <tr>
                <th id="id">ID</th>
                <th id="titulo">PRODUTO</th>
                <th id="titulo">PRECO</th>
                <th id="desconto">DESCONTO</th>
                <th id="titulo">COR</th>
                <th>EDITAR</th>
                <th>EXCLUIR</th>
            </tr>
            </thead>
            <tbody>
          
                <?php 
                while($registro = mysqli_fetch_assoc($result)){ 
                     
                     //alimentando a tabela com os dados do banco
                     $desconto = $registro['cor'];
                     if($desconto == 'vermelho' && $registro['preco'] >= '50.00'){
                        $valor_desconto ='5%';
                     }
                     elseif($desconto == 'vermelho'){
                        $valor_desconto = '20%';
                     }
                     elseif($desconto == 'azul'){
                        $valor_desconto = '20%';
                     }
                     else{
                        $valor_desconto = '5%';
                     }
                     ?>
                     <tr>
                        <td><?php echo $registro['idprod'];?></td>
                        <td><?php echo $registro['nome'];?></td>
                        <td><?php echo $registro['preco'];?></td>
                        <td><?php echo $valor_desconto;?></td>
                        <td><?php echo $registro['cor'];?></td>
                        
                        <td><button type="button" class="btn btn-xs btn-warning" data-bs-toggle="modal" data-bs-target="#editar" data-whatever="<?php echo $registro['idprod']; ?>" data-whatevernome="<?php echo $registro['nome']; ?>"data-whateverpreco="<?php echo $registro['preco']; ?>">Editar</button></td>
                        <td><button button type="button" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#excluir" data-whatever="<?php echo $registro['idprod']; ?>" data-whatevernome="<?php echo $registro['nome']; ?>"data-whateverpreco="<?php echo $registro['preco']; ?>">Excluir</button></td>
                  <?php  } ?>
            </tbody>
        </table>
    </section>
    <!-- Modal Editar -->
    <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Produto</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="php/update_prod.php" enctype="multipart/form-data">
                <div class="form-group">
                <input type="hidden" value="" name="id-produto" id="id-produto">
                    </div>
                    <div class="form-group">
                        <label for="descricao" class="control-label">Nome:</label>
                        <input name="descricao" type="text" class="form-control" id="descricao">
                    </div>
                    <div class="form-group">
                        <label for="preco" class="control-label">Detalhes:</label>
                        <input name="preco" class="form-control" id="preco">
                    </div>
                    <input name="id" type="hidden" class="form-control" id="id-curso" value="">	
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Alterar</button>
                </form>
            </div>
        </div>
    </div>
    </div>
        <!-- Modal Excluir -->
        <div class="modal fade" id="excluir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Produto</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="php/excluir_prod.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <h2 id="excluir_h2">Deseja excluir este produto?</h2>
                        <input type="hidden" value="" name="id-produto" id="id-produto">
                    </div>
                    <input name="id" type="hidden" class="form-control" id="id-curso" value="">	
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$('#excluir').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var recipient = button.data('whatever') // Extract info from data-* attributes
		  var recipientnome = button.data('whatevernome')
		  var whateverpreco = button.data('whateverpreco')
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('.modal-title').text('ID ' + recipient)
		  modal.find('#id-produto').val(recipient)
		  modal.find('#descricao').val(recipientnome)
		  modal.find('#preco').val(whateverpreco)
		  
		})

		$('#editar').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var recipient = button.data('whatever') // Extract info from data-* attributes
		  var recipientnome = button.data('whatevernome')
		  var whateverpreco = button.data('whateverpreco')
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('.modal-title').text('ID ' + recipient)
		  modal.find('#id-produto').val(recipient)
		  modal.find('#descricao').val(recipientnome)
		  modal.find('#preco').val(whateverpreco)
		  
		})
	</script>
</body>
</html>