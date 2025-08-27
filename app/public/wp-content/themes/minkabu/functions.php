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
    // メインスタイルシート（テーマ情報のみ）
    wp_enqueue_style(
        'minkabu-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );
    
    // ヘッダーCSS
    wp_enqueue_style(
        'minkabu-header',
        get_template_directory_uri() . '/assets/css/header.css',
        array(),
        '1.0.0'
    );
    
    // フッターCSS
    wp_enqueue_style(
        'minkabu-footer',
        get_template_directory_uri() . '/assets/css/footer.css',
        array(),
        '1.0.0'
    );
    
    // メインコンテンツCSS
    wp_enqueue_style(
        'minkabu-main-content',
        get_template_directory_uri() . '/assets/css/main-content.css',
        array(),
        '1.0.0'
    );
    
    // レイアウトCSS（メインとサイドバー）
    wp_enqueue_style(
        'minkabu-layout',
        get_template_directory_uri() . '/assets/css/layout.css',
        array(),
        '1.0.0'
    );
    
    // 全セクション統合CSS（カードグリッド、口座開設、FAQ）
    wp_enqueue_style(
        'minkabu-sections',
        get_template_directory_uri() . '/assets/css/sections.css',
        array(),
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
                            <div class="video-card">
                                <div class="video-thumbnail-wrapper">
                                    <img 
                                        src="https://img.youtube.com/vi/<?php echo esc_attr($video_id); ?>/maxresdefault.jpg" 
                                        alt="<?php echo esc_attr($video->post_title); ?>"
                                        class="video-thumbnail"
                                        onerror="this.src='https://img.youtube.com/vi/<?php echo esc_attr($video_id); ?>/hqdefault.jpg'"
                                    >
                                    <div class="play-button">
                                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="30" cy="30" r="30" fill="rgba(255,255,255,0.9)"/>
                                            <path d="M24 20L40 30L24 40V20Z" fill="#DC000C"/>
                                        </svg>
                                    </div>
                                    <a href="<?php echo esc_url($youtube_url); ?>" 
                                       class="video-link" 
                                       target="_blank"
                                       data-video-id="<?php echo esc_attr($video_id); ?>">
                                    </a>
                                </div>
                                <div class="video-content">
                                    <h3 class="video-title"><?php echo esc_html($video->post_title); ?></h3>
                                    <?php if ($description) : ?>
                                        <p class="video-description"><?php echo esc_html($description); ?></p>
                                    <?php endif; ?>
                                </div>
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
        
        // Video Carousel CSS
        wp_enqueue_style(
            'minkabu-video-carousel-style',
            get_template_directory_uri() . '/assets/css/video-carousel.css',
            array(),
            '1.0.0'
        );
        
        // Swiper JS
        wp_enqueue_script(
            'swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            '11.0.0',
            true
        );
        
        // カルーセル初期化スクリプト
        wp_enqueue_script(
            'minkabu-video-carousel',
            get_template_directory_uri() . '/assets/js/video-carousel.js',
            array('swiper'),
            '1.0.0',
            true
        );
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

/**
 * カードグリッド機能の読み込み
 */
require get_template_directory() . '/inc/card-grid-shortcodes.php';
require get_template_directory() . '/inc/customizer-card-grid.php';
require get_template_directory() . '/inc/card-grid-metabox.php';


/**
 * FAQカスタム投稿タイプの登録
 */
function minkabu_register_faq_post_type() {
    $labels = array(
        'name'               => 'よくある質問',
        'singular_name'      => 'FAQ',
        'menu_name'          => 'FAQ管理',
        'add_new'            => '新規追加',
        'add_new_item'       => '新規FAQを追加',
        'edit_item'          => 'FAQを編集',
        'new_item'           => '新規FAQ',
        'view_item'          => 'FAQを表示',
        'search_items'       => 'FAQを検索',
        'not_found'          => 'FAQが見つかりません',
        'not_found_in_trash' => 'ゴミ箱にFAQが見つかりません',
        'all_items'          => 'すべてのFAQ',
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-editor-help',
        'supports'            => array('title', 'editor', 'page-attributes'),
        'has_archive'         => false,
        'rewrite'             => false,
        'show_in_rest'        => true, // ブロックエディタを有効化
        'hierarchical'        => false,
        'capability_type'     => 'post',
    );
    
    register_post_type('minkabu_faq', $args);
}
add_action('init', 'minkabu_register_faq_post_type');

/**
 * FAQカテゴリータクソノミーの登録
 */
function minkabu_register_faq_taxonomy() {
    $labels = array(
        'name'              => 'FAQカテゴリー',
        'singular_name'     => 'FAQカテゴリー',
        'search_items'      => 'カテゴリーを検索',
        'all_items'         => 'すべてのカテゴリー',
        'parent_item'       => '親カテゴリー',
        'parent_item_colon' => '親カテゴリー:',
        'edit_item'         => 'カテゴリーを編集',
        'update_item'       => 'カテゴリーを更新',
        'add_new_item'      => '新規カテゴリーを追加',
        'new_item_name'     => '新規カテゴリー名',
        'menu_name'         => 'FAQカテゴリー',
    );
    
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'rewrite'           => false,
    );
    
    register_taxonomy('faq_category', 'minkabu_faq', $args);
}
add_action('init', 'minkabu_register_faq_taxonomy');

/**
 * FAQ用メタボックスの追加
 */
function minkabu_add_faq_meta_boxes() {
    add_meta_box(
        'minkabu_faq_settings',
        'FAQ表示設定',
        'minkabu_faq_settings_callback',
        'minkabu_faq',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'minkabu_add_faq_meta_boxes');

/**
 * FAQメタボックスのコールバック
 */
function minkabu_faq_settings_callback($post) {
    wp_nonce_field('minkabu_faq_settings_nonce', 'minkabu_faq_settings_nonce');
    $show_on_top = get_post_meta($post->ID, '_minkabu_faq_show_on_top', true);
    ?>
    <p>
        <label>
            <input type="checkbox" name="minkabu_faq_show_on_top" value="1" <?php checked($show_on_top, '1'); ?> />
            トップページに表示する
        </label>
    </p>
    <p class="description">チェックを入れると、このFAQがトップページのFAQセクションに表示されます。</p>
    <?php
}

/**
 * FAQメタボックスの保存処理
 */
function minkabu_save_faq_meta($post_id) {
    // nonce確認
    if (!isset($_POST['minkabu_faq_settings_nonce']) || !wp_verify_nonce($_POST['minkabu_faq_settings_nonce'], 'minkabu_faq_settings_nonce')) {
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
    
    // トップページ表示設定の保存
    $show_on_top = isset($_POST['minkabu_faq_show_on_top']) ? '1' : '0';
    update_post_meta($post_id, '_minkabu_faq_show_on_top', $show_on_top);
}
add_action('save_post_minkabu_faq', 'minkabu_save_faq_meta');

/**
 * FAQ管理画面のカラムカスタマイズ
 */
function minkabu_faq_columns($columns) {
    $new_columns = array();
    foreach($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key == 'title') {
            $new_columns['faq_answer'] = '回答（抜粋）';
        }
    }
    $new_columns['show_on_top'] = 'トップページ';
    $new_columns['menu_order'] = '並び順';
    return $new_columns;
}
add_filter('manage_minkabu_faq_posts_columns', 'minkabu_faq_columns');

/**
 * FAQカスタムカラムの内容表示
 */
function minkabu_faq_column_content($column_name, $post_id) {
    if ($column_name == 'faq_answer') {
        $content = get_post_field('post_content', $post_id);
        $excerpt = wp_trim_words(strip_tags($content), 20, '...');
        echo esc_html($excerpt);
    }
    if ($column_name == 'show_on_top') {
        $show_on_top = get_post_meta($post_id, '_minkabu_faq_show_on_top', true);
        echo $show_on_top == '1' ? '<span style="color:#46b450;">●</span> 表示' : '－';
    }
    if ($column_name == 'menu_order') {
        $post = get_post($post_id);
        echo $post->menu_order;
    }
}
add_action('manage_minkabu_faq_posts_custom_column', 'minkabu_faq_column_content', 10, 2);

/**
 * FAQ投稿タイプを並び順でソート可能にする
 */
function minkabu_faq_sortable_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-minkabu_faq_sortable_columns', 'minkabu_faq_sortable_columns');

/**
 * FAQ表示用のヘルパー関数
 */
function minkabu_get_faqs($args = array()) {
    $defaults = array(
        'post_type' => 'minkabu_faq',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'post_status' => 'publish',
    );
    
    $args = wp_parse_args($args, $defaults);
    return get_posts($args);
}

/**
 * FAQセクションのHTML出力
 */
function minkabu_render_faq_section($faqs, $title = 'よくある質問', $class = 'faq-section') {
    if (empty($faqs)) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($class); ?>">
        <h2 class="section-title"><?php echo esc_html($title); ?></h2>
        <div class="faq-list">
            <?php foreach ($faqs as $faq) : ?>
                <div class="faq-item" data-faq-id="<?php echo $faq->ID; ?>">
                    <div class="faq-question">
                        <span class="faq-question-text"><?php echo esc_html($faq->post_title); ?></span>
                        <span class="faq-toggle"></span>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <div class="faq-answer-text">
                                <?php echo apply_filters('the_content', $faq->post_content); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * FAQショートコード
 */
function minkabu_faq_shortcode($atts) {
    $atts = shortcode_atts(array(
        'category' => '',
        'count' => -1,
        'show_on_top' => false,
        'title' => 'よくある質問',
    ), $atts);
    
    $args = array(
        'posts_per_page' => $atts['count'],
    );
    
    // カテゴリー指定がある場合
    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'faq_category',
                'field' => 'slug',
                'terms' => $atts['category'],
            ),
        );
    }
    
    // トップページ表示のみを取得
    if ($atts['show_on_top']) {
        $args['meta_query'] = array(
            array(
                'key' => '_minkabu_faq_show_on_top',
                'value' => '1',
                'compare' => '=',
            ),
        );
    }
    
    $faqs = minkabu_get_faqs($args);
    return minkabu_render_faq_section($faqs, $atts['title']);
}
add_shortcode('minkabu_faq', 'minkabu_faq_shortcode');

