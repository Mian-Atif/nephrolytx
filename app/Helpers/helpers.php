<?php

use App\Helpers\uuid;
use App\Models\Notification\Notification;
use App\Models\Settings\Setting;
use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


/**
 * Henerate UUID.
 *
 * @return uuid
 */
function generateUuid()
{
    return uuid::uuid4();
}

if (!function_exists('homeRoute')) {

    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
//        Session::flush();
        if (access()->allow('view-backend')) {
            return 'admin.home';
        } elseif (auth()->check()) {
            return 'frontend.user.dashboard';
        }
        return 'frontend.index';
    }
}
if (!function_exists('flushRoute')) {

    function flushRoute()
    {
//        dd('im here');
//        toastr('Password is changed');
                Session::flush();

    }
}
if (!function_exists('flashRoute')) {

    function flashRoute()
    {
//        dd('im here');
//        toastr('Password is changed');
        Session::flush();

    }
}
/*
 * Global helpers file with misc functions.
 */
if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function access()
    {
        return app('access');
    }
}

if (!function_exists('history')) {
    /**
     * Access the history facade anywhere.
     */
    function history()
    {
        return app('history');
    }
}

if (!function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (!function_exists('includeRouteFiles')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        $directory = $folder;
        $handle = opendir($directory);
        $directory_list = [$directory];

        while (false !== ($filename = readdir($handle))) {
            if ($filename != '.' && $filename != '..' && is_dir($directory.$filename)) {
                array_push($directory_list, $directory.$filename.'/');
            }
        }

        foreach ($directory_list as $directory) {
            foreach (glob($directory.'*.php') as $filename) {
                require $filename;
            }
        }
    }
}

if (!function_exists('getRtlCss')) {

    /**
     * The path being passed is generated by Laravel Mix manifest file
     * The webpack plugin takes the css filenames and appends rtl before the .css extension
     * So we take the original and place that in and send back the path.
     *
     * @param $path
     *
     * @return string
     */
    function getRtlCss($path)
    {
        $path = explode('/', $path);
        $filename = end($path);
        array_pop($path);
        $filename = rtrim($filename, '.css');

        return implode('/', $path).'/'.$filename.'.rtl.css';
    }
}

if (!function_exists('settings')) {
    /**
     * Access the settings helper.
     */
    function settings()
    {
        // Settings Details
        $settings = Setting::latest()->first();
        if (!empty($settings)) {
            return $settings;
        }
    }
}

