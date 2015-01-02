<?php

require_once( locate_template( '/lib/admin/remote-installer/class-EDD_RI_Client.php' ) );
require_once( locate_template( '/lib/admin/remote-installer/class-EDD_RI_Client_Admin.php' ) );

$store_page = new EDD_RI_Client_Admin( 'http://press.codes/' );
$content = $store_page->settings_page();
?>
<script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/assets/js/edd-ri.js"></script>
