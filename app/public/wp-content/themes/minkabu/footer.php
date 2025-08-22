</main><!-- #main -->

<?php if (!wp_is_mobile()) : ?>
<!-- PC Footer -->
<footer id="pcFooter" class="footer pt5 mt10" style="padding-bottom: 90px;">
    <nav>
        <ul class="breadcrumbs">
            <li><a href="https://minkabu.jp">TOP</a></li>
            <li><a href="https://fx.minkabu.jp/">FX/為替</a></li>
            <li>為替レート</li>
        </ul>
    </nav>
    <div class="footer__inner pt5">
        <p class="footer__text fs-xs mb8" data-accordion-role="reader">
            【ご注意】『みんかぶ』における「買い」「売り」の情報はあくまでも投稿者の個人的見解によるものであり、情報の真偽、株式の評価に関する正確性・信頼性等については一切保証されておりません。 
            また、東京証券取引所、名古屋証券取引所、China Investment Information Services、NASDAQ OMX、CME Group Inc.、東京商品取引所、堂島取引所、 S&amp;P Global、S&amp;P Dow Jones Indices、Hang Seng Indexes、bitFlyer、ＮＴＴデータエービック、ICE Data Services等から情報の提供を受けています。 
            日経平均株価の著作権は日本経済新聞社に帰属します。 『みんかぶ』に掲載されている情報は、投資判断の参考として投資一般に関する情報提供を目的とするものであり、投資の勧誘を目的とするものではありません。 
            これらの情報には将来的な業績や出来事に関する予想が含まれていることがありますが、それらの記述はあくまで予想であり、その内容の正確性、信頼性等を保証するものではありません。
            掲載しているFX会社の評価やランキングは、各FX会社の公式サイトの掲載情報や、実際の取引画面の調査、個人投資家へのアンケートに基づいています。
            ただし、必ずしもサービスの内容、正確性、信頼性等を保証するものではございません。また、ランキングの評価項目は各カテゴリの比較ページに掲載しています。 
            総合ランキングについてはスプレッド比較、スワップ比較、PCツール比較、スマホアプリ比較、取引ルール比較、ニュース・コラム比較の評価をもとにランキングを作成しています。
            これらの情報に基づいて被ったいかなる損害についても、当社、投稿者及び情報提供者は一切の責任を負いません。 
            投資に関するすべての決定は、利用者ご自身の判断でなさるようにお願いいたします。 
            個別の投稿が金融商品取引法等に違反しているとご判断される場合には「<a target="_blank" rel="nofollow" href="https://www.fsa.go.jp/sesc/watch/"><span class="fc-white60 fbd">証券取引等監視委員会への情報提供</span></a>」から、同委員会へ情報の提供を行ってください。 
            また、『みんかぶ』において公開されている情報につきましては、営業に利用することはもちろん、第三者へ提供する目的で情報を転用、複製、販売、加工、再利用及び再配信することを固く禁じます。
        </p>
        <ul class="footer__nav text-sm flexbox pb5 mb5">
            <li class="mr8"><a title="みんかぶ（FX/為替）について" href="/about">みんかぶ（FX/為替）について</a></li>
            <li class="mr8"><a href="https://minkabu.co.jp/" target="_blank">運営会社</a></li>
            <li class="mr8"><a href="https://info.minkabu.jp/terms/" target="_blank">利用規約</a></li>
            <li class="mr8"><a href="https://minkabu.co.jp/privacy-policy/" target="_blank">プライバシーポリシー</a></li>
            <li class="mr8"><a href="https://info.minkabu.jp/economy/" target="_blank">特定商取引表示</a></li>
            <li class="mr8"><a href="https://info.minkabu.jp/law/" target="_blank">ご利用上の注意（関連法規）</a></li>
            <li class="mr8"><a href="https://livedoor.co.jp/sales/minkabu-sales-sheet.pdf" target="_blank" rel="noopener">広告掲載・取扱商品</a></li>
            <li><a href="https://minkabu.jp/top/contact" target="_blank">お問い合わせ</a></li>
        </ul>
        <div class="flexbox flexbox_l-between flexbox_l-middle">
            <a target="_blank" rel="noopener" href="https://minkabu.co.jp/">
                <img alt="会社ロゴ" width="150" height="60" src="https://assets.minkabu.jp/images/logo/v2/min_infonoid_logo_black.svg">
            </a>
            <span class="fs-s">(C)&nbsp;MINKABU&nbsp;THE&nbsp;INFONOID,&nbsp;Inc.</span>
        </div>
    </div>
</footer>

<?php else : ?>
<!-- SP Footer -->
<footer class="footer fs-s pr10 pl10">
    <a href="https://minkabu.co.jp/">
        <img alt="会社ロゴ" width="150" height="60" src="https://fx.minkabu.jp/assets/infonoid_logo-a31d7ea017469573269b005964204c8fbbd68080c1456f98d3260d02d248f7a3.svg">
    </a>
    <p class="tcen">(C)&nbsp;MINKABU&nbsp;THE&nbsp;INFONOID,&nbsp;Inc.</p>
</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>