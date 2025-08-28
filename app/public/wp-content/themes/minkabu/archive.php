<?php
/**
 * The template for displaying archive pages
 */

get_header(); ?>

<?php if (!wp_is_mobile()) : ?>
<div class="l-container">
    <main class="l-main">
<?php endif; ?>
    
    <div class="main-content">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php
                if (is_category()) {
                    echo 'カテゴリー: ';
                    single_cat_title();
                } elseif (is_tag()) {
                    echo 'タグ: ';
                    single_tag_title();
                } elseif (is_author()) {
                    echo '投稿者: ';
                    the_author();
                } elseif (is_date()) {
                    if (is_day()) {
                        echo get_the_date();
                    } elseif (is_month()) {
                        echo get_the_date('Y年n月');
                    } elseif (is_year()) {
                        echo get_the_date('Y年');
                    }
                } else {
                    echo 'アーカイブ';
                }
                ?>
            </h1>
            <?php if (is_category() && category_description()) : ?>
                <div class="archive-description">
                    <?php echo category_description(); ?>
                </div>
            <?php elseif (is_tag() && tag_description()) : ?>
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
                <p>該当する記事がありません。</p>
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