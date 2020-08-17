<?php
/**
 * Class idoSellBookingSideButtonWidget
 * klasa obslugujaca panel administracyjny
 */
class IdoSellBookingAdminPage extends WP_Widget {
    private $options;

    function __construct() {
        parent::__construct(false, $name = __('IdoSellBooking', 'idosellbooking'));
        if (is_admin()) {
            add_action('admin_menu', array($this, 'addPluginPage'));
            add_action('admin_init', array($this, 'pageInit'));
        }
    }

    /**
     * dodaje strone administracyjna dodatku
     */
    public function addPluginPage()
    {
        add_options_page(
            'Settings Admin',
            __('IdoSellBooking', 'idosellbooking'),
            'manage_options',
            'idosellbooking-setting-admin',
            array( $this, 'createAdminPage' )
        );
    }

    /**
     * generuje strone administracyjna dodatku
     */
    public function createAdminPage()
    {
        wp_register_style('idosell_admin', plugins_url('style.css', __FILE__ ));
        wp_enqueue_style('idosell_admin');
        $this->options = get_option('idosellbooking_options');
        ?>
        <div class="wrap">
            <h2><?php _e('IdoSellBooking', 'idosellbooking'); ?></h2>           
            <form method="post" action="options.php">
            <?php
                settings_fields('idosellbooking_option_group');
                do_settings_sections('idosellbooking-setting-admin-general');
                do_settings_sections('idosellbooking-setting-admin');
                submit_button();
            ?>
            </form>
            <?php
            if (get_locale() === 'pl_PL') { 
            ?>
                <h3>Instrukcja</h3>
                <h4>Określenie podstawowych ustawień:</h4>
                <p>
                    Dodatek działa w oparciu o system rezerwacji internetowych i kalendarz rezerwacji (widget) IdoSell Booking.
                    W przypadku braku posiadania własnego konta w IDoSell Booking istnieje możliwość dodania dodatku i generowanie zawartości na podstawie systemu demo.
                    Mamy nadzieję, że demo i 100-dniowy okres testowy za darmo, sprawią że zamówisz własną,
                    niezależną kopię na <a href="http://www.idosell.com/booking/">http://www.idosell.com/booking/</a>.
                </p>
                <p>
                    Jeśli nie jesteś klientem IdoSell Booking skorzystaj z opcji „Demo”. Wybór tej opcji pozwoli Ci wyświetlać przykładowy widget systemu IdoSell Booking.
                </p>
                <p>
                    Jeśli jesteś klientem IdoSell Booking, to w "Ustawieniach" wybierz opcję „Jestem klientem IdoSell Booking - wyświetl mój widget systemu rezerwacji” a następnie wpisz "Identyfikator panelu."
                </p>
                <p>
                    Przed dodaniem przycisku należy wpisać "Domyślny tekst na przycisku" oraz wskazać "Domyślną szerokość widgetu".<br /><br />
                </p>
                <h4>Dodanie przycisku wywołującego widget lub widgetu IdoSell Booking</h4>
                <p>
                    Aby dodać przycisk wywołującego widget lub widget IdoSell Booking należy w panelu bocznym Wordpressa wybrać pozycję "Wygląd" a następnie "Widgety".
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/1.png', __FILE__ ); ?>">
                <p>
                    Następnie z listy dostępnych Widgetów należy wybrać IdoSell Booking, a w kolejnym kroku zdecydować do jakiej strefy widgetów ma być dołączony.
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/2.png', __FILE__ ); ?>">
                <p>
                    Po dodaniu widgetu do odpowiedniej strefy widgetów, skonfiguruj go wybierając odpowiednie opcje.
                    W opcji „Wyświetl” wskaż, czy wyświetlany ma być widget czy przycisk wywołujący widget. 
                    Jeśli chcesz wyświetlić widget IdoSell Booking możesz zmienić jego szerokość w opcji "Szerokość widgetu IdoSell Booking" 
                    na inną niż domyślna. W kolejnej opcji możesz dodać „tekst nad widgetem” lub „tekst pod widgetem”. 
                    Nie są to jednak pola wymagane. Jeżeli wybierzesz przycisk, w opcji „Tekst przycisku” będziesz mógł zdecydować czy test ma być domyślny czy własny. 
                    Jeżeli własny, wpisz odpowiedni w wyznaczonym polu. Po określeniu ustawień naciśnij przycisk "Zapisz".<br />
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/3.png', __FILE__ ); ?>">
                <p>
                    Po naciśnięciu przycisku „Zapisz”, widget pojawi się w odpowiedniej strefie widgetów na witrynie.
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/16.png', __FILE__ ); ?>">
                <br /><br />
                <h4>Dodanie przycisku IdoSell Booking przylegajcego do krawędzi przeglądarki</h4>
                <p>
                    Aby dodać przycisk uruchamiający widget IdoSell Booking przylegający do krawędzi przeglądarki należy w panelu bocznym Wordpressa wybrać pozycję "Wygląd", 
                    a następnie "Widgety".
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/1.png', __FILE__ ); ?>">
                <p>
                     Następnie z listy dostępnych Widgetów należy wybrać "Przycisk IdoSell Booking przylegający do krawędzi przeglądarki”, 
                     a w kolejnym kroku zdecydować do jakiej strefy widgetów ma być dołączony.
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/4.png', __FILE__ ); ?>">
                <p>
                    W oknie ustawień widgetu należy określić opcje wyświetlania. Jeśli chcesz, możesz zmienić tekst wyświetlany na przycisku wybierając 
                    w opcji "Tekst przycisku" opcję "Własny" i wpisać odpowiedni tekst w polu "Własny tekst na przycisku".
                     Następnie wskaż położenie przycisku oraz zdecyduj czy powinien pływać ze stroną.<br />
                    Po określeniu ustawień naciśnij przycisk "Zapisz".
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/6.png', __FILE__ ); ?>">
                <p>
                    Po naciśnięciu „Zapisz” przycisk wywołujący widget pojawi się się w wybranym miejscu przy krawędzi okna przeglądarki.
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/7.png', __FILE__ ); ?>">
                <br /><br />
                <h4>Dodanie podstrony wyświetlającej cały widget jako nowej pozycji w menu</h4>
                <p>
                    Aby dodać cały widget jako nową podstronę należy w panelu bocznym Wordpressa wybrać pozycję Strony, a następnie Dodaj nową.
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/8.png', __FILE__ ); ?>">
                <p>
                    Następnie określ tytuł oraz treść nowej strony zawierając w niej, w którym miejscu powinien pojawić się cały widget, za pomocą frazy "[idosellbooking|widget/]".
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/9.png', __FILE__ ); ?>">
                <p>
                    Po zakończeniu redagowania strony wybierz "Opublikuj" aby zapisać i opublikować nową stronę.
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/10.png', __FILE__ ); ?>">
                <p>
                    Następnie z panelu bocznego wybierz pozycję Wygląd, a następnie Menu.
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/11.png', __FILE__ ); ?>">
                <p>
                    Wybierz menu, które chcesz edytować lub stwórz nowe. Aby dodać podstronę z widgetem zaznacz na liście pozycji, 
                    w sekcji "Strony" dodaną stronę i naciśnij przycisk "Dodaj do menu".
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/12.png', __FILE__ ); ?>">
                <p>
                    Po wykonaniu powyższych kroków w wybranym menu pojawi się nowa pozycja kierująca do podstrony z widgetem.
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/13.png', __FILE__ ); ?>">
                <br /><br />
                <h4>Wstawienie przycisku wywołującego widget IdoSell Booking w treści artykułu</h4>
                <p>
                    Aby wstawić przycisk wywołujący widget IdoSell Booking w treści artykułu w miejscu, w którym ma wyświetlić się przycisk, wstaw frazę "[idosellbooking|button][/idosellbooking]". 
                    Aby zmienić tekst przycisku na inny niż domyślny pomiędzy znacznikami "[idosellbooking|button]" oraz "[/idosellbooking]”, 
                    wpisz tekst, który ma zostać wyświetlony zamiast domyślnego, np. "[idosellbooking|button]Inny tekst[/idosellbooking]".
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/14.png', __FILE__ ); ?>">
                <br /><br />
                <h4>Wstawienie całego widgetu w treści artykułu</h4>
                <p>
                    Aby wstawić cały widget w treści artykułu w miejscu, w którym ma wyświetlić się widget, wstaw frazę "[idosellbooking|widget/]". 
                    Aby zmienić szerokość widgetu na inną niż domyślna, frazę wstawiającą widget skonstruuj według schamatu: "[idosellbooking|widget|szerokosc_widgetu/]", 
                    przy czym jako szerokość widgetu należy wpisać jedną z 4 wartości: 980, 760, 690, 480, np. "[idosellbooking|widget|480/].
                </p>
                <img src="<?php echo plugins_url( 'image/pl_PL/15.png', __FILE__ ); ?>">
            <?php 
            } else { 
            ?>
                <h3>Instructions</h3>
                <h4>Basic settings:</h4>
                <p>
                    The extension works on the basis of IdoSell Booking Management System and its Booking Engine.
                    If you don't have an active IdoSell Booking system, you can use a demo account to embed the extension and test how it works.
                    We hope that the demo account and 100-day trail period will encourage you to order your own IdoSell Booking system at
                    <a href="http://www.idosell.com/booking/">http://www.idosell.com/booking/</a>.
                </p>
                <p>
                    If you are not yet an IdoSell Booking client, have a look at the Demo tab. It gives you a possibility to see how our Booking Widget works in action.
                </p>
                <p>
                    If you already are an active IdoSell Booking client, proceed to the Settings tab, choose the option -
                    "I'm an IdoSell Booking customer - display my widget".
                </p>
                <p>
                    Before embedding the widget, enter the "Default text on a button" and set the width.<br /><br />
                </p>
                <h4>Adding the IdoSell Booking widget or button</h4>
                <p>
                    In order to add a button redirecting to the widget or to embed the widget on your website, 
                    go the sidebar menu in your Wordpress panel and select “Appearance” >> “Widgets”.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/1.png', __FILE__ ); ?>">
                <p>
                    From the list of available Widgets, select “IdoSellBooking” and decide which widget area you want to choose.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/2.png', __FILE__ ); ?>">
                <p>
                    After adding the widget to the chosen area, set it up by selecting suitable options. In the “Display” section, 
                    you can select whether you want to display the whole widget or just a button. If you decide on the widget, 
                    you can modify the default width settings in "IdoSell Booking widget width." 
                    Next option allows you to add “Text over a button / widget” or “Text under a button / widget.” 
                    However, they are not required fields. If you choose to display a button, you can decide if you want 
                    to use a default text or create your own in the “Button text” section. 
                    In case of opting for your own text, you will be asked to enter the text in a suitable field. 
                    After adjusting the settings, click on the “Save” button.<br />
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/3.png', __FILE__ ); ?>">
                <p>
                    After doing so, the widget will appear in the chosen widget area on your website.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/4.png', __FILE__ ); ?>">
                <br /><br />
                <h4>Adding an IdoSell Booking button displayed on the edge of the browser window.</h4>
                <p>
                    In order to add a button on the browser edge, select “Appearance”  >> “Widgets” from the sidebar menu of your Wordpress panel.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/1.png', __FILE__ ); ?>">
                <p>
                    From the list of available Widgets, select “IdoSell Booking button placed on the browser edge” and decide in which widget area it should appear.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/5.png', __FILE__ ); ?>">
                <p>
                    In the widget settings window, you will be asked to configure visibility options. 
                    If you want to, you can modify the text displayed on the button by selecting “own” in the “Button text” option 
                    and entering your text in the "Custom tex on a button" field. 
                    Next, choose the button position and decide if it should appear as a floating element.<br />
                    After adjusting all the settings, click on the “Save” button.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/7.png', __FILE__ ); ?>">
                <p>
                    After completing all the steps, a "Book online" button will appear in the chosen space on the browser edge.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/6.png', __FILE__ ); ?>">
                <br /><br />
                <h4>Adding a subpage with the widget as a new menu position</h4>
                <p>
                    In order to display the whole widget on a new subpage, you need to select "Pages" >> "Add new" from the sidebar menu in your Wordpress panel.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/8.png', __FILE__ ); ?>">
                <p>
                    Next, provide a title and content of the page, placing the following code – "[idosellbooking|widget/]" - in the position in which the widget should appear.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/9.png', __FILE__ ); ?>">
                <p>
                    Click on "Publish" to save and publish the new page.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/10.png', __FILE__ ); ?>">
                <p>
                    Afterwards, select "Appearance" >> “Menus” from the sidebar menu.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/11.png', __FILE__ ); ?>">
                <p>
                    Select the menu that you want to edit or create a new one. In order to add the subpage with your widget, pick the chosen page from the list of available positions in the “Page” section and click on "Add to Menu".
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/12.png', __FILE__ ); ?>">
                <p>
                    After completing all the steps, a new position redirecting the widget subpage will appear in the chosen menu.
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/13.png', __FILE__ ); ?>">
                <br /><br />
                <h4>Embedding the IdoSell Booking button into a post</h4>
                <p>
                    In order to embed a button redirecting to the widget in a post, you need to enter the following code: 
                    "[idosellbooking|button][/idosellbooking]" in the place where you want to display the button. 
                    You can change the default text by entering your own in the space between the opening and closing tags, e.g. 
                    "[idosellbooking|button]your own text[/idosellbooking]".
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/14.png', __FILE__ ); ?>">
                <br /><br />
                <h4>Embedding the widget into a post</h4>
                <p>
                    In order to embed the widget into a post, you need to include the following code "[idosellbooking|widget/]" 
                    in the place where you want to display the widget. You can change the widget width by adding in the indicated place - 
                    "[idosellbooking|widget|widget_width/]" - one of the 4 available width values: 980, 760, 690, 480, e.g. "[idosellbooking|widget|480/].”
                </p>
                <img src="<?php echo plugins_url( 'image/en_GB/15.png', __FILE__ ); ?>">
                <?php 
                } 
                ?>
        </div>
        <?php
    }

