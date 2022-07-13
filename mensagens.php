<?php

//Conecta-se a base de dados
$con = mysqli_connect('localhost', 'root', '', 'lzap_chatbot') OR die(__FILE__.': Erro->falha ao conectar a base de dados | Linha->'.__LINE__);

//Pega mensagens
$sql_mensagens = mysqli_query($con, "SELECT mensagem.*, chat.nome FROM whats_mensagem mensagem, whats_chat chat WHERE mensagem.id_chat = chat.id_chat");

while($res_mensagens = mysqli_fetch_array($sql_mensagens))
{
	//Apresenta mensagens
	$mensagem = "<h2>".($res_mensagens['minha']=='N'?$res_mensagens['nome']:'Logon Soluções')."</h2><p>".$res_mensagens['mensagem']."</p></br></br>";
	echo $mensagem;
}