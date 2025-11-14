<?php
/**
 * Template Name: Custom Home Page
 */

get_header(); ?>

<main id="maincontent" role="main">
  <?php do_action( 'vw_gardening_landscaping_before_slider' ); ?>

  <?php if( get_theme_mod( 'vw_gardening_landscaping_slider_hide_show', true) == 1 || get_theme_mod( 'vw_gardening_landscaping_resp_slider_hide_show', true) == 1) { ?>

    <section id="slider">
      <?php if(get_theme_mod('vw_gardening_landscaping_slider_type', 'Default slider') == 'Default slider' ){ ?>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="<?php echo esc_attr(get_theme_mod( 'vw_gardening_landscaping_slider_speed',4000)) ?>"> 
          <?php $vw_gardening_landscaping_slider_pages = array();
            for ( $count = 1; $count <= 3; $count++ ) {
              $mod = intval( get_theme_mod( 'vw_gardening_landscaping_slider_page' . $count ));
              if ( 'page-none-selected' != $mod ) {
                $vw_gardening_landscaping_slider_pages[] = $mod;
              }
            }
            if( !empty($vw_gardening_landscaping_slider_pages) ) :
              $args = array(
                'post_type' => 'page',
                'post__in' => $vw_gardening_landscaping_slider_pages,
                'orderby' => 'post__in'
              );
              $query = new WP_Query( $args );
              if ( $query->have_posts() ) :
                $i = 1;
          ?>     
          <div class="carousel-inner" role="listbox">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
              <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
                <?php if(has_post_thumbnail()){
                  the_post_thumbnail();
                } else{?>
                  <img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/block-patterns/images/slider1.png" alt="" />
                <?php } ?>
                <div class="carousel-caption">
                  <div class="inner_carousel">
                    <?php if( get_theme_mod('vw_gardening_landscaping_slider_title_hide_show',true) == 1){ ?>
                      <h1 class="wow rollIn delay-1000" data-wow-duration="3s"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                    <?php } ?>
                    <?php if( get_theme_mod('vw_gardening_landscaping_slider_content_hide_show',true) == 1){ ?>
                      <p class="wow rollIn delay-1000" data-wow-duration="3s"><?php $vw_gardening_landscaping_excerpt = get_the_excerpt(); echo esc_html( vw_gardening_landscaping_string_limit_words( $vw_gardening_landscaping_excerpt, esc_attr(get_theme_mod('vw_gardening_landscaping_slider_excerpt_number','30')))); ?></p>
                    <?php } ?>
                    <?php
                    $vw_gardening_landscaping_button_text = get_theme_mod('vw_gardening_landscaping_slider_button_text','READ MORE');
                    $vw_gardening_landscaping_button_link = get_theme_mod('vw_gardening_landscaping_top_button_url', '');
                    if (empty($vw_gardening_landscaping_button_link)) {
                      $vw_gardening_landscaping_button_link = get_permalink();
                    }
                    if ($vw_gardening_landscaping_button_text || !empty($vw_gardening_landscaping_button_link)) { ?>
                      <div class="more-btn wow rollIn delay-1000" data-wow-duration="3s">
                        <?php if( get_theme_mod('vw_gardening_landscaping_slider_button_text','READ MORE') != ''){ ?>
                          <a href="<?php echo esc_url($vw_gardening_landscaping_button_link); ?>" class="button redmor">
                          <?php echo esc_html($vw_gardening_landscaping_button_text); ?>
                            <span class="screen-reader-text"><?php echo esc_html($vw_gardening_landscaping_button_text); ?></span>
                          </a>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php $i++; endwhile; 
            wp_reset_postdata();?>
          </div>
          <?php else : ?>
              <div class="no-postfound"></div>
          <?php endif;
          endif;?>
          <a class="carousel-control-prev" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" role="button">
            <span class="carousel-control-prev-icon w-auto h-auto" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
            <span class="screen-reader-text"><?php esc_html_e( 'Previous','vw-gardening-landscaping' );?></span>
          </a>
          <a class="carousel-control-next" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" role="button">
            <span class="carousel-control-next-icon w-auto h-auto" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
            <span class="screen-reader-text"><?php esc_html_e( 'Next','vw-gardening-landscaping' );?></span>
          </a>
        </div>
        <div class="clearfix"></div>
      <?php } else if(get_theme_mod('vw_gardening_landscaping_slider_type', 'Advance slider') == 'Advance slider'){?>
        <?php echo do_shortcode(get_theme_mod('vw_gardening_landscaping_advance_slider_shortcode')); ?>
      <?php } ?>
    </section>
  <?php } ?>

  <?php do_action( 'vw_gardening_landscaping_after_slider' ); ?>

  <?php if( get_theme_mod('vw_gardening_landscaping_our_expertise') != ''){ ?>
    <section id="serv-section" class="wow zoomInDown delay-1000" data-wow-duration="2s">
      <div class="container">
        <?php if( get_theme_mod('vw_gardening_landscaping_section_text') != '' ){ ?>
          <h6 class="mb-3 htext text-center"><?php echo esc_html(get_theme_mod('vw_gardening_landscaping_section_text',''));?></h6>
        <?php }?>
        <?php if( get_theme_mod( 'vw_gardening_landscaping_section_title') != '') { ?>
          <h2><?php echo esc_html(get_theme_mod('vw_gardening_landscaping_section_title',''));?></h2>
        <?php }?>
        <div class="row">
          <?php
            $vw_gardening_landscaping_catData =  get_theme_mod('vw_gardening_landscaping_our_expertise','');
            if($vw_gardening_landscaping_catData){
            $page_query = new WP_Query(array( 'category_name' => esc_html($vw_gardening_landscaping_catData,'vw-gardening-landscaping'))); ?>
            <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
            <div class="col-lg-4 col-md-6">
              <div class="serv-box">
                <?php the_post_thumbnail(); ?>
                <h3><?php the_title(); ?></h3>
                <p><?php $vw_gardening_landscaping_excerpt = get_the_excerpt(); echo esc_html( vw_gardening_landscaping_string_limit_words( $vw_gardening_landscaping_excerpt, esc_attr(get_theme_mod('vw_gardening_landscaping_expertise_excerpt_number','30')))); ?></p>
                <?php if( get_theme_mod('vw_gardening_landscaping_expertise_button_text','READ MORE') != ''){ ?>
                  <div class="expertise-btn">
                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_theme_mod('vw_gardening_landscaping_expertise_button_text',__('READ MORE','vw-gardening-landscaping')));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('vw_gardening_landscaping_expertise_button_text',__('READ MORE','vw-gardening-landscaping')));?></span></a>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php endwhile;
            wp_reset_postdata();
          } ?>
        </div>
      </div>
    </section>
  <?php }?>
  <?php do_action( 'vw_gardening_landscaping_after_expertise_section' ); ?>

  <div class="content-vw py-3">
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
