<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<html>
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
    var cod_cat = document.getElementById('categoria').value;
		imprimir_inf("inf_afiliados.php",'0&cod_afi='+cod_afi+'&cod_cat='+cod_cat,'grande');
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
                <td colspan="4"  class="ctablasup" >INFORME DE AFILIADOS</td>
              </tr>
              <?php 
						$estilo="ctablablanc";
						$estilo="ctablagris";					
						if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> ";
						?>
              <tr>
                <td width="25%" class="ctablablanc" >Afiliados</td>
                <td width="25%" class="ctablablanc" ><?php combo_evento_where("afiliado","afiliado","cod_afi","CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi)","",""," where estado_afi = 1 ORDER BY nombre");  ?></td>
                <td width="25%" class="ctablablanc">Categoria</td>
                <td width="25%" class="ctablablanc" ><?php combo_evento_where("categoria","categoria","cod_cat","nom_cat",$dbdatos->cat_ent,""," where estado_cat = 1"); ?></td>
              </tr>
               <tr>
                <td width="25%" class="ctablasup" colspan='2'>Informe General</td>
                <td width="25%" class="ctablablanc" ><img src='imagenes/mirar.png' alt="." width='16' height='16'  style="cursor:pointer"  onClick="abrir()" /></td>
              </tr>
              <tr>
                <td width="100%" class="ayuda" colspan='4'>SI DESEA VER TODOS LOS REGISTROS DEBE DEJAR EN LA OPCION SELECCION...</td>
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
</body>
</html>