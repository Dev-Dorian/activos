<?php

date_default_timezone_set('America/Costa_Rica');
// Conexão com o banco
try {
	$pdo = new PDO("mysql:dbname=dbsistemalaravel;host=localhost:8000", "root", "");
} catch (PDOException $e) {
	echo "ERRO: " . $e->getMessage();
	exit();
}
// ip do usuário
$ip = $_SERVER['REMOTE_ADDR']; 
// Horário
//$hora = date('H:i:s');
//$hora = date('d/m/Y H:i:s');

$hora = date('Y-m-d H:i:s');

// Adiciona os dados ao banco de dados
$sql = $pdo->prepare("INSERT INTO acessos (ip, hora) VALUES (:ip, :hora)");
$sql->bindValue(":ip", $ip);
$sql->bindValue(":hora", $hora);
$sql->execute();
// Deleta os dados do banco de dados
//$sql = $pdo->prepare("DELETE FROM acessos WHERE hora < :hora");
//$sql->bindValue(":hora", date('H:i:s', strtotime("-2 minutes")));
//$sql->execute();
// Seleciona dados no banco de dados
$sql = "SELECT * FROM acessos WHERE hora > :hora GROUP BY ip";
$sql = $pdo->prepare($sql);
$sql->bindValue(":hora", date('H:i:s', strtotime("-2 minutes")));
$sql->execute();
$contagem = $sql->rowCount();
// Exibe acessos
echo "ONLINE: " . $contagem;
