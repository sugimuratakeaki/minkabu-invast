<?php
/**
 * The main template file
 */

get_header(); ?>

<?php if (is_home() || is_front_page()) : ?>
    <?php 
    // 動画カルーセルセクション（全幅で表示）
    echo do_shortcode('[minkabu_video_carousel]');
    ?>
<?php endif; ?>

<!-- メインコンテンツとサイドバーのコンテナ -->
<?php if (!wp_is_mobile()) : ?>
<div class="l-container">
    <main class="l-main">
<?php endif; ?>
    
    <div class="main-content">
        <?php if (have_posts()) : ?>
            <?php if (is_home() || is_front_page()) : ?>
                <!-- Section Title -->
                <div class="section-header">
                    <h2 class="section-title">新着記事</h2>
                </div>
                
                <div class="card-grid">
                    <?php 
                    $post_count = 0;
                    while (have_posts() && $post_count < 3) : the_post(); 
                        $post_count++;
                    ?>
                        <?php get_template_part('template-parts/content', 'card'); ?>
                    <?php endwhile; ?>
                </div>
                
                <!-- View More Button -->
                <div class="section-footer">
                    <a href="<?php echo esc_url(home_url('/category/asset-formation/')); ?>" class="btn-outline">
                        新着記事
                    </a>
                </div>
            <?php else : ?>
                <!-- アーカイブページ用のレイアウト -->
                <div class="card-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content', 'card'); ?>
                    <?php endwhile; ?>
                </div>
                
                <?php minkabu_pagination(); ?>
            <?php endif; ?>
            
        <?php else : ?>
            <div class="no-posts">
                <h2>記事が見つかりませんでした</h2>
                <p>お探しの記事は見つかりませんでした。他のキーワードで検索してみてください。</p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
        
        <?php if (is_home() || is_front_page()) : ?>
            <?php 
            // トライオートFX紹介セクション
            get_template_part('template-parts/triautofx', 'intro');
            ?>
            
            <?php 
            // FAQセクション（トップページ表示用）
            minkabu_frontpage_faq_section();
            ?>
        <?php endif; ?>
    </div>
    
<?php if (!wp_is_mobile()) : ?>
    </main><!-- .l-main -->
    
    <?php get_sidebar(); ?>
    
</div><!-- .l-container -->
<?php else : ?>
    <?php get_sidebar(); ?>
<?php endif; ?>

<?php if (is_home() || is_front_page()) : ?>
    <?php 
    // 口座開設セクション（全幅で表示）
    echo do_shortcode('[minkabu_account_opening]');
    ?>
<?php endif; ?>

<?php get_footer(); ?>