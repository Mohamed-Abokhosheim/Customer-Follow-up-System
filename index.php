<?php
session_start();

require_once __DIR__ . '/app/config/db.php';
require_once __DIR__ . '/app/helpers/i18n.php';
require_once __DIR__ . '/app/helpers/flash.php';
require_once __DIR__ . '/app/helpers/router.php';
require_once __DIR__ . '/app/middleware/auth.php';
require_once __DIR__ . '/app/middleware/csrf.php';

I18n::init();

Router::add('dashboard', 'DashboardController@index');
Router::add('leads', 'LeadController@index');
Router::add('leads/create', 'LeadController@create');
Router::add('leads/view', 'LeadController@view');
Router::add('followups', 'FollowupController@index');
Router::add('reports', 'ReportController@index');
Router::add('admin/users', 'UserController@index');
Router::add('admin/services', 'ServiceController@index');
Router::add('admin/sources', 'SourceController@index');
Router::add('logout', 'AuthController@logout');
Router::add('set_lang', 'AuthController@setLang');

CSRF::generate();

Router::run();