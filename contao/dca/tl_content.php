<?php

/**
 * Add fields with page title, needed for sorting and grouping
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['dce_page_group'] = array(
	'eval' => array('doNotShow' => true),
	'sql'  => "varchar(265) NOT NULL default ''"
);
