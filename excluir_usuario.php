<?php
session_start();
require_once 'conexao.php';

//VERIFICA DE O USUARIO TEM PERMISSAO DE ADM
if ($_SESSION['perfil' !=1]){
    echo"<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
    exit();
}

//INICIALIZA VARIAVEL PARA ARMAZENAR USUARIO
$usuarios = [];

//BUSCA USUARIOS CADASTRADOS EM ORDEM ALFABETICA
$sql = "SELECT * FROM usuarios ORDER BY nome ASC"
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

//SE UM ID PASSADO VIA GET EXCLUI O USUARIO
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];

    //EXCLUI O USUARIO DO BANCO DE DADOS
    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare
}
?>