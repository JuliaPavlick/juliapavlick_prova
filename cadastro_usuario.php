<?php
session_start();
require_once 'conexao.php';

//VERIFICA SE O USUARIO TEM PERMISSAO SUPONDO QUE O PERFIL 1 SEJA O ADMINISTRADOR
if ($_SESSION['perfil']!=1){
    echo "Acesso negado";
}

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash( $_POST['senha'],PASSWORD_DEFAULT);
    $id_perfil = $_POST['id_perfil'];

    $sql = "INSERT INTO usuario (nome,email,senha,id_perfil) VALUES (:nome,:email,:senha,:id_perfil)";
    $stmt = $pdo->$prepare($sql);
    $stmt->bindParam(:nome,$nome);
    $stmt->bindParam(:email,$email);
    $stmt->bindParam(:senha,$senha);
    $stmt->bindParam(:id_perfil,$id_perfil);

    if ($stmt->execute()){

    }else{
        echo""
    }
}