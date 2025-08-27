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
        <div class="box">
            <h2 class="h2-normal h2-icon">人気記事ランキング</h2>
            <div style="">
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
                        'post_html' => '<li>{thumb}<div class="wpp-text"><a href="{url}" class="wpp-post-title">{text_title}</a><span class="wpp-meta"><span class="wpp-date">{date}</span></span></div></li>'
                    );
                    wpp_get_mostpopular($wpp_args);
                    ?>
                <?php else : ?>
                    <p class="p5">WordPress Popular Postsプラグインをアクティベートしてください。</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Recent Posts Section -->
    <div class="box">
        <h2 class="h2-normal h2-icon">新着記事</h2>
        <div style="">
            <?php
            // 新着記事の取得
            $recent_posts = new WP_Query(array(
                'posts_per_page' => 10,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($recent_posts->have_posts()) : ?>
                <ul class="recent-list">
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <li>
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail', array('width' => 100, 'height' => 70)); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='70' viewBox='0 0 100 70'%3E%3Crect width='100' height='70' fill='%23e5e7eb'/%3E%3Ctext x='50' y='35' text-anchor='middle' dominant-baseline='middle' font-family='sans-serif' font-size='11' fill='%23999'%3ENo%3C/text%3E%3Ctext x='50' y='45' text-anchor='middle' dominant-baseline='middle' font-family='sans-serif' font-size='11' fill='%23999'%3EThumbnail%3C/text%3E%3C/svg%3E" alt="No Thumbnail" width="100" height="70">
                                </a>
                            <?php endif; ?>
                            <div class="recent-text">
                                <a href="<?php the_permalink(); ?>" class="recent-post-title">
                                    <?php the_title(); ?>
                                </a>
                                <span class="recent-meta">
                                    <span class="recent-date"><?php echo get_the_date('Y.m.d'); ?></span>
                                </span>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else : ?>
                <p class="p5">記事がありません。</p>
            <?php endif; 
            wp_reset_postdata(); ?>
        </div>
    </div>
</aside>
<?php endif; ?>