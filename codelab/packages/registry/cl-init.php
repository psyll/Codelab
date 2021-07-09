<?php
	if (clDB::connected()):
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
		cl::log('registry', 'success', 'Registry loaded as [clRegistry]');
	else:
		DEFINE('clRegistry', []);
		cl::log('registry', 'error', 'Database not connected');
	endif;