<?php
if ( ! defined( 'ABSPATH' ) ) exit;

	function phoen_appointment_retrieve_orders()
	{
		$query = new WC_Order_Query( array(
				'limit' => -1,
				'orderby' => 'date',
				'order' => 'DESC',
				'return' => 'ids',
			) );
		$orders = $query->get_orders();
		$phoen_main_return=array();
		for($i=0;$i <= count($orders)-1;$i++){
			
			$order = wc_get_order( $orders[$i] );
						
			foreach ( $order->get_items() as $key => $item ) {
				
				$product_id = version_compare( WC_VERSION, '3.0', '<' ) ? $item['product_id'] : $item->get_product_id();
				
				$FROM = wc_get_order_item_meta( $key, 'FROM', true );
				
				$TO = wc_get_order_item_meta( $key, 'TO', true );
				
				$DATE = wc_get_order_item_meta( $key,'DATETIME', true );
				
				if(!empty($DATE) || !empty($FROM)){
					
					$order_data = $order->get_data();
					
					$order_id=$order_data['id'];
					
					$order_status=$order_data['status'];
					
					$customer_id=$order_data['customer_id'];
					
					$item_name=$item['name'];
					
					$item_quantity=$item['quantity'];
					
					$item_id=$product_id;
					
					$gen_settings=get_post_meta( $product_id, 'phoen_arbpw_calander_mode', true );
					
					$booking_end=$TO;
					
					$booking_start=!empty($FROM) ? $FROM : $DATE;
					
					if($gen_settings['pickertype'] == 'weekly' && $gen_settings['product_days_to_sel'] == '1'){
						
						$date_end= date('Y-m-d',strtotime($booking_start));
						
						$booking_end=date('d M , Y', strtotime($date_end . ' +6 day'));
					
					}
					if(!empty($product_id)){
						$phoen_main_return["products_options"][$product_id] = $item_name;
					}
					
					
					$first_name=$order_data['billing']['first_name'];
					
					$first_email=$order_data['billing']['email'];
					
					$phoen_main_return['data'][]=array(
						'order_id'=>$order_id,
						'order_status'=>$order_status,
						'item_name'=>$item_name,
						'item_id'=>$item_id,
						'item_quantity'=>$item_quantity,
						'first_name'=>$first_name,
						'email'=>$first_email,
						'customer_id'=>$customer_id,
						'booking_start'=>$booking_start,
						'booking_end'=>$booking_end
					);
					
				}
				
			}

		}
		
		return $phoen_main_return;
	}
	
		$phoen_retrieve_orders=phoen_appointment_retrieve_orders();
		?>
		<div class="wrap"> 
			<h2><?php esc_html_e('Booking Calendar','phoen-arbpw'); ?></h2>
			</br>
				<hr class="wp-header-end">
			
			<form method="post">
				<?php
				$products_isdd="";
				$from="";
				$to="";
				
				if(isset( $_POST['phoen_save_appointment_new_rule'])  && wp_verify_nonce( $_POST['phoen_save_appointment_new_rule'], 'phoen_appointment_save_new_rule' ) ){
					$products_isdd=isset($_POST['products'])? sanitize_text_field($_POST['products']):'';
					$from=$_POST['from'];isset($_POST['from'])? sanitize_text_field($_POST['from']):'';
					$to=isset($_POST['to'])? sanitize_text_field($_POST['to']) :'';
					
				}
			
				
				?>
			
				<div class="tablenav top phoen_filter">
				
					<?php wp_nonce_field( 'phoen_appointment_save_new_rule', 'phoen_save_appointment_new_rule' ); ?>
					<select name="products"  class="select_mul_products">
					<option value="0"><?php echo esc_html('Search Product','phoen-arbpw'); ?></option>
					<?php
					
					foreach($phoen_retrieve_orders['products_options'] as $key => $value){
						?>
						<option value="<?php echo $key;?>" <?php if(!empty($products_isdd) && $products_isdd==$key){ echo 'selected'; }  ?>><?php echo $value;?></option>
						<?php
						} 
					?>
					</select>
					<input type="text" value="<?php echo $from; ?>" name="from" class="phoen_min_from"  placeholder="From" />
					<input type="text" name="to" class="phoen_min_to" value="<?php echo $to; ?>"  placeholder="To"/>	
					<input type="submit" value="Filter" name="submit" class="button" />					
				</div>
				<div class="phoen_color_help">
					<ul>
						<li class="phoen_color_comoleted"><span></span><?php esc_html_e('Completed','phoen-arbpw'); ?></li>
						<li class="phoen_color_failed"><span></span><?php esc_html_e('Failed','phoen-arbpw'); ?></li>
						<li class="phoen_color_cancell"><span></span><?php esc_html_e('Cancelled','phoen-arbpw'); ?></li>
						<li class="phoen_color_onhold"><span></span><?php esc_html_e('On hold','phoen-arbpw'); ?></li>
						<li class="phoen_color_processing"><span></span><?php esc_html_e('Processing','phoen-arbpw'); ?></li>
						<li class="phoen_color_pending"><span></span><?php esc_html_e('Pending payment','phoen-arbpw'); ?></li>
						<li class="phoen_color_refunded"><span></span><?php esc_html_e('Refunded','phoen-arbpw'); ?></li>
					</ul>
				</div>
				<div id="phoen_show_calender"></div>
				
			</form>
		</div>
		<?php
		function phoen_appointment_example_data(){
				
				$phoen_main_return=phoen_appointment_retrieve_orders();
				
				 $qmt_data=array();
				 $jjaw_data=array();
				$data=isset($phoen_main_return['data'])?$phoen_main_return['data']:'';
				  
				  
				  
				if(isset( $_POST['phoen_save_appointment_new_rule'])  && wp_verify_nonce( $_POST['phoen_save_appointment_new_rule'], 'phoen_appointment_save_new_rule' ) ){
					
					$products_id=isset($_POST['products'])? sanitize_text_field($_POST['products']):'';
					$from=$_POST['from'];isset($_POST['from'])? sanitize_text_field($_POST['from']):'';
					$to=isset($_POST['to'])? sanitize_text_field($_POST['to']) :'';
					 
					if($products_id!=0){
						 foreach($data as $val_k){
							 if($val_k['item_id']==$products_id){
								 $qmt_data[]=$val_k;
							 }
						 }
					}else{
						$qmt_data=$data;
					}
				 
					$date_from= date('Y-m-d',strtotime($from));
					
					$date_to= date('Y-m-d',strtotime($to));
					if(!empty($qmt_data) && count($qmt_data) > 0){
						
						foreach($qmt_data as $key => $val_m){
							
							$date_start= date('Y-m-d',strtotime($val_m['booking_start']));
							
							$date_end="";
							
							if($val_m['booking_end']!=""){
								$date_end= date('Y-m-d',strtotime($val_m['booking_end']));
							}else{
								$date_end=0;
							}
							
							if(!empty($date_start) && !empty($from)){
							
								if(empty($from) && !empty($to)){
									
									if($date_to <= $date_end){
										$jjaw_data[]=$val_m;
									}
									
								}elseif(!empty($from) && empty($to)){
									
									if($date_from <= $date_start){
										$jjaw_data[]=$val_m;
									}
									
								}else{
									
									
									if(!empty($date_end)){
										if($date_from<=$date_start && $date_to>=$date_end){
											$jjaw_data[]=$val_m;
										} 
									}else{
										
										if($date_from <= $date_start){
											$jjaw_data[]=$val_m;
										} 
									}
								
								}
								
							}else{
								
								$jjaw_data[]=$val_m;
							}
							
							
						
						}
						
					}								
					
					
					return $jjaw_data;
					
				}else{
					
					  return $data;
					  
				 }
				 
		}
?>