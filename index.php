<?php
$host="localhost";$db="guestbook";$user="root";$pass="";
try{$pdo=new PDO("mysql:host=$host;dbname=$db;charset=utf8",$user,$pass);}
catch(PDOException$e){die("Erro: ".$e->getMessage());}
if($_SERVER["REQUEST_METHOD"]==="POST"&&isset($_POST["nome"],$_POST["msg"])){
$stmt=$pdo->prepare("INSERT INTO mensagens (nome,mensagem) VALUES (?,?)");
$stmt->execute([htmlspecialchars($_POST["nome"]),htmlspecialchars($_POST["msg"])]);
header("Location: index.php");exit;}
$mensagens=$pdo->query("SELECT * FROM mensagens ORDER BY criado_em DESC LIMIT 50")->fetchAll();
?><!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Livro de Visitas</title>
<style>body{font-family:Arial;max-width:600px;margin:30px auto;padding:20px;background:#f9f9f9}
form{background:white;padding:20px;border-radius:8px;margin-bottom:20px}
input,textarea{width:100%;padding:8px;margin:5px 0;border:1px solid #ddd;border-radius:4px}
button{background:#2196F3;color:white;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}
.msg{background:white;padding:15px;margin-bottom:10px;border-radius:4px;border-left:4px solid #2196F3}
.msg small{color:#999}.msg .data{color:#bbb;font-size:0.8em}</style></head>
<body><h1>Livro de Visitas</h1>
<form method="POST"><input type="text" name="nome" placeholder="Seu nome" required>
<textarea name="msg" placeholder="Sua mensagem..." required></textarea>
<button type="submit">Enviar</button></form>
<?php foreach($mensagens as $m):?>
<div class="msg"><strong><?=htmlspecialchars($m["nome"])?></strong>
<p><?=nl2br(htmlspecialchars($m["mensagem"]))?></p>
<small class="data"><?=$m["criado_em"]?></small></div>
<?php endforeach;?></body></html>
