<?php 
    namespace Digital\Template\FileManager\FileManager;
        use Exception;
        use Digital\Model\Properties\BaseFileManager\BaseManager as BaseManagerModel;
        use Digital\Template\FileManager\FileReader\FileReader as FileReader;
        use Digital\Template\FileManager\FileSaver\FileSaver as FileSaver;

        /** 
            *
            * This class is Used to
            * apply change on the file
            * 
        */
        class FileManager extends BaseManagerModel {
            /** 
                *
                * the last time the
                * file have been modified 
            */
            protected string $lastModified;
            /** 
                * the size of the
                * fiel 
            */
            protected int $size;
            /** 
                * 
                * the saver manager of the 
                * file, it is used to modified
                * the file 
            */
            protected FileSaver $saver;
            /** 
                *
                * the Reader Manager of the file
                * it is used to save the
                * file 
            */
            protected FileReader $reader;
            /** 
                * 
                * this field content the
                * type of the file 
            */
            protected string $type;
            /** 
                *
                * this field content the 
                * mimetype of the file  
            */
            protected string $minetype;

            public function __construct( string $path )
            {
                /** 
                    * 
                    * In the first time, we have to
                    * create the Reader and Saver Manager of the
                    * file the, we can
                    * set the path of this file 
                */
                $saver = new FileSaver( $path );
                $reader = new FileReader( $path );
                    $this->setSaver( $saver );
                    $this->setReader( $reader );
                $this->setPath( $path );
                $this->loadData();
            }

            /** 
                *
                * charge all data of
                * the file in here fiel
                * @return void 
            */
            public function loadData()
            {
                $filename = $this->getPath();
                    $this->size = \filesize( $filename );
                    $this->lastModified = \filemtime( $filename );
                    $this->type = \filetype( $filename );
                $this->minetype = \mime_content_type( $filename );
            }

            /** 
                *
                * this function is used to set the
                * file saver manager
                * @param FileSaver 
            */
            protected function setSaver( FileSaver $saver ) : void {
                $this->saver = $saver;
            }

            /** 
                *
                * this function is used to set the
                * file reader manager
                * @param FileReader 
            */
            protected function setReader( FileReader $reader ) : void {
                $this->reader = $reader;
            }

            /** 
                * 
                * This function return the
                * file saver Manager
                * @return FileSaver 
            */
            public function getSaver() : FileSaver {
                return $this->saver;
            }

            /** 
                *
                * this function return the
                * file reader Manager 
                * @return FileReader
            */
            public function getReader() : FileReader {
                return $this->reader;
            }

            /** 
                * 
                * this function is used
                * to create a file
                * @param string $path
                * @return int
            */
            public static function createFile( string $path ) : int {
                try{
                    fclose(
                        fopen( $path, 'w' )
                    );
                    return 1;
                } catch( Exception $e ) {
                    return 0;
                }
            }

            /** 
                *
                * This function is used to 
                * remove a file 
                * @param string $path
                * @return int
            */
            public static function removeFile( string $path ) : int {
                try{
                        unlink( $path );
                    return 1;
                } catch( Exception $e ) {
                    return 0;
                }
            }

            /** 
                *
                * this function is used to create
                * a Directory
                * @param string $path 
                * @return int 
            */
            public static function createFolder( string $path ) : int {
                try{
                        mkdir( $path );
                    return 1;
                } catch( Exception $e ) {
                    return 0;
                }
            }

            /**
                *
                * This function is used to 
                * remove a Folder
                * @param string $path
                * @return int 
            */
            public static function removeFolder( string $path ) : int {
                try{
                    $list = scandir( $path );
                        foreach ( $list as $index => $file ) {
                            if (is_dir($file)) {
                                FileManager::removeFolder( "$path/$file" );
                            } else {
                                FileManager::removeFile( "$path/$file" );
                            }
                        }
                        rmdir( $path );
                    return 1;
                } catch( Exception $e ) {
                    return 0;
                }
            } 

            /** 
                *
                * this function will remove the current
                * file
                * @return int 
            */
            public function remove() : int {
                return is_dir( $this->getPath() ) ? 
                    FileManager::removeFolder( $this->getPath() ) : 
                    FileManager::removeFile( $this->getPath() );
            }

            /** 
                * this function will createa file
                * using the current file 
                * @return int
            */
            public function create() : int {
                return is_dir( $this->getPath() ) ? 
                    FileManager::createFolder( $this->getPath() ) : 
                    FileManager::createFile( $this->getPath() );
            }
        }
?>