<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 	= 'login';
$route['404_override'] 			= 'dashboard/routeNotFound';
$route['translate_uri_dashes'] 	= FALSE;

$route['login']					=	'login';
$route['check-auth']			=	'login/auth';

$route['dashboard']		=	'dashboard';
//$route['download-excel/(:any)']	=	'dashboard/download_excel/$1';

$route['clients'] = 'Client';
$route['all-clients'] = 'Client/get_all_clients';
$route['add-client'] = 'Client/add_client';
$route['create-client'] = 'Client/create_client';
$route['delete-client'] = 'Client/delete_client';
$route['view-client/(:any)']   = 'Client/view_client/$1';
$route['edit-client/(:any)']   = 'Client/edit_client/$1';
$route['update-client/(:any)'] = 'Client/update_client/$1';

$route['industries']      = 'Industry';
$route['all-industries']  = 'Industry/get_all_industries';
$route['add-industry']    = 'Industry/add_industry';
$route['create-industry'] = 'Industry/create_industry';
$route['delete-industry'] = 'Industry/delete_industry';
$route['view-industry/(:any)']   = 'Industry/view_industry/$1';
$route['edit-industry/(:any)']   = 'Industry/edit_industry/$1';
$route['update-industry/(:any)'] = 'Industry/update_industry/$1';
$route['popular-industries']      = 'Industry/popular_industries';
$route['all-popular-industries']  = 'Industry/get_all_popular_industries';

$route['reports'] = 'Report';
$route['all-reports'] = 'Report/get_all_reports';
$route['add-report'] = 'Report/add_report';
$route['create-report'] = 'Report/create_report';
$route['delete-report'] = 'Report/delete_report';
$route['view-report/(:any)']   = 'Report/view_report/$1';
$route['edit-report/(:any)']   = 'Report/edit_report/$1';
$route['update-report/(:any)'] = 'Report/update_report/$1';

$route['blogs'] = 'Blog';
$route['all-blogs'] = 'Blog/get_all_blogs';
$route['add-blog'] = 'Blog/add_blog';
$route['create-blog'] = 'Blog/create_blog';
$route['delete-blog'] = 'Blog/delete_blog';
$route['view-blog/(:any)']   = 'Blog/view_blog/$1';
$route['edit-blog/(:any)']   = 'Blog/edit_blog/$1';
$route['update-blog/(:any)'] = 'Blog/update_blog/$1';

$route['news'] = 'news';
$route['all-news'] = 'News/get_all_news';
$route['add-news'] = 'News/add_news';
$route['create-news'] = 'News/create_news';
$route['delete-news'] = 'News/delete_news';
$route['view-news/(:any)']   = 'News/view_news/$1';
$route['edit-news/(:any)']   = 'News/edit_news/$1';
$route['update-news/(:any)'] = 'News/update_news/$1';

//api url
$route['get-reports']	=	'Api/get_reports';
$route['get-featured-reports']	=	'Api/get_featured_reports';
$route['get-blogs']		=	'Api/get_blogs';
$route['get-industries']=	'Api/get_industries';
$route['get-popular-industries']=	'Api/get_popular_industries';
$route['get-news']		=	'Api/get_news';
$route['get-clients']		=	'Api/get_clients';
$route['get-all-industries']=	'Api/get_all_industries';
$route['get-all-publish-status']=	'Api/get_all_publish_status';
$route['add-user']      =	'Api/add_user';
$route['user-login']    =	'Api/user_login';
$route['get-single-report/(:any)']	=	'Api/get_report_by_id/$1';
$route['get-single-blog/(:any)']	=	'Api/get_blog_by_id/$1';
$route['add-inquiry']   =	'Api/add_inquiry';

