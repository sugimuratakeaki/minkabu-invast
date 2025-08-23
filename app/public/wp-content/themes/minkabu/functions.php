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