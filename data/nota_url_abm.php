<?   
	session_start();
	//	puedo_mostrar_pagina($_SESSION['usua_codigo']);
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"> 
<html><!-- InstanceBegin template="/Templates/plantilla_admin.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<? 	require_once("./include.php"); 
	$conexion = new accesoBD(SERVIDORBD,USUARIOBD,CLAVEBD);
	$conexion->SeleccionBD(BASEDATOS);

	$SQL_constante = "SELECT * ";
	$SQL_constante .= " FROM rol ";
	$result_constante = $conexion->EjecutarQuery($SQL_constante,"búsqyeda de constantes",$errno);
	while ($fila_constante = mysql_fetch_assoc($result_constante)) {
		define($fila_constante['rol_nombre'],$fila_constante['rol_codigo']);
	}

	
	puedo_mostrar_pagina_admin($_SESSION['usu_codigo'],$_SESSION['rol_codigo']);
?>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Panel de Administraci&oacute;n</title>
<!-- InstanceEndEditable -->
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/funcionesjs.js"></script>
<script type="text/javascript" src="coolmenu.js"></script>
<script type="text/javascript" src="menuitems_admin.js"></script>

<script type="text/javascript">new COOLjsMenu("menu1", MENU_ITEMS_MULTIPLE1)</script>

<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<link href="estilos.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background: #DDDDDD;
}
-->
</style></HEAD>
<? 
	if (isset($texto_libre)) { 
	echo "<body onLoad=\"initEditor()\"> ";
	} else { ?> 
	  <body>	  
<?	}	?>

