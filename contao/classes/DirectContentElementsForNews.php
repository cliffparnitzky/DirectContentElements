<?php

namespace CliffParnitzky\DirectContentElements;

use Contao\Config;
use Contao\Database;
use Contao\DataContainer;
use Contao\Date;
use Contao\Image;
use Contao\NewsModel;
use CliffParnitzky\DirectContentElements\AbstractDirectContentElements;

class DirectContentElementsForNews extends AbstractDirectContentElements
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
		$objNews = NewsModel::findByPk($row['pid']);
		$this->loadLanguageFile($this->getParentTable());
		$this->loadLanguageFile(static::TABLE);

		return sprintf($GLOBALS['TL_LANG'][static::TABLE]['directContentElements']['label']['news']['row'], $objNews->headline, Date::parse(Config::get('datimFormat'), $objNews->date), $GLOBALS['TL_LANG']['CTE'][$row['type']][0], $row['id']);
	}

	/**
	 * Creates the name of the group
	 */
	public function getGroupLabel($group, $sortingMode, $firstOrderBy, $row, DataContainer $dc)
	{
		$objNewsArchive = Database::getInstance()->prepare('SELECT p.* FROM ' . $this->getSuperParentTable() . ' p JOIN ' . $this->getParentTable() . ' a ON a.pid = p.id WHERE a.id = ?')->limit(1)->execute($row['pid']);
		return Image::getHtml('bundles/contaonews/news.svg', '', null) . " " . sprintf($GLOBALS['TL_LANG'][static::TABLE]['directContentElements']['label']['news']['group'], $objNewsArchive->title, $objNewsArchive->id);
	}

	/**
	 * Return the parent table name.
	 */
	public function getParentTable()
	{
		return 'tl_' . $this->getParentAction();
	}

	/**
	 * Return the parent action name.
	 */
	public function getParentAction()
	{
		return 'news';
	}

	/**
	 * Return the table name of the super parent.
	 */
	public function getSuperParentTable()
	{
		return 'tl_news_archive';
	}
}