    /**
     * opcje strony administracyjnej dodatku
     */
    public function pageInit()
    {
        register_setting(
            'idosellbooking_option_group',
            'idosellbooking_options',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'idosellbooking_main_settings_section',
            '',
            null,
            'idosellbooking-setting-admin'
        );

        add_settings_section(
            'idosellbooking_main_settings_section_general',
            __('ustawienia', 'idosellbooking'),
            null,
            'idosellbooking-setting-admin-general'
        );

        add_settings_field(
            'showDemo',
            '',
            array($this, 'showDemoCallback'),
            'idosellbooking-setting-admin-general',
            'idosellbooking_main_settings_section_general'
        );

        add_settings_field(
            'panelId', // ID
             __('idPanelu', 'idosellbooking').':',
            array( $this, 'panelIdCallback' ),
            'idosellbooking-setting-admin',
            'idosellbooking_main_settings_section'         
        );

        add_settings_field(
            'buttonStandardText', 
            __('domyslnyTekstNaPrzycisku', 'idosellbooking').':', 
            array( $this, 'buttonStandardTextCallback' ), 
            'idosellbooking-setting-admin', 
            'idosellbooking_main_settings_section'
        );

        add_settings_field(
            'widgetStandardWidth',
            __('domyslnaSzerokoscWidgetu', 'idosellbooking').':',
            array( $this, 'widgetStandardWidthCallback' ),
            'idosellbooking-setting-admin',
            'idosellbooking_main_settings_section'
        );
    }

