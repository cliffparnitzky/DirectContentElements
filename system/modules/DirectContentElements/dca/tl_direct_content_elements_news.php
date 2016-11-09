<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2016 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Cliff Parnitzky 2014-2016
 * @author     Cliff Parnitzky
 * @package    DirectContentElements
 * @license    LGPL
 */

/**
 * Table tl_direct_content_elements_news
 */
$GLOBALS['TL_DCA']['tl_direct_content_elements_news'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'     => 'DynamicTable',
		'oncreate_callback' => array
		(
			array('tl_direct_content_elements_news', 'initTable'),
		)
	)
);

/**
 * Class tl_direct_content_elements_news
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Cliff Parnitzky 2014-2016
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class tl_direct_content_elements_news extends DirectContentElements
{
	/**
	 * Initialize the table
	 */
	public function initTable()
	{
		$return = parent::initalize(__CLASS__);
		
		// modify sorting
		$GLOBALS['TL_DCA'][static::TABLE]['list']['sorting']['fields'] = array('dce_page_group', '(SELECT a.date FROM ' . $this->getParentTable() . ' a where a.id = ' . static::TABLE . '.pid) DESC', 'sorting');
		
		return $return;
	}
	
	/**
	 * Creates the name of the row containing the data for a content element
	 */
	public function getRowLabel($row, $label, DataContainer $dc)
	{
		$objNews = \NewsModel::findByPk($row['pid']);
		$this->loadLanguageFile($this->getParentTable());
		$this->loadLanguageFile(static::TABLE);
		
		return sprintf($GLOBALS['TL_LANG'][static::TABLE]['directContentElements']['label']['news']['row'], $objNews->headline, Date::parse(Config::get('datimFormat'), $objNews->date), $GLOBALS['TL_LANG']['CTE'][$row['type']][0], $row['id']);
	}
	
	/**
	 * Creates the name of the group
	 */
	public function getGroupLabel($group, $sortingMode, $firstOrderBy, $row, DataContainer $dc)
	{
		$objNewsArchive = \Database::getInstance()->prepare('SELECT p.* FROM ' . $this->getSuperParentTable() . ' p JOIN ' . $this->getParentTable() . ' a ON a.pid = p.id WHERE a.id = ?')->limit(1)->execute($row['pid']);
		return \Image::getHtml('system/modules/news/assets/icon.gif', '', null) . " " . sprintf($GLOBALS['TL_LANG'][static::TABLE]['directContentElements']['label']['news']['group'], $objNewsArchive->title, $objNewsArchive->id);
	}
	
	/**
	 * Return the parent table name.
	 */
	public function getParentTable(){
		return 'tl_' . $this->getParentAction();
	}
	
	/**
	 * Return the parent action name.
	 */
	public function getParentAction(){
		return 'news';
	}
	
	/**
	 * Return the table name of the super parent.
	 */
	public function getSuperParentTable(){
		return 'tl_news_archive';
	}

}

?>