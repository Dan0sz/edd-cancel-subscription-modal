<?php
/**
 * Plugin Name: Easy Digital Downloads - Cancel Subscription Modal
 * Plugin URI: https://github.com/Dan0sz/edd-cancel-subscription-modal
 * Description: Adds a confirmation modal when canceling EDD subscriptions.
 * Version: 1.0.1
 * Author: Daan from Daan.dev
 * Text Domain: edd-cancel-subscription-modal
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class EDD_Cancel_Subscription_Modal {
	/**
	 * Build class.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Enqueue scripts and styles when edd_subscriptions shortcode is found on the page and replaces
	 * EDD Recurring's frontend JS with our modified version, since that's the only way to remove
	 * its ugly confirmation dialog.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		global $post;

		// Check if we're on a page and if it contains the edd_subscriptions shortcode
		if ( ! is_a( $post, 'WP_Post' ) || ! has_shortcode( $post->post_content, 'edd_subscriptions' ) ) {
			return;
		}

		$version = filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/modal.min.css' );

		wp_enqueue_style(
			'edd-cancel-subscription-modal',
			plugin_dir_url( __FILE__ ) . 'assets/css/modal.min.css',
			[],
			$version
		);

		$version = filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/modal.min.js' );

		wp_enqueue_script(
			'edd-cancel-subscription-modal',
			plugin_dir_url( __FILE__ ) . 'assets/js/modal.min.js',
			[],
			$version,
			true
		);

		wp_deregister_script( 'edd-frontend-recurring' );

		$version = filemtime( plugin_dir_path( __FILE__ ) . 'assets/lib/js/edd-frontend-recurring.js' );

		wp_enqueue_script( 'edd-frontend-recurring', plugin_dir_url( __FILE__ ) . 'assets/lib/js/edd-frontend-recurring.js', [ 'jquery' ], $version, true );

		// Add the modal HTML to the footer
		add_action( 'wp_footer', [ $this, 'add_modal_html' ] );
	}

	/**
	 * Outputs the modal's HTML.
	 *
	 * @return void
	 */
	public function add_modal_html() {
		?>
        <div id="edd-cancel-modal" class="edd-cancel-modal">
            <div class="edd-cancel-modal-content">
                <span class="edd-cancel-modal-close">&times;</span>
                <h2><?php echo __( 'Don\'t wanna be tied down, huh?', 'edd-cancel-subscription-modal' ); ?></h2>
                <p><?php echo __( 'I get it. Honestly.', 'edd-cancel-subscription-modal' ); ?></p>
                <p><?php echo __( 'I promise <strong>this won\'t be a 7 step process</strong>, but I do want to make you aware of the following:', 'edd-cancel-subscription-modal' ); ?></p>
                <p><?php echo __(
						'Recently, <strong>for the first time in 5 years</strong>, I had to <a href="https://daan.dev/blog/rants/daan-dev-2-0/" target="_blank">increase my prices</a>.',
						'edd-cancel-subscription-modal'
					); ?></p>
                <p><?php echo __(
						'Full disclosure: <strong>I have no plans to do so again in the near future</strong>, but, as I\'m sure you understand, these are uncertain times.',
						'edd-cancel-subscription-modal'
					); ?></p>
                <p><?php echo __(
						'An active subscription <strong>protects you from future price increases</strong>, so if you\'re planning to keep using the plugin and renew your license, it\'s better to leave it active.',
						'edd-cancel-subscription-modal'
					); ?></p>
                <p><?php echo __(
						'That\'s it! I\'ve said what I wanted to say. Now it\'s up to you...',
						'edd-cancel-subscription-modal'
					); ?></p>
                <div class="edd-cancel-confirmation">
                    <label class="edd-cancel-checkbox-label">
                        <input type="checkbox" id="edd-cancel-confirm-checkbox"/>
                        <strong><?php echo __( 'I understand that my subscription can\'t be reactivated after I cancel it.', 'edd-cancel-subscription-modal' ); ?></strong>
                    </label>
                </div>
                <div class="edd-cancel-modal-buttons">
                    <button id="edd-cancel-modal-confirm" disabled class="button"><?php echo __( 'Yes, please cancel', 'edd-cancel-subscription-modal' ); ?></button>
                    <button id="edd-cancel-modal-cancel" class="button"><?php echo __( 'No, keep my subscription', 'edd-cancel-subscription-modal' ); ?></button>
                </div>
            </div>
        </div>
		<?php
	}
}

// Initialize the plugin
new EDD_Cancel_Subscription_Modal();