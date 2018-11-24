<?php

/**
* Visitor Helper
* Visitor helper on the thread display page.
*
* @package      MyBB
* @author       mdtoff <mdtoff@gmail.com>
* @version      1.0.0
* @copyright    (c) 2018 mdtoff
*/

if (!defined('IN_MYBB')) {
    die('(-_*) This file cannot be accessed directly.');
}

define('ROOT', str_replace("\\", "/", MYBB_ROOT));
define('PLUG_ROOT', ROOT . 'inc/plugins');
define('THIS_PLUG_ROOT', PLUG_ROOT . '/visitor_helper');

global $templatelist;

if (isset($templatelist)) {
    $templatelist .= ',';
}

if (defined('THIS_SCRIPT')) {
	if (THIS_SCRIPT == 'showthread.php') {
        $templatelist .= 'visitor_helper';
	}
}

if (!defined('IN_ADMINCP')) {
    if (THIS_SCRIPT == 'showthread.php') {
        $plugins->add_hook('showthread_start', 'visitor_helper');
    }
}

function visitor_helper_info() {
    global $lang;

    $lang->load('visitor_helper');

    return array(
        'name'          => $lang->visitor_helper_name,
        'description'   => $lang->visitor_helper_desc,
        'website'       => '',
        'author'        => 'mdtoff',
        'authorsite'    => 'mailto:mdtoff@gmail.com',
        'version'       => '1.0.0',
        'codename'      => 'md_visitor_helper',
        'compatibility' => '18*'
    );
}

function visitor_helper_install() {
    global $db, $cache;

    $info = visitor_helper_info();

    // Add cache
    $md = $cache->read('mdtoff');
    $md[$info['codename']] = [
        'name'      => $info['name'],
        'author'    => $info['author'],
        'version'   => $info['version'],
    ];
    $cache->update('mdtoff', $md);

    // Add templates
    $temp = visitor_helper_temp('visitor_helper');

    $db->insert_query('templates', array(
        'title'     => 'visitor_helper',
        'template'  => $db->escape_string($temp),
        'sid'       => '-1',
        'version'   => '',
        'dateline'  => time()
    ));
}

function visitor_helper_is_installed() {
    global $cache;

    $info = visitor_helper_info();

    // Check cache
    $installed = $cache->read('mdtoff');
    if ($installed[$info['codename']]) {
        return true;
    }
}

function visitor_helper_uninstall() {
    global $db, $cache;

    $info = visitor_helper_info();

    // Remove cache
    $md = $cache->read('mdtoff');
    unset($md[$info['codename']]);
    $cache->update('mdtoff', $md);

    if (count($md) == 0) {
        $db->delete_query('datacache', "title='mdtoff'");
    }

    // Remove templates
    $db->delete_query('templates', "title='visitor_helper'");
}

function visitor_helper_activate() {
    require_once ROOT . 'inc/adminfunctions_templates.php';
    find_replace_templatesets('showthread', '#' . preg_quote('{$quickreply}') . '#', "{\$visitor_helper}\n{\$quickreply}");
}

function visitor_helper_deactivate() {
    require_once ROOT . 'inc/adminfunctions_templates.php';
    find_replace_templatesets('showthread', '#' . preg_quote('{$visitor_helper}') . '#', '');
}

function visitor_helper() {
    global $mybb;

    if ($mybb->user['uid'] == 0) {
        global $lang, $theme, $templates, $visitor_helper, $visitor_helper_styles;

        $lang->load('visitor_helper');

        $visitor_helper = eval($templates->render('visitor_helper'));
    }
}

function visitor_helper_temp($temp, $ex = 'tpl') {
    $temp = trim($temp);
    $temp = THIS_PLUG_ROOT . "/templates/{$temp}.{$ex}";

    if (file_exists($temp)) {
        return file_get_contents($temp);
    } else {
        exit('<code>alert(' . $temp . ')</code>');
    }
}
