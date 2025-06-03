<?php
/**
 * Plugin Name: EDD Cancel Subscription Modal
 * Plugin URI:
 * Description: Adds a confirmation modal when canceling EDD subscriptions
 * Version: 1.0.0
 * Author: Daan from Daan.dev
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class EDD_Cancel_Subscription_Modal {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	public function enqueue_scripts() {
		// Only enqueue on relevant pages
		if ( ! function_exists( 'edd_is_success_page' ) || ! is_account_page() ) {
			return;
		}

		wp_enqueue_style(
			'edd-cancel-subscription-modal',
			plugin_dir_url( __FILE__ ) . 'css/modal.css',
			[],
			'1.0.0'
		);

		wp_enqueue_script(
			'edd-cancel-subscription-modal',
			plugin_dir_url( __FILE__ ) . 'js/modal.js',
			[], // Removed jQuery dependency
			'1.0.0',
			true
		);

		// Add the modal HTML to the footer
		add_action( 'wp_footer', [ $this, 'add_modal_html' ] );
	}

	public function add_modal_html() {
		?>
        <div id="edd-cancel-modal" class="edd-cancel-modal">
            <div class="edd-cancel-modal-content">
                <span class="edd-cancel-modal-close">&times;</span>
                <h2>Cancel Subscription</h2>
                <p>Are you sure you want to cancel your subscription? This action cannot be undone.</p>
                <div class="edd-cancel-modal-buttons">
                    <button id="edd-cancel-modal-confirm" class="button">Yes, Cancel</button>
                    <button id="edd-cancel-modal-cancel" class="button">No, Keep Subscription</button>
                </div>
            </div>
        </div>
		<?php
	}
}

// Initialize the plugin
new EDD_Cancel_Subscription_Modal();