<?php
/*
 * Custom Helpers
 *
 */
if ( ! function_exists('force_download'))
{
 function force_download($filename = '', $data = '')
 {
  if ($filename == '' OR $data == '')
  {
   return FALSE;
  }

  // Try to determine if the filename includes a file extension.
  // We need it in order to set the MIME type
  if (FALSE === strpos($filename, '.'))
  {
   return FALSE;
  }
 
  // Grab the file extension
  $x = explode('.', $filename);
  $extension = end($x);

  // Load the mime types
  @include(APPPATH.'config/mimes'.EXT);
 
  // Set a default mime if we can't find it
  if ( ! isset($mimes[$extension]))
  {
   $mime = 'application/octet-stream';
  }
  else
  {
   $mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
  }
 
  // Generate the server headers
  if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
  {
   header('Content-Type: "'.$mime.'"');
   header('Content-Disposition: attachment; filename="'.$filename.'"');
   header('Expires: 0');
   header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
   header("Content-Transfer-Encoding: binary");
   header('Pragma: public');
   header("Content-Length: ".strlen($data));
  }
  else
  {
   header('Content-Type: "'.$mime.'"');
   header('Content-Disposition: attachment; filename="'.$filename.'"');
   header("Content-Transfer-Encoding: binary");
   header('Expires: 0');
   header('Pragma: no-cache');
   header("Content-Length: ".strlen($data));
  }
 
  exit($data);
 }
}



//check auth
if (!function_exists('auth_check')) {
    function auth_check()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->auth_model->is_logged_in();
    }
}

//is admin
if (!function_exists('is_admin')) {
    function is_admin()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->auth_model->is_admin();
    }
}

//get admin
if (!function_exists('assigned_admin')) {
    function assigned_admin($member_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        $get_administrators = $ci->auth_model->get_administrators();
        $get_members = $ci->auth_model->get_members();
        $array_sh  = array();
        foreach ($get_members as $members) {
            foreach ($get_administrators as $admin) {
                $array_sh[$admin->id][] = $members->id;
         }
        }
        $admin_id = get_it($member_id,$array_sh);
        return get_user($admin_id);
    }
}
//get service request count;
if (!function_exists('get_service_request_count')) {
    function get_service_request_count(){
        $ci =& get_instance();
        return $ci->auth_model->get_service_request_count();
        }
    }

if (!function_exists('get_it')) {
    function get_it($id,$array)
    {
       foreach ($array as $key => $value) {
           if(in_array($id, $value))
              return $key;
           }
       }
    }

//is admin
if (!function_exists('is_service')) {
    function is_service()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->auth_model->is_service();
    }
}

//get logged user
if (!function_exists('user')) {
    function user()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        $user = $ci->auth_model->get_logged_user();
        if (empty($user)) {
            $ci->auth_model->logout();
        } else {
            return $user;
        }
    }
}

//get user by id
if (!function_exists('get_user')) {
    function get_user($user_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->auth_model->get_user($user_id);
    }
}

//get translated message
if (!function_exists('trans')) {
    function trans($string)
    {
        $ci =& get_instance();
        return $ci->lang->line($string);
    }
}

//print old form data
if (!function_exists('old')) {
    function old($field)
    {
        $ci =& get_instance();
        return html_escape($ci->session->flashdata('form_data')[$field]);
    }
}

//admin url
if (!function_exists('admin_url')) {
    function admin_url()
    {
        require APPPATH . "config/route_slugs.php";
        return base_url() . $custom_slug_array["admin"] . "/";
    }
}

//get category
if (!function_exists('get_category')) {
    function get_category($id)
    {
        $ci =& get_instance();
        return $ci->category_model->get_category($id);
    }
}

//get category joined
if (!function_exists('get_category_joined')) {
    function get_category_joined($id)
    {
        $ci =& get_instance();
        return $ci->category_model->get_category_joined($id);
    }
}

//get subcategories
if (!function_exists('get_subcategories_by_parent_id')) {
    function get_subcategories_by_parent_id($parent_id)
    {
        $ci =& get_instance();
        return $ci->category_model->get_subcategories_by_parent_id($parent_id);
    }
}

