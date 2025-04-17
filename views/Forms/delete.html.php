<?php
	
	use Class\SnakeManager;
	
	$manager = new SnakeManager();
	
	$id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ) ?? null;
	if( $id ) {
		$manager->delete( $id );
	}
	
	header( "Location: index.php?page=list" );
	exit;
