<?php

namespace CliffParnitzky\DirectContentElements;

use Contao\DC_Table;

class DC_DynamicTable extends DC_Table
{
	public function __construct($strTable)
	{
		// HOOK: add custom create function
		if (array_key_exists('oncreate_callback', $GLOBALS['TL_DCA'][$strTable]['config']) && is_array($GLOBALS['TL_DCA'][$strTable]['config']['oncreate_callback'])) {
			foreach ($GLOBALS['TL_DCA'][$strTable]['config']['oncreate_callback'] as $callback) {
				$this->import($callback[0]);
				$strTable = $this->{$callback[0]}->{$callback[1]}($strTable);
			}
		}

		parent::__construct($strTable);
	}
}
