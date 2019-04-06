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

$sql ="SELECT *,HOUR(h_ini_enc) as HI,MINUTE(h_ini_enc) as MI,SECOND(h_ini_enc) as SI,HOUR(h_fin_enc) as HF,MINUTE(h_fin_enc) as MF,SECOND(h_fin_enc) as SF FROM m_encuentro WHERE cod_res = $codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS

  $compos="(cod_cam,cod_enc,del_enc,equi1_enc,equi2_enc,equi1_mar,equi2_mar)";
  $valores="('".$_REQUEST['campeonato']."','".$_REQUEST['encuentro']."','".$_REQUEST['profesor']."','".$_REQUEST['equi1']."','".$_REQUEST['equi2']."','".$_REQUEST['marcador1']."','".$_REQUEST['marcador2']."')" ;
  $ins_id =insertar_maestro("m_resultado",$compos,$valores); 

  $compos="(cod_cam,fec_enc,lug_enc,cat_enc)";
  $valores="('".$_REQUEST['campeonato']."','".$_REQUEST['fecha']."','".$_REQUEST['parque']."','".$_REQUEST['categoria']."')" ;
  $ins_id =insertar_maestro("m_encuentro",$compos,$valores); 

  if($ins_id > 0){

    for($ii = 1; $ii <= $_REQUEST['val_inicial']; $ii++){
      $compos="(cod_menc,cod_afi)";
      $valores="('".$ins_id."','".$_REQUEST['cod_afi_'.$ii]."')" ;
      $error = insertar("d_encuentro",$compos,$valores); 
    }

    header("Location: con_resultados.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
  $error=editar("m_encuentro",$compos,'cod_res',$codigo); 

  $error=eliminar("d_encuentro",$codigo,"cod_menc");

  for($ii = 1; $ii <= $_REQUEST['val_inicial']; $ii++){
      $compos="(cod_menc,cod_afi)";
      $valores="('".$codigo."','".$_REQUEST['cod_afi_'.$ii]."')" ;
      $error = insertar("d_encuentro",$compos,$valores); 
  }

  if ($error==1) {
    header("Location: con_resultados.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
//CARGA LOS ENCUENTROS DEL CAMPEONATO
function carga_encuentro(campeonato,encuentro){
var combo=document.getElementById(encuentro);
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione...','0'); 
cant++;
<?
    $i=0;
    $sqlc ="SELECT *,fecha.nom_fec as fecha FROM `d_programacion`
    INNER JOIN m_programacion ON m_programacion.cod_pro = d_programacion.cod_prog
    INNER JOIN fase ON fase.cod_fase = d_programacion.fase_dprog
    INNER JOIN fecha ON fecha.cod_fec = d_programacion.nom_fec";   
    $dbc= new  Database();
    $dbc->query($sqlc);
    while($dbc->next_row()){ 
    echo "if(document.getElementById(campeonato).value==$dbc->cam_pro){ "; 
    echo "combo.options[cant] = new Option('$dbc->nom_fase $dbc->fecha','$dbc->cod_dprog'); ";  
    echo "cant++; } ";
    }
?>
carga_nomina(campeonato);
}

//CARGA LOS EQUIPOS DEL ENCUENTRO
function carga_equipos(encuentro,equipo1,equipo2){
<?
    $sqle1 ="SELECT * FROM equipo
    INNER JOIN d_programacion ON d_programacion.equi1_dprog = equipo.cod_equi
    INNER JOIN m_programacion ON m_programacion.cod_pro = d_programacion.cod_prog";   
    $dbe1= new  Database();
    $dbe1->query($sqle1);
    while($dbe1->next_row()){ 
    echo "if(document.getElementById(encuentro).value==$dbe1->cod_dprog){ "; 
    echo "document.getElementById('equi1').value = '$dbe1->cod_equi'; ";  
    echo "document.getElementById(equipo1).value = '$dbe1->nom_equi'; ";  
    echo "} ";
    }
?>
<?
    $sqle2 ="SELECT * FROM equipo
    INNER JOIN d_programacion ON d_programacion.equi2_dprog = equipo.cod_equi
    INNER JOIN m_programacion ON m_programacion.cod_pro = d_programacion.cod_prog";   
    $dbe2= new  Database();
    $dbe2->query($sqle2);
    while($dbe2->next_row()){ 
    echo "if(document.getElementById(encuentro).value==$dbe2->cod_dprog){ "; 
    echo "document.getElementById('equi2').value = '$dbe2->cod_equi'; ";
    echo "document.getElementById(equipo2).value = '$dbe2->nom_equi'; ";  
    echo "} ";
    }
?>
}

//CARGA NOMINA
function carga_nomina(campeonato){
  var num = document.getElementById('val_inicial');

  if(num.value > 0){
    //VALIDA CUAL ES EL ULTIMO ID;
    for(i = 1; i <= num.value; i++){
      //REMUEVE EL NODO
      var fila = document.getElementById('fila_'+i);
      fila.parentNode.removeChild(fila);
    }
    document.getElementById('val_inicial').value = 0;
  }


<?php
  $db = new database();
  $sql = "SELECT d_nomina.cod_afi as codigo_afi ,cam_nom,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) AS nombre FROM m_nomina
  INNER JOIN d_nomina ON d_nomina.cod_nom = m_nomina.cod_nom
  INNER JOIN afiliado ON afiliado.cod_afi = d_nomina.cod_afi";
  $db->query($sql);
  while($db->next_row()){
    echo "if(document.getElementById(campeonato).value==$db->cam_nom){ "; 

    echo "var num = document.getElementById('val_inicial');"; 
    echo "var lastRow = document.getElementById('fila_' + num.value);"; 
    echo "var soloLectura = 'readonly';"; 

  echo "if(lastRow){"; 
    echo "num.value = parseInt(num.value) + 1;"; 
    echo "var newRow = document.createElement('tr');"; 
    echo "newRow.id = 'fila_' + num.value;   ";      

    echo "var td = document.createElement('td');"; 
    echo "td.innerHTML = '<INPUT type=\"hidden\" name=\"cod_afi_' + num.value + '\" value=\"$db->codigo_afi\"><div>$db->nombre</div>';"; 
    echo "newRow.appendChild(td);"; 

    echo "var td = document.createElement('td');"; 
    echo "td.innerHTML = '<input type=\"checkbox\" name=\"asistencia\" checked>';"; 
    echo "newRow.appendChild(td);"; 
    
    echo "lastRow.parentNode.insertBefore(newRow, lastRow.nextSibling);"; 
      
  echo "}";

    echo "} ";
  }
?>
}

function datos_completos(){  
if (document.getElementById('campeonato').value == 0 || document.getElementById('encuentro').value == 0 )
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
<form  name="forma" id="forma" action="man_resultados.php"  method="post">
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
        <td width="21" class="ctablaform"><a href="con_resultados.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
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
    <td class="textotabla2">RESULTADOS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="tablacabezera" valign="top">
  <table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textotabla1">Campeonato:</td>
        <td ><?php combo_evento_where("campeonato","campeonato","cod_cam","nom_cam",$dbdatos->cod_cam,"onchange='carga_encuentro(\"campeonato\",\"encuentro\")'"," where estado_cam = 1 order by nom_cam");?></td>
        <td ><span class="textorojo">*</span></td>
        <td ></td>
        <td ></td>
        <td class="textorojo"></td>
      </tr>
      <tr>
        <td class="textotabla1">Encuentro:</td>
        <td >
        <?php 
        //CONSULTA LOS PARTIDOS PROGRAMADOS
        $sql="SELECT *,d_programacion.cod_prog as cod, CONCAT(nom_fase,' ',fecha.nom_fec) as nombre  FROM d_programacion 
        INNER JOIN fecha ON fecha.cod_fec = d_programacion.nom_fec
        INNER JOIN fase ON fase.cod_fase = d_programacion.fase_dprog";
        combo_sql_evento("encuentro","","cod","nombre","",$sql,"onchange='carga_equipos(\"encuentro\",\"equipo1\",\"equipo2\")'");  ?></td>
        <td ><span class="textorojo">*</span></td>
        <td ><span class="textotabla1">Delegado:</span></td>
        <td ><?php combo_evento_where("profesor","profesor","cod_pro","CONCAT(nom1_pro,' ',nom2_pro,' ',apel1_pro,' ',apel2_pro)",$dbdatos->cod_pro,""," where estado_pro = 1 order by nombre");?></td>
        <td class="textorojo">*</td>
      </tr>
      <tr>
        <td class="textotabla1">Equipo A:</td>
        <td><input name="equi1" id="equi1" type="hidden" /><input name="equipo1" id="equipo1" type="text" class="textfield2" readonly='readonly' value="<?php echo $dbdatos->nom_usu?>" /></td>
        <td><span class="textorojo">*</span></td>
        <td><span class="textotabla1">Equipo B:</span></td>
        <td><input name="equi2" id="equi2" type="hidden" /><input name="equipo2" id="equipo2" type="text" class="textfield2"  readonly='readonly' value="<?php echo $dbdatos->nom_usu?>" /></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">MARCADOR:</td>
        <td><input name="marcador1" type="text" id="marcador1" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->HI?>"/></td>
        <td><span class="textorojo">*</span></td>
        <td><span class="textotabla1">MARCADOR:</span></td>
        <td><input name="marcador2" type="text" id="marcador2" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->HF?>"/></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Fecha:</td>
        <td ><input name="fecha" type="text" class="fecha" id="fecha" value="<?php echo $dbdatos->fec_enc ?>" /><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td ><span class="textorojo">*</span></td>
        <td ></td>
        <td ></td>
        <td ></td>
      </tr>
      <tr>
        <td class="textotabla1">Parque o lugar:</td>
        <td><?php combo_evento_where("parque","parque","cod_par","nom_par",$dbdatos->lug_enc,""," where estado_par = 1 ORDER BY nom_par")?></td>
        <td class="textorojo">*</td>
        <td><span class="textotabla1">Categoria:</span></td>
        <td><?php combo_evento_where("categoria","categoria","cod_cat","nom_cat",$dbdatos->cat_enc,""," where estado_cat = 1"); ?></td>
        <td class="textorojo">*</td>
      </tr>
      <tr id='fila_0'>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>             
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
    <td colspan='6'><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
  </td>
  </tr>
</table>
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
</form> 
</body>
</html>