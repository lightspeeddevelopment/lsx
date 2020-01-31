<?php
/**
 * LSX Popup Maker Class
 *
 * @package    lsx
 * @subpackage popup-maker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'LSX_Popup_Maker' ) ) :

	/**
	 * The LSX Popup_Maker integration class
	 */
	class LSX_Popup_Maker {

		/**
		 * Holds class instance
		 *
		 * @since 1.0.0
		 * @var      object
		 */
		protected static $instance = null;

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action( 'wp_enqueue_scripts', array( $this, 'lsx_popup_maker_scripts_add_styles' ) );
		}

		/**
		 * Return an instance of this class.
		 *
		 * @since 1.0.0
		 * @return    object    A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Popup_Maker enqueue styles.
		 *
		 * @package    lsx
		 * @subpackage popup-maker
		 */
		public function lsx_popup_maker_scripts_add_styles() {
			wp_enqueue_style( 'popup-maker-lsx', get_template_directory_uri() . '/assets/css/popup-maker/popup-maker.css', array( 'lsx_main' ), LSX_VERSION );
		}
	}

endif;

LSX_Popup_Maker::get_instance();
