<?
include "lib/sesion.php";
include("lib/database.php");
include("js/funciones.php");	

	$db = new Database();
	$sql = "SELECT * FROM afiliado
	WHERE cod_afi = '33'";
	$db->query($sql);
	while($db->next_row()){
		enviar_alerta2($asunto,$mensaje);
	}
?>