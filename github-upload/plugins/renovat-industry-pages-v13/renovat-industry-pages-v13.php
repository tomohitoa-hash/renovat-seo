<?php
/**
 * Plugin Name: Renovat Industry Pages
 * Description: Creates industry-specific consultation pages and adds an industry section to the static top page.
 * Version: 1.3.0
 * Author: Renovat
 */

if (!defined('ABSPATH')) exit;

define('RIP_VERSION', '1.3.0');
define('RIP_PHONE', '0584-30-9143');
define('RIP_TEL', '0584309143');
define('RIP_EMAIL', 'info@renovat.jp');

function rip_root_dir() {
    $base = trailingslashit(ABSPATH);
    $parent = trailingslashit(dirname(untrailingslashit($base)));
    if (basename(untrailingslashit($base)) === 'column' && is_dir($parent)) return $parent;
    return $base;
}

function rip_backup_file($file, $label = 'file') {
    if (!file_exists($file)) return true;
    $upload = wp_upload_dir();
    if (!empty($upload['error'])) return new WP_Error('upload', $upload['error']);
    $dir = trailingslashit($upload['basedir']) . 'renovat-backups/industry-pages/';
    if (!wp_mkdir_p($dir)) return new WP_Error('backup_dir', 'バックアップ保存先を作成できません。');
    $backup = $dir . sanitize_file_name($label) . '-' . current_time('Ymd-His') . '-' . wp_generate_password(6, false, false) . '.bak';
    return copy($file, $backup) ? true : new WP_Error('backup', 'バックアップに失敗しました: ' . $file);
}

function rip_common_links() {
    return array(
        '法人向け不用品回収' => '/service/business-junk-removal/',
        '個人向け不用品回収' => '/service/personal-junk-removal/',
        '廃棄物一元管理' => '/column/service/waste-centralized-management/',
        '難処理物・特殊廃棄物' => '/difficult-waste.html',
        '事業系ごみ回収手配' => '/business-waste.html',
        '対応エリア' => '/area.html',
        'お問い合わせ' => '/contact.html#form',
    );
}

