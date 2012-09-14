# phpIp2Country

###PHP geolocalization class with free (updated daily) IPs database

( MongoDB Implementation )

Setup:

	In convertAndInsert.php, modify the Mongo connection to 
	the database & collection you want the lookup to be in.
	
		//Connect to your Mongo database
		$m = new Mongo();
		$db = $m->selectDB( 'iptocountry' );  //example database
		$collection = $db->iptocountry;		  //example collection

	Run convertAndInsert.php to add the lookup data.

Example code:

    <?
    require('phpip2country.class.php');

	//Connect to your Mongo Database
	$m = new Mongo();
	$db = $m->selectDB( 'iptocountry' );  //example database

    $phpIp2Country = new phpIp2Country('213.180.138.148',$dbConfigArray);

    print_r($phpIp2Country->getInfo(IP_INFO));
    ?>

Outputs:

    Array(
        [IP_FROM] => 3585376256
        [IP_TO] => 3585384447
        [REGISTRY] => RIPE
        [ASSIGNED] => 948758400
        [CTRY] => PL
        [CNTRY] => POL
        [COUNTRY] => POLAND
        [IP_STR] => 213.180.138.148
        [IP_VALUE] => 3585378964
        [IP_FROM_STR] => 127.255.255.255
        [IP_TO_STR] => 127.255.255.255
    )
