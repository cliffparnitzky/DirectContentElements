<?php

namespace CliffParnitzky\DirectContentElements;

use CliffParnitzky\DirectContentElements\DC_DynamicTable;
use CliffParnitzky\DirectContentElements\DirectContentElementsForArticles;

$GLOBALS['TL_DCA']['tl_direct_content_elements_articles'] = array(
	'config' => array(
		'dataContainer'     => DC_DynamicTable::class,
		'oncreate_callback' => array(
			array(DirectContentElementsForArticles::class, 'initTable')
		)
	)
);
