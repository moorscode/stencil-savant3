<?php
/**
 * Engine code
 *
 * @package Stencil
 * @subpackage Savant3
 */

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


if ( class_exists( 'Stencil_Implementation' ) ) :

	add_action( 'init', create_function( '', 'new Stencil_Savant_3();' ) );

	/**
	 * Class StencilSavant3
	 *
	 * Implementation of the "Savant3" templating engine
	 */
	class Stencil_Savant_3 extends Stencil_Implementation {

		/**
		 * Initialize Savant3 and set defaults
		 */
		public function __construct() {
			parent::__construct();

			$this->template_extension = 'tpl.php';

			require_once( 'lib/Savant3.php' );

			$config = array(
				'template_path' => $this->template_path,
			);

			$this->engine = new Savant3( $config );

			$this->ready();
		}

		/**
		 * Sets the variable to value
		 *
		 * @param string $variable Variable to set.
		 * @param mixed  $value Value to apply.
		 *
		 * @return mixed|void
		 */
		public function set( $variable, $value ) {
			if ( is_object( $value ) ) {
				$this->engine->assignRef( $variable, $value );
			} else {
				$this->engine->assign( $variable, $value );
			}

			return $this->get( $variable );
		}

		/**
		 * Gets the value of variable
		 *
		 * @param string $variable Variable to read.
		 *
		 * @return mixed|string
		 */
		public function get( $variable ) {
			return $this->engine->getTemplateVars( $variable );
		}

		/**
		 * Fetches the Smarty compiled template
		 *
		 * @param string $template Template file to get.
		 *
		 * @return string
		 */
		public function fetch( $template ) {
			return $this->engine->fetch( $template );
		}
	}

endif;
