<?php
session_start();
require_once("conexao.php");

// VERIFICA SE O USUARIO TEM PERMISSAO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!');window.location.href='principal.php'</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_produto'];
    $nome_prod = $_POST['nome_prod'];
    $descricao = $_POST['descricao'];
    $qtde = $_POST['qtde'];
    $valor_unit = $_POST['valor_unit'];

    //ATUALIZA OS DADOS DO USUARIO
   if {
        $sql = "UPDATE poduto SET nome_prod=:nome_prod,decricao=:descricao,qtde=:qtde,valor_unit=:valor_unit,id_produto=:id_produto WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
    }
    $stmt->bindParam('nome_prod', $nome_prod);
    $stmt->bindParam('descricao', $descricao);
    $stmt->bindParam('qtde', $qtde);
    $stmt->bindParam('id_produto', $id_produto);

    if ($stmt->execute()) {
       echo "<script>alert('Produto atualizado com sucesso!');window.location.href='buscar_produto.php'</script>";
    } else {
      echo "<script>alert('Erro ao atualizar o produto!');window.location.href='alterar_produto.php?id=$id_produto';</script>";
    }
}
?>