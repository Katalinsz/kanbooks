<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

get_header(); 

?>
<div class="wrap">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->
		<?php 
		$search_template = do_shortcode('[wpdreams_ajaxsearchlite]'); 
		if (!strstr($search_template, "[wpdreams_ajaxsearchlite]")) {
		  echo do_shortcode('[wpdreams_ajaxsearchlite]'); 
		}
	   ?>
		
		<div class="kanbooks_sortby">
    		<form action="" method="get">
    			<select name="orderby">
    				<option value="kanbooks_release_date">Release date</option>
    				<option value="post_date">Post date</option> 
    			</select>
    			<input type="hidden" name="post_type" value="kanbooks">
    			<input type="submit" value="Sort">
    		</form>
		</div>			
		<div class="clearfix"></div>
    			
		
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="kanbooks-site-main" role="main">

		<?php
		if ( have_posts() ) :
			?>
			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that
				 * will be used instead.
				 */
				?>
				
				<h2><a href="<?php the_permalink(); ?>"><?php echo the_field('bookTitel'); ?></a> </h2>
			
				<?php 
				//$authors = get_field('kanbook_author');
				//$authors = get_authors_for_book_id( get_the_ID );
				//$authors = get_all_of_post_type('kanbooksauthor');
				$authors = get_field('kanbook_author'); 
				if (!empty($authors))
				{
				    $add_comma = ''; 
                    foreach($authors as $author_id)
                	{
                	    $author = get_post($author_id); 
                	    echo $add_comma.'<a href="'.$author->guid.'">' . $author->post_title . '</a>';
                	    $add_comma = ', '; 
                	}
                    echo '<br>';	
				}
                ?>
                
    			<b> ISBN: </b> <?php the_field('kanbooks_isbn'); ?><br>
    			
    			<div class="kanbooks_list_item">
        			<div class="kanbooks_list_item_image">
        				<img src="<?php the_field('omslagsbild'); ?>"/>
        			</div>
        			<div class="kanbooks_list_item_text">
        				<span style="vertical-align:middle"><?php echo substr(get_field('description'), 0, 75); ?></span><br>
        			</div>
    			</div>
    			<div class="clearfix"></div>
    			<hr class="kanbooks_hr">
    			
<?php 
			endwhile;
			the_posts_pagination(
				array(
					'prev_text'          => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
					'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
				)
			);

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<style>
    .kanbooks-site-main {
        margin-top: 20px; 
    }
    .kanbooks_list_item {
        width:100%; 
        margin:10px 0 30px 0; 
    }
    .kanbooks_list_item_image{
        float:left;
        width:25%; 
        margin:0; 
    }
    .kanbooks_list_item_text{
        float:left;
        width:70%; 
        margin-left:10px;
    }
    .kanbooks_clearfix{
        clear: both; 
        margin: 30px 0 0 0; 
    }
    .kanbooks_hr {
        width: 100%; 
        color: #eee; 
        height: 0.01em;
        margin: 20px 0 0px 0
    }    
    .kanbooks_sortby {
        width: 45%; 
        float: left;
    }
</style>
<?php
get_footer();