    public function sanitize( $input )
    {
        $new_input = array();
        if (isset($input['panelId'])) {
            $new_input['panelId'] = sanitize_text_field($input['panelId']);
        }

        if (isset($input['buttonStandardText'])) {
            $new_input['buttonStandardText'] = sanitize_text_field($input['buttonStandardText']);
        }

        if (isset($input['widgetStandardWidth'])) {
            $new_input['widgetStandardWidth'] = sanitize_text_field($input['widgetStandardWidth']);
        }

        if (isset($input['showDemo'])) {
            $new_input['showDemo'] = sanitize_text_field($input['showDemo']);
        }

        return $new_input;
    }

    public function panelIdCallback()
    {
        printf(
            '<input type="text" id="panelId" name="idosellbooking_options[panelId]" value="%s" />',
            isset( $this->options['panelId'] ) ? esc_attr( $this->options['panelId']) : ''
        );
    }

    public function buttonStandardTextCallback()
    {
        if(!isset( $this->options['buttonStandardText'] )){
            $this->options['buttonStandardText'] = __('rezerwujPrzezInternet', 'idosellbooking');
        }
        printf(
            '<input type="text" id="buttonStandardText" name="idosellbooking_options[buttonStandardText]" value="%s" />',
            isset( $this->options['buttonStandardText'] ) ? esc_attr( $this->options['buttonStandardText']) : ''
        );
    }

