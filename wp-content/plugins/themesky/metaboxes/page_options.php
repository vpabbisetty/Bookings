<?php
$options = array();
$default_sidebars = function_exists('boxshop_get_list_sidebars')?boxshop_get_list_sidebars():array();
$sidebar_options = array();
foreach( $default_sidebars as $key => $_sidebar ){
	$sidebar_options[$_sidebar['id']] = $_sidebar['name'];
}

/* Get list menus */
$menus = array('0' => esc_html__('Default', 'themesky'));
$nav_terms = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
if( is_array($nav_terms) ){
	foreach( $nav_terms as $term ){
		$menus[$term->term_id] = $term->name;
	}
}

/* Get list Footer Blocks */
$footer_blocks = array('0' => esc_html__('Default', 'themesky'));

$args = array(
	'post_type'			=> 'ts_footer_block'
	,'post_status'	 	=> 'publish'
	,'posts_per_page' 	=> -1
);

$posts = new WP_Query($args);

if( !empty( $posts->posts ) && is_array( $posts->posts ) ){
	foreach( $posts->posts as $p ){
		$footer_blocks[$p->ID] = $p->post_title;
	}
}

wp_reset_postdata();

$options[] = array(
				'id'		=> 'page_layout_heading'
				,'label'	=> esc_html__('Page Layout', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'heading'
			);

$options[] = array(
				'id'		=> 'layout_style'
				,'label'	=> esc_html__('Layout Style', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
									'default'  	=> esc_html__('Default', 'themesky')
									,'boxed' 	=> esc_html__('Boxed', 'themesky')
									,'wide' 	=> esc_html__('Wide', 'themesky')
								)
			);
			
$options[] = array(
				'id'		=> 'page_layout'
				,'label'	=> esc_html__('Page Layout', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
									'0-1-0'  => esc_html__('Fullwidth', 'themesky')
									,'1-1-0' => esc_html__('Left Sidebar', 'themesky')
									,'0-1-1' => esc_html__('Right Sidebar', 'themesky')
									,'1-1-1' => esc_html__('Left & Right Sidebar', 'themesky')
								)
			);
			
$options[] = array(
				'id'		=> 'left_sidebar'
				,'label'	=> esc_html__('Left Sidebar', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> $sidebar_options
			);

$options[] = array(
				'id'		=> 'right_sidebar'
				,'label'	=> esc_html__('Right Sidebar', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> $sidebar_options
			);
			
$options[] = array(
				'id'		=> 'header_breadcrumb_heading'
				,'label'	=> esc_html__('Header - Breadcrumb', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'heading'
			);
			
$options[] = array(
				'id'		=> 'header_layout'
				,'label'	=> esc_html__('Header Layout', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
									'default'  	=> esc_html__('Default', 'themesky')
									,'v1'  		=> esc_html__('Header Layout 1', 'themesky')
									,'v2' 		=> esc_html__('Header Layout 2', 'themesky')
									,'v3' 		=> esc_html__('Header Layout 3', 'themesky')
									,'v4' 		=> esc_html__('Header Layout 4', 'themesky')
									,'v5' 		=> esc_html__('Header Layout 5', 'themesky')
									,'v6' 		=> esc_html__('Header Layout 6', 'themesky')
									,'v7' 		=> esc_html__('Header Layout 7', 'themesky')
								)
			);
			
$options[] = array(
				'id'		=> 'top_header_transparent'
				,'label'	=> esc_html__('Top Header Transparent', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
								'1'		=> esc_html__('Yes', 'themesky')
								,'0'	=> esc_html__('No', 'themesky')
								)
				,'default'	=> '0'
			);
			
$options[] = array(
				'id'		=> 'top_header_text_color'
				,'label'	=> esc_html__('Top Header Text Color', 'themesky')
				,'desc'		=> esc_html__('Available when Top Header Transparent is enabled', 'themesky')
				,'type'		=> 'select'
				,'options'	=> array(
								'default'	=> esc_html__('Default', 'themesky')
								,'light'	=> esc_html__('Light', 'themesky')
								)
			);

$options[] = array(
				'id'		=> 'menu_id'
				,'label'	=> esc_html__('Primary Menu', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> $menus
			);
			
$options[] = array(
				'id'		=> 'display_vertical_menu_by_default'
				,'label'	=> esc_html__('Display Vertical Menu By Default', 'themesky')
				,'desc'		=> esc_html__('If this option is enabled, you wont need to hover to see the vertical menu', 'themesky')
				,'type'		=> 'select'
				,'default'	=> 0
				,'options'	=> array(
								'1'		=> esc_html__('Yes', 'themesky')
								,'0'	=> esc_html__('No', 'themesky')
								)
			);
			
$options[] = array(
				'id'		=> 'show_page_title'
				,'label'	=> esc_html__('Show Page Title', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
								'1'		=> esc_html__('Yes', 'themesky')
								,'0'	=> esc_html__('No', 'themesky')
								)
			);
			
$options[] = array(
				'id'		=> 'show_breadcrumb'
				,'label'	=> esc_html__('Show Breadcrumb', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
								'1'		=> esc_html__('Yes', 'themesky')
								,'0'	=> esc_html__('No', 'themesky')
								)
			);
			
$options[] = array(
				'id'		=> 'breadcrumb_layout'
				,'label'	=> esc_html__('Breadcrumb Layout', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
									'default'  	=> esc_html__('Default', 'themesky')
									,'v1'  		=> esc_html__('Breadcrumb Layout 1', 'themesky')
									,'v2' 		=> esc_html__('Breadcrumb Layout 2', 'themesky')
									,'v3' 		=> esc_html__('Breadcrumb Layout 3', 'themesky')
								)
			);
			
$options[] = array(
				'id'		=> 'breadcrumb_bg_parallax'
				,'label'	=> esc_html__('Breadcrumb Background Parallax', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
								'default'  	=> esc_html__('Default', 'themesky')
								,'1'		=> esc_html__('Yes', 'themesky')
								,'0'		=> esc_html__('No', 'themesky')
								)
			);
			
$options[] = array(
				'id'		=> 'bg_breadcrumbs'
				,'label'	=> esc_html__('Breadcrumb Background Image', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'upload'
			);	
			
$options[] = array(
				'id'		=> 'logo'
				,'label'	=> esc_html__('Logo', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'upload'
			);
			
$options[] = array(
				'id'		=> 'logo_mobile'
				,'label'	=> esc_html__('Mobile Logo', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'upload'
			);
			
$options[] = array(
				'id'		=> 'logo_sticky'
				,'label'	=> esc_html__('Sticky Logo', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'upload'
			);

$options[] = array(
				'id'		=> 'page_slider_heading'
				,'label'	=> esc_html__('Page Slider', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'heading'
			);			
			
$revolution_exists = class_exists('RevSliderSlider');

$page_sliders = array();
$page_sliders[0] = esc_html__('No Slider', 'themesky');
if( $revolution_exists ){
	$page_sliders['revslider']	= esc_html__('Revolution Slider', 'themesky');
}

$options[] = array(
				'id'		=> 'page_slider'
				,'label'	=> esc_html__('Page Slider', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> $page_sliders
			);
			
$options[] = array(
				'id'		=> 'page_slider_position'
				,'label'	=> esc_html__('Page Slider Position', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
							'before_header'			=> esc_html__('Before Header', 'themesky')
							,'before_main_content'	=> esc_html__('Before Main Content', 'themesky')
							)
				,'default'	=> 'before_main_content'
			);

if( $revolution_exists ){
	global $wpdb, $post;
	$revsliders = array();
	$revsliders[0] = esc_html__('Select a slider', 'themesky');
	$sliders = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."revslider_sliders where type != 'folder'");
	if( $sliders ){
		foreach( $sliders as $slider ){
			$revsliders[$slider->alias] = $slider->title;
		}
		
		/* Convert id to alias */
		$selected_slider = get_post_meta($post->ID, 'ts_rev_slider', true);
		if( $selected_slider && is_numeric($selected_slider) ){
			$slider_ids = wp_list_pluck($sliders, 'id');
			$slider_alias = wp_list_pluck($sliders, 'alias');
			$key = array_search($selected_slider, $slider_ids);
			if( $key !== false ){
				update_post_meta($post->ID, 'ts_rev_slider', $slider_alias[$key]);
			}
		}
	}
				
	$options[] = array(
					'id'		=> 'rev_slider'
					,'label'	=> esc_html__('Select Revolution Slider', 'themesky')
					,'desc'		=> ''
					,'type'		=> 'select'
					,'options'	=> $revsliders
				);
}

$options[] = array(
				'id'		=> 'page_footer_heading'
				,'label'	=> esc_html__('Page Footer', 'themesky')
				,'desc'		=> esc_html__('You also need to add the TS - Footer Block widget to Footer (Copyright) Widget Area', 'themesky')
				,'type'		=> 'heading'
			);
	
$options[] = array(
				'id'		=> 'footer_id'
				,'label'	=> esc_html__('Footer Widget Area', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> $footer_blocks
			);
	
$options[] = array(
				'id'		=> 'footer_copyright_id'
				,'label'	=> esc_html__('Footer Copyright Widget Area', 'themesky')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> $footer_blocks
			);
?>