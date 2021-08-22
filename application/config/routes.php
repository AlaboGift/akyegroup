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

include_once "route_slugs.php";
//routes
$r_admin = $custom_slug_array["admin"];


$route['default_controller'] = 'home_controller';
$route['404_override'] = 'home_controller/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['error-404'] = 'home_controller/error_404';

$route['login'] = 'auth_controller/login';
$route['logout'] = 'auth_controller/logout';
$route['register'] = 'auth_controller/register';
$route['reset-password'] = 'auth_controller/reset_password';
$route['confirm'] = 'auth_controller/confirm';
$route['profile/(:any)'] = 'profile_controller/profile/$1';
$route['favorites/(:any)'] = 'profile_controller/favorites/$1';
$route['followers/(:any)'] = 'profile_controller/followers/$1';
$route['following/(:any)'] = 'profile_controller/following/$1';
$route['settings'] = 'profile_controller/update_profile';
$route['settings/update-profile'] = 'profile_controller/update_profile';
$route['settings/service-profile'] = 'profile_controller/service_profile';
$route['download-guarantor'] = 'profile_controller/download_guarantor';
$route['download-referal'] = 'profile_controller/download_referal';
$route['settings/contact-informations'] = 'profile_controller/contact_informations';
$route['settings/social-media'] = 'profile_controller/social_media';
$route['settings/change-password'] = 'profile_controller/change_password';
$route['contact'] = 'home_controller/contact';
$route['members'] = 'home_controller/members';


/*product routes*/
$route['swap-now'] = 'product_controller/add_product';
$route['request-service'] = 'product_controller/request_service';
$route['pricing/(:num)'] = 'product_controller/pricing/$1';
$route['promote-product/(:num)'] = 'product_controller/promote_product/$1';
$route['update-product/(:num)'] = 'product_controller/update_product/$1';
$route['filter-products'] = 'product_controller/filter_products';
$route['products'] = 'product_controller/products';
$route['pending-products'] = 'profile_controller/pending_products';
$route['hidden-products'] = 'profile_controller/hidden_products';

/*blog routes*/
$route['blog'] = 'home_controller/blog';
$route['blog/(:any)'] = 'home_controller/category/$1';
$route['blog/tag/(:any)'] = 'home_controller/tag/$1';
$route['blog/(:any)/(:any)'] = 'home_controller/post/$1/$2';

$route['category/(:any)'] = 'product_controller/category/$1';
$route['category/(:any)/(:any)'] = 'product_controller/subcategory/$1/$2';
$route['category/(:any)/(:any)/(:any)'] = 'product_controller/third_category/$1/$2/$3';

$route["messages"] = 'message_controller/messages';
$route["messages/message/(:num)"] = 'message_controller/message/$1';

/*paypal routes*/
$route["execute-paypal-payment"] = 'product_controller/execute_paypal_payment';

$route['cron/update-sitemap'] = 'cron_controller/update_sitemap';
/*
 *
 * ADMIN ROUTES
 *
 */

/*Slider routes*/
$route[$r_admin . '/add-slider-item'] = 'admin_controller/add_slider_item';
$route[$r_admin . '/slider-items'] = 'admin_controller/slider_items';
$route[$r_admin . '/update-slider-item/(:num)'] = 'admin_controller/update_slider_item/$1';

/*page routes*/
$route[$r_admin] = 'admin_controller/index';
$route[$r_admin . '/settings'] = 'admin_controller/settings';
$route[$r_admin . '/email-settings'] = 'admin_controller/email_settings';
$route[$r_admin . '/social-login'] = 'admin_controller/social_login_settings';

$route[$r_admin . '/add-page'] = 'page_controller/add_page';
$route[$r_admin . '/update-page'] = 'page_controller/update_page';
$route[$r_admin . '/pages'] = 'page_controller/pages';
$route[$r_admin . '/pages'] = 'page_controller/pages';

