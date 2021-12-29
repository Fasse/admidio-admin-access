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
require_once($rootPath . '/adm_program/system/login_valid.php');

$assignedRoles = array();

// read all admin roles
$sql = 'SELECT rol_id, rol_name, org_longname
          FROM '.TBL_ROLES.'
         INNER JOIN ' . TBL_CATEGORIES . ' ON cat_id = rol_cat_id
         INNER JOIN ' . TBL_ORGANIZATIONS . ' ON org_id = cat_org_id
         WHERE rol_administrator = true ';
$adminStatement = $gDb->queryPrepared($sql);

// assign the current user to the admin roles
while ($row = $adminStatement->fetch()) {
    $membership = new TableMembers($gDb);
    $membership->startMembership((int) $row['rol_id'], $gCurrentUser->getValue('usr_id'));

    $assignedRoles[] = $row;
}

$gNavigation->clear();

// generate html output
$page = new HtmlPage('admidio-plugin-admin-access', 'Admin access');
$page->addHtml('<div class="alert alert-primary" role="alert">The current user ' . $gCurrentUser->getValue('FIRST_NAME') . ' '. $gCurrentUser->getValue('LAST_NAME') . ' was assigned to the following roles:<br /><br />');

foreach($assignedRoles as $role) {
    $page->addHtml('<p><b>' . $role['rol_name'] . '</b> of the organization ' . $role['org_longname'] . '</p>');
}

$page->addHtml('</div><br /><br /><div class="alert alert-danger" role="alert"><h4>!!! Important notice !!!</h4><p>Please delete this script and the complete folder <b>' . $pluginFolder . '</b>.</p>With this script other users could get admin access to your Admidio installation.</div><br />');

$page->show();