function rip_pages() {
    return array(
        'real-estate' => array(
            'label' => '不動産会社様',
            'title' => '不動産会社向け不用品回収・残置物撤去の相談',
            'seo_title' => '不動産会社向け不用品回収・残置物撤去の相談｜退去・原状回復時の回収手配ならリノバト',
            'description' => '賃貸退去、管理物件、店舗・オフィス退去、原状回復時の不用品・残置物回収をサポート。リノバトが許可を持つ協力業者と連携し、回収手配・処理手配を行います。',
            'lead' => '賃貸退去、管理物件、店舗・オフィス退去、原状回復前の片付けなど、不用品・残置物の相談が発生した際に、リノバトが相談窓口として回収手配・処理手配をサポートします。',
            'keywords' => '不動産会社 不用品回収,管理会社 残置物,賃貸 残置物 処分,退去 不用品回収,原状回復 廃棄物',
            'troubles' => array('退去後に家具・家電・生活用品が残っている', '原状回復前に残置物を片付けたい', '店舗・オフィス退去で什器や備品が残っている', '管理会社・オーナーとして相談先を確保したい', '写真だけで概算相談をしたい'),
            'consults' => array('賃貸退去時の不用品回収相談', '引っ越し時に残った残置物', '店舗・オフィス退去時の什器・備品', '原状回復前の片付け', '空き家整理・管理物件の整理', '急ぎ案件の対応可否確認'),
            'items' => array('家具・家電・生活用品', '店舗什器・オフィス家具', '段ボール・古紙・廃プラスチック', '残置物・家財一式', '注意が必要：一般家庭の不用品は地域の一般廃棄物許可が関係します'),
            'related' => array('法人向け不用品回収' => '/service/business-junk-removal/', '個人向け不用品回収' => '/service/personal-junk-removal/', '残置物撤去の相談' => '/column/service/corporate-remaining-items-removal/'),
            'faq' => array(
                '写真だけで見積もり相談できますか？' => '可能です。所在地、写真、量、搬出条件が分かると概算確認がしやすくなります。',
                '急ぎの退去案件も相談できますか？' => 'はい。地域と内容を確認し、対応可能な協力業者との調整可否を確認します。',
                '一般家庭の残置物も相談できますか？' => 'はい。地域の許可を持つ協力業者と連携して、相談窓口として手配をサポートします。',
                '管理会社からの紹介案件も対応できますか？' => '対応可能です。紹介元様・ご依頼者様の連絡方法も含めて調整します。',
                '店舗退去やオフィス退去も相談できますか？' => 'はい。什器、備品、OA機器、機密書類なども含めて相談できます。',
            ),
        ),
        'medical-care' => array(
            'label' => '病院・介護施設・ケアマネージャー様',
            'title' => '病院・介護施設・ケアマネージャー向け不用品回収・遺品整理相談',
            'seo_title' => '病院・介護施設・ケアマネージャー向け不用品回収・遺品整理相談｜入居・退去・長期入院時の回収手配',
            'description' => '病院、介護施設、ケアマネージャー様向けに、入居・退去・長期入院・お亡くなりになられた際の不用品回収や遺品整理の相談を受け付けています。協力業者と連携し回収手配をサポートします。',
            'lead' => '施設入居、長期入院、退去、ご逝去後の家財整理など、ご家族や施設担当者様から相談が入りやすい片付け案件を、相談窓口としてサポートします。',
            'keywords' => '介護施設 不用品回収,ケアマネージャー 遺品整理,病院 退院 不用品,長期入院 家財整理,施設入居 家財整理',
            'troubles' => array('施設入居前に自宅の家財を整理したい', '長期入院で部屋の片付け相談が必要', '老人ホーム退去時の不用品が残っている', 'ご家族から遺品整理の相談を受けた', '施設担当者・ケアマネージャーとして紹介先を探している'),
            'consults' => array('施設入居時の家財整理', '長期入院時の片付け', '介護施設退去時の不用品', 'お亡くなりになられた際の遺品整理', 'ご家族からの相談・紹介案件', '感染性廃棄物は専門対応が必要なため別途確認'),
            'items' => array('家具・家電・衣類・生活用品', '介護ベッド・福祉用具の相談', '遺品整理・家財整理', '施設内の事業系廃棄物相談', '注意が必要：感染性廃棄物・医療系廃棄物は専門の処理体制が必要です'),
            'related' => array('個人向け不用品回収' => '/service/personal-junk-removal/', '介護施設の廃棄物管理' => '/column/service/care-facility-waste-management/', '感染性廃棄物管理' => '/column/service/infectious-waste-management/'),
            'faq' => array(
                'ケアマネージャーからの紹介でも相談できますか？' => 'はい。ご家族・施設担当者様との連絡方法も含めて調整できます。',
                '退去日が近い場合も相談できますか？' => '地域や量により異なりますが、対応可能な協力業者との調整可否を確認します。',
                '遺品整理も相談できますか？' => '可能です。専門対応ができる協力業者との連携可否を確認します。',
                '感染性廃棄物も一緒に相談できますか？' => '感染性廃棄物は専門の許可・処理体制が必要です。一般の不用品とは分けて確認します。',
                'リノバトが回収するのですか？' => 'いいえ。リノバトは相談窓口として、地域の許可を持つ協力業者と連携し回収手配をサポートします。',
            ),
        ),
        'construction-renovation' => array(
            'label' => '工務店・リフォーム業・解体業者様',
            'title' => '工務店・リフォーム業・解体業者向け廃材処分・不用品回収相談',
            'seo_title' => '工務店・リフォーム業・解体業者向け廃材処分・不用品回収相談｜木くず・石膏ボード・混合廃棄物の手配',
            'description' => 'リフォーム、解体、改装時に発生する廃材、木くず、石膏ボード、混合廃棄物、不用品の処理手配をサポート。許可を持つ協力業者と連携し、現場ごとの回収相談に対応します。',
            'lead' => 'リフォーム・解体・改装現場では、木くず、石膏ボード、混合廃棄物、残置物など処理区分の確認が必要な廃棄物が発生します。現場ごとのスポット相談をサポートします。',
            'keywords' => '工務店 廃棄物,リフォーム 廃材処分,解体 廃棄物,木くず 処分,石膏ボード 処分,混合廃棄物 処理',
            'troubles' => array('現場ごとに廃材の種類や量が変わる', '木くず・石膏ボード・混合廃棄物の処理先を探している', '残置物と工事廃材を分けて相談したい', 'スポット回収の手配先を確保したい', '処理区分や必要書類を整理したい'),
            'consults' => array('リフォーム時の廃材', '解体・改装時の廃材', '木くず・石膏ボード・混合廃棄物', '現場ごとのスポット回収', '残置物の整理', '建設系廃棄物は発生工程により産業廃棄物扱いになることの確認'),
            'items' => array('木くず・廃プラスチック・金属くず', '石膏ボード・混合廃棄物', '店舗改装時の什器・残置物', '梱包材・発泡スチロール', '注意が必要：建設系廃棄物は発生工程・排出事業者・処理委託契約の確認が重要です'),
            'related' => array('難処理物・特殊廃棄物' => '/difficult-waste.html', '石膏ボード相談' => '/column/service/plasterboard-disposal/', '木パレット回収' => '/column/service/wooden-pallet-collection/'),
            'faq' => array(
                '現場単位のスポット相談はできますか？' => '可能です。所在地、品目、量、搬出条件、希望日をお知らせください。',
                '石膏ボードや混合廃棄物も相談できますか？' => 'はい。処理区分や受け入れ条件を確認し、協力業者との調整可否を確認します。',
                '残置物と工事廃材をまとめて相談できますか？' => '相談窓口は一本化できます。実際の処理は品目や許可範囲に応じて整理します。',
                'マニフェストや委託契約書も必要ですか？' => '産業廃棄物に該当する場合は、法令に沿った契約・マニフェスト管理が必要です。',
                'リノバトの役割は何ですか？' => 'リノバトは許可を持つ協力業者と連携し、処理先の調整と手配をサポートします。',
            ),
        ),
        'funeral' => array(
            'label' => '葬儀社様',
            'title' => '葬儀社向け遺品整理・不用品回収の相談',
            'seo_title' => '葬儀社向け遺品整理・不用品回収の相談｜ご遺族対応後の片付け手配ならリノバト',
            'description' => '葬儀社様向けに、ご遺族から相談される遺品整理、不用品回収、家財整理の協力業者手配をサポート。地域の許可業者と連携し、相談窓口として対応します。',
            'lead' => '葬儀後にご遺族から遺品整理・家財整理・不用品回収について相談を受けた際、リノバトが相談窓口として地域の許可を持つ協力業者との手配をサポートします。',
            'keywords' => '葬儀社 遺品整理,遺品整理 業者紹介,葬儀後 片付け,不用品回収 遺品整理,家財整理 相談',
            'troubles' => array('ご遺族から片付け先を相談される', '一軒家・マンションの家財整理が必要', '急ぎで対応可否を確認したい', '地域の許可業者と連携できる窓口がほしい', '紹介先として安心できる相談先を用意したい'),
            'consults' => array('葬儀後の遺品整理相談', 'ご遺族からの紹介案件', '一軒家・マンションの家財整理', '大型家具・家電・生活用品の片付け', '急ぎ対応可否の確認', '地域の許可業者との連携'),
            'items' => array('家具・家電・衣類・生活用品', '思い出品・仕分けが必要な家財', '大型不用品・粗大ごみ相当品', '空き家整理・実家の片付け', '注意が必要：一般家庭の不用品は地域の一般廃棄物許可が関係します'),
            'related' => array('個人向け不用品回収' => '/service/personal-junk-removal/', '残置物撤去の相談' => '/column/service/corporate-remaining-items-removal/', '対応エリア' => '/area.html'),
            'faq' => array(
                '葬儀社からご遺族を紹介してもよいですか？' => 'はい。紹介方法や連絡の流れも含めて調整できます。',
                '遺品整理の専門業者と連携できますか？' => '案件内容と地域に応じて、対応可能な協力業者との連携可否を確認します。',
                '急ぎの片付けも相談できますか？' => '可能です。希望日、量、所在地を確認したうえで調整します。',
                '見積もりに立ち会いは必要ですか？' => '写真で概算確認できる場合もありますが、量や搬出条件により現地確認が必要な場合があります。',
                'リノバトの役割は何ですか？' => '地域の許可を持つ協力業者と連携し、相談窓口として回収手配をサポートします。',
            ),
        ),
        'recycle-shop' => array(
            'label' => 'リサイクル会社・買取業者様',
            'title' => 'リサイクル会社・買取業者向け処分相談',
            'seo_title' => 'リサイクル会社・買取業者向け処分相談｜買取できない商品の廃棄・回収手配ならリノバト',
            'description' => 'リサイクル会社・買取業者様向けに、買取不可品、在庫処分、壊れた商品、処分が必要な不用品の回収手配をサポート。協力業者と連携し、処理先の調整を行います。',
            'lead' => '買取できない商品、壊れた家具・家電、在庫処分、店舗片付けなど、リユース不可品の処理先に困ったときの相談窓口としてサポートします。',
            'keywords' => 'リサイクルショップ 処分,買取不可 処分,買取できない 商品 処分,在庫処分 回収,不用品回収 協業',
            'troubles' => array('買取不可品の処分先を探している', '壊れた家具・家電が溜まっている', '在庫処分や店舗片付けを相談したい', '協業・紹介先として廃棄物の相談窓口がほしい', '処理先の調整を一本化したい'),
            'consults' => array('買取できない商品の処分', '壊れた家具・家電', '在庫処分・滞留品の整理', '店舗の片付け', 'リユース不可品の処理相談', '協業・紹介案件の相談'),
            'items' => array('家具・家電・雑貨・什器', '在庫品・期限切れ商品', '廃プラスチック・金属・木くず', '店舗片付け時の不用品', '注意が必要：家電リサイクル対象品や産業廃棄物は区分確認が必要です'),
            'related' => array('法人向け不用品回収' => '/service/business-junk-removal/', '難処理物・特殊廃棄物' => '/difficult-waste.html', '有価物と廃棄物の違い' => '/column/service/waste-and-valuable-resources/'),
            'faq' => array(
                '買取できない商品だけ相談できますか？' => 'はい。リユース不可品や壊れた商品の処理手配について相談できます。',
                '協業や紹介案件も相談できますか？' => '可能です。紹介元様との連絡方法や対応範囲も含めて調整します。',
                '在庫処分のスポット回収も相談できますか？' => '可能です。品目、数量、保管状況、搬出条件を確認します。',
                '有価物になるか廃棄物になるか分からない場合は？' => '状態・量・市況・処理ルートにより変わるため、条件を整理して確認します。',
                'リノバトの役割は何ですか？' => 'リノバトは収集運搬・処分を自社で行う会社ではありません。許可を持つ協力業者と連携し、処理先の調整をサポートします。',
            ),
        ),
    );
}

