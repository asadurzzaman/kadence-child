<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;

    }

endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'kadence-global','kadence-header','kadence-content','kadence-woocommerce','kadence-footer' ) );
    }

endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );


function my_custom_scripts() {
    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'my_custom_scripts' );

//require( get_template_directory_uri() . '/inc/components/woocommerce/component.php' );



// END ENQUEUE PARENT ACTION

// END ENQUEUE PARENT ACTION
// function wplogick_remove_all_quantity_fields( $return, $product ) {return true;}
// add_filter( 'woocommerce_is_sold_individually','wplogick_remove_all_quantity_fields', 10, 2 );


// Remove All Images On All Single Product Pages
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
// Remove breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 40 );

//skip cart and go straight to checkout
add_filter( 'woocommerce_add_to_cart_redirect', 'skip_wc_cart' );
function skip_wc_cart() {
	return wc_get_checkout_url();
}

//customize add to cart text
add_filter( 'woocommerce_product_single_add_to_cart_text', 'lw_cart_btn_text' );
add_filter( 'woocommerce_product_add_to_cart_text', 'lw_cart_btn_text' );
//Changing Add to Cart text to Buy It Now
function lw_cart_btn_text() {
	return __( 'Buy It Now', 'woocommerce' );
}

/**
 * @snippet WooCommerce Max 1 Product @ Cart
 *
 */

add_filter( 'woocommerce_add_to_cart_validation', 'bbloomer_only_one_in_cart', 9999, 2 );

function bbloomer_only_one_in_cart( $passed, $added_product_id ) {
	wc_empty_cart();
	return $passed;
}

// ===========================================================================
//  After Empty Cart Hide "Undo product" Message Code
// ===========================================================================
add_filter('woocommerce_cart_item_removed_notice_type', '__return_null');
add_filter( 'wc_add_to_cart_message_html', '__return_false' );

// ===========================================================================
//  Redirect Empty Checkout to Home
// ===========================================================================

//add_action('template_redirect', 'redirection_function');
//
//function redirection_function(){
//	global $woocommerce;
//
//	if( is_checkout() && 0 == sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count) && !isset($_GET['key']) ) {
//		wp_redirect( home_url() );
//		exit;
//	}
//}


// ===========================================================================
//  Redirect Empty Checkout to Shop Page
// ===========================================================================

add_action("template_redirect", 'redirection_function');
function redirection_function(){
	global $woocommerce;
	if( is_cart() && WC()->cart->cart_contents_count == 0){
		wp_safe_redirect( get_permalink( woocommerce_get_page_id( 'shop' ) ) );
	}
}

// ===========================================================================
//  The Code Below Removes Checkout Fields
// ===========================================================================

add_filter( 'woocommerce_checkout_fields' , 'bbloomer_simplify_checkout_virtual' );
function bbloomer_simplify_checkout_virtual( $fields ) {
		unset($fields['billing']['billing_company']);
		unset($fields['billing']['billing_address_1']);
		unset($fields['billing']['billing_address_2']);
		unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_postcode']);
		//unset($fields['billing']['billing_country']);
		unset($fields['billing']['billing_state']);
		unset($fields['billing']['billing_phone']);
		add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
	return $fields;
}
add_filter( 'woocommerce_billing_fields', 'bbloomer_move_checkout_email_field' );

function bbloomer_move_checkout_email_field( $address_fields ) {
	$address_fields['billing_email']['priority'] = 1;
	return $address_fields;
}

// ===========================================================================
//  Change Billing details text
// ===========================================================================

function wc_billing_field_strings( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case 'Billing details' :
			$translated_text = __( 'Account Information', 'woocommerce' );
			break;
	}
	return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );

// ===========================================================================
//  Change Billing details text
// ===========================================================================

add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' );

function woo_custom_order_button_text() {
	return __( 'Complete your purchase', 'woocommerce' );
}

// ===========================================================================
//  Remove Product permalink on cart page
// ===========================================================================
add_filter( 'woocommerce_cart_item_permalink', '__return_null' );
add_filter( 'woocommerce_cart_item_thumbnail', '__return_false' );

