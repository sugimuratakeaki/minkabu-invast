<?php
/**
 * Card Grid Meta Box
 * 
 * Adds meta boxes to post editor for card-specific settings,
 * allowing operators to control individual card appearance.
 * 
 * @package minkabu
 * @since 1.0.0
 */

// Security check
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta boxes to post editor
 */
function minkabu_card_add_meta_boxes() {
    add_meta_box(
        'minkabu_card_settings',
        'カード表示設定',
        'minkabu_card_meta_box_callback',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'minkabu_card_add_meta_boxes');

/**
 * Meta box callback function
 */
function minkabu_card_meta_box_callback($post) {
    // Add nonce for security
    wp_nonce_field('minkabu_card_meta_box', 'minkabu_card_meta_box_nonce');
    
    // Get existing values
    $is_featured = get_post_meta($post->ID, '_is_featured', true);
    $card_style = get_post_meta($post->ID, '_card_style', true);
    $hide_from_grid = get_post_meta($post->ID, '_hide_from_grid', true);
    $custom_badge = get_post_meta($post->ID, '_custom_badge', true);
    ?>
    
    <div class="minkabu-meta-box">
        <style>
            .minkabu-meta-box p {
                margin: 10px 0;
            }
            .minkabu-meta-box label {
                display: block;
                margin-bottom: 5px;
                font-weight: 600;
            }
            .minkabu-meta-box input[type="text"],
            .minkabu-meta-box select {
                width: 100%;
            }
            .minkabu-meta-box .description {
                font-size: 12px;
                color: #666;
                margin-top: 3px;
            }
            .minkabu-meta-box hr {
                margin: 15px 0;
                border: 0;
                border-top: 1px solid #ddd;
            }
        </style>
        
        <p>
            <label>
                <input type="checkbox" name="is_featured" value="yes" <?php checked($is_featured, 'yes'); ?>>
                <strong>特集記事として表示</strong>
            </label>
            <span class="description">チェックすると特集記事として強調表示されます</span>
        </p>
        
        <hr>
        
        <p>
            <label for="card_style">カードスタイル</label>
            <select name="card_style" id="card_style">
                <option value="">デフォルト</option>
                <option value="minimal" <?php selected($card_style, 'minimal'); ?>>ミニマル（影なし）</option>
                <option value="featured" <?php selected($card_style, 'featured'); ?>>強調（大きい影）</option>
                <option value="horizontal" <?php selected($card_style, 'horizontal'); ?>>横型レイアウト</option>
            </select>
            <span class="description">この記事のカード表示スタイルを選択</span>
        </p>
        
        <hr>
        
        <p>
            <label for="custom_badge">カスタムバッジ</label>
            <input type="text" name="custom_badge" id="custom_badge" value="<?php echo esc_attr($custom_badge); ?>" placeholder="例: NEW, HOT, 限定">
            <span class="description">カテゴリーの代わりに表示するバッジテキスト</span>
        </p>
        
        <hr>
        
        <p>
            <label>
                <input type="checkbox" name="hide_from_grid" value="yes" <?php checked($hide_from_grid, 'yes'); ?>>
                グリッド一覧から非表示
            </label>
            <span class="description">トップページやカテゴリーページの一覧から除外します</span>
        </p>
    </div>
    <?php
}

/**
 * Save meta box data
 */
function minkabu_card_save_meta_box_data($post_id) {
    // Check if nonce is set
    if (!isset($_POST['minkabu_card_meta_box_nonce'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['minkabu_card_meta_box_nonce'], 'minkabu_card_meta_box')) {
        return;
    }
    
    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save featured status
    if (isset($_POST['is_featured']) && $_POST['is_featured'] === 'yes') {
        update_post_meta($post_id, '_is_featured', 'yes');
    } else {
        delete_post_meta($post_id, '_is_featured');
    }
    
    // Save card style
    if (isset($_POST['card_style'])) {
        update_post_meta($post_id, '_card_style', sanitize_text_field($_POST['card_style']));
    }
    
    // Save custom badge
    if (isset($_POST['custom_badge'])) {
        update_post_meta($post_id, '_custom_badge', sanitize_text_field($_POST['custom_badge']));
    }
    
    // Save hide from grid
    if (isset($_POST['hide_from_grid']) && $_POST['hide_from_grid'] === 'yes') {
        update_post_meta($post_id, '_hide_from_grid', 'yes');
    } else {
        delete_post_meta($post_id, '_hide_from_grid');
    }
}
add_action('save_post', 'minkabu_card_save_meta_box_data');

/**
 * Add featured column to admin posts list
 */
function minkabu_card_add_admin_columns($columns) {
    $new_columns = array();
    
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        
        // Add after title column
        if ($key === 'title') {
            $new_columns['featured'] = '特集';
            $new_columns['card_style'] = 'カードスタイル';
        }
    }
    
    return $new_columns;
}
add_filter('manage_posts_columns', 'minkabu_card_add_admin_columns');

/**
 * Display data in admin columns
 */
function minkabu_card_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'featured':
            $is_featured = get_post_meta($post_id, '_is_featured', true);
            if ($is_featured === 'yes') {
                echo '<span style="color: #ff6b35; font-weight: bold;">★ 特集</span>';
            } else {
                echo '—';
            }
            break;
            
        case 'card_style':
            $card_style = get_post_meta($post_id, '_card_style', true);
            if ($card_style) {
                $styles = array(
                    'minimal' => 'ミニマル',
                    'featured' => '強調',
                    'horizontal' => '横型',
                );
                echo isset($styles[$card_style]) ? $styles[$card_style] : $card_style;
            } else {
                echo 'デフォルト';
            }
            break;
    }
}
add_action('manage_posts_custom_column', 'minkabu_card_admin_column_content', 10, 2);

