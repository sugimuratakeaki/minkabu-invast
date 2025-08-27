<?php
/**
 * Card Grid Shortcode System
 * 
 * Provides operator-friendly shortcodes for displaying posts in card grid layouts.
 * This system allows non-technical users to easily create card grids through
 * the WordPress editor without coding knowledge.
 * 
 * @package minkabu
 * @since 1.0.0
 */

// Security check
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main card grid shortcode
 * Usage: [minkabu_card_grid posts="6" columns="3" category="news"]
 * 
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function minkabu_card_grid_shortcode($atts) {
    // デフォルト属性
    $atts = shortcode_atts(array(
        'posts'      => 6,              // 表示する投稿数
        'columns'    => 3,              // 列数（2, 3, 4）
        'category'   => '',             // カテゴリースラッグ
        'featured'   => false,          // 特集記事のみ表示
        'style'      => 'default',      // カードスタイル（default, minimal, featured）
        'show_desc'  => true,           // 説明文の表示
        'show_meta'  => true,           // メタ情報の表示
        'order'      => 'date',         // 並び順（date, title, rand）
        'orderby'    => 'DESC',         // 並び順方向（ASC, DESC）
        'offset'     => 0,              // オフセット
        'exclude'    => '',             // 除外する投稿ID（カンマ区切り）
        'aspect'     => 'default',      // アスペクト比（default, square, wide, tall）
    ), $atts, 'minkabu_card_grid');

    // クエリ引数の構築
    $query_args = array(
        'post_type'      => 'post',
        'posts_per_page' => intval($atts['posts']),
        'post_status'    => 'publish',
        'orderby'        => $atts['order'],
        'order'          => $atts['orderby'],
        'offset'         => intval($atts['offset']),
    );

    // カテゴリーフィルタ
    if (!empty($atts['category'])) {
        $query_args['category_name'] = sanitize_text_field($atts['category']);
    }

    // 特集記事フィルタ
    if ($atts['featured'] === 'true') {
        $query_args['meta_key'] = '_is_featured';
        $query_args['meta_value'] = 'yes';
    }

    // 除外投稿
    if (!empty($atts['exclude'])) {
        $exclude_ids = explode(',', $atts['exclude']);
        $query_args['post__not_in'] = array_map('intval', $exclude_ids);
    }

    // クエリ実行
    $card_query = new WP_Query($query_args);
    
    // 出力バッファリング開始
    ob_start();
    
    if ($card_query->have_posts()) : ?>
        <?php
        // グリッドクラスの構築
        $grid_classes = array('card-grid');
        
        // 列数クラス
        switch(intval($atts['columns'])) {
            case 2:
                $grid_classes[] = 'card-grid--2-cols';
                break;
            case 4:
                $grid_classes[] = 'card-grid--4-cols';
                break;
            // 3列はデフォルトなのでクラス追加不要
        }
        ?>
        
        <div class="<?php echo esc_attr(implode(' ', $grid_classes)); ?>">
            <?php while ($card_query->have_posts()) : $card_query->the_post(); ?>
                <?php
                // カードクラスの構築
                $card_classes = array('card', 'card--clickable');
                
                // スタイルクラス
                if ($atts['style'] === 'minimal') {
                    $card_classes[] = 'card--minimal';
                } elseif ($atts['style'] === 'featured') {
                    $card_classes[] = 'card--featured';
                }
                
                // アスペクト比クラス
                $media_classes = array('card__media');
                switch($atts['aspect']) {
                    case 'square':
                        $media_classes[] = 'card__media--square';
                        break;
                    case 'wide':
                        $media_classes[] = 'card__media--wide';
                        break;
                    case 'tall':
                        $media_classes[] = 'card__media--tall';
                        break;
                }
                ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class($card_classes); ?>>
                    <!-- クリック可能なオーバーレイ -->
                    <a href="<?php the_permalink(); ?>" class="card__link" aria-label="<?php echo esc_attr(get_the_title()); ?>"></a>
                    
                    <!-- カードメディア -->
                    <div class="<?php echo esc_attr(implode(' ', $media_classes)); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium_large', array(
                                'class' => 'card__image',
                                'loading' => 'lazy',
                                'alt' => get_the_title()
                            )); ?>
                        <?php else : ?>
                            <div class="card__media--empty"></div>
                        <?php endif; ?>
                        
                        <?php 
                        $categories = get_the_category();
                        if (!empty($categories)) : ?>
                            <span class="card__badge"><?php echo esc_html($categories[0]->name); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- カードコンテンツ -->
                    <div class="card__content">
                        <!-- タイトル -->
                        <h3 class="card__title">
                            <a href="<?php the_permalink(); ?>" rel="bookmark">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <?php if ($atts['show_desc'] === 'true' || $atts['show_desc'] === true) : ?>
                            <?php if (has_excerpt()) : ?>
                                <p class="card__description">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php if ($atts['show_meta'] === 'true' || $atts['show_meta'] === true) : ?>
                            <!-- メタ情報 -->
                            <div class="card__meta">
                                <span class="card__author">
                                    <?php the_author(); ?>
                                </span>
                                <span class="card__date">
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo get_the_date(); ?>
                                    </time>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
                
            <?php endwhile; ?>
        </div>
        
    <?php else : ?>
        <div class="no-posts">
            <p>表示する記事がありません。</p>
        </div>
    <?php endif;
    
    wp_reset_postdata();
    
    // 出力を返す
    return ob_get_clean();
}
add_shortcode('minkabu_card_grid', 'minkabu_card_grid_shortcode');

