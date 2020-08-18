<?php
/*
Plugin Name:Product Availability Calendar Version2.0
Description: A plugin to display availability calendar for product  functionality
Author: NetScore
Version: 3.0
*/

function product_availabilty_table_install(){
  $custom_id=283;
  global $custom_id;
  global $wpdb;
  global $wnm_db_version;

  $config_table = $wpdb->prefix . "product_availability_config";
  if($wpdb->get_var("show tables like '". $config_table . "'") != $config_table){ 
    $sql_config_table = "CREATE TABLE ". $config_table . "     (
    id int(50) NOT NULL AUTO_INCREMENT,
    product_id int(50) NOT NULL,
    product_name varchar(100) NOT NULL,
    product_sku varchar(50) NOT NULL,
    start_date datetime NOT NULL,
    end_date datetime NOT NULL,
    status varchar(100) NOT NULL,

    PRIMARY KEY  (id)
  ) ";
}
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql_config_table);
dbDelta($sql);
add_option("wnm_db_version", $wnm_db_version);
}
register_activation_hook( __FILE__, 'product_availabilty_table_install' );

//deletes table while deactivating plugin
function delete_product_availability_plugin_database_tables(){
  global $wpdb;
  $tableArray = [   
    $wpdb->prefix . "product_availability_config",

  ];

  foreach ($tableArray as $tablename) {
   $wpdb->query("DROP TABLE IF EXISTS $tablename");
 }
}
register_deactivation_hook( __FILE__, 'delete_product_availability_plugin_database_tables' );

//deletes table after deleting plugin
//register_uninstall_hook(__FILE__, 'delete_product_availability_plugin_database_tables');


function wpb_hook_javascript() {
    ?>
        <script>

jQuery( document ).ready(function( $ ) {

 
});

   jQuery.noConflict()
     
</script>
 
    <?php
}
add_action('wp_head', 'wpb_hook_javascript');

add_action( 'wp_enqueue_scripts', 'availability_plugin_javascript_cache_refresh' );
 
function availability_plugin_javascript_cache_refresh() {

          wp_enqueue_style( 
    'caleran-css',
    plugin_dir_url( __FILE__ ) . 'css/humanity.datepick.css'
  );
    wp_enqueue_style( 
    'custom-css',
    plugin_dir_url( __FILE__ ) . 'css/custom.css'
  );
             wp_enqueue_script( 
    'jquery-2.1.4-js',
    plugin_dir_url( __FILE__ ) . 'js/jquery/1.11.0/jquery.min.js'
  );  

    wp_enqueue_script( 
    'jquery-plugin-js',
    plugin_dir_url( __FILE__ ) . 'js/jquery.plugin.js'
  );   
   
    wp_enqueue_script( 
    'jquery-datepick-js',
    plugin_dir_url( __FILE__ ) . 'js/jquery.datepick.js'
  );       
 
}

add_action( 'wp_footer', 'my_footer_scripts' );
function my_footer_scripts(){
  global $product;
//$id_cal = $product->id;
  ?>

<script type="text/javascript">

jQuery(function() {
  
 // jQuery('#').datepick({});
//  jQuery('.inlineDatepicker').datepick({showTrigger: '#calImg'});
jQuery('.inlineDatepicker').datepick({onSelect: addPeriods,multiSelect: 999});

});

// jQuery('.inlineDatepicker').datepick({onSelect: addPeriods,prevText: '< M', todayText: 'M yyyy', nextText: 'M >', 
//     commandsAsDateFormat: true,rangeSelect: true,dateFormat: 'dd/mm/yy'}).
// startdate=datepick('setDate', new Date());

// jQuery('#addAmount,#addPeriod').change(addPeriods);

function addPeriods() {

  var date = new Date(jQuery('.inlineDatepicker').datepick('getDate')[0].getTime());
  if(date && jQuery('#addAmount').val()){
        jQuery.datepick.add(date, (parseInt(jQuery('#addAmount').val(), 10)-1), jQuery('#addPeriod').val());
      jQuery('.addedDate').val(jQuery.datepick.formatDate(date));
      var selected_setofdates= jQuery.datepick.formatDate(date);
      var IntialDate=jQuery('.inlineDatepicker').datepick('getDate')[0];
      console.log(IntialDate);
      console.log(date);
    alert(selected_setofdates);
    var getDateArray = function(IntialDate, date) {
        var arr = new Array();

        var dt = new Date(IntialDate);
        while (dt <= date) {
          var formatDate = (new Date(dt).getMonth()+1) + "/"+new Date(dt).getDate() + "/"+new Date(dt).getFullYear();
            arr.push(formatDate);
            dt.setDate(dt.getDate() + 1);
        }
        return arr;
    }

    var dateArr = getDateArray(IntialDate, date);

    // Output
    // document.write("<p>Start Date: " + IntialDate + "</p>");
    // document.write("<p>End Date: " + date + "</p>");
    // document.write("<p>Date Array</p>")
    console.log('Date test');
    // for (var i = 0; i < dateArr.length; i++) {
    // //alert("hi");
    // var dateFormatConversion = dateFormat(dateArr[i]);

    // 	console.log(dateFormatConversion);
    //   //document.write("<p class='selecteddates' style='display:none'>" + dateArr[i] + "</p>");
    // }
    // jQuery('.inlineDatepicker').datepick({ 
    //     minDate: '08/20/2020', maxDate: '08/26/2020'
    // });
    // var dates = '08/11/2020,08/12/2020,08/13/2020'.split(','); 
    jQuery('.inlineDatepicker').datepick('setDate', dateArr); 
     
    var selected= dateArr.val( (jQuery('.datepick-selected').val() || 'blank') + '\n'); 
    console.log(selected);

  }
 

}
function dateFormat(d){
  return d.getDate() + "/"+(d.getMonth()+1) +"/"+d.getFullYear();
  
}
 
function ConvertedDisableDates(date) {
  var dates = ["20/01/2018", "21/01/2018", "22/01/2018", "23/01/2018"];
    var string = jQuery.datepick.formatDate('dd/mm/yy', date);
    return [dates.indexOf(string) == -1];
}


//o/p
  function getDates(IntialDate, selected_setofdates) {
      var dateArray = new Array();
      var currentDate = IntialDate;
      while (currentDate <= selected_setofdates) {
        dateArray.push(currentDate)
        currentDate = currentDate.addDays(1);
      }
      return dateArray;
    }

 
function DisableDates(dates) {
  alert('The chosen date(s): ' + dates);
    var string = jQuery.datepicker.formatDate('dd/mm/yy', date);
    return [dates.indexOf(string) == -1];
}
var dates = jQuery('.addedDate').datepick('getDate');

// jQuery(".inlineDatepicker").click(function(){
//      var id = this.id;
//      console.log(id);
// });

    </script>

  <?php
}


