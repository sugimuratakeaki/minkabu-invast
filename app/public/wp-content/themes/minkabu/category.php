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
            <div class="card-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'card'); ?>
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