<?php
session_start();
require_once 'conexao.php';

//GARANTE QUE O USUARIO ESTEJA LOGADO
if (!isste($_SESSION['id_usuario'])){
    echo "<script>alert('Acesso Negado!');window.locartion.href='login.php';</script>";
    exit();
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_usuario = $_SESSION['id_usuario'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if($nova_senha !== $confirmar_senha){
        echo "<script>alert('As senhas não coincidem!');</script>";
    }elseif(strlen($nova_senha)<8){
        echo "<script>alert('A senha deve ter pelo menos 8 caracteres!');</script>";
    }elseif(strlen($nova_senha === "temp123")){
        echo "<script>alert('Escolha uma senha diferente de temporaria!');</script>";
    }else{
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        //ATUALIZA ASENHA E REMOVE O STATUS DE TEMPORARIA
        $sql = "UPDATE usuario SET senha= :senha, senha_temporaria = FALSE WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha',$senha_hash);
        $stmt->bindParam(':id',$id_usuario);
    }
}
?>