/**
 * カテゴリーページ下段にFAQを自動表示
 */
function minkabu_category_faq_section() {
    if (!is_category()) {
        return;
    }
    
    $category = get_queried_object();
    $category_slug = $category->slug;
    
    // カテゴリーに対応するFAQカテゴリーがあるか確認
    $faq_category = get_term_by('slug', $category_slug, 'faq_category');
    
    if (!$faq_category) {
        return;
    }
    
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'faq_category',
                'field' => 'term_id',
                'terms' => $faq_category->term_id,
            ),
        ),
    );
    
    $faqs = minkabu_get_faqs($args);
    
    if (!empty($faqs)) {
        $title = $category->name . 'に関するよくある質問';
        echo minkabu_render_faq_section($faqs, $title, 'faq-section faq-category-section');
    }
}
// カテゴリーテンプレートで使用するため、アクションフックは追加しない（テンプレート側で直接呼び出し）

/**
 * トップページ用FAQセクション
 */
function minkabu_frontpage_faq_section() {
    $args = array(
        'meta_query' => array(
            array(
                'key' => '_minkabu_faq_show_on_top',
                'value' => '1',
                'compare' => '=',
            ),
        ),
    );
    
    $faqs = minkabu_get_faqs($args);
    
    if (!empty($faqs)) {
        echo minkabu_render_faq_section($faqs, 'よくある質問', 'faq-section faq-frontpage-section');
    }
}
// トップページテンプレートで使用するため、アクションフックは追加しない（テンプレート側で直接呼び出し）

