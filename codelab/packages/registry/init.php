<?php
	$param = array(
		'table' => 'registry',
		'columns' => ['name', 'value'],
	 );
	$results = clDB::get($param);
	$clRegistryQuery = array();
	foreach ($results as $key => $value):
		$clRegistryQuery[$value['name']] = $value['value'];
	endforeach;
	DEFINE('clRegistry', $clRegistryQuery);
	unset($clRegistryQuery);