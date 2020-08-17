<?php 
/*
** Plugin Name: Appointment, Reservation and Rental Booking for Woocommerce

** Plugin URI: https://www.phoeniixx.com/product/appointment-reservation-and-rental-booking-for-woocommerce/

** Description: It is a plugin which allows you to manage your online appointment, reservation and rental bookings.  

** Version: 3.0

** Author: phoeniixx

** Text Domain:phoen-arbpw

** Author URI: https://www.phoeniixx.com/

** License: GPLv2 or later

** License URI: http://www.gnu.org/licenses/gpl-2.0.html

** WC requires at least: 3.2.0

** WC tested up to: 3.9.1

**/  
if ( ! defined( 'ABSPATH' ) ) exit;
	
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		
		include(dirname(__FILE__).'/libs/execute-libs.php');
	
		define('PHOEN_ARBPRPLUGURL',plugins_url(  "/", __FILE__));
	
		define('PHOEN_ARBPRPLUGPATH',plugin_dir_path(  __FILE__));
			
		function phoe_arbpw_menu_booking() {
			
			$Bookings=__('Bookings','phoen-arbpw');
			
			add_submenu_page( 'woocommerce', 'Phoeniixx_booking_report', $Bookings,'manage_options', 'Phoeniixx_booking_report',  'phoen_arbpw_report_func' );
	
		}
		
		add_action( 'woocommerce_single_product_summary', 'phoen_appointment_add_to_cart', 60 );
				
		function phoen_appointment_add_to_cart(){
			
			global $product;
			
			if($product->get_type()=='bookable'){
				?>
				<form class="cart phoen_card_cart" method="post" enctype='multipart/form-data'>
						<?php do_action ( 'woocommerce_before_add_to_cart_button' ); ?>
						<div class="phoen_add_tocart">
							<div class="quantity">
								<label for="quantity" class="screen-reader-text"><?php _e('Quantity','phoen-arbpw'); ?></label>
								<input type="number" aria-labelledby="" inputmode="numeric" pattern="[0-9]*" size="4" title="Qty" value="1" name="quantity" max="" min="1" step="1" class="input-text qty text" >
							</div>						
							<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="bookable_add_to_cart_button button alt"><?php esc_html_e('Book Now','phoen-arbpw'); ?></button>
						</div>	
				<?php do_action ( 'woocommerce_after_add_to_cart_button' ); ?>
				</form>
				
				<?php do_action ( 'woocommerce_after_add_to_cart_form' ); 
			}
				
		}
		
		add_action('admin_head','phoen_arbpw_backend_func');
		
		function phoen_arbpw_backend_func(){
			
			$current_page = get_current_screen()->base;
			
			if($current_page=='woocommerce_page_Phoeniixx_booking_report' || $current_page=='post'){
				
				wp_enqueue_style( 'phoeniixx_arbpw_booking_default_css', PHOEN_ARBPRPLUGURL. "assets/css/default.css",'',false,false);	
						
				wp_enqueue_style( 'phoeniixx_min_classic_select2_css', PHOEN_ARBPRPLUGURL. "assets/css/select2.css");
						
				wp_enqueue_style( 'phoeniixx_min_classic_date_css', PHOEN_ARBPRPLUGURL. "assets/css/datetimepicker.css");		
				
				wp_enqueue_script( 'phoeniixx_arbpw_moment_js', PHOEN_ARBPRPLUGURL. "assets/js/moment.min.js",array('jquery'),'2.21.0',false);
				
				wp_enqueue_script( 'phoeniixx_arbpw_full_cal_min_js', PHOEN_ARBPRPLUGURL. "assets/js/fullcalendar.min.js",array('jquery'),'3.8.2',false);
							
				wp_enqueue_script( 'phoeniixx_arbpw_booking_picker_js', PHOEN_ARBPRPLUGURL. "assets/js/datetimepicker.js",array('jquery'),'201835',false);
				
				wp_enqueue_script( 'phoeniixx_arbpw_booking_select2_js', PHOEN_ARBPRPLUGURL. "assets/js/select2.js",array('jquery'),'4.0.6',false);
				
				wp_enqueue_script( 'phoeniixx_arbpw_booking_backend_js', PHOEN_ARBPRPLUGURL. "assets/js/picker.js",array('jquery'),'3.5.6',false);
				
				wp_enqueue_script( 'phoeniixx_arbpw_picker_time_backend_js', PHOEN_ARBPRPLUGURL. "assets/js/picker.time.js",array('jquery'),'3.5.6',false);	
				
				wp_enqueue_style( 'phoeniixx_min_classic_time_css', PHOEN_ARBPRPLUGURL. "assets/css/default.time.css");
				
			}
			
		}
		
		function phoen_arbpw_report_func(){
			
			wp_enqueue_style( 'phoeniixx_arbpw_full_no_css', PHOEN_ARBPRPLUGURL. "assets/css/fullcalendar.min.css",false);
			wp_enqueue_style( 'phoeniixx_arbpw_full_hhwes', PHOEN_ARBPRPLUGURL. "assets/css/phoen_backend_add.css",false);
			 ?>
				
			<div id="profile-page" class="wrap">
		
				<?php
				$tab = isset($_GET['tab']) ? sanitize_text_field( $_GET['tab'] ):'';	
				?>
				<h2> <?php _e('Appointment, Reservation and Rental Booking for Woocommerce','phoen-arbpw'); ?></h2>
				
				
				<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
				
					<a class="nav-tab <?php if($tab == 'Phoeniixx_booking_calender' || $tab == ''){ echo esc_attr( "nav-tab-active" ); } ?>" href="?page=Phoeniixx_booking_report&amp;tab=Phoeniixx_booking_calender"><?php echo esc_html('Calendar','phoen-arbpw'); ?></a>
					<a class="nav-tab <?php if($tab == 'phoen_arbpw_report'){ echo esc_attr( "nav-tab-active" ); } ?>" href="?page=Phoeniixx_booking_report&amp;tab=phoen_arbpw_report"><?php echo esc_html('Bookings','phoen-arbpw'); ?></a>
					
				</h2>
				
			</div>
			
			<script>
			jQuery(document).ready(function(){
				jQuery('.select_mul_products').select2({
					minimumInputLength: 3
				});
			});
			</script>
				<?php	
			
			if($tab=='' || $tab == 'Phoeniixx_booking_calender'){
				
				require_once('includes/phoen_calender_main.php');
				
				phoen_calender_collback();
				
			}else{
				
				require_once('includes/phoen_reports.php');
				
			}
			
		}
		
		add_filter('woocommerce_is_purchasable', function($is_purchasable, $product) {
			 
			 if($product->get_type()=="bookable"){
				return true;
			}else{
			
				if($is_purchasable):
				return true;
				else:
				return false;
				endif;
				
			}
			
			 
		}, 10, 2);
		
		function phoen_calender_collback(){
			
			$example_data=phoen_appointment_example_data();

			?>
			<script>
			jQuery(document).ready(function(){
				
				jQuery('#phoen_show_calender').fullCalendar({
				  header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,basicWeek,basicDay'
				  },
				  defaultDate: '<?php echo date("Y-m-d");?>',
				  navLinks: true, // can click day/week names to navigate views
				  editable: false,
				  eventLimit: true, // allow "more" link when too many events
				  events: [
					<?php
					
					if(!empty($example_data) && is_array($example_data)){
						foreach($example_data as $key => $value){     
				
								$color="";
							if($value['order_status']=="completed"){
								$color="#2e4453";
							}elseif($value['order_status']=="failed"){
								$color="#761919";
							}elseif($value['order_status']=="on-hold"){
								$color="#94660c";
							}elseif($value['order_status']=="processing"){
								$color="#5b841b";
							}else{
								$color="#777";
							}
				
							if(strlen($value['booking_start'])==19 || strlen($value['booking_start']) > 19){
								$date_start =str_replace(" ","T",$value['booking_start']);
								$date_end =str_replace(" ","T",$value['booking_end']);
							}else{
								$date_start= date('Y-m-d',strtotime($value['booking_start']));
								$date_end= date('Y-m-d',strtotime($value['booking_end']));
								$date_end=date('Y-m-d', strtotime($date_end . ' +1 day'));
							}
						
							$item_name=$value['item_name'];
							$order_id=$value['order_id'];
							if($value['booking_end'] !==''){
								?>
								{
									title:'<?php echo "#$order_id - ".$item_name;?>',
									start:'<?php echo $date_start;?>',
									end:'<?php echo $date_end;?>',
									color: '<?php echo $color;?>'
								},
								
								<?php
							}else{
								?>
								{
									title:'<?php echo "#$order_id - ".$item_name;?>',
									start:'<?php echo $date_start;?>',
									color: '<?php echo $color;?>'
								},
								
								<?php
							}
							
						}
					}
					?>
				  ]
				});
					
			});
			</script>
			<?php
		}
		
		add_action('admin_menu', 'phoe_arbpw_menu_booking');
		
		add_action('wp_enqueue_scripts','phoen_arbpw_datepicker_func');

		function phoen_arbpw_datepicker_func(){
			
			if(is_product()){
				
				wp_enqueue_script('jquery');
			
				wp_enqueue_style( 'phoeniixx_arbpw_booking_default_css', PHOEN_ARBPRPLUGURL. "assets/css/default.css",'',false,false);	
				
				wp_enqueue_style( 'phoeniixx_min_classic_date_css', PHOEN_ARBPRPLUGURL. "assets/css/default.date.css",'',false,false);
				
				wp_enqueue_style( 'phoeniixx_min_classic_time_css', PHOEN_ARBPRPLUGURL. "assets/css/default.time.css",'',false,false);
				
				wp_enqueue_script( 'phoeniixx_arbpw_booking_picker_js', PHOEN_ARBPRPLUGURL. "assets/js/picker.js",array('jquery'),'3.5.6',false,false);
				
				wp_enqueue_script( 'phoeniixx_arbpw_jquery_ui_js', PHOEN_ARBPRPLUGURL. "assets/js/jquery-ui.js",array('jquery'),'201853',false,false);
				
				wp_enqueue_script( 'phoeniixx_arbpw_picker_date_js', PHOEN_ARBPRPLUGURL. "assets/js/picker.date.js",array('jquery'),'3.5.6', false,false);	
				
				wp_enqueue_script( 'phoeniixx_arbpw_picker_time_js', PHOEN_ARBPRPLUGURL. "assets/js/picker.time.js",array('jquery'),'3.5.6', false,false);	
							
				wp_enqueue_style( 'phoeniixx_arbpw_booking_front_css', PHOEN_ARBPRPLUGURL. "assets/css/phoen_arbpw_front_css.css",'',false,false);	
			
			}
			
		}
	
		add_action( 'wp_ajax_phoen_arbpw_data_to_display_on_product', 'phoen_arbpw_calander_on_product_show' );
		
		add_action( 'wp_ajax_nopriv_phoen_arbpw_data_to_display_on_product', 'phoen_arbpw_calander_on_product_show' );
		
		function phoen_arbpw_calander_on_product_show(){
			
			global $product;
				
			$id=absint($_POST['product_id']);
			
			$product_gen_settings=get_post_meta( $id, 'phoen_arbpw_calander_mode', true );
			
			$product_enable_book=isset($product_gen_settings['product_enable_book'])?$product_gen_settings['product_enable_book']:'';
			
			$product_days_to_sel=isset($product_gen_settings['product_days_to_sel'])?$product_gen_settings['product_days_to_sel']:'';
			
			$product_calc_mode=isset($product_gen_settings['product_calc_mode'])?$product_gen_settings['product_calc_mode']:'';
			
			$pickertype=isset($product_gen_settings['pickertype'])?$product_gen_settings['pickertype']:'';
			
			$curr=$curr=get_woocommerce_currency_symbol();
			
			$price="";
			   			
			$mode="";
		
			if($pickertype=="time"){
				
				$start= sanitize_text_field($_POST['start']);
			
				$end= sanitize_text_field($_POST['end']);
			
				$start_date = date("H:i", strtotime($start));
				
				$end_date = date("H:i", strtotime($end));
				
				$total_days=$end_date - $start_date;
						
			}elseif($pickertype=="weekly"){
				
				$start= sanitize_text_field($_POST['start']);
				
				$end= sanitize_text_field($_POST['end']);
				
				$start_date = strtotime($start);
				
				$end_date = strtotime($end);
				
				$datediff = $end_date - $start_date;

				$total_num= round($datediff / (60 * 60 * 24));
				 
				$total_days= round($total_num / 7);
				
			}else{
			
				$start= sanitize_text_field($_POST['start']);
				
				$end= sanitize_text_field($_POST['end']);
				
				$start_date = strtotime($start);
				
				$end_date = strtotime($end);
				
				$datediff = $end_date - $start_date;

				$total_days= round($datediff / (60 * 60 * 24));
				
			}
					
			$quantity =absint($_POST['quantity']);
				
			$price=get_post_meta($id, 'phoen_regular_price',true);
				
			if($product_enable_book==1)
			{
				if($pickertype=='date'){
					
					if($product_calc_mode=="Day")
					{
						
						$total_days+=1;
					} 
					
				}
				
				
				$mode=$product_calc_mode;
			}
			
			
			if($mode =="Day")
			{
				if($total_days=='1')
				{
					$mode=$mode;
				
				}else{
					
					$mode="Days";
				}
			}
			
			if($pickertype =="time")
			{
				if($total_days=='1')
				{
					$mode='Hour';
				
				}else{
					
					$mode="Hours";
				}
			}elseif($pickertype =="weekly")
			{
				if($total_days=='1')
				{
					$mode='Week';
				
				}else{
					
					$mode="Weeks";
				}
			}
			
			
			$total_amt_pro=$price*$quantity*$total_days;
		
			if($total_days > 0 && $total_amt_pro > 0){
				
				?> 
					<ul class="phoen_days_per_price">
						<li><p><?php echo $total_days;  ?><span><?php echo $mode;  ?></span></p></li>
						<li><p><?php echo $curr.$total_amt_pro;  ?><span><?php echo esc_html('Total Price','phoen-arbpw');?></span></p></li>
					</ul>
				
				
				<?php 
				
			}else{
				
				echo '';
				
			}
			die();
		}
		
		/**
		*  Change add to cart button text.
		 * custom_woocommerce_template_loop_add_to_cart
		*/
		add_filter( 'woocommerce_product_add_to_cart_text' , 'phoen_appointment_add_to_cart_text' );
		
		function phoen_appointment_add_to_cart_text() {
			
			global $product;
			
			$product_type = $product->get_type();
			switch ( $product_type ) {
				case 'external':
					return __( 'Buy product', 'woocommerce' );
				break;
				case 'grouped':
					return __( 'View products', 'woocommerce' );
				break;
				case 'simple':
					return __( 'Add to cart', 'woocommerce' );
				break;
				case 'variable':
					return __( 'Select options', 'woocommerce' );
				break;
				case 'bookable':
					return __( 'Select Date', 'woocommerce' );
				break;
				default:
				return __( 'Read more', 'woocommerce' );
			}
			
		}
		
		function phoen_arbpw_calander_on_product() {
			
			global $product;
			
			global $post;
			
			$product_gen_settings=get_post_meta( get_the_ID(), 'phoen_arbpw_calander_mode', true );
			
			$product_enable_book=isset($product_gen_settings['product_enable_book'])?$product_gen_settings['product_enable_book']:'';
			
			$product_days_to_sel=isset($product_gen_settings['product_days_to_sel'])?$product_gen_settings['product_days_to_sel']:'';
			
			$picker_type=isset($product_gen_settings['pickertype'])?$product_gen_settings['pickertype']:'';
			
			$_product = wc_get_product( get_the_ID() );
			
			if( $_product->is_type( 'bookable' ) ) {
				
				$days_to_sel=isset($product_gen_settings['product_days_to_sel'])?$product_gen_settings['product_days_to_sel']:'';
				
				$calc_mode=isset($product_gen_settings['product_calc_mode'])?$product_gen_settings['product_calc_mode']:'';
				
				
				
				$timeslot=isset($product_gen_settings['timeslot'])?$product_gen_settings['timeslot']:'';
				
				$first_day=isset($product_gen_settings['first_day'])?$product_gen_settings['first_day']:'';
				
				$first_booking=isset($product_gen_settings['first_booking'])?$product_gen_settings['first_booking']:'';
				
				$maximum_booking=isset($product_gen_settings['maximum_booking'])?$product_gen_settings['maximum_booking']:'';
				
				$minimum_booking=isset($product_gen_settings['minimum_booking'])?$product_gen_settings['minimum_booking']:'';
								
				if(empty($product_gen_settings['work_hours'])){
					
					$fromTime=$product_gen_settings['working_hours']['fromTime'];
					
					$toTime=$product_gen_settings['working_hours']['toTime'];
					
					$current_time=current_time('G:i');
					
					$fromTime_o=str_replace(":",',',$fromTime);
					
					 $toTime_o=str_replace(":",',',$toTime);
					
					if( strtotime($current_time) > strtotime($fromTime) )
					{
						$emin_num=" min: true , max: [$toTime_o],";
					}
					else
					{
						$emin_num="min: [$fromTime_o], max: [$toTime_o],";
					}
					
				}else{
					$emin_num=" min: true,";
				}
			}
			$mmkkk=0;
			if(isset($picker_type) && $picker_type=="weekly"){
				if(isset($calc_mode) && $calc_mode=="Night"){
					$mmkkk=1;
				}else{
					$mmkkk="null";
				}
				
				$phoen_add=0;
			}else{
				$phoen_add=1;
			}
			// echo $phoen_add;
			// echo $emin_num;
			
			if(!empty($first_day)){
				?>
				<script>
						var first_day=<?php echo $first_day;?>;
				</script>
				<?php
				if($first_day==2){
					$firstday='firstDay:true,';
				}else{
					$firstday='firstDay:false,';
				}
				
			}
			
			if(isset($calc_mode) && $calc_mode=='Night'){
				
				$mmkkk=1;
				?>
				<script>
						var calc_mode=1;
				</script>
				<?php
			}else{
				?>
				<script>
						var calc_mode=5;
				</script>
				<?php
			}
			
			if(!empty($minimum_booking) || !empty($maximum_booking)){
					
				if(!empty($minimum_booking)){
					
					if($calc_mode=='Night'){
						?>
						<script>
						var minimum_booking=<?php echo $minimum_booking ? $minimum_booking:'0'; ?>;
						</script>
						<?php
					}else{
						?>
						<script>
						var minimum_booking=<?php echo $minimum_booking? $minimum_booking-1:'0'; ?>;
						</script>
						<?php
					}
					
				}else{
					?>
					<script>
					var minimum_booking=<?php echo $mmkkk;?>;
					</script>
					<?php
				}
				if(!empty($maximum_booking)){
					
					if($calc_mode=='Night'){
						?>
						<script>
						var maximum_booking=<?php echo $maximum_booking ? $maximum_booking:'0'; ?>;
						</script>
						<?php
					}else{
						?>
						<script>
						var maximum_booking=<?php echo $maximum_booking? $maximum_booking-$phoen_add:'0'; ?>;
						</script>
						<?php
					}
				}else{
					?>
					<script>
					var maximum_booking=null;
					</script>
					<?php
				}
			
			}else{
				?>
				<script>
				var minimum_booking=<?php echo ($calc_mode=="Day")?'null':1;?>;
				var maximum_booking=null;
				</script>
				<?php
			}
			
			if(!empty($first_booking)){
				$first_min="min:+$first_booking,";
			}else{
				$first_min='min:true,';
			}
	
			if( $_product->is_type( 'bookable' ) && $product_enable_book==1 ) 
			{
						
				if($product_days_to_sel==2) 	{ ?>
					
					<div class="phoen_arbpw_calander_picker <?php if($picker_type=="time"){ echo esc_attr('phoen_time_class'); }?>" >
					
						<label for="start_date"><?php _e('From','phoen-arbpw');?></label>
					
						<input type="text" class="phoen_arbpw_date_val phoen_arbpw_start_date two_strt" style="width:70%;" name="start_date"   id="phoen_date" />
					
						<label for="end_date"><?php _e('To','phoen-arbpw');?></label><input type="text" class="phoen_arbpw_date_val phoen_arbpw_end_date" name="end_date"  style="width:70%;" />
							
							<input type="hidden" class="phoen_arbpw_product_id" value="<?php echo $product->get_id(); ?>">
							
							<input type="hidden" class="phoen_arbpw_product_type" value="<?php echo $product->get_type(); ?>">
							
							<input type="hidden" class="phoen_arbpw_price" value="<?php echo $product->get_price(); ?>">
					</div>
						<?php 
				} else { ?>
			
					<div class="phoen_arbpw_calander_picker <?php if($picker_type=="time"){ echo esc_attr('phoen_time_class'); }?>" >
						
					<label for="start_date">	<?php if($picker_type=="time"){ _e('Time','phoen-arbpw'); }else{ _e('Date','phoen-arbpw'); }  ?></label><input type="text" class="phoen_arbpw_date_val phoen_arbpw_start_date"  style="width:70%;" name="start_date" />
		
					</div>
					
					<?php 
				
				}
			}
			
		
			?><div class="phoen_arbpw_span_for_price"></div>
		
			<script>
			
				function EndDateSet(Enddate){
					
					if(first_day===1){
						
						if(calc_mode===5){
							
							if(Enddate===1){
								var	 endpoint = [2,3,4,5,6,7];
							}else if(Enddate===2){
								var	endpoint = [1,3,4,5,6,7];
							}else if(Enddate===3){
								var	endpoint = [1,2,4,5,6,7];
							}else if(Enddate===4){
								var	endpoint = [1,2,3,5,6,7];
							}else if(Enddate===5){
								var	endpoint = [1,2,3,4,6,7];
							}else if(Enddate===6){
								var	 endpoint = [1,2,3,4,5,7];
							}else{
								var	endpoint = [1,2,3,4,5,6];
							}
								
							return endpoint;
							
						}else{
							
							var endpoint = [1,2,3,4,5,6,7];
							endpoint_value = jQuery.grep(endpoint, function(value) {
							  return value != Enddate+1;
							});
							return endpoint_value;
						}
					}else{
						
					
						if(calc_mode===5){
							
							if(Enddate===1){
								var	 endpoint = [1,2,3,4,5,6];
							}else if(Enddate===2){
								var	endpoint = [0,2,3,4,5,6];
							}else if(Enddate===3){
								var	endpoint = [0,1,3,4,5,6];
							}else if(Enddate===4){
								var	endpoint = [0,1,2,4,5,6];
							}else if(Enddate===5){
								var	endpoint = [0,1,2,3,5,6];
							}else if(Enddate===6){
								var	 endpoint = [0,1,2,3,4,6];
							}else{
								var	endpoint = [0,1,2,3,4,5];
							}
								
							return endpoint;
							
						}else{
							
							var endpoint = [0,1,2,3,4,5,6];
							endpoint_value = jQuery.grep(endpoint, function(value) {
							  return value != Enddate;
							});
							return endpoint_value;
						}	
					}	
				
				}
			
				jQuery(document).ready(function($){
				
				<?php
				if($picker_type=="time"){
					
					if($days_to_sel==2){
						?>
						var startDate = $('.phoen_arbpw_start_date').pickatime({
						<?php echo $emin_num;?>
							interval: 60,
							  onClose:function(){
								 $(document.activeElement).blur()
							  },
						}),

						startPicker = startDate.pickatime('picker')

						var endDate = $('.phoen_arbpw_end_date').pickatime({
							<?php echo $emin_num;?>
							interval: 60,
						}),

						endPicker = endDate.pickatime('picker')
							
						if ( startPicker.get('value') ) {
						  endPicker.set('min', startPicker.get('select'))
						}
						if ( endPicker.get('value') ) {
						  startPicker.set('max', endPicker.get('select'))
						}
						// When something is selected, update the “from” and “to” limits.
						startPicker.on('set', function(event) {
							var min_mihhse=startPicker.get('select')
							var day_day=min_mihhse.hour;
							// alert(JSON.stringify(day_day));
							if ( event.select ) {
								endPicker.set('min', [day_day+1,0])    
							  }
							  else if ( 'clear' in event ) {
								endPicker.set('min', false)
							  }
						})
						endPicker.on('set', function(event) {
						  if ( event.select ) {
							startPicker.set('max', endPicker.get('select'))
						  }
						  else if ( 'clear' in event ) {
							startPicker.set('max', false)
						  }
						})
						<?php
					}else{
						?>
						
						var startDate = $('.phoen_arbpw_start_date').pickatime({
							<?php echo $emin_num;?>
							interval: <?php echo !empty($timeslot)?$timeslot*60:60; ?>,
							onClose:function(){
							 $(document.activeElement).blur()
						  },
						}),
						startPicker = startDate.pickatime('picker')
						<?php
					}
				}elseif($picker_type=="weekly"){
					
					if($days_to_sel==2){
						?>
						var startDate = $('.phoen_arbpw_start_date').pickadate({
							formatSubmit: 'yyyy/mm/dd',
							hiddenPrefix: 'num_',
							<?php
							echo $first_min;
							echo $firstday;
							?>
							
							onOpen: function() {
							
							endPicker.stop();
							endPicker.start();
							
							<?php
							if(!empty($first_booking)){
								?>
								startPicker.set('min', +<?php echo $first_booking;?>)
								<?php
							}else{
								?>
								startPicker.set('min', true)
								<?php
							}
							?>
							startPicker.set('max', false)
							endPicker.set('max', false)
						  },
						  onClose:function(){
							 
							  endPicker.open(true)
							 
						  },
						  
						}),

						startPicker = startDate.pickadate('picker')

						var endDate = $('.phoen_arbpw_end_date').pickadate({
							formatSubmit: 'yyyy/mm/dd',
							hiddenPrefix: 'end_',
							<?php
								echo $firstday;
								?>
								
						 onClose:function(){
							 $(document.activeElement).blur()
						  },
						}),

						endPicker = endDate.pickadate('picker')
						
						startPicker.on({
							render: function() {
								startPicker.$root.find('.picker__header').prepend('<div class="picker__title">Start</div>');
							}
						})
					
						// Check if there’s a “from” or “to” date to start with.
						if ( startPicker.get('value') ) { 
						  endPicker.set('min', startPicker.get('select'))
						}
						if ( endPicker.get('value') ) {
						  startPicker.set('max', endPicker.get('select'))
						}
						// When something is selected, update the “from” and “to” limits.
						startPicker.on('set', function(event) {	
						
							var first_select=new Date(jQuery("input[name=num_start_date_submit]").val());
							
							var current_date = new Date(jQuery.datepicker.formatDate( "yy/mm/dd",  new Date() ));
							
							var	diff  = new Date(first_select - current_date);
							
							var days = diff/1000/60/60/24;
							// alert(maximum_booking);	
							var total_day=Math.round(days);
					
							var minsum=total_day+minimum_booking * 7;
							
							var maxsum=minsum+maximum_booking * 7 - minimum_booking  * 7;
					
							
					
							if ( event.select ) {
								  
								var min_mihhse=startPicker.get('select');

								var day_day=min_mihhse.day;
								
								var endDate_value = EndDateSet(day_day);
								
								endPicker.set('disable',endDate_value) ; 
								
								  if(minimum_booking!==null){
									  endPicker.set('min', +minsum)    
								  }else{
									   endPicker.set('min', startPicker.get('select'))    
								  }
								 
								  if(maximum_booking!==null){
									  endPicker.set('max', +maxsum)    
								  }
								  
							}
						  else if ( 'clear' in event ) {
							endPicker.set('min', false)
						  }
						  
						})
						endPicker.on('set', function(event) {
						  if ( event.select ) {
							startPicker.set('max', endPicker.get('select'))
						  }
						  else if ( 'clear' in event ) {
							startPicker.set('max', false)
						  }
						})
						<?php
					}else{
						?>
						var startDate = $('.phoen_arbpw_start_date').pickadate({
							<?php
							echo $first_min;
							echo $firstday;
							?>
							onClose:function(){
							 $(document.activeElement).blur()
						  },
						}),
						startPicker = startDate.pickadate('picker')
						<?php
					}
				}else{
					
					if($days_to_sel==2){
						?>
						var startDate = $('.phoen_arbpw_start_date').pickadate({
							formatSubmit: 'yyyy/mm/dd',
							
							hiddenPrefix: 'num_',
							<?php
							echo $first_min;
							echo $firstday;
							?>
							onOpen: function() {
							
							<?php
							if(!empty($first_booking)){
								?>
								startPicker.set('min', +<?php echo $first_booking;?>)
								<?php
							}else{
								?>
								startPicker.set('min', true)
								<?php
							}
							?>
							startPicker.set('max', false)
						  },
						  onClose:function(){
							 $(document.activeElement).blur()
						  },
						}),

						startPicker = startDate.pickadate('picker')

						var endDate = $('.phoen_arbpw_end_date').pickadate({
							formatSubmit: 'yyyy/mm/dd',
							hiddenPrefix: 'end_',
							<?php
								echo $firstday;
								?>
							onClose:function(){
								 $(document.activeElement).blur()
							},
						}),

						endPicker = endDate.pickadate('picker')
															
						// Check if there’s a “from” or “to” date to start with.
						if ( startPicker.get('value') ) { 
						  endPicker.set('min', startPicker.get('select'))
						}
						if ( endPicker.get('value') ) {
						  startPicker.set('max', endPicker.get('select'))
						}
						// When something is selected, update the “from” and “to” limits.
						startPicker.on('set', function(event) {	
						
							var first_select=new Date(jQuery("input[name=num_start_date_submit]").val());
							
							var current_date = new Date(jQuery.datepicker.formatDate( "yy/mm/dd",  new Date() ));
							
							var	diff  = new Date(first_select - current_date);
			
							var days = diff/1000/60/60/24;
							
							var total_day=Math.round(days);
						
							var minsum=total_day+minimum_booking;
							
							var maxsum=minsum+maximum_booking-minimum_booking;
					
						  if ( event.select ) {
							  
							  if(minimum_booking!==null){
								  endPicker.set('min', +minsum)    
							  }else{
								  endPicker.set('min', startPicker.get('select'))    
							  }
							  
							  if(maximum_booking!==null){
								  endPicker.set('max', +maxsum)    
							  }
							  
						  }
						  else if ( 'clear' in event ) {
							endPicker.set('min', false)
						  }
						  
						})
						endPicker.on('set', function(event) {
						  if ( event.select ) {
							startPicker.set('max', endPicker.get('select'))
						  }
						  else if ( 'clear' in event ) {
							startPicker.set('max', false)
						  }
						})
						<?php
					}else{
						?>
						var startDate = $('.phoen_arbpw_start_date').pickadate({
							<?php
							echo $first_min;
							echo $firstday;
							?>
							onClose:function(){
							 $(document.activeElement).blur()
							},
						}),
						startPicker = startDate.pickadate('picker')
						<?php
					}
				}
				
				?>
				
					var product_type=jQuery('.phoen_arbpw_product_type').val();
				
					if(product_type=="bookable") {
						
						jQuery('.phoen_arbpw_end_date,.two_strt').on('change', function(){
								
							var fromd=	jQuery('.phoen_arbpw_start_date').val();
							
							var tod=jQuery('.phoen_arbpw_end_date').val();
							
							var variation_id=jQuery('.variation_id').val();
							
							var ajaxurl= '<?php echo admin_url( 'admin-ajax.php' );?>';
							
							var quantity=jQuery('.qty').val();
							
							var product_id=jQuery('.phoen_arbpw_product_id').val();
							
							var product_price=jQuery('.phoen_arbpw_price').val();
					
							jQuery.post(
								
								ajaxurl, 
								{
									'action': 'phoen_arbpw_data_to_display_on_product',
									'product_id':product_id,
									'variation_id': variation_id,  
									'start':fromd,
									'end':tod,
									'quantity':quantity,
									'price':product_price
								}, 
								
								function(response){
									jQuery('.phoen_arbpw_span_for_price').html(response);
								}
							);

						
						}); 
					}
					
				});

			</script>
			<?php     
   
		}
	
		function phoen_arbpw_validate_add_cart_product(  $passed, $product_id, $quantity ) {
			
			global $woocommerce;
			
			global $product;
			
			global $post;
			
			$product_gen_settings=get_post_meta( $product_id, 'phoen_arbpw_calander_mode', true );
			
			$product_enable_book=isset($product_gen_settings['product_enable_book'])?$product_gen_settings['product_enable_book']:'';
			
			$product_days_to_sel=isset($product_gen_settings['product_days_to_sel'])?$product_gen_settings['product_days_to_sel']:'';
			
			$data_msg = "";
			$_product = wc_get_product( $product_id );
				
			if( $_product->is_type( 'bookable' ) ) {
				if($product_enable_book==1)  {
							
					if($product_days_to_sel==2) 	{
					
						if((sanitize_text_field($_POST['start_date'])=="")||(sanitize_text_field($_POST['end_date'])=="")) 	{
							
							$data = new WP_Error( 'error', sprintf( __( 'Enter Data correctly', 'custom-options'),"" ) );
											
							wc_add_notice( $data->get_error_message(), 'error' );
												
							$data_msg = 1;
							
						}
					}
					else if(sanitize_text_field($_POST['start_date'])=="") {
							
						$data = new WP_Error( 'error', sprintf( __( 'Enter Data correctly', 'custom-options'),"" ) );
											
						wc_add_notice( $data->get_error_message(), 'error' );
												
						$data_msg = 1;
							
					}
						
				
				} 
			} 
			
			if($data_msg == 1) {
				
				return false;
			}
							
			return $passed;
						
		}  
					
		function phoen_arbpw_add_cart_item($cart_item_data) {
		
			return $cart_item_data;
		}
		
		function phoen_arbpw_get_item_data( $other_data, $cart_item_data ) {
		
			$product_gen_settings=get_post_meta( $cart_item_data['product_id'], 'phoen_arbpw_calander_mode', true );
		
			$product_enable_book=isset($product_gen_settings['product_enable_book'])?$product_gen_settings['product_enable_book']:'';
			
			$product_days_to_sel=isset($product_gen_settings['product_days_to_sel'])?$product_gen_settings['product_days_to_sel']:'';
		
			if ( ! empty( $cart_item_data['phoeniixx_booking_dates'] ) ) {
				
				foreach ( $cart_item_data['phoeniixx_booking_dates'] as $options ) { 	
				
					if($product_enable_book==1) 	{
					
						if($product_days_to_sel==2) {
							
							echo "<br/>"." <strong>From</strong>: ".$options['start_value'];
							
							echo "<br/>"." <strong>To</strong>: ".$options['end_value'];
						}
						
						else if($product_days_to_sel==1){
							
							echo "<br/>"." DateTime: ".$options['start_value'];
						} 
						 
											
					}
					
				}
			
			} 
			
			return $other_data;
			
		}
		
		function phoen_arbpw_add_to_cart_product( $cart_item_data,$product_id ) {
				
			$val_post = isset($_POST['start_date'])?sanitize_text_field($_POST['start_date']):'';
			
			
			$end_val_lla=isset($_POST['end_date'])?sanitize_text_field($_POST['end_date']):'';
			
			$end_val=isset($_POST['end_date'])?sanitize_text_field($_POST['end_date']):'';
			
			$product_gen_settings=get_post_meta( $product_id, 'phoen_arbpw_calander_mode', true );
			
			$pickertype = isset($product_gen_settings['pickertype'])?sanitize_text_field($product_gen_settings['pickertype']):'';
			
			if(isset($product_gen_settings["product_days_to_sel"]) && $product_gen_settings["product_days_to_sel"]==1){
				
				$product_calc_mode = isset($product_gen_settings['product_calc_mode'])?sanitize_text_field($product_gen_settings['product_calc_mode']):'';
								
				$timeslot = !empty($product_gen_settings['timeslot'])?sanitize_text_field($product_gen_settings['timeslot']):1;
				
				if($pickertype=="time"){
					
					$val_post_end=date("Y-m-d").' '.$val_post;
					
					$val_post=date("y-m-d").' '.$val_post;
					
					$val_post_end = date('Y-m-d H:i:s', strtotime($val_post_end));
					
					$minuts=$timeslot*60;
					
					$val_post = date('Y-m-d H:i:s', strtotime($val_post));
									
					$end_val = date('Y-m-d H:i:s', strtotime($val_post_end ."+$minuts minute"));
					
				}elseif($pickertype=="date"){
					
					if($product_calc_mode=="Night"){
						
						$date_end= date('Y-m-d',strtotime($val_post));
						
						$end_val=date('d M , Y', strtotime($date_end . ' +1 day'));
						
					}else{
						
						$end_val=$val_post;
						
					}
					
					
				}else{
					
					if($product_calc_mode=="Night"){
						
						$date_end= date('Y-m-d',strtotime($val_post));
						
						$end_val=date('d M , Y', strtotime($date_end . ' +7 day'));
						
					}else{
						
						$date_end= date('Y-m-d',strtotime($val_post));
						
						$end_val=date('d M , Y', strtotime($date_end . ' +6 day'));
						
					}
					
				}
				
				
			}elseif(isset($product_gen_settings["product_days_to_sel"]) && $product_gen_settings["product_days_to_sel"]==2 && $pickertype=="time"){
				
				$val_post=date("y-m-d").' '.$val_post;
				
				$end_val_lla=date("y-m-d").' '.$end_val_lla;
				
				$val_post = date('Y-m-d H:i:s', strtotime($val_post));
				
				$end_val = date('Y-m-d H:i:s', strtotime($end_val_lla));
				
			}
			
			if($val_post != '') {
						
				$data[] = array(
							
					'start_value' => $val_post,
							
					'end_value'=>$end_val
							
				);
						
				$cart_item_data['phoeniixx_booking_dates'] =  $data;
						
			}
			
			return $cart_item_data;	
		}
	
		function phoen_arbpw_calculate_extra_feea($cart_object ) {
	
			$old_price1='';
				
			foreach ( $cart_object->cart_contents as $key => $value ) {  
			
				$_product = wc_get_product( $value['data']->get_id() );
				
				if( $_product->is_type( 'bookable' ) ) {
				
					$old_price1=get_post_meta($value['data']->get_id(), 'phoen_regular_price',true);
				
					$product_gen_settings=get_post_meta( $value['data']->get_id() ,'phoen_arbpw_calander_mode', true );
	
					$product_enable_book=isset($product_gen_settings['product_enable_book'])?$product_gen_settings['product_enable_book']:'';
			
					$product_days_to_sel=isset($product_gen_settings['product_days_to_sel'])?$product_gen_settings['product_days_to_sel']:'';
		
					$product_calc_mode=isset($product_gen_settings['product_calc_mode'])?$product_gen_settings['product_calc_mode']:'';
					
					$pickertype=isset($product_gen_settings['pickertype'])?$product_gen_settings['pickertype']:'';
			
					$st_date= isset($value['phoeniixx_booking_dates'][0]['start_value'])?$value['phoeniixx_booking_dates'][0]['start_value']:'';
					
					$end_date= isset($value['phoeniixx_booking_dates'][0]['end_value'])?$value['phoeniixx_booking_dates'][0]['end_value']:'';
					
					if($pickertype=="time"){
						
						$dteStart = new DateTime($st_date);
					
						$dteEnd   = new DateTime($end_date); 
						
						$dteDiff_mi = $dteStart->diff($dteEnd);
						
						$dteDiff=$dteDiff_mi->h;
						
					}elseif($pickertype=="weekly"){
						
						$dteStart = new DateTime($st_date);
					
						$dteEnd   = new DateTime($end_date); 
						
						$dteDiff  = $dteStart->diff($dteEnd); 
						
						$dteDiff = $dteEnd->diff($dteStart)->format("%a");
						
						$dteDiff=round($dteDiff/7);
							
					}else{
						
						$dteStart = new DateTime($st_date);
					
						$dteEnd   = new DateTime($end_date); 
						
						$dteDiff  = $dteStart->diff($dteEnd); 
						
						$dteDiff = $dteEnd->diff($dteStart)->format("%a");
						
					}
					
					if($product_enable_book==1)		{
						
						if($pickertype=='time' || $pickertype=='weekly'){
							
							if($product_days_to_sel==1){
								
								$dteDiff=1; 
							
							}
							
							
						}else{
							
							if(($product_calc_mode=="Day")&&($product_days_to_sel==2))		 {
						
								$dteDiff+=1; 
							
							}
							
							else if($product_days_to_sel==1)	{
							 
								$dteDiff=1; 
							
							}
						}
						
						
						if($end_date=="")	{
						 
							$dteDiff=1; 
						
						}
						
						
					}
					
					 $phoen_data = ($old_price1*$dteDiff);
					
					$value['data']->set_price($phoen_data); 
				
				}
		
			}
		
		}
				
		function phoen_arbpw_order_item_meta($item_id,$values) {
			
			if ( ! empty( $values['phoeniixx_booking_dates'] ) ) {
				
				foreach ( $values['phoeniixx_booking_dates'] as $options ) {
					
					if($options['end_value']!="")  	{
						
						woocommerce_add_order_item_meta( $item_id,"FROM", $options['start_value'] );
						
						woocommerce_add_order_item_meta( $item_id,"TO", $options['end_value'] );
					}
					else {
						
						woocommerce_add_order_item_meta( $item_id, "DATETIME", $options['start_value'] );
						
					}
					
				}
			}
		}

		function phoen_arbpw_add_price_html( $price = '', $product) {
			
			global $product;
			
			$_product = wc_get_product( $product->get_id() );
				
				
			if( $_product->is_type( 'bookable' ) ) {
				
				$price_html='';
				
				$price=get_post_meta($product->get_id(), 'phoen_regular_price',true);
				
				$price=wc_price( $price );
				
				$product_gen_settings=get_post_meta( $product->get_id(), 'phoen_arbpw_calander_mode', true );
			
				
				$product_enable_book=isset($product_gen_settings['product_enable_book'])?$product_gen_settings['product_enable_book']:'';
				
				if(isset($product_gen_settings['pickertype']) && $product_gen_settings['pickertype']=="time")	{
					
					if(isset($product_gen_settings["product_days_to_sel"]) && $product_gen_settings["product_days_to_sel"]==1){
						$product_calc_mode='Time slot';
					}else{
						$product_calc_mode='Hours';
					}
					
					
					
				}elseif(isset($product_gen_settings['pickertype']) && $product_gen_settings['pickertype']=="weekly"){
					
					$product_calc_mode='Week';
					
				}else{
					
					$product_calc_mode=isset($product_gen_settings['product_calc_mode'])?$product_gen_settings['product_calc_mode']:'';
					
				}
				
				if($product_enable_book==1){
				
					if($product_gen_settings['pickertype']=="date"){
						$price_html = __('/Dag', 'phoen_arbpw');
					}else{
						$price_html = __('/'.$product_calc_mode, 'phoen_arbpw');
					}
				
					
					
			  
				}
				
				
				if($price!="")	{
				  
					$price .=  '<span class="phoen_arbpw_price-format">' . $price_html . '</span>';
			   
				}
				
			}
			
			return $price;

		}
	
		function phoen_arbpw_get_cart_item_from_session($cart_item_data, $values) {
			
			if ( ! empty( $values['phoeniixx_booking_dates'] ) ) {
				
				$cart_item_data['phoeniixx_booking_dates'] = $values['phoeniixx_booking_dates'];
				
				$cart_item_data = phoen_arbpw_add_cart_item( $cart_item_data );
				
			}
			
			return $cart_item_data;
		}
		
		add_filter( 'product_type_selector', 'phoen_add_custom_product_type' );
		
		function phoen_add_custom_product_type( $types ){
			$types[ 'bookable' ] = __( 'Bookable Product' ,'phoen_arbpw');
			return $types;
		}
		
		add_filter( 'woocommerce_product_data_tabs', 'phoen_appointment_booking_tab' );

		add_action( 'product_type_options', 'phoen_bookable_product_type_options' );

		function phoen_bookable_product_type_options($options){
			
			$options['virtual']['wrapper_class'] = 'show_if_simple_bookable';
			
			return $options;
		}
		
		add_action( 'plugins_loaded', 'phoen_appointment_custom_product_type' );
		
		function phoen_appointment_custom_product_type(){
			 // declare the product class
			 
			class WC_Product_bookable extends WC_Product{
				public function __construct( $product ) {
				   $this->product_type = 'bookable';
				   // $this->virtual = true;
				   parent::__construct( $product );
				   // add additional functions here
				}
			}
		}
		
		function phoen_appointment_booking_tab( $tabs) {
			 
			$tabs['bookable'] =array(
				
				'label'	 => __( 'Booking', 'phoen-arbpw' ),
				
				'target' => 'phoen_bookable_options',
				
				'class'  => ('show_if_bookable'),
				
				'priority'  => 10,
				
			);

			$tabs['availability'] =array(
			
				'label'	 => __( 'Availability', 'phoen-arbpw' ),
				
				'target' => 'phoen_bookable_options_availability',
				
				'class'  => ('show_if_bookable'),
				
				'priority'  => 20,
			);
			
			return $tabs;
		}
		
			//edit price tag e.g /day or /night
			add_filter( 'woocommerce_get_price_html', 'phoen_arbpw_add_price_html' , 10, 2 );
			
			//calculate price according to per unit include additional or custom cahrge
			add_action( 'woocommerce_before_calculate_totals', 'phoen_arbpw_calculate_extra_feea', 1, 1 );
					
			// Get item data to display on cart page after checkout on product column
			add_filter( 'woocommerce_get_item_data',  'phoen_arbpw_get_item_data' , 10, 2 );
				
			//Stores options value in cart 
			add_filter( 'woocommerce_add_cart_item_data',  'phoen_arbpw_add_to_cart_product' , 10, 2 );
			
			//return options value on cart in product column during session
			add_filter( 'woocommerce_add_cart_item',  'phoen_arbpw_add_cart_item' , 20, 1 );
			
			// it takes value from checkout to order
			add_filter( 'woocommerce_get_cart_item_from_session', 'phoen_arbpw_get_cart_item_from_session' , 20, 2 );
			
			//add textbox to product page
			add_action( 'woocommerce_before_add_to_cart_button', 'phoen_arbpw_calander_on_product', 10, 0 ); 
			
			// Validate when adding to cart
			add_filter( 'woocommerce_add_to_cart_validation',  'phoen_arbpw_validate_add_cart_product' , 10, 3 );
			
			//order page
			add_action( 'woocommerce_add_order_item_meta',  'phoen_arbpw_order_item_meta' , 10, 2 );
			
		include_once(PHOEN_ARBPRPLUGPATH.'includes/phoeniixx_arbpw_product.php');
		
	}else{
		
		add_action('admin_notices', 'phoen_arbpw_admin_notice');

		function phoen_arbpw_admin_notice() {
			global $current_user ;
				$user_id = $current_user->ID;
				/* Check that the user hasn't already clicked to ignore the message */
			if ( ! get_user_meta($user_id, 'phoen_arbpw_ignore_notice') ) {
				echo '<div class="error"><p>'; 
				printf(__('Appointment, Reservation and Rental Booking for Woocommerce could not detect an active Woocommerce plugin. Make sure you have activated it. | <a href="%1$s">Hide Notice</a>'), '?phoen_arbpw_nag_ignore=0');
				echo "</p></div>";
			}
		}

		add_action('admin_init', 'phoen_arbpw_nag_ignore');

		function phoen_arbpw_nag_ignore() {
			global $current_user;
				$user_id = $current_user->ID;
				/* If user clicks to ignore the notice, add that to their user meta */
				if ( isset($_GET['phoen_arbpw_nag_ignore']) && '0' == $_GET['phoen_arbpw_nag_ignore'] ) {
					 add_user_meta($user_id, 'phoen_arbpw_ignore_notice', 'true', true);
			}
		}
	
	}?>
