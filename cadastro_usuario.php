<?php
session_start();
require_once("conexao.php");

// VERIFICA SE O USUARIO TEM PERMISSAO (ADMIN)
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!');window.location.href='principal.php'</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    $id_perfil = (int)$_POST["id_perfil"];

    if ($nome && $email && $senha && $id_perfil) {
        $sql = "INSERT INTO usuario (nome, email, senha, id_perfil) VALUES (:nome,:email,:senha,:id_perfil)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':id_perfil', $id_perfil, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Usuário cadastrado com sucesso!');window.location.href='buscar_usuario.php'</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário!');</script>";
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
    <title>Cadastrar usuário</title>
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

    <h2>Cadastrar Usuário</h2>
    <form action="cadastro_usuario.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email">

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha">

        <label for="id_perfil">Perfil:</label>
        <select name="id_perfil" id="id_perfil">
            <option value="1">Administrador</option>
            <option value="2">Secretaria</option>
            <option value="3">Almoxarife</option>
            <option value="4">Cliente</option>
        </select>

    <div class="botoes">
        <button type="submit"> Salvar </button>
        <button type="reset"> Cancelar </button>
    </div>

    </form>

    <a href="principal.php">Voltar</a>

    <andress>
            Júlia Caroline Borges Pavlick
        </andress>
</body>

</html>