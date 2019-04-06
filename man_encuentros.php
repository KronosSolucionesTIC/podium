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

$sql ="SELECT *,HOUR(h_ini_enc) as HI,MINUTE(h_ini_enc) as MI,SECOND(h_ini_enc) as SI,HOUR(h_fin_enc) as HF,MINUTE(h_fin_enc) as MF,SECOND(h_fin_enc) as SF FROM m_encuentro WHERE cod_enc = $codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS
  //CONCATENO LA HORA INICIAL
  $hora_ini = $_REQUEST['HI'].':'.$_REQUEST['MI'].':'.$_REQUEST['SI'];

  //CONCATENO LA HORA FINAL
  $hora_fin = $_REQUEST['HF'].':'.$_REQUEST['MF'].':'.$_REQUEST['SF'];

	$compos="(cod_cam,fec_enc,h_ini_enc,h_fin_enc,lug_enc,cat_enc)";
	$valores="('".$_REQUEST['campeonato']."','".$_REQUEST['fecha']."','".$hora_ini."','".$hora_fin."','".$_REQUEST['parque']."','".$_REQUEST['categoria']."')" ;
	$ins_id =insertar_maestro("m_encuentro",$compos,$valores); 

  if($ins_id > 0){

    for($ii = 1; $ii <= $_REQUEST['val_inicial']; $ii++){
      $compos="(cod_menc,cod_afi)";
      $valores="('".$ins_id."','".$_REQUEST['cod_afi_'.$ii]."')" ;
      $error = insertar("d_encuentro",$compos,$valores); 
    }

    header("Location: con_encuentros.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
  }

	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS
  //CONCATENO LA HORA INICIAL
  $hora_ini = $_REQUEST['HI'].':'.$_REQUEST['MI'].':'.$_REQUEST['SI'];

  //CONCATENO LA HORA FINAL
  $hora_fin = $_REQUEST['HF'].':'.$_REQUEST['MF'].':'.$_REQUEST['SF'];
	$compos="cod_cam='".$_REQUEST['campeonato']."',fec_enc='".$_REQUEST['fecha']."',h_ini_enc='".$hora_ini."',h_fin_enc='".$hora_fin."',lug_enc='".$_REQUEST['parque']."',cat_enc='".$_REQUEST['categoria']."'";
	$error=editar("m_encuentro",$compos,'cod_enc',$codigo); 

  $error=eliminar("d_encuentro",$codigo,"cod_menc");

  for($ii = 1; $ii <= $_REQUEST['val_inicial']; $ii++){
      $compos="(cod_menc,cod_afi)";
      $valores="('".$codigo."','".$_REQUEST['cod_afi_'.$ii]."')" ;
      $error = insertar("d_encuentro",$compos,$valores); 
  }

	if ($error==1) {
		header("Location: con_encuentros.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
<link href="css/styles.css" rel="stylesheet" type="text/css" /> 
<?php inicio() ?>
<script language="javascript">
function datos_completos(){  
if (document.getElementById('fecha').value == "" || document.getElementById('campeonato').value == "" )
	return false;
else
	return true;
}

function  adicion() 
{
  if(document.getElementById("afiliado").value>0) 
  {
    Agregar_html_afiliado();
    document.getElementById('afiliado').value = 0;  
  }
  else 
  {
    alert("Ingrese una Referencia Valida junto con los demas Valores")
  }

}

</script>
<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_encuentros.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td bgcolor="#FFF"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
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
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_encuentros.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform">&nbsp;</td>
        <td width="70" class="ctablaform">&nbsp;</td>
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
    <td class="textotabla2">ENCUENTROS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="tablacabezera" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textotabla1">Campeonato:</td>
        <td ><?php combo_evento_where("campeonato","campeonato","cod_cam","nom_cam",$dbdatos->cod_cam,""," where estado_cam = 1 order by nom_cam");?></td>
        <td ><span class="textorojo">*</span></td>
        <td ><span class="textotabla1">Fecha:</span></td>
        <td ><input name="fecha" type="text" class="fecha" id="fecha" value="<?php echo $dbdatos->fec_enc ?>" /><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td class="textorojo">*</td>
      </tr>
      <tr>
        <td class="textotabla1">Hora inicio:</td>
        <td><input name="HI" type="text" id="HI" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->HI?>"/>:<input name="MI" type="text" id="MI" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->MI?>"/>:<input name="SI" type="text" id="SI" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->SI?>"/></td>
        <td><span class="textorojo">*</span></td>
        <td><span class="textotabla1">Hora fin:</span></td>
        <td><input name="HF" type="text" id="HF" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->HF?>"/>:<input name="MF" type="text" id="MF" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->MF?>"/>:<input name="SF" type="text" id="SF" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->SF?>"/></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Parque o lugar:</td>
        <td><?php combo_evento_where("parque","parque","cod_par","nom_par",$dbdatos->lug_enc,""," where estado_par = 1 ORDER BY nom_par")?></td>
        <td>&nbsp;</td>
        <td><span class="textotabla1">Categoria:</span></td>
        <td><?php combo_evento_where("categoria","categoria","cod_cat","nom_cat",$dbdatos->cat_enc,""," where estado_cat = 1"); ?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <table width='100%'>
        <tr>
          <td class="ctablasup" width='70%'>Afiliado</td>
          <td class="ctablasup" align="center" width='30%'>Agregar:</td>
        </tr>
        <tr >
          <td ><?php combo_evento_where("afiliado","afiliado","cod_afi","CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi)","",""," where estado_afi = 1 ORDER BY nombre");  ?></td>
          <td align="center"><input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">      </td>
        </tr>
      </table>
      <table width="100%">
        <tr id="fila_0">
        <td  class="ctablasup" width='70%'>Afiliado</td>
          <td class="ctablasup" align="center" width='30%'>Borrar:</td>
        </tr>
        <?
        if ($codigo!=0) { // BUSCAR DATOS
          $sql =" SELECT * FROM d_encuentro
          INNER JOIN m_encuentro ON m_encuentro.cod_enc = d_encuentro.cod_menc
          INNER JOIN afiliado ON afiliado.cod_afi = d_encuentro.cod_afi
          where cod_enc = $codigo";//=    
          $dbdatos_1= new  Database();
          $dbdatos_1->query($sql);
          $jj=1;
          //echo "<table width='100%'>";
          while($dbdatos_1->next_row()){ 
            echo "<tr id='fila_$jj'>";
            
            //cmarca
            echo "<td  ><INPUT type='hidden'  name='cod_afi_$jj' id='cod_afi_$jj' value='$dbdatos_1->cod_afi'><span class='textfield01'>$dbdatos_1->nom1_afi $dbdatos_1->nom2_afi $dbdatos_1->apel1_afi $dbdatos_1->apel2_afi</span> </td>"; 
                       
            //boton q quita la fila
            if ($codigo != 0) {
            echo "<td><div align='center'><INPUT type='button' class='botones' value='  -  ' onclick='removerFila_afiliado(\"fila_$jj\",\"val_inicial\",\"fila_\");'>
            </div></td>";
            }
            echo "</tr>";
            $jj++;
          }
        }
        ?>
        </table>               
      <tr>
    <td>
  <input type="hidden" name="val_inicial" id="val_inicial" value="<?php if($codigo!=0) echo $jj-1; else echo "0"; ?>" />
     <?php  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
     <input type="hidden" id="valDoc_inicial" value="<?php echo $valueInicial?>"> 
     <input type="hidden" name="cant_items" id="cant_items" value=" <?php  if ($codigo!="") echo $aa; else echo "0"; ?>">
  </td>
  </tr>
  </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
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
</script> 
</body>
</html>