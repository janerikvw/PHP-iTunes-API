PHP-iTunes-API
==============

A super simple class for reading the iTunes API.


A simple example
----------------
This example gets the results by searching for "Maroon5" in the iTunes store of the Netherlands.
	<?php
	$results = iTunes::search('Maroon 5', array(
	    'country' => 'NL'
	))->results;
	?>
	