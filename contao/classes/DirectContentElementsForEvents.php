<?php

namespace CliffParnitzky\DirectContentElements;

use Contao\CalendarEventsModel;
use Contao\Config;
use Contao\Database;
use Contao\DataContainer;
use Contao\Date;
use Contao\Image;
use CliffParnitzky\DirectContentElements\AbstractDirectContentElements;

class DirectContentElementsForEvents extends AbstractDirectContentElements
{
	/**
	 * Initialize the table
	 */
	public function initTable()
	{
		$return = parent::initalize(__CLASS__);

		// modify sorting
		$GLOBALS['TL_DCA'][static::TABLE]['list']['sorting']['fields'] = array('dce_page_group', '(SELECT a.startDate FROM ' . $this->getParentTable() . ' a where a.id = ' . static::TABLE . '.pid) DESC', 'sorting');

		return $return;
	}

	/**
	 * Creates the name of the row containing the data for a content element
	 */
	public function getRowLabel($row, $label, DataContainer $dc)
	{
		$objEvent = CalendarEventsModel::findByPk($row['pid']);
		$this->loadLanguageFile($this->getParentTable());
		$this->loadLanguageFile(static::TABLE);

		return sprintf($GLOBALS['TL_LANG'][static::TABLE]['directContentElements']['label']['events']['row'], $objEvent->title, Date::parse(Config::get('dateFormat'), $objEvent->startDate), $GLOBALS['TL_LANG']['CTE'][$row['type']][0], $row['id']);
	}

	/**
	 * Creates the name of the group
	 */
	public function getGroupLabel($group, $sortingMode, $firstOrderBy, $row, DataContainer $dc)
	{
		$objCalendar = Database::getInstance()->prepare('SELECT p.* FROM ' . $this->getSuperParentTable() . ' p JOIN ' . $this->getParentTable() . ' a ON a.pid = p.id WHERE a.id = ?')->limit(1)->execute($row['pid']);
		return Image::getHtml('bundles/contaocalendar/calendar.svg', '', null) . " " . sprintf($GLOBALS['TL_LANG'][static::TABLE]['directContentElements']['label']['events']['group'], $objCalendar->title, $objCalendar->id);
	}

	/**
	 * Return the parent table name.
	 */
	public function getParentTable()
	{
		return 'tl_calendar_events';
	}

	/**
	 * Return the parent action name.
	 */
	public function getParentAction()
	{
		return 'calendar';
	}

	/**
	 * Return the table name of the super parent.
	 */
	public function getSuperParentTable()
	{
		return 'tl_calendar';
	}
}
