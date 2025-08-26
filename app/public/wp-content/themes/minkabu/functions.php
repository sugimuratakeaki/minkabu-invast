<?php
/**
 * minkabu theme functions and definitions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * テーマのセットアップ
 */
function minkabu_theme_setup() {
    // タイトルタグのサポート
    add_theme_support('title-tag');
    
    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');
    
    // HTML5マークアップのサポート
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // カスタムロゴのサポート
    add_theme_support('custom-logo', array(
        'height' => 60,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ));
    
    // メニューの登録
    register_nav_menus(array(
        'primary' => 'プライマリーメニュー',
        'footer' => 'フッターメニュー',
        'mobile' => 'モバイルメニュー',
    ));
}
add_action('after_setup_theme', 'minkabu_theme_setup');

/**
 * Register widget area
 */
function minkabu_widgets_init() {
    // メインサイドバー
    register_sidebar(array(
        'name'          => 'サイドバー',
        'id'            => 'sidebar-1',
        'description'   => 'サイドバーに表示するウィジェットを追加してください',
        'before_widget' => '<section class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="h2-normal h2-icon">',
        'after_title'   => '</h2>',
    ));
    
    // Popular Posts専用エリア
    register_sidebar(array(
        'name'          => '人気記事エリア',
        'id'            => 'popular-posts',
        'description'   => 'WordPress Popular Postsウィジェット専用',
        'before_widget' => '<section class="widget-popular %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="h2-normal h2-icon">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'minkabu_widgets_init');

/**
 * スタイルシートとスクリプトの読み込み
 */
function minkabu_enqueue_scripts() {
    // メインスタイルシート
    wp_enqueue_style(
        'minkabu-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );
    
    // オリジナルみんかぶCSS（全クラス含む）
    wp_enqueue_style(
        'minkabu-original',
        get_template_directory_uri() . '/assets/css/minkabu-original.css',
        array('minkabu-style'),
        '1.0.0'
    );
    
    // 追加CSS
    wp_enqueue_style(
        'minkabu-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array('minkabu-style', 'minkabu-original'),
        '1.0.0'
    );
    
    // メインJavaScript
    wp_enqueue_script(
        'minkabu-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // WordPressのローカライズ
    wp_localize_script('minkabu-main', 'minkabu_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('minkabu_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'minkabu_enqueue_scripts');

/**
 * bodyクラスの追加
 */
function minkabu_body_classes($classes) {
    // モバイル判定
    if (wp_is_mobile()) {
        $classes[] = 'is-mobile';
    } else {
        $classes[] = 'is-desktop';
    }
    
    return $classes;
}
add_filter('body_class', 'minkabu_body_classes');

/**
 * カスタムウォーカークラス（メニュー用）
 */
class Minkabu_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
        $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';
        
        $item_output = $args->before ?? '';
        $item_output .= '<a'. $attributes .'>';
        $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
        $item_output .= '</a>';
        $item_output .= $args->after ?? '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * ページネーション
 */
function minkabu_pagination() {
    global $wp_query;
    
    $big = 999999999;
    
    $pages = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'type' => 'array',
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
    ));
    
    if (is_array($pages)) {
        echo '<div class="pagination">';
        echo '<ul class="pagination-list">';
        foreach ($pages as $page) {
            echo '<li class="pagination-item">' . $page . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}

/**
 * 抜粋の文字数
 */
function minkabu_excerpt_length($length) {
    return 80;
}
add_filter('excerpt_length', 'minkabu_excerpt_length');

/**
 * 抜粋の末尾文字
 */
function minkabu_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'minkabu_excerpt_more');

/**
 * カスタム投稿タイプ「動画」の登録
 */
function minkabu_register_video_post_type() {
    $labels = array(
        'name'               => '動画',
        'singular_name'      => '動画',
        'menu_name'          => '動画管理',
        'add_new'            => '新規追加',
        'add_new_item'       => '新規動画を追加',
        'edit_item'          => '動画を編集',
        'new_item'           => '新規動画',
        'view_item'          => '動画を表示',
        'search_items'       => '動画を検索',
        'not_found'          => '動画が見つかりません',
        'not_found_in_trash' => 'ゴミ箱に動画が見つかりません',
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-video-alt3',
        'supports'            => array('title', 'thumbnail'),
        'has_archive'         => false,
        'rewrite'             => false,
        'show_in_rest'        => false,
    );
    
    register_post_type('minkabu_video', $args);
}
add_action('init', 'minkabu_register_video_post_type');

/**
 * 動画用メタボックスの追加
 */
function minkabu_add_video_meta_boxes() {
    add_meta_box(
        'minkabu_video_url',
        'YouTube動画設定',
        'minkabu_video_url_callback',
        'minkabu_video',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'minkabu_add_video_meta_boxes');

/**
 * メタボックスのコールバック
 */
function minkabu_video_url_callback($post) {
    wp_nonce_field('minkabu_video_url_nonce', 'minkabu_video_url_nonce');
    $youtube_url = get_post_meta($post->ID, '_minkabu_youtube_url', true);
    $video_description = get_post_meta($post->ID, '_minkabu_video_description', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="minkabu_youtube_url">YouTube URL</label></th>
            <td>
                <input type="text" id="minkabu_youtube_url" name="minkabu_youtube_url" value="<?php echo esc_attr($youtube_url); ?>" style="width: 100%;" />
                <p class="description">YouTubeの動画URLを入力してください（例: https://www.youtube.com/watch?v=xxxxx）</p>
            </td>
        </tr>
        <tr>
            <th><label for="minkabu_video_description">動画説明</label></th>
            <td>
                <textarea id="minkabu_video_description" name="minkabu_video_description" rows="3" style="width: 100%;"><?php echo esc_textarea($video_description); ?></textarea>
                <p class="description">動画の簡単な説明を入力してください（任意）</p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * メタボックスの保存処理
 */
function minkabu_save_video_meta($post_id) {
    // nonce確認
    if (!isset($_POST['minkabu_video_url_nonce']) || !wp_verify_nonce($_POST['minkabu_video_url_nonce'], 'minkabu_video_url_nonce')) {
        return;
    }
    
    // 自動保存の場合は処理しない
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // 権限確認
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // YouTube URLの保存
    if (isset($_POST['minkabu_youtube_url'])) {
        update_post_meta($post_id, '_minkabu_youtube_url', sanitize_text_field($_POST['minkabu_youtube_url']));
    }
    
    // 動画説明の保存
    if (isset($_POST['minkabu_video_description'])) {
        update_post_meta($post_id, '_minkabu_video_description', sanitize_textarea_field($_POST['minkabu_video_description']));
    }
}
add_action('save_post_minkabu_video', 'minkabu_save_video_meta');

/**
 * YouTube動画カルーセルのショートコード
 */
function minkabu_video_carousel_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ), $atts);
    
    $args = array(
        'post_type' => 'minkabu_video',
        'posts_per_page' => $atts['count'],
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'post_status' => 'publish',
    );
    
    $videos = get_posts($args);
    
    if (empty($videos)) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="minkabu-video-section">
        <div class="container">
            <h2 class="section-title">動画コンテンツ</h2>
            <div class="swiper video-carousel">
                <div class="swiper-wrapper">
                    <?php foreach ($videos as $video) : 
                        $youtube_url = get_post_meta($video->ID, '_minkabu_youtube_url', true);
                        $description = get_post_meta($video->ID, '_minkabu_video_description', true);
                        
                        // YouTube URLからIDを抽出
                        $video_id = '';
                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $youtube_url, $matches)) {
                            $video_id = $matches[1];
                        }
                        
                        if (!$video_id) continue;
                    ?>
                        <div class="swiper-slide">
                            <div class="video-item">
                                <div class="video-wrapper">
                                    <iframe 
                                        src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?rel=0" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <h3 class="video-title"><?php echo esc_html($video->post_title); ?></h3>
                                <?php if ($description) : ?>
                                    <p class="video-description"><?php echo esc_html($description); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('minkabu_video_carousel', 'minkabu_video_carousel_shortcode');

/**
 * Swiper.jsとカルーセル用のスタイル・スクリプトを追加
 */
function minkabu_enqueue_carousel_assets() {
    if (is_front_page() || is_home()) {
        // Swiper CSS
        wp_enqueue_style(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            array(),
            '11.0.0'
        );
        
        // Swiper JS
        wp_enqueue_script(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            '11.0.0',
            true
        );
        
        // カスタムカルーセルCSS
        wp_add_inline_style('minkabu-main', '
            .minkabu-video-section {
                padding: 60px 0;
                background-color: #f8f9fa;
            }
            .minkabu-video-section .section-title {
                text-align: center;
                font-size: 28px;
                margin-bottom: 40px;
                color: #333;
            }
            .video-carousel {
                position: relative;
                padding: 0 50px;
            }
            .video-item {
                background: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            .video-wrapper {
                position: relative;
                padding-bottom: 56.25%;
                height: 0;
                overflow: hidden;
            }
            .video-wrapper iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
            .video-title {
                padding: 15px 20px 10px;
                font-size: 18px;
                font-weight: bold;
                color: #333;
            }
            .video-description {
                padding: 0 20px 20px;
                font-size: 14px;
                color: #666;
                line-height: 1.6;
            }
            .swiper-button-prev,
            .swiper-button-next {
                color: #333;
            }
            .swiper-pagination-bullet-active {
                background-color: #333;
            }
            @media (max-width: 768px) {
                .minkabu-video-section {
                    padding: 40px 0;
                }
                .minkabu-video-section .section-title {
                    font-size: 24px;
                    margin-bottom: 30px;
                }
                .video-carousel {
                    padding: 0;
                }
                .swiper-button-prev,
                .swiper-button-next {
                    display: none;
                }
                .video-title {
                    font-size: 16px;
                }
            }
        ');
        
        // カルーセル初期化スクリプト
        wp_add_inline_script('swiper', '
            document.addEventListener("DOMContentLoaded", function() {
                new Swiper(".video-carousel", {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    loop: true,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev"
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 30
                        }
                    }
                });
            });
        ');
    }
}
add_action('wp_enqueue_scripts', 'minkabu_enqueue_carousel_assets');

/**
 * 初期動画データの登録（管理画面での通知とワンクリック登録）
 */
function minkabu_video_admin_notices() {
    $screen = get_current_screen();
    if ($screen->post_type !== 'minkabu_video') {
        return;
    }
    
    // 既に動画が登録されているかチェック
    $videos = get_posts(array(
        'post_type' => 'minkabu_video',
        'posts_per_page' => 1,
    ));
    
    if (empty($videos) && !isset($_GET['sample_imported'])) {
        ?>
        <div class="notice notice-info">
            <p>まだ動画が登録されていません。サンプル動画を登録しますか？</p>
            <p><a href="<?php echo admin_url('edit.php?post_type=minkabu_video&import_samples=1'); ?>" class="button button-primary">サンプル動画を登録</a></p>
        </div>
        <?php
    }
    
    if (isset($_GET['sample_imported'])) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>サンプル動画が正常に登録されました。</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'minkabu_video_admin_notices');

/**
 * サンプル動画のインポート処理
 */
function minkabu_import_sample_videos() {
    if (!isset($_GET['import_samples']) || $_GET['import_samples'] != '1') {
        return;
    }
    
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // サンプル動画データ
    $sample_videos = array(
        array(
            'title' => '動画タイトル1',
            'url' => 'https://www.youtube.com/watch?v=7TJrWllSl7Y',
            'description' => 'サンプル動画1の説明文です。',
        ),
        array(
            'title' => '動画タイトル2',
            'url' => 'https://www.youtube.com/watch?v=1SGD9ZF15PA',
            'description' => 'サンプル動画2の説明文です。',
        ),
        array(
            'title' => '動画タイトル3',
            'url' => 'https://www.youtube.com/watch?v=QpbiYKnPW7k',
            'description' => 'サンプル動画3の説明文です。',
        ),
    );
    
    foreach ($sample_videos as $index => $video) {
        $post_data = array(
            'post_title' => $video['title'],
            'post_status' => 'publish',
            'post_type' => 'minkabu_video',
            'menu_order' => $index,
        );
        
        $post_id = wp_insert_post($post_data);
        
        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, '_minkabu_youtube_url', $video['url']);
            update_post_meta($post_id, '_minkabu_video_description', $video['description']);
        }
    }
    
    // リダイレクト
    wp_redirect(admin_url('edit.php?post_type=minkabu_video&sample_imported=1'));
    exit;
}
add_action('admin_init', 'minkabu_import_sample_videos');

/**
 * 管理画面の動画一覧にYouTube URLカラムを追加
 */
function minkabu_video_columns($columns) {
    $columns['youtube_url'] = 'YouTube URL';
    $columns['menu_order'] = '並び順';
    return $columns;
}
add_filter('manage_minkabu_video_posts_columns', 'minkabu_video_columns');

/**
 * カスタムカラムの内容を表示
 */
function minkabu_video_column_content($column_name, $post_id) {
    if ($column_name == 'youtube_url') {
        $url = get_post_meta($post_id, '_minkabu_youtube_url', true);
        if ($url) {
            echo '<a href="' . esc_url($url) . '" target="_blank">' . esc_html($url) . '</a>';
        }
    }
    if ($column_name == 'menu_order') {
        $post = get_post($post_id);
        echo $post->menu_order;
    }
}
add_action('manage_minkabu_video_posts_custom_column', 'minkabu_video_column_content', 10, 2);

/**
 * 動画投稿タイプを並び順でソート可能にする
 */
function minkabu_video_sortable_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-minkabu_video_sortable_columns', 'minkabu_video_sortable_columns');

/**
 * 管理画面で並び順をサポート
 */
function minkabu_video_page_attributes() {
    add_post_type_support('minkabu_video', 'page-attributes');
}
add_action('init', 'minkabu_video_page_attributes', 11);