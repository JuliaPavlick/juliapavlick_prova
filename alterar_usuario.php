<?php
session_start();
require_once("conexao.php");

if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

// INICIALIZA VARIÁVEL
$usuario = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['busca_usuario'])) {
        $busca = trim($_POST['busca_usuario']);

        // VERIFICA SE A BUSCA É UM NÚMERO (ID) OU UM NOME
        if (is_numeric($busca)) {
            $sql = "SELECT * FROM usuario WHERE id_usuario = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM usuario WHERE nome_usuario LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $busca_nome = "$busca%";
            $stmt->bindParam(':busca_nome', $busca_nome, PDO::PARAM_STR);
        }

        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // SE O USUÁRIO NÃO FOR ENCONTRADO, EXIBE UM ALERTA
        if (!$usuario) {
            echo "<script>alert('Usuário não encontrado!');</script>";
        }
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
    <script src="script.js"></script>
</head>
<body>
    <h2>Alterar Usuário</h2>

    <form action="alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o ID ou nome do usuário:</label>
        <input type="text" id="busca_usuario" name="busca_usuario" required onkeyup="buscarSugestoes()">
        <button type="submit">Pesquisar</button>

    <!--div para exibir sugestoes de usuario-->
    <div id="sugestoes"></div>
    <button type="submit">Buscar</button>
    </form>
    
    <?php if($usuario):?>
    <!--formulario para alterar usuario-->
    <form action="processa_alteracao_usuario.php" method="POST">
        <inpt type="hidden" name="id_usuario" value="<?=htmlspecialchars($usuario['id_usuario'])?>">
            <label for="nome">Nome: </label>
            <inpt type="text" id="nome" name="nome" value="<?=htmlspecialchars($usuario['nome'])?>"required>
            
            <label for="email">E-mail: </label>
            <inpt type="email" id="email" name="email" value="<?=htmlspecialchars($usuario['email'])?>"required>
              
            <label for="id_perfil">Perfil</label>
            <select id="id_perfil" name="id_perfil">
                <option
    </form>
</body>
</html>
