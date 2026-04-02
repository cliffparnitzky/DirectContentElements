<?php

namespace CliffParnitzky\DirectContentElements;

use Contao\ArrayUtil;
use Contao\System;

class DirectContentElementsHooks
{
  /**
   * Reposition the menu items
   */
  public function repositionMenuItems($arrModules, $blnShowAll)
  {
    $arrModules = $this->moveMenuItem($arrModules, 'directContentElementsArticles', 'article');

    $bundles = array_keys(System::getContainer()->getParameter('kernel.bundles'));
    if (in_array('ContaoCalendarBundle', $bundles)) {
      $arrModules = $this->moveMenuItem($arrModules, 'directContentElementsEvents', 'calendar');
    }
    if (in_array('ContaoNewsBundle', $bundles)) {
      $arrModules = $this->moveMenuItem($arrModules, 'directContentElementsNews', 'news');
    }

    return $arrModules;
  }

  private function moveMenuItem($arrModules, $strItemToMove, $strItemToInsertAfter)
  {
    if (empty($arrModules['content']['modules']) || !isset($arrModules['content']['modules'][$strItemToMove])) {
      return $arrModules;
    }
    $arrItem = [$strItemToMove => $arrModules['content']['modules'][$strItemToMove]];
    unset($arrModules['content']['modules'][$strItemToMove]);
    ArrayUtil::arrayInsert($arrModules['content']['modules'], array_search($strItemToInsertAfter, array_keys($arrModules['content']['modules'])) + 1, $arrItem);

    return $arrModules;
  }
}
