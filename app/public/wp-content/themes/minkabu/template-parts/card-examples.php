<?php
/**
 * Card Grid System - Usage Examples
 * 
 * This file demonstrates various implementations of the card grid system.
 * Copy and modify these examples as needed for your templates.
 * 
 * @package minkabu
 */

// Security check
if (!defined('ABSPATH')) {
    exit;
}
?>

<!-- Example 1: Basic 3-column grid (default) -->
<div class="card-grid">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/content', 'card'); ?>
    <?php endwhile; ?>
</div>

<!-- Example 2: 2-column grid -->
<div class="card-grid card-grid--2-cols">
    <?php // Your loop here ?>
</div>

<!-- Example 3: 4-column grid -->
<div class="card-grid card-grid--4-cols">
    <?php // Your loop here ?>
</div>

<!-- Example 4: Auto-fit grid (responsive columns) -->
<div class="card-grid card-grid--auto-fit">
    <?php // Your loop here ?>
</div>

<!-- Example 5: Custom card with square thumbnails -->
<article class="card">
    <div class="card__media card__media--square">
        <?php the_post_thumbnail('medium', array('class' => 'card__image')); ?>
    </div>
    <div class="card__content">
        <h3 class="card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="card__meta">
            <span class="card__author"><?php the_author(); ?></span>
            <span class="card__date"><?php the_date(); ?></span>
        </div>
    </div>
</article>

<!-- Example 6: Featured card with description -->
<article class="card card--featured">
    <div class="card__media">
        <?php the_post_thumbnail('large', array('class' => 'card__image')); ?>
        <span class="card__badge">Featured</span>
    </div>
    <div class="card__content">
        <h3 class="card__title card__title--large">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="card__description">
            <?php echo get_the_excerpt(); ?>
        </p>
        <div class="card__meta card__meta--no-border">
            <span class="card__author"><?php the_author(); ?></span>
            <span class="card__date"><?php the_date(); ?></span>
        </div>
    </div>
</article>

<!-- Example 7: Horizontal card layout -->
<article class="card card--horizontal">
    <div class="card__media">
        <?php the_post_thumbnail('thumbnail', array('class' => 'card__image')); ?>
    </div>
    <div class="card__content">
        <h3 class="card__title card__title--small">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="card__meta">
            <span class="card__date"><?php the_date(); ?></span>
        </div>
    </div>
</article>

<!-- Example 8: Minimal card (no shadow) -->
<article class="card card--minimal">
    <div class="card__media">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium', array('class' => 'card__image')); ?>
        <?php else : ?>
            <div class="card__media--empty"></div>
        <?php endif; ?>
    </div>
    <div class="card__content card__content--compact">
        <h3 class="card__title card__title--2-lines">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="card__meta">
            <span class="card__date"><?php the_date(); ?></span>
        </div>
    </div>
</article>

<!-- Example 9: Loading state cards -->
<div class="card-grid">
    <?php for ($i = 0; $i < 3; $i++) : ?>
        <article class="card card--loading">
            <div class="card__media"></div>
            <div class="card__content">
                <div class="card__title"></div>
                <div class="card__meta"></div>
            </div>
        </article>
    <?php endfor; ?>
</div>

<!-- Example 10: Card with footer -->
<article class="card">
    <div class="card__media card__media--wide">
        <?php the_post_thumbnail('medium_large', array('class' => 'card__image')); ?>
    </div>
    <div class="card__content">
        <h3 class="card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="card__description">
            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
        </p>
    </div>
    <div class="card__footer">
        <span class="card__date"><?php the_date(); ?></span>
        <a href="<?php the_permalink(); ?>" class="card__read-more">Read More →</a>
    </div>
</article>