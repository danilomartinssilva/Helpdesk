<?php
session_start();
$dataServer = array(
	'nome_cadadm' => $_SESSION["dadosAtendente"]["nome_cadadm"],
    'id_cadadm' => (int) $_SESSION["dadosAtendente"]["id_cadadm"]
);
echo 'window.dataServer = '.json_encode($dataServer);
?>
