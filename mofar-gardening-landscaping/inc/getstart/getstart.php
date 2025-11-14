<?php
//about theme info
add_action( 'admin_menu', 'vw_gardening_landscaping_gettingstarted' );
function vw_gardening_landscaping_gettingstarted() {
	add_theme_page( esc_html__('About VW Gardening Landscaping', 'vw-gardening-landscaping'), esc_html__('Theme Demo Import', 'vw-gardening-landscaping'), 'edit_theme_options', 'vw_gardening_landscaping_guide', 'vw_gardening_landscaping_mostrar_guide');
}

// Add a Custom CSS file to WP Admin Area
function vw_gardening_landscaping_admin_theme_style() {
   wp_enqueue_style('vw-gardening-landscaping-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getstart/getstart.css');
   wp_enqueue_script('vw-gardening-landscaping-tabs', esc_url(get_template_directory_uri()) . '/inc/getstart/js/tab.js');
}
add_action('admin_enqueue_scripts', 'vw_gardening_landscaping_admin_theme_style');

//guidline for about theme
function vw_gardening_landscaping_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'vw-gardening-landscaping' );
?>

<div class="wrapper-info">
    <div class="col-left sshot-section">
    	<h2><?php esc_html_e( 'Welcome to VW Gardening Landscaping Theme', 'vw-gardening-landscaping' ); ?> <span class="version">Version: <?php echo esc_html($theme['Version']);?></span></h2>
    	<p><?php esc_html_e('All our WordPress themes are modern, minimalist, 100% responsive, seo-friendly,feature-rich, and multipurpose that best suit designers, bloggers and other professionals who are working in the creative fields.','vw-gardening-landscaping'); ?></p>
    </div>
    <div class="col-right coupen-section">
		<div class="logo-section">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" alt="" />
		</div>
		<div class="logo-right">			
			<div class="update-now">
				<div class="theme-info">
					<div class="theme-info-left">
						<h2><?php esc_html_e('TRY PREMIUM','vw-gardening-landscaping'); ?></h2>
						<h4><?php esc_html_e('VW GARDENING LANDSCAPING THEME','vw-gardening-landscaping'); ?></h4>
					</div>	
					<div class="theme-info-right"></div>
				</div>	
				<div class="dicount-row">
					<div class="disc-sec">	
						<h5 class="disc-text"><?php esc_html_e('GET THE FLAT DISCOUNT OF','vw-gardening-landscaping'); ?></h5>
						<h1 class="disc-per"><?php esc_html_e('20%','vw-gardening-landscaping'); ?></h1>	
					</div>
					<div class="coupen-info">
						<h5 class="coupen-code"><?php esc_html_e('"VWPRO20"','vw-gardening-landscaping'); ?></h5>
						<h5 class="coupen-text"><?php esc_html_e('USE COUPON CODE','vw-gardening-landscaping'); ?></h5>
						<div class="info-link">						
							<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_BUY_NOW ); ?>" target="_blank"> <?php esc_html_e( 'UPGRADE TO PRO', 'vw-gardening-landscaping' ); ?></a>
						</div>	
					</div>	
				</div>				
			</div>
		</div>
    </div>

    <div class="tab-sec">
		<div class="tab">
			<button class="tablinks" onclick="vw_gardening_landscaping_open_tab(event, 'theme_offer')"><?php esc_html_e( 'Demo Importer', 'vw-gardening-landscaping' ); ?></button>
			<button class="tablinks" onclick="vw_gardening_landscaping_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Setup With Customizer', 'vw-gardening-landscaping' ); ?></button>		 
			
		  	<button class="tablinks" onclick="vw_gardening_landscaping_open_tab(event, 'gardening_pro')"><?php esc_html_e( 'Get Premium', 'vw-gardening-landscaping' ); ?></button>
		  	<button class="tablinks" onclick="vw_gardening_landscaping_open_tab(event, 'free_pro')"><?php esc_html_e( 'Free Vs Premium', 'vw-gardening-landscaping' ); ?></button>
		  	<button class="tablinks" onclick="vw_gardening_landscaping_open_tab(event, 'get_bundle')"><?php esc_html_e( 'Get 350+ Themes Bundle at $99', 'vw-gardening-landscaping' ); ?></button>
		</div>

		<?php
			$vw_gardening_landscaping_plugin_custom_css = '';
			if(class_exists('Ibtana_Visual_Editor_Menu_Class')){
				$vw_gardening_landscaping_plugin_custom_css ='display: block';
			}
		?>
		<div id="theme_offer" class="tabcontent open">
			<div class="demo-content">
				<h3><?php esc_html_e( 'Click the below run importer button to import demo content', 'vw-gardening-landscaping' ); ?></h3>
				<?php 
				/* Get Started. */ 
				require get_parent_theme_file_path( '/inc/getstart/demo-content.php' );
			 	?>
			</div> 	
		</div>

		<div id="lite_theme" class="tabcontent">
			<?php  if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
				$plugin_ins = VW_Gardening_Landscaping_Plugin_Activation_Settings::get_instance();
				$vw_gardening_landscaping_actions = $plugin_ins->recommended_actions;
				?>
				<div class="vw-gardening-landscaping-recommended-plugins">
				    <div class="vw-gardening-landscaping-action-list">
				        <?php if ($vw_gardening_landscaping_actions): foreach ($vw_gardening_landscaping_actions as $key => $vw_gardening_landscaping_actionValue): ?>
				                <div class="vw-gardening-landscaping-action" id="<?php echo esc_attr($vw_gardening_landscaping_actionValue['id']);?>">
			                        <div class="action-inner">
			                            <h3 class="action-title"><?php echo esc_html($vw_gardening_landscaping_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($vw_gardening_landscaping_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($vw_gardening_landscaping_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" get-start-tab-id="lite-theme-tab" href="javascript:void(0);"><?php esc_html_e('Skip','vw-gardening-landscaping'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="lite-theme-tab" style="<?php echo esc_attr($vw_gardening_landscaping_plugin_custom_css); ?>">
				<h3><?php esc_html_e( 'Lite Theme Information', 'vw-gardening-landscaping' ); ?></h3>
				<hr class="h3hr">
			  	<p><?php esc_html_e('VW Gardening Landscaping is a refreshing, clean, reliable, robust, dynamic and feature-full gardening and landscaping WordPress theme for lawn services, sod cutting services, gardening and landscaping, lawn decorators, farm producers, garden designers, florists, naturopathy, organic medicinal herbs, Real Estate Agencies, Home Improvement Blogs, Community Gardens, landscape architects, environmentalist, grow and sell herbs, flowershop, Landscape Photography Portfolios, Landscaping Supply Stores, gardening, landscaping, earth, Gardening Blogs, Outdoor Design Studios, Environmental Organizations, Outdoor Recreation Businesses, Botanical Gardens, Greenhouse Nurseries, vegan food, plant, Backyard Nursery, Florist, Vegetable Farmer, forest department and forest guards, green tourism industry, Landscaping Companies, green farming, natural and ayurvedic products, greenery theme for Gardeners, Compost Sales, Fertilizer Sales, Small Poultry Farm, Fish Farmer, Beekeeper, Nurseries, conservationist, organic food, renewable energy provider, land scrappers,Landscape Maintenance Services, Outdoor Wedding Venues, agricultural products, agri based foods, Landscape Construction Companies, Petting Farm, Corn Maze, eco social group websites, organic farmers, ecologists, natural, earth website, plants shop, Nature lover, Nursury shop landscaper, hire gardener, eco natural, fresh, organic life projects, life safeguarding pledge drives, natural life ventures, foundation, fertilizer maker and supplier, gardening tools store, flowers, nature, eco friendly, green renewable energy, conservation and all such websites. This theme can also be customized for Landscape Product Reviews and Recommendations, Outdoor Cooking and BBQ Blogs, Outdoor Recreation Guides, Landscape Conservation Organizations, Outdoor Wedding Photography Studios. It has multiple website layouts like boxed, full-width and full screen; unlimited colour options and over 100+ Google fonts. This garden WordPress theme is fully responsive, cross-browser compatible, wide blocks, block editor styles, featured images, social media linked and SEO friendly. It is translation ready and supports RTL writing style. It is packed with an amazing range of advanced features and functionality along with some predesigned inner pages and a fully explained documentation. This theme has a super-efficient theme customizer that eases the burden of making changes to the website through theme customizer. It is made to work conveniently with third party plugins and integrated with WooCommerce to instantly set up an online store with beautiful product pages and secure payment gateways. It is compatible with the latest WordPress version and coded in clean environment. It is helpful for Groundskeepers, firewood, ecology, lumberjack, Agriculture, wildlife, Vacation Rentals with Outdoor Spaces, Big or Small gardener Business, green products business website, environmental project and plantation.','vw-gardening-landscaping'); ?></p>
			  	<div class="col-left-inner">
			  		<h4><?php esc_html_e( 'Theme Documentation', 'vw-gardening-landscaping' ); ?></h4>
					<p><?php esc_html_e( 'If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'vw-gardening-landscaping' ); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'vw-gardening-landscaping' ); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Theme Customizer', 'vw-gardening-landscaping'); ?></h4>
					<p> <?php esc_html_e('To begin customizing your website, start by clicking "Customize".', 'vw-gardening-landscaping'); ?></p>
					<div class="info-link">
						<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'vw-gardening-landscaping'); ?></a>
					</div>
					<hr>				
					<h4><?php esc_html_e('Having Trouble, Need Support?', 'vw-gardening-landscaping'); ?></h4>
					<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'vw-gardening-landscaping'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'vw-gardening-landscaping'); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Reviews & Testimonials', 'vw-gardening-landscaping'); ?></h4>
					<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'vw-gardening-landscaping'); ?>  </p>
					<div class="info-link">
						<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'vw-gardening-landscaping'); ?></a>
					</div>
			  		<div class="link-customizer">
						<h3><?php esc_html_e( 'Link to customizer', 'vw-gardening-landscaping' ); ?></h3>
						<hr class="h3hr">
						<div class="first-row">
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','vw-gardening-landscaping'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-slides"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_gardening_landscaping_slidersettings') ); ?>" target="_blank"><?php esc_html_e('Slider Settings','vw-gardening-landscaping'); ?></a>
								</div>
							</div>
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-welcome-write-blog"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_gardening_landscaping_topbar') ); ?>" target="_blank"><?php esc_html_e('Topbar Settings','vw-gardening-landscaping'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-editor-table"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_gardening_landscaping_expertise_section') ); ?>" target="_blank"><?php esc_html_e('Our Expertise','vw-gardening-landscaping'); ?></a>
								</div>
							</div>
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','vw-gardening-landscaping'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','vw-gardening-landscaping'); ?></a>
								</div>
							</div>

							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_gardening_landscaping_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','vw-gardening-landscaping'); ?></a>
								</div>
								 <div class="row-box2">
									<span class="dashicons dashicons-align-center"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_gardening_landscaping_woocommerce_section') ); ?>" target="_blank"><?php esc_html_e('WooCommerce Layout','vw-gardening-landscaping'); ?></a>
								</div> 
							</div>
							
							<div class="row-box">
								<div class="row-box1">
									<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_gardening_landscaping_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','vw-gardening-landscaping'); ?></a>
								</div>
								<div class="row-box2">
									<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_gardening_landscaping_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','vw-gardening-landscaping'); ?></a>
								</div>
							</div>
						</div>
					</div>
			  	</div>
				<div class="col-right-inner">
					<h3 class="page-template"><?php esc_html_e('How to set up Home Page Template','vw-gardening-landscaping'); ?></h3>
				  	<hr class="h3hr">
					<p><?php esc_html_e('Follow these instructions to setup Home page.','vw-gardening-landscaping'); ?></p>
	                <ul>
	                  	<p><span class="strong"><?php esc_html_e('1. Create a new page :','vw-gardening-landscaping'); ?></span><?php esc_html_e(' Go to ','vw-gardening-landscaping'); ?>
					  	<b><?php esc_html_e(' Dashboard >> Pages >> Add New Page','vw-gardening-landscaping'); ?></b></p>

	                  	<p><?php esc_html_e('Name it as "Home" then select the template "Custom Home Page".','vw-gardening-landscaping'); ?></p>
	                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/home-page-template.png" alt="" />
	                  	<p><span class="strong"><?php esc_html_e('2. Set the front page:','vw-gardening-landscaping'); ?></span><?php esc_html_e(' Go to ','vw-gardening-landscaping'); ?>
					  	<b><?php esc_html_e(' Settings >> Reading ','vw-gardening-landscaping'); ?></b></p>
					  	<p><?php esc_html_e('Select the option of Static Page, now select the page you created to be the homepage, while another page to be your default page.','vw-gardening-landscaping'); ?></p>
	                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/set-front-page.png" alt="" />
	                  	<p><?php esc_html_e(' Once you are done with this, then follow the','vw-gardening-landscaping'); ?> <a class="doc-links" href="https://preview.vwthemesdemo.com/docs/free-vw-gardening-landscaping/" target="_blank"><?php esc_html_e('Documentation','vw-gardening-landscaping'); ?></a></p>
	                </ul>
			  	</div>
			</div>
		</div>	


		<div id="gardening_pro" class="tabcontent">
		  	<h3><?php esc_html_e( 'Premium Theme Information', 'vw-gardening-landscaping' ); ?></h3>
			<hr class="h3hr">
		    <div class="col-left-pro">
		    	<p><?php esc_html_e('This landscaping WordPress theme brings many incredible features under one roof to help you design a performance focused website with unique design and visually stunning look. The thoughtful placement of objects throughout the theme leads to a beautiful design which catches user attention at the very first glance. It is an intuitive theme with the use of refreshing colours and apt typography making it more impactful. This landscaping WordPress theme requires minimum efforts to set it up and hence is equally easy for experienced coder and WordPress newbie to explore it to its maximum potential to craft a highly efficient gardening and landscaping website. Whether you run the biggest nursery shop in your city or famous for offering gardening services throughout the country, this landscaping WP theme will perfectly represent your brand aiding you in handling your website smoothly without ever raising the need to take help from outside.','vw-gardening-landscaping'); ?></p>
		    	
		    </div>
		    <div class="col-right-pro">
		    	<div class="pro-links">
			    	<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'vw-gardening-landscaping'); ?></a>
					<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'vw-gardening-landscaping'); ?></a>
					<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'vw-gardening-landscaping'); ?></a>
					<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Get 350+ Themes Bundle at $99', 'vw-gardening-landscaping'); ?></a>
				</div>
		    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/responsive.png" alt="" />
		    </div>
		    
		</div>

		<div id="free_pro" class="tabcontent">
		  	<div class="featurebox">
			    <h3><?php esc_html_e( 'Theme Features', 'vw-gardening-landscaping' ); ?></h3>
				<hr class="h3hr">
				<div class="table-image">
					<table class="tablebox">
						<thead>
							<tr>
								<th></th>
								<th><?php esc_html_e('Free Themes', 'vw-gardening-landscaping'); ?></th>
								<th><?php esc_html_e('Premium Themes', 'vw-gardening-landscaping'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php esc_html_e('Theme Customization', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Responsive Design', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Logo Upload', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Social Media Links', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Slider Settings', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Number of Slides', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><?php esc_html_e('4', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><?php esc_html_e('Unlimited', 'vw-gardening-landscaping'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Template Pages', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><?php esc_html_e('15', 'vw-gardening-landscaping'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Home Page Template', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><?php esc_html_e('2', 'vw-gardening-landscaping'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Theme sections', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><?php esc_html_e('2', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><?php esc_html_e('14', 'vw-gardening-landscaping'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Contact us Page Template', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('1', 'vw-gardening-landscaping'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Blog Templates & Layout', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'vw-gardening-landscaping'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Page Templates & Layout', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('2(Left/Right Sidebar)', 'vw-gardening-landscaping'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Color Pallete For Particular Sections', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Global Color Option', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Reordering', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Demo Importer', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Allow To Set Site Title, Tagline, Logo', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Enable Disable Options On All Sections, Logo', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Full Documentation', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Latest WordPress Compatibility', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Woo-Commerce Compatibility', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Support 3rd Party Plugins', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Secure and Optimized Code', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Exclusive Functionalities', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Enable / Disable', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Section Google Font Choices', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Gallery', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Simple & Mega Menu Option', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support to add custom CSS / JS ', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Shortcodes', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Premium Membership', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Budget Friendly Value', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Priority Error Fixing', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Feature Addition', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('All Access Theme Pass', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Seamless Customer Support', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('WordPress 6.4 or later', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('PHP 8.2 or 8.3', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('MySQL 5.6 (or greater) | MariaDB 10.0 (or greater)', 'vw-gardening-landscaping'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td></td>
								<td class="table-img"></td>
								<td class="update-link"><a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'vw-gardening-landscaping'); ?></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div id="get_bundle" class="tabcontent">		  	
		   <div class="col-left-pro">
		   	<h3><?php esc_html_e( 'WP Theme Bundle', 'vw-gardening-landscaping' ); ?></h3>
		    	<p><?php esc_html_e('Enhance your website effortlessly with our WP Theme Bundle. Get access to 350+ premium WordPress themes and 5+ powerful plugins, all designed to meet diverse business needs. Enjoy seamless integration with any plugins, ultimate customization flexibility, and regular updates to keep your site current and secure. Plus, benefit from our dedicated customer support, ensuring a smooth and professional web experience.','vw-gardening-landscaping'); ?></p>
		    	<div class="feature">
		    		<h4><?php esc_html_e( 'Features:', 'vw-gardening-landscaping' ); ?></h4>
		    		<p><?php esc_html_e('350+ Premium Themes & 5+ Plugins.', 'vw-gardening-landscaping'); ?></p>
		    		<p><?php esc_html_e('Seamless Integration.', 'vw-gardening-landscaping'); ?></p>
		    		<p><?php esc_html_e('Customization Flexibility.', 'vw-gardening-landscaping'); ?></p>
		    		<p><?php esc_html_e('Regular Updates.', 'vw-gardening-landscaping'); ?></p>
		    		<p><?php esc_html_e('Dedicated Support.', 'vw-gardening-landscaping'); ?></p>
		    	</div>
		    	<p><?php esc_html_e('Upgrade now and give your website the professional edge it deserves, all at an unbeatable price of $99!', 'vw-gardening-landscaping'); ?></p>
		    	<div class="pro-links">
					<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Now', 'vw-gardening-landscaping'); ?></a>
					<a href="<?php echo esc_url( VW_GARDENING_LANDSCAPING_THEME_BUNDLE_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'vw-gardening-landscaping'); ?></a>
				</div>
		   </div>
		   <div class="col-right-pro">
		    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/bundle.png" alt="" />
		   </div>		    
		</div>
	</div>
</div>
<?php } ?>