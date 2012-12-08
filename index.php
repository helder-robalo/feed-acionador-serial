<html>
<head>
	<title>Alert my sales</title>
	<META HTTP-EQUIV="Refresh" CONTENT="60">
</head>
<body>
	<?php
	$feed 		= file_get_contents('http://usuario:senha@dominio-feed.com.br/rss/order/new/'); //just put here your rss feed address
	$rss 		= new SimpleXmlElement($feed);

	$contador	= count($rss->channel->item);

	$arquivo 	= 'contador.txt';
	$ponteiro	= fopen($arquivo, 'r') or die("Erro1");
	$quantidade	= fread($ponteiro, filesize($arquivo));
	fclose($ponteiro);
	
	if($quantidade < $contador):
		//emite o disparo do alarme
		include "php-serial/php_serial.class.php";
		$serial = new phpSerial;
		$serial->deviceSet("COM6");
		$serial->deviceOpen();
		for ($i=0; $i <99 ; $i++):
			$serial->sendMessage("Vendeu"); //Message to send to your device
		endfor;
		$serial->deviceClose();

		//atualiza o arquivo
		$ponteiro	= fopen($arquivo, 'w') or die("Erro");
		fwrite($ponteiro, $contador);
		fclose($ponteiro);

		echo 'há uma nova venda: '; //feedback
	else:
		echo 'continuamos com esse total de vendas ';//feedback
	endif;
	echo $contador;
	
?>

</body>
</html>

<?php
// http://code.google.com/p/php-serial/ 

?>