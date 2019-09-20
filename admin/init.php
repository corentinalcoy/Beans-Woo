<?php

namespace BeansWoo\Admin;

defined('ABSPATH') or die;

define( 'BEANS_WOO_BASE_MENU_SLUG', 'beans-woo' );
define( 'BEANS_WOO_API_ENDPOINT', get_site_url().'/wp-json/wc/v2/' );
define( 'BEANS_WOO_API_AUTH_ENDPOINT', get_site_url().'/wc-auth/v1/authorize/' );

include_once( "observer.php" );

include_once( "connector/abstract-connector.php" );
include_once ("connector/snow-connector.php");
include_once ("connector/liana-connector.php");
include_once ("connector/poppy-connector.php");

//include_once ("connector/lotus-connector.php");
//include_once ("connector/bamboo-connector.php");


//use BeansWoo\Admin\Connector\BambooConnector;
//use BeansWoo\Admin\Connector\LotusConnector;
use BeansWoo\Admin\Connector\PoppyConnector;
use BeansWoo\Admin\Connector\SnowConnector;
use BeansWoo\Admin\Connector\LianaConnector;

class Main {

    public static function init() {

    	LianaConnector::init();
        SnowConnector::init();
        PoppyConnector::init();
//        BambooConnector::init();
//        LotusConnector::init();

        Observer::init();
    }
}
