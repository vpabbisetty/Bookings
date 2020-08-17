<?php
if ( ! defined( 'ABSPATH' ) ) exit;

	function phoen_appointment_data_retrieve_orders()
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
				
				$DATE = wc_get_order_item_meta( $key, 'DATETIME', true );
				
				if(!empty($DATE) || !empty($FROM)){
					
					$order_data = $order->get_data();
					
					$order_date = $order->get_date_completed();
					
					$order_date_main=date('d F,Y',strtotime($order_date));
					
					$order_date_time=date('h:i a',strtotime($order_date));
					
					$order_id=$order_data['id'];
					
					$order_status=$order_data['status'];
					
					$customer_id=$order_data['customer_id'];
					
					$item_name=$item['name'];
					
					$item_quantity=$item['quantity'];
					
					$item_id=$product_id;
					
					$phoen_main_return["products_options"][$product_id] = $item_name;
					
					$first_name=$order_data['billing']['first_name'];
					
					$first_email=$order_data['billing']['email'];
					
					$booking_start=!empty($FROM) ? $FROM : $DATE;
					
					$booking_end=$TO;
					
					$gen_settings=get_post_meta( $product_id, 'phoen_arbpw_calander_mode', true );
					
					if($gen_settings['pickertype'] == 'weekly' && $gen_settings['product_days_to_sel'] == '1'){
						
						$date_end= date('Y-m-d',strtotime($booking_start));
						
						$booking_end=date('d M , Y', strtotime($date_end . ' +6 day'));
					
					}
					
					if($TO==""){
						$booking_end="";
					}
	
					$phoen_main_return['data'][]=array(
						'order_id'=>$order_id,
						'order_status'=>$order_status,
						'item_name'=>$item_name,
						'order_date'=>$order_date_main,
						'order_time'=>$order_date_time,
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
	
	if( ! class_exists( 'WP_List_Table' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}
	
	$phoen_reports_list_obj = new phoen_reports_membership_list();
	
		$phoen_retrieve_orders=phoen_appointment_data_retrieve_orders();
		?>
		<div class="wrap phoen_min_wp_wrap"> 
			<h2><?php _e('Booking Calendar','phoen-arbpw'); ?></h2>
			</br>
				<hr class="wp-header-end">
			<?php
			$phoen_reports_list_obj->prepare_items(); ?>
			
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
					<option value="0"><?php _e('Search Product','phoen-arbpw'); ?></option>
					<?php
					foreach($phoen_retrieve_orders['products_options'] as $key => $value){
						?>
						<option value="<?php echo $key;?>" <?php if($products_isdd==$key){ echo 'selected'; }  ?>><?php echo $value;?></option>
						<?php
					} 
					?>
					</select>
					<input type="text" name="from"  value="<?php echo $from; ?>" class="phoen_min_from"  placeholder="From" />
					<input type="text" name="to" class="phoen_min_to" value="<?php echo $to; ?>"  placeholder="To"/>	
					<input type="submit" value="Filter" name="submit" class="button" />					
				</div>
			</form>
		
		<?php
		
		$phoen_reports_list_obj->display(); 
	?></div><?php
		class phoen_reports_membership_list extends WP_List_Table
		{ 
			function get_columns(){ 
				$columns = array(
				'order_id' => 'Order',
				'item_name'    => 'Product',
				'order_date'    => 'Booked On',
				'booking_start'    => 'From',
				'booking_end'    => 'To',
				'item_quantity'    => 'Total Booking',
				'order_status'        => 'Status',
				);
				return $columns;
			}
			 
			
			function prepare_items() {
				
				$columns = $this->get_columns();
				
				$hidden = array();
				
				$sortable = $this->get_sortable_columns();
				
				$action = $this->column_booktitle();
				
				$data = $this->phoen_appointment_example_data();
				
				if(!empty($data)){
					usort( $data, array( &$this, 'sort_data' ) );
				}
				$perPage = 10;

				$currentPage = $this->get_pagenum();

				$totalItems = count($data);

				$this->set_pagination_args( array(

					'total_items' => $totalItems,
					'per_page'    => $perPage
					) 
				);
				if(!empty($data)){	
					$data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
				}
				$this->_column_headers = array($columns, $hidden, $sortable);
				
				$this->items = $data;
			}  
			
			public	function phoen_appointment_example_data(){
				
				$phoen_main_return=phoen_appointment_data_retrieve_orders();
				
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
							
							$date_end= date('Y-m-d',strtotime($val_m['booking_end']));
							
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
					
			function column_default( $item, $column_name ) {
		
				 $pnumbtn=isset($item['order_status'])? $item['order_status'] :'';
				 $order_id=$item['order_id'];
				 $first_name=$item['first_name'];
				 $email=$item['email'];
				 $order_date=$item['order_date'];
				 $order_time=$item['order_time'];
				 $customer_id=$item['customer_id'];
				$order_url= get_edit_post_link( $order_id, '&amp;' );
				 
				switch( $column_name ) { 
							
					case 'order_date' : echo $order_date.'<br />'.$order_time;break;
					
					case 'order_status': echo "<mark class='phoen-report-status status-".$pnumbtn." tips'><span>$pnumbtn</span></mark>";break;
					
					case 'order_id': echo '<a class="row-title" href="'.$order_url.'"><strong>#'.$order_id.'</strong></a> by <a href="user-edit.php?user_id='.$customer_id.'">'.$first_name.'</a><small class="meta email"><a href="mailto:'.$email.'">'.$email.'</a></small>'; break;
					
					case 'item_name':
					
					case 'booking_start':
					
					case 'booking_end':
					
					case 'item_quantity':
					
					return $item[ $column_name ];
					
					default:
					
					return print_r( $item, true ) ; 
				
				}		
			} 
			
			function get_sortable_columns() {
				return array(
				'order_id'  => array('order_id',true),
				'item_name'  => array('item_name',false),
				'order_date'  => array('order_date',false),
				'booking_start'  => array('booking_start',false),
				'booking_end' => array('booking_end', false),
				);
				
			} 
					
			function sort_data( $a, $b )
			{
				// Set defaults
				$orderby = 'order_id';
				$order = 'DESC';
				// If orderby is set, use this as the sort column
				if(!empty($_GET['orderby']))
				{
					$orderby = sanitize_text_field($_GET['orderby']);
				}
				// If order is set use this as the order
				if(!empty($_GET['order']))
				{
					$order = sanitize_text_field($_GET['order']);
				}
				$result = strcmp( $a[$orderby], $b[$orderby] );
				if($order === 'asc')
				{
					return $result;
				}
				return -$result;
			} 
				
		}
?>