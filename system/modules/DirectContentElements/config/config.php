<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2023 Leo Feyer
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
 * @copyright  Cliff Parnitzky 2014-2023
 * @author     Cliff Parnitzky
 * @package    DirectContentElements
 * @license    LGPL
 */
 
/*
 * Backend modules
 */
// for articles
$GLOBALS['BE_MOD']['content']['directContentElementsArticles'] = array
(
  'tables' => array('tl_direct_content_elements_articles')
);

if (TL_MODE == 'BE' && Input::get('do') == 'directContentElementsArticles' && Input::get('act') == 'editAll' && Input::get('fields') == null)
{
  \Controller::redirect(str_replace('do=directContentElementsArticles', 'do=article&amp;table=tl_content', \Environment::get('request')));
}

$bundles = array_keys(\System::getContainer()->getParameter('kernel.bundles'));

// for calendar
if (\in_array('ContaoCalendarBundle', $bundles))
{
  $GLOBALS['BE_MOD']['content']['directContentElementsEvents'] = array
  (
    'tables' => array('tl_direct_content_elements_events')
  );

  if (TL_MODE == 'BE' && Input::get('do') == 'directContentElementsEvents' && Input::get('act') == 'editAll' && Input::get('fields') == null)
  {
    \Controller::redirect(str_replace('do=directContentElementsEvents', 'do=calendar&amp;table=tl_content', \Environment::get('request')));
  }
}

// for news
if (\in_array('ContaoNewsBundle', $bundles))
{
  $GLOBALS['BE_MOD']['content']['directContentElementsNews'] = array
  (
    'tables' => array('tl_direct_content_elements_news')
  );

  if (TL_MODE == 'BE' && Input::get('do') == 'directContentElementsNews' && Input::get('act') == 'editAll' && Input::get('fields') == null)
  {
    \Controller::redirect(str_replace('do=directContentElementsNews', 'do=news&amp;table=tl_content', \Environment::get('request')));
  }
}

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getUserNavigation'][] = array('DirectContentElementsHooks', 'repositionMenuItems');

/**
 * adding custom css to backend
 */
if (TL_MODE == 'BE')
{
  $GLOBALS['TL_CSS'][] = 'system/modules/DirectContentElements/assets/backend.css';
}

?>