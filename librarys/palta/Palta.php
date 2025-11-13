<?php 



	/**
	 * 
	 */
	class Palta
	{

		private $tpl_name;
		private $buffer_tpl;
		
		function __construct($name_view)
		{

			/* carga de la vista*/
			$this->buffer_tpl = file_get_contents('views/'.$name_view.'View.tpl.php');

			/*seccion para cargar componentes*/

			$component_content = file_get_contents('views/components/headComponent.tpl.php');

			$this->buffer_tpl = str_replace("@component(head)", $component_content, $this->buffer_tpl);

			$component_content = file_get_contents('views/components/footerComponent.tpl.php');

			$this->buffer_tpl = str_replace("@component(footer)", $component_content, $this->buffer_tpl);

			/* reemplaza las variables de html con valores de php*/
			$this->assign([
				"APP_NAME" => APP_NAME,
				"APP_AUTHOR" => APP_AUTHOR,
				"APP_DESCRIPTION" => APP_DESCRIPTION,
				"COLOR_FONDO_PRINCIPAL" => COLOR_FONDO_PRINCIPAL,
				"COLOR_TEXTO_PRINCIPAL" => COLOR_TEXTO_PRINCIPAL,
				"COLOR_TEXTO_SECUNDARIO" => COLOR_TEXTO_SECUNDARIO,
				"COLOR_ACENTO_CLIMA" => COLOR_ACENTO_CLIMA,
				"COLOR_ACENTO_ALERTA" => COLOR_ACENTO_ALERTA,
				"COLOR_ACENTO_SECUNDARIO" => COLOR_ACENTO_SECUNDARIO,
				"COLOR_BOTON_PRINCIPAL_TEXTO" => COLOR_BOTON_PRINCIPAL_TEXTO,
				"COLOR_BOTON_SECUNDARIO_TEXTO" => COLOR_BOTON_SECUNDARIO_TEXTO,
				"COLOR_HEADER_FONDO" => COLOR_HEADER_FONDO,
				"COLOR_FOOTER_FONDO" => COLOR_FOOTER_FONDO,
				"COLOR_FOOTER_TEXTO" => COLOR_FOOTER_TEXTO,
				"APP_BASE_URL" => APP_BASE_URL,
				"API_BASE_URL" => API_BASE_URL,
			]);

		}

		/* recibe un array asocitivo con la key de la variable a modificar y su valor a reemplazar*/

		/*  $array_assoc = ["CANT_USERS" => 10, "APP_AUTHOR" => "matt", ,,,,,,] */
		public function assign($array_assoc){

			foreach ($array_assoc as $key => $value) {
				$this->buffer_tpl = str_replace("{{ ".$key." }}", $value, $this->buffer_tpl);
			}
			
		}


		public function printToScreen(){

			echo $this->buffer_tpl;
		}
	}


 ?>