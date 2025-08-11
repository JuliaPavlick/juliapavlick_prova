<?php
session_start();
require_once 'conexao.php';

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit();
}
//OBTENDO O NOME DO PERFIL DO USUARIO LOGADO 
$id_Perfi = $_SESSION['perfil'];
$sqlPerfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";
$stmtPerfil = $pdo->prepare($sqlPerfil);
$stmtPerfil->bindParam(':id_perfil',$id_Perfil);
$stmtPerfil->bindParam(':id_perfil',$id_Perfil);













$permissoes =[
    1=>["Cadastrar"=>["cadastro_usuario.php","cadastro_perfil.php","cadastro_cliente",
    "cadastro_fornecedor","cadastro_produto","cadastro_funcionario"],
    "Buscar"=>["buscar_usuario.php","buscar_perfil.php","buscar_cliente",
    "buscar_fornecedor","buscar_produto","buscar_funcionario"],
    "alterar"=>["alterar_usuario.php","alterar_perfil.php","alterar_cliente",
    "alterar_fornecedor","alterar_produto","alterar_funcionario"],
    "excluir"=>["excluir_usuario.php","excluir_perfil.php","excluir_cliente",
    "excluir_fornecedor","excluir_produto","excluir_funcionario"],
    ]


    2=>["Cadastrar"=>["cadastro_cliente"],
    "Buscar"=>["buscar_cliente","buscar_fornecedor","buscar_produto"],
    "alterar"=>["alterar_fornecedor","alterar_produto"],
    "excluir"=>["excluir_produto"],
    ]

    3=>["Cadastrar"=>["cadastro_usuario.php","cadastro_perfil.php","cadastro_cliente",
    "cadastro_fornecedor","cadastro_produto","cadastro_funcionario"],
    "Buscar"=>["buscar_usuario.php","buscar_perfil.php","buscar_cliente",
    "buscar_fornecedor","buscar_produto","buscar_funcionario"],
    "alterar"=>["alterar_usuario.php","alterar_perfil.php","alterar_cliente",
    "alterar_fornecedor","alterar_produto","alterar_funcionario"],
    "excluir"=>["excluir_usuario.php","excluir_perfil.php","excluir_cliente",
    "excluir_fornecedor","excluir_produto","excluir_funcionario"],
    ]
]
?> 