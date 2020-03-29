<? 	
	session_start();
	?>
	
<?	
	require_once("./include.php"); 
	$conexion = new accesoBD(SERVIDORBD,USUARIOBD,CLAVEBD);
	$conexion->SeleccionBD(BASEDATOS);

	$SQL_constante = "SELECT * ";
	$SQL_constante .= " FROM rol ";
	$result_constante = $conexion->EjecutarQuery($SQL_constante,"búsqueda de constantes",$errno);
	while ($fila_constante = mysql_fetch_assoc($result_constante)) {
		define($fila_constante['rol_nombre'],$fila_constante['rol_codigo']);
	}

	
	puedo_mostrar_pagina_admin($_SESSION['usu_codigo'],$_SESSION['rol_codigo']);
?>
					
					<? 
						$oNoticia= new cNotaUrl($conexion); 
					
						
					$operacion = $_POST['operacion'];
					switch ($operacion) {
						
						case "A":
							$operacion_leyenda = "Agregar";
							break;

						case "M":
							$operacion_leyenda = "Modificar";
							$oNoticia->BuscarDatos($_POST['noti_codigo'],$fila_datos);
							break;

						case "B":
							$operacion_leyenda = "Eliminar";
							$oNoticia->BuscarDatos($_POST['noti_codigo'],$fila_datos);
							break;
					
					}
					
					?>
					<form name="formulario" action="nota_url_upd.php" method="post" onSubmit=" return ValidarFormAltaNoticia(formulario)">
					
					<table width="90%" align="center" cellpadding="5" class="TablaMarco">
						<tr class="tablaTitulo">
							<td colspan="2"><? echo $operacion_leyenda?> Nota </td>
						</tr>
						
						
						<tr>
						  <td width="10%" class="tablaEtiqueta">Título</td>
						  <td class="tablaDato">
						  	<? if ($operacion == 'M' || $operacion == 'A') { ?>
								  <input name="noti_titulo" type="text" class="textoCombo" id="noti_titulo" size="50" maxlength="200" value="<? echo $fila_datos['noti_titulo']?>">
							<? } else { 
									echo $fila_datos['noti_titulo'];
								} ?>						  </td>
					 	 </tr>
					 	 
					 	 <tr>
						  <td width="10%" class="tablaEtiqueta">URL</td>
						  <td class="tablaDato">
						  	<? if ($operacion == 'M' || $operacion == 'A') { ?>
								  <input name="noti_url" type="text" class="textoCombo" id="noti_url" size="50" maxlength="200" value="<? echo $fila_datos['noti_url']?>">
							<? } else { 
									echo $fila_datos['noti_url'];
								} ?>						  </td>
					 	 </tr>


						<tr>
						  <td class="tablaEtiqueta">Copete</td>
						  <td class="tablaDato">
						  	<? if ($operacion == 'M' || $operacion == 'A') { ?>
								  <textarea name="noti_copete" cols="50" rows="5" class="textoCombo" id="noti_copete"><? echo $fila_datos['noti_copete']?></textarea>
							<? } else { 
									echo $fila_datos['noti_copete'];
								} ?>						  </td>
						  <td>                        
					  </tr>
						<tr>
						  <td width="10%" class="tablaEtiqueta">Texto</td>
						  <td class="tablaDato"><? if ($operacion == 'M' || $operacion == 'A') { ?>
                              <div id="divtexto"><? echo html_entity_decode($fila_datos['noti_texto'],ENT_QUOTES);?></div>
						    <textarea name="noti_texto" id="noti_texto" style="width:1; height:1"><? echo $fila_datos['noti_texto']?></textarea>
                            <a href="javascript:void(0)" class="textoNormal" onclick="javascript:Popup('editar_texto_nota_url.php?','Editar_Texto',600,500,0,0,'yes')"><img src="images/ico_modificar.png" border="0" />Editar texto</a>
							<? } else { 
									echo html_entity_decode($fila_datos['noti_texto'],ENT_QUOTES);
								} ?>						  </td>
							
							</td>
						</tr>

						<tr>
						  <td width="10%" class="tablaEtiqueta">Orden</td>
						  <td class="tablaDato">
						  	<? if ($operacion == 'M' || $operacion == 'A') { ?>
								  <input name="noti_orden" type="text" class="textoCombo" id="noti_orden" size="10" maxlength="4" value="<? echo $fila_datos['noti_orden']?>">
							<? } else { 
									echo $fila_datos['noti_orden'];
								} ?>						  </td>
					 	 </tr>

						 
						<tr>
						  <td colspan="2"><div align="center">
							<input name="bot_agregar" type="submit" class="boton" value="<? echo $operacion_leyenda?>">
							<input type="hidden" name="operacion" id="operacion" value="<? echo $operacion?>">
							<input type="hidden" name="noti_codigo" id="noti_codigo" value="<? echo $_POST['noti_codigo']?>">

							</div></td>
						  </tr>
					</table>
					
					
					<p>&nbsp;</p>
					</form>
