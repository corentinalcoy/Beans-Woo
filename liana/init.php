<?php

namespace BeansWoo\Liana;

include_once( 'observer.php' );
include_once( 'block.php' );
include_once( 'admin/block.php' );

define( 'BEANS_LIANA_COUPON_UID', 'redeem_points' );


class Main {

    public static function init() {

        Observer::init();
        Block::init();

    }
}




