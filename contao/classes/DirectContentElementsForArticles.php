<?php

namespace CliffParnitzky\DirectContentElements;

use Contao\ArticleModel;
use Contao\Controller;
use Contao\Database;
use Contao\DataContainer;
use Contao\Image;
use Contao\PageModel;
use CliffParnitzky\DirectContentElements\AbstractDirectContentElements;

class DirectContentElementsForArticles extends AbstractDirectContentElements
{
	/**
	 * Initialize the table
	 */
	public function initTable()
	{
		$return = parent::initalize(__CLASS__);

		// modify sorting
		$GLOBALS['TL_DCA'][static::TABLE]['list']['sorting']['fields'] = array('dce_page_group', '(SELECT a.sorting FROM ' . $this->getParentTable() . ' a where a.id = ' . static::TABLE . '.pid)', 'sorting');

		return $return;
	}

	/**
	 * Creates the name of the row containing the data for a content element
	 */
	public function getRowLabel($row, $label, DataContainer $dc)
	{
		$objArticle = ArticleModel::findByPk($row['pid']);
		$this->loadLanguageFile($this->getParentTable());
		$this->loadLanguageFile(static::TABLE);

		$strInColumnText = $GLOBALS['TL_LANG']['COLS'][$objArticle->inColumn];

		return sprintf($GLOBALS['TL_LANG'][static::TABLE]['directContentElements']['label']['articles']['row'], $objArticle->title, $strInColumnText, $GLOBALS['TL_LANG']['CTE'][$row['type']][0], $row['id']);
	}

	/**
	 * Creates the name of the group
	 */
	public function getGroupLabel($group, $sortingMode, $firstOrderBy, $row, DataContainer $dc)
	{
		$objPageId = Database::getInstance()->prepare('SELECT p.id FROM ' . $this->getSuperParentTable() . ' p JOIN ' . $this->getParentTable() . ' a ON a.pid = p.id WHERE a.id = ?')->limit(1)->execute($row['pid'])->id;
		$objPage = PageModel::findWithDetails($objPageId);
		return Image::getHtml(Controller::getPageStatusIcon($objPage), '', null) . " " . sprintf($GLOBALS['TL_LANG'][static::TABLE]['directContentElements']['label']['articles']['group'], $objPage->title, $objPage->id, $objPage->rootTitle);
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
		return 'article';
	}

	/**
	 * Return the table name of the super parent.
	 */
	public function getSuperParentTable()
	{
		return 'tl_page';
	}
}
