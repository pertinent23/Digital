<?php 
    namespace Digital\Model\Properties\BaseFileManager;
        /** 
            * 
            * This file provide the root
            * of all file manager system of all the 
            * framework
            * 
        */
        abstract class BaseManager{
            /** 
                *
                * BaseManager is the base of 
                * all fileManager in Digital Php
                * it is used to set end get Path
            */
            protected string $path;
            public function __construct( $path )
            {
                /** 
                    * we have to save the
                    * path in the first time 
                */
                $this->setPath( $path );
            }
            /** 
                *
                * Set the value of the 
                * file path
                * @param string $path
                * @return void 
            */
            protected function setPath( string $path ) : void
            {
                $this->path = DIGITAL_BASE_PATH.$path;
            }

            /** 
                *
                * Return the value of the
                * field Path 
            */
            public function getPath() : string
            {
                return $this->path;
            }
        }

        /** 
            *
            * the interface save is the 
            * root of all saver Manager
            * in Digital PHP 
        */
        interface Saver {
            /** 
                * 
                * Set the content of a file
                * if the content another thing,
                * this content will be changer
                *  @param string $content
            */
            public function setContent( string $content );
            /** 
                * 
                * add a data to the content of the file
                * if the file is empty this content 
                * we be set 
            */
            public function addContent( string $content );
            /** 
                *
                * this function add data to the content
                * of the file and save it 
            */
            public function saverAddContent( string $content );
            /** 
                *
                * this function set the content
                * of the file then save it 
            */
            public function saveContent( string $content );
            /** 
                * 
                * this function save the 
                * content of the file 
            */
            public function save();
            /** 
                *
                * this function save 
                * all the file of a file 
            */
            public function saveAllLines( mixed $lines );
            /** 
                *
                * this function add all line
                * of a file
                * 
            */
            public function saveAddedLines( mixed $lines );
            /** 
                *
                * this function add Line of a 
                * file 
            */
            public function addLines( mixed $lines );
            /** 
                * 
                * this function set the lines
                * of a file 
            */
            public function setLines( mixed $lines ); 
        }

        /** 
            *
            * the interface save is the 
            * root of all Reader Manager
            * in Digital PHP 
        */
        interface Reader {
            /** 
                *
                *  this function return the content
                * of the file 
                * @return string;
            */
            public function getContent();
            /** 
                * this function read the file then
                * return it's content 
                * @return string
            */
            public function readerGetContent();
            /** 
                * 
                * this function read the
                * file
                * @return void 
            */
            public function read();
            /** 
                *
                * this function read the file
                * then return all his line 
            */
            public function getLines();
            /** 
                * this function read
                * all lines of a file 
            */
            public function readLines();
            /** 
                * this function read all lines of a files
                * the return it 
            */
            public function readerGetLines();
        }
?>