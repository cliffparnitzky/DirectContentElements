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
 * @copyright  Cliff Parnitzky 2014-2019
 * @author     Cliff Parnitzky
 * @package    DirectContentElements
 * @license    LGPL
 */
 
/*
 * Backend modules
 */
// for articles
array_insert($GLOBALS['BE_MOD']['content'], array_search('article', array_keys($GLOBALS['BE_MOD']['content'])) + 1, array
(
  'directContentElementsArticles' => array
  (
    'tables' => array('tl_direct_content_elements_articles')
  )
));

if(TL_MODE == 'BE' && $_GET['do'] == 'directContentElementsArticles' && $_GET['act'] == 'editAll' && $_GET['fields'] == null)
{
  \Controller::redirect(str_replace('do=directContentElementsArticles', 'do=article&amp;table=tl_content', \Environment::get('request')));
}

$bundles = array_keys(\System::getContainer()->getParameter('kernel.bundles'));

// for calendar
if (\in_array('ContaoCalendarBundle', $bundles))
{
  if(TL_MODE == 'BE' && $_GET['do'] == 'directContentElementsEvents' && $_GET['act'] == 'editAll' && $_GET['fields'] == null)
  {
    \Controller::redirect(str_replace('do=directContentElementsEvents', 'do=calendar&amp;table=tl_content', \Environment::get('request')));
  }
}

// for news
if (\in_array('ContaoNewsBundle', $bundles))
{
  if(TL_MODE == 'BE' && $_GET['do'] == 'directContentElementsNews' && $_GET['act'] == 'editAll' && $_GET['fields'] == null)
  {
    \Controller::redirect(str_replace('do=directContentElementsNews', 'do=news&amp;table=tl_content', \Environment::get('request')));
  }
}

/**
 * Hooks
 */
//$GLOBALS['TL_HOOKS']['getUserNavigation'][] = array('DirectContentElementsHooks', 'addArticleNavigation');
$GLOBALS['TL_HOOKS']['getUserNavigation'][] = array('DirectContentElementsHooks', 'addCalendarNavigationIfAvailable');
$GLOBALS['TL_HOOKS']['getUserNavigation'][] = array('DirectContentElementsHooks', 'addNewsNavigationIfAvailable');

/**
 * adding custom css to backend
 */
if (TL_MODE == 'BE')
{
  $GLOBALS['TL_CSS'][] = 'system/modules/DirectContentElements/assets/backend.css';
}

?>