/*service routes*/
$route[$r_admin . '/service-request'] = 'product_admin_controller/service_request';
$route[$r_admin . '/service-details/(:num)'] = 'product_admin_controller/service_details/$1';
$route[$r_admin . '/assign-agent/(:num)/(:any)'] = 'product_admin_controller/assign_agent/$1/$2';
/*product routes*/
$route[$r_admin . '/products'] = 'product_admin_controller/products';
$route[$r_admin . '/promoted-products'] = 'product_admin_controller/promoted_products';
$route[$r_admin . '/pending-products'] = 'product_admin_controller/pending_products';
$route[$r_admin . '/hidden-products'] = 'product_admin_controller/hidden_products';
$route[$r_admin . '/product-details/(:num)'] = 'product_admin_controller/product_details/$1';

/*page routes*/
$route[$r_admin . '/pages'] = 'page_controller/pages';
$route[$r_admin . '/update-page/(:num)'] = 'page_controller/update_page/$1';

/*category routes*/
$route[$r_admin . '/add-category'] = 'category_controller/add_category';
$route[$r_admin . '/categories'] = 'category_controller/categories';
$route[$r_admin . '/update-category/(:num)'] = 'category_controller/update_category/$1';
$route[$r_admin . '/update-subcategory/(:num)'] = 'category_controller/update_subcategory/$1';
$route[$r_admin . '/subcategories'] = 'category_controller/subcategories';
$route[$r_admin . '/add-subcategory'] = 'category_controller/add_subcategory';

/*blog routes*/
$route[$r_admin . '/blog-add-post'] = 'blog_controller/add_post';
$route[$r_admin . '/blog-posts'] = 'blog_controller/posts';
$route[$r_admin . '/update-blog-post/(:num)'] = 'blog_controller/update_post/$1';
$route[$r_admin . '/blog-categories'] = 'blog_controller/categories';
$route[$r_admin . '/update-blog-category/(:num)'] = 'blog_controller/update_category/$1';

/*comment routes*/
$route[$r_admin . '/product-comments'] = 'product_admin_controller/comments';
$route[$r_admin . '/blog-comments'] = 'blog_controller/comments';

/*review routes*/
$route[$r_admin . '/reviews'] = 'product_admin_controller/reviews';

/*ad spaces routes*/
$route[$r_admin . '/ad-spaces'] = 'admin_controller/ad_spaces';

/*seo tools routes*/
$route[$r_admin . '/seo-tools'] = 'admin_controller/seo_tools';

/*location*/
$route[$r_admin . '/location-settings'] = 'admin_controller/location_settings';
$route[$r_admin . '/countries'] = 'admin_controller/countries';
$route[$r_admin . '/states'] = 'admin_controller/states';
$route[$r_admin . '/add-country'] = 'admin_controller/add_country';
$route[$r_admin . '/update-country/(:num)'] = 'admin_controller/update_country/$1';
$route[$r_admin . '/add-state'] = 'admin_controller/add_state';
$route[$r_admin . '/update-state/(:num)'] = 'admin_controller/update_state/$1';

/*users routes*/
$route[$r_admin . '/members'] = 'admin_controller/members';
$route[$r_admin . '/service'] = 'admin_controller/service';
$route[$r_admin . '/administrators'] = 'admin_controller/administrators';
$route[$r_admin . '/add-administrator'] = 'admin_controller/add_administrator';

/*languages routes*/
$route[$r_admin . '/languages'] = 'language_controller/languages';
$route[$r_admin . '/update-language/(:num)'] = 'language_controller/update_language/$1';
$route[$r_admin . '/update-phrases/(:num)'] = 'language_controller/update_phrases/$1';

/*payment routes*/
$route[$r_admin . '/payments'] = 'admin_controller/payments';
$route[$r_admin . '/payment-details/(:num)'] = 'admin_controller/payment_details/$1';
$route[$r_admin . '/payment-settings'] = 'admin_controller/payment_settings';
$route[$r_admin . '/visual-settings'] = 'admin_controller/visual_settings';


$route[$r_admin . '/newsletter'] = 'admin_controller/newsletter';
$route[$r_admin . '/contact_messages'] = 'admin_controller/contact_messages';

$route[$r_admin . '/preferences'] = 'admin_controller/preferences';

$route['(:any)'] = 'home_controller/any/$1';
