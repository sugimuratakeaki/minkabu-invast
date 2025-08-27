<?php
/**
 * Template part for displaying content in card layout
 *
 * @package minkabu
 */

// Security check
if (!defined('ABSPATH')) {
    exit;
}

// Get post data
$post_id = get_the_ID();
$title = get_the_title();
$permalink = get_the_permalink();
$author = get_the_author();
$date = get_the_date('Y.m.d');
?>

<article id="post-<?php echo $post_id; ?>" <?php post_class('card card--clickable'); ?>>
    <!-- Clickable overlay -->
    <a href="<?php echo esc_url($permalink); ?>" class="card__link" aria-label="<?php echo esc_attr($title); ?>"></a>
    
    <!-- Card Media/Thumbnail -->
    <div class="card__media">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium_large', array(
                'class' => 'card__image',
                'loading' => 'lazy',
                'alt' => get_the_title()
            )); ?>
        <?php else : ?>
            <!-- Empty state for missing thumbnail -->
            <div class="card__media--empty"></div>
        <?php endif; ?>
    </div>
    
    <!-- Card Content -->
    <div class="card__content">
        <!-- Title -->
        <h3 class="card__title">
            <a href="<?php echo esc_url($permalink); ?>" rel="bookmark">
                <?php echo esc_html($title); ?>
            </a>
        </h3>
        
        <!-- Meta Information -->
        <div class="card__meta">
            <span class="card__author">
                <?php echo esc_html($author); ?>編集室
            </span>
            <span class="card__date">
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html($date); ?>
                </time>
            </span>
        </div>
    </div>
</article>