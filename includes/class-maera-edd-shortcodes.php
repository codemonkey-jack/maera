<?php

class Maera_EDD_Shortcodes {

    function __construct() {
        add_filter( 'downloads_shortcode', array( $this, 'modify_edd_download_shortcode' ), 10, 11 );
        add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
    }

    function pre_get_posts() {

        if ( is_post_type_archive( 'download' ) || is_tax( 'download_category' ) || is_tax( 'download_tag' ) ) {
            add_filter( 'edd_downloads_query', array( $this, 'archives_query' ) );
        }

    }

    function archives_query( $query ) {
        global $wp_query;
        $query_array = (array) $wp_query;

        if ( is_tax( 'download_category' ) ) {
            $term = get_term_by( 'slug', $query_array['query']['download_category'], 'download_category' );
            $query['tax_query'][] = array(
                'taxonomy'  => 'download_category',
                'tax_query' => 'term_id',
                'terms'     => $term->term_id,
                'operator'  => 'IN'
            );
        } else if ( is_tax( 'download_tag' ) ) {
            $term = get_term_by( 'slug', $query_array['query']['download_tag'], 'download_tag' );
            $query['tax_query'][] = array(
                'taxonomy'  => 'download_tag',
                'tax_query' => 'term_id',
                'terms'     => $term->term_id,
                'operator'  => 'IN'
            );
        }

        return $query;
    }

    /**
    * Filter [download] shortcode HTML
    * @since 1.0
    */
    function modify_edd_download_shortcode( $display, $atts, $buy_button, $columns, $column_width, $downloads, $excerpt, $full_content, $price, $thumbnails, $query ) {

        $button_defaults = apply_filters( 'edd_purchase_link_defaults', array() );
        $button_defaults_class = $button_defaults['class'];

        // We can't divide the grid to 5 columns, so we're setting them to 4.
        $columns = ( 5 == $columns ) ? 4 : $columns;

        if ( 1 == $columns ) {
            $column_class = '[maera_grid_col_12]';
        } else if ( 2 == $columns ) {
            $column_class = '[maera_grid_col_6]';
        } else if ( 3 == $columns ) {
            $column_class = '[maera_grid_col_4]';
        } else if ( 4 == $columns ) {
            $column_class = '[maera_grid_col_3]';
        } else if ( 6 == $columns ) {
            $column_class = '[maera_grid_col_2]';
        }

        ob_start();
        $count = 0;
        $rand = rand( 0, 999 );

        if ( 1 != $columns ) {
            echo '<style>.downloads-list .edd-grid-column-' . $rand . '_1{clear:left;}.downloads-list [class*="column"] + [class*="column"]:last-child{float: left;}</style>';
        }

        $list_class = 1 == $columns ? 'list' : 'grid';
        ?>
        <div class="downloads-list <?php echo $list_class; ?>">
            <div class="[maera_grid_row_class]">
                <?php

                while ( $downloads->have_posts() ) : $downloads->the_post(); $count++;

                $count       = $count > $columns ? 1 : $count;
                $count_class = 1 < $columns ? 'edd-grid-column-' . $rand . '_' . $count : null;

                $in_cart         = ( edd_item_in_cart( get_the_ID() ) && ! edd_has_variable_prices( get_the_ID() ) ) ? 'in-cart' : '';
                $variable_priced = ( edd_has_variable_prices( get_the_ID() ) ) ? 'variable-priced' : '';
                $hover_type      = get_theme_mod( 'hover_type', 'edd' );
                $effect          = 'effect-' . $hover_type;

                $context = Maera()->template->context();
                $context['post']             = new TimberPost( get_the_ID() );
                $context['columns']          = $columns;
                $context['display_excerpt']  = ( $excerpt != 'no' && $full_content != 'yes' ) ? true : false;
                $context['display_full']     = ( 'yes' == $full_content ) ? true : false;
                $context['display_buy_btn']  = $buy_button;
                $context['in_cart']          = $in_cart;
                $context['variable_priced']  = $variable_priced;
                $context['column_class']     = $column_class;
                $context['count_class']      = $count_class;
                $context['count']            = $count;
                $context['download_classes'] = array( $in_cart, $variable_priced, $column_class, $count_class, $count, $effect );
                $context['btn_class']        = $button_defaults_class;

                if ( 1 == $columns ) {
                    $mode = 'list';
                    $context['download_classes'] = array( $in_cart, $variable_priced, $column_class, $count_class, $count );
                } else {
                    $mode = $hover_type;
                    $mode = ( 'edd' == $hover_type ) ? 'grid' : $mode;
                }
                Maera()->template->main( 'shortcode-download-content-' . $mode . '.twig', $context );

                endwhile;

                wp_reset_postdata();
                ?>
            </div>
        </div>

        <div id="downloads-shortcode" class="download-navigation clearfix">
            <?php
            $big = 999999;
            $paginate_links_args = array(
                'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'    => '?paged=%#%',
                'current'   => max( 1, $query['paged'] ),
                'total'     => $downloads->max_num_pages,
                'prev_next' => false,
                'show_all'  => true,
            );
            echo paginate_links( $paginate_links_args );
            ?>
        </div>
        <script>jQuery( "ul.page-numbers" ).addClass( "pagination" );</script>
        <?php

        $display = ob_get_clean();
        return $display;

    }

}
