<?php

use Contao\Controller;
use Contao\Environment;
use Contao\Input;
use Contao\System;

$request = System::getContainer()->get('request_stack')->getCurrentRequest();
$blnIsBackend = ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request));

/*
 * Backend modules
 */
// for articles
$GLOBALS['BE_MOD']['content']['directContentElementsArticles'] = [
  'tables' => ['tl_direct_content_elements_articles']
];

if ($blnIsBackend && Input::get('do') == 'directContentElementsArticles' && Input::get('act') == 'editAll' && Input::get('fields') == null) {
  Controller::redirect(str_replace('do=directContentElementsArticles', 'do=article&amp;table=tl_content', Environment::get('request')));
}

$bundles = array_keys(System::getContainer()->getParameter('kernel.bundles'));

// for calendar
if (in_array('ContaoCalendarBundle', $bundles)) {
  $GLOBALS['BE_MOD']['content']['directContentElementsEvents'] = [
    'tables' => ['tl_direct_content_elements_events']
  ];

  if ($blnIsBackend && Input::get('do') == 'directContentElementsEvents' && Input::get('act') == 'editAll' && Input::get('fields') == null) {
    Controller::redirect(str_replace('do=directContentElementsEvents', 'do=calendar&amp;table=tl_content', Environment::get('request')));
  }
}

// for news
if (in_array('ContaoNewsBundle', $bundles)) {
  $GLOBALS['BE_MOD']['content']['directContentElementsNews'] = [
    'tables' => ['tl_direct_content_elements_news']
  ];

  if ($blnIsBackend && Input::get('do') == 'directContentElementsNews' && Input::get('act') == 'editAll' && Input::get('fields') == null) {
    Controller::redirect(str_replace('do=directContentElementsNews', 'do=news&amp;table=tl_content', Environment::get('request')));
  }
}

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getUserNavigation'][] = ['CliffParnitzky\\DirectContentElements\\DirectContentElementsHooks', 'repositionMenuItems'];

/**
 * adding custom css to backend
 */
if ($blnIsBackend) {
  $GLOBALS['TL_CSS'][] = 'bundles/cliffparnitzkydirectcontentelements/backend.css';
}