/**
 * FAQ用のスタイルとスクリプトを追加
 */
function minkabu_enqueue_faq_assets() {
    // FAQスタイル - minkabu-original.cssに移動済み
    // 以下のスタイルは minkabu-original.css に移動しました
    /*
    wp_add_inline_style('minkabu-main', '
        .faq-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        
        .faq-section-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 40px;
            color: #333;
            font-weight: bold;
            position: relative;
            padding-bottom: 20px;
        }
        
        .faq-section-title:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: #007cba;
        }
        
        .faq-list {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .faq-item {
            background: white;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }
        
        .faq-item:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        
        .faq-question {
            padding: 20px 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            position: relative;
            transition: background-color 0.3s ease;
        }
        
        .faq-question:hover {
            background-color: #f0f7ff;
        }
        
        .faq-item.active .faq-question {
            background-color: #f0f7ff;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .faq-q {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #007cba;
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 50%;
            margin-right: 20px;
            flex-shrink: 0;
        }
        
        .faq-title {
            flex: 1;
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            line-height: 1.5;
            padding-right: 40px;
        }
        
        .faq-toggle {
            position: absolute;
            right: 25px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .faq-toggle-icon {
            position: relative;
            width: 20px;
            height: 20px;
        }
        
        .faq-toggle-icon:before,
        .faq-toggle-icon:after {
            content: "";
            position: absolute;
            background-color: #666;
            transition: transform 0.3s ease;
        }
        
        .faq-toggle-icon:before {
            top: 50%;
            left: 0;
            width: 20px;
            height: 2px;
            transform: translateY(-50%);
        }
        
        .faq-toggle-icon:after {
            top: 0;
            left: 50%;
            width: 2px;
            height: 20px;
            transform: translateX(-50%);
        }
        
        .faq-item.active .faq-toggle-icon:after {
            transform: translateX(-50%) rotate(90deg);
            opacity: 0;
        }
        
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            background-color: white;
        }
        
        .faq-item.active .faq-answer {
            max-height: 1000px;
        }
        
        .faq-answer > * {
            padding: 25px;
            display: flex;
            align-items: flex-start;
        }
        
        .faq-a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #46b450;
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 50%;
            margin-right: 20px;
            flex-shrink: 0;
        }
        
        .faq-content {
            flex: 1;
            font-size: 16px;
            line-height: 1.8;
            color: #555;
        }
        
        .faq-content p {
            margin: 0 0 15px 0;
        }
        
        .faq-content p:last-child {
            margin-bottom: 0;
        }
        
        .faq-category-section {
            background-color: white;
            padding: 40px 0;
            margin-top: 40px;
            border-top: 2px solid #e5e5e5;
        }
        
        .faq-frontpage-section {
            background: linear-gradient(to bottom, #f8f9fa, white);
        }
        
        @media (max-width: 768px) {
            .faq-section {
                padding: 40px 0;
            }
            
            .faq-section-title {
                font-size: 24px;
                margin-bottom: 30px;
            }
            
            .faq-list {
                padding: 0 15px;
            }
            
            .faq-question {
                padding: 15px 20px;
            }
            
            .faq-q,
            .faq-a {
                width: 32px;
                height: 32px;
                font-size: 16px;
                margin-right: 15px;
            }
            
            .faq-title {
                font-size: 16px;
                padding-right: 30px;
            }
            
            .faq-toggle {
                right: 20px;
                width: 24px;
                height: 24px;
            }
            
            .faq-toggle-icon {
                width: 16px;
                height: 16px;
            }
            
            .faq-toggle-icon:before {
                width: 16px;
            }
            
            .faq-toggle-icon:after {
                height: 16px;
            }
            
            .faq-answer > * {
                padding: 20px;
            }
            
            .faq-content {
                font-size: 14px;
            }
        }
    ');
    */
    
    // FAQ JavaScript
    wp_enqueue_script(
        'minkabu-faq',
        get_template_directory_uri() . '/assets/js/faq.js',
        array(),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'minkabu_enqueue_faq_assets');

/**
 * 口座開設セクションのショートコード
 */
function minkabu_account_opening_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => '口座開設も <span class="highlight">スマホで簡単4ステップ！</span>',
        'cta_text' => '口座開設はこちら',
        'cta_url' => '/account-opening',
        'show_details' => 'true',
    ), $atts);
    
    ob_start();
    
    // カスタマイズ可能なパラメータを変数として設定
    $GLOBALS['minkabu_account_opening_params'] = $atts;
    
    // テンプレートパートを読み込み
    get_template_part('template-parts/account-opening');
    
    // グローバル変数をクリーンアップ
    unset($GLOBALS['minkabu_account_opening_params']);
    
    return ob_get_clean();
}
add_shortcode('minkabu_account_opening', 'minkabu_account_opening_shortcode');

