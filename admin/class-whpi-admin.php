<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ridwan-arifandi
 * @since      1.0.0
 *
 * @package    Whpi
 * @subpackage Whpi/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Whpi
 * @subpackage Whpi/admin
 * @author     Ridwan Arifandi <orangerdigiart@gmail.com>
 */
class Whpi_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/whpi-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/whpi-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register sub admin menu under WuoyMeember
	 * Hooked via action admin_menu, priority 999
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function register_admin_menu() {

		add_submenu_page('wuoy-member', __('Ekspor Data HPI', 'whpi'), __('HPI Export', 'whpi'), 'manage_options', 'wuoymember-whpi', [$this, 'display_export_page']);

	}

	public function display_export_page() {
		require plugin_dir_path( __FILE__ ) . 'partials/export-form.php';
	}

}
