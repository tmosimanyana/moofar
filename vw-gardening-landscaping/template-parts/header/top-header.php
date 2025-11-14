<?php
/**
 * The template part for top header
 *
 * @package VW Gardening Landscaping 
 * @subpackage vw_gardening_landscaping
 * @since VW Gardening Landscaping 1.0
 */
?>
<?php if( get_theme_mod( 'vw_gardening_landscaping_topbar_hide_show', true) == 1 || get_theme_mod( 'vw_gardening_landscaping_resp_topbar_hide_show', true) == 1) { ?>
  <div id="topbar">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 col-md-8">
          <div class="row">
            <div class="col-lg-4 col-md-4">
              <?php if( get_theme_mod( 'vw_gardening_landscaping_phone_number') != '') { ?>
                <i class="<?php echo esc_attr(get_theme_mod('vw_gardening_landscaping_phone_icon','fas fa-phone')); ?>"></i><span><a href="tel:<?php echo esc_attr( get_theme_mod('vw_gardening_landscaping_phone_number','') ); ?>"><?php echo esc_html(get_theme_mod('vw_gardening_landscaping_phone_number',''));?></a></span>
              <?php }?>
            </div>
            <div class="col-lg-8 col-md-8">
              <?php if( get_theme_mod( 'vw_gardening_landscaping_email_address') != '') { ?>
                <i class="<?php echo esc_attr(get_theme_mod('vw_gardening_landscaping_email_icon','fas fa-envelope-open')); ?>"></i><span><a href="mailto:<?php echo esc_attr(get_theme_mod('vw_gardening_landscaping_email_address',''));?>"><?php echo esc_html(get_theme_mod('vw_gardening_landscaping_email_address',''));?></a></span>
              <?php }?>
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-md-4">
          <div class="row">
            <div class="<?php if( get_theme_mod( 'vw_gardening_landscaping_search_hide_show',true) == 1) { ?>col-lg-11 col-md-10"<?php } else { ?>col-lg-12 col-md-12<?php } ?>">
              <?php if (is_active_sidebar('social-links')) : ?>
                <?php dynamic_sidebar('social-links'); ?>
              <?php else : ?>
                <!-- Default Social Icons Widgets -->
                  <div class="widget">
                      <ul class="custom-social-icons" >
                        <li><a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a></li> 
                        <li><a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a></li> 
                        <li><a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a></li> 
                        <li><a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a></li> 
                        <li><a href="https://pinterest.com" target="_blank"><i class="fab fa-pinterest"></i></a></li> 
                        <li><a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a></li>                     
                      </ul>
                  </div>
              <?php endif; ?>  
            </div>
            <?php if( get_theme_mod( 'vw_gardening_landscaping_search_hide_show',true) == 1) { ?>
              <div class="col-lg-1 col-md-1">
                <div class="search-box">
                  <span><a href="#"><i class="<?php echo esc_attr(get_theme_mod('vw_gardening_landscaping_search_icon','fas fa-search')); ?>"></i></a></span>
                </div>
              </div>
            <?php }?>
          </div>
        </div>
      </div>
      <div class="serach_outer">
        <div class="closepop"><a href="#maincontent"><i class="<?php echo esc_attr(get_theme_mod('vw_gardening_landscaping_search_close_icon','fa fa-window-close')); ?>"></i></a></div>
        <div class="serach_inner">
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
  </div>
<?php }?>