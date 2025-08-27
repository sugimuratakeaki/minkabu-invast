<?php
/**
 * Account Opening Section Template
 * 口座開設セクション テンプレート
 */

if (!defined('ABSPATH')) exit;

// ショートコードからのパラメータを取得（なければデフォルト値）
$params = isset($GLOBALS['minkabu_account_opening_params']) ? $GLOBALS['minkabu_account_opening_params'] : array();
$title = isset($params['title']) ? $params['title'] : '口座開設も <span class="highlight">スマホで簡単4ステップ！</span>';
$cta_text = isset($params['cta_text']) ? $params['cta_text'] : '口座開設はこちら';
$cta_url = isset($params['cta_url']) ? $params['cta_url'] : '/account-opening';
$show_details = isset($params['show_details']) ? ($params['show_details'] === 'true' || $params['show_details'] === true) : true;
?>

<section class="account-opening-section">
    <div class="account-opening-container">
        <!-- Main Headline -->
        <h2 class="account-opening-headline">
            <?php echo $title; ?>
        </h2>
        
        <!-- 4-Step Cards -->
        <div class="account-steps-cards">
            <div class="account-steps-row">
                <!-- Step 1 -->
                <div class="account-step-card animate-fade-in animate-delay-1">
                    <span class="account-step-number">1</span>
                    <div class="account-step-icon step-icon-document"></div>
                    <div class="account-step-title">口座開設の<br>申し込み</div>
                    <div class="account-step-arrow"></div>
                </div>
                
                <!-- Step 2 -->
                <div class="account-step-card animate-fade-in animate-delay-2">
                    <span class="account-step-number">2</span>
                    <div class="account-step-icon step-icon-upload"></div>
                    <div class="account-step-title">本人確認書類の<br>提出</div>
                    <div class="account-step-arrow"></div>
                </div>
                
                <!-- Step 3 -->
                <div class="account-step-card animate-fade-in animate-delay-3">
                    <span class="account-step-number">3</span>
                    <div class="account-step-icon step-icon-envelope"></div>
                    <div class="account-step-title">初期取引<br>パスワードの受取り</div>
                    <div class="account-step-arrow"></div>
                </div>
                
                <!-- Step 4 -->
                <div class="account-step-card animate-fade-in animate-delay-4">
                    <span class="account-step-number">4</span>
                    <div class="account-step-icon step-icon-checkmark"></div>
                    <div class="account-step-title">初期設定</div>
                </div>
            </div>
        </div>
        
        <?php if ($show_details) : ?>
        <!-- Detailed Steps -->
        <div class="account-detailed-steps">
            <h3 class="account-detailed-title">口座開設の詳細手順</h3>
            
            <div class="account-detailed-list">
                <!-- Step 01: 口座開設の申し込み -->
                <div class="account-detailed-item">
                    <div class="account-detailed-number">01</div>
                    <div class="account-detailed-text">
                        <h3>口座開設の申し込み</h3>
                        <p>メールアドレスの登録と規約の同意<br>
                        必要事項（お名前、生年月日、住所など）の入力</p>
                    </div>
                </div>
                
                <!-- Step 02: 本人確認書類の提出 -->
                <div class="account-detailed-item">
                    <div class="account-detailed-number">02</div>
                    <div class="account-detailed-text">
                        <h3>本人確認書類の提出</h3>
                        <p>マイナンバーカードをスマホで撮影してアップロード<br>
                        運転免許証など本人確認書類の画像提出</p>
                    </div>
                </div>
                
                <!-- Step 03: 初期取引パスワードの受取り -->
                <div class="account-detailed-item">
                    <div class="account-detailed-number">03</div>
                    <div class="account-detailed-text">
                        <h3>初期取引パスワードの受取り</h3>
                        <p>審査完了後、メールでログインIDを受け取り<br>
                        初期取引パスワードの設定</p>
                    </div>
                </div>
                
                <!-- Step 04: 初期設定 -->
                <div class="account-detailed-item">
                    <div class="account-detailed-number">04</div>
                    <div class="account-detailed-text">
                        <h3>初期設定・お取引開始</h3>
                        <p>口座開設完了、初期設定を行います<br>
                        設定完了後、すぐにお取引を開始できます</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- CTA Button -->
        <div class="account-cta-container">
            <a href="<?php echo esc_url($cta_url); ?>" class="account-cta-button"><?php echo esc_html($cta_text); ?></a>
        </div>
    </div>
</section>