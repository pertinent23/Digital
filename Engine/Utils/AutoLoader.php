<?php 
    namespace Digital\Engine\Utils\AutoLoader;
        /** 
            * 
            * We use the class AutoLoader
            * to auto load our class
            * and load some parameter
            * 
        */
        class Engine{
            public static string $__BASE__ = __NAMESPACE__;
            public static function init() : bool
            {
                /** 
                    * 
                    * @we Use the function
                    * spl_autoload_register to auto 
                    * load class
                    * 
                */
                return spl_autoload_register( function ( $class ) {
                    /** 
                        *
                        * We have to replace Digital
                        * by the root url
                        *
                    */
                    $path = '';
                    if ( \preg_match( "#^Digital#", $class ) ) {
                        $url = "$class.php";
                            $result = preg_replace( "#Digital\\\#", "", $url );
                            $path = DIGITAL_BASE_PATH.preg_replace( "#\\\#", "/", $result );
                                $part = preg_split( "#/#", $path );
                                /** 
                                    * 
                                    * because the part before the 
                                    * name of the class is the 
                                    * name of the file  
                                */
                                array_pop( $part );
                        $path = implode( '/', $part );
                    } else {
                        $path = './'.$class;
                    }
                    require_once $path.".php";
                } );
            }

            /** 
                *
                * Now we can create the method encode
                * to encode some string
                * 
            */
            public static function patch( string &$var = '' ) : string
            {
                $i=0;
                $result = '';
                for ( ; $i < \strlen( $var ) ; $i++ ) 
                    $result .= ord( $var[ $i ] );
                        $var = $result;
                return $result;
            }
        }
?>