if (!function_exists('createNotification')) {
    /**
     * create new notification.
     *
     * @param  $message    message you want to show in notification
     * @param  $userId     To Whom You Want To send Notification
     *
     * @return object
     */
    function createNotification($message, $userId)
    {
        $notification = new Notification();

        return $notification->insert([
            'message'    => $message,
            'user_id'    => $userId,
            'type'       => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}

if (!function_exists('escapeSlashes')) {
    /**
     * Access the escapeSlashes helper.
     */
    function escapeSlashes($path)
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        $path = str_replace('//', DIRECTORY_SEPARATOR, $path);
        $path = trim($path, DIRECTORY_SEPARATOR);

        return $path;
    }
}

if (!function_exists('getMenuItems')) {
    /**
     * Converts items (json string) to array and return array.
     */
    function getMenuItems($type = 'backend', $id = null)
    {

        $menu = new \App\Models\Menu\Menu();
        $menu = $menu->where('type', $type);
        if (!empty($id)) {
            $menu = $menu->where('id', $id);
        }
        $menu = $menu->first();

        if (!empty($menu) && !empty($menu->items)) {
            return json_decode($menu->items);
        }

        return [];
    }
}

if (!function_exists('getRouteUrl')) {
    /**
     * Converts querystring params to array and use it as route params and returns URL.
     */
    function getRouteUrl($url, $url_type = 'route', $separator = '?')
    {
        $routeUrl = '';
        if (!empty($url)) {
            if ($url_type == 'route') {
                if (strpos($url, $separator) !== false) {
                    $urlArray = explode($separator, $url);
                    $url = $urlArray[0];
                    parse_str($urlArray[1], $params);
                    $routeUrl = route($url, $params);
                } else {
                    $routeUrl = route($url);
                }
            } else {
                $routeUrl = $url;
            }
        }

        return $routeUrl;
    }
}

if (!function_exists('renderMenuItems')) {
    /**
     * render sidebar menu items after permission check.
     */
    function renderMenuItems($items, $viewName = 'backend.includes.partials.sidebar-item')
    {

        foreach ($items as $item) {
            // if(!empty($item->url) && !Route::has($item->url)) {
            //     return;
            // }
            if (!empty($item->view_permission_id)) {
                if (access()->allow($item->view_permission_id)) {
                    echo view($viewName, compact('item'));
                }
            } else {
                echo view($viewName, compact('item'));
            }
        }
    }
}

if (!function_exists('isActiveMenuItem')) {
    /**
     * checks if current URL is of current menu/sub-menu.
     */
    function isActiveMenuItem($item, $separator = '?')
    {
        $item->clean_url = $item->url;
        if (strpos($item->url, $separator) !== false) {
            $item->clean_url = explode($separator, $item->url, -1);
        }
        if (Active::checkRoutePattern($item->clean_url)) {
            return true;
        }
        if (!empty($item->children)) {
            foreach ($item->children as $child) {
                $child->clean_url = $child->url;
                if (strpos($child->url, $separator) !== false) {
                    $child->clean_url = explode($separator, $child->url, -1);
                }
                if (Active::checkRoutePattern($child->clean_url)) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (!function_exists('checkDatabaseConnection')) {

    /**
     * @return bool
     */
    function checkDatabaseConnection()
    {
        try {
            DB::connection()->reconnect();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}



if (!function_exists('truncate_number')) {

    /**
     * @return bool
     */
    function truncate_number($number, $precision = 2) {

        // Zero causes issues, and no need to truncate
        if (0 == (int)$number) {
            return $number;
        }

        // Are we negative?
        $negative = $number / abs($number);

        // Cast the number to a positive to solve rounding
        $number = abs($number);

        // Calculate precision number for dividing / multiplying
        $precision = pow(10, $precision);

        // Run the math, re-applying the negative value to ensure
        // returns correctly negative / positive
        return floor( $number * $precision ) / $precision * $negative;
    }
}


if (!function_exists('displayPrice')) {
    function displayPrice($currency='',$amount=''){
        $spacer=" ";
        return $currency.$spacer.$amount;
    }
}

if (!function_exists('prettyFormat')) {
    function prettyFormat($price){

        $decimal=2;
        $decimal_separators='yes';

        $thousand_separator=',';
        $decimal_separator='.';


        $thou_separator='';
        if (!empty($price)){
            if ($decimal==""){
                $decimal=2;
            }
            if ( $decimal_separators=="yes"){
                //$thou_separator=",";
                $thou_separator=$thousand_separator;
            }
            //return number_format((float)$price,$decimal,".",$thou_separator);
            return number_format((float)$price,$decimal,$decimal_separator,$thou_separator);
        }
        if ($decimal==""){
            $decimal=2;
        }
        //return number_format(0,$decimal,".",$thou_separator);
        $thou_separator=$thousand_separator;
        return number_format(0,$decimal,$decimal_separator,$thou_separator);
    }
}


if (!function_exists('prettyPricePercent')) {
    function prettyPricePercent($amount){
        return displayPricePercent('%',prettyFormat( (float) $amount));
    }
}
if (!function_exists('displayPricePercent')) {
    function displayPricePercent($sign='',$amount=''){
        $spacer=" ";
        return $amount.$spacer.$sign;
    }
}

if (!function_exists('prettyPrice')) {
    function prettyPrice($amount){
        return displayPrice('$',prettyFormat( (float) $amount));
    }
}
if (!function_exists('unPrettyPrice')) {
    function unPrettyPrice($price){
        if ( !empty($price)){
            //return number_format($price,2,".","");
            return str_replace(",","",$price);
        }
        return false;
    }
}

if (!function_exists('normalPrettyPrice')) {
    function normalPrettyPrice($price = '')
    {
        if (is_numeric($price)) {
            return number_format($price, 2, '.', '');
        }
        return false;
    }
}

if (!function_exists('normalPrettyPrice2')) {
    function normalPrettyPrice2($price = '')
    {
        if (is_numeric($price)) {
            return number_format($price, 0, '.', '');
        }
        return false;
    }
}

if (!function_exists('standardPrettyFormat')) {
    function standardPrettyFormat($price = '')
    {
        $decimal = 2;
        $decimal_separators = 'yes';
        $thou_separator = '';
        if (!empty($price)) {

            if ($decimal_separators == "yes") {
                $thou_separator = ",";
            }
            return number_format((float)$price, $decimal, ".", $thou_separator);
        }

        return number_format(0, $decimal, ".", $thou_separator);

    }
}