function rip_parent_page() {
    return array(
        'title' => '業種別 廃棄物・不用品回収のご相談',
        'seo_title' => '業種別 廃棄物・不用品回収のご相談｜紹介・協業相談ならリノバト',
        'description' => '不動産会社、医療・介護関係者、工務店、解体業者、葬儀社、リサイクル会社など、廃棄物や不用品の相談が発生しやすい事業者様向けに、許可を持つ協力業者と連携して回収手配・処理手配をサポートします。',
    );
}

function rip_header($title, $description, $canonical, $keywords = '') {
    $conversion_description = $description . ' 所在地・品目・量をもとに、回収・処理の進め方を無料で診断します。';
    return '<!doctype html><html lang="ja"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">' .
        '<title>' . esc_html($title) . '</title><meta name="description" content="' . esc_attr($conversion_description) . '">' .
        '<meta name="robots" content="index,follow"><link rel="canonical" href="' . esc_url($canonical) . '">' .
        ($keywords ? '<meta name="keywords" content="' . esc_attr($keywords) . '">' : '') .
        '<meta property="og:type" content="article"><meta property="og:title" content="' . esc_attr($title) . '"><meta property="og:description" content="' . esc_attr($conversion_description) . '"><meta property="og:url" content="' . esc_url($canonical) . '">' .
        '<style>' . rip_css() . '</style></head><body><header class="rip-header"><div class="rip-wrap rip-head"><a class="rip-logo" href="/">RENOVAT</a><nav><a href="/">トップ</a><a href="/industry/">業種別</a><a href="/business-waste.html">事業系ごみ</a><a href="/area.html">対応エリア</a><a class="rip-header-cta" data-rip-cta="header" href="/contact.html?utm_source=industry&utm_medium=organic&utm_campaign=free_diagnosis&utm_content=header#form">無料診断</a></nav></div></header>';
}

