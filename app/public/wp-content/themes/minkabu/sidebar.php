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
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php else : ?>
        <!-- Default sections if no widgets are active -->
        <section>
            <h2 class="h2-normal h2-icon">アクセスランキング</h2>
            <div class="box p5">
                <h3 class="fs-l fbd mt5 ml5"><i class="i-attention"></i>注目</h3>
                <ul class="list-link">
                    <?php
                    // Sample popular posts
                    $args = array(
                        'posts_per_page' => 5,
                        'orderby' => 'comment_count',
                        'order' => 'DESC'
                    );
                    $popular_posts = new WP_Query($args);
                    
                    if ($popular_posts->have_posts()) :
                        while ($popular_posts->have_posts()) : $popular_posts->the_post();
                    ?>
                    <li class="list-link__item">
                        <a title="<?php the_title(); ?>" class="p5 flexbox flexbox_l-middle" href="<?php the_permalink(); ?>">
                            <div class="flexbox__grow">
                                <p class="fbd"><?php the_title(); ?></p>
                                <p class="fs-s">
                                    <?php $categories = get_the_category(); ?>
                                    <?php if (!empty($categories)) : ?>
                                        <span class="fc-newscategory"><?php echo esc_html($categories[0]->name); ?></span>&nbsp;
                                    <?php endif; ?>
                                    <span class="fc-sub"><?php echo get_the_date('m/d(D) H:i'); ?></span>
                                </p>
                            </div>
                            <i class="news-arrow flexbox__shrink"></i>
                        </a>
                    </li>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                    <li class="list-link__item">
                        <p class="p5">記事がありません。</p>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </section>

        <section>
            <h2 class="h2-normal h2-icon">新着記事</h2>
            <div class="box p5">
                <h3 class="fs-l fbd mt5 ml5"><i class="i-attention"></i>新着</h3>
                <ul class="list-link">
                    <?php
                    // Recent posts
                    $recent_args = array(
                        'posts_per_page' => 5,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    $recent_posts = new WP_Query($recent_args);
                    
                    if ($recent_posts->have_posts()) :
                        while ($recent_posts->have_posts()) : $recent_posts->the_post();
                    ?>
                    <li class="list-link__item">
                        <a title="<?php the_title(); ?>" class="p5 flexbox flexbox_l-middle" href="<?php the_permalink(); ?>">
                            <div class="flexbox__grow">
                                <p class="fbd"><?php the_title(); ?></p>
                                <p class="fs-s">
                                    <?php $categories = get_the_category(); ?>
                                    <?php if (!empty($categories)) : ?>
                                        <span class="fc-newscategory"><?php echo esc_html($categories[0]->name); ?></span>&nbsp;
                                    <?php endif; ?>
                                    <span class="fc-sub"><?php echo get_the_date('m/d(D) H:i'); ?></span>
                                </p>
                            </div>
                            <i class="news-arrow flexbox__shrink"></i>
                        </a>
                    </li>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                    <li class="list-link__item">
                        <p class="p5">記事がありません。</p>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>
</aside>
<?php endif; ?>