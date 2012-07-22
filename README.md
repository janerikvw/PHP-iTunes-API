PHP-iTunes-API
==============

A super simple class for reading the iTunes API.


A simple search example
----------------------
This example gets the results by searching for "Maroon5" in the iTunes store of the Netherlands. The results are stored in an array.
	<?php
	$results = iTunes::search('Maroon 5', array(
	    'country' => 'NL'
	))->results;
	?>

A simple lookup example
----------------------
Get the albums of the artist with the id "909253".
	<?php
	$albums = iTunes::lookup(909253, 'id', array(
		'entity' => 'album'
	))->results;
	?>

For all the config information look at the iTunes API page:
http://www.apple.com/itunes/affiliates/resources/documentation/itunes-store-web-service-search-api.html