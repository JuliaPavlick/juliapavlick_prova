<?php
session_start();
require_once 'conexao.php';

// VERIFICA PERMISSÃO
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $id_perfil = $_POST['id_perfil'];

    // VERIFICAR SE O E-MAIL JÁ EXISTE
    $sqlCheck = "SELECT COUNT(*) FROM usuario WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(":email", $email);
    $stmtCheck->execute();

    if ($stmtCheck->fetchColumn() > 0) {
        echo "<script>alert('Erro: E-mail já cadastrado!');</script>";
    } else {
        // INSERIR NOVO USUÁRIO
        $sql = "INSERT INTO usuario (nome, email, senha, id_perfil) 
                VALUES (:nome, :email, :senha, :id_perfil)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":id_perfil", $id_perfil);

        if ($stmt->execute()) {
            echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro: Não foi possível cadastrar o usuário.');</script>";
        }
    }
}
?>
