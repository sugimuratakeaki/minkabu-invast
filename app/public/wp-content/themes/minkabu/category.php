<?php
/**
 * The template for displaying category archive pages
 */

get_header(); ?>

<?php if (!wp_is_mobile()) : ?>
<main class="l-main">
<?php endif; ?>
    <div class="main-content">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php single_cat_title(); ?>
            </h1>
            <?php if (category_description()) : ?>
                <div class="archive-description">
                    <?php echo category_description(); ?>
                </div>
            <?php endif; ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <header class="post-header">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="post-meta">
                                    <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                </div>
                            </header>
                            
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <footer class="post-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    続きを読む
                                    <span class="arrow">&rarr;</span>
                                </a>
                            </footer>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php minkabu_pagination(); ?>
            
        <?php else : ?>
            <div class="no-posts">
                <h2>記事が見つかりませんでした</h2>
                <p>このカテゴリーにはまだ記事がありません。</p>
            </div>
        <?php endif; ?>
    </div>
<?php if (!wp_is_mobile()) : ?>
</main><!-- .l-main -->
<?php endif; ?>

<?php get_sidebar(); ?>

<?php 
// カテゴリーページ下段にFAQを自動表示
minkabu_category_faq_section();
?>

<?php get_footer(); ?>