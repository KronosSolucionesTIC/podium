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
<title><?php echo $nombre_aplicacion?></title>
<script type="text/javascript">
var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function abrir() {	 // cierre normal	
	if(document.getElementById('categoria').value == 0 ||  document.getElementById('campeonato').value== 0) {
	 	alert('Seleccione los campos')
	}
	else 
	{
		var categoria = document.getElementById('categoria').value;
		var campeonato = document.getElementById('campeonato').value;
		imprimir_inf("inf_resultados.php",'0&categoria='+categoria+'&campeonato='+campeonato,'mediano');
	}
}

//CARGA EL CAMPEONATO
function carga_campeonato(){
var combo=document.getElementById('campeonato');
combo.options.length=0;
var cant=0;
combo.options[cant] = new Option('Seleccione...','0'); 
cant++;
<?
    $i=0;
    $sqlc ="SELECT * FROM `campeonato`
    ORDER BY nom_cam";   
    $dbc= new  Database();
    $dbc->query($sqlc);
    while($dbc->next_row()){ 
    echo "if(document.getElementById('categoria').value==$dbc->cat_cam){ "; 
    echo "cam = '$dbc->nom_cam';";
    echo "cam = cam + ' ' + '$dbc->ver_cam';";
    echo "combo.options[cant] = new Option(cam,'$dbc->cod_cam'); ";  
    echo "cant++; } ";
    }
?>
}
</script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="informes/inf.js"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body  <?php echo $sis?> >
<table align="center">
  <tr>
    <td valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
        <tr>
          <td><table width="587" border="0"  cellpadding="0" align="center">
              <tr>
                <td colspan="4"  class="ctablasup" >INFORME DE RESULTADOS</td>
              </tr>
              <?php 
						$estilo="ctablablanc";
						$estilo="ctablagris";					
						if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> ";
						?>
              <tr>
                <td width="91" class="ctablablanc" >Categoria</td>
                <td><?php echo combo_evento_where("categoria","categoria","cod_cat","nom_cat",""," onchange=carga_campeonato();"," WHERE estado_cat = 1 ORDER BY nom_cat")?></td>
                <td width="73" class="ctablablanc" >Campeonato</td>
                <td><?php echo combo_evento_where("campeonato","campeonato","cod_cam","nom_cam","",""," WHERE estado_cam = 1 ORDER BY nom_cam")?></td>              
              <tr>
                <td colspan="2" class="ctablasup" >Informe General</td>
                <td class="ctablablanc" ><img src='imagenes/mirar.png' alt="." width='16' height='16'  style="cursor:pointer"  onClick="abrir()" /></td>
                <td class="ctablablanc" >&nbsp;</td>
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