/**
 * 口座開設セクションを表示するヘルパー関数
 * テンプレート内で直接呼び出し可能
 */
function minkabu_display_account_opening($args = array()) {
    $defaults = array(
        'title' => '口座開設も <span class="highlight">スマホで簡単4ステップ！</span>',
        'cta_text' => '口座開設はこちら',
        'cta_url' => '/account-opening',
        'show_details' => true,
    );
    
    $args = wp_parse_args($args, $defaults);
    
    // パラメータをグローバル変数にセット
    $GLOBALS['minkabu_account_opening_params'] = $args;
    
    // テンプレートパートを読み込み
    get_template_part('template-parts/account-opening');
    
    // グローバル変数をクリーンアップ
    unset($GLOBALS['minkabu_account_opening_params']);
}

/**
 * FAQ管理画面での通知とサンプルデータ登録
 */
function minkabu_faq_admin_notices() {
    $screen = get_current_screen();
    if ($screen->post_type !== 'minkabu_faq') {
        return;
    }
    
    // 既にFAQが登録されているかチェック
    $faqs = get_posts(array(
        'post_type' => 'minkabu_faq',
        'posts_per_page' => 1,
    ));
    
    if (empty($faqs) && !isset($_GET['faq_sample_imported'])) {
        ?>
        <div class="notice notice-info">
            <p>まだFAQが登録されていません。サンプルFAQを登録しますか？</p>
            <p><a href="<?php echo admin_url('edit.php?post_type=minkabu_faq&import_faq_samples=1'); ?>" class="button button-primary">サンプルFAQを登録</a></p>
        </div>
        <?php
    }
    
    if (isset($_GET['faq_sample_imported'])) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>サンプルFAQが正常に登録されました。</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'minkabu_faq_admin_notices');

