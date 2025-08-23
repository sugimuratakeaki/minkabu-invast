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
        <!-- Default widgets if no widgets are active -->
        <div class="widget">
            <h3 class="widget-title">アクセスランキング</h3>
            <p>ウィジェットエリアにウィジェットを追加してください。</p>
        </div>
        <div class="widget">
            <h3 class="widget-title">更新記事一覧</h3>
            <p>管理画面 > 外観 > ウィジェット からウィジェットを設定できます。</p>
        </div>
    <?php endif; ?>
</aside>
<?php endif; ?>