    public function widgetStandardWidthCallback()
    {
        if(!isset($this->options['widgetStandardWidth'])){
            $this->options['widgetStandardWidth']=980;
        }
        ?>
        <input type="radio" name="idosellbooking_options[widgetStandardWidth]" value="980" <?php checked(980,  $this->options['widgetStandardWidth'], true); ?>>980 px<br />
        <input type="radio" name="idosellbooking_options[widgetStandardWidth]" value="760" <?php checked(760,  $this->options['widgetStandardWidth'], true); ?>>760 px<br />
        <input type="radio" name="idosellbooking_options[widgetStandardWidth]" value="690" <?php checked(690,  $this->options['widgetStandardWidth'], true); ?>>690 px<br />
        <input type="radio" name="idosellbooking_options[widgetStandardWidth]" value="480" <?php checked(480,  $this->options['widgetStandardWidth'], true); ?>>480 px<br />
        <?php
    }

    public function showDemoCallback()
    {
        if (!isset($this->options['showDemo'])) {
            // jeśli nie ustawiono parametru
            if (!isset($this->options['widgetStandardWidth']) && !isset($this->options['buttonStandardText']) && !isset($this->options['panelId'])) {
                // jeśli nigdy nie dokonano zapisu - zaznaczamy domyślnie demo dla nowych instalacji.
                $this->options['showDemo'] = idoSellBookingGenerateHtml::SETTING_YES;
            } else {
                $this->options['showDemo'] = idoSellBookingGenerateHtml::SETTING_NO;
            }
        }
        ?>
        <input type="radio" name="idosellbooking_options[showDemo]" value="yes" <?php checked(idoSellBookingGenerateHtml::SETTING_YES,  $this->options['showDemo'], true); ?>><?php echo __('Demo', 'idosellbooking'); ?><br />
        <input type="radio" name="idosellbooking_options[showDemo]" value="no" <?php checked(idoSellBookingGenerateHtml::SETTING_NO,  $this->options['showDemo'], true); ?>><?php echo __('jestemKlientemIdosellBookingWyswietlMojWidget', 'idosellbooking'); ?><br />
        <?php
    }
}

?>