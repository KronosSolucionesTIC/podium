<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if ($codigo!=0) {

$sql ="SELECT *  FROM parque WHERE cod_par=$codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS

	$campos="(nom_par,dir_par,loc_par,cod_est)";
	$valores="('".$_REQUEST['nombre']."','".$_REQUEST['dir']."','".$_REQUEST['localidad']."','".$_REQUEST['cod_est']."')" ;
	$error=insertar("parque",$campos,$valores); 

	if ($error==1) {
		header("Location: con_parque.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS
	$compos="nom_par='".$_REQUEST['nombre']."',dir_par='".$_REQUEST['dir']."',loc_par='".$_REQUEST['localidad']."',cod_est='".$_REQUEST['cod_est']."'";
	$error=editar("parque",$compos,'cod_par',$codigo); 
	//echo $error; exit;
	if ($error==1) {
		header("Location: con_parque.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {font-size: 12px}
</style> 

<?php inicio() ?>

<script language="javascript">
function datos_completos(){  
if (document.getElementById('nombre').value == "" || document.getElementById('dir').value == "" )
	return false;
else
	return true;
}
</script>

</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_parque.php"  method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td ><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
         <td height="19">&nbsp;</td>
        <td><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>
        <td class="ctablaform">Guardar</td>
        <td class="ctablaform"><a href="con_parque.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td class="ctablaform">Cancelar </td>
        <td class="ctablaform"></td>
        <td class="ctablaform">&nbsp;</td>
        <td Valign="middle" class="ctablaform">&nbsp;</td>
        <td valign="middle"><label>
          <input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" />
        </label></td>
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla1 Estilo1">PARQUES O LUGARES:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td  valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textotabla1">Nombre:</td>
        <td><input name="nombre" id="nombre" type="text" class="textfield2"  value="<?php echo $dbdatos->nom_par?>" /></td>
        <td><span class="textorojo">*</span></td>
        <td><span class="textotabla1">Direccion:</span></td>
        <td><input name="dir" type="text" class="textfield2" id="dir"  value="<?php echo $dbdatos->dir_par?>" /></td>
        <td class="textorojo">*</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
          <td class="textotabla1">Localidad:</td>
          <td><?php combo_evento("localidad","localidad","cod_loc","nom_loc",$dbdatos->loc_par,"","nom_loc"); ?></td>
          <td class="textorojo">&nbsp;</td>
          <td class="textotabla1"></td>
          <td></td>
      </tr
      <tr>
        <td class="textotabla1">Codigo estatal:</td>
        <td><input name="cod_est" type="text" class="textfield2" id="cod_est" value="<?php echo $dbdatos->cod_est?>"/></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="textorojo">*</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
	</td>
  </tr>
</table>
</form> 
</body>
</html>