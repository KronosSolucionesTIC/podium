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
	  $sql ="SELECT * FROM proveedor WHERE cod_prov= $codigo";
		$dbdatos= new  Database();
		$dbdatos->query($sql);
		$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS

	$campos="(nom1_prov,nom2_prov,apel1_prov,apel2_prov,tiden_prov,id_prov,dir_prov,tel_prov,cel1_prov,cel2_prov,dep_prov,ciu_prov,email_prov)";
	
	 $valores="('".$_REQUEST['nombre1']."','".$_REQUEST['nombre2']."','".$_REQUEST['apellido1']."', '".$_REQUEST['apellido2']."','".$_REQUEST['tipo_id']."','".$_REQUEST['iden']."','".$_REQUEST['direccion']."','".$_REQUEST['telefono']."','".$_REQUEST['celular1']."','".$_REQUEST['celular2']."','".$_REQUEST['departamento']."','".$_REQUEST['ciudad']."','".$_REQUEST['correo']."')" ;  
	
	$error=insertar("proveedor",$campos,$valores); 
	
	if ($error==1) {
		header("Location: con_proveedor.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA EDITAR REGISTROS 

	$campos="nom1_prov='".$_REQUEST['nombre1']."',nom2_prov='".$_REQUEST['nombre2']."', apel1_prov='".$_REQUEST['apellido1']."', apel2_prov='".$_REQUEST['apellido2']."',tiden_prov='".$_REQUEST['tipo_id']."',id_prov='".$_REQUEST['iden']."', dir_prov='".$_REQUEST['direccion']."',tel_prov='".$_REQUEST['telefono']."',cel1_prov='".$_REQUEST['celular1']."', cel2_prov='".$_REQUEST['celular2']."', dep_prov='".$_REQUEST['departamento']."', ciu_prov='".$_REQUEST['ciudad']."', email_prov= '".$_REQUEST['correo']."'";
	
	$error=editar("proveedor",$campos,'cod_prov',$codigo); 
	if ($error==1) {
		
		header("Location: con_proveedor.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
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
  if(document.getElementById('nombre1').value == ""){
    return false;
  }
	return true;
}

function cargar_ciudad(departamento,ciudad) {
var combo=document.getElementById(ciudad);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione...','0'); 
cant++;
<?
		$i=0;
		$sqlc ="SELECT * FROM `ciudad` ";		
		$dbc= new  Database();
		$dbc->query($sqlc);
		while($dbc->next_row()){ 
		echo "if(document.getElementById(departamento).value==$dbc->departamento){ ";	
		echo "combo.options[cant] = new Option('$dbc->desc_ciudad','$dbc->cod_ciudad'); ";	
		echo "cant++; } ";
		}
?>
}

function cargar_localidad(ciudad,localidad) {
var combo=document.getElementById(localidad);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione...','0'); 
cant++;
<?
    $i=0;
    $sqlc ="SELECT * FROM `localidad` ";    
    $dbc= new  Database();
    $dbc->query($sqlc);
    while($dbc->next_row()){ 
    echo "if(document.getElementById(ciudad).value==$dbc->ciu_loc){ ";  
    echo "combo.options[cant] = new Option('$dbc->nom_loc','$dbc->cod_loc'); "; 
    echo "cant++; } ";
    }
?>
}
</script>

</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_proveedor.php"  method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
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
         <td width="5" height="19">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nuevo Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_proveedor.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle"><label>
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
    <td class="textotabla1 Estilo1">proveedor:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textotabla1">Primer nombre:</td>
        <td><input name="nombre1" id="nombre1" type="text" class="textfield2"  value="<?php echo $dbdatos->nom1_prov?>" /></td>
        <td align="left" class="textorojo">*</td>
        <td class="textotabla1">Segundo nombre:</td>
        <td><input name="nombre2" id="nombre2" type="text" class="textfield2" value="<?php echo $dbdatos->nom2_prov?>"  /><span class="textorojo"></span></td>
        <td  class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Primer apellido:</td>
        <td><input name="apellido1" id="apellido1" type="text" class="textfield2"  value="<?php echo $dbdatos->apel1_prov?>" /></td>
        <td class="textorojo">*</td>
        <td class="textotabla1">Segundo apellido:</td>
        <td><input name="apellido2" id="apellido2" type="text" class="textfield2"  value="<?php echo $dbdatos->apel2_prov?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Tipo ID:</td>
        <td><?php combo_evento_where("tipo_id","tipo_identificacion","cod_tiden","nom_tiden",$dbdatos->tiden_prov,""," where estado_tiden = 1 order by nom_tiden"); ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">No identificacion:</td>
        <td><input name="iden" id="iden" type="text" class="textfield2"  onkeypress="return validaInt_evento(this)"  value="<?php echo $dbdatos->id_prov?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Direccion:</td>
        <td><input name="direccion" id="direccion" type="text" class="textfield2"  value="<?php echo $dbdatos->dir_prov?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Telefono:</td>
        <td><input name="telefono" id="telefono" type="text" class="textfield2"  value="<?php echo $dbdatos->tel_prov?>" /></td>
        <td class="textorojo">&nbsp;</td>
        </tr>
      <tr>
        <td class="textotabla1">Celular 1:</td>
        <td><input name="celular1" id="celular1" type="text" class="textfield2"  value="<?php echo $dbdatos->cel1_prov?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Celular 2:</td>
        <td><input name="celular2" id="celular2" type="text" class="textfield2"  value="<?php echo $dbdatos->cel2_prov?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Departamento:</td>
        <td><?php combo_evento("departamento","departamento","cod_departamento","desc_departamento",$dbdatos->dep_prov,"onchange='cargar_ciudad(\"departamento\",\"ciudad\")'","desc_departamento"); ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Ciudad:</td>
        <td><?php combo_evento_where("ciudad","ciudad","cod_ciudad","desc_ciudad",$dbdatos->ciu_prov,"","");?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">E-mail:</td>
        <td><input name="correo" id="correo" type="text" class="textfield2"  value="<?php echo $dbdatos->email_prov?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1"></td>
        <td></td>
        <td class="textorojo">&nbsp;</td>
      </tr>		
	  	  <tr>
        <td colspan="6" valign="bottom"></td>
        </tr>
    </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
	</td>
  </tr>
</table>
</form>
</body>
</html>