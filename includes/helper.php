<?php

namespace BeansWoo;

use Beans\Beans;

class Helper {
    const CONFIG_NAME = 'beans-config-3';

    private static $cards = array();
    public static $key = null;

    public static function getDomain( $sub ) {
        $key     = "BEANS_DOMAIN_$sub";
        $domains = array(
            'API'     => 'api-3.trybeans.com',
            'CONNECT' => 'connect.trybeans.com',
            'WWW'     => 'www.trybeans.com',
        );
        $val     = getenv( $key );

        return empty( $val ) ? $domains[ $sub ] : getenv( $key );
    }

    public static function getApps() {
        return array(
            'liana' => array(
                'name' => 'Liana',
                'description' =>'Loyalty program to keep customers tight to your shop.',
	            'link' => 'admin.php?page=beans-woo',
            ),
//            'bamboo' => array(
//                'name' => 'Bamboo',
//                'description' => 'Referral program to make customers bring more customers.'
//            ),
//            'lotus' => array(
//                'name' => 'Lotus',
//                'description' => 'Social media posting automation.'
//            ),
            'snow' => array(
            	'name' => 'Snow',
	            'description' => 'Notifications widget.',
	            'link' => 'admin.php?page=beans-woo-snow',
            ),
        );
    }

    public static function API() {
        if ( ! self::$key ) {
            self::$key = self::getConfig( 'secret' );
        }
        $beans           = new Beans( self::$key );
        $beans->endpoint = 'https://' . self::getDomain( 'API' ) . '/v3/';

        return $beans;
    }

    public static function getAccountData( $account, $k, $default = null ) {
        if ( isset( $account[ $k ] ) ) {
            echo "$k:'" . $account[ $k ] . "',";
        } else if ( $default !== null ) {
            echo "$k: '',";
        }
    }

    public static function getConfig( $key ) {
        $config = get_option( self::CONFIG_NAME );
        if ( isset( $config[ $key ] ) ) {
            return $config[ $key ];
        }

        return null;
    }

    public static function setConfig( $key, $value ) {
        $config         = get_option( self::CONFIG_NAME );
        $config[ $key ] = $value;
        update_option( self::CONFIG_NAME, $config );
    }

    public static function isSetup() {
        return Helper::getConfig( 'key' ) &&
               Helper::getConfig( 'card' ) &&
               Helper::getConfig( 'secret' );
    }

    public static function resetSetup() {
        self::setConfig( 'key', null );
        self::setConfig( 'card', null );
        self::setConfig( 'secret', null );
        self::$cards = array();

        return true;
    }

    public static function isSetupApp(string $app_name){
    	return ! is_null(Helper::getCard($app_name));
    }

    public static function log( $info ) {
        if ( file_exists( BEANS_INFO_LOG ) && filesize( BEANS_INFO_LOG ) > 100000 ) {
            unlink( BEANS_INFO_LOG );
        }

        if ( ! is_writable( BEANS_INFO_LOG ) ) {
            return false;
        }

        $log = date( 'Y-m-d H:i:s.uP' ) . " => " . $info . PHP_EOL;

        try {
            file_put_contents( BEANS_INFO_LOG, $log, FILE_APPEND );
        } catch ( \Exception $e ) {
            return false;
        }

        return true;
    }

    public static function getCard($app_name) {
        if ( ! isset(self::$cards[$app_name]) && self::isSetup() ) {
            try {
                self::$cards[$app_name] = self::API()->get( "${app_name}/card/current" );
            } catch ( \Beans\Error\BaseError $e ) {
                self::log( 'Unable to get card: ' . $e->getMessage() );
            }
        }

        return isset(self::$cards[$app_name]) ? self::$cards[$app_name] : null;
    }

    public static function getCart() {
        global $woocommerce;

        if ( ! empty( $woocommerce->cart ) && empty( $woocommerce->cart->cart_contents ) ) {
            $woocommerce->cart->calculate_totals();
        }

        return $woocommerce->cart;
    }

	public static function admin_notice($app_name) {

		if ( ! Helper::isSetup() || !Helper::isSetupApp($app_name)) {
			$app_info = Helper::getApps()[$app_name];
			echo '<div class="error" style="margin-left: auto"><div style="margin: 10px auto;"> Beans: ' .
			     __( "${app_info['name']} is not properly setup.", 'beans-woo' ) .
			     ' <a href="' . admin_url($app_info['link'] ) . '">' .
			     __( 'Set up', 'beans-woo' ) .
			     '</a>' .
			     '</div></div>';
		}
	}

}
