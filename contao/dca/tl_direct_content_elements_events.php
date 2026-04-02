<?php

namespace CliffParnitzky\DirectContentElements;

use CliffParnitzky\DirectContentElements\DC_DynamicTable;
use CliffParnitzky\DirectContentElements\DirectContentElementsForEvents;

$GLOBALS['TL_DCA']['tl_direct_content_elements_events'] = array(
	'config' => array(
		'dataContainer'     => DC_DynamicTable::class,
		'oncreate_callback' => array(
			array(DirectContentElementsForEvents::class, 'initTable'),
		)
	)
);
