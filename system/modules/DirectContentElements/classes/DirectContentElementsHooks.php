<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2019 Leo Feyer
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
 * @copyright  Cliff Parnitzky 2019-2019
 * @author     Cliff Parnitzky
 * @package    DirectContentElements
 * @license    LGPL
 */

/**
 * Class DirectContentElementsHooks
 *
 * Hook implementations
 * @copyright  Cliff Parnitzky 2019-2019
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class DirectContentElementsHooks
{
  /**
   * Reposition the menu items
   */
  public function repositionMenuItems($arrModules, $blnShowAll)
  {
    print_r($arrModules);
    
    $arrItem = $arrModules['content']['modules']['directContentElementsArticles'];
    print_r($arrItem);
    unset($arrModules['content']['modules']['directContentElementsArticles']);
    
    print_r($arrModules);
    //array_insert($arrModules['content']['modules'], array_search('article', array_keys($arrModules['content']['modules'])) + 1, $arrItem);
    
    print_r($arrModules);
    
    $bundles = array_keys(\System::getContainer()->getParameter('kernel.bundles'));
    if (\in_array('ContaoCalendarBundle', $bundles))
    {
    }

    return $arrModules;
  }
}

?>