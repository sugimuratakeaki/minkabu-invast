<?php
/**
 * The main template file
 */

get_header(); ?>

<?php 
// 動画カルーセルセクション（全幅で表示）
echo do_shortcode('[minkabu_video_carousel]');
?>

<!-- メインコンテンツとサイドバーのコンテナ -->
<?php if (!wp_is_mobile()) : ?>
<div class="l-container">
    <main class="l-main">
<?php endif; ?>
    
    <div class="main-content">
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
                                    <?php if (has_category()) : ?>
                                        <div class="post-categories">
                                            <?php the_category(', '); ?>
                                        </div>
                                    <?php endif; ?>
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
                <p>お探しの記事は見つかりませんでした。他のキーワードで検索してみてください。</p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
        
        <?php 
        // FAQセクション（トップページ表示用）
        minkabu_frontpage_faq_section();
        ?>
    </div>
    
<?php if (!wp_is_mobile()) : ?>
    </main><!-- .l-main -->
    
    <?php get_sidebar(); ?>
    
</div><!-- .l-container -->
<?php else : ?>
    <?php get_sidebar(); ?>
<?php endif; ?>

<?php get_footer(); ?>