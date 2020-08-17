<?php
/*
Plugin Name: IdoSell Booking
Plugin URI: 
Description: Plugin which enables publishing IdoSell Booking widget or button on a webpage
Version: 1.1
Author: IAI S.A.
Author URI: 
License: GPL2
*/

/**
 * ladowanie plikow jezykowych
 */
function loadIdosellBookingTextDomain() {
    if (get_locale() === 'pl_PL') {
        load_textdomain('idosellbooking', plugin_dir_path( __FILE__ ).'/languages/idosellbooking-pl_PL.mo');
    } else {
        load_textdomain('idosellbooking', plugin_dir_path( __FILE__ ).'/languages/idosellbooking-en_GB.mo');
    }
}
add_action('init', 'loadIdosellBookingTextDomain');

require_once dirname( __FILE__ ) . '/admin/AdminPage.php';
require_once dirname( __FILE__ ) . '/widget/Widget.php';
require_once dirname( __FILE__ ) . '/widget/SideButtonWidget.php';
require_once dirname( __FILE__ ) . '/GenerateHtml.php';

/**
 *  funkcja zmieniajaca znaczniki idosellbooking w tresci postow na widget/button
 * @param strint $text
 */
function idoSellBookingContentPlugin($text) {
    // funkcja zmieniajaca znaczniki idosellbooking w tresci postow na widget/button
    $pattern1 = '/\[idosellbooking\|button\](.*?)\[\/idosellbooking\]/i';
    $pattern2 = '/\[idosellbooking\|widget(\|(\d*))?\/\]/i';

    $text = preg_replace_callback($pattern1, 'createButton', $text);
    $text = preg_replace_callback($pattern2, 'createWidget', $text);

    return $text;
}

function createButton($matches) {
    $match = $matches[1];
    $buttonCode = idoSellBookingGenerateHtml::getButtonCode((bool)$match, $match);
    return $buttonCode;
}

function createWidget($matches) {
    if (isset($matches[2])) {
        $match = $matches[2];
    } else {
        $match = null;
    }
    $widgetCode = idoSellBookingGenerateHtml::getWidgetCode((bool)$match, $match);
    return $widgetCode;
}

add_filter('the_content', 'idoSellBookingContentPlugin');

add_action('widgets_init', create_function('', 'return register_widget("idoSellBookingWidget");'));

add_action('widgets_init', create_function('', 'return register_widget("idoSellBookingSideButtonWidget");'));

if (is_admin()) {
    // jesli zaplecze administracyjne
    $idoSellBookingAdminPage = new IdoSellBookingAdminPage();
}
?>