function rip_footer() {
    return '<footer class="rip-footer"><div class="rip-wrap rip-foot"><div><strong>株式会社リノバト</strong><br>〒503-1278 岐阜県養老郡養老町横屋129番地<br>電話：<a href="tel:' . RIP_TEL . '">' . RIP_PHONE . '</a><br>メール：<a href="mailto:' . RIP_EMAIL . '">' . RIP_EMAIL . '</a></div><nav><a href="/">トップ</a><a href="/industry/">業種別のご相談</a><a href="/company.html">会社概要</a><a href="/contact.html#form">お問い合わせ</a><a href="/legal/">特定商取引法に基づく表記</a><a href="/privacy-policy/">プライバシーポリシー</a><a href="/terms/">利用規約</a></nav></div></footer><script>document.addEventListener("click",function(e){var a=e.target.closest("a[href^=\'tel:\']");if(a&&typeof gtag==="function")gtag("event","phone_click",{link_url:a.href,phone_number:"' . RIP_PHONE . '"});});</script>' . rip_tracking_script() . '</body></html>';
}

function rip_cta($class = '') {
    $placement = $class ? $class : 'inline';
    return '<section class="rip-cta ' . esc_attr($class) . '"><p class="rip-cta-kicker">法人・紹介案件のご相談に対応</p><h2>回収・処理の進め方を無料で診断します</h2><p>所在地・品目・量が分かれば、写真だけでも概算相談がしやすくなります。許可を持つ協力業者と連携し、回収手配・処理手配・窓口一本化をサポートします。</p><ul class="rip-cta-points"><li>相談・診断は無料</li><li>写真があれば概算相談がスムーズ</li><li>許可を持つ協力業者と連携</li></ul><div class="rip-actions"><a class="rip-btn" data-rip-cta="' . esc_attr($placement) . '" href="/contact.html?utm_source=industry&utm_medium=organic&utm_campaign=free_diagnosis&utm_content=' . rawurlencode($placement) . '#form">無料診断を依頼する</a><a class="rip-phone" data-rip-phone="' . esc_attr($placement) . '" href="tel:' . RIP_TEL . '">電話で状況を相談する</a></div></section>';
}

function rip_mobile_cta() {
    return '<aside class="rip-mobile-cta" aria-label="無料診断への導線"><a data-rip-cta="mobile_sticky" href="/contact.html?utm_source=industry&utm_medium=organic&utm_campaign=free_diagnosis&utm_content=mobile_sticky#form">無料診断を依頼</a><a data-rip-phone="mobile_sticky" href="tel:' . RIP_TEL . '">電話で相談</a></aside><style>.rip-cta-kicker{margin:0 0 4px;font-size:14px;font-weight:800;color:#9ff0d4}.rip-cta-points{display:flex;flex-wrap:wrap;gap:8px 16px;margin:16px 0;padding:0;list-style:none;font-size:14px}.rip-cta-points li:before{content:"✓ ";font-weight:900;color:#9ff0d4}.rip-mobile-cta{display:none}@media(max-width:760px){body{padding-bottom:70px}.rip-mobile-cta{position:fixed;bottom:0;left:0;right:0;z-index:99;display:grid;grid-template-columns:1.2fr 1fr;gap:8px;padding:9px 12px;background:#fff;box-shadow:0 -4px 16px rgba(16,36,31,.18)}.rip-mobile-cta a{display:flex;align-items:center;justify-content:center;min-height:46px;border-radius:8px;font-weight:800;text-decoration:none}.rip-mobile-cta a:first-child{background:#08785f;color:#fff}.rip-mobile-cta a:last-child{border:2px solid #08785f;color:#08785f}}</style>';
}