/**
 * Make columns sortable
 */
function minkabu_card_sortable_columns($columns) {
    $columns['featured'] = 'featured';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'minkabu_card_sortable_columns');

/**
 * Handle column sorting
 */
function minkabu_card_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    if ($query->get('orderby') === 'featured') {
        $query->set('meta_key', '_is_featured');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'minkabu_card_orderby');

/**
 * Add bulk actions for featured posts
 */
function minkabu_card_bulk_actions($bulk_actions) {
    $bulk_actions['set_featured'] = '特集記事に設定';
    $bulk_actions['unset_featured'] = '特集記事から解除';
    return $bulk_actions;
}
add_filter('bulk_actions-edit-post', 'minkabu_card_bulk_actions');

/**
 * Handle bulk actions
 */
function minkabu_card_handle_bulk_actions($redirect_to, $doaction, $post_ids) {
    if ($doaction === 'set_featured') {
        foreach ($post_ids as $post_id) {
            update_post_meta($post_id, '_is_featured', 'yes');
        }
        $redirect_to = add_query_arg('featured_set', count($post_ids), $redirect_to);
    } elseif ($doaction === 'unset_featured') {
        foreach ($post_ids as $post_id) {
            delete_post_meta($post_id, '_is_featured');
        }
        $redirect_to = add_query_arg('featured_unset', count($post_ids), $redirect_to);
    }
    
    return $redirect_to;
}
add_filter('handle_bulk_actions-edit-post', 'minkabu_card_handle_bulk_actions', 10, 3);

/**
 * Display admin notices for bulk actions
 */
function minkabu_card_admin_notices() {
    if (!empty($_REQUEST['featured_set'])) {
        $count = intval($_REQUEST['featured_set']);
        echo '<div class="notice notice-success is-dismissible"><p>';
        printf('%d件の記事を特集記事に設定しました。', $count);
        echo '</p></div>';
    }
    
    if (!empty($_REQUEST['featured_unset'])) {
        $count = intval($_REQUEST['featured_unset']);
        echo '<div class="notice notice-success is-dismissible"><p>';
        printf('%d件の記事を特集記事から解除しました。', $count);
        echo '</p></div>';
    }
}
add_action('admin_notices', 'minkabu_card_admin_notices');