<?php

class Shoestrap_Post extends TimberPost {

	function meta_info() {

		do_action( 'shoestrap/entry/meta', $this->ID );

	}

}
