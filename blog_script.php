<meta charset="utf-8">
<? 

		require_once ("data/include.php");
		$conexion = new accesoBD(SERVIDORBD,USUARIOBD,CLAVEBD);
		$conexion->SeleccionBD(BASEDATOS);
	

		if (isset($_GET['pagina']) && ValidarContenido($_GET['pagina'],"NumericoEntero") && $_GET['pagina'] >= 1) 
			$pagina_actual= $_GET['pagina'];
		else 
			$pagina_actual = 1;

	
		$oNoticia= new cNotaUrl($conexion); 
		$oNoticia->ConsultaTraerDatos($SQL_consulta,"");
		paginacion($pagina_actual,$oNoticia->tamano_pagina_publico,$SQL_consulta, $pagina, $num_total_registros,$total_paginas);
		$result = $conexion->EjecutarQuery($SQL_consulta,"selección de noticias",$errno);


		if (mysql_num_rows($result) == 0) { ?>
			<p align="center" class="txt11"> No hay datos</p>
		    <? }  
		
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



		while ($fila_noticia = mysql_fetch_assoc($result)) {
		
			$oNoticia->TraerImagenPrincipal($fila_noticia['noti_codigo'],$result_foto);
			$oNoticia->TraerImagenSecundarias($fila_noticia['noti_codigo'],$result_foto_secundarias);
			
			$hay_foto_principal = (mysql_num_rows($result_foto) ==1);
			$hay_foto_secundaria = (mysql_num_rows($result_foto_secundarias) >=1);
			
		?>
					
					
		<article class="notas">
      		<h1 class="azul" style="background:#E0E0E0; border-radius:5px; padding:0.3em; font-weight: 700; font-size:1.2em "> <? echo $fila_noticia['noti_titulo']?></h1>
       		<div style="padding:0.5em; line-height:1.3em; margin-top:0.5em;" ><? if ($hay_foto_principal) { 
						 	$fila_foto = mysql_fetch_assoc($result_foto);	
						 ?>
							<a href="<? echo $oNoticia->ruta_archivo.rawurlencode($fila_foto['foto_archivo'])?>" target="_blank"><img src="<? echo $oNoticia->ruta_archivo.rawurlencode($fila_foto['foto_archivo'])?>" alt="<? echo $fila_foto['foto_nombre']?>"> </a>
							 </span> 
						<? } ?>	<? echo nl2br($fila_noticia['noti_copete'])?><br> <br>
						<strong class="azul" style="background:#E0E0E0; border-radius:5px; padding:0.3em; ">
				<a href="tema-<?php echo $fila_noticia['noti_codigo'] ?>/<?php echo armarUrl($fila_noticia['noti_titulo'],$fila_noticia['noti_url']); ?>">Leer más + </a></strong><br>
			 </div>
   		  </article>
     <div class="cleaner"></div>
     
     
					 <br /><br />

		
		<? } 

		paginacion_navegador ($_SERVER['PHP_SELF'],$pagina_actual, $num_total_registros, $total_paginas);
		
		?>
		
		
