<?php

class Maera_MDL_Menu_Navwalker extends Walker_Nav_Menu {

    public function walk( $elements, $max_depth ) {
        $list = '';

        foreach ( $elements as $item ) {
            if ( $item->current ) {
                $list .= '<a class="mdl-navigation__link active" href=' . $item->url . '>' . $item->title . '</a>';
            } else {
                $list .= '<a class="mdl-navigation__link" href=' . $item->url . '>' . $item->title . '</a>';
            }
        }

        return $list;

    }

}
