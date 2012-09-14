<?php

$sql = fopen( "ip_to_country.sql", "r" );

//Connect to your Mongo database
$m = new Mongo();
$db = $m->selectDB( 'iptocountry' );  //example database
$collection = $db->iptocountry;		  //example collection

//Cleanup the collection
$collection->drop();

function cleanup( &$item )
{
	$item = trim( $item, " '");
}

$count = 0;

while( ! feof( $sql ) )
{
	$line = fgets( $sql );
	
	/**
	 * Note: this makes a few assumptions
	 *     - Each line with data starts with a parenthesis
	 *     - Each line with data ends with a parenthesis or a comma
	 *     - Columns are in the order: IP_FROM, IP_TO, REGISTRY, ASSIGNED, CTRY, CNTRY, COUNTRY
	 *     - Country names do not have a comma
	*/
	
	if ( $line[ 0 ] != '(' ) continue;
	
	$closingPos = strrpos( $line, ")" );
	
	//Eliminate opening & closing parenthesis ( and trailing comma )
	$line =  substr( $line, 1,  $closingPos - 1 );
	
	$arr = explode( ',', $line );
	
	array_walk( $arr, 'cleanup' );
	
	$data = array( 
				'IP_FROM' 	=> (int) $arr[ 0 ], 
				'IP_TO'		=> (int) $arr[ 1 ],
				'REGISTRY'	=> $arr[ 2 ],
				'ASSIGNED'	=> $arr[ 3 ],
				'CTRY'		=> $arr[ 4 ],
				'CNTRY'		=> $arr[ 5 ],
				'COUNTRY'	=> $arr[ 6 ]
			);
	
	$collection->insert( $data );
	$count++;
	//var_dump( $data );
}

fclose( $sql );

echo "Inserted $count entries";

?>






