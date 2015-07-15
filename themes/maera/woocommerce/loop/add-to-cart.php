<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $quantity;

$context = array(
	'product'  => $product,
	'quantity' => $quantity,
);
Maera()->views->render( 'loop/add-to-cart.twig', $context );
