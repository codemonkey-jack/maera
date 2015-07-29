<?php

/**
 * This is an abstract class.
 * When building a shell you should extend this class and follow the pattern set by this class.
 * When extending this class you should not include a __construct.
 * If you do include a __construct, then don't forget to call parent::__construct() in it.
 */
abstract class Maera_Shell {

    public $path;
    public $url;
    public $templates_path;

    /**
     * The class constructor
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
        $this->path           = $this->path();
        $this->url            = $this->url();
        $this->templates_path = $this->templates_path();
    }

    /**
     * Define the shell's path.
     *
     * @return string   absolute path to the shell
     */
    abstract public function path();

    /**
     * Define the shell's templates path.
     *
     * @return string   absolute path to the shell's templates folder.
     */
    abstract public function templates_path();

    /**
     * Define the shell's URL.
     *
     * @return string   URL of the shell.
     */
    abstract public function url();

    /**
     * Enqueue the shell's scripts and styles.
     *
     * @return void
     */
    abstract public function enqueue();

    /**
     * Define the shell's container CSS class.
     *
     * @return string   the CSS class of the shell's container class for grids.
     */
    abstract public function container();

    /**
     * Define the shell's row CSS class.
     *
     * @return string   the CSS class of the shell's row class for grids.
     */
    abstract public function row();

    /**
     * Define the shell's column CSS class.
     * Returns a string containing CSS classes
     * depending on the arguments passed to it.
     * The default is using a 12-column grid,
     * but that can change depending on the shell's implementation.
     *
     * @param $columns_desktop  int     The number of columns for desktop.
     * @param $columns_tablet   int     The number of columns for tablets.
     * @param $columns_mobile   int     The number of columns for mobiles.
     * @return                  string  The CSS class of the shell's container class for grids.
     */
    abstract public function column( $columns_desktop = 12, $columns_tablet = null, $columns_mobile = null );

    /**
     * Define the shell's button CSS classes.
     * Returns a string containing the CSS classes of the button
     * depending on the arguments passed to it.
     *
     * @param $color    string  The button color.
     * @param $size     string  The button size.
     * @param $type     string  The button type (example: round).
     * @return          string  The CSS classes needed to properly render the button.
     */
    abstract public function button( $color = null, $size = null, $type = null );

}
