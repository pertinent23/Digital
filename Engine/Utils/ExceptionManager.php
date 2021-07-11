<?php 
    namespace Digital\Engine\Utils\ExceptionManager;
        use FFI\Exception;
        use Digital\Engine\Utils\AutoLoader\Engine;
        /** 
            * 
            * We use this namespace
            * to Manage All Exceptions
            * All Exception shoul be content here
            * to easy show it to the user
            * 
            * when an  exceptions Occur
            * we have to put it in the pile
            * after that we shoul be able to get it
            * 
        */
        class ExceptionManager extends Exception{
            /** 
                * 
                * Pile content all exception
                * which have been occured in the
                * system during execution
                * 
            */
            protected static $pile = [];
            /** 
                *
                * Type is the Type of Execption
                * which have been occur
            */
            protected string $type;
            /** 
                *
                * Content the error message
                * of the exception
                * 
            */
            protected string $message;
            /** 
                *
                * Content the file where the
                * Exception occur
                * 
            */
            protected string $file;
            /** 
                *
                * Content the line where
                * the error is 
            */
            protected int $line;
            /** 
                *
                * content the code 
                * of the exception 
            */
            public function __construct( string $type, string $message, int $code, string $file = __FILE__, int $line = __LINE__ )
            {
                parent::__construct( $message, $code );
                    $this->setFile( $file );
                    $this->setLine( $line );
                    $this->setType( $type );
                ExceptionManager::pushExecption( $this );
            }

            /** 
                * 
                * To set the exception Line
                * @param int $line
            */
            protected function setLine( int $line ) : void {
                $this->line = $line;
            }

            /** 
                *
                * To set the Exception
                * File 
            */
            protected function setFile( string $fine ) : void {
                $this->fine = $fine;
            }

            /** 
                * 
                * To set The Exepction
                * type 
            */
            protected function setType( string $type ) : void {
                $this->type = $type;
            }

            /** 
                * To get The Expetion
                * type
                * @return void 
            */
            public function getType() : string {
                return $this->type;
            }

            /** 
                * 
                * Here we use this function
                * to save all exception in a 
                * array 
            */
            public static function pushExecption ( ExceptionManager $e ) : mixed {
                return array_push(
                    self::$pile,
                    $e
                );
            }

            /** 
                *
                * Return true if the pile 
                * is not empty 
                * @return bool
            */
            public static function is() : bool {
                return (
                    count( self::$pile ) === 0
                );
            }

            /** 
                * 
                * Return all expception
                * which have occured
            */
            public static function getAllExption () : mixed {
                return (
                    self::$pile
                );
            }

            /** 
                *
                * we use this function
                * to throw an exception
                * @return void
            */
            public static function throwExeption( string $type, string $message, int $code, string $file = __FILE__, int $line = __LINE__ ) : void {
                throw new ExceptionManager( $type, $message, $code, $file, $line );
            }

            /**
                *
                * Used to return
                * an exception code 
            */
            public static function createType( string $type ) : string {
                return Engine::patch( $type ); 
            }

            /** 
                *
                * Now we can define all our
                * Exception type
                * Here, they we require to 
                * create on extension 
            */
            public static const FILE_SAVER = ExceptionManager::createType( 'FILE_SAVER' );
            public static const FILE_READER = ExceptionManager::createType( 'FILE_READER' );
        }
?>