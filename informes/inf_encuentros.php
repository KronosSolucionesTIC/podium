<?php
include("../lib/database.php");
include("../js/funciones.php");
?>
<?php 
//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
?>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>INFORME ASISTENCIA ENCUENTROS</title>
</head>
<body>
<?php 
    //CONSULTA LOS CAMPEONATOS ACTIVOS
    $db = new database();
    $sql = "SELECT count(*) as total FROM campeonato
    WHERE estado_cam = 1";
    $db->query($sql);
    $db->next_row();
    $columnas = $db->total * 2 + 2;
?>
<table width="731" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='<?=$columnas?>'>INFORME ASISTENCIA ENCUENTROS</td>
  </tr>
  <tr>
    <td align="center">TORNEOS</td>
    <?php 
    //CONSULTA LOS CAMPEONATOS ACTIVOS
    $dbc = new database();
    $sqlc = "SELECT * FROM campeonato
    WHERE estado_cam = 1";
    $dbc->query($sqlc);
    while($dbc->next_row()){
    ?>
      <td align="center" colspan='2'><?php echo $dbc->nom_cam;?></td>
    <?php
    }
    ?>
    <td align="center">% ASISTENCIA</td>
  </tr>
  <tr>
    <td align="center">AFILIADO</td>
    <?php 
    //CONSULTA LOS CAMPEONATOS ACTIVOS
    $dbc = new database();
    $sqlc = "SELECT * FROM campeonato
    WHERE estado_cam = 1";
    $dbc->query($sqlc);
    while($dbc->next_row()){
    ?>
      <td align="center">CANT.</td>
      <td align="center">ASIS.</td>
    <?php
    }
    ?>
    <td align="center"></td>
  </tr>
  <? 
  $db = new database();
  $sql = "SELECT cat_afi,cod_afi,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) AS nombre FROM afiliado
  WHERE estado_afi = 1
  ORDER BY nombre";
  $db->query($sql);
  while($db->next_row()){
  ?>
   <tr>
    <td><?=$db->nombre?></td>
    <? 
    $tot = 0;
    $cont = 0;
    $porcentaje = 0;
    $asis = 0;
    //CONSULTA LOS CAMPEONATOS ACTIVOS
    $dbc = new database();
    $sqlc = "SELECT * FROM campeonato
    WHERE estado_cam = 1";
    $dbc->query($sqlc);
    while($dbc->next_row()){
       //CONSULTA SI ESTA EN NOMINA
       $dbn = new database();
  	   $sqln = "SELECT * FROM m_nomina
       INNER JOIN d_nomina ON d_nomina.cod_nom = m_nomina.cod_nom
  	   WHERE cam_nom = $dbc->cod_cam AND cod_afi = $db->cod_afi;";
  	   $dbn->query($sqln);
  	   if($dbn->next_row()){

        //CONSULTA CUANTOS ENCUETROS HAY EN ESE CAMPEONATO
        $dbe = new database();
        $sqle = "SELECT COUNT(*) AS cantidad FROM m_encuentro
        WHERE estado_enc = 1 AND cod_cam = $dbc->cod_cam;";
        $dbe->query($sqle);
        $dbe->next_row();

        //CONSULTA CUANTAS ASISTENCIAS TIENE
        $dba = new database();
        $sqla = "SELECT COUNT(*) AS asistencias FROM m_encuentro
        INNER JOIN d_encuentro ON d_encuentro.cod_menc = m_encuentro.cod_enc
        WHERE estado_enc = 1 AND cod_cam = $dbc->cod_cam AND cod_afi = $db->cod_afi;";
        $dba->query($sqla);
        $dba->next_row();

        //CALCULA EL % ASISTENCIA
        if($dbe->cantidad <=0){
          $asis = '0';
        }
        else{
          $asis = $dba->asistencias * 100 / $dbe->cantidad;
          $asis = round($asis);
        }

        if($dbe->cantidad > 0){
          $cont++;
        }
        else{

        }

        $tot = $tot + $asis;

        if($cont == 0){
          $porcentaje = 0;
        } 
        else{
          $porcentaje = $tot / $cont;     
          $porcentaje = round($porcentaje);
        }
    ?>
      <td align="center"><?php echo $dbe->cantidad?></td>
      <td align="center"><?php echo $dba->asistencias?></td>
    <?php
       } else {
    ?>
      <td align="center" colspan='2'></td>
    <?php
      }
    }
    ?>
    <td align="center"><?php echo $porcentaje ?>%</td>
  </tr>
  <? 
	}
  ?>
    <tr>
      <td align="center" colspan='<?=$columnas?>'><input name="button" type="button" class="botones"  onClick="window.print()" value="Imprimir" />
        <input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" />
        <input type="hidden" name="mapa" value="<?=$mapa?>"></td>
    </tr>
</table>
</body>
</html>