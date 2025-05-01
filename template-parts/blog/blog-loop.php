<?php 
if ( have_posts() )
{ 
	$cols	=	'';
	$sidebar_opt = fl_framework_get_options('blog_sidebar');
	if( isset( $sidebar_opt ) && $sidebar_opt == 'no-sidebar' )
	{
		$cols	=	'col-xl-4 col-sm-4';	
	}
	else
	{
		$cols	=	'col-xl-6 col-sm-6';	
	}
	if ( !is_active_sidebar( 'exertia-blog-widget' ) ) {
		$cols	=	'col-xl-4 col-sm-4 col-12';	
	}
    while ( have_posts() )
    { 

    the_post();
	$post_id = get_the_ID();
		?>
        <div class=" <?php echo esc_attr( $cols ); ?> grid-item">
            <div <?php post_class(); ?>>
                <div class="fr-latest-box selim">
                <?php
					if ( has_post_thumbnail( $post_id ) )
					{
						?>
                        <div class="fr-latest-content"> <a href="<?php the_permalink(); ?>"><?php echo exertio_get_feature_image(get_the_ID(), 'blog-grid-img'); ?></a> </div>
                        <?php
					}
                    $profile_clickable = $profile_clickable_close = '';
                    if (fl_framework_get_options("em_allow_profile_clickable") == 1) {
                        $profile_clickable .= '<a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'">';
                        $profile_clickable_close = '</a>';
                    }
					?>
                    <div class="fr-latest-sm">
                    <div class="fr-latest-content">
                        <h3><a href="<?php the_permalink(); ?>"> <?php echo get_the_title(); ?></a></h3>
                      <div class="fr-latest-style">
                        <ul>
                          <li> <?php echo $profile_clickable;?>
                            <div class="fr-latest-profile"> <?php echo get_avatar( get_the_author_meta('ID'), 40); ?> <span><?php the_author(); ?></span> </div>
                            <?php echo $profile_clickable_close;?> </li>
                          <li>
                            <div class="fr-latest-profile"> <i class="fa fa-calendar"></i> <span><?php echo get_the_date( 'F j, Y', $post_id ); ?></span> </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="fr-latest-container">
                      <p><?php echo wp_trim_words(get_the_excerpt(), 10, '...'); ?></p>
                      <a href="<?php the_permalink(); ?>"><span class="readmore"><?php echo esc_html__('Read More','khebrat_theme'); ?><i class="fa fa-long-arrow-right"></i></span></a></div>
                    </div>
                </div>
            </div>
          </div>
		<?php     
    }
}
else
{
    get_template_part( 'template-parts/blog/content', 'none' );
}
?>