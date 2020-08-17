<?php if ( ! defined( 'ABSPATH' ) ) exit;

	function phoen_arbpw_custom_tab_options_calander() {
		
		global $product;
		
		global $post;
		
		$_product = wc_get_product( $post->ID );
		
		$regular_price_max=$_product->get_regular_price();
		
		$regular_price=get_post_meta($post->ID, 'phoen_regular_price',true);
		
		$gen_settings=get_post_meta( $post->ID, 'phoen_arbpw_calander_mode', true );
		
		$restrict_days=isset($gen_settings["restrict_days"])?$gen_settings["restrict_days"]:'';
		if(empty($gen_settings)){
			$work_hours=isset($gen_settings["work_hours"])?'':1;
			$product_enable_book=1;
		}else{
			$product_enable_book=$gen_settings['product_enable_book'];
			$work_hours=isset($gen_settings["work_hours"])?$gen_settings["work_hours"]:'';
		}
		$working_hours=isset($gen_settings['working_hours'])?$gen_settings['working_hours']:'';	
		$timeslot=isset($gen_settings['timeslot'])?$gen_settings['timeslot']:'';	
		
			if($working_hours !=='' && is_array($working_hours)){
				
				$fromTime=$working_hours['fromTime'];
			
				$toTime=$working_hours['toTime'];
				
				 $start_time = date("h:i a", strtotime($fromTime));
				
				 $end_time = date("h:i a", strtotime($toTime));
			}
			
		   ?>
			
				<div class="panel wc-metaboxes-wrapper phoe_nue" id="phoen_bookable_options">
					
					<table class="form-table">
						<tbody>	
							<tr class="phoeniixx_arbpw_enable_booking">
								<th>
									<label><?php _e('Enable booking','phoen-arbpw'); ?> </label>
								</th>
								<td>
									<input type="checkbox"  name="enable_book" id="enable_book" value="1" <?php echo(isset($product_enable_book) && $product_enable_book == '1')?'checked':'';?>>
								</td>
							</tr>
							
							<tr class="phoeniixx_arbpw_enable_booking">
								<th>
										<label><?php _e('Show calendar on product page','phoen-arbpw'); ?> </label>
								</th>
								<td>
									<select id="days_to_sel" class="days_to_sel" name="days_to_sel">
							
										<option value="1" <?php echo(isset($gen_settings['product_days_to_sel']) && $gen_settings['product_days_to_sel'] == '1')?'selected':'';?>><?php esc_html_e('One','phoen-arbpw'); ?></option>
									
										<option  value="2" <?php echo(isset($gen_settings['product_days_to_sel']) && $gen_settings['product_days_to_sel'] == '2')?'selected':'';?>><?php esc_html_e('Two','phoen-arbpw'); ?></option>
									
									</select>
								</td>
							</tr>
							<tr class="phoeniixx_arbpw_enable_booking">
								<th>
									<label><?php _e('Booking type','phoen-arbpw'); ?> </label>
								</th>
								<td>
									<select id="pickertype" class="pickertype" name="pickertype">
										<option value="date" <?php echo(isset($gen_settings['pickertype']) && $gen_settings['pickertype'] == 'date')?'selected':'';?>><?php esc_html_e('Daily','phoen-arbpw'); ?>	</option>
										<option value="weekly" <?php echo(isset($gen_settings['pickertype']) && $gen_settings['pickertype'] == 'weekly')?'selected':'';?>><?php esc_html_e('Weekly','phoen-arbpw'); ?></option>
										<option  value="time" <?php echo(isset($gen_settings['pickertype']) && $gen_settings['pickertype'] == 'time')?'selected':'';?>><?php esc_html_e('Hourly','phoen-arbpw'); ?></option>
									</select>
								</td>
							</tr>
							
							<tr class="phoeniixx_phoe_book_wrap phoen_time_slot"   style="display:<?php echo(isset($gen_settings['pickertype']) && $gen_settings['pickertype'] == 'time' && $gen_settings['product_days_to_sel'] == '1') ?'':'none'; ?>;">
							
								<th>
								
									<label><?php esc_html_e('Hours per slot','phoen-arbpw'); ?> </label>
									
								</th>
								
								<td>
								
									<input type="number" onkeypress="return isNumberKey(event)" class="numeric" placeholder="1.0" step="0.1"  min="0" max="24" value="<?php echo $timeslot ? $timeslot:'0';?>" id="timeslot" name="timeslot" />
									<span><?php esc_html_e('eg.( 0.5= 30 mins Or 1 = 1 Hour).','phoen-arbpw'); ?></span>
								</td>
									
							</tr>
							
							<tr class="phoeniixx_arbpw_enable_booking phoen_mob_date"  style="display:<?php echo($gen_settings['pickertype'] == 'time')?'none':''; ?>;">
								<th>
										<label><?php esc_html_e('Booking price calculation','phoen-arbpw'); ?></label>
								</th>
								<td>
									<select id="calc_mode" class="calc_mode" name="calc_mode">
						
									<option value="Day" <?php echo(isset($gen_settings['product_calc_mode']) && $gen_settings['product_calc_mode'] == 'Day')?'selected':'';?>><?php esc_html_e('Days','phoen-arbpw'); ?></option>
								
									<option  value="Night" <?php echo(isset($gen_settings['product_calc_mode']) && $gen_settings['product_calc_mode'] == 'Night')?'selected':'';?>><?php _e('Nights','phoen-arbpw'); ?></option>
								
								</select>
								<p class="phoen_desc"><?php _e('Based on number of days or nights eg.( 3 days=2 nights )','phoen-arbpw'); ?></p>
								</td>
							</tr>
							<tr class="phoeniixx_phoe_book_wrap">
							
								<th>
								
									<label><?php esc_html_e('Booking price('.get_woocommerce_currency_symbol().')','phoen-arbpw'); ?> </label>
									
								</th>
								
								<td>
								
									<input type="number" onkeypress="return isNumberKey(event)" min="0" placeholder=""  value="<?php echo $regular_price ? $regular_price:'0';?>" id="_regular_price" name="_regular_price1" style="" class="short wc_input_price numeric">
										<span id="phoen_price_mode">
									<?php 
									if(isset($gen_settings['pickertype']) && $gen_settings['pickertype'] =="time"){
										if($gen_settings['product_days_to_sel'] == '1'){
											echo "Per slot";
										}else{
											echo "Per hour";
										}
										
									}elseif(isset($gen_settings['pickertype']) && $gen_settings['pickertype'] =="weekly"){
										echo "Per Week";
									}else{
										echo "Per Day";
									}
									?>
									</span>
								</td>
									
							</tr>
						
						</tbody>
						
					</table>				
					
				</div>
				
				<div id="phoen_bookable_options_availability" class="phoe_nue" style="display:none;">
					<table>
						<tbody>
						<tr class="phoeniixx_phoe_book_wrap working_hours phoen_mob_time" style="display:<?php echo(isset($gen_settings['pickertype']) && $gen_settings['pickertype'] == 'time')?'':'none'; ?>;">
						
								<th>
								
									<label><?php esc_html_e('Working hours','phoen-arbpw'); ?> </label>
									
								</th>
								<td>
									<div class="phoen_multi_cont">
									<input type="radio"  name="work_hours" class="work_hours" value="1" <?php echo(isset($work_hours) && $work_hours == '1')?'checked':'';?>>
										<label><?php esc_html_e('24 hours  ','phoen-arbpw'); ?> </label>
									</div>
									<div class="phoen_multi_cont">
									<input type="radio"  name="work_hours" class="work_hours" value="" <?php echo($work_hours == '')?'checked':'';?>>								
									<label for="fromTime"><?php esc_html_e('From','phoen-arbpw'); ?></label>
									<input type="time" class="fromTime"  name="wh[fromTime]"  value="<?php echo isset($start_time)?$start_time:'';  ?>" />
									<label for="toTime"><?php esc_html_e('To','phoen-arbpw'); ?></label>
									<input type="time" class="toTime" name="wh[toTime]" value="<?php echo isset($end_time) ? $end_time:'';  ?>" />
									</div>
								</td>
								
						</tr>
				

							<tr class="phoeniixx_phoe_book_wrap phoen_hide_minmax" style="display:<?php echo(isset($gen_settings['pickertype']) && $gen_settings['pickertype'] != 'time' && $gen_settings['product_days_to_sel'] != '1') ?'':'none'; ?>;">
						
								<th>
								
									<label><?php esc_html_e('Booking limit','phoen-arbpw'); ?> </label>
									
								</th>
								
								<td>
									<div class="phoen_multi_cont">
										<input type="number"  name="minimum_booking" min="0" class="minimum_booking" value="<?php if(!empty($gen_settings['minimum_booking'] )){ echo $gen_settings['minimum_booking']; }else{ echo '0'; } ?>"  />
										<span class="description"><?php esc_html_e('Min','phoen-arbpw'); ?></span>
									</div>
									<span class="phoen_separator"> _ </span>
									<div class="phoen_multi_cont">
										<input type="number" min="0"  name="maximum_booking" class="maximum_booking" value="<?php if(!empty($gen_settings['maximum_booking'] )){ echo $gen_settings['maximum_booking']; }else{ echo '0'; } ?>"  />
										<span><?php esc_html_e('Leave 0 for no limit.','phoen-arbpw'); ?></span>
										<span class="description"><?php esc_html_e('Max','phoen-arbpw'); ?></span>
									</div>
								</td>
								
							</tr>
							
							<tr class="phoeniixx_phoe_book_wrap phoen_mob_date" style="display:<?php echo($gen_settings['pickertype'] == 'time')?'none':''; ?>;">
						
								<th>
								
									<label><?php esc_html_e('Booking starts after','phoen-arbpw'); ?> </label>
									
								</th>
								
								<td>
								<div class="phoen_multi_cont">
									<input type="number" min="0"  name="first_booking" class="first_booking" value="<?php if(!empty($gen_settings['first_booking'] )){ echo $gen_settings['first_booking']; }else{ echo '0'; } ?>"  />
									
									
									<span><?php esc_html_e('Leave 0 for no limit.','phoen-arbpw'); ?></span>
									<span class="description"><?php esc_html_e('Day','phoen-arbpw'); ?></span></div>
								</td>
								
							</tr>
							<tr class="phoeniixx_phoe_book_wrap phoen_mob_date" style="display:<?php echo($gen_settings['pickertype'] == 'time')?'none':''; ?>;">
						
								<th>
								
									<label><?php esc_html_e('Week starts from','phoen-arbpw'); ?> </label>
									
								</th>
								
								<td>
								
									<select id="first_day" class="first_day" name="first_day">
									
										<option value="2" <?php echo(isset($gen_settings['first_day']) && $gen_settings['first_day'] == '2')?'selected':'';?>><?php esc_html_e('Monday','phoen-arbpw'); ?></option>
											
										<option  value="1" <?php echo(isset($gen_settings['first_day']) && $gen_settings['first_day'] == '1')?'selected':'';?>><?php esc_html_e('Sunday','phoen-arbpw'); ?></option>
									
									</select>
									
								</td>
								
							</tr>
							
						</tbody>
					</table>
				</div>
				
				<style>
					.phoe_nue table th {
							color: #555;
							font-size: 12px;
							font-weight: 400;
							padding: 15px 25px 15px 8px;
							text-align: left;
						}
						
						.phoe_nue table td {
							padding: 15px 25px 15px 8px;
						}
						
						.phoe_nue table td input {
							width: 100px;
						}
						
						.phoe_nue table td input[type="checkbox"],
						.phoe_nue table td input[type="radio"] {
							width: auto;
						}
						
						.phoe_nue .phoen_multi_cont {
								display: inline-block;
								vertical-align: top;
						}
						
						.phoe_nue .phoen_multi_cont:first-child {
							margin-right: 10px;
						}
						
						.phoe_nue .phoen_multi_cont span.description {
								display: block;
						}
						
						.phoe_nue .phoen_separator {
								font-weight: 600;
								line-height: 1.5;
								padding-right: 10px;
						}
						
						ul.wc-tabs li.availability_tab a::before {
							content: "\f147"!important;
						}
						ul.wc-tabs li.bookable_tab a::before {
							content: "\f508"!important;
						}
						
						.phoe_nue .picker--time {
								display: inline-block;
						}
						.picker--opened .picker__holder {
							z-index: 99;
						}
				</style>
				
				
			<!--</div>-->
			<script>
			  function isNumberKey(evt)
			  {
				 var charCode = (evt.which) ? evt.which : event.keyCode
				 //alert(charCode);
				 if (charCode > 31 && (charCode < 45 || charCode > 57))
					
				return false;
					
				 return true;
			  }
			jQuery(document).ready(function($){
			
				jQuery("#pickertype").on('change',function(){
					if(jQuery(this).val()==="time"){
						if(jQuery("#days_to_sel").val()==1){
							jQuery(".phoen_time_slot").show();
							jQuery("#phoen_price_mode").html("Per slot");
						}else{
							jQuery("#phoen_price_mode").html("Per hour");
							jQuery(".phoen_time_slot").hide();
						}
						
						jQuery(".phoen_hide_minmax").hide();
						jQuery(".phoen_mob_time").show();
						jQuery(".phoen_mob_date").hide();
						// jQuery("#phoen_price_mode").html("Per Hour");
					}else if(jQuery(this).val()==="date"){
						
						if(jQuery("#days_to_sel").val()==2){
							jQuery(".phoen_hide_minmax").show();
						}else{
							jQuery(".phoen_hide_minmax").hide();
						}
						jQuery(".phoen_time_slot").hide();
						jQuery(".phoen_mob_time").hide();
						jQuery(".phoen_mob_date").show();
						jQuery("#phoen_price_mode").html("Per Day");
					}else{
						
						if(jQuery("#days_to_sel").val()==2){
							jQuery(".phoen_hide_minmax").show();
						}else{
							jQuery(".phoen_hide_minmax").hide();
						}
						jQuery(".phoen_time_slot").hide();
						jQuery(".phoen_mob_time").hide();
						jQuery(".phoen_mob_date").show();
						jQuery("#phoen_price_mode").html("Per week");
					}
				});
			jQuery("#days_to_sel").on('change',function(){
				
				if(jQuery(this).val()==2 && jQuery("#pickertype").val() !="time"){
					
					jQuery(".phoen_hide_minmax").show();
					
					
					
				}else{
						
					jQuery(".phoen_hide_minmax").hide();
					
					
						
				}
				if(jQuery(this).val()==1 && jQuery("#pickertype").val() =="time"){
					
					jQuery(".phoen_time_slot").show();
					
					jQuery("#phoen_price_mode").html("Per slot");
					
				}else if(jQuery(this).val()==2 && jQuery("#pickertype").val() =="time"){
					
					jQuery("#phoen_price_mode").html("Per hour");
					
					jQuery(".phoen_time_slot").hide();
				}

			});
							
				jQuery('.phoeniixx_dynamic_discount_custom_tab').click(function(){
			
						jQuery('.phoeniixx_arbpw_calander_content_div').show();
				
				});
				var startDate = jQuery('.fromTime').pickatime({
							interval: 60,
						onOpen: function() {
							startPicker.set('max', false)
							endPicker.set('max', false)
						  },
							
							
						}),

						startPicker = startDate.pickatime('picker')

						var endDate = jQuery('.toTime').pickatime({
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
						  if ( event.select ) {
							endPicker.set('min', startPicker.get('select'))    
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
				jQuery('.product_data .product_data_tabs a').click(function(){
				
				 if(jQuery(this).attr('href')==="#phoen_bookable_options_availability"){
						jQuery('#phoen_bookable_options_availability').show();
						jQuery('#phoen_bookable_options_cost').hide();
					}else{
						jQuery('#phoen_bookable_options_availability').hide();
						jQuery('#phoen_bookable_options_cost').hide();
					}
				});
				
				
			});	
			
			</script>
			<?php 
	
	} 
		

	function phoen_arbpw_process_product_meta_custom_tab_calander( $post_id ) {
		
		$enable_book=isset($_POST['enable_book'])?sanitize_text_field($_POST['enable_book']):'';
		
		$calc_mode=isset($_POST['calc_mode'])?sanitize_text_field($_POST['calc_mode']):'';
		
		$days_to_sel=isset($_POST['days_to_sel'])?sanitize_text_field($_POST['days_to_sel']):'';
		
		$pickertype=isset($_POST['pickertype'])?sanitize_text_field($_POST['pickertype']):'';
				
		$work_hours=isset($_POST['work_hours'])?sanitize_text_field($_POST['work_hours']):'';
		
		$wh=$_POST['wh'];
	
		if(isset($wh) && is_array($wh)){
			
			$fromTime=$wh['fromTime'];
			
			$toTime=$wh['toTime'];
			
			$start_date = date("H:i", strtotime($fromTime));
			
			$end_date = date("H:i", strtotime($toTime));
				
			$wh=array(
			'fromTime'=>$start_date,
			'toTime'=>$end_date,
			);
			
		}
		
		
		$minimum_booking=isset($_POST['minimum_booking'])?sanitize_text_field($_POST['minimum_booking']):'';
		
		$maximum_booking=isset($_POST['maximum_booking'])?sanitize_text_field($_POST['maximum_booking']):'';
		
		$first_booking=isset($_POST['first_booking'])?sanitize_text_field($_POST['first_booking']):'';
		
		$first_day=isset($_POST['first_day'])?sanitize_text_field($_POST['first_day']):'';
		
		$timeslot=isset($_POST['timeslot'])?sanitize_text_field($_POST['timeslot']):'';
		
		$product_type=isset($_POST['product-type'])?sanitize_text_field($_POST['product-type']):'';
		
		$product_price= isset($_POST['_regular_price1']) ? absint($_POST['_regular_price1']):'0';
		
		if(isset($_POST['_regular_price1'])){
			update_post_meta( $post_id, 'phoen_regular_price', "$product_price" );	
		}
		
			
			$phoe_arbpw_value = array(
				 
				'product_enable_book'=>$enable_book,
		
				'product_calc_mode'=>$calc_mode,
		
				'product_days_to_sel'=>$days_to_sel,
				
				'pickertype'=>$pickertype,
							
				'work_hours'=>$work_hours,
				
				'working_hours'=>$wh,
				
				'timeslot'=>$timeslot,
												
				'minimum_booking'=>$minimum_booking,
				
				'maximum_booking'=>$maximum_booking,
				
				'first_booking'=>$first_booking,
				
				'first_day'=>$first_day
										 
			);

		update_post_meta( $post_id, 'phoen_arbpw_calander_mode', $phoe_arbpw_value );
		
	}
	
	add_action('woocommerce_process_product_meta', 'phoen_arbpw_process_product_meta_custom_tab_calander');
	
	add_action('woocommerce_product_data_panels', 'phoen_arbpw_custom_tab_options_calander');
		
?>
