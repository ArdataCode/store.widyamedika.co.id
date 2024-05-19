<?php
/**
 * AI Product Review Summary - Archive Product
 * 
 * @since 2.1.1
 */

// Direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

require_once ALPUS_PLUGIN_FRAMEWORK_PATH . 'admin/options/class-plugin-options.php';

class Alpus_APRS_Archive_Product {
	/**
	 * The Constructor
     *
	 * @since 2.1.1
	 * @access public
	*/
	public function __construct() {

        // add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'display_label' ), 5 );
	}

    public function display_label() {
        ob_start();
        ?>
        <div class="alpus-aprs-status-label">
            <?php echo esc_html__( 'AI Summary', 'alpus-aprs' ); ?>
        </div>
        <?php
        $html = ob_get_clean();

        echo apply_filters( 'aprs_archive_product_label_html', $html );
    }

    /**
     * Enqueue JS & Styles for Backend.
     * 
     * @since 2.1.1
     * @access public
     */
    public function enqueue() {
        
    }
}

new Alpus_APRS_Archive_Product;