/**
 * 関連記事カードグリッドショートコード
 * 現在の記事に関連する記事を表示
 * 
 * Usage: [minkabu_related_cards posts="3"]
 */
function minkabu_related_cards_shortcode($atts) {
    // 単一記事ページでない場合は何も表示しない
    if (!is_single()) {
        return '';
    }
    
    $atts = shortcode_atts(array(
        'posts'   => 3,
        'columns' => 3,
        'title'   => '関連記事',
    ), $atts, 'minkabu_related_cards');
    
    // 現在の記事のカテゴリーを取得
    $categories = wp_get_post_categories(get_the_ID());
    
    if (empty($categories)) {
        return '';
    }
    
    // 関連記事クエリ
    $query_args = array(
        'category__in'   => $categories,
        'post__not_in'   => array(get_the_ID()),
        'posts_per_page' => intval($atts['posts']),
        'orderby'        => 'rand',
    );
    
    $related_query = new WP_Query($query_args);
    
    ob_start();
    
    if ($related_query->have_posts()) : ?>
        <div class="related-posts-section">
            <?php if (!empty($atts['title'])) : ?>
                <h2 class="section-title"><?php echo esc_html($atts['title']); ?></h2>
            <?php endif; ?>
            
            <div class="card-grid card-grid--<?php echo intval($atts['columns']); ?>-cols">
                <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                    <?php get_template_part('template-parts/content', 'card'); ?>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif;
    
    wp_reset_postdata();
    
    return ob_get_clean();
}
add_shortcode('minkabu_related_cards', 'minkabu_related_cards_shortcode');

/**
 * カスタムカードグリッドショートコード
 * 手動で指定した投稿IDの記事を表示
 * 
 * Usage: [minkabu_custom_cards ids="1,2,3,4"]
 */
function minkabu_custom_cards_shortcode($atts) {
    $atts = shortcode_atts(array(
        'ids'     => '',
        'columns' => 3,
        'style'   => 'default',
    ), $atts, 'minkabu_custom_cards');
    
    if (empty($atts['ids'])) {
        return '<p>表示する記事IDを指定してください。</p>';
    }
    
    $post_ids = explode(',', $atts['ids']);
    $post_ids = array_map('intval', $post_ids);
    
    $query_args = array(
        'post__in'       => $post_ids,
        'posts_per_page' => count($post_ids),
        'orderby'        => 'post__in',
    );
    
    $custom_query = new WP_Query($query_args);
    
    ob_start();
    
    if ($custom_query->have_posts()) : ?>
        <div class="card-grid card-grid--<?php echo intval($atts['columns']); ?>-cols">
            <?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                <?php get_template_part('template-parts/content', 'card'); ?>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>指定された記事が見つかりません。</p>
    <?php endif;
    
    wp_reset_postdata();
    
    return ob_get_clean();
}