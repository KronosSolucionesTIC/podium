<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if ($codigo!=0) {
	  $sql ="SELECT * FROM afiliado WHERE cod_afi= $codigo";
		$dbdatos= new  Database();
		$dbdatos->query($sql);
		$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS

  //GUARDA LA FOTO
  $ruta = "fotos";
  $archivo = $_FILES['imagen']['tmp_name'];
  $nombre_archivo = $_FILES['imagen']['name'];

  move_uploaded_file($archivo, $ruta."/".$nombre_archivo);
  $ruta = $ruta."/".$nombre_archivo;
  //
  if($ruta == "fotos/"){
    $ruta = "";
  }

 
	$campos="(linea_afi,nom1_afi,nom2_afi,apel1_afi,apel2_afi,tiden_afi,id_afi,dir_afi,tel_afi,cel1_afi,cel2_afi,dep_afi,ciu_afi,
          loc_afi,rh_afi,email_afi,cat_afi,eps_afi,fnac_afi,fins_afi,foto_afi,copia_eps,copia_doc,talla_afi,pos_afi,dorsal_afi,peso_afi,estatura_afi)";
	
	$valores="('".$_REQUEST['linea']."','".$_REQUEST['nombre1']."','".$_REQUEST['nombre2']."','".$_REQUEST['apellido1']."',
    '".$_REQUEST['apellido2']."','".$_REQUEST['tipo_id']."','".$_REQUEST['iden']."','".$_REQUEST['direccion']."',
    '".$_REQUEST['telefono']."','".$_REQUEST['celular1']."','".$_REQUEST['celular2']."','".$_REQUEST['departamento']."',
    '".$_REQUEST['ciudad']."','".$_REQUEST['localidad']."','".$_REQUEST['rh_afi']."','".$_REQUEST['correo']."',
    '".$_REQUEST['categoria']."','".$_REQUEST['eps']."','".$_REQUEST['fecha']."','".$_REQUEST['fecha_ins']."',
    '".$_REQUEST['ruta']."','".$_REQUEST['eps']."','".$_REQUEST['doc']."','".$_REQUEST['talla']."','".$_REQUEST['posicion']."','".$_REQUEST['dorsal']."','".$_REQUEST['peso']."','".$_REQUEST['estatura']."')" ;  
	
	$error=insertar("afiliado",$campos,$valores); 
	
	if ($error==1) {
		header("Location: con_afiliado.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA EDITAR REGISTROS 
  
  if($dbdatos->foto_afi != ""){
  }
  else{
    //GUARDA LA FOTO
    $ruta = "fotos";
    $archivo = $_FILES['imagen']['tmp_name'];
    $nombre_archivo = $_FILES['imagen']['name'];

    move_uploaded_file($archivo, $ruta."/".$nombre_archivo);
    $ruta = $ruta."/".$nombre_archivo;
    //
    if($ruta == "fotos/"){
      $ruta = "";
    }

    $campos = "foto_afi = '".$ruta."'";
    $error=editar("afiliado",$campos,'cod_afi',$codigo);
  }

	$campos="linea_afi='".$_REQUEST['linea']."',nom1_afi='".$_REQUEST['nombre1']."',nom2_afi='".$_REQUEST['nombre2']."', 
  apel1_afi='".$_REQUEST['apellido1']."', apel2_afi='".$_REQUEST['apellido2']."',tiden_afi='".$_REQUEST['tipo_id']."',
  id_afi='".$_REQUEST['iden']."', dir_afi='".$_REQUEST['direccion']."',tel_afi='".$_REQUEST['telefono']."',
  cel1_afi='".$_REQUEST['celular1']."', cel2_afi='".$_REQUEST['celular2']."', dep_afi='".$_REQUEST['departamento']."',
   ciu_afi='".$_REQUEST['ciudad']."', loc_afi='".$_REQUEST['localidad']."', rh_afi='".$_REQUEST['rh_afi']."', 
   email_afi= '".$_REQUEST['correo']."', cat_afi= '".$_REQUEST['categoria']."', eps_afi= '".$_REQUEST['eps']."', 
   fnac_afi = '".$_REQUEST['fecha']."' , fins_afi = '".$_REQUEST['fecha_ins']."' ,copia_eps='".$_REQUEST['copia_eps']."',
   copia_doc='".$_REQUEST['doc']."', talla_afi ='".$_REQUEST['talla']."', pos_afi ='".$_REQUEST['posicion']."', dorsal_afi ='".$_REQUEST['dorsal']."', peso_afi ='".$_REQUEST['peso']."', estatura_afi ='".$_REQUEST['estatura']."'";
	
	$error=editar("afiliado",$campos,'cod_afi',$codigo); 
	if ($error==1) {
		
		header("Location: con_afiliado.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
  if(document.getElementById('linea').value == 0 || document.getElementById('nombre1').value == "" || document.getElementById('apellido1').value == "" || document.getElementById('tipo_id').value == 0 || document.getElementById('iden').value == "" ){
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
<body <?=$sis?>>
<form  name="forma" id="forma" action="man_afiliado.php"  method="post" enctype="multipart/form-data">
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
        <td width="21" class="ctablaform"><a href="con_afiliado.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle"><label>
          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
        </label></td>
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla1 Estilo1">AFILIADOS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textotabla1">Linea:</td>
        <td><?php combo_evento_where("linea","linea","cod_linea","nom_linea",$dbdatos->linea_afi,""," where estado_linea = 1");?></td>
        <td align="left" class="textorojo">*</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td class="textotabla1">Primer nombre:</td>
        <td><input name="nombre1" id="nombre1" type="text" class="textfield2"  value="<?=$dbdatos->nom1_afi?>" /></td>
        <td align="left" class="textorojo">*</td>
        <td class="textotabla1">Segundo nombre:</td>
        <td><input name="nombre2" id="nombre2" type="text" class="textfield2" value="<?=$dbdatos->nom2_afi?>"  />
        <span class="textorojo"></span></td>
      </tr>
      <tr>
        <td class="textotabla1">Primer apellido:</td>
        <td><input name="apellido1" id="apellido1" type="text" class="textfield2"  value="<?=$dbdatos->apel1_afi?>" /></td>
        <td class="textorojo">*</td>
        <td class="textotabla1">Segundo apellido:</td>
        <td><input name="apellido2" id="apellido2" type="text" class="textfield2"  value="<?=$dbdatos->apel2_afi?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Tipo ID:</td>
        <td><?php combo_evento_where("tipo_id","tipo_identificacion","cod_tiden","nom_tiden",$dbdatos->tiden_afi,""," where estado_tiden = 1 order by nom_tiden"); ?></td>
        <td class="textorojo">*</td>
        <td class="textotabla1">No identificacion:</td>
        <td><input name="iden" id="iden" type="text" class="textfield2"  onkeypress="return validaInt_evento(this)"  value="<?=$dbdatos->id_afi?>" /></td>
        <td class="textorojo">*</td>
      </tr>
      <tr>
        <td class="textotabla1">Direccion:</td>
        <td><input name="direccion" id="direccion" type="text" class="textfield2"  value="<?=$dbdatos->dir_afi?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Telefono:</td>
        <td><input name="telefono" id="telefono" type="text" class="textfield2"  value="<?=$dbdatos->tel_afi?>" /></td>
        <td class="textorojo">&nbsp;</td>
        </tr>
      <tr>
        <td class="textotabla1">Celular 1:</td>
        <td><input name="celular1" id="celular1" type="text" class="textfield2"  value="<?=$dbdatos->cel1_afi?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Celular 2:</td>
        <td><input name="celular2" id="celular2" type="text" class="textfield2"  value="<?=$dbdatos->cel2_afi?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Departamento:</td>
        <td><?php combo_evento("departamento","departamento","cod_departamento","desc_departamento",$dbdatos->dep_afi,"onchange='cargar_ciudad(\"departamento\",\"ciudad\")'","desc_departamento"); ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Ciudad:</td>
        <td><?php combo_evento_where("ciudad","ciudad","cod_ciudad","desc_ciudad",$dbdatos->ciu_afi,"","");?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
          <td class="textotabla1">Localidad:</td>
          <td><?php combo_evento("localidad","localidad","cod_loc","nom_loc",$dbdatos->loc_afi,"","nom_loc"); ?></td>
          <td class="textorojo">&nbsp;</td>
          <td class="textotabla1">Tipo de sangre:</td>
          <td><input name="rh_afi" id="rh_afi" type="text" class="textfield2"  value="<?=$dbdatos->rh_afi?>" /></td>
          <td></td>
      </tr>
      <tr>
        <td class="textotabla1">E-mail:</td>
        <td><input name="correo" id="correo" type="text" class="textfield2"  value="<?=$dbdatos->email_afi?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">EPS:</td>
        <td><?php combo_evento_where("eps","eps","cod_eps","nom_eps",$dbdatos->eps_afi,""," where estado_eps = 1 ORDER BY nom_eps"); ?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>		
      <tr>
        <td class="textotabla1">Categoria:</td>
        <td><?php combo_evento_where("categoria","categoria","cod_cat","nom_cat",$dbdatos->cat_afi,""," where estado_cat = 1"); ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">FOTO:</td>
        <td><input type='file' name='imagen' /><?php if($dbdatos->foto_afi != ""){?><img src="<?=$dbdatos->foto_afi?>" width='113' height='151'><?php } else {?><label>Sin foto:</label><?php } ?></td>
        <td class="textorojo">&nbsp;</td>
      </tr> 
      <tr>
        <td class="textotabla1">Fecha nacimiento:</td>
        <td><input name="fecha" type="text" class="fecha" id="fecha" value="<?=$dbdatos->fnac_afi ?>" /><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Fecha inscripcion:</td>
        <td><input name="fecha_ins" type="text" class="fecha" id="fecha_ins" value="<?=$dbdatos->fins_afi ?>" /><img src="imagenes/date.png" alt="Calendario" name="calendario2" width="16" height="16" border="0" id="calendario2" style="cursor:pointer"/></td>
        <td></td>
      </tr> 
      <tr>
        <td class="textotabla1">COPIA EPS:</td>
        <td><input type='checkbox' id='copia_eps' name='copia_eps' <?php if($dbdatos->copia_eps == 'on'){?> checked='true'> <?php } ?></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">COPIA DOCUMENTO:</td>
        <td><input type='checkbox' id='doc' name='doc' <?php if($dbdatos->copia_doc == 'on'){?> checked='true'> <?php } ?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">TALLA:</td>
        <td><?php combo_evento_where("talla","talla","cod_talla","nom_talla",$dbdatos->talla_afi,""," where estado_talla = 1 ORDER BY nom_talla"); ?></td>
        <td>&nbsp;</td>
        <td class="textotabla1">POSICION:</td>
        <td><?php combo_evento_where("posicion","posicion","cod_posicion","nom_posicion",$dbdatos->pos_afi,""," where estado_posicion = 1 ORDER BY nom_posicion"); ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">PESO:</td>
        <td><input type="number" name="peso" id="peso" value="<?php echo $dbdatos->peso_afi ?>" ?></td>
        <td>&nbsp;</td>
        <td class="textotabla1">ESTATURA:</td>
       <td><input type="number" name="estatura" id="estatura" value="<?php echo $dbdatos->estatura_afi ?>" ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">DORSAL:</td>
        <td><input type="number" name="dorsal" id="dorsal" value="<?php echo $dbdatos->dorsal_afi ?>" ?></td>
        <td>&nbsp;</td>
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
<script type="text/javascript">
    Calendar.setup(
      {
      inputField  : "fecha",      
      ifFormat    : "%Y-%m-%d",    
      button      : "calendario" ,  
      align       :"T3",
      singleClick :true
      }
    );

    Calendar.setup(
      {
      inputField  : "fecha_ins",      
      ifFormat    : "%Y-%m-%d",    
      button      : "calendario2" ,  
      align       :"T3",
      singleClick :true
      }
    );
</script> 
</body>
</html>