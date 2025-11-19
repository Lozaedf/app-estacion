<?php 



	/**
	 * 
	 */
	class Palta
	{

		private $tpl_name;
		private $buffer_tpl;
		
		function __construct($name_view, $section = null)
		{

			/* carga de la vista*/
			$this->buffer_tpl = file_get_contents('views/'.$name_view.'View.tpl.php');

			/*section para cargar componentes*/
			$head_component = file_get_contents('views/components/headComponent.tpl.php');
			$this->buffer_tpl = str_replace('@component(head)', $head_component, $this->buffer_tpl);

			/* Cargar header si existe */
			if (strpos($this->buffer_tpl, '@component(header)') !== false) {
				$header_component = file_get_contents('views/components/headerComponent.tpl.php');
				$this->buffer_tpl = str_replace("@component(header)", $header_component, $this->buffer_tpl);
			}

			/* Cargar footer si existe */
			if (strpos($this->buffer_tpl, '@component(footer)') !== false) {
				$footer_component = file_get_contents('views/components/footerComponent.tpl.php');
				$this->buffer_tpl = str_replace("@component(footer)", $footer_component, $this->buffer_tpl);
			}

			/* Eliminar cualquier placeholder de componente no usado */
			$this->buffer_tpl = preg_replace('/@component\([^)]*\)\s*/', '', $this->buffer_tpl);

			/* reemplaza las variables de html con valores de php*/
			$assign_vars = [
				// Variables de aplicación
				"APP_NAME" => APP_NAME,
				"APP_AUTHOR" => APP_AUTHOR,
				"APP_DESCRIPTION" => APP_DESCRIPTION,
				"APP_BASE_URL" => APP_BASE_URL,
				"API_BASE_URL" => API_BASE_URL,

				// Colores principales
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

				// Colores adicionales para formularios y autenticación
				"COLOR_BLANCO" => COLOR_BLANCO,
				"COLOR_GRIS_CLARO" => COLOR_GRIS_CLARO,
				"COLOR_GRIS_MEDIO" => COLOR_GRIS_MEDIO,
				"COLOR_BORDE_INPUT" => COLOR_BORDE_INPUT,
				"COLOR_BORDE_INPUT_FOCUS" => COLOR_BORDE_INPUT_FOCUS,
				"COLOR_FONDO_ERROR" => COLOR_FONDO_ERROR,
				"COLOR_FONDO_EXITO" => COLOR_FONDO_EXITO,
				"COLOR_SOMBRA" => COLOR_SOMBRA,

				// Tipografía
				"FONT_FAMILY" => FONT_FAMILY,
				"FONT_SIZE_BASE" => FONT_SIZE_BASE,
				"FONT_WEIGHT_NORMAL" => FONT_WEIGHT_NORMAL,
				"FONT_WEIGHT_BOLD" => FONT_WEIGHT_BOLD,

				// Espaciado
				"SPACING_XS" => SPACING_XS,
				"SPACING_SM" => SPACING_SM,
				"SPACING_MD" => SPACING_MD,
				"SPACING_LG" => SPACING_LG,
				"SPACING_XL" => SPACING_XL,

				// Bordes
				"BORDER_RADIUS_SM" => BORDER_RADIUS_SM,
				"BORDER_RADIUS_MD" => BORDER_RADIUS_MD,
				"BORDER_RADIUS_LG" => BORDER_RADIUS_LG,

				// Transiciones
				"TRANSITION_FAST" => TRANSITION_FAST,
				"TRANSITION_MEDIUM" => TRANSITION_MEDIUM,
			];

			// Agregar CSS_SECTION (por defecto 'landing' si no se especifica)
			$css_section = $section ? $section : 'landing';
			$assign_vars["CSS_SECTION"] = $css_section . '.css';
			$assign_vars["CSS_SECTION_LINK"] = '<link rel="stylesheet" href="views/assets/css/' . $css_section . '.css">';

			$this->assign($assign_vars);

		}

		/* recibe un array asocitivo con la key de la variable a modificar y su valor a reemplazar*/

		/*  $array_assoc = ["CANT_USERS" => 10, "APP_AUTHOR" => "matt", ,,,,,,] */
		public function assign($array_assoc){

			foreach ($array_assoc as $key => $value) {
				$this->buffer_tpl = str_replace("{{ ".$key." }}", $value, $this->buffer_tpl);
			}
			
		}


		public function printToScreen(){

			// Evaluar PHP en el buffer
			ob_start();
			eval('?>' . $this->buffer_tpl);
			$output = ob_get_contents();
			ob_end_clean();

			echo $output;
		}
		}


 ?>