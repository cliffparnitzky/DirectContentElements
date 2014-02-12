<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
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
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @package    DirectContentElements
 * @license    LGPL
 */
 
/*
 * Backend modules
 */
array_insert($GLOBALS['BE_MOD']['content'], count($GLOBALS['BE_MOD']['article'])+1, array
(
	'directContentElements' => array
	(
		'tables' => array('tl_direct_content_elements'),
		'icon'   => 'system/modules/DirectContentElements/assets/icon.png'
	)
));

if(TL_MODE == 'BE' && $_GET['do'] == 'directContentElements' && $_GET['act'] == 'editAll' && $_GET['fields'] == null)
{
	\Controller::redirect(str_replace('do=directContentElements', 'do=article&amp;table=tl_content', \Environment::get('request')));
}


?>