function rip_tracking_script() {
    return '<script>(function(){var source=new URLSearchParams(window.location.search);var params=["gclid","gbraid","wbraid","utm_source","utm_medium","utm_campaign","utm_term","utm_content"];document.querySelectorAll("[data-rip-cta]").forEach(function(a){var destination=new URL(a.href,window.location.origin);params.forEach(function(name){if(source.get(name))destination.searchParams.set(name,source.get(name));});if(source.get("gclid")||source.get("gbraid")||source.get("wbraid")){destination.searchParams.set("utm_source","google");destination.searchParams.set("utm_medium","cpc");}a.href=destination.toString();});function track(name,el){if(typeof window.gtag!=="function")return;window.gtag("event",name,{event_category:"lead_generation",cta_placement:el.getAttribute("data-rip-cta")||el.getAttribute("data-rip-phone")||"unknown",page_location:window.location.href});}document.addEventListener("click",function(e){var c=e.target.closest("[data-rip-cta]");if(c)track("free_diagnosis_cta_click",c);var p=e.target.closest("[data-rip-phone]");if(p)track("phone_cta_click",p);});})();</script>';
}

function rip_page_html($slug, $p) {
    $canonical = 'https://renovat.jp/industry/' . $slug . '/';
    $html = rip_header($p['seo_title'], $p['description'], $canonical, $p['keywords']);
    $html .= '<main class="rip-wrap"><section class="rip-hero"><p class="rip-eyebrow">業種別のご相談</p><h1>' . esc_html($p['title']) . '</h1><p>' . esc_html($p['lead']) . '</p><div class="rip-visual" aria-label="' . esc_attr($p['label'] . '向けの廃棄物・不用品回収手配相談') . '"><span>相談</span><span>選定</span><span>手配</span></div></section>';
    $html .= rip_cta('rip-cta-top');
    $html .= '<section><h2>このようなお悩みはありませんか</h2><ul class="rip-check">' . rip_li($p['troubles']) . '</ul></section>';
    $html .= '<section><h2>業種別によくある相談内容</h2><div class="rip-grid">' . rip_cards($p['consults']) . '</div></section>';
    $html .= '<section><h2>リノバトがサポートできること</h2><ul class="rip-check"><li>許可を持つ協力業者の選定</li><li>回収手配・処理手配</li><li>処理先の調整</li><li>複数案件の窓口一本化</li><li>写真・所在地・数量をもとにした相談整理</li><li>紹介案件・協業相談の受付</li></ul></section>';
    $html .= rip_cta('rip-cta-mid');
    $html .= '<section><h2>相談から手配までの流れ</h2><ol class="rip-flow"><li><strong>無料相談</strong><br>所在地、品目、量、写真、希望時期を分かる範囲で確認します。</li><li><strong>区分・条件の整理</strong><br>一般廃棄物、産業廃棄物、資源物などの可能性を整理します。</li><li><strong>協力業者の選定</strong><br>地域と品目に応じて、許可を持つ協力業者との連携可否を確認します。</li><li><strong>見積り・日程調整</strong><br>費用、回収条件、搬出条件、必要書類を確認します。</li><li><strong>回収手配・処理手配</strong><br>リノバトが窓口として連絡調整をサポートします。</li></ol></section>';
    $html .= '<section><h2>対応できるもの・注意が必要なもの</h2><table class="rip-table"><tbody>' . rip_table_rows($p['items']) . '</tbody></table><p class="rip-note"><strong>重要：</strong>リノバトは自社で収集運搬・処分を行う会社ではありません。一般家庭の不用品回収・遺品整理・家財整理は、一般廃棄物の許可が関係する可能性があります。地域の許可を持つ協力業者と連携し、相談窓口として回収手配をサポートします。</p></section>';
    $html .= '<section><h2>よくある質問</h2><div class="rip-faq">' . rip_faq($p['faq']) . '</div></section>';
    $html .= '<section><h2>関連サービス</h2><ul class="rip-links">' . rip_links(array_merge($p['related'], rip_common_links())) . '</ul></section>';
    $html .= rip_cta('rip-cta-bottom');
    $html .= '</main>' . rip_faq_schema($p['faq']) . rip_mobile_cta() . rip_footer();
    return $html;
}

function rip_parent_html() {
    $p = rip_parent_page();
    $pages = rip_pages();
    $html = rip_header($p['seo_title'], $p['description'], 'https://renovat.jp/industry/');
    $html .= '<main class="rip-wrap"><section class="rip-hero"><p class="rip-eyebrow">Industry Support</p><h1>' . esc_html($p['title']) . '</h1><p>' . esc_html($p['description']) . '</p></section>';
    $html .= rip_cta('rip-cta-top');
    $html .= '<section><h2>業種別のご相談</h2><div class="rip-industry-cards">';
    foreach ($pages as $slug => $page) {
        $html .= '<a class="rip-industry-card" href="/industry/' . esc_attr($slug) . '/"><span>' . esc_html($page['label']) . '</span><strong>' . esc_html($page['title']) . '</strong><small>' . esc_html($page['description']) . '</small></a>';
    }
    $html .= '</div></section><section><h2>リノバトの役割</h2><p>株式会社リノバトは、自社で収集運搬・処分を行う会社ではありません。廃棄物・不用品・残置物・遺品整理・廃材処分などの相談に対し、許可を持つ協力業者と連携し、回収手配・処理手配・窓口一本化をサポートします。</p></section></main>' . rip_mobile_cta() . rip_footer();
    return $html;
}

