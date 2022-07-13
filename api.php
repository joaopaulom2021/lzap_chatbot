<?php
//Conecta-se a base de dados
$con = mysqli_connect('localhost', 'root', '', 'lzap_chatbot') OR die(__FILE__.': Erro->falha ao conectar a base de dados | Linha->'.__LINE__);

//Pega tipo da requisição
$method = $_SERVER['REQUEST_METHOD'];

//Verifica tipo da requisição
switch($method)
{
	CASE 'POST':
		//Pega dados brutos da requisição
		$json = file_get_contents ('php://input');
		
		//Converte em objeto PHP
		$data = json_decode($json);
		
		//Trata requisição
		redirectRequest($con, $data);
		break;
}

function redirectRequest($con, $data)
{
	//Pega dados
	$id_mensagem   = $data->Body->Info->Id;
	$id_chat	   = $data->Body->Info->RemoteJid;
	$numero		   = substr($id_chat, 0, strpos($id_chat, '@'));
	$nome		   = $data->Body->Info->PushName;
	$envio		   = $data->Body->Info->Timestamp;
	$envio		   = date('Y-m-d H:i:s', $envio);
	$mensagem	   = $data->Body->Text;
	$id_mencionado = $data->Body->ContextInfo->QuotedMessageID;
	
	//Pega chat
	$sql_chat = mysqli_fetch_assoc(mysqli_query($con, "SELECT *, COUNT(*) AS qtd FROM whats_chat WHERE id_chat LIKE '%".$numero."%'"));
	$res_chat = $sql_chat['qtd'];
	
	//Pega mensagens do bot
	$sql_chatbot 	= mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM chatbot WHERE empresa = '47'"));
	$pedir_nome  	= $sql_chatbot['pedir_nome'];
	$pedir_email 	= $sql_chatbot['pedir_email'];
	$opcoes		 	= $sql_chatbot['opcoes'];
	$pedir_assunto  = $sql_chatbot['pedir_assunto'];
	$despedida	    = $sql_chatbot['despedida'];
	
	//Verifica se chat existe
	if($res_chat != '0')
	{
		//Verifica qual a fase
		switch($sql_chat['fase'])
		{
			CASE 'pedir_email':
			
				//Insere mensagem do cliente no chat
				mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".$id_mensagem."', '".$id_chat."', 'chat', '".$mensagem."', 'N', '".$envio."', NOW())");
			
				//Delay na execução
				sleep(3);
				
				//Insere mensagem do bot no chat
				mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".bin2hex(date("YmdHis").basename(__FILE__))."', '".$id_chat."', 'chat', '".$pedir_email."', 'S', '".date('Y-m-d H:i:s')."', NOW())");
		
				//Atualiza chat
				mysqli_query($con, "UPDATE whats_chat SET fase = 'opcoes', envio = '".$envio."' WHERE id_chat LIKE '%".$numero."%'");
				break;
				
			CASE 'opcoes':
			
				//Insere mensagem do cliente no chat
				mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".$id_mensagem."', '".$id_chat."', 'chat', '".$mensagem."', 'N', '".$envio."', NOW())");
			
				//Delay na execução
				sleep(3);
				
				//Insere mensagem do bot no chat
				mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".bin2hex(date("YmdHis").basename(__FILE__))."', '".$id_chat."', 'chat', '".$opcoes."', 'S', '".date('Y-m-d H:i:s')."', NOW())");
		
				//Atualiza chat
				mysqli_query($con, "UPDATE whats_chat SET fase = 'pedir_assunto', envio = '".$envio."' WHERE id_chat LIKE '%".$numero."%'");
				break;
				
			CASE 'pedir_assunto':
			
				//Insere mensagem do cliente no chat
				mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".$id_mensagem."', '".$id_chat."', 'chat', '".$mensagem."', 'N', '".$envio."', NOW())");
			
				//Delay na execução
				sleep(3);
				
				//Insere mensagem do bot no chat
				mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".bin2hex(date("YmdHis").basename(__FILE__))."', '".$id_chat."', 'chat', '".$pedir_assunto."', 'S', '".date('Y-m-d H:i:s')."', NOW())");
		
				//Atualiza chat
				mysqli_query($con, "UPDATE whats_chat SET fase = 'despedida', envio = '".$envio."' WHERE id_chat LIKE '%".$numero."%'");
				break;
				
			CASE 'despedida':
			
				//Insere mensagem do cliente no chat
				mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".$id_mensagem."', '".$id_chat."', 'chat', '".$mensagem."', 'N', '".$envio."', NOW())");
			
				//Delay na execução
				sleep(3);
				
				//Insere mensagem do bot no chat
				mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".bin2hex(date("YmdHis").basename(__FILE__))."', '".$id_chat."', 'chat', '".$despedida."', 'S', '".date('Y-m-d H:i:s')."', NOW())");
		
				//Atualiza chat
				mysqli_query($con, "UPDATE whats_chat SET fase = 'atendimento', envio = '".$envio."' WHERE id_chat LIKE '%".$numero."%'");
				break;
		}
		
	} else{
		
		//Cria novo chat
		mysqli_query($con, "INSERT INTO whats_chat(empresa, id_chat, nome, envio, fase, data_sync) VALUES ('47', '".$id_chat."', '".$nome."', '".$envio."', 'pedir_email', NOW())");
		
		//Insere mensagem do cliente no chat
		mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".$id_mensagem."', '".$id_chat."', 'chat', '".$mensagem."', 'N', '".$envio."', NOW())");
	
		//Delay na execução
		sleep(3);
		
		//Insere mensagem do bot no chat
		mysqli_query($con, "INSERT INTO whats_mensagem (empresa, id_mensagem, id_chat, tipo, mensagem, minha, envio, data_sync) VALUES ('47', '".bin2hex(date("YmdHis").basename(__FILE__))."', '".$id_chat."', 'chat', '".$pedir_nome."', 'S', '".date('Y-m-d H:i:s')."', NOW())");
	}
}