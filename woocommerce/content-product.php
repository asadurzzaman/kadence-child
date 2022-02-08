<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
global $woocommerce;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

?>
<div class="price-tab" data-id="tab_<?php echo strtolower( get_the_title()); ?> ">
    <div class="table-width">
        <?php

        global  $product;

        if( $product->is_type('variable') ){


            foreach( $product->get_available_variations() as $variation ){

                //echo $category =  wc_get_product_category_list( $product->get_id() );

                //// Variation ID
                $variation_id = $variation['variation_id'];
                // get attribute signular name
                // Attributes
                $attributes = array();
                foreach( $variation['attributes'] as $key => $value ){
                    $taxonomy = str_replace('attribute_', '', $key );
                    $taxonomy_label = get_taxonomy( $taxonomy )->labels->singular_name;
                }

                ?>

                <div class="single_table <?php echo $taxonomy_label ?>">
                    <div class="table_header">
                        <h4 class="packer_name"><?php echo $taxonomy_label; ?></h4>
                        <p class="packeg_details">
                            <span class="price_html"><?php echo $variation['price_html'] ?></span>
                            <span class="packeg_name"><?php echo $taxonomy_label;  ?></span>
                        </p>
                    </div>
                    <div class="table_features">
                        <?php echo $variation['variation_description']; ?>
                    </div>
                    <div class="custom_feald">
                        <?php //echo $variation['new_text_field']; ?>
                    </div>
                    <div class="table_footer">
                        <form id="variations_table_form" action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" method="post" enctype="multipart/form-data">
                            <div class="woocommerce-variation-add-to-cart variations_button woocommerce-variation-add-to-cart-enabled">
                                <button type="submit" class="single_add_to_cart_button button alt">Purchase Now</button>
                                <input type="hidden" name="add-to-cart" value="<?php echo get_the_ID(); ?>">
                                <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
                                <input type="hidden" name="variation_id" class="variation_id" value="<?php echo $variation_id ?>">
                            </div>
                        </form>

                    </div>
                </div>

                <?php

            }
        }

        ?>
    </div>
</div>



