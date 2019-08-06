<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

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
class Whpi_Admin_Export {

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
     * Check file
     * Hooked via wp_ajax_check-file, priority 999
     * @since   1.0.0
     * @return  void
     */
    public function check_file() {
        $respond = [
            'file'  => get_option('whpi-file')
        ];

        $export      = get_option('whpi-file');
        $reader      = new XlsxReader();
        $spreadsheet = $reader->load($export['file']);
		$sheetData         = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        wp_send_json([
			'message'  => sprintf(__('Total data %s', 'whpi'), count($sheetData) - 1),
			'continue' => (0 <= count($sheetData) - 1) ? true : false
		]);
        exit;
    }

}
