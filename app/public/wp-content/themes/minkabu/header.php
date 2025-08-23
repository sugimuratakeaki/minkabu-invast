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
        <button class="hamburger-menu" id="hamburgerMenu" aria-label="メニューを開く">
            <span></span>
            <span></span>
            <span></span>
        </button>
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

<?php if (wp_is_mobile()) : ?>
<!-- Slide Menu -->
<nav id="slide-menu" class="slideout-menu slideout-menu-right">
  <dl class="slide-close-btn">
    <dt class="trit p10">
      <img alt="CLOSEアイコン" width="20" height="auto" class="" src="https://fx.minkabu.jp/assets/close-c6421da6708ea80fd0b8ab9df33c20903581a5c70b4f8234f26985d9314aebfb.svg">
    </dt>
  </dl>
  <div class="mb10"><a href="https://tw.minkabu.jp/"><img loading="lazy" src="https://fx.minkabu.jp/assets/asset_planner/banner_assetplanner_270_50-8d23bd4c9d4dd6910dc7017e0574b69ec093c31e5bbb8e87cf471abcc0eb519d.png" width="270" height="50"></a></div>
  <ul class="flexbox_wrap flexbox_l-start slide__media_icon_box">
    <li class="icon_box__col4">
      <a href="https://minkabu.jp/" title="株式トップ" class="d-block p5">
        <div class="pt2 pb2">
          <img src="https://assets.minkabu.jp/images/icon/icon_kabu.svg" alt="株式アイコン" width="25" height="25" class="d-block icon_box__m-auto">
        </div>
        <p class="icon_box__text fc-white tcen">株式</p>
      </a>
    </li>
    <li class="icon_box__col4">
      <a href="https://us.minkabu.jp/" title="米国株トップ" class="d-block p5">
        <div class="pt2 pb2">
          <img src="https://assets.minkabu.jp/images/icon/icon_us.svg" alt="米国株アイコン" width="25" height="25" class="d-block icon_box__m-auto">
        </div>
        <p class="icon_box__text fc-white tcen">米国株</p>
      </a>
    </li>
    <li class="icon_box__col4">
      <a href="https://itf.minkabu.jp/" title="投資信託トップ" class="d-block p5">
        <div class="pt2 pb2">
          <img src="https://assets.minkabu.jp/images/icon/icon_toushin.svg" alt="投資信託アイコン" width="25" height="25" class="d-block icon_box__m-auto">
        </div>
        <p class="icon_box__text fc-white tcen">投資信託</p>
      </a>
    </li>
    <li class="icon_box__col4">
      <a href="https://tw.minkabu.jp/?utm_source=mintame&amp;utm_medium=sp_hamburger_menu&amp;utm_campaign=media_list" title="アセプラ" class="d-block p5">
        <div class="pt2 pb2">
          <img src="https://assets.minkabu.jp/images/icon/icon_asset_white.svg" alt="アセプラ" width="25" height="25" class="d-block icon_box__m-auto">
        </div>
        <p class="icon_box__text fc-white tcen">アセプラ</p>
      </a>
    </li>
    <li class="icon_box__col4">
      <a href="https://ins.minkabu.jp/" title="保険トップ" class="d-block p5">
        <div class="pt2 pb2">
          <img src="https://assets.minkabu.jp/images/icon/icon_hoken.svg" alt="保険アイコン" width="25" height="25" class="d-block icon_box__m-auto">
        </div>
        <p class="icon_box__text fc-white tcen">保険</p>
      </a>
    </li>
    <li class="icon_box__col4">
      <a href="https://fu.minkabu.jp/" title="先物トップ" class="d-block p5">
        <div class="pt2 pb2">
          <img src="https://assets.minkabu.jp/images/icon/icon_sakimono.svg" alt="先物アイコン" width="25" height="25" class="d-block icon_box__m-auto">
        </div>
        <p class="icon_box__text fc-white tcen">先物</p>
      </a>
    </li>
    <li class="icon_box__col4">
      <a href="https://cc.minkabu.jp/" title="仮想通貨トップ" class="d-block p5">
        <div class="pt2 pb2">
          <img src="https://assets.minkabu.jp/images/icon/icon_kasoutsuka.svg" alt="仮想通貨アイコン" width="25" height="25" class="d-block icon_box__m-auto">
        </div>
        <p class="icon_box__text fc-white tcen">仮想通貨</p>
      </a>
    </li>
    <li class="icon_box__col4">
      <a href="https://mag.minkabu.jp/" title="みんかぶマガジントップ" class="d-block p5">
        <div class="pt2 pb2">
          <img src="https://assets.minkabu.jp/images/icon/icon_study.svg" alt="みんかぶマガジンアイコン" width="25" height="25" class="d-block icon_box__m-auto">
        </div>
        <p class="icon_box__text fc-white tcen">マガジン</p>
      </a>
    </li>
  </ul>

  <div class="user_block">
      <div class="sign_up_login">
        <a href="https://id.minkabu.jp/login?callback_url=https%3A%2F%2Ffx.minkabu.jp%2Fpair&amp;service=fxminkabu">ログイン</a><span>｜</span><a href="https://id.minkabu.jp/sign_up?callback_url=https%3A%2F%2Ffx.minkabu.jp%2Fpair&amp;service=fxminkabu">会員登録</a>
      </div>
  </div>

  <dl class="slide-list">
    <dd>
      <a href="https://s.minkabu.jp/" title="みんかぶTOP" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
        <span>みんかぶTOP</span>
        <i class="i-arrow_right ml3 mr3"></i>
      </a>
    </dd>
      <dd><a title="FX/為替TOP" class="flexbox flexbox_l-middle flexbox_l-between item-pd" href="https://fx.minkabu.jp/"><span>FX/為替TOP</span><i class="i-arrow_right ml3 mr3"></i></a></dd>
  </dl>

  <dl class="slide-list">
    <dt>その他金融商品・関連サイト</dt>
    <dd>
      <a href="https://tw.minkabu.jp/?utm_source=mintame&amp;utm_medium=sp_hamburger_menu&amp;utm_campaign=media_list" title="みんかぶアセットプランナー" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
        <span>みんかぶアセットプランナー</span>
        <i class="i-arrow_right ml3 mr3"></i>
      </a>
    </dd>
    <dd>
      <a href="https://s.minkabu.jp/" title="株式" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
        <span>株式</span>
        <i class="i-arrow_right ml3 mr3"></i>
      </a>
    </dd>
    <dd>
      <a href="https://us.minkabu.jp/" title="米国株" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
        <span>米国株</span>
        <i class="i-arrow_right ml3 mr3"></i>
      </a>
    </dd>
    <dd>
      <a href="https://cc.minkabu.jp/" title="仮想通貨（暗号資産）" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
        <span>仮想通貨（暗号資産）</span>
        <i class="i-arrow_right ml3 mr3"></i>
      </a>
    </dd>
    <dd>
      <a href="https://fu.minkabu.jp/" title="先物" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
        <span>先物</span>
        <i class="i-arrow_right ml3 mr3"></i>
      </a>
    </dd>
    <dd>
      <a href="https://itf.minkabu.jp/" title="投資信託" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
        <span>投資信託</span>
        <i class="i-arrow_right ml3 mr3"></i>
      </a>
    </dd>
    <dd>
      <a href="https://ins.minkabu.jp/" title="保険" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
        <span>保険</span>
        <i class="i-arrow_right ml3 mr3"></i>
      </a>
    </dd>
    <dd>
      <div class="menu">
        <input type="checkbox" id="type1" class="accordion">
        <label for="type1" class="flexbox flexbox_l-middle flexbox_l-between i-motion item-pd">
          <span>初心者</span>
          <i class="i-arrow_down ml3 mr3"></i>
        </label>
        <ul id="links1">
          <li>
            <a title="株 初心者入門" href="https://mag.minkabu.jp/kabu-beginner/" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>株 初心者入門</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
          <li>
            <a title="投資信託 初心者" href="https://mag.minkabu.jp/itf-beginner/" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>投資信託 初心者</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
          <li>
            <a title="FX 初心者入門" href="https://mag.minkabu.jp/fx-beginner/" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>FX 初心者入門</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
          <li>
            <a title="暗号資産 入門" href="https://mag.minkabu.jp/cc-beginner/" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>暗号資産 入門</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
          <li>
            <a title="不動産投資 入門" href="https://mag.minkabu.jp/re-beginner/" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>不動産投資 入門</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
          <li>
            <a title="先物取引 入門" href="https://fu.minkabu.jp/beginner" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>先物取引 入門</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
          <li>
            <a title="保険コラム" href="https://ins.minkabu.jp/columns" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>保険コラム</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
          <li>
            <a title="証券会社比較" href="https://minkabu.jp/hikaku/" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>証券会社比較</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
          <li>
            <a title="FX会社比較" href="https://fx.minkabu.jp/hikaku/" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>FX会社比較</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
          <li>
            <a title="暗号資産取引所比較" href="https://cc.minkabu.jp/hikaku/" class="flexbox flexbox_l-middle flexbox_l-between item-pd">
              <span>暗号資産取引所比較</span>
              <i class="i-arrow_right ml3 mr3"></i>
            </a>
          </li>
        </ul>
      </div>
    </dd>
  </dl>
  <ul class="slide-caution font-light">
    <li><a class="slide-caution__item" href="https://minkabu.co.jp/" target="_blank"><span class="fc-white text-sm">運営会社</span></a></li>
    <li><a class="slide-caution__item" href="https://info.minkabu.jp/terms/" target="_blank"><span class="fc-white text-sm">利用規約</span></a></li>
    <li><a class="slide-caution__item" href="https://minkabu.co.jp/privacy-policy/" target="_blank"><span class="fc-white text-sm">プライバシーポリシー</span></a></li>
    <li><a class="slide-caution__item" href="https://info.minkabu.jp/economy/" target="_blank"><span class="fc-white text-sm">特定商取引表示</span></a></li>
    <li><a class="slide-caution__item" href="https://info.minkabu.jp/law/" target="_blank"><span class="fc-white text-sm">ご利用上の注意（関連法規）</span></a></li>
    <li><a class="slide-caution__item" href="https://livedoor.co.jp/sales/minkabu-sales-sheet.pdf" target="_blank" rel="noopener"><span class="fc-white text-sm">広告掲載・取扱商品</span></a></li>
    <li><a class="slide-caution__item" href="https://s.minkabu.jp/top/contact" target="_blank"><span class="fc-white text-sm">お問い合わせ</span></a></li>
    <li>
      <details>
        <summary class="slide-caution__item fc-white text-sm">ご注意</summary>
        <p class="mt3 fs-xs fc-white text-sm pb10 pr15 pl15">【ご注意】『みんかぶ』における「買い」「売り」の情報はあくまでも投稿者の個人的見解によるものであり、情報の真偽、株式の評価に関する正確性・信頼性等については一切保証されておりません。 また、東京証券取引所、名古屋証券取引所、China Investment Information Services、NASDAQ OMX、CME Group Inc.、東京商品取引所、堂島取引所、 S&amp;P Global、S&amp;P Dow Jones Indices、Hang Seng Indexes、bitFlyer、ＮＴＴデータエービック、ICE Data Services等から情報の提供を受けています。 日経平均株価の著作権は日本経済新聞社に帰属します。 『みんかぶ』に掲載されている情報は、投資判断の参考として投資一般に関する情報提供を目的とするものであり、投資の勧誘を目的とするものではありません。 これらの情報には将来的な業績や出来事に関する予想が含まれていることがありますが、それらの記述はあくまで予想であり、その内容の正確性、信頼性等を保証するものではありません。掲載しているFX会社の評価やランキングは、各FX会社の公式サイトの掲載情報や、実際の取引画面の調査、個人投資家へのアンケートに基づいています。ただし、必ずしもサービスの内容、正確性、信頼性等を保証するものではございません。また、ランキングの評価項目は各カテゴリの比較ページに掲載しています。 総合ランキングについてはスプレッド比較、スワップ比較、PCツール比較、スマホアプリ比較、取引ルール比較、ニュース・コラム比較の評価をもとにランキングを作成しています。これらの情報に基づいて被ったいかなる損害についても、当社、投稿者及び情報提供者は一切の責任を負いません。 投資に関するすべての決定は、利用者ご自身の判断でなさるようにお願いいたします。 個別の投稿が金融商品取引法等に違反しているとご判断される場合には「<a target="_blank" rel="nofollow" href="https://www.fsa.go.jp/sesc/watch/"><span class="fc-white60 fbd">証券取引等監視委員会への情報提供</span></a>」から、同委員会へ情報の提供を行ってください。 また、『みんかぶ』において公開されている情報につきましては、営業に利用することはもちろん、第三者へ提供する目的で情報を転用、複製、販売、加工、再利用及び再配信することを固く禁じます。</p>
      </details>
    </li>
  </ul>
</nav>

<!-- Overlay -->
<div class="slide-overlay" id="slideOverlay"></div>
<?php endif; ?>

<?php if (!wp_is_mobile()) : ?>
<div class="l-container">
<?php else : ?>
<main id="main" class="site-main slideout-panel">
<?php endif; ?>