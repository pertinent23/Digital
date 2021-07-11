<?php 
    $query = "./public".$_SERVER[ "REDIRECT_DIGITAL_QUERY" ];
    $file = fopen( $query, "r" );
    $mime = mime_content_type( $query ); 
    header( 'Content-Type: '.$mime );
    header( 'Content-Length: '.filesize( $query ) );
    fpassthru( $file );
?>