<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Minkabu
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<?php if (!wp_is_mobile()) : ?>
<aside class="l-side" role="complementary">
    
    <!-- Popular Posts Widget Area -->
    <?php if (is_active_sidebar('popular-posts')) : ?>
        <div class="box p5">
            <?php dynamic_sidebar('popular-posts'); ?>
        </div>
    <?php else : ?>
        <!-- WordPress Popular Posts Direct Display -->
        <section>
            <h2 class="h2-normal h2-icon">人気記事ランキング</h2>
            <div class="box p5">
                <?php if (function_exists('wpp_get_mostpopular')) : ?>
                    <?php
                    // WordPress Popular Postsの表示
                    $wpp_args = array(
                        'limit' => 10,
                        'range' => 'daily',
                        'order_by' => 'views',
                        'thumbnail_width' => 100,
                        'thumbnail_height' => 70,
                        'wpp_start' => '<ul class="wpp-list">',
                        'wpp_end' => '</ul>',
                        'post_html' => '<li>{thumb}<div class="wpp-text"><a href="{url}" class="wpp-post-title">{text_title}</a><span class="wpp-meta">{author} {date}</span></div></li>'
                    );
                    wpp_get_mostpopular($wpp_args);
                    ?>
                <?php else : ?>
                    <p class="p5">WordPress Popular Postsプラグインをアクティベートしてください。</p>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
</aside>
<?php endif; ?>