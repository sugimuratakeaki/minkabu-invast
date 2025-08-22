<?php
/**
 * The sidebar containing the main widget area
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="sidebar">
    <!-- 検索ウィジェット -->
    <div class="widget widget-search">
        <h3 class="widget-title">検索</h3>
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" class="search-field" placeholder="キーワードを入力" value="<?php echo get_search_query(); ?>" name="s" />
            <button type="submit" class="search-submit">
                <span class="screen-reader-text">検索</span>
                🔍
            </button>
        </form>
    </div>

    <!-- カテゴリーウィジェット -->
    <div class="widget widget-categories">
        <h3 class="widget-title">カテゴリー</h3>
        <ul class="category-list">
            <?php
            $categories = get_categories(array(
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => true,
            ));
            
            foreach ($categories as $category) {
                echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . ' (' . $category->count . ')</a></li>';
            }
            ?>
        </ul>
    </div>

    <!-- 人気記事ウィジェット -->
    <div class="widget widget-popular">
        <h3 class="widget-title">人気記事</h3>
        <ul class="popular-posts">
            <?php
            $popular_posts = new WP_Query(array(
                'posts_per_page' => 5,
                'meta_key' => 'post_views_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'ignore_sticky_posts' => 1
            ));
            
            if ($popular_posts->have_posts()) :
                while ($popular_posts->have_posts()) : $popular_posts->the_post();
            ?>
                <li class="popular-post-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="popular-post-thumb">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="popular-post-content">
                        <h4 class="popular-post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <time class="popular-post-date"><?php echo get_the_date(); ?></time>
                    </div>
                </li>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </ul>
    </div>

    <!-- タグクラウドウィジェット -->
    <div class="widget widget-tags">
        <h3 class="widget-title">タグ</h3>
        <div class="tag-cloud">
            <?php
            $tags = get_tags(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => 20
            ));
            
            foreach ($tags as $tag) {
                echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-item">' . $tag->name . '</a>';
            }
            ?>
        </div>
    </div>

    <!-- アーカイブウィジェット -->
    <div class="widget widget-archives">
        <h3 class="widget-title">アーカイブ</h3>
        <ul class="archive-list">
            <?php wp_get_archives(array(
                'type' => 'monthly',
                'limit' => 12,
                'show_post_count' => true,
            )); ?>
        </ul>
    </div>

    <!-- バナーウィジェット -->
    <div class="widget widget-banner">
        <a href="#" class="banner-link">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-sidebar.jpg" alt="口座開設" class="banner-image">
        </a>
    </div>
</div>

<style>
/* サイドバースタイル */
.sidebar {
    background: #f8f8f8;
    padding: 20px;
    border-radius: 8px;
}

.widget {
    margin-bottom: 30px;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.widget:last-child {
    margin-bottom: 0;
}

.widget-title {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #0066cc;
}

/* 検索フォーム */
.search-form {
    position: relative;
}

.search-field {
    width: 100%;
    padding: 10px 40px 10px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.search-submit {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    padding: 5px 10px;
    background: transparent;
    border: none;
    cursor: pointer;
}

/* カテゴリーリスト */
.category-list {
    list-style: none;
}

.category-list li {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.category-list li:last-child {
    border-bottom: none;
}

.category-list a {
    color: #333;
    display: flex;
    justify-content: space-between;
}

.category-list a:hover {
    color: #0066cc;
    opacity: 1;
}

/* 人気記事 */
.popular-posts {
    list-style: none;
}

.popular-post-item {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.popular-post-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.popular-post-thumb {
    flex-shrink: 0;
}

.popular-post-thumb img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.popular-post-content {
    flex: 1;
}

.popular-post-title {
    font-size: 14px;
    line-height: 1.4;
    margin-bottom: 5px;
}

.popular-post-title a {
    color: #333;
}

.popular-post-title a:hover {
    color: #0066cc;
    opacity: 1;
}

.popular-post-date {
    font-size: 12px;
    color: #999;
}

/* タグクラウド */
.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-item {
    display: inline-block;
    padding: 5px 12px;
    background: #f0f0f0;
    border-radius: 20px;
    font-size: 13px;
    color: #666;
}

.tag-item:hover {
    background: #0066cc;
    color: #fff;
    opacity: 1;
}

/* アーカイブリスト */
.archive-list {
    list-style: none;
}

.archive-list li {
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.archive-list li:last-child {
    border-bottom: none;
}

.archive-list a {
    color: #333;
    font-size: 14px;
}

.archive-list a:hover {
    color: #0066cc;
    opacity: 1;
}

/* バナー */
.banner-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

/* レスポンシブ */
@media screen and (max-width: 768px) {
    .sidebar {
        margin-top: 40px;
        padding: 0;
        background: transparent;
    }
    
    .widget {
        border-radius: 0;
    }
}
</style>