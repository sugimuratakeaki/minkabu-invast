<?php
/**
 * Card Grid Customizer Settings
 * 
 * Adds WordPress Customizer options for card grid configuration,
 * allowing operators to control card display without coding.
 * 
 * @package minkabu
 * @since 1.0.0
 */

// Security check
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Card Grid Customizer Settings
 */
function minkabu_card_grid_customizer($wp_customize) {
    
    // カードグリッドセクションを追加
    $wp_customize->add_section('minkabu_card_grid_settings', array(
        'title'       => 'カードグリッド設定',
        'description' => 'サイト全体のカードグリッド表示をカスタマイズします。',
        'priority'    => 35,
        'capability'  => 'edit_theme_options',
    ));
    
    // ==========================================
    // 基本設定 / Basic Settings
    // ==========================================
    
    // デフォルトの列数
    $wp_customize->add_setting('minkabu_card_default_columns', array(
        'default'           => '3',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_default_columns', array(
        'label'       => 'デフォルトの列数（PC）',
        'description' => 'デスクトップ表示時のデフォルト列数を設定します。',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'select',
        'choices'     => array(
            '2' => '2列',
            '3' => '3列（推奨）',
            '4' => '4列',
        ),
    ));
    
    // カード間隔
    $wp_customize->add_setting('minkabu_card_gap', array(
        'default'           => '24',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('minkabu_card_gap', array(
        'label'       => 'カード間のスペース（px）',
        'description' => 'カード間の余白を調整します。',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'select',
        'choices'     => array(
            '16' => '狭い（16px）',
            '20' => '標準（20px）',
            '24' => 'ゆったり（24px）',
            '32' => '広い（32px）',
        ),
    ));
    
    // ==========================================
    // 表示設定 / Display Settings
    // ==========================================
    
    // タイトル表示行数
    $wp_customize->add_setting('minkabu_card_title_lines', array(
        'default'           => '3',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_title_lines', array(
        'label'       => 'タイトル表示行数',
        'description' => 'カードタイトルの最大表示行数を設定します。',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'radio',
        'choices'     => array(
            '2' => '2行まで表示',
            '3' => '3行まで表示（推奨）',
            '4' => '4行まで表示',
        ),
    ));
    
    // 説明文の表示
    $wp_customize->add_setting('minkabu_card_show_excerpt', array(
        'default'           => true,
        'sanitize_callback' => 'minkabu_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_show_excerpt', array(
        'label'       => '説明文を表示',
        'description' => 'カードに抜粋文を表示します。',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'checkbox',
    ));
    
    // 説明文の文字数
    $wp_customize->add_setting('minkabu_card_excerpt_length', array(
        'default'           => '20',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_excerpt_length', array(
        'label'       => '説明文の文字数',
        'description' => '表示する説明文の最大文字数',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 5,
        ),
        'active_callback' => function() {
            return get_theme_mod('minkabu_card_show_excerpt', true);
        },
    ));
    
    // ==========================================
    // メタ情報設定 / Meta Information
    // ==========================================
    
    // 投稿者の表示
    $wp_customize->add_setting('minkabu_card_show_author', array(
        'default'           => true,
        'sanitize_callback' => 'minkabu_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_show_author', array(
        'label'   => '投稿者名を表示',
        'section' => 'minkabu_card_grid_settings',
        'type'    => 'checkbox',
    ));
    
    // 日付の表示
    $wp_customize->add_setting('minkabu_card_show_date', array(
        'default'           => true,
        'sanitize_callback' => 'minkabu_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_show_date', array(
        'label'   => '投稿日を表示',
        'section' => 'minkabu_card_grid_settings',
        'type'    => 'checkbox',
    ));
    
    // カテゴリーバッジの表示
    $wp_customize->add_setting('minkabu_card_show_category', array(
        'default'           => true,
        'sanitize_callback' => 'minkabu_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_show_category', array(
        'label'   => 'カテゴリーバッジを表示',
        'section' => 'minkabu_card_grid_settings',
        'type'    => 'checkbox',
    ));
    
    // ==========================================
    // 画像設定 / Image Settings
    // ==========================================
    
    // デフォルトのアスペクト比
    $wp_customize->add_setting('minkabu_card_aspect_ratio', array(
        'default'           => '3-2',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_aspect_ratio', array(
        'label'       => 'サムネイルのアスペクト比',
        'description' => 'カード画像の縦横比を設定します。',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'select',
        'choices'     => array(
            '1-1'  => '正方形（1:1）',
            '4-3'  => '標準（4:3）',
            '3-2'  => 'デフォルト（3:2）',
            '16-9' => 'ワイド（16:9）',
            '21-9' => '超ワイド（21:9）',
        ),
    ));
    
    // 画像のホバーエフェクト
    $wp_customize->add_setting('minkabu_card_image_hover', array(
        'default'           => 'zoom',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('minkabu_card_image_hover', array(
        'label'       => '画像ホバーエフェクト',
        'description' => 'マウスオーバー時の画像エフェクト',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'select',
        'choices'     => array(
            'none'     => 'なし',
            'zoom'     => 'ズーム（推奨）',
            'opacity'  => '透明度',
            'blur'     => 'ぼかし',
        ),
    ));
    
    // ==========================================
    // スタイル設定 / Style Settings
    // ==========================================
    
    // カードの影
    $wp_customize->add_setting('minkabu_card_shadow', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('minkabu_card_shadow', array(
        'label'       => 'カードの影',
        'description' => 'カードの影の強さを設定します。',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'select',
        'choices'     => array(
            'none'    => '影なし',
            'minimal' => '最小',
            'default' => '標準',
            'strong'  => '強い',
        ),
    ));
    
    // カードのボーダー
    $wp_customize->add_setting('minkabu_card_border', array(
        'default'           => false,
        'sanitize_callback' => 'minkabu_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('minkabu_card_border', array(
        'label'       => 'カードにボーダーを表示',
        'description' => 'カードの周りに境界線を表示します。',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'checkbox',
    ));
    
    // ==========================================
    // モバイル設定 / Mobile Settings
    // ==========================================
    
    // モバイル列数
    $wp_customize->add_setting('minkabu_card_mobile_columns', array(
        'default'           => '1',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_mobile_columns', array(
        'label'       => 'モバイルの列数',
        'description' => 'スマートフォンでの表示列数',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'select',
        'choices'     => array(
            '1' => '1列（推奨）',
            '2' => '2列',
        ),
    ));
    
    // モバイルでの説明文表示
    $wp_customize->add_setting('minkabu_card_mobile_show_excerpt', array(
        'default'           => false,
        'sanitize_callback' => 'minkabu_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_mobile_show_excerpt', array(
        'label'       => 'モバイルで説明文を表示',
        'description' => 'スマートフォンで説明文を表示するかどうか',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'checkbox',
    ));
    
    // ==========================================
    // パフォーマンス設定 / Performance Settings
    // ==========================================
    
    // 遅延読み込み
    $wp_customize->add_setting('minkabu_card_lazy_load', array(
        'default'           => true,
        'sanitize_callback' => 'minkabu_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_lazy_load', array(
        'label'       => '画像の遅延読み込みを有効化',
        'description' => 'ページ読み込み速度を改善します。',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'checkbox',
    ));
    
    // アニメーション
    $wp_customize->add_setting('minkabu_card_animation', array(
        'default'           => 'fade-in',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('minkabu_card_animation', array(
        'label'       => 'カード表示アニメーション',
        'description' => 'カードが表示される際のアニメーション',
        'section'     => 'minkabu_card_grid_settings',
        'type'        => 'select',
        'choices'     => array(
            'none'     => 'なし',
            'fade-in'  => 'フェードイン',
            'slide-up' => 'スライドアップ',
            'zoom-in'  => 'ズームイン',
        ),
    ));
}
add_action('customize_register', 'minkabu_card_grid_customizer');

/**
 * チェックボックスのサニタイズ関数
 */
function minkabu_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * カスタマイザー設定を適用するためのCSS出力
 */
function minkabu_card_grid_customizer_css() {
    $gap = get_theme_mod('minkabu_card_gap', '24');
    $title_lines = get_theme_mod('minkabu_card_title_lines', '3');
    $aspect = get_theme_mod('minkabu_card_aspect_ratio', '3-2');
    $shadow = get_theme_mod('minkabu_card_shadow', 'default');
    
    // アスペクト比の計算
    $aspect_map = array(
        '1-1'  => '100%',
        '4-3'  => '75%',
        '3-2'  => '66.67%',
        '16-9' => '56.25%',
        '21-9' => '42.86%',
    );
    
    $aspect_value = isset($aspect_map[$aspect]) ? $aspect_map[$aspect] : '66.67%';
    
    // 影の設定
    $shadow_map = array(
        'none'    => 'none',
        'minimal' => '0 1px 3px rgba(0,0,0,0.05)',
        'default' => '0 2px 8px rgba(0,0,0,0.08)',
        'strong'  => '0 4px 16px rgba(0,0,0,0.12)',
    );
    
    $shadow_value = isset($shadow_map[$shadow]) ? $shadow_map[$shadow] : '0 2px 8px rgba(0,0,0,0.08)';
    
    ?>
    <style type="text/css">
        /* カスタマイザー設定のCSS */
        .card-grid {
            gap: <?php echo intval($gap); ?>px;
        }
        
        .card__media {
            padding-top: <?php echo esc_attr($aspect_value); ?>;
        }
        
        .card__title {
            -webkit-line-clamp: <?php echo intval($title_lines); ?>;
            min-height: <?php echo intval($title_lines) * 22; ?>px;
        }
        
        .card {
            box-shadow: <?php echo esc_attr($shadow_value); ?>;
        }
        
        <?php if (get_theme_mod('minkabu_card_border', false)) : ?>
        .card {
            border: 1px solid #e9ecef;
        }
        <?php endif; ?>
        
        <?php if (!get_theme_mod('minkabu_card_show_excerpt', true)) : ?>
        .card__description {
            display: none;
        }
        <?php endif; ?>
        
        <?php if (!get_theme_mod('minkabu_card_show_author', true)) : ?>
        .card__author {
            display: none;
        }
        <?php endif; ?>
        
        <?php if (!get_theme_mod('minkabu_card_show_date', true)) : ?>
        .card__date {
            display: none;
        }
        <?php endif; ?>
        
        <?php if (!get_theme_mod('minkabu_card_show_category', true)) : ?>
        .card__badge {
            display: none;
        }
        <?php endif; ?>
        
        /* モバイル設定 */
        @media (max-width: 768px) {
            <?php if (get_theme_mod('minkabu_card_mobile_columns', '1') === '2') : ?>
            .card-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            <?php endif; ?>
            
            <?php if (!get_theme_mod('minkabu_card_mobile_show_excerpt', false)) : ?>
            .card__description {
                display: none;
            }
            <?php endif; ?>
        }
    </style>
    <?php
}
add_action('wp_head', 'minkabu_card_grid_customizer_css');

/**
 * カスタマイザーのライブプレビュー用JavaScript
 */
function minkabu_card_grid_customizer_js() {
    if (is_customize_preview()) {
        wp_enqueue_script(
            'minkabu-card-grid-customizer',
            get_template_directory_uri() . '/assets/js/card-grid-customizer.js',
            array('jquery', 'customize-preview'),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'minkabu_card_grid_customizer_js');