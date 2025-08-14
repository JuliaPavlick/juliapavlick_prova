<?php
    session_start();
    require_once 'conexao.php';

    //Verifica se o usuario tem permissao de adm ou secretaria
    if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2){
        echo "<script>alert('Acesso Negado!');window.locarion.href='principal.php';</script>";
        exit();
    }

    $usuario = []; //INICIALIZA A VARIAVEL PARA EVITAR ERROS

    //SE O FORMULARIO FOR ENVIADO, BUSCA O USUARIO PELO ID OU NOME
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['busca'])){
        $busca = trim($_POST['busca']);

        //VERIFICA SE A BUSCA É UM NUMERO OU UM NOME

        if(is_numeric($busca)){
            $sql = "SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":busca", $busca, PDO::PARAM_INT);
        }else{
            $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":busca_nome", "$busca%", PDO::PARAM_STR);
        }

    }else{
        $sql = "SELECT  * FROM usuario ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
    }
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Lista de Usuários</h2>

<form action="buscar_usuario.php" method="POST">
    <label for="busca">Digite o ID ou NOME(opcional): </label>
    <input type="text" id="busca" name="busca">
    <button type="submit">pesquisar</button>
</form>

<?php if(!empty($usuarios)): ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>

    <?php foreach($usuarios as $usuario): ?>

        <tr>
            <td><?=htmlspecialchars($usuario['id_usuario'])?> </td>
            <td><?=htmlspecialchars($usuario['nome'])?> </td>
            <td><?=htmlspecialchars($usuario['email'])?> </td>
            <td><?=htmlspecialchars($usuario['id_perfil'])?> </td>
            <td>
                <a href="alterar_usuario.php?>id=<?htmlspecialchars($usuario['id_usuario'])?>">Alterar</a>
                <a href="excluir_usuario.php?>id=<?htmlspecialchars($usuario['id_usuario'])?>"
                onclick="return confirm('tem certeza que deseja excluir este usuario?')">excluir</a>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php else: ?>
        <p>Nebhum usuario encontardo.</p>
        <?php endif;?>
        <a href="principal.php">Voltar</a>
</body>
</html>