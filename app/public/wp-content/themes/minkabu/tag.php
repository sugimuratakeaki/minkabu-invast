<?php
/**
 * The template for displaying tag archive pages
 */

get_header(); ?>

<?php if (!wp_is_mobile()) : ?>
<div class="l-container">
    <main class="l-main">
<?php endif; ?>
    
    <div class="main-content">
        <header class="archive-header">
            <h1 class="archive-title">
                タグ: <?php single_tag_title(); ?>
            </h1>
            <?php if (tag_description()) : ?>
                <div class="archive-description">
                    <?php echo tag_description(); ?>
                </div>
            <?php endif; ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="card-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'card'); ?>
                <?php endwhile; ?>
            </div>
            
            <?php minkabu_pagination(); ?>
            
        <?php else : ?>
            <div class="no-posts">
                <h2>記事が見つかりませんでした</h2>
                <p>このタグの記事はまだありません。</p>
            </div>
        <?php endif; ?>
    </div>
    
<?php if (!wp_is_mobile()) : ?>
    </main><!-- .l-main -->
    
    <?php get_sidebar(); ?>
    
</div><!-- .l-container -->
<?php else : ?>
    <?php get_sidebar(); ?>
<?php endif; ?>

<?php get_footer(); ?>