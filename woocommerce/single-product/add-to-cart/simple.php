<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$context = array();
$context['product'] = $product;

// Availability
$context['availability']      = $product->get_availability();
$context['availability_html'] = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

if ( $product->is_in_stock() ) {
	$context['min_value'] = apply_filters( 'woocommerce_quantity_input_min', 1, $product );
	$context['max_value'] = apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product );
}
Maera()->views->render( 'single-product/add-to-cart/simple.twig', $context );
