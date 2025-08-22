<?php
session_start();
require_once("conexao.php");

// VERIFICA SE O USUARIO TEM PERMISSAO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!');window.location.href='principal.php'</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produto = $_POST['id_produto'];
    $nome_prod  = $_POST['nome_prod'];
    $descricao  = $_POST['descricao'];
    $qtde       = $_POST['qtde'];
    $valor_unit = $_POST['valor'];

    try {
        $sql = "UPDATE produto 
                   SET nome_prod = :nome_prod,
                       descricao = :descricao,
                       qtde = :qtde,
                       valor_unit = :valor_unit
                 WHERE id_produto = :id_produto";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome_prod', $nome_prod, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':qtde', $qtde, PDO::PARAM_INT);
        $stmt->bindParam(':valor_unit', $valor_unit, PDO::PARAM_STR);
        $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Produto atualizado com sucesso!');window.location.href='buscar_produto.php'</script>";
        } else {
            echo "<script>alert('Erro ao atualizar o produto!');window.location.href='alterar_produto.php?id=$id_produto'</script>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>