//get featured category
if (!function_exists('get_featured_category')) {
    function get_featured_category($order)
    {
        $ci =& get_instance();
        return $ci->category_model->get_featured_category($order);
    }
}

//generate category url
if (!function_exists('generate_category_url')) {
    function generate_category_url($category)
    {
        if (!empty($category)) {
            if ($category->category_level == 3) {
                return base_url() . 'category' . '/' . $category->top_parent_slug . '/' . $category->parent_slug . '/' . $category->slug;
            } elseif ($category->category_level == 2) {
                return base_url() . 'category' . '/' . $category->parent_slug . '/' . $category->slug;
            } else {
                return base_url() . 'category' . '/' . $category->slug;
            }
        }
    }
}

//generate product url
if (!function_exists('generate_product_url')) {
    function generate_product_url($product)
    {
        if (!empty($product)) {
            return base_url() . $product->slug;
        }
    }
}

//generate blog url
if (!function_exists('generate_post_url')) {
    function generate_post_url($post)
    {
        if (!empty($post)) {
            return base_url() . 'blog' . '/' . $post->category_slug . '/' . $post->slug;
        }
    }
}

//generate profile url
if (!function_exists('generate_profile_url')) {
    function generate_profile_url($user)
    {
        if (!empty($user)) {
            return base_url() . 'profile' . '/' . $user->slug;
        }
    }
}

//delete file from server
if (!function_exists('delete_file_from_server')) {
    function delete_file_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}

//get user avatar
if (!function_exists('get_user_avatar')) {
    function get_user_avatar($user)
    {
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url() . $user->avatar;
            } elseif (!empty($user->avatar) && $user->user_type != "registered") {
                return $user->avatar;
            } else {
                return base_url() . "assets/img/user.png";
            }
        } else {
            return base_url() . "assets/img/user.png";
        }
    }
}

//get user avatar by id
if (!function_exists('get_user_avatar_by_id')) {
    function get_user_avatar_by_id($user_id)
    {
        $ci =& get_instance();

        $user = $ci->auth_model->get_user($user_id);
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url() . $user->avatar;
            } elseif (!empty($user->avatar) && $user->user_type != "registered") {
                return $user->avatar;
            } else {
                return base_url() . "assets/img/user.png";
            }
        } else {
            return base_url() . "assets/img/user.png";
        }
    }
}

//date format
if (!function_exists('helper_date_format')) {
    function helper_date_format($datetime)
    {
        $date = date("M Y", strtotime($datetime));
        $date = str_replace("Jan", trans("January"), $date);
        $date = str_replace("Feb", trans("February"), $date);
        $date = str_replace("Mar", trans("March"), $date);
        $date = str_replace("Apr", trans("April"), $date);
        $date = str_replace("May", trans("May"), $date);
        $date = str_replace("Jun", trans("June"), $date);
        $date = str_replace("Jul", trans("July"), $date);
        $date = str_replace("Aug", trans("August"), $date);
        $date = str_replace("Sep", trans("September"), $date);
        $date = str_replace("Oct", trans("October"), $date);
        $date = str_replace("Nov", trans("November"), $date);
        $date = str_replace("Dec", trans("December"), $date);
        return $date;

    }
}

//get logo
if (!function_exists('get_logo')) {
    function get_logo($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo) && file_exists(FCPATH . $settings->logo)) {
                return base_url() . $settings->logo;
            }
        }
        return base_url() . "assets/img/logo.svg";
    }
}

//get favicon
if (!function_exists('get_favicon')) {
    function get_favicon($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->favicon) && file_exists(FCPATH . $settings->favicon)) {
                return base_url() . $settings->favicon;
            }
        }
        return base_url() . "assets/img/favicon.png";
    }
}

//get page title
if (!function_exists('get_page_title')) {
    function get_page_title($page)
    {
        if (!empty($page)) {
            return html_escape($page->title);
        } else {
            return "";
        }
    }
}