function rip_li($items) {
    $out = '';
    foreach ($items as $item) $out .= '<li>' . esc_html($item) . '</li>';
    return $out;
}

function rip_cards($items) {
    $out = '';
    foreach ($items as $item) $out .= '<div class="rip-card">' . esc_html($item) . '</div>';
    return $out;
}

function rip_table_rows($items) {
    $out = '';
    foreach ($items as $item) {
        $parts = explode('：', $item, 2);
        if (isset($parts[1])) {
            $out .= '<tr><th>' . esc_html($parts[0]) . '</th><td>' . esc_html($parts[1]) . '</td></tr>';
        } else {
            $out .= '<tr><th>相談できる品目</th><td>' . esc_html($item) . '</td></tr>';
        }
    }
    return $out;
}

function rip_faq($faq) {
    $out = '';
    foreach ($faq as $q => $a) $out .= '<details><summary>' . esc_html($q) . '</summary><p>' . esc_html($a) . '</p></details>';
    return $out;
}

function rip_links($links) {
    $out = '';
    foreach ($links as $label => $url) $out .= '<li><a href="' . esc_url($url) . '">' . esc_html($label) . '</a></li>';
    return $out;
}

function rip_faq_schema($faq) {
    $entities = array();
    foreach ($faq as $q => $a) $entities[] = array('@type' => 'Question', 'name' => $q, 'acceptedAnswer' => array('@type' => 'Answer', 'text' => $a));
    return '<script type="application/ld+json">' . wp_json_encode(array('@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $entities), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

function rip_css() {
    return ':root{--g:#08785f;--d:#10241f;--t:#17231f;--m:#5a6a64;--bg:#f2faf6}*{box-sizing:border-box}body{margin:0;color:var(--t);font-family:-apple-system,BlinkMacSystemFont,"Segoe UI","Noto Sans JP","Hiragino Sans",Meiryo,sans-serif;line-height:1.85;background:#fff}a{color:var(--g)}.rip-wrap{width:min(1080px,calc(100% - 32px));margin:auto}.rip-header{background:#fff;border-bottom:1px solid #dfe9e5;position:sticky;top:0;z-index:10}.rip-head{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:14px 0}.rip-logo{font-weight:900;letter-spacing:.06em;color:var(--d);text-decoration:none}.rip-header nav,.rip-footer nav{display:flex;flex-wrap:wrap;gap:10px 16px}.rip-header nav a{text-decoration:none;color:var(--t);font-weight:700;font-size:14px}.rip-header nav .rip-header-cta{padding:7px 11px;border-radius:7px;background:var(--g);color:#fff}.rip-hero{padding:clamp(36px,7vw,76px) 0}.rip-eyebrow{color:var(--g);font-weight:800}.rip-hero h1{font-size:clamp(30px,5.5vw,52px);line-height:1.25;margin:.2em 0}.rip-hero p{font-size:18px;color:var(--m);max-width:840px}.rip-visual{margin-top:24px;display:flex;gap:10px;flex-wrap:wrap}.rip-visual span{padding:10px 16px;border-radius:999px;background:var(--bg);color:var(--g);font-weight:800}section{margin:0 0 56px}h2{font-size:clamp(24px,3vw,34px);line-height:1.35;color:var(--d)}.rip-check{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 24px}.rip-check li{padding-left:.2em}.rip-grid,.rip-industry-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px}.rip-card,.rip-industry-card{border:1px solid #d7e6df;border-radius:14px;background:#fff;padding:18px;box-shadow:0 8px 24px rgba(16,36,31,.06)}.rip-industry-card{text-decoration:none;color:var(--t);display:flex;flex-direction:column;gap:8px}.rip-industry-card span{color:var(--g);font-weight:800}.rip-industry-card strong{font-size:18px}.rip-industry-card small{color:var(--m);font-size:14px}.rip-cta{padding:clamp(22px,4vw,38px);border-radius:18px;background:var(--d);color:#fff}.rip-cta h2{color:#fff;margin-top:0}.rip-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:16px}.rip-btn,.rip-phone{display:inline-flex;align-items:center;justify-content:center;padding:13px 18px;border-radius:9px;text-decoration:none;font-weight:800}.rip-btn{background:var(--g);color:#fff}.rip-phone{background:#fff;color:var(--d);border:2px solid var(--g)}.rip-flow{display:grid;gap:12px}.rip-flow li{padding:16px;border-left:5px solid var(--g);background:var(--bg);border-radius:10px}.rip-table{width:100%;border-collapse:collapse;overflow:hidden;border-radius:12px}.rip-table th,.rip-table td{padding:14px;border:1px solid #d7e6df;text-align:left;vertical-align:top}.rip-table th{width:32%;background:var(--bg)}.rip-note{padding:16px;border-radius:12px;background:#fff7e8;border:1px solid #f0d6a8}.rip-faq details{padding:16px 0;border-bottom:1px solid #d7e6df}.rip-faq summary{cursor:pointer;font-weight:800}.rip-links{columns:2}.rip-footer{margin-top:64px;padding:38px 0 90px;background:var(--d);color:#dcebe6}.rip-footer a{color:#fff}.rip-foot{display:grid;grid-template-columns:1fr 1fr;gap:24px}@media(max-width:760px){.rip-head{align-items:flex-start;flex-direction:column}.rip-header{position:static}.rip-check{grid-template-columns:1fr}.rip-actions a{width:100%}.rip-table,.rip-table tbody,.rip-table tr,.rip-table th,.rip-table td{display:block}.rip-table th{width:100%;border-bottom:0}.rip-links{columns:1}.rip-foot{grid-template-columns:1fr}}';
}

function rip_write_file($path, $html, $label) {
    $dir = dirname($path);
    if (!wp_mkdir_p($dir)) return new WP_Error('mkdir', '保存先を作成できません: ' . $dir);
    $backup = rip_backup_file($path, $label);
    if (is_wp_error($backup)) return $backup;
    if (file_put_contents($path, $html, LOCK_EX) === false) return new WP_Error('write', 'ファイルを書き込めません: ' . $path);
    @chmod($path, 0644);
    return true;
}

function rip_home_section_html() {
    $pages = rip_pages();
    $html = "\n<!-- renovat-industry-section:start -->\n<section class=\"rips-home\" id=\"industry-consultation\"><div class=\"rips-home__inner\"><p class=\"rips-home__eyebrow\">Industry Support</p><h2>業種別のご相談</h2><p>不動産会社、医療・介護関係者、工務店、解体業者、葬儀社、リサイクル会社など、紹介・協業につながる廃棄物・不用品の相談窓口を用意しています。</p><div class=\"rips-home__cards\">";
    foreach ($pages as $slug => $page) {
        $html .= '<a href="/industry/' . esc_attr($slug) . '/"><span>' . esc_html($page['label']) . '</span><strong>' . esc_html($page['title']) . '</strong></a>';
    }
    $html .= '</div><div class="rips-home__actions"><a class="rips-home__btn" href="/industry/">業種別ページを見る</a><a class="rips-home__btn rips-home__btn--line" href="/contact.html#form">協業・紹介案件を相談する</a></div></div></section><style id="rips-home-css">.rips-home{padding:clamp(48px,7vw,86px) 16px;background:#f2faf6}.rips-home__inner{width:min(1120px,100%);margin:auto}.rips-home__eyebrow{color:#08785f;font-weight:800}.rips-home h2{font-size:clamp(28px,4vw,42px);line-height:1.3;color:#10241f}.rips-home__cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:14px;margin-top:24px}.rips-home__cards a{display:flex;flex-direction:column;gap:8px;padding:18px;border-radius:14px;background:#fff;border:1px solid #d7e6df;color:#17231f;text-decoration:none;box-shadow:0 8px 24px rgba(16,36,31,.06)}.rips-home__cards span{color:#08785f;font-weight:800}.rips-home__cards strong{line-height:1.5}.rips-home__actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:24px}.rips-home__btn{display:inline-flex;padding:13px 18px;border-radius:9px;background:#08785f;color:#fff!important;text-decoration:none;font-weight:800}.rips-home__btn--line{background:#fff;color:#08785f!important;border:2px solid #08785f}@media(max-width:680px){.rips-home__actions a{width:100%;justify-content:center}}</style>' . "\n<!-- renovat-industry-section:end -->\n";
    return $html;
}

function rip_update_home() {
    $index = rip_root_dir() . 'index.html';
    if (!is_readable($index) || !is_writable($index)) return new WP_Error('home', 'トップページ index.html を読み書きできません。');
    $html = file_get_contents($index);
    $section = rip_home_section_html();
    if (strpos($html, '<!-- renovat-industry-section:start -->') !== false) {
        $new = preg_replace('~<!-- renovat-industry-section:start -->.*?<!-- renovat-industry-section:end -->~is', $section, $html, 1);
    } elseif (strpos($html, '<section class="section quick-guide"') !== false) {
        $new = str_replace('<section class="section quick-guide"', $section . '<section class="section quick-guide"', $html);
    } elseif (strpos($html, '<section class="section section-alt discovery"') !== false) {
        $new = str_replace('<section class="section section-alt discovery"', $section . '<section class="section section-alt discovery"', $html);
    } elseif (stripos($html, '</main>') !== false) {
        $new = preg_replace('~</main>~i', $section . '</main>', $html, 1);
    } else {
        $new = str_ireplace('</body>', $section . '</body>', $html);
    }
    $new = rip_fix_static_phone_text($new);
    if ($new !== $html) {
        $backup = rip_backup_file($index, 'index-html');
        if (is_wp_error($backup)) return $backup;
        if (file_put_contents($index, $new, LOCK_EX) === false) return new WP_Error('home_write', 'トップページを書き込めません。');
    }
    return true;
}

function rip_home_needs_update() {
    $index = rip_root_dir() . 'index.html';
    if (!is_readable($index)) return true;
    $html = file_get_contents($index);
    if (!is_string($html) || $html === '') return true;
    if (strpos($html, '<!-- renovat-industry-section:start -->') === false) return true;
    if (strpos($html, '7月6日開通予定') !== false) return true;
    if (strpos($html, '電話は7月6日開通予定') !== false) return true;
    return false;
}

function rip_fix_static_phone_text($html) {
    if (!is_string($html) || $html === '') return $html;
    $phone_link = '<a href="tel:' . RIP_TEL . '">電話で相談 ' . RIP_PHONE . '</a>';
    $html = str_replace(
        array(
            '<span class="header-phone phone-pending" data-phone-open="ready">電話は7月6日開通予定</span>',
            '<span class="btn btn-phone phone-pending" data-phone-open="ready">電話は7月6日開通予定</span>',
            '<span class="btn btn-phone-light phone-pending" data-phone-open="ready">電話は7月6日開通予定</span>',
            '<span class="btn btn-primary phone-pending" data-phone-open="ready">電話 7月6日開通予定</span>',
            '<span class="phone-pending" data-phone-open="ready">7月6日開通予定</span>',
        ),
        array(
            '<a class="header-phone" href="tel:' . RIP_TEL . '">電話で相談 ' . RIP_PHONE . '</a>',
            '<a class="btn btn-phone" href="tel:' . RIP_TEL . '">電話で相談 ' . RIP_PHONE . '</a>',
            '<a class="btn btn-phone-light" href="tel:' . RIP_TEL . '">電話で相談 ' . RIP_PHONE . '</a>',
            '<a class="btn btn-primary" href="tel:' . RIP_TEL . '">電話で相談 ' . RIP_PHONE . '</a>',
            '<a href="tel:' . RIP_TEL . '">' . RIP_PHONE . '</a>',
        ),
        $html
    );
    return $html;
}

function rip_deploy() {
    $root = rip_root_dir();
    $result = rip_write_file($root . 'industry/index.html', rip_parent_html(), 'industry-index');
    if (is_wp_error($result)) return $result;
    foreach (rip_pages() as $slug => $page) {
        $result = rip_write_file($root . 'industry/' . $slug . '/index.html', rip_page_html($slug, $page), 'industry-' . $slug);
        if (is_wp_error($result)) return $result;
    }
    $result = rip_update_home();
    if (is_wp_error($result)) return $result;
    update_option('rip_deployed_at', current_time('mysql'), false);
    update_option('rip_version', RIP_VERSION, false);
    return true;
}

register_activation_hook(__FILE__, 'rip_deploy');

function rip_maybe_deploy() {
    if (!is_admin() || !current_user_can('manage_options')) return;
    if (get_option('rip_version') === RIP_VERSION && !rip_home_needs_update()) return;
    $result = rip_deploy();
    if (is_wp_error($result)) update_option('rip_last_error', $result->get_error_message(), false);
}
add_action('admin_init', 'rip_maybe_deploy', 20);

function rip_repair_home_on_shutdown() {
    if (!is_admin() || !current_user_can('manage_options')) return;
    if (!rip_home_needs_update()) return;
    $result = rip_update_home();
    if (is_wp_error($result)) update_option('rip_last_error', $result->get_error_message(), false);
}
add_action('shutdown', 'rip_repair_home_on_shutdown', 9999);

function rip_admin_menu() {
    add_management_page('リノバト業種別ページ', 'リノバト業種別ページ', 'manage_options', 'renovat-industry-pages', 'rip_admin_page');
}
add_action('admin_menu', 'rip_admin_menu');

function rip_admin_page() {
    if (!current_user_can('manage_options')) return;
    $result = null;
    if (isset($_POST['rip_deploy']) && check_admin_referer('rip_deploy')) $result = rip_deploy();
    echo '<div class="wrap"><h1>リノバト業種別ページ</h1>';
    if (is_wp_error($result)) echo '<div class="notice notice-error"><p>' . esc_html($result->get_error_message()) . '</p></div>';
    elseif ($result === true) echo '<div class="notice notice-success"><p>業種別ページとトップページ導線を反映しました。</p></div>';
    echo '<p>/industry/ 配下に業種別ページを作成し、トップページに「業種別のご相談」セクションを追加します。</p><ul>';
    echo '<li><a href="https://renovat.jp/industry/" target="_blank">https://renovat.jp/industry/</a></li>';
    foreach (rip_pages() as $slug => $page) echo '<li><a href="https://renovat.jp/industry/' . esc_attr($slug) . '/" target="_blank">https://renovat.jp/industry/' . esc_html($slug) . '/</a></li>';
    echo '</ul><form method="post">';
    wp_nonce_field('rip_deploy');
    echo '<p><button class="button button-primary" name="rip_deploy" value="1">業種別ページを再反映する</button></p></form>';
    echo '<p><strong>最終反映：</strong>' . esc_html(get_option('rip_deployed_at', '未反映')) . '</p>';
    $error = get_option('rip_last_error', '');
    if ($error) echo '<p><strong>直近エラー：</strong>' . esc_html($error) . '</p>';
    echo '</div>';
}
