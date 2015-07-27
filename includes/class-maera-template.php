<?php

class Maera_Template {

    public function __construct() {
        add_filter( 'comments_template', array( $this, 'comments_template' ) );
    }

    public function find_file( $template_name, $default = '' ) {
        $located = $default;
        if ( STYLESHEETPATH != TEMPLATEPATH && file_exists( STYLESHEETPATH . '/' . $template_name ) ) {
            $located = STYLESHEETPATH . '/' . $template_name;
        } elseif ( file_exists( MAERA_SHELL_PATH . '/templates/' . $template_name ) ) {
            $located = MAERA_SHELL_PATH . '/' . $template_name;
        } elseif ( file_exists( MAERA_SHELL_PATH . '/' . $template_name ) ) {
            $located = MAERA_SHELL_PATH . '/' . $template_name;
        } elseif ( file_exists( TEMPLATEPATH . '/' . $template_name ) ) {
            $located = TEMPLATEPATH . '/' . $template_name;
        }

        return $located;
    }

    public function comments_template() {
        return $this->find_file( 'comments.php', '' );
    }

    public static function locate_template( $template_names, $load = false, $require_once = true ) {
        $located = '';
        foreach ( (array) $template_names as $template_name ) {
            if ( ! $template_name ) {
                continue;
            }
            $located = $this->find_file( $template_name, $located );
        }

        if ( $load && '' != $located ) {
            load_template( $located, $require_once );
        }

        return $located;
    }

    /**
     * Load a template part into a template
     *
     * Makes it easy for a theme to reuse sections of code in a easy to overload way
     * for child themes.
     *
     * Includes the named template part for a theme or if a name is specified then a
     * specialised part will be included. If the theme contains no {slug}.php file
     * then no template will be included.
     *
     * The template is included using require, not require_once, so you may include the
     * same template part multiple times.
     *
     * For the $name parameter, if the file is called "{slug}-special.php" then specify
     * "special".
     *
     * @since 3.0.0
     *
     * @param string $slug The slug name for the generic template.
     * @param string $name The name of the specialised template.
     */
    public static function get_template_part( $slug, $name = null ) {
        /**
         * Fires before the specified template part file is loaded.
         *
         * The dynamic portion of the hook name, `$slug`, refers to the slug name
         * for the generic template part.
         *
         * @since 3.0.0
         *
         * @param string $slug The slug name for the generic template.
         * @param string $name The name of the specialized template.
         */
        do_action( "get_template_part_{$slug}", $slug, $name );

        $templates = array();
        $name = (string) $name;
        if ( '' !== $name ) {
            $templates[] = "{$slug}-{$name}.php";
        }

        $templates[] = "{$slug}.php";

        self::locate_template( $templates, true, false );
    }

}