//get page description
if (!function_exists('get_page_description')) {
    function get_page_description($page)
    {
        if (!empty($page)) {
            return html_escape($page->description);
        } else {
            return "";
        }
    }
}

//get page keywords
if (!function_exists('get_page_keywords')) {
    function get_page_keywords($page)
    {
        if (!empty($page)) {
            return html_escape($page->keywords);
        } else {
            return "";
        }
    }
}

//get settings
if (!function_exists('get_settings')) {
    function get_settings()
    {
        $ci =& get_instance();
        $ci->load->model('settings_model');
        return $ci->settings_model->get_settings(1);
    }
}

//get general settings
if (!function_exists('get_general_settings')) {
    function get_general_settings()
    {
        $ci =& get_instance();
        $ci->load->model('settings_model');
        return $ci->settings_model->get_general_settings();
    }
}

//get product
if (!function_exists('get_product')) {
    function get_product($id)
    {
        $ci =& get_instance();
        return $ci->product_model->get_product_by_id($id);
    }
}

//get product small image
if (!function_exists('get_product_small_image')) {
    function get_product_small_image($product_id)
    {
        $ci =& get_instance();
        return $ci->file_model->get_product_small_image($product_id);
    }
}

//get product image
if (!function_exists('get_product_image')) {
    function get_product_image($image_name)
    {
        return base_url() . "uploads/images/" . $image_name;
    }
}

//get product images
if (!function_exists('get_product_images')) {
    function get_product_images($product_id)
    {
        $ci =& get_instance();
        return $ci->file_model->get_product_images($product_id);
    }
}

//get product main image
if (!function_exists('get_product_main_image')) {
    function get_product_main_image($product_id)
    {
        $ci =& get_instance();
        return $ci->file_model->get_product_main_image($product_id);
    }
}

//get product count by category
if (!function_exists('get_products_count_by_category')) {
    function get_products_count_by_category($category_id)
    {
        $ci =& get_instance();
        return $ci->product_model->get_products_count_by_category($category_id);
    }
}

//get product count by subcategory
if (!function_exists('get_products_count_by_subcategory')) {
    function get_products_count_by_subcategory($category_id)
    {
        $ci =& get_instance();
        return $ci->product_model->get_products_count_by_subcategory($category_id);
    }
}
//get product count by third category
if (!function_exists('get_products_count_by_third_category')) {
    function get_products_count_by_third_category($category_id)
    {
        $ci =& get_instance();
        return $ci->product_model->get_products_count_by_third_category($category_id);
    }
}
//get category name by lang
if (!function_exists('get_category_name_by_lang')) {
    function get_category_name_by_lang($category_id, $lang_id)
    {
        $ci =& get_instance();
        return $ci->category_model->get_category_name_by_lang($category_id, $lang_id);
    }
}

//check product in favorites
if (!function_exists('is_product_in_favorites')) {
    function is_product_in_favorites($user_id, $product_id)
    {
        $ci =& get_instance();
        return $ci->product_model->is_product_in_favorites($user_id, $product_id);
    }
}

//get product favorited count
if (!function_exists('get_product_favorited_count')) {
    function get_product_favorited_count($product_id)
    {
        $ci =& get_instance();
        return $ci->product_model->get_product_favorited_count($product_id);
    }
}

//get product favorited count
if (!function_exists('get_user_favorited_products_count')) {
    function get_user_favorited_products_count($user_id)
    {
        $ci =& get_instance();
        return $ci->product_model->get_user_favorited_products_count($user_id);
    }
}

//get followers count
if (!function_exists('get_followers_count')) {
    function get_followers_count($following_id)
    {
        $ci =& get_instance();
        return $ci->profile_model->get_followers_count($following_id);
    }
}

//get following users count
if (!function_exists('get_following_users_count')) {
    function get_following_users_count($follower_id)
    {
        $ci =& get_instance();
        return $ci->profile_model->get_following_users_count($follower_id);
    }
}

//get user products count
if (!function_exists('get_user_products_count')) {
    function get_user_products_count($user_slug)
    {
        $ci =& get_instance();
        return $ci->product_model->get_user_products_count($user_slug);
    }
}

