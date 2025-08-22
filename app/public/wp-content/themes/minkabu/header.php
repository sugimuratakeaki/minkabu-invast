<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if (wp_is_mobile()) : ?>
<!-- SP Header -->
<header class="sp_header">
    <div class="header__inner flexbox flexbox_l-middle header-usual" id="spHeader">
        <div>
            <a class="l-header__logo" href="https://minkabu.jp/" title="みんかぶ">
                <img alt="みんかぶ" width="110" height="30" class="d-block" src="https://assets.minkabu.jp/images/logo/v4/logo_minkabu.svg">
            </a>
        </div>
        <!-- Menu button removed -->
    </div>
</header>

<?php else : ?>
<!-- PC Header -->
<header>
    <div class="l-header">
        <div class="ribbon_box">
            <a href="https://id.minkabu.jp/premium_lp.html">
                <span class="md_ribbon">みんかぶプレミアムのご紹介 ›</span>
            </a>
        </div>
        <div class="flexbox l-header__first flexbox_l-middle tlft">
            <div class="m-0">
                <a class="l-header__logo" href="https://minkabu.jp/" title="みんかぶ">
                    <img alt="みんかぶ" width="146" height="40" class="d-block" src="https://assets.minkabu.jp/images/logo/v4/logo_minkabu.svg">
                </a>
            </div>
            <div class="l-header__media">
                <ul class="flexbox">
                    <li class="l-header__media__li"><a href="https://minkabu.jp/">株式</a></li>
                    <li class="l-header__media__li"><a href="https://us.minkabu.jp/">米国株</a></li>
                    <li class="l-header__media__li"><a class="fbd fc-red" href="https://fx.minkabu.jp/">FX</a></li>
                    <li class="l-header__media__li"><a href="https://cc.minkabu.jp/">仮想通貨</a></li>
                    <li class="l-header__media__li"><a href="https://itf.minkabu.jp/">投信</a></li>
                    <li class="l-header__media__li"><a href="https://fu.minkabu.jp">先物</a></li>
                    <li class="l-header__media__li"><a href="https://ins.minkabu.jp/">保険</a></li>
                    <li class="l-header__media__li">
                        <span class="l-header__media__li__hover l-header__media__li__arrow-s">マガジン</span>
                        <div class="l-header__media__second flexbox flexbox_l-around tlft">
                            <ul>
                                <li class="l-header__media__second__li text-link">
                                    <a title="マガジンTOP" class="l-header__nav__second__link" href="https://mag.minkabu.jp/">マガジンTOP</a>
                                </li>
                                <li class="l-header__media__second__li text-link">
                                    <a title="マガジン総合" class="l-header__nav__second__link" href="https://mag.minkabu.jp/mag-sogo/">マガジン総合</a>
                                </li>
                                <li class="l-header__media__second__li text-link">
                                    <a title="資産形成のはじめ方" class="l-header__nav__second__link" href="https://mag.minkabu.jp/asset-formation/">資産形成のはじめ方</a>
                                </li>
                                <li class="l-header__media__second__li text-link">
                                    <a title="NISA・つみたてNISA" class="l-header__nav__second__link" href="https://mag.minkabu.jp/nisa-tnisa/">NISA・つみたてNISA</a>
                                </li>
                                <li class="l-header__media__second__li text-link">
                                    <a title="iDeCo（イデコ）" class="l-header__nav__second__link" href="https://mag.minkabu.jp/ideco/">iDeCo（イデコ）</a>
                                </li>
                            </ul>
                            <ul>
                                <li class="l-header__media__second__li text-link">
                                    <a title="株 初心者入門" class="l-header__nav__second__link" href="https://mag.minkabu.jp/kabu-beginner/">株 初心者入門</a>
                                </li>
                                <li class="l-header__media__second__li text-link">
                                    <a title="投資信託 初心者入門" class="l-header__nav__second__link" href="https://mag.minkabu.jp/itf-beginner/">投資信託 初心者入門</a>
                                </li>
                                <li class="l-header__media__second__li text-link">
                                    <a title="FX 初心者入門" class="l-header__nav__second__link" href="https://mag.minkabu.jp/fx-beginner/">FX 初心者入門</a>
                                </li>
                                <li class="l-header__media__second__li text-link">
                                    <a title="仮想通貨 初心者入門" class="l-header__nav__second__link" href="https://mag.minkabu.jp/cc-beginner/">仮想通貨 初心者入門</a>
                                </li>
                                <li class="l-header__media__second__li text-link">
                                    <a title="不動産 初心者入門" class="l-header__nav__second__link" href="https://mag.minkabu.jp/re-beginner/">不動産 初心者入門</a>
                                </li>
                                <li class="l-header__media__second__li text-link">
                                    <a title="先物取引 初心者入門" class="l-header__nav__second__link" href="https://fu.minkabu.jp/beginner">先物取引 初心者入門</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<?php endif; ?>

<!-- Mobile Drawer removed -->

<main id="main" class="site-main">