function shop_page_display_calendar() {
    global $product;
    global $wpdb;
   
    $checkboxvalue =  get_post_meta($product->id, 'avail_checkbox', true);
   // check against the custom field has a value
if(( get_post_meta($product->id, 'avail_checkbox', true) == 'yes' ))  {
   // echo'<input type="text" id="" size="10" readonly class="addedDate ui-state-active">';
 // echo '<input type="text" id="'.$product->id.'" class="inlineDatepicker"/>';
  echo '<a href="#" id="'.$product->id.'" class="inlineDatepicker">Availability Calendar</a>';
} else{
  // echo "checkbox not checked";
}
  
    $location = get_post_meta( $product->id, 'availability_calendar', true );
        
    if(!empty($location)){
       // echo $location;
      // Get Product ID 
      $idproduct=$product->id;
      echo $idproduct;
      echo'<br>';
      $productname=$product->get_name();
      $productsku=$product->get_sku();
      echo $productsku;
      $wpdb->insert($wpdb->prefix . 'product_availability_config',array('product_id'=>$idproduct,'product_name'=>$productname,'product_sku'=>$productsku,'start_date'=>"2020-06-25",'end_date'=>"2020-06-30",'status'=>"Available",),array('%s','%s','%s','%s','%s','%s'));
      };
  
}
add_action( 'woocommerce_after_shop_loop_item', 'shop_page_display_calendar', 9 );

/**
* Dispaly Calendar in Single Product Page 
*/

function single_product_display_calendar() {
    global $product;
    global $wpdb;
     // echo $product->id;
     //  echo $product->get_name();
     //   echo $product->get_sku();
    $checkboxvalue =  get_post_meta($product->id, 'avail_checkbox', true);

   // check against the custom field has a value
if(( get_post_meta($product->id, 'avail_checkbox', true) == 'yes' ))  {
  echo 'Start Date: <input type="text" id="'.$product->id.'" class="inlineDatepicker"/><br>';
    echo'End Date:&nbsp&nbsp <input type="text" id="" size="10" readonly class="addedDate ui-state-active">';
  

  // echo  $test_var;

} else{
  // echo "checkbox not checked";
}
  
    $location = get_post_meta( $product->id, 'availability_calendar', true );
        
    if(!empty($location)){
       // echo $location;
      // Get Product ID 
      $idproduct=$product->id;
      echo $idproduct;
      echo'<br>';
      $productname=$product->get_name();
      $productsku=$product->get_sku();
      echo $productsku;
      $wpdb->insert($wpdb->prefix . 'product_availability_config',array('product_id'=>$idproduct,'product_name'=>$productname,'product_sku'=>$productsku,'start_date'=>"2020-06-25",'end_date'=>"2020-06-30",'status'=>"Available",),array('%s','%s','%s','%s','%s','%s'));
      };
  
}
add_action( 'woocommerce_before_add_to_cart_button', 'single_product_display_calendar', 9 );


/**
 * Display the custom text field
 
 */
function product_availability_custom_field() {
  global $post;
 // get_the_ID();
   $pageid=$post->ID;

 // Checkbox
woocommerce_wp_checkbox( 
array( 
  'id'            => 'avail_checkbox', 
  'wrapper_class' => 'show_if_simple', 
  'label'         => __('Avaiability Calendar', 'woocommerce' ), 
  'desc_tip'    => true,
  'description'   => __( 'Enable for Availability Calendar Display!', 'woocommerce' ) 
  )
);

}
add_action( 'woocommerce_product_options_general_product_data', 'product_availability_custom_field' );

/* saving custom fields */
function woo_add_custom_general_fields_save( $post_id ){
 
  // Textarea
  $woocommerce_textarea = $_POST['avilability_textarea_id'];
  if( !empty( $woocommerce_textarea ) )
    update_post_meta( $post_id, 'avilability_textarea_id', esc_html( $woocommerce_textarea ) );

    
  // Checkbox
  $woocommerce_checkbox = isset( $_POST['avail_checkbox'] ) ? 'yes' : 'no';
  update_post_meta( $post_id, 'avail_checkbox', $woocommerce_checkbox );
  
 
}
// Save Fields
add_action('woocommerce_process_product_meta', 'woo_add_custom_general_fields_save');
?>
