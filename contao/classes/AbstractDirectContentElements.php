<?php

namespace CliffParnitzky\DirectContentElements;

use Contao\Backend;
use Contao\Database;
use Contao\DataContainer;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;

abstract class AbstractDirectContentElements extends Backend
{
  const TABLE = 'tl_content';

  /**
   * Initialize the table
   */
  public function initalize($strDcaName)
  {
    // load dca and language
    $this->loadLanguageFile(static::TABLE);
    $this->loadDataContainer(static::TABLE);

    // modify config
    $GLOBALS['TL_DCA'][static::TABLE]['config']['closed'] = true;
    $GLOBALS['TL_DCA'][static::TABLE]['config']['ptable'] = $this->getParentTable();
    $GLOBALS['TL_DCA'][static::TABLE]['config']['onload_callback'] = array(array($strDcaName, 'refreshDirectContentElementsGroup'));

    // modify sorting
    $GLOBALS['TL_DCA'][static::TABLE]['list']['sorting']['filter'] = array(array('(ptable = ?)', $this->getParentTable()));
    $GLOBALS['TL_DCA'][static::TABLE]['list']['sorting']['mode'] = 1;
    $GLOBALS['TL_DCA'][static::TABLE]['list']['sorting']['flag'] = 11;

    // modify label
    $GLOBALS['TL_DCA'][static::TABLE]['list']['label']['fields'] = array('id');
    $GLOBALS['TL_DCA'][static::TABLE]['list']['label']['label_callback'] = array($strDcaName, 'getRowLabel');
    $GLOBALS['TL_DCA'][static::TABLE]['list']['label']['group_callback'] = array($strDcaName, 'getGroupLabel');

    // remove some operations
    unset($GLOBALS['TL_DCA'][static::TABLE]['list']['operations']['copy']);
    unset($GLOBALS['TL_DCA'][static::TABLE]['list']['operations']['cut']);

    // modfiy edit operation
    $GLOBALS['TL_DCA'][static::TABLE]['list']['operations']['edit']['href'] = 'do=' . $this->getParentAction() . '&table=' . static::TABLE . '&' . $GLOBALS['TL_DCA'][static::TABLE]['list']['operations']['edit']['href'];

    // add jump to parent operation
    $GLOBALS['TL_DCA'][static::TABLE]['list']['operations']['jump_to_' . $this->getParentAction()] = array(
      'label'               => &$GLOBALS['TL_LANG'][static::TABLE]['jump_to_' . $this->getParentAction()],
      'href'                => 'do=' . $this->getParentAction() . '&table=' . static::TABLE,
      'icon'                => 'bundles/cliffparnitzkydirectcontentelements/jump_to.png',
      'button_callback'     => array($strDcaName, 'jumpToParent')
    );

    // add additonal filter and search fields
    $GLOBALS['TL_DCA'][static::TABLE]['fields']['cssID']['filter'] = true;
    $GLOBALS['TL_DCA'][static::TABLE]['fields']['cssID']['search'] = true;
    $GLOBALS['TL_DCA'][static::TABLE]['fields']['module']['search'] = true;
    $GLOBALS['TL_DCA'][static::TABLE]['fields']['form']['search'] = true;

    return static::TABLE;
  }

  /**
   * Refresh the grouping value
   * @param DataContainer
   */
  public function refreshDirectContentElementsGroup(DataContainer $dc)
  {
    if (!Input::get('act')) {
      Database::getInstance()->prepare("UPDATE " . static::TABLE . " c SET c.dce_page_group = (SELECT CONCAT(p.title, '_', p.id) FROM " . $this->getSuperParentTable() . " p JOIN " . $this->getParentTable() . " a ON a.pid = p.id WHERE a.id = c.pid) WHERE c.ptable = ?")
        ->execute($this->getParentTable());
    }
  }

  /**
   * Return the "jump_to_parent" button
   */
  public function jumpToParent($row, $href, $label, $title, $icon, $attributes)
  {
    return '<a href="' . $this->addToUrl($href . '&id=' . $row['pid']) . '" title="' . StringUtil::specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label) . '</a> ';
  }

  /**
   * Creates the name of the row containing the data for a content element
   */
  public abstract function getRowLabel($row, $label, DataContainer $dc);

  /**
   * Creates the name of the group
   */
  public abstract function getGroupLabel($group, $sortingMode, $firstOrderBy, $row, DataContainer $dc);

  /**
   * Return the parent table name.
   */
  public abstract function getParentTable();

  /**
   * Return the parent action name.
   */
  public abstract function getParentAction();

  /**
   * Return the table name of the super parent.
   */
  public abstract function getSuperParentTable();
}
