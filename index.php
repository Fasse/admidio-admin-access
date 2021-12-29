<?php
/******************************************************************************
 * Plugin Admin access
 *
 * Copyright    : (c) 2004-2021 The Admidio Team
 * Homepage     : http://www.admidio.org
 * Author       : Markus Faßbender
 * License      : GNU Public License 2 http://www.gnu.org/licenses/gpl-2.0.html
 * Version      : 0.9.0
 * Required     : Admidio Version 3.3
 *
 *****************************************************************************/

$rootPath = dirname(dirname(__DIR__));
$pluginFolder = basename(__DIR__);

require_once($rootPath . '/adm_program/system/common.php');

$gNavigation->clear();

// generate html output
$page = new HtmlPage('admidio-plugin-admin-access', 'Admin access');

if ($gValidLogin) {
    $page->addHtml('<div class="alert alert-primary" role="alert">Your are logged in with the  user ' . $gCurrentUser->getValue('FIRST_NAME') . ' '. $gCurrentUser->getValue('LAST_NAME') . '. If you continue, this user will be made the administrator of the deposited organizations.');
} else {
    $page->addHtml('<div class="alert alert-primary" role="alert">There is no user logged in at the moment. If you continue you must log in with a user. This user will then be assigned as administrator to all stored organizations.');
}

$page->addHtml('<br /><br /><button class="btn btn-primary" onclick="location.href=\'set_admin.php\';">Assign administrator</button></div>');

$page->addHtml('<br /><br /><div class="alert alert-danger" role="alert"><h4>!!! Important notice !!!</h4><p>Please delete this script and the complete folder <b>' . $pluginFolder . '</b> afterwards.</p>With this script other users could get admin access to your Admidio installation.</div><br />');

$page->show();