// Display trust badges on checkout page
add_action( 'woocommerce_review_order_after_submit', 'approved_trust_badges' );
function approved_trust_badges() {
	echo '<div class="trust-badges">Add trust badges here</div>
		<div class="trust-badge-message">I added the trust badges above with a WooCommerce hook</div>';
}

// ===========================================================================
//  raper div start for shop page
// ===========================================================================
function wplogic_woocommerce_checkout_before_order_review_heading(){
	echo "<div class=\"custom-review-order\">";
}
add_action('woocommerce_checkout_before_order_review_heading', 'wplogic_woocommerce_checkout_before_order_review_heading');

// ===========================================================================
//  raper div End for shop page
// ===========================================================================
function wplogic_woocommerce_checkout_after_order_review(){
	echo"</div>";
}
add_action('woocommerce_checkout_before_order_review','wplogic_woocommerce_checkout_after_order_review');

function wplogic_before_woocommerce_checkout_after_order_review(){
	echo "<div class=\"custom-order\">";
}
add_action('woocommerce_checkout_before_order_review','wplogic_before_woocommerce_checkout_after_order_review');

function wplogic_after_woocommerce_checkout_after_order_review(){
	echo"</div>";
}
add_action('woocommerce_checkout_before_order_review','wplogic_woocommerce_checkout_after_order_review');


add_filter( 'woocommerce_product_add_to_cart_text', 'bbloomer_change_select_options_button_text', 9999, 2 );

function bbloomer_change_select_options_button_text( $label, $product ) {
	if ( $product->is_type( 'variable' ) ) {
		return 'View Product';
	}
	return $label;
}
// Custom Filed Product variation
add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );
add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );
add_filter( 'woocommerce_available_variation', 'load_variation_settings_fields' );

function variation_settings_fields( $loop, $variation_data, $variation ) {
	woocommerce_wp_textarea_input(
		array(
			'id'            => "my_text_field{$loop}",
			'name'          => "my_text_field[{$loop}]",
			'value'         => get_post_meta( $variation->ID, 'my_text_field', true ),
			'label'         => __( 'Some label', 'woocommerce' ),
			'desc_tip'      => true,
			'description'   => __( 'Some description.', 'woocommerce' ),
			'wrapper_class' => 'form-row form-row-full',
		)
	);
}

function save_variation_settings_fields( $variation_id, $loop ) {
	$text_field = $_POST['my_text_field'][ $loop ];

	if ( ! empty( $text_field ) ) {
		update_post_meta( $variation_id, 'my_text_field', esc_attr( $text_field ));
	}
}

function load_variation_settings_fields( $variation ) {
	$variation['my_text_field'] = get_post_meta( $variation[ 'variation_id' ], 'my_text_field', true );

	return $variation;
}


add_action('woocommerce_checkout_before_customer_details', 'wplogic_woocommerce_checkout_before_customer_details');
function wplogic_woocommerce_checkout_before_customer_details(){
    echo '<div class="total_price">';
    echo '<div class="cart_title"><h3>Your Cart</h3></div>';
    echo woocommerce_order_review();
    echo '</div>';
}


add_action('woocommerce_before_checkout_form', 'wplogic_woocommerce_before_checkout_form', 0);
function wplogic_woocommerce_before_checkout_form(){
    echo '<div class="checkout_header">';
    echo the_custom_logo();
    echo '</div>';
}


add_action('woocommerce_review_order_before_submit', 'wplogic_woocommerce_review_order_before_submit');
function wplogic_woocommerce_review_order_before_submit(){
    global $woocommerce;?>
    <div class="cart_total">
        <h3 id="cart_order_review"><?php esc_html_e( 'You\'re Almost Done!', 'woocommerce' ); ?></h3>
        <h4>Purchase Total : <span class="amount"><?php echo wc_cart_totals_order_total_html(); ?></span></h4>
    </div>
<?php

}

