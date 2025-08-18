<?php
session_start();
require_once("conexao.php");

//GARANTE QUE O USUARIO ESTEJA LOGADO
if (!isset($_SESSION["id_usuario"])) {
    echo "<script>alert('Acesso Negado!');window.location.href='index.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['id_usuario'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($nova_senha != $confirmar_senha) {
        echo "<script>alert('As senhas não coincidem!');</script>";
    } elseif (strlen($nova_senha) < 8) {
        echo "<script>alert('A senha deve ter pelo menos 8 caracteres!');</script>";
    } elseif ($nova_senha === "temp123") {
        echo "<script>alert('Escolha uma senha diferente da temporaria!');</script>";
    } else {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        //ATUALIZA A SENHA E REMOVE O STATUS DE TEMPORARIA
        $sql = "UPDATE usuario SET senha = :senha, senha_temporaria = FALSE WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':id', $id_usuario);


        if ($stmt->execute()) {
            session_destroy(); //FINALIZA A SESSÃO
            echo "<script>alert('Faça login novamente!');window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erro ao alterar a senha!');;</script>";
        }
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
    <title>Alterar senha</title>
    <link rel="stylesheet" href="styles.css">
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
    <h2>Alterar senha</h2>
    <p>Olá, <strong><?php echo $_SESSION['usuario'] ?></strong>. Digite sua nova senha Abaixo:</p>

    <form action="alterar_senha.php" method="POST">
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" name="nova_senha" id="nova_senha" required>


        <label for="confirmar_senha">Confirmar Senha:</label>
        <input type="password" name="confirmar_senha" id="confirmar_senha" required>
        
        <label for="">
            <input type="checkbox" onclick="mostrarSenha()"> Mostrar senha
        </label>

        <button type="submit">Salvar nova senha</button>
    </form>

    <script>

    function mostrarSenha(){
        let senha1 = document.getElementById("nova_senha");
        let senha2 = document.getElementById("confimar_senha");
        let tipo = senha1.type === "password" ? "text": "password";
        senha1.type=tipo;
        senha2.type=tipo;

    }

    </script>

</body>

</html>