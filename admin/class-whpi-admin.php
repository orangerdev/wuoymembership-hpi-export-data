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
	 * Upload file
	 * @param  array $file [description]
	 * @return void
	 */
	protected function upload_file($file) {
		$upload_dir = wp_upload_dir();
		$source      = $file['tmp_name'];
		$destination = trailingslashit( $upload_dir['basedir'] ) . 'wphi.xlsx';

		move_uploaded_file($source, $destination);
		update_option('wphi-file', $destination);
	}

	/**
	 * Check export process
	 * Hooked via action admin_init, priority 999
	 * @return 	void
	 */
	public function check_process() {

		if(isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'wphi-upload-excel') && current_user_can('manage_options')) :

			$valid  = true;
			$errors = [];
			$args   = wp_parse_args($_POST,[
				'product'	=> NULL,
				'active' => false,
			]);

			$file = $_FILES['file'];

			if(0 !== intval($file['error'])) :
				$valid = false;
				$errors[] = 'file-error';
			endif;

			if(!in_array($file['type'], ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])) :
				$valid = false;
				$errors[] = 'wrong-file-type';
			endif;

			if(false !== $valid) :
				$this->upload_file($file);
				$link = add_query_arg([
					'page'       => 'wuoymember-whpi',
					'upload-hpi' => true
				],admin_url('admin.php'));
				wp_redirect($link);
				exit;
			else :
				$link = add_query_arg([
					'page'	=> 'wuoymember-whpi',
					'error-hpi'	=> implode('+++' ,$errors)
				],admin_url('admin.php'));
				wp_redirect($link);
				exit;
			endif;
		endif;

	}

	/**
	 * Display admin message
	 * Hooked via action admin_notices, priority 999
	 * @since 	1.0.0
	 * @return 	void
	 */
	public function admin_notice() {
		if(isset($_GET['error-hpi'])) :
			$errors = explode('+++', $_GET['error-hpi']);
		?>
		<div class="notice notice-error">
			<?php if(in_array('file-error', $errors)) : ?>
			<p><?php _e('Anda belum mengupload file', 'whpi'); ?></p>
			<?php endif; ?>

			<?php if(in_array('wrong-file-type', $errors)) : ?>
			<p><?php _e('File yang anda upload bukan file excel yang benar', 'whpi'); ?></p>
			<?php endif; ?>
		</div>
		<?php
		endif;
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

	/**
	 * Display export page
	 * @return 	void
	 */
	public function display_export_page() {
		if(isset($_GET['upload-hpi']) && true === boolval($_GET['uplaod-hpi'])) :
			require plugin_dir_path( __FILE__ ) . 'partials/excel-process.php';
		else :
			require plugin_dir_path( __FILE__ ) . 'partials/export-form.php';
		endif;
	}

}
