
<? 

		require_once ("data/include.php");
		$conexion = new accesoBD(SERVIDORBD,USUARIOBD,CLAVEBD);
		$conexion->SeleccionBD(BASEDATOS);
	

		if (isset($_GET['id']) && ValidarContenido($_GET['id'],"NumericoEntero") && $_GET['id'] >= 1) 
			$tema= $_GET['id'];
		else 
			$tema = 1;

	
		$oNoticia= new cNotaUrl($conexion); 
		
		function LimpioNombre($cadena)	{

			$cadena = strtolower($cadena);
			$buscar = array(".",",","?","?","?","?","?","?","?","?","?","?","?","?"," ","'","&","?","?","?","?","?","?","?","?"."?"."?");
			$reemplazar = array ("","","n","a","e","i","o","u","n","a","e","i","o","u","-","","y", "a","a","e","e","i","i","o","o","u","u");
			$cadena = str_replace($buscar,$reemplazar,$cadena);

			return $cadena;
		}
		//-----------------------------------------------------------------------------------------------------
		function armarUrl($titulo, $url)    {

			if ($url == "")
				$cadena = LimpioNombre($titulo);
			else
				$cadena = $url;

			return $cadena;
		}
		
		// Consulto el ultimo ID de las notas
		$sql =  "SELECT * FROM nota WHERE noti_codigo = (SELECT MAX(noti_codigo) FROM nota)";
		$resultado = mysql_query($sql);
		$total_pages = mysql_fetch_assoc($resultado); 
		// Consulto cual es la nota siguiente
		$sql =  "SELECT * FROM nota WHERE noti_codigo > $tema ORDER BY noti_codigo ASC LIMIT 1";
		$resultado = mysql_query($sql);
		$next = mysql_fetch_assoc($resultado); 
		// Consulto cual es la nota anterior
		$sql =  "SELECT * FROM nota WHERE noti_codigo <  $tema ORDER BY noti_codigo DESC LIMIT 1";
		$resultado = mysql_query($sql);
		$prev = mysql_fetch_assoc($resultado);
		
		if($tema == 1) {
			$oNoticia->BuscarDatos($next['noti_codigo'],$fila_noticia);
			echo "<a href='tema-".$fila_noticia['noti_codigo']."/",armarURL($fila_noticia['noti_titulo'], $fila_noticia['noti_url'])."'>Siguiente >> </a>";
		} elseif($tema == $total_pages['noti_codigo']) {
			$oNoticia->BuscarDatos($prev['noti_codigo'],$fila_noticia);
			echo "<a href='tema-".$fila_noticia['noti_codigo']."/",armarURL($fila_noticia['noti_titulo'], $fila_noticia['noti_url'])."'> << Anterior</a>"; 
		} else {
			$oNoticia->BuscarDatos($prev['noti_codigo'],$fila_noticia);
			echo "<a href='tema-".$fila_noticia['noti_codigo']."/",armarURL($fila_noticia['noti_titulo'], $fila_noticia['noti_url'])."'><< Anterior</a> | "; 
			$oNoticia->BuscarDatos($next['noti_codigo'],$fila_noticia);
			echo "<a href='tema-".$fila_noticia['noti_codigo']."/",armarURL($fila_noticia['noti_titulo'], $fila_noticia['noti_url'])."'>Siguiente >> </a>";
		}

		$oNoticia->BuscarDatos($tema,$fila_noticia);
		
		
//		paginacion($pagina_actual,$oNoticia->tamano_pagina_publico,$SQL_consulta, $pagina, $num_total_registros,$total_paginas);
//		$result = $conexion->EjecutarQuery($SQL_consulta,"selecci�n de noticias",$errno);


	//	while ($fila_noticia = mysql_fetch_assoc($result)) {
		
			$oNoticia->TraerImagenPrincipal($fila_noticia['noti_codigo'],$result_foto);
			$oNoticia->TraerImagenSecundarias($fila_noticia['noti_codigo'],$result_foto_secundarias);
			
			$hay_foto_principal = (mysql_num_rows($result_foto) ==1);
			$hay_foto_secundaria = (mysql_num_rows($result_foto_secundarias) >=1);
		?>
		
		
		
		
						
		<article class="notas">
      		<h1 class="azul" style="background:#E0E0E0; border-radius:5px; padding:0.3em; font-weight: 700; font-size:1.2em "> <? echo $fila_noticia['noti_titulo']?></h1>
       		<div style="line-height:1.3em; margin-top:0.5em;" ><? if ($hay_foto_principal) { 
						 	$fila_foto = mysql_fetch_assoc($result_foto);	
						 ?>
							<a href="<? echo $oNoticia->ruta_archivo.rawurlencode($fila_foto['foto_archivo'])?>" target="_blank"><img src="<? echo $oNoticia->ruta_archivo.rawurlencode($fila_foto['foto_archivo'])?>" alt="<? echo $fila_foto['foto_nombre']?>"> </a>
							 </span> 
						<? } ?>	<p><? echo nl2br($fila_noticia['noti_copete'])?><br>
						 
				  <? echo html_entity_decode($fila_noticia['noti_texto'],ENT_QUOTES)?></p><br>
			 </div>
   		  </article>
     <div class="cleaner"></div>
     
     

					 <br /><br />

		
		<? //} 

	//	paginacion_navegador ($_SERVER['PHP_SELF'],$pagina_actual, $num_total_registros, $total_paginas);
		
		?>
		
	
	<!-- valoraci�n con reviews -->
<div id="wpac-review"></div>
<script type="text/javascript">
wpac_init = window.wpac_init || [];
wpac_init.push({widget: 'Review', id: 7637});
(function() {
    if ('WIDGETPACK_LOADED' in window) return;
    WIDGETPACK_LOADED = true;
    var mc = document.createElement('script');
    mc.type = 'text/javascript';
    mc.async = true;
    mc.src = 'https://embed.widgetpack.com/widget.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
})();
</script>
<!--<a href="https://widgetpack.com" class="wpac-cr">Reviews System WIDGET PACK</a>-->
		
		<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-595e6d8f557f60f3"></script>

		
		
