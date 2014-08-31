<?php

abstract class TimberCore {

    public $id;
    public $ID;
    public $object_type;

    /**
     *
     *
     * @return boolean
     */
    function __isset( $field ) {
        if ( isset( $this->$field ) ) {
            return $this->$field;
        }
        return false;
    }

    /**
     * This is helpful for twig to return properties and methods see: https://github.com/fabpot/Twig/issues/2 
     * @return mixed
     */
    function __call( $field, $args ) {
        return $this->__get( $field );
    }

    /**
     * This is helpful for twig to return properties and methods see: https://github.com/fabpot/Twig/issues/2 
     *
     * @return mixed
     */
    function __get( $field ) {
        if ( !isset( $this->$field ) ) {
            if ( $meta_value = $this->meta( $field ) ) {
                $this->$field = $meta_value;
            } else if (method_exists($this, $field)){
                $this->$field = $this->$field();
            } else {
                $this->$field = false;
            }
        }
        return $this->$field;
    }

    /**
     *
     *
     * @param array|object $info an object or array you want to grab data from to attach to the Timber object
     */
    function import( $info ) {
        if ( is_object( $info ) ) {
            $info = get_object_vars( $info );
        }
        if ( is_array( $info ) ) {
            foreach ( $info as $key => $value ) {
                if ( !empty( $key ) ) {
                    $this->$key = $value;
                }
            }
        }
    }


    /**
     *
     *
     * @param string  $key
     * @param mixed   $value
     */
    function update( $key, $value ) {
        update_metadata( $this->object_type, $this->ID, $key, $value );
    }

    /**
     *
     *
     * @return bool
     */
    function can_edit() {
        if ( isset( $this->_can_edit ) ) {
            return $this->_can_edit;
        }
        $this->_can_edit = false;
        if ( !function_exists( 'current_user_can' ) ) {
            return false;
        }
        if ( current_user_can( 'edit_post', $this->ID ) ) {
            $this->_can_edit = true;
        }
        return $this->_can_edit;
    }

    /**
     *
     *
     * @return array
     */
    function get_method_values() {
        $ret = array();
        $ret['can_edit'] = $this->can_edit();
        return $ret;
    }

}
