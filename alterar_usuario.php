<?php
session_start();
require_once 'conexao.php';

// VERIFICA SE O USUÁRIO TEM PERMISSÃO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('ACESSO NEGADO!');window.location.href='principal.php';</script>";
    exit();
}

// INICIALIZA VARIÁVEL
$usuario = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['busca_usuario'])) {
    $busca = trim($_POST['busca_usuario']);

    if (is_numeric($busca)) {
        $sql = "SELECT * FROM usuario WHERE id_usuario = :busca";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome";
        $stmt = $pdo->prepare($sql);
        $likeBusca = "%$busca%";
        $stmt->bindParam(':busca_nome', $likeBusca, PDO::PARAM_STR);
    }

    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "<script>alert('Usuário não encontrado!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>
<body>
    <h2>Alterar Usuário</h2>

    <!-- FORMULÁRIO DE PESQUISA -->
    <form action="alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o ID ou nome de usuário:</label>
        <input type="text" id="busca_usuario" name="busca_usuario" required onkeyup="buscarSugestoes()">
        <div id="sugestoes"></div>
        <button type="submit">Pesquisar</button>
    </form>

    <?php if ($usuario): ?>
    <!-- FORMULÁRIO DE ALTERAÇÃO -->
    <form action="processa_alteracao_usuario.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label for="id_perfil">Perfil:</label>
        <select name="id_perfil" id="id_perfil">
            <option value="1" <?= $usuario['id_perfil'] == 1 ? 'selected' : '' ?>>Administrador</option>
            <option value="2" <?= $usuario['id_perfil'] == 2 ? 'selected' : '' ?>>Usuário Comum</option>
            <option value="3" <?= $usuario['id_perfil'] == 3 ? 'selected' : '' ?>>Outro Perfil</option>
        </select>

        <?php if ($_SESSION['perfil'] == 1): ?>
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha">
        <?php endif; ?>

        <button type="submit">Alterar</button>
        <button type="reset">Cancelar</button>
    </form>
    <?php endif; ?>

    <a href="principal.php">Voltar</a>
</body>
</html>
