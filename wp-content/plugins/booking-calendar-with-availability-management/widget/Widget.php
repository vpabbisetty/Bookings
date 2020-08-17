<?php

/**
 * Class idoSellBookingSideButtonWidget
 * klasa obslugujaca widget wyswietlajacy przycisk lub widget IdoSell Booking
 */
class IdoSellBookingWidget extends WP_Widget {
    function __construct() {
        if (get_locale() === 'pl_PL') {
            load_textdomain('idosellbooking', plugin_dir_path( __DIR__ ).'/languages/idosellbooking-pl_PL.mo');
        } else {
            load_textdomain('idosellbooking', plugin_dir_path( __DIR__ ).'/languages/idosellbooking-en_GB.mo');
        }
        parent::__construct(false, __('IdoSellBooking', 'idosellbooking'), array( 'description' => __( 'widgetDescription', 'idosellbooking' )) );
    }

    /**
     * generuje widok opcji widgetu
     * @param array $instance
     */
    function form($instance) {
        // wczytanie istniejacych ustawien
        if( $instance) {
             $title = esc_attr($instance['title']);
             $textBefore = esc_attr($instance['textBefore']);
             $textAfter = esc_attr($instance['textAfter']);
             $type = esc_attr($instance['type']);
             $showAlternativeText = esc_attr($instance['showAlternativeText']);
             $buttonAlternativeText = esc_attr($instance['buttonAlternativeText']);
             $widgetWidth = esc_attr($instance['widgetWidth']);
        } else {
              //standardowe ustawienia - przy nowej instacji
             $title = '';
             $textBefore = '';
             $textAfter = '';
             $type = 'widget';
             $showAlternativeText = 0;
             $buttonAlternativeText = '';
             $widgetWidth = 0;
        }
        ?>

        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('tytulWidgetu', 'idosellbooking'); ?>:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
        <?php _e('Wyswietl', 'idosellbooking'); ?>:<br />
        <input type="radio" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" value="widget" <?php checked('widget', $type, true); ?> ><?php _e('widget', 'idosellbooking'); ?><br />
        <input type="radio" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" value="button" <?php checked('button', $type, true); ?> ><?php _e('przycisk', 'idosellbooking'); ?><br />
        </p>

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
        <label for="<?php echo $this->get_field_id('widgetWidth'); ?>"><?php _e('szerokoscWidgetuIdoSellBooking', 'idosellbooking'); ?>:</label><br />
        <input type="radio" id="<?php echo $this->get_field_id('widgetWidth'); ?>" name="<?php echo $this->get_field_name('widgetWidth'); ?>" value="0" <?php checked(0, $widgetWidth, true); ?>><?php _e('domyslna', 'idosellbooking'); ?><br />
        <input type="radio" id="<?php echo $this->get_field_id('widgetWidth'); ?>" name="<?php echo $this->get_field_name('widgetWidth'); ?>" value="980" <?php checked(980, $widgetWidth, true); ?>>980 px<br />
        <input type="radio" id="<?php echo $this->get_field_id('widgetWidth'); ?>" name="<?php echo $this->get_field_name('widgetWidth'); ?>" value="760" <?php checked(760, $widgetWidth, true); ?>>760 px<br />
        <input type="radio" id="<?php echo $this->get_field_id('widgetWidth'); ?>" name="<?php echo $this->get_field_name('widgetWidth'); ?>" value="690" <?php checked(690, $widgetWidth, true); ?>>690 px<br />
        <input type="radio" id="<?php echo $this->get_field_id('widgetWidth'); ?>" name="<?php echo $this->get_field_name('widgetWidth'); ?>" value="480" <?php checked(480, $widgetWidth, true); ?>>480 px<br />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('textBefore'); ?>"><?php _e('tekstNad', 'idosellbooking'); ?>:</label>
        <textarea class="widefat" id="<?php echo $this->get_field_id('textBefore'); ?>" name="<?php echo $this->get_field_name('textBefore'); ?>" type="text" ><?php echo $textBefore; ?> </textarea>
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('textAfter'); ?>"><?php _e('tekstPod', 'idosellbooking'); ?>:</label>
        <textarea class="widefat" id="<?php echo $this->get_field_id('textAfter'); ?>" name="<?php echo $this->get_field_name('textAfter'); ?>" type="text" ><?php echo $textAfter; ?> </textarea>
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
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['textBefore'] = strip_tags($new_instance['textBefore']);
        $instance['textAfter'] = strip_tags($new_instance['textAfter']);
        $instance['type'] = strip_tags($new_instance['type']);
        $instance['showAlternativeText'] = strip_tags($new_instance['showAlternativeText']);
        $instance['buttonAlternativeText'] = strip_tags($new_instance['buttonAlternativeText']);
        $instance['widgetWidth'] = strip_tags($new_instance['widgetWidth']);
        return $instance;
    }

    /**
     * wyswietlanie widgetu lub przycisku
     * @param array $new_instance
     * @param array $old_instance
     */
    function widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget_title', $instance['title']);
        $textBefore = $instance['textBefore'];
        $textAfter = $instance['textAfter'];
        $type = $instance['type'];
        $showAlternativeText = (bool) $instance['showAlternativeText'];
        $buttonAlternativeText = $instance['buttonAlternativeText'];
        $widgetWidth = $instance['widgetWidth'];
        $applyAlternativeWidth = (bool) $widgetWidth;

        echo $args['before_widget'];

        echo '<div class="widget-text idosellbooking_box">';

        if ($title) {
            echo $before_title . $title . $after_title;
        }

        if ($textBefore) {
            echo '<p class="idosellbooking_text">'.$textBefore.'</p>';
        }

        if ($type === 'widget') {
            echo idoSellBookingGenerateHtml::getWidgetCode($applyAlternativeWidth, $widgetWidth);
        } else {
            echo idoSellBookingGenerateHtml::getButtonCode($showAlternativeText, $buttonAlternativeText);
        }

        if ($textAfter) {
            echo '<p class="idosellbooking_text">'.$textAfter.'</p>';
        }

        echo '</div>';
        echo $args['after_widget'];
    }
}

?>