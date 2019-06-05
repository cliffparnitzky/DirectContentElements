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
   * Add the navigation entry below calendar
   */
  public function addCalendarNavigationIfAvailable($arrModules, $blnShowAll)
  {
    $bundles = array_keys(\System::getContainer()->getParameter('kernel.bundles'));
    if (\in_array('ContaoCalendarBundle', $bundles))
    {
      $strModuleName = 'directContentElementsEvents';
      
      /** @var RouterInterface $router */
      $router = \System::getContainer()->get('router');
      
      $strRefererId = \System::getContainer()->get('request_stack')->getCurrentRequest()->attributes->get('_contao_referer_id'); 
      
      array_insert($arrModules['content']['modules'], array_search('calendar', array_keys($arrModules['content']['modules'])) + 1, array
      (
        $strModuleName => array
        (
          'tables' => array('tl_direct_content_elements_events'),
          'label'        => \StringUtil::specialchars($GLOBALS['TL_LANG']['MOD'][$strModuleName][0]),
          'title'        => \StringUtil::specialchars($GLOBALS['TL_LANG']['MOD'][$strModuleName][1]),
          'class'        => 'navigation ' . $strModuleName,
          'href'         => $router->generate('contao_backend', array('do'=>$strModuleName, 'ref'=>$strRefererId)),
          'isActive'     => false
        )
      ));
    }

    return $arrModules;
  }
  
  /**
   * Add the navigation entry below news
   */
  public function addNewsNavigationIfAvailable($arrModules, $blnShowAll)
  {
    $bundles = array_keys(\System::getContainer()->getParameter('kernel.bundles'));
    if (\in_array('ContaoNewsBundle', $bundles))
    {
      array_insert($arrModules['content']['modules'], array_search('news', array_keys($arrModules['content']['modules'])) + 1, array
      (
        'directContentElementsNews' => array
        (
          'tables' => array('tl_direct_content_elements_news')
        )
      ));
    }

    return $arrModules;
  }
}

?>