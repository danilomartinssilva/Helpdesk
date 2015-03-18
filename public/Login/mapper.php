<?php
$url = __DIR__;
 if(substr_count($url,"HelpDesk")>0){
            	$endereco = "/helpdesk/public/";
            	 
            }
            else{
            	$endereco = "/~hepshego/";
            }
            $url = $endereco;
    $dataServer = array(                
                'endereco' =>($endereco),
                //'id_cadcli' =>($idAdministrador),
                //'url'=>($endereco)    
            );
            $json = json_encode($dataServer);
            echo "window.dataServerUsuario ={$json}";

?>