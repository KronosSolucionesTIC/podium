<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="calendario/javascript/calendar.js"></script>
<script type="text/javascript" src="calendario/javascript/calendar-es.js"></script>
<script type="text/javascript" src="calendario/javascript/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="calendario/styles/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script src="utilidades.js" type="text/javascript"> </script>
<title>
<?php echo $nombre_aplicacion?>
</title>
<script type="text/javascript">
var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function abrir() {	 // cierre normal	
		var cod_afi = document.getElementById('afiliado').value;
    var fec_ini = document.getElementById('fec_ini').value;
    var fec_fin = document.getElementById('fec_fin').value;
		imprimir_inf("inf_estado_cuenta.php",'0&cod_afi='+cod_afi+'&fec_ini='+fec_ini+'&fec_fin='+fec_fin,'grande');
}
</script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="informes/inf.js"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body  <?php echo $sis?> >
<table align="center">
  <tr>
    <td valign="top" ><table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
        <tr>
          <td><table width="587" border="0"  cellpadding="0" align="center">
              <tr>
                <td colspan="4"  class="ctablasup" >INFORME DE ESTADO DE CUENTA</td>
              </tr>
              <?php 
						$estilo="ctablablanc";
						$estilo="ctablagris";					
						if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> ";
						?>
              <tr>
                <td width="25%" class="ctablablanc" >Afiliados</td>
                <td width="75%" class="ctablablanc" colspan = '3'><?php combo_evento_where("afiliado","afiliado","cod_afi","CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi)","",""," where estado_afi = 1 ORDER BY nombre");  ?></td>
              </tr>
              <tr>
                <td width="15%" class="ctablablanc" >Fecha Inicial</td>
                <td width="30%" class="ctablablanc" ><input name="fecha" type="text" class="textotabla01" id="fec_ini" readonly  /><img src="imagenes/date.png" alt="Calendario" name="imageField" width="16" height="16" border="0" id="imageField" style="cursor:pointer"/></td>
                <td width="15%" class="ctablablanc" >Fecha Final</td>
                <td width="30%" class="ctablablanc" ><input name="fec_fin" type="text" class="textotabla01" id="fec_fin" readonly  /><img src="imagenes/date.png" alt="Calendario" name="imageField1" width="16" height="16" border="0" id="imageField1" style="cursor:pointer"/></td>
              </tr>
               <tr>
                <td width="25%" class="ctablasup" colspan='2'>Informe General</td>
                <td width="25%" class="ctablablanc" colspan='2'><img src='imagenes/mirar.png' alt="." width='16' height='16'  style="cursor:pointer"  onClick="abrir()" /></td>
              </tr>
            </table ></td>
        </tr>
        <tr>
          <td><img src="imagenes/lineasup3.gif" width="624" height="4" /></td>
        </tr>
        <tr>
          <td height="30" align="center" valign="bottom"></td>
        </tr>
      </table></td>
  </tr>
</table>
<script type="text/javascript">
Calendar.setup(
  {
  inputField  : "fec_ini",      // ID of the input field
  ifFormat    : "%Y-%m-%d",    // the date format
  button      : "imageField" ,   // ID of the button
  //align       :"T2",
  singleClick :true
  }
);

Calendar.setup(
  {
  inputField  : "fec_fin",      // ID of the input field
  ifFormat    : "%Y-%m-%d",    // the date format
  button      : "imageField1" ,   // ID of the button
  //align       :"T2",
  singleClick :true
  }
);
</script>
</body>
</html>