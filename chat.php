<?php
//Verifica se post foi feito
if(isset($_POST['submit']))
{
	//Pega dados
	$numero   = $_POST['numero'];
	$nome	  = $_POST['nome'];
	$mensagem = $_POST['mensagem'];
	
	//Cria corpo da requisição
	$payload = json_encode([
		"Type" => "receveid_message",
		"Body" => array(
			"Info" 		  => [
				"Id"		=> bin2hex(date("YmdHis").basename(__FILE__)),
				"RemoteJid"	=> $numero."@s.whatsapp.net",
				"FromMe"	=> false,
				"Timestamp"	=> time(),
				"PushName"	=> $nome
			],
			"Text" 		  => $mensagem,
			"ContextInfo" => [
				"QuotedMessageID" => "",
				"QuotedMessage"	  => ""
			]
		)
	]);
	
	//Cria cabeçalho da requisição
	$options = array(
		"Content-Type: application/json",
		"Content-Length: ".strlen($payload)
	);
	
	//Inicia biblioteca curl
	$ch = CURL_INIT();
	
	//Configura opções
	CURL_SETOPT_ARRAY($ch, [
		CURLOPT_URL				=> 'http://localhost/logon/estudo/self/php/lzap_chatbot/api.php',
		CURLOPT_HEADER			=> $options,
		CURLOPT_POST			=> true,
		CURLOPT_RETURNTRANSFER	=> true,
		CURLOPT_POSTFIELDS		=> $payload
	]);
	
	//Envia requisição
	$response = CURL_EXEC($ch);
	$code	  = CURL_GETINFO($ch, CURLINFO_HTTP_CODE);
	
	//Encerro a biblioteca curl
	CURL_CLOSE($ch);
}
?>

<html>

<head>
	<meta charset="UTF-8">
	<!-- <meta http-equiv="refresh" content="10"> -->
</head>

<body>
	<div id="chat"></div>
	<form method="POST" enctype="multipart/form-data">
		<label>Número: </label><input type="text" name="numero"></br>
		<label>Nome: </label><input type="text" name="nome"></br>
		<label>Mensagem: </label><input type="text" name="mensagem"></br>
		<button type="submit" name="submit">Enviar</button>
	</form>
</body>

<script type="text/javascript">
	function ajax(){
		var req = new XMLHttpRequest();
		req.onreadystatechange = function(){
			if (req.readyState == 4 && req.status == 200) {
					document.getElementById('chat').innerHTML = req.responseText;
			}
		}
		req.open('GET', 'mensagens.php', true);
		req.send();
	}

	setInterval(function(){ajax();}, 1000);
</script>

</html>