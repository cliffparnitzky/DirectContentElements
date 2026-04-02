<?php

namespace CliffParnitzky\DirectContentElements;

use CliffParnitzky\DirectContentElements\DC_DynamicTable;
use CliffParnitzky\DirectContentElements\DirectContentElementsForNews;

$GLOBALS['TL_DCA']['tl_direct_content_elements_news'] = array(
	'config' => array(
		'dataContainer'     => DC_DynamicTable::class,
		'oncreate_callback' => array(
			array(DirectContentElementsForNews::class, 'initTable'),
		)
	)
);