/**
 * 管理画面にテーマ設定メニューを追加
 */
function minkabu_add_admin_menu() {
    add_menu_page(
        'Minkabuテーマ設定',
        'Minkabuテーマ',
        'manage_options',
        'minkabu-theme-settings',
        'minkabu_theme_settings_page',
        'dashicons-layout',
        61
    );
    
    add_submenu_page(
        'minkabu-theme-settings',
        'ショートコード一覧',
        'ショートコード',
        'manage_options',
        'minkabu-shortcodes',
        'minkabu_shortcodes_page'
    );
}
add_action('admin_menu', 'minkabu_add_admin_menu');

/**
 * テーマ設定ページ
 */
function minkabu_theme_settings_page() {
    ?>
    <div class="wrap">
        <h1>Minkabuテーマ設定</h1>
        <div class="card">
            <h2>テーマの機能</h2>
            <p>このテーマには以下の機能が含まれています：</p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><strong>動画カルーセル</strong>: YouTube動画を管理・表示</li>
                <li><strong>FAQ管理</strong>: よくある質問を管理</li>
                <li><strong>口座開設セクション</strong>: 口座開設の流れを表示</li>
                <li><strong>カードグリッド</strong>: 記事をカード形式で表示</li>
            </ul>
        </div>
    </div>
    <?php
}

/**
 * ショートコード一覧ページ
 */
function minkabu_shortcodes_page() {
    ?>
    <div class="wrap">
        <h1>利用可能なショートコード</h1>
        
        <div class="card">
            <h2>口座開設セクション</h2>
            <p>口座開設の流れを4ステップで表示します。</p>
            <h3>基本的な使用方法:</h3>
            <code style="display: block; padding: 10px; background: #f0f0f0; margin: 10px 0;">[minkabu_account_opening]</code>
            
            <h3>カスタマイズ例:</h3>
            <code style="display: block; padding: 10px; background: #f0f0f0; margin: 10px 0;">[minkabu_account_opening title="最短5分で口座開設！" cta_text="今すぐ開設" cta_url="/register" show_details="false"]</code>
            
            <h3>パラメータ:</h3>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><strong>title</strong>: セクションのタイトル（HTMLタグ使用可）</li>
                <li><strong>cta_text</strong>: ボタンのテキスト</li>
                <li><strong>cta_url</strong>: ボタンのリンク先URL</li>
                <li><strong>show_details</strong>: 詳細手順の表示/非表示（true/false）</li>
            </ul>
        </div>
        
        <div class="card">
            <h2>動画カルーセル</h2>
            <code style="display: block; padding: 10px; background: #f0f0f0; margin: 10px 0;">[minkabu_video_carousel]</code>
            <p>登録された動画をカルーセル形式で表示します。</p>
        </div>
        
        <div class="card">
            <h2>FAQ表示</h2>
            <code style="display: block; padding: 10px; background: #f0f0f0; margin: 10px 0;">[minkabu_faq]</code>
            <h3>パラメータ:</h3>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><strong>category</strong>: 表示するFAQカテゴリー（スラッグ）</li>
                <li><strong>count</strong>: 表示件数（-1で全件）</li>
                <li><strong>show_on_top</strong>: トップページ表示のみ（true/false）</li>
                <li><strong>title</strong>: セクションタイトル</li>
            </ul>
        </div>
    </div>
    <?php
}

/**
 * サンプルFAQのインポート処理
 */
