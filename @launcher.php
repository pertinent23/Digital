<?php 
    /** 
        * 
        * Digital is the main name space used
        * in Digital PHP
        * 
    */
    namespace Digital {
        /** 
            *
            * We have to start error
            * Manager firts if it's not
            * the case
            *
        */
        \ini_set( "display_erros", "On" );
        \ini_set( "display_startup_errors", "On" );
        
        require_once DIGITAL_BASE_PATH.'Engine/Utils/AutoLoader.php';
        use Digital\Engine\Utils\AutoLoader\Engine as Engine;
        /**
            *  
            * Here we take the loader
            * from its file
            * 
        */
        abstract class Entry{

            public static string $ViewType = 'View';
            public static string $AppType = 'App';
            /** 
                * @var $data 
                * represent data set by the sever
                * you need it for manage location
                *
            */
            protected $data = array();
            /** 
                * 
                * @var $type
                * Is the type of content request to the
                * Server 
                *
            */
            protected $type;
            public function __construct( string $type )
            {
                $this->$type = $type;
                    $this->loadData( $type );
                return $this;
            }

            /** 
                * 
                * @param $stype
                * loadData is used to load data 
                * from sever in both cases. 
            */
            public function loadData( $type ) : void
            {
                $result = array();
                /** 
                    * 
                    * The root directory of
                    * our project
                    *  
                */
                $this->addData( 'base',
                    $this->keyExits( 'REDIRECT_DIGITAL_BASE' ) ?
                        $this->getenv( 'REDIRECT_DIGITAL_BASE' ) : 
                        $this->getenv( 'DIGITAL_BASE' )
                );
                if ( $type === Entry::$AppType ) {
                    /** 
                        *
                        * The path of the request 
                        * page 
                    */
                    $this->addData( 'route',
                        $this->keyExits( 'REDIRECT_DIGITAL_QUERY' ) ? 
                            $this->getenv( 'REDIRECT_DIGITAL_QUERY' ) : 
                            $this->getenv( 'DIGITAL_QUERY' )
                    );
                }  else {
                    if ( $type === Entry::$ViewType ) {
                        /** 
                            *
                            * The path of the request 
                            * page 
                        */
                        $this->addData( 'path',
                            $this->keyExits( 'REDIRECT_DIGITAL_QUERY' ) ? 
                                $this->getenv( 'REDIRECT_DIGITAL_QUERY' ) : 
                                $this->getenv( 'DIGITAL_QUERY' )
                        );
                    }
                }
                /** 
                    *
                    * If there is a query string, this
                    * path containt a query string 
                    *
                */
                $this->addData( 'query',
                    $this->getenv( 'QUERY_STRING' )
                );

                /** 
                    *
                    * Now we will try to take
                    * the ip address of the user
                    * using REMOTE_ADDR but sometimes due to a proxy
                    * we can not take the ip address using it so
                    * we use HTTP_CLIENT_IP or HTTP_X_FORWARDED_FOR
                    *
                    * We have to store that ip address
                    * in with the key `ip`
                    * 
                */
                $this->addData( 'ip',
                    $this->keyExits( 'HTTP_CLIENT_IP' ) ?
                        $this->getenv( 'HTTP_CLIENT_IP' ) :
                            ( $this->keyExits( 'HTTP_X_FORWARDED_FOR' ) ?
                            $this->getenv( 'HTTP_X_FORWARDED_FOR' ) :
                        $this->getenv( 'REMOTE_ADDR' ) )
                );
            }

            /** 
                *
                * This function get the value of the
                * key from enviroment variable
                * 
            */
            protected function getenv( string $key ) : string
            {
                if ( $this->keyExits( $key ) === TRUE ) 
                    return \getenv( $key );
                return '';
            }

            /** 
                *
                * We use this function to verify if the 
                * key have been create
                * 
            */
            protected function keyExits( string $key ) : bool {
                return array_key_exists( $key, $_SERVER );
            }

            /** 
                *
                * We use addData to add item in 
                * the list of data
                * 
            */
            protected function addData( string $key, string $val ) : void
            {
                $this->data[ $key ] = $val;
            }

            /** 
                * 
                * @return array
                * the field data 
                *
            */
            public function getData()
            {
                return $this->data;
            }

            protected function setData( $data ) : void
            {
                $this->data = $data;
            }
        }

        /** 
            * 
            * When a HTTP /1 request arrive to the server,
            * there are two possibility
            * 
            * In the first case, the request need a page
            * so the entry point is the AppBundle 
            * so All Data will be generate for AppBundle
            *
            * In the second case, if the request is not require
            * a page, so ( image, JSON, XML, .... )
            * the entry point is the ViewBundle 
            *
        */

        class ViewEntry extends Entry{
            public function __construct()
            {
                return parent::__construct( Entry::$ViewType );
            }

            public static function getViewData() : array {
                /** 
                    *
                    * Here we return data to the 
                    * Bundle 
                    * 
                */
                return (
                    ( new ViewEntry() )->getData()
                );
            }
        }

        class AppEntry extends Entry{
            public function __construct()
            {
                return parent::__construct( Entry::$AppType );
            }

            public static function getAppData() : array {
                /** 
                    *
                    * Here we return data to the 
                    * Bundle 
                    * 
                */
                return (
                    ( new AppEntry() )->getData()
                );
            }
        }

        /** 
            * 
            * Now Here we can use
            * engine
            * 
        */

        Engine::patch( Entry::$ViewType );
        Engine::patch( Entry::$AppType );
        Engine::init();
    };
?>