<table width="800" border="1" align="left" cellpadding="0" cellspacing="0" class="TablaIndex">
  <tr> 
    <td> <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="tablaEncabezado">
        <tr> 
          <td  align="center">
		  <img src="images/banner_top.gif" width="800" height="120" alt="Panel de Administración"></td>
        </tr>
        <tr class="tablaTitulo">
          <td align="center"><div align="right"><? echo NOMBRE_CLIENTE." - ".NOMBRE_SISTEMA ?></div></td>
        </tr>
        <tr class="tablaTitulo">
          <td align="center"><div align="right" class="tablaEtiqueta">Usuario: <? echo $_SESSION['usu_nombre']." ".$_SESSION['usu_apellido'] ?></div></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0"  style="background-color:#FFF">
        <tr> 
          <td width="140" valign="top" class="tablaMenu"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablamenu">
              <tr>
                <td >&nbsp;</td>
              </tr>
              <tr>
                <td >&nbsp;</td>
              </tr>
              <tr> 
                <td ><!-- InstanceBeginEditable name="EditRegion5" --> 
                  <p>.</p>
                  <!-- InstanceEndEditable --></td>
              </tr>
          </table></td>
          <td valign="top"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr> 
                <td><blockquote>
					<!-- InstanceBeginEditable name="EditRegion3" --> 
						<br />
						<blockquote>
						  <p align="left" class="textoTitulo">Administrar Notas </p>
					  </blockquote>	

						<script src="richtext/js/richtext.js" type="text/javascript" language="javascript"></script>
						<!-- Include the Free Rich Text Editor Variables Page -->
						<script src="richtext/js/richtextconfig.js" type="text/javascript" language="javascript"></script>


						<script type="text/javascript">
						function ActualizarFormulario(formulario,divDestino,noti_codigo,operacion) {
						
						
							var item_obj = $(divDestino);
							var objAguarde = $('idAguarde');
							if (objAguarde != null)
								objAguarde.innerHTML='Aguarde ...';	
						
							item_obj.innerHTML="";
						
							var params="noti_codigo="+noti_codigo+"&operacion="+operacion;
							var url = "nota_url_ajax.php";
							
							var ajax = new Ajax.Request(url, {
									parameters: params,
									method:"post",
									onComplete: function(transport) {
										if (200 == transport.status) 
											{	
												response=transport.responseText;
												objAguarde.innerHTML='';
												item_obj.innerHTML=	response;
											 	location.href='#final_pagina';

												return true;
											}	
									}
								}
							);
							
							
							return false;
						}
						
						
						</script>                    
					<? 
					
						$_SESSION['carga_inicial']=true;
					
						if (isset($_GET['pagina'])) 
							$pagina_actual= $_GET['pagina'];
						else 
							$pagina_actual = 1;
						
						$oNoticia= new cNotaUrl($conexion); 
						$oNoticia->ConsultaTraerDatos($SQL_consulta,"");
						paginacion($pagina_actual,$oNoticia->tamano_pagina,$SQL_consulta, $pagina, $num_total_registros,$total_paginas);
						$result = $conexion->EjecutarQuery($SQL_consulta,"selecci�n de noticias",$errno);

						if (mysql_num_rows($result) == 0) {
							?>
								<p align="center" class="textoNormal"> No hay datos </p>
					  <? } else { ?>
	
							<table width="90%" align="center" cellpadding="5" class="TablaMarco" >
							  <tr class="tablaTitulo">
								  <td><div align="center">T&iacute;tulo</div></td>
							    <td width="10%"><div align="center">Imágenes</div></td>
							    <td width="10%"><div align="center">Modificar</div></td>
								  <td width="10%"><div align="center">Eliminar</div></td>						
							  </tr>
							<? 
								$i=0;
								while ($fila_datos = mysql_fetch_assoc($result)) { 
								$i++;
								$clase =  ($i%2==0)?"TextoPar":"TextoImpar";
								
								
								?>	
								  <tr class="<? echo $clase?>">
									<td class="textoNormal"><div align="left"><? echo $fila_datos['noti_titulo']?></div></td>
									<td><div align="center"><a href="javascript:void(0)" onClick="javascript:Popup('nota_url_fotos.php?noti_codigo=<? echo $fila_datos['noti_codigo']?>','imagenes',600,500,0,0,'yes')"><img src="images/ico_archivo.png" width="24" height="24" border="0" alt="Administrar im&aacute;genes" /></a></div></td>						
									<td><div align="center"><a href="javascript:void(0)" onClick="return ActualizarFormulario('formulario','divFormulario',<? echo $fila_datos['noti_codigo']?>,'M');"><img src="images/ico_modificar.png" width="24" height="24" border="0" alt="Modificar" /></a></div></td>						
									  <td><div align="center"><a href="javascript:void(0)" onClick="return ActualizarFormulario('formulario','divFormulario',<? echo $fila_datos['noti_codigo']?>,'B');"><img src="images/ico_borrar.png" width="24" height="24" border="0" alt="Eliminar" /></a></div></td>						
							  </tr>
							<? } ?>
						</table>	
						<br />
						<? 
							paginacion_navegador ($_SERVER['PHP_SELF'],$pagina_actual, $num_total_registros, $total_paginas);
							
							?>
							<img src="images/ico_agregar.jpg" alt="Agregar" width="24" height="24" border="0" />
							  <a href="javascript:void(0)" onClick="return ActualizarFormulario('formulario','divFormulario','','A');"> Agregar Nota </a><br />
							<? 	} ?>	
							
				<script type="text/javascript">
					<? $oNoticia->ValidarFormAltaNoticia();?>
				</script>
				<div id="idAguarde" class="textoNormal">
				</div>
				<a name="final_pagina" id="final_pagina"></a>
				<div id="divFormulario">
					<form action="nota_url_upd.php" method="post" name="formulario" id="formulario" onSubmit=" return ValidarFormAltaNoticia(formulario)">
					
					<table width="90%" align="center" cellpadding="5" class="TablaMarco">
						<tr class="tablaTitulo">
							<td colspan="2">Agregar Nota </td>
						</tr>
						<tr>
						  <td class="tablaEtiqueta">Título (*) </td>
						  <td class="tablaDato"><input name="noti_titulo" type="text" class="textoCombo" id="noti_titulo" value="" size="50" maxlength="255"></td>
						 </tr>
						 <tr>
						  <td class="tablaEtiqueta">URL amigable</td>
						  <td class="tablaDato"><input name="noti_url" type="text" class="textoCombo" id="noti_url" value="" size="50" maxlength="255"></td>
						 </tr>
						<tr>
						  <td class="tablaEtiqueta">Copete </td>
						  <td class="tablaDato"><textarea name="noti_copete" cols="50" rows="5" class="textoCombo" id="noti_copete"></textarea></td>
						 </tr>
						<tr>
						  <td class="tablaEtiqueta">Texto</td>
						  <td class="tablaDato"><div id="divtexto"></div>
						      <textarea name="noti_texto" id="noti_texto" style="width:1; height:1"></textarea>
                            <a href="javascript:void(0)" class="textoNormal" onClick="javascript:Popup('editar_texto_nota_url.php?','Editar_Texto',600,500,0,0,'yes')"><img src="images/ico_modificar.png" border="0">Editar texto</a></td>
						</tr>
						<tr>
						  <td class="tablaEtiqueta">Orden (*) </td>
						  <td class="tablaDato"><input name="noti_orden" type="text" class="textoCombo" id="noti_orden" value="" size="10" maxlength="4"></td>
						 </tr>
						<tr>
						  <td colspan="2" class="textoNormal">(*) Datos obligatorios </td>
						  </tr>
						<tr>
						  <td colspan="2"><div align="center">
							<input name="bot_agregar" type="submit" class="boton" value="Agregar" />
							<input type="hidden" name="operacion" id="operacion" value="A" />
							</div></td>
						  </tr>
					</table>
					
					
					<p>&nbsp;</p>
					</form>
				</div>						
						


                <!-- InstanceEndEditable -->
				</blockquote>
				</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#2F36EC" class="textoTitulo">&nbsp;</td>
  </tr>

</table>



</BODY>
<!-- InstanceEnd --></html>