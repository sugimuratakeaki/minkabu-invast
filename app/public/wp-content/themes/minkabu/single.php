<?php
/**
 * The template for displaying all single posts
 */

get_header(); ?>

<?php if (!wp_is_mobile()) : ?>
<div class="l-container">
    <main class="l-main">
<?php endif; ?>
        <div class="main-content">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                        <header class="single-header">
                            <div class="single-meta">
                                <time class="single-date" datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                                <?php if (has_category()) : ?>
                                    <div class="single-categories">
                                        <?php the_category(', '); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h1 class="single-title"><?php the_title(); ?></h1>
                            <?php if (has_tag()) : ?>
                                <div class="single-tags">
                                    <?php the_tags('<span class="tag-label">タグ:</span> ', ', ', ''); ?>
                                </div>
                            <?php endif; ?>
                        </header>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="single-thumbnail">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="single-content">
                            <?php the_content(); ?>
                        </div>
                        
                        <footer class="single-footer">
                            <div class="single-author">
                                <div class="author-avatar">
                                    <?php echo get_avatar(get_the_author_meta('ID'), 60); ?>
                                </div>
                                <div class="author-info">
                                    <h3 class="author-name"><?php the_author(); ?></h3>
                                    <p class="author-description"><?php the_author_meta('description'); ?></p>
                                </div>
                            </div>
                            
                            <nav class="single-navigation">
                                <div class="nav-previous">
                                    <?php previous_post_link('%link', '&larr; %title'); ?>
                                </div>
                                <div class="nav-next">
                                    <?php next_post_link('%link', '%title &rarr;'); ?>
                                </div>
                            </nav>
                        </footer>
                    </article>
                    
                    <?php
                    // Related posts
                    $categories = get_the_category();
                    if ($categories) {
                        $category_ids = array();
                        foreach($categories as $category) {
                            $category_ids[] = $category->term_id;
                        }
                        
                        $args = array(
                            'category__in' => $category_ids,
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page' => 3,
                            'orderby' => 'rand'
                        );
                        
                        $related_query = new WP_Query($args);
                        
                        if ($related_query->have_posts()) : ?>
                            <div class="related-posts">
                                <h2 class="related-title">関連記事</h2>
                                <div class="related-grid">
                                    <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                                        <div class="related-item">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="related-thumbnail">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('thumbnail'); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <h3 class="related-item-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <time class="related-date"><?php echo get_the_date(); ?></time>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        <?php endif;
                        wp_reset_postdata();
                    }
                    ?>
                    
                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                <?php endwhile; ?>
        </div>
        
<?php if (!wp_is_mobile()) : ?>
    </main><!-- .l-main -->
    
    <?php get_sidebar(); ?>
    
</div><!-- .l-container -->
<?php else : ?>
    <?php get_sidebar(); ?>
<?php endif; ?>

<?php get_footer(); ?>