<?php

/**
 * Class idoSellBookingSideButtonWidget
 * klasa obslugujaca widget wyswietlajacy przycisk boczny
 */
class idoSellBookingSideButtonWidget extends WP_Widget {

    function __construct() {
        if (get_locale() === 'pl_PL') {
            load_textdomain('idosellbooking', plugin_dir_path( __DIR__ ).'/languages/idosellbooking-pl_PL.mo');
        } else {
            load_textdomain('idosellbooking', plugin_dir_path( __DIR__ ).'/languages/idosellbooking-en_GB.mo');
        }
        parent::__construct(false, __('przyciskIdoSellBookingPrzylegajacyDoKrawedziPrzegladarki', 'idosellbooking'),  array( 'description' => __( 'sideButtonWidgetDescription', 'idosellbooking' )) );
    }

    /**
     * generuje widok opcji widgetu
     * @param array $instance
     */
    function form($instance) {
        if ($instance) {
            // wczytanie istniejacych ustawien
            $showAlternativeText = esc_attr($instance['showAlternativeText']);
            $buttonAlternativeText = esc_attr($instance['buttonAlternativeText']);
            $buttonLocation1 = esc_attr($instance['buttonLocation1']);
            $buttonLocation2 = esc_attr($instance['buttonLocation2']);
            $float = esc_attr($instance['float']);
        } else {
            //standardowe ustawienia - przy nowej instacji
            $showAlternativeText = 0;
            $buttonAlternativeText = '';
            $buttonLocation1 = 'left';
            $buttonLocation2 = 'top';
            $float = 'float';
        }
        ?>

        <p>
        <?php _e('tekstPrzycisku', 'idosellbooking'); ?>:<br />
        <input type="radio" id="<?php echo $this->get_field_id('showAlternativeText'); ?>" name="<?php echo $this->get_field_name('showAlternativeText'); ?>" value="0" <?php checked(0, $showAlternativeText, true); ?> ><?php _e('domyslny', 'idosellbooking'); ?><br />
        <input type="radio" id="<?php echo $this->get_field_id('showAlternativeText'); ?>" name="<?php echo $this->get_field_name('showAlternativeText'); ?>" value="1" <?php checked(1, $showAlternativeText, true); ?> ><?php _e('wlasny', 'idosellbooking'); ?><br />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('buttonAlternativeText'); ?>"><?php _e('wlasnyTekstNaPrzycisku', 'idosellbooking'); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('buttonAlternativeText'); ?>" name="<?php echo $this->get_field_name('buttonAlternativeText'); ?>" type="text" value="<?php echo $buttonAlternativeText; ?>" />
        </p>

        <p>
        <?php _e('Polozenie', 'idosellbooking'); ?>:<br />
        <input type="radio" id="<?php echo $this->get_field_id('buttonLocation1'); ?>" name="<?php echo $this->get_field_name('buttonLocation1'); ?>" value="left" <?php checked('left', $buttonLocation1, true); ?> ><?php _e('lewa', 'idosellbooking'); ?><br />
        <input type="radio" id="<?php echo $this->get_field_id('buttonLocation1'); ?>" name="<?php echo $this->get_field_name('buttonLocation1'); ?>" value="right" <?php checked('right', $buttonLocation1, true); ?> ><?php _e('prawa', 'idosellbooking'); ?><br />
        </p>

        <p>
        <input type="radio" id="<?php echo $this->get_field_id('buttonLocation2'); ?>" name="<?php echo $this->get_field_name('buttonLocation2'); ?>" value="top" <?php checked('top', $buttonLocation2, true); ?> ><?php _e('gora', 'idosellbooking'); ?><br />
        <input type="radio" id="<?php echo $this->get_field_id('buttonLocation2'); ?>" name="<?php echo $this->get_field_name('buttonLocation2'); ?>" value="center" <?php checked('center', $buttonLocation2, true); ?> ><?php _e('srodek', 'idosellbooking'); ?><br />
        <input type="radio" id="<?php echo $this->get_field_id('buttonLocation2'); ?>" name="<?php echo $this->get_field_name('buttonLocation2'); ?>" value="bottom" <?php checked('bottom', $buttonLocation2, true); ?> ><?php _e('dol', 'idosellbooking'); ?><br />
        </p>

        <p>
        <?php _e('PlywanieZeStrona', 'idosellbooking'); ?>:<br />
        <input type="radio" id="<?php echo $this->get_field_id('float'); ?>" name="<?php echo $this->get_field_name('float'); ?>" value="float" <?php checked('float', $float, true); ?> ><?php _e('tak', 'idosellbooking'); ?><br />
        <input type="radio" id="<?php echo $this->get_field_id('float'); ?>" name="<?php echo $this->get_field_name('float'); ?>" value="nonfloat" <?php checked('nonfloat', $float, true); ?> ><?php _e('nie', 'idosellbooking'); ?><br />
        </p>

        <?php
    }

    /**
     * update opcji widgetu
     * @param array $new_instance
     * @param array $old_instance
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['showAlternativeText'] = strip_tags($new_instance['showAlternativeText']);
        $instance['buttonAlternativeText'] = strip_tags($new_instance['buttonAlternativeText']);
        $instance['buttonLocation1'] = strip_tags($new_instance['buttonLocation1']);
        $instance['buttonLocation2'] = strip_tags($new_instance['buttonLocation2']);
        $instance['float'] = strip_tags($new_instance['float']);
        return $instance;
    }

    /**
     * wyswietlanie widgetu bocznego
     * @param array $new_instance
     * @param array $old_instance
     */
    function widget($args, $instance) {
        $showAlternativeText = (bool) $instance['showAlternativeText'];
        $buttonAlternativeText = $instance['buttonAlternativeText'];
        $buttonParams = array(
            'buttonLocation1' => $instance['buttonLocation1'],
            'buttonLocation2' => $instance['buttonLocation2'],
            'float' => $instance['float']
        );

        echo idoSellBookingGenerateHtml::getSideButtonCode($buttonParams, $showAlternativeText, $buttonAlternativeText);
    }
}

?>