<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				
				?> 
				
				<h1>Title: <?php echo the_field('bookTitel'); ?></h1>
				<b> Author/Authors:  </b>
				<?php 
				$authors = get_field('kanbook_author');
				if (!empty($authors))
				{
				    foreach($authors as $author_id)
				    {
				        $author = get_post($author_id);
				        echo '<a href="'.$author->guid.'">' . $author->post_title . '</a>, ';
				    }
				    echo '<br>';
				}
				?>
				
				
                <b> Release date: </b> <?php the_field('kanbooks_release_date'); ?><br>
				<b> ISBN: </b> <?php the_field('kanbooks_isbn'); ?><br>
			
			
				<div style="width:100%; margin:10px">
    			<div style="float:left;width:25%">
    			<img src="<?php the_field('omslagsbild'); ?>"style="vertical-align:middle" />
    			</div>
    			<div style="float:left;width:70%; margin-left:10px;">
    			<span> Description:  <?php the_field('description'); ?></span><br>
				</div>
    			</div>
    			<div style="clear:both"></div>
				<?php 
				the_post_navigation(
					array(
						'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'twentyseventeen' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
						'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'twentyseventeen' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
					)
				);

			endwhile; // End the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php
get_footer();
