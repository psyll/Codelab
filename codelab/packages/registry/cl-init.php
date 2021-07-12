<?php
	if (CodelabDB::connected()):
		$param = array(
			'table' => 'registry',
			'columns' => ['name', 'value'],
		);
		$results = CodelabDB::get($param);
		$clRegistryQuery = array();
		foreach ($results as $key => $value):
			$clRegistryQuery[$value['name']] = $value['value'];
		endforeach;
		DEFINE('REGISTRY', $clRegistryQuery);
		unset($clRegistryQuery);
		Codelab::log('registry', 'success', 'Registry loaded as [clRegistry]');
	else:
		DEFINE('REGISTRY', []);
		Codelab::log('registry', 'error', 'Database not connected');
	endif;