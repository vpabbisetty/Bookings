<?php

/**
 * Class idoSellBookingGenerateHtml
 * klasa zawierajaca metody obslugujace generowanie widgetu/buttonow IdoSell Booking
 */
class idoSellBookingGenerateHtml
{
    const PANEL_DEMO_ID = 4835;
    const SETTING_YES = 'yes';
    const SETTING_NO = 'no';

    public static function getPanelId()
    {
        $options = get_option('idosellbooking_options');
        if (isset($options['showDemo']) && self::SETTING_YES == $options['showDemo']) {
            // jeśli mamy wyświetlać demo systemu korzystamy z panelu 4835
            return self::PANEL_DEMO_ID;
        }
        return $options['panelId'];
    }

    /**
     * generuje html przycisku bocznego
     * @param array $buttonParams
     * @param bool $showAlternativeText
     * @param string $buttonText
     */
    public static function getSideButtonCode($buttonParams, $showAlternativeText = null, $buttonText = null) {
        $options = get_option('idosellbooking_options');
        $panelId = self::getPanelId();
        if (!$panelId) {
            return __('nieOkreslonoIdPanelu', 'idosellbooking');
        }
        if (!$showAlternativeText) {
            // wyswietlamy standardowy tekst przycisku
            $buttonText = $options['buttonStandardText'];
            if (!$buttonText) {
                return __('nieOkreslonoTekstuWyswietlanegoNaPrzycisku', 'idosellbooking');
            }
        } else {
            // wyswietlamy wlasny tekst przycisku
            if (!$buttonText) {
                return __('nieOkreslonoTekstuWlasnegoWyswietlanegoNaPrzycisku', 'idosellbooking');
            }
        }
        self::addIdoSellBookingScript();
        $buttonCode = '<div class="idosell_booking_cms_side_button_for_generate" data-clientid="' . $panelId .'" data-buttonlocationhorizontal="' . $buttonParams['buttonLocation1'] .'" data-buttonlocationvertical="' . $buttonParams['buttonLocation2'] .'" data-buttonfloat="' . $buttonParams['float'] .'" data-buttontext="' . $buttonText . '"></div>';
        return $buttonCode;
    }

    /**
     * generuje html przycisku wyswietlajacego widget
     * @param bool $showAlternativeText
     * @param string $buttonText
     */
    public static function getButtonCode($showAlternativeText = null, $buttonText = null) {
        $options = get_option('idosellbooking_options');
        $panelId = self::getPanelId();
        $buttonStandardText = $options['buttonStandardText'];
        if (!$panelId) {
            return __('nieOkreslonoIdPanelu', 'idosellbooking');
        }
        if (!$showAlternativeText) {
            $buttonText = $buttonStandardText;
            if (!$buttonText) {
                return __('nieOkreslonoTekstuWyswietlanegoNaPrzycisku', 'idosellbooking');
            }
        } else {
            if (!$buttonText) {
                return __('nieOkreslonoTekstuWlasnegoWyswietlanegoNaPrzycisku', 'idosellbooking');
            }
        }
        self::addIdoSellBookingScript();
        $buttonCode = '<p class="idosell_booking_cms_button_for_generate" data-clientid="' . $panelId .'" data-buttontext="' . $buttonText . '">' . __('trwaUruchamianieSystemuRezerwacji', 'idosellbooking') . '</p>';
        return $buttonCode;
    }

    /**
     * generuje html iframe wyswietlajacego widget
     * @param bool $applyAlternativeWidth
     * @param $widgetWidth
     */
    public static function getWidgetCode($applyAlternativeWidth = null, $widgetWidth = null) {
        $options = get_option('idosellbooking_options');
        $panelId = self::getPanelId();
        if (!$panelId) {
            return __('nieOkreslonoIdPanelu', 'idosellbooking');
        }
        if (!$applyAlternativeWidth) {
            // szerokosc brana z domyslnych ustawien
            $widgetWidth = $options['widgetStandardWidth'];
        } else {
            // szerokosc brana z wlasnych ustawien
            if (!in_array($widgetWidth, array(980,760,690,480))) {
                return __('nieprawidlowoOkreslonaSzerokoscWidgetuIdoSellBooking', 'idosellbooking');
            }
        }
        self::addIdoSellBookingScript();
        $widgetCode = '<p class="idosell_booking_cms_widget_for_generate" data-clientid="' . $panelId .'" data-widgetwidth="' . $widgetWidth . '">' . __('trwaUruchamianieSystemuRezerwacji', 'idosellbooking') . '</p>';
        return $widgetCode;
    }

    /**
     * generuje url dla js
     */
    public static function getJsPath() {
        $panelId = self::getPanelId();
        $jsPath = 'https://client' . $panelId . '.idosell.com/widget/script/loadScriptsForCms';
        return $jsPath;
    }

    /**
     * ddoawanie js
     */
    public static function addIdoSellBookingScript()
    {
        wp_register_script('idosell_booking_js', self::getJsPath());
        wp_enqueue_script('idosell_booking_js');
    }
}


?>