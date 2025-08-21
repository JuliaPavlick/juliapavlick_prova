<?php
session_start();
require_once("conexao.php");

// VERIFICA SE O USUARIO TEM PERMISSAO (ADMIN)
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!');window.location.href='principal.php'</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_prod = trim($_POST["nome_prod"]);
    $descricao = trim($_POST["descricao"]);
    $qtde = $_POST["qtde"];
    $valor_unit = $_POST["valor_unit"];
    $id_produto = $_POST["id_produto"];

    if ($nome_prod && $descricao && $qtde && $valor_unit && $id_produto) {
        $sql = "INSERT INTO usuario (nome_prod, descricao, qtde, valor_unit, id_prod) VALUES (:nome_prod,:descricao, :qtde, :valor_unit, :id_produto)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_produto', $nome_prod, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':qtde', $qtde, PDO::PARAM_STR);
        $stmt->bindParam(':valor_unit', $valor_unit, PDO::PARAM_STR);
        $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Produto cadastrado com sucesso!');window.location.href='buscar_produto.php'</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar produto!');</script>";
        }
    } else {
        echo "<script>alert('Preencha todos os campos!');</script>";
    }
}


$id_perfil = $_SESSION['perfil'];
$permissoes = [
    //adm
    1 => [
        "Cadastrar" => [
            "cadastro_usuario.php",
            "cadastro_perfil.php",
            "cadastro_cliente.php",
            "cadastro_fornecedor.php",
            "cadastro_produto.php",
            "cadastro_funcionario.php"
        ],
        "Buscar" => [
            "buscar_usuario.php",
            "buscar_perfil.php",
            "buscar_cliente.php",
            "buscar_fornecedor.php",
            "buscar_produto.php",
            "buscar_funcionario.php"
        ],
        "Alterar" => [
            "alterar_usuario.php",
            "alterar_perfil.php",
            "alterar_cliente.php",
            "alterar_fornecedor.php",
            "alterar_produto.php",
            "alterar_funcionario.php"
        ],
        "Excluir" => [
            "excluir_usuario.php",
            "excluir_perfil.php",
            "excluir_cliente.php",
            "excluir_fornecedor.php",
            "excluir_produto.php",
            "excluir_funcionario.php"
        ]
    ],
    //secretaria
    2 => [
        "Cadastrar" => ["cadastro_cliente.php"],
        "Buscar" => ["buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php","buscar_usuario.php"],
        "Alterar" => ["alterar_fornecedor.php", "alterar_produto.php"],
        "Excluir" => ["excluir_produto.php"]
    ],
    //almoxarife
    3 => [
        "Cadastrar" => ["cadastro_fornecedor.php", "cadastro_produto.php"],
        "Buscar" => ["buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php"],
        "Alterar" => ["alterar_fornecedor.php", "alterar_produto.php"],
        "Excluir" => ["excluir_produto.php",]
    ],
    //cliente
    4 => [
        "Cadastrar" => ["cadastro_cliente.php"],
        "Buscar" => ["buscar_produto.php"],
        "Alterar" => ["alterar_cliente.php"],
    ],
];
$opcoes_menu = $permissoes[$id_perfil];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="css/cadusu.css">
</head>

<body>
    <nav>
        <ul class="menu">
            <?php foreach ($opcoes_menu as $categoria => $arquivos): ?>
                <li class="dropdown">
                    <a href="#"><?= $categoria ?></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($arquivos as $arquivo): ?>
                            <li>
                                <a href="<?= $arquivo ?>"><?= ucfirst(str_replace("_", " ", basename($arquivo, ".php"))) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <h2>Cadastrar Produto</h2>
    <form action="cadastro_produto.php" method="POST">
        <label for="nome_prod">Nome do Produto:</label>
        <input type="text" name="nome_prod" id="nome_prod">

        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao">

        <label for="qtde">Quantidade:</label>
        <input type="int" name="qtde" id="qtde">

        <label for="valor_unit">valor Unitário:</label>
        <input type="int" name="valor_unit" id="valor_unit">

    <div class="botoes">
        <button type="submit"> Salvar </button>
        <button type="reset"> Cancelar </button>
    </div>

    </form>

    <a href="principal.php">Voltar</a>

    
</body>

</html>