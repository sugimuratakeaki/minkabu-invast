<?php
/**
 * TriAutoFX Introduction Section
 * トライオートFX紹介セクション
 */

if (!defined('ABSPATH')) exit;
?>

<section class="triautofx-intro-section">
    <div class="triautofx-container">
        
        <!-- Main Hero Box -->
        <div class="triautofx-hero">
            <h2 class="triautofx-hero-title">
                初心者にも<span class="highlight">わかる</span><br>
                トライオートFXとは？
            </h2>
            <p class="triautofx-hero-text">
                「トライオートFXをしたい」「自動売買を知りたい」そう思っている方におすすめの記事をご紹介！初金をしながらトライオートFXができる新NISA、iDeCoについて、各投資商品についてなど、おすすめの自動売買の方法を分かりやすく解説します。
            </p>
            <div class="triautofx-icons">
                <span class="icon-chart">📊</span>
                <span class="icon-edit">📝</span>
                <span class="icon-tools">🔧</span>
            </div>
        </div>

        <!-- Diagnosis Box -->
        <div class="triautofx-diagnosis">
            <h3 class="diagnosis-title">
                診断：あなたはセレクト派？ビルダー派？ 🤔
            </h3>
        </div>

        <!-- Recommended Articles Title -->
        <h3 class="triautofx-articles-title">トライオートFXおすすめ記事</h3>

        <!-- Article Cards Grid using same card-grid style as main content -->
        <div class="card-grid">
            <?php
            // カテゴリー「pick_up」の最新記事を取得
            $pickup_args = array(
                'category_name' => 'pick_up',
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC'
            );
            
            $pickup_posts = new WP_Query($pickup_args);
            
            if ($pickup_posts->have_posts()) :
                while ($pickup_posts->have_posts()) : $pickup_posts->the_post();
                    // 既存のcontent-cardテンプレートを使用
                    get_template_part('template-parts/content', 'card');
                endwhile;
            else : 
                // pick_upカテゴリーに記事がない場合は最新記事を表示
                $fallback_args = array(
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                
                $fallback_posts = new WP_Query($fallback_args);
                
                if ($fallback_posts->have_posts()) :
                    while ($fallback_posts->have_posts()) : $fallback_posts->the_post();
                        get_template_part('template-parts/content', 'card');
                    endwhile;
                endif;
                wp_reset_postdata();
            endif;
            wp_reset_postdata();
            ?>
        </div>

        <!-- CTA Button -->
        <div class="triautofx-cta">
            <a href="#" class="triautofx-cta-button">
                自動売買って全部同じに見える？<br>
                トライオートはここが違う ➜
            </a>
        </div>

    </div>
</section>