add_action('woocommerce_review_order_before_payment', 'wplogic_woocommerce_review_order_before_payment');
function wplogic_woocommerce_review_order_before_payment(){
    echo '<div class="payment_details"><h3>Payment Details</h3></div>' ;
}

add_filter('woocommerce_product_loop_start', 'wplogic_woocommerce_product_loop_start', 10);

function wplogic_woocommerce_product_loop_start( $default ){

    $default = '<div class="pricing_page_loop_start">';

    return $default;
}

add_filter('woocommerce_product_loop_end', 'wplogic_woocommerce_product_loop_end');
function wplogic_woocommerce_product_loop_end( $default ){

    $default = '</div>';
    return $default;
}

add_action('woocommerce_before_shop_loop', 'newdd_woocommerce_before_shop_loop');
function newdd_woocommerce_before_shop_loop(){
?>
<nav class="price-table-tab">
	<div class="nav text-center justify-content-center" id="nav-tab" role="tablist">
<?php
		global $product;
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => 2,
			);

		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post(); ?>

		        <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" type="button"
                role="tab" data-target="tab_<?php echo strtolower( get_the_title()); ?>">
				    <?php echo get_the_title(); ?>
				</button>

		<?php endwhile; } wp_reset_postdata();

	    echo '</div></nav>';

 echo "<h2>Some Features Add Hear</h2>";

}

add_action('woocommerce_after_shop_loop', 'newdd_woocommerce_after_shop_loop');
function newdd_woocommerce_after_shop_loop(){ ?>


<?php

echo "<h2>Add Other Section like CEO Message, FAQ, Money Back guarantee Section</h2>";

}


add_action('woocommerce_after_single_product_summary', 'wplogic_woocommerce_after_add_to_cart_button');

function wplogic_woocommerce_after_add_to_cart_button(){

    echo '<div class="after_cart_option">';
    echo '<strong>Version: </strong> 4.2.0';
    echo '<strong>WordPress: </strong> 4.5 or higher';
    echo '<strong>LocationLogic: </strong> 4.2.0 or higher';
    echo '<strong>Last Update: </strong> 01 Sep 2021';

    echo '</div>';
}

// Shortcode for yearly price
add_shortcode( 'single_product_annual', 'single_anuual_product_shortcode' );
function single_anuual_product_shortcode() {
        global $product;
		$args = array(
			'post_type' => 'product',
            'product_cat' => 'yearly',
			);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
			echo "<h3>Yearly</h3>";
			echo woocommerce_variable_add_to_cart();
			endwhile;

            echo '<div class="after_cart_option">';
            echo '<strong>Version: </strong> 4.2.0 <br>';
            echo '<strong>WordPress: </strong> 4.5 or higher <br>';
            echo '<strong>LocationLogic: </strong> 4.2.0 or higher <br>';
            echo '<strong>Last Update: </strong> 01 Sep 2021 <br>';
            echo '</div>';
		}
		wp_reset_postdata();

}

// Shortcode for Lifetime price
add_shortcode( 'single_product_lifetime', 'single_lifetime_product_shortcode' );
function single_lifetime_product_shortcode() {
    global $product;
    $args = array(
        'post_type' => 'product',
        'product_cat' => 'monthly',
    );
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) : $loop->the_post();


        //echo print_r($loop);
        echo "<h3>Lifetime</h3>";
            echo woocommerce_variable_add_to_cart();
        endwhile;

        echo '<div class="after_cart_option">';
        echo '<strong>Version: </strong> 4.2.0 <br>';
        echo '<strong>WordPress: </strong> 4.5 or higher <br>';
        echo '<strong>LocationLogic: </strong> 4.2.0 or higher <br>';
        echo '<strong>Last Update: </strong> 01 Sep 2021 <br>';
        echo '</div>';

    }
    wp_reset_postdata();
}

/**
 * * Single product page to shop page
 */
add_action( 'wp', 'single_product_redirect_product_pages', 99 );
function single_product_redirect_product_pages() {

    if ( is_product() ) {
        wp_safe_redirect( site_url('shop') );
        exit;
    }
}