function minkabu_import_sample_faqs() {
    if (!isset($_GET['import_faq_samples']) || $_GET['import_faq_samples'] != '1') {
        return;
    }
    
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // FAQカテゴリーの作成
    $general_cat = wp_insert_term('一般', 'faq_category', array(
        'description' => 'トライオートFXに関する一般的な質問',
        'slug' => 'general',
    ));
    
    $trading_cat = wp_insert_term('取引', 'faq_category', array(
        'description' => '取引に関する質問',
        'slug' => 'trading',
    ));
    
    // サンプルFAQデータ
    $sample_faqs = array(
        array(
            'title' => 'トライオートFXとは、どのようなサービスですか？',
            'content' => 'トライオートFXは、インヴァスト証券が提供するFX（外国為替証拠金取引）の自動売買サービスです。あらかじめ設定されたルールに基づいて、システムが24時間自動で取引を行います。投資家は自分の投資スタイルに合った自動売買プログラムを選択するだけで、専門知識がなくても効率的な取引が可能です。',
            'category' => isset($general_cat['term_id']) ? $general_cat['term_id'] : null,
            'show_on_top' => '1',
            'menu_order' => 1,
        ),
        array(
            'title' => '自動売買と裁量取引の違いは何ですか？',
            'content' => '自動売買は、プログラムが事前に設定されたルールに従って自動的に取引を行います。感情に左右されることなく、24時間市場を監視して取引機会を逃しません。一方、裁量取引は投資家自身が市場を分析し、売買のタイミングを判断して取引を行います。トライオートFXでは、両方の取引スタイルを組み合わせることも可能です。',
            'category' => isset($general_cat['term_id']) ? $general_cat['term_id'] : null,
            'show_on_top' => '1',
            'menu_order' => 2,
        ),
        array(
            'title' => '初心者でもトライオートFXを始められますか？',
            'content' => 'はい、始められます。トライオートFXは、専門知識がなくても始められるように設計されています。あらかじめ用意された自動売買プログラムから選ぶだけで取引を開始できます。また、デモ取引機能で練習することも可能です。さらに、充実したサポート体制と学習コンテンツにより、初心者の方でも安心して取引を始められます。',
            'category' => isset($general_cat['term_id']) ? $general_cat['term_id'] : null,
            'show_on_top' => '1',
            'menu_order' => 3,
        ),
        array(
            'title' => '最低いくらから取引できますか？',
            'content' => 'トライオートFXでは、1,000通貨単位から取引が可能です。米ドル/円の場合、レバレッジ25倍を活用すれば、約5,000円から取引を開始できます。ただし、余裕を持った資金管理のため、10万円程度の証拠金があると、より安定した取引が可能になります。また、通貨ペアやレートの変動により必要証拠金は変動しますので、取引前に必ず最新の情報をご確認ください。',
            'category' => isset($trading_cat['term_id']) ? $trading_cat['term_id'] : null,
            'show_on_top' => '1',
            'menu_order' => 4,
        ),
        array(
            'title' => '取引手数料はかかりますか？',
            'content' => 'トライオートFXの取引手数料は無料です。ただし、売値と買値の差であるスプレッドが実質的なコストとなります。スプレッドは通貨ペアや市場状況により変動します。詳細な最新のスプレッド情報は、公式サイトでご確認ください。',
            'category' => isset($trading_cat['term_id']) ? $trading_cat['term_id'] : null,
            'show_on_top' => '0',
            'menu_order' => 5,
        ),
        array(
            'title' => 'どんな通貨ペアで取引できますか？',
            'content' => 'トライオートFXでは、主要通貨ペアから高金利通貨まで、17通貨ペアの取引が可能です。米ドル/円、ユーロ/円、ポンド/円などの主要通貨ペアはもちろん、豪ドル/円、NZドル/円、南アフリカランド/円などの高金利通貨ペアも取り扱っています。',
            'category' => isset($trading_cat['term_id']) ? $trading_cat['term_id'] : null,
            'show_on_top' => '0',
            'menu_order' => 6,
        ),
    );
    
    foreach ($sample_faqs as $faq) {
        $post_data = array(
            'post_title' => $faq['title'],
            'post_content' => $faq['content'],
            'post_status' => 'publish',
            'post_type' => 'minkabu_faq',
            'menu_order' => $faq['menu_order'],
        );
        
        $post_id = wp_insert_post($post_data);
        
        if (!is_wp_error($post_id)) {
            // カテゴリーの設定
            if ($faq['category']) {
                wp_set_post_terms($post_id, array($faq['category']), 'faq_category');
            }
            
            // トップページ表示設定
            update_post_meta($post_id, '_minkabu_faq_show_on_top', $faq['show_on_top']);
        }
    }
    
    // リダイレクト
    wp_redirect(admin_url('edit.php?post_type=minkabu_faq&faq_sample_imported=1'));
    exit;
}
add_action('admin_init', 'minkabu_import_sample_faqs');