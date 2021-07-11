<?php 
    namespace Digital\Template\TaggedDocument\Elements;
        use Digital\Engine\Utils\AutoLoader\Engine as Engine;

        interface NodeInterface {
            public function getContent();
            public function getNodeType();
        };

        class Node implements NodeInterface {
            protected string $name;
            protected int $type;
            protected mixed $content;

            public function __construct( string $name, int $type, string $content )
            {
                $this->setName( $name );
                    $this->setType( $type );
                $this->content = $content;
            }

            protected function setName( string $name ) {
                $this->name = $name;
            }

            public function getNodeName() : string {
                return $this->name;
            }

            protected function setType( int $type ) {
                $this->type = $type;
            }

            public function getNodeType() : int {
                return $this->type;
            }

            public static function createType( $type ) : int {
                return (
                    intval(
                        Engine::patch( $type )
                    )
                );
            }

            public function getContent() {
                return $this->content;
            }

            public static const NODE_ATTRIBUTE = Node::createType( 'attribut' );
            public static const NODE_ELEMENT = Node::createType( 'element' );
            public static const NODE_LIST = Node::createType( 'node_list' );
            public static const TEXT_NODE = Node::createType( 'text_node' );
        }

        class Element extends Node implements NodeInterface{
            protected mixed $attrs = [];
        }
?>