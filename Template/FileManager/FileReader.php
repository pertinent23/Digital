<?php 
    namespace Digital\Template\FileManager\FileReader;
        use Digital\Model\Properties\BaseFileManager\BaseManager as BaseManagerModel;
        use Digital\Model\Properties\BaseFileManager\Reader as ReaderModel;
        use Digital\Engine\Utils\ExceptionManager\ExceptionManager;

        class FileReader extends BaseManagerModel implements ReaderModel {
            /** 
                *
                * This field content
                * the path of the current file 
            */
            protected string $path;
            /** 
                *
                * this field content the current 
                * content of this file 
            */
            protected string $content;
            /** 
                *
                * this field content all lines
                * of a files 
            */
            protected mixed $lines;

            public function getContent()
            {
                return $this->content;
            }

            public function read()
            {
                $path = $this->path;
                $is = file_exists( $path );
                    if ( $is ) {
                            $this->content = \file_get_contents( $path );
                        return $this;
                    } else {
                        /** 
                            *
                            * If is not an existing file
                            * we have to throw an 
                            * error 
                        */
                        $error = 'We can\'t find this file';
                        return ExceptionManager::throwExeption(
                            ExceptionManager::FILE_READER,
                            $error, 1,
                            __FILE__, __LINE__
                        );
                    }
                return $this;
            }

            public function readerGetContent()
            {
                $this->read();
                return $this->getContent();
            }

            public function getLines()
            {
                return $this->lines;
            }

            public function readLines()
            {
                $path = $this->path;
                    if ( file_exists( $path ) ) {
                            $this->lines = file( $path );
                        return $this;
                    } else {
                        /** 
                            *
                            * If is not an existing file
                            * we have to throw an 
                            * error 
                        */
                        $error = 'We can\'t find this file';
                        return ExceptionManager::throwExeption(
                            ExceptionManager::FILE_READER,
                            $error, 1,
                            __FILE__, __LINE__
                        );
                    }
                return $this;
            }

            public function readerGetLines()
            {
                $this->readLines();
                return $this->getLines();
            }
        }
?>