//get user products count
if (!function_exists('get_user_pending_products_count')) {
    function get_user_pending_products_count($user_id)
    {
        $ci =& get_instance();
        return $ci->product_model->get_user_pending_products_count($user_id);
    }
}
//get user hidden products count
if (!function_exists('get_user_hidden_products_count')) {
    function get_user_hidden_products_count($user_id)
    {
        $ci =& get_instance();
        return $ci->product_model->get_user_hidden_products_count($user_id);
    }
}
//get product comment count
if (!function_exists('get_product_comment_count')) {
    function get_product_comment_count($product_id)
    {
        $ci =& get_instance();
        return $ci->comment_model->get_product_comment_count($product_id);
    }
}

//check user follows
if (!function_exists('is_user_follows')) {
    function is_user_follows($following_id, $follower_id)
    {
        $ci =& get_instance();
        return $ci->profile_model->is_user_follows($following_id, $follower_id);
    }
}

//get blog post
if (!function_exists('get_post')) {
    function get_post($id)
    {
        $ci =& get_instance();
        return $ci->blog_model->get_post_joined($id);
    }
}

//get blog categories
if (!function_exists('get_blog_categories')) {
    function get_blog_categories()
    {
        $ci =& get_instance();
        return $ci->blog_category_model->get_categories();
    }
}

//get blog post count by category
if (!function_exists('get_blog_post_count_by_category')) {
    function get_blog_post_count_by_category($category_id)
    {
        $ci =& get_instance();
        return $ci->blog_model->get_post_count_by_category($category_id);
    }
}

//get post comment count
if (!function_exists('get_post_comment_count')) {
    function get_post_comment_count($post_id)
    {
        $ci =& get_instance();
        return $ci->comment_model->get_post_comment_count($post_id);
    }
}

//get subcomments
if (!function_exists('get_subcomments')) {
    function get_subcomments($parent_id)
    {
        $ci =& get_instance();
        return $ci->comment_model->get_subcomments($parent_id);
    }
}

//get unread conversations count
if (!function_exists('get_unread_conversations_count')) {
    function get_unread_conversations_count($receiver_id)
    {
        $ci =& get_instance();
        return $ci->message_model->get_unread_conversations_count($receiver_id);
    }
}

//get last sent message
if (!function_exists('get_last_message')) {
    function get_last_message($conversation_id)
    {
        $ci =& get_instance();
        return $ci->message_model->get_last_message($conversation_id);
    }
}

//get language
if (!function_exists('get_language')) {
    function get_language($lang_id)
    {
        $ci =& get_instance();
        return $ci->language_model->get_language($lang_id);
    }
}

//get countries
if (!function_exists('get_countries')) {
    function get_countries()
    {
        $ci =& get_instance();
        return $ci->location_model->get_countries();
    }
}

//get country
if (!function_exists('get_country')) {
    function get_country($id)
    {
        $ci =& get_instance();
        return $ci->location_model->get_country($id);
    }
}

//get states by country
if (!function_exists('get_states_by_country')) {
    function get_states_by_country($country_id)
    {
        $ci =& get_instance();
        return $ci->location_model->get_states_by_country($country_id);
    }
}

if (!function_exists('get_city_by_state')) {
    function get_city_by_state($state_id)
    {
        $ci =& get_instance();
        return $ci->location_model->get_city_by_state($state_id);
    }
}

//get ad codes
if (!function_exists('get_ad_codes')) {
    function get_ad_codes($ad_space)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->ad_model->get_ad_codes($ad_space);
    }
}

//get recaptcha
if (!function_exists('generate_recaptcha')) {
    function generate_recaptcha()
    {
        $ci =& get_instance();
        if ($ci->recaptcha_status) {
            $ci->load->library('recaptcha');
            echo '<div class="form-group">';
            echo $ci->recaptcha->getWidget();
            echo $ci->recaptcha->getScriptTag();
            echo ' </div>';
        }
    }
}

