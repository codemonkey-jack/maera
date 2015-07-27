<?php

class Maera_Wrapper_Override {

    /**
     * Singleton class
     */
    private static $instance = null;

    /**
     * The shell dir
     */
    private static $shell = null;

    /**
     * The theme dir
     */
    private static $theme;

    /**
     * Overrides
     */
    private static $overrides;

    /**
     * The class constructor
     *
     * @param array
     */
    function __construct( $overrides = array(), $path ) {

        self::$overrides = $overrides;
        /**
         * We only need this on the frontend
         */
        if ( ! is_admin() ) {
            /**
             * Check that the class has not been instantiated before
             */
            if ( null === self::$instance ) {
                add_action( 'wp', array( $this, 'add_filters' ) );
                self::$instance  = $this;
                self::$shell     = $path;
                self::$overrides = $overrides; // and setup our default overrides.
                self::$theme     = trailingslashit( get_stylesheet_directory() ); // All the admin only stuff.
            }

        }

    }

    /**
     * We need to add our filters.
     * All our filters conform to the same format, so it's easy
     * to loop through the overrides, and add a filter for each.
     */
    public function add_filters() {
        if ( ! self::$overrides || ! is_array( self::$overrides ) || ! is_singular() ) {
            return;
        }

        foreach ( self::$overrides as $override ) {
            add_filter( 'maera/wrap_' . $override['prefix'], array( $this, 'override' ), 100 );
        }
    }

    /**
     * We only need one filter function because this is predicated on a very strict naming convention.
     * It'll add our data at the start of the array of preferred templates.
     * We could simply output the template we want, but that will break things
     * if templates are renamed, deleted or are modified by a later filter.
     * Let's hope everyone else employs the same logic or we could run into trouble.
     */
    public function override( $templates ) {
        /**
         * the end of the array contains the default template.
         */
        $type = end( $templates );
        /**
         * We only need the prefix to know which filter we're filtering.
         */
        $type = basename( $type, '.php' );
        /**
         * Apply the filter
         */
        $template = apply_filters( 'maera/wrapper/override/' . $type, '' );
        /**
         * If the filter exists, then add the template to the front of the queue
         */
        if ( $template !== '' ) {
            array_unshift( $templates, $template );
        }

        return $templates;
    }

}
