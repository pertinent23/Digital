<?php 
    namespace Digital\Template\FileManager\FileSaver;
        use Digital\Template\FileManager\FileManager\FileManager as FileManager;
        use Digital\Model\Properties\BaseFileManager\BaseManager as BaseManagerModel;
        use Digital\Model\Properties\BaseFileManager\Saver as SaverModel;
        use Digital\Engine\Utils\ExceptionManager\ExceptionManager;

        class FileSaver extends BaseManagerModel implements SaverModel {
            /** 
                *
                * This field content
                * the path of the current file 
            */
            protected string $path = '';
            /** 
                *
                * this field content the current 
                * content of this file 
            */
            protected string $content = '';
            /** 
                *
                * this field content all lines
                * of a files 
            */
            protected mixed $lines;


            public function save()
            {
                $content = $this->content;
                $path = $this->path;
                $is = file_exists( $path );
                    if ( $is && is_string( $content ) ) {
                            file_put_contents( $path, $content );
                        return true;
                    } else {
                        if ( !$is ) {
                                FileManager::createFile( $path );
                            return $this->save();
                        } else {
                            /** 
                                *
                                * if the content of the file
                                * is not a string, we have to 
                                * throw an error 
                            */
                            $error = 'The content of the file should be a string.';
                            return ExceptionManager::throwExeption(
                                ExceptionManager::FILE_SAVER,
                                $error, 1,
                                __FILE__, __LINE__
                            );
                        } 
                    }
                return false;
            }

            public function saveContent( string $content )
            {
                $this->setContent( $content );
            }

            public function setContent( string $content )
            {
                $this->content = $content;
            }

            public function addContent( string $content )
            {
                $this->setContent( $this->content . $content );
            }

            public function saverAddContent( string $content )
            {
                $this->addContent( $content );
                return $this->save();
            }

            public function setLines( mixed $lines ) {
                $this->lines = $lines;
                    $content = &$this->content;
                        for ( $i = 0; $i < count( $lines ); $i++ ) { 
                            if ( $content === '' ) {
                                $content .= $lines[ $i ];
                            } else {
                                $content .= "\n".$lines[ $i ];
                            }
                        }
                return $content;
            }

            public function addLines( mixed $lines ) {
                    $this->setLines( array_merge( $this->lines, $lines ) );
                return $this;
            }

            public function saveAllLines( mixed $lines ) {
                    $this->setLines( $lines );
                return $this->save();
            }

            public function saveAddedLines( mixed $lines ) {
                    $this->addLines( $lines );
                return $this->save();
            }
        }
?>