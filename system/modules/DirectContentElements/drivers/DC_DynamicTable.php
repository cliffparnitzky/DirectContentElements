<?php

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that
 * specializes in accessibility and generates W3C-compliant HTML code. It
 * provides a wide range of functionality to develop professional websites
 * including a built-in search engine, form generator, file and user manager,
 * CSS engine, multi-language support and many more. For more information and
 * additional TYPOlight applications like the TYPOlight MVC Framework please
 * visit the project website http://www.typolight.org.
 *
 * PHP version 5
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    System
 * @license    LGPL
 * @filesource
 */

/**
 * Class DC_DynamicTable
 *
 * Driver class that allows a callback to redefine the tablename on the fly.
 * Currently used by FormAuto, Catalog
 * @copyright  Thyon Design 2008 
 * @author     John Brand <john.brand@thyon.com> 
 * @package    DynamicTable
 */

class DC_DynamicTable extends DC_Table
{

  /**
	 * Initialize the object
	 * @param string
	 */


	public function __construct($strTable)
	{

		// HOOK: add custom create function
		if (array_key_exists('oncreate_callback', $GLOBALS['TL_DCA'][$strTable]['config']) && is_array($GLOBALS['TL_DCA'][$strTable]['config']['oncreate_callback']))
		{
			foreach ($GLOBALS['TL_DCA'][$strTable]['config']['oncreate_callback'] as $callback)
			{
				$this->import($callback[0]);
				$strTable =$this->{$callback[0]}->{$callback[1]}($strTable);
			}
		}

		parent::__construct($strTable);
	}

}

?>