//reset flash data
if (!function_exists('reset_flash_data')) {
    function reset_flash_data()
    {
        $ci =& get_instance();
        $ci->session->set_flashdata('errors', "");
        $ci->session->set_flashdata('error', "");
        $ci->session->set_flashdata('success', "");
    }
}

//get location
if (!function_exists('get_location')) {
    function get_location($object)
    {
        $ci =& get_instance();
        $location = "";
        if (!empty($object)) {
            if (!empty($object->address)) {
                $location = $object->address;
            }
            if (!empty($object->zip_code)) {
                $location .= " " . $object->zip_code;
            }
            if (!empty($object->state_id)) {
                if (!empty($object->address) || $object->zip_code) {
                    $location .= ", ";
                }
                $location .= $ci->location_model->get_state($object->state_id)->name;
            }
            if (!empty($object->country_id)) {
                if (!empty($object->state_id)) {
                    $location .= ", ";
                }
                $location .= $ci->location_model->get_country($object->country_id)->name;
            }
        }
        return $location;
    }
}

//get currencies
if (!function_exists('get_currencies')) {
    function get_currencies()
    {
        $ci =& get_instance();
        $ci->config->load('currencies');
        return $ci->config->item('currencies_array');
    }
}

//get currency
if (!function_exists('get_currency')) {
    function get_currency($currency_key)
    {
        $ci =& get_instance();
        $ci->config->load('currencies');
        $currencies = $ci->config->item('currencies_array');
        if (!empty($currencies)) {
            if (isset($currencies[$currency_key])) {
                return $currencies[$currency_key]["hex"];
            }
        }
        return "";
    }
}

//price format
if (!function_exists('price_format')) {
    function price_format($price)
    {
        $price = $price / 100;
        if (is_int($price)) {
            return number_format($price, 0, ".", ",");
        } else {
            return number_format($price, 2, ".", ",");
        }
    }
}

//price format input
if (!function_exists('price_format_input')) {
    function price_format_input($price)
    {
        $price = $price / 100;
        if (is_int($price)) {
            return number_format($price, 0, ".", "");
        } else {
            return number_format($price, 2, ".", "");
        }
    }
}

//generate slug
if (!function_exists('str_slug')) {
    function str_slug($str)
    {
        return url_title(convert_accented_characters($str), "-", true);
    }
}

//generate product keywords
if (!function_exists('generate_product_keywords')) {
    function generate_product_keywords($title)
    {
        $array = explode(" ", $title);
        $keywords = "";
        $c = 0;
        if (!empty($array)) {
            foreach ($array as $item) {
                $item = trim($item);
                $item = trim($item, ",");
                if (!empty($item)) {
                    $keywords .= $item;
                    if ($c > 0) {
                        $keywords .= ", ";
                    }
                }
                $c++;
            }
        }
        return $keywords;
    }
}

//date diff
if (!function_exists('date_difference')) {
    function date_difference($end_date, $start_date, $format = '%a')
    {
        $datetime_1 = date_create($end_date);
        $datetime_2 = date_create($start_date);
        $diff = date_diff($datetime_1, $datetime_2);
        $day = $diff->format($format) + 1;
        if ($start_date > $end_date) {
            $day = 0 - $day;
        }
        return $day;
    }
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function time_ago($timestamp)
{
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);           // value 60 is seconds
    $hours = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
    $days = round($seconds / 86400);          //86400 = 24 * 60 * 60;
    $weeks = round($seconds / 604800);          // 7*24*60*60;
    $months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
    $years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
    if ($seconds <= 60) {
        return "Just Now";
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "1 minute ago";
        } else {
            return "$minutes minutes ago";
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "1 hour ago";
        } else {
            return "$hours hours ago";
        }
    } else if ($days <= 30) {
        if ($days == 1) {
            return "1 day ago";
        } else {
            return "$days days ago";
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return "1 month ago";
        } else {
            return "$months months ago";
        }
    } else {
        if ($years == 1) {
            return "1 year ago";
        } else {
            return "$years years ago";
        }
    }
}

?>