<?php
/**
 * wbce_search - languages/TR.php
 * Türkçe
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Gelişmiş arama ayarları. WBCE CMS aramasının dizini, modülleri, düzenleri ve istatistikleri: operatörlerle tam metin arama, canlı öneriler, hedef sayfada sonuçların vurgulanması ve etiket bulutu.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Ara';
$SEARCH['SEARCH_HEADING']                    = 'Arama';
$SEARCH['RESULTS_FOR']                       = 'Sonuçlar:';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Sonuç yok',
    'one' => '%d sonuç',
    'other' => '%d sonuç',
];
$SEARCH['NO_RESULTS']                        = 'Sonuç bulunamadı.';
$SEARCH['ALL_WORDS']                         = 'Tüm kelimeler';
$SEARCH['ANY_WORDS']                         = 'Herhangi bir kelime';
$SEARCH['EXACT_MATCH']                       = 'Tam ifade';
$SEARCH['MATCH']                             = 'Arama modu';
$SEARCH['PAGES']                             = 'Sayfalar';
$SEARCH['TIPS_TITLE']                        = 'Arama ipuçları:';
$SEARCH['TIP_FEWER']                         = 'Daha az terim kullanın';
$SEARCH['TIP_OR']                            = 'VEYA araması:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'başkaTerim';
$SEARCH['TIP_NOT']                           = 'Hariç tut:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'hariç';
$SEARCH['TIP_PHRASE']                        = 'Tam ifade:';
$SEARCH['TIP_WILDCARD']                      = 'Joker karakter:';
$SEARCH['TIP_FUZZY']                         = 'Yazım hatalarını tolere et:';
$SEARCH['DID_YOU_MEAN']                      = 'Bunu mu demek istediniz:';
$SEARCH['SCOPE_TITLE']                       = 'Yalnızca başlık';
$SEARCH['SCOPE_CONTENT']                     = 'Yalnızca içerik';
$SEARCH['SEARCH_OR']                         = 'VEYA araması (en az bir terim)';
$SEARCH['AREAS_TITLE']                       = 'Konuya göre göz atın:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Sık arananlar:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'bir kez arandı',
    'other' => '%d kez arandı',
];
$SEARCH['HIT_CONTENT']                       = 'İçerik';
$SEARCH['HIT_KEYWORD']                       = 'Anahtar kelime';
$SEARCH['HIT_DESCRIPTION']                   = 'Açıklama';
$SEARCH['HIT_TITLE']                         = 'Başlık';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Joker karakter';
$SEARCH['LEGEND_FUZZY']                      = 'Yazım hatalarını tolere et';
$SEARCH['LEGEND_PHRASE']                     = 'Tam ifade';
$SEARCH['LEGEND_EXCLUDE']                    = 'Terimi hariç tut';
$SEARCH['LEGEND_OR']                         = 'Terimlerden biri';
$SEARCH['LEGEND_COMBINATION']                = 'Birleşim';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatörler';
$SEARCH['OP_EXCLUDE']                        = 'hariç';
$SEARCH['OP_WILDCARD']                       = 'joker';
$SEARCH['OP_TYPOS']                          = 'yazım hatası';
$SEARCH['OP_PHRASE']                         = 'ifade';
$SEARCH['OP_OR']                             = 'veya';
$SEARCH['EXAMPLE_WORD']                      = 'hardal';
$SEARCH['EXAMPLE_WORD2']                     = 'organik';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'acı';
$SEARCH['EXAMPLE_OR']                        = 'ketçap';
$SEARCH['EXAMPLE_PHRASE']                    = 'sarı hardal';
$SEARCH['EXAMPLE_PHRASE2']                   = 'mısırdan';
$SEARCH['LABEL_LEGEND']                      = 'Açıklama';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Terim sayfa içeriğinde bulundu';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Terim sayfanın anahtar kelimelerinde bulundu';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Terim sayfa açıklamasında bulundu';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Terim başlıkta bulundu';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Terim içerikte ve anahtar kelimelerde';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Terim içerikte ve açıklamada';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Terim anahtar kelimelerde ve açıklamada';
$SEARCH['LEGEND_HIT_ALL']                    = 'Terim üç alanın hepsinde';
$SEARCH['PAGE_PREV']                         = 'Önceki sayfa';
$SEARCH['PAGE_NEXT']                         = 'Sonraki sayfa';
$SEARCH['DROPLET_DESCRIPTION']               = 'En çok aranan terimlerin bulutu. Parametreler: max=20, min_count=1, desc=Etiket, active=true (false = gizli)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Genel bakış';
$SEARCH['MENU_MODULES']                      = 'Modüller';
$SEARCH['MENU_LAYOUT']                       = 'Düzen';
$SEARCH['MENU_SETTINGS']                     = 'Ayarlar';
$SEARCH['MENU_STATS']                        = 'İstatistikler';
$SEARCH['CRUMB_OVERVIEW']                    = 'Arama dizininin durumu ve bakımı';
$SEARCH['CRUMB_MODULES']                     = 'Arama dizinini hangi modüller besliyor';
$SEARCH['CRUMB_LAYOUT']                      = 'Sonuç sayfasının şablonu';
$SEARCH['CRUMB_SETTINGS']                    = 'Arama davranışı, canlı arama, etiket bulutu';
$SEARCH['CRUMB_STATS']                       = 'Ziyaretçiler ne arıyor';
$SEARCH['LEDE_OVERVIEW']                     = 'Arama dizininin ve web sitesindeki aramanın güncel durumu.';
$SEARCH['LEDE_MODULES']                      = 'Kurulu her modülün nasıl dizinlendiği. Tanımı olmayan modüller yalnızca sayfa başlığını katar.';
$SEARCH['LEDE_LAYOUT']                       = 'Arama sayfasının ve etiket bulutunun hangi düzeni ve stil dosyasını kullandığı. Birlikte gelen dosyalar ve şablondaki dosyalar değişmez; her zaman kendi kopyanızı düzenlersiniz.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Sonuç sayfası';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = '/search/ sayfasının düzeni';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Etiket bulutu';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = '[[wbce_search_tagcloud]] droplet\'inin düzeni';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Stil dosyası';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Sonuç sayfası ve etiket bulutu için';
$SEARCH['LAYOUT_CSS_LEDE']                   = '%1$s içindeki CSS burada görünür · "Düzenle" %2$s dosyasını oluşturur';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Stil dosyası yok';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'şablon tüm stilleri kendisi getirir';
$SEARCH['LAYOUT_ACTIVE']                     = 'etkin';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'kendi dosyanız';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = '"%s" şablonundan';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'birlikte gelen';
$SEARCH['LAYOUT_READONLY']                   = 'salt okunur';
$SEARCH['LAYOUT_MODIFIED']                   = 'değiştirildi: %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'şablon dosyası %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'birlikte gelen dosya %s';
$SEARCH['BTN_EDIT']                          = 'Düzenle';
$SEARCH['BTN_DELETE']                        = 'Sil';
$SEARCH['BTN_BACK']                          = 'Geri';
$SEARCH['BTN_SAVE_BACK']                     = 'Kaydet ve geri dön';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "%2\$s dosyasının kopyası olarak yeni bir %1\$s dosyası oluşturulacak.\n\nKopya düzenlenir ve etkin düzen olur; orijinal değişmez.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s zaten var. %2\$s içeriğiyle üzerine yazılıp düzenlensin mi?\n\n%1\$s dosyasının mevcut sürümünüz kaybolacak.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "%s silinsin mi?\n\nBu işlem geri alınamaz.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Etkin düzen: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s oluşturuldu';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s silindi';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Stil dosyası: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Puanlama, alıntılar, canlı arama ve etiket bulutu.';
$SEARCH['LEDE_STATS']                        = 'Etiket bulutu için kaydedilen arama terimleri (ilk 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Arama dizini';
$SEARCH['INDEX_BUILD']                       = 'Tamamen yeniden oluştur';
$SEARCH['INDEX_UPDATE']                      = 'Değişiklikleri güncelle';
$SEARCH['INDEX_CLEAR']                       = 'Dizini boşalt';
$SEARCH['ENTRIES']                           = 'Kayıtlar';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Dizin oluşturuldu — dizinlenecek bir şey yok.',
    'one' => 'Dizin oluşturuldu: %d kayıt.',
    'other' => 'Dizin oluşturuldu: %d kayıt.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Güncellenecek bir şey yok.',
    'one' => '%d kayıt güncellendi.',
    'other' => '%d kayıt güncellendi.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Dizin silindi.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Tüm dizin gerçekten silinsin mi?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Web sitesinde arama';
$SEARCH['LABEL_LAST_INDEXED']                = 'Son dizinleme';
$SEARCH['INDEX_BUILD_DESC']                  = '<b>Tüm</b> aranabilir bölümleri yeniden okur. Büyük sitelerde zaman alır.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Yalnızca değişen veya eksik bölümleri okur. Tam yeniden oluşturmadan daha hızlıdır.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Yalnızca değişen veya eksik bölümleri okur. Şu anda yapılacak bir şey yok.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Dizini boşaltır. Yeniden oluşturulana kadar arama hiçbir şey bulmaz.';
$SEARCH['LABEL_FRESHNESS']                   = 'Güncellik';
$SEARCH['FRESH_ALL']                         = '<b>Dizin güncel</b> — %d bölümün tamamı son değişiklikleriyle eşleşiyor.';
$SEARCH['FRESH_STALE']                       = '<b>%2$d bölümden %1$d</b> tanesi değişti veya eksik.';
$SEARCH['FRESH_NONE']                        = 'Henüz aranabilir bölüm yok.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Web sitesinde arama';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Ayarlar › Arama';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Herkese açık';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Kayıtlı';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Özel';
$SEARCH['SITE_SEARCH_NONE']                  = 'Kapalı';
$SEARCH['HINT_SITE_SEARCH']                  = 'Kimler arama yapabilir — arkasında hangi arama olursa olsun, sitedeki her arama kutusu için. <a href="%s">Ayarlar › Arama</a> altındaki ayarla aynıdır; "Kayıtlı" ve "Özel" ikisi de şu anlama gelir: yalnızca oturum açmış ziyaretçiler.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Web sitesindeki arama \"%s\" olarak ayarlansın mı?\n\nBu, tüm ziyaretçiler için sitenin \"Arama\" ayarını değiştirir.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Web sitesinde arama: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Diller';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Dil bilgisi yok';
$SEARCH['VIS_HIDDEN']                        = 'Gizli';
$SEARCH['VIS_PUBLIC']                        = 'Herkese açık';
$SEARCH['VIS_PRIVATE']                       = 'Özel';
$SEARCH['VIS_REGISTERED']                    = 'Kayıtlı';
$SEARCH['VIS_NONE']                          = 'Yok';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Düzen boş ve kaydedilmedi.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'search_custom.htt yazılamadı. Lütfen layouts klasörünün yazma izinlerini kontrol edin.';
$SEARCH['HINT_LAYOUT_SAVE']                  = '"AjaxSave" işaretliyken Kaydet ve Ctrl+S sayfayı yeniden yüklemeden kaydeder; "Kaydet ve geri dön" o zaman gizlenir.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'En az kelime uzunluğu';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Daha kısa kelimeler yok sayılır';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Başlık ağırlığı';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Başlıktaki eşleşmeler × katsayı';
$SEARCH['SET_MAX_EXCERPT']                   = 'En fazla alıntı uzunluğu';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Alıntı başına karakter';
$SEARCH['SET_HIGHLIGHT']                     = 'Vurgulama';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Arama terimlerini alıntıda vurgula';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Vurgulama etiketi';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Vurgulama için kullanılan HTML etiketi';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Sayfa başına sonuç';
$SEARCH['SET_AUTO_REINDEX']                  = 'Aramada otomatik yeniden dizinleme';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Her aramada eskimiş kayıtları sessizce günceller';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Etiket bulutunu göster';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Arama sayfasında. Droplet\'in kendi active=true/false parametresi vardır';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Aramaları kaydet';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Aramaları etiket bulutu ve istatistikler için kaydeder — kapatmak bulutu gizlemez';
$SEARCH['SET_AJAX_SUGGEST']                  = 'AJAX canlı arama';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Yazarken öneriler göster';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Hata ayıklama modu';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Her arama sonucunun altında teknik veriler göster (yalnızca yöneticiler)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Arama sayfası şablonu';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = '/search/ sayfasının gösterildiği ön yüz şablonu.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Sitenin varsayılan şablonu (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Arama';
$SEARCH['GROUP_DISPLAY']                     = 'Sonuçların gösterimi';
$SEARCH['GROUP_INDEX']                       = 'Dizin bakımı';
$SEARCH['GROUP_LIVE']                        = 'Canlı arama';
$SEARCH['GROUP_TAGCLOUD']                    = 'Etiket bulutu';
$SEARCH['GROUP_ADMIN']                       = 'Yönetim aracı';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Sonuç listesinin sayfa boyutu';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Dil filtresi';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Yalnızca ziyaretçinin dilindeki sayfaları göster (site varsayılanı: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Gelişmiş arama';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Arama formunda kapsam onay kutularını ve VEYA seçeneğini göster';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Arama başına en fazla bölüm';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Otomatik yeniden dizinleme sınırı (yük kontrolü)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Öneri kaynağı';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Karma önce başlık eşleşmelerini listeler, ardından metninde kelime geçen sayfalarla tamamlar';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'En fazla öneri';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Gösterilen öneri sayısı';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Önerilerde görseller';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Modül bir görsel dizinliyorsa öğenin görselini (katalog, haberler …) önerinin yanında gösterir';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'En fazla etiket';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Etiket bulutunda gösterilen terim sayısı';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'En az arama';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Bir terimin görünmesi için gereken en az arama sayısı';
$SEARCH['SET_NAV_STYLE']                     = 'Gezinme';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Üstte sekmeler veya solda simge çubuğu';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Önce başlıklar, tam metinden tamamlanır (önerilen)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Başlık + açıklama (hızlı)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Tam metin dizini (kapsamlı)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Üstte sekmeler';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Solda kenar çubuğu';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Uç nokta';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Arama sayfasında adı "string", type="search" veya sınıfı ws-input olan alanlarda otomatik algılanır.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Ayarlar kaydedildi.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Arama istatistikleri silindi.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Tüm istatistikler gerçekten silinsin mi?';
$SEARCH['STATS_DELETE']                      = 'İstatistikleri sil';
$SEARCH['STATS_TERM']                        = 'Arama terimi';
$SEARCH['STATS_COUNT']                       = 'Sayı';
$SEARCH['STATS_LAST']                        = 'Son arama';
$SEARCH['STATS_TERMS']                       = 'Terimler';
$SEARCH['STATS_SEARCHES']                    = 'Aramalar';
$SEARCH['STATS_SHOWING']                     = [
    'one' => '%d terimden ilk 100.',
    'other' => '%d terimden ilk 100.',
];
$SEARCH['STATS_EMPTY']                       = 'Henüz kaydedilmiş arama terimi yok.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Arandı, bulunamadı';
$SEARCH['HINT_STATS_MISSES']                 = 'Sonuç vermeyen tam aramalar — ziyaretçilerinizin beklediği ama bulamadığı içeriğe dair bir ipucu. Asla herkese açık gösterilmez.';
$SEARCH['STATS_QUERY']                       = 'Sorgu';
$SEARCH['STATS_MISSES_EMPTY']                = 'Sonuçsuz arama kaydedilmedi.';
$SEARCH['CARD_WORDS']                        = 'Kelime dizini';
$SEARCH['HINT_WORDS']                        = 'Büyük siteler için: tüm kelimelerin listesi; böylece bir aramanın artık tüm dizini okuması gerekmez. %s dizin kaydından itibaren otomatik oluşturulur.';
$SEARCH['WORDS_INACTIVE']                    = 'Etkin değil — site eşiğin altında (%2$s dizin kaydı, şu anda %1$s); normal arama yeterince hızlı.';
$SEARCH['WORDS_OFF']                         = 'Ayarlarda kapatıldı.';
$SEARCH['WORDS_BUILDING']                    = 'Oluşturuluyor';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Oluşturmaya devam et';
$SEARCH['MSG_WORDS_READY']                   = 'Kelime dizini tamamlandı.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Kelime dizini: %d kayıt hâlâ bekliyor — o zamana kadar normal arama kullanılır.',
    'other' => 'Kelime dizini: %d kayıt hâlâ bekliyor — o zamana kadar normal arama kullanılır.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Kullanımda — %d kelime kaydı.',
    'other' => 'Kullanımda — %d kelime kaydı.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Kelime dizini';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Otomatik: yalnızca site aşağıdaki eşiğe ulaştığında oluşturulur. Küçük sitelerin buna ihtiyacı yoktur.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Otomatik';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Her zaman açık';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Kapalı';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Kelime dizini eşiği';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Kelime dizininin otomatik oluşturulduğu dizinlenmiş kayıt (bölümler ve modül öğeleri) sayısı';
$SEARCH['BTN_DELETE_TERM']                   = 'Bu terimi kaldır';
$SEARCH['MSG_TERM_DELETED']                  = 'Terim kaldırıldı.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = '<b>%s</b> için yarı yapılandırma search.php\'den önceden dolduruldu — lütfen kontrol edip düzenleyin.';
$SEARCH['MSG_SEMI_SAVED']                    = '\'%s\' için yarı yapılandırma kaydedildi.';
$SEARCH['MSG_SEMI_DELETED']                  = '%s için yapılandırma ve dizin kayıtları silindi.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php oluşturuldu. Lütfen dizini yeniden oluşturun.';
$SEARCH['CONFIRM_MOD_DELETE']                = '%s için yapılandırma ve dizin kayıtları silinsin mi?';
$SEARCH['STATUS_SEMI']                       = 'Yarı yapılandırma';
$SEARCH['LABEL_GUIDE']                       = 'Bu modülün kılavuzunu göster';
$SEARCH['LABEL_TABLE_HINT']                  = 'Tablo seçin → sütunlar otomatik yüklenir';
$SEARCH['LABEL_TABLE_SELECT']                = 'Tablo seçin';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'WBCE sayfa çapası';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Yalnızca aranabilir sayfalar';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Tüm bölümler (içerik havuzu)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Yalnızca etkin kayıtlar (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Zaman denetimi (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Join\'ler (isteğe bağlı, en fazla 3) — ek tablolardan veri';
$SEARCH['LABEL_GENERATE_DEF']                = 'module_defs dosyası oluştur';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'search.php\'den';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Yapılandırmayı sil';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Metin sütunu yok';
$SEARCH['LABEL_ERROR']                       = 'Hata';
$SEARCH['LABEL_MODULE']                      = 'Modül';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Aranamaz';
$SEARCH['LABEL_HELP']                        = 'Yardım';
$SEARCH['BTN_CONFIGURE']                     = 'Yapılandır';
$SEARCH['BTN_CLOSE']                         = 'Kapat';
$SEARCH['DEF_GENERATED']                     = 'oluşturuldu';
$SEARCH['DEF_SHIPPED']                       = 'yerleşik';
$SEARCH['LABEL_KIND']                        = 'Tür';
$SEARCH['LABEL_INDEXING']                    = 'Dizinleme';
$SEARCH['LABEL_SECTIONS']                    = 'Bölümler';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrele …';
$SEARCH['MODULES_SHOWN']                     = '%2$d modülden %1$d tanesi gösteriliyor';
$SEARCH['KIND_PAGE']                         = 'Sayfa modülleri';
$SEARCH['KIND_SNIPPET']                      = 'Snippet\'ler';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtreler';
$SEARCH['KIND_TOOL']                         = 'Yönetim araçları';
$SEARCH['BADGE_PAGE']                        = 'Sayfa';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtre';
$SEARCH['BADGE_TOOL']                        = 'Araç';
$SEARCH['GROUP_DEF']                         = 'tanımlı';
$SEARCH['GROUP_OPEN']                        = 'eksik';
$SEARCH['GROUP_TITLE']                       = 'yalnızca sayfa başlığı';
$SEARCH['SOURCE_MODULE']                     = 'Modülden';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Yerleşik';
$SEARCH['SOURCE_GENERATED']                  = 'Yarı yapılandırma';
$SEARCH['SOURCE_SEMI']                       = 'Yarı yapılandırma – oluşturulmadı';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php bulundu';
$SEARCH['SOURCE_TITLE']                      = 'Yalnızca sayfa başlığı';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Modül kendi arama tanımını getirir (search_index.php) — burada düzenlenemez.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Bir PHP callback\'i ile dizinlenir — burada düzenlenemez.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'WBCE Search ile gelen tanım (module_defs/). Yarı yapılandırma önceliklidir.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Yarı yapılandırmadan oluşturulan tanım.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Yarı yapılandırma kaydedildi ancak henüz tanım oluşturulmadı.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Henüz tanım yok — modülün eski search.php dosyasından önceden doldurulabilir.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Tanım yok — dizin yalnızca sayfa başlığını içerir.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Sayfa bölümü yok — dizinlenecek bir şey yok.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Bu sayfa için arama kapalı';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Yerleşik tanım. Kaydetmek, önceliği olan bir yarı yapılandırma oluşturur.';
$SEARCH['LABEL_TABLE']                       = 'Tablo';
$SEARCH['LABEL_OWN_TABLES']                  = 'Bu modülün tabloları';
$SEARCH['LABEL_OTHER_TABLES']                = 'Diğer modül tabloları';
$SEARCH['HINT_TABLE']                        = 'Yalnızca section_id sütunu olan mod_* tabloları dizinlenebilir.';
$SEARCH['LABEL_ID_FIELD']                    = 'ID sütunu';
$SEARCH['LABEL_ITEM_KEY']                    = 'Öğe anahtarı';
$SEARCH['HINT_ITEM_KEY']                     = 'Öğe başına benzersiz anahtar (çoklu mod).';
$SEARCH['LABEL_TITLE_COL']                   = 'Başlık sütunu';
$SEARCH['LABEL_TEXT_COLS']                   = 'Metin sütunları';
$SEARCH['LABEL_LINK_COL']                    = 'Bağlantı sütunu';
$SEARCH['HINT_LINK_PREFIX']                  = 'İsteğe bağlı önek: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Görsel sütunu';
$SEARCH['HINT_IMAGE_PATH']                   = '/media altındaki yol; {item_id} gibi yer tutuculara izin verilir.';
$SEARCH['LABEL_NONE']                        = 'yok';
$SEARCH['LABEL_MODE']                        = 'Mod';
$SEARCH['MODE_SINGLE']                       = 'Tekli — bölüm başına bir kayıt';
$SEARCH['MODE_MULTI']                        = 'Çoklu — öğe başına bir kayıt';
$SEARCH['LABEL_INDEX_BASE']                  = 'Dizin temeli';
$SEARCH['LABEL_FILTER']                      = 'Filtre';
$SEARCH['LABEL_NO_JOIN']                     = 'join yok';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Lütfen geçerli bir modül tablosu seçin.';
$SEARCH['MSG_IMPORT_FAILED']                 = '%s modülünün search.php dosyasında kullanılabilir tablo bulunamadı.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Sayfa yok',
    'one' => '%d sayfa',
    'other' => '%d sayfa',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Kaydet';
$SEARCH['MSG_SECURITY_ERROR']                = 'Güvenlik denetimi başarısız oldu.';
$SEARCH['STATUS_ACTIVE']                     = 'Etkin';
$SEARCH['STATUS_INACTIVE']                   = 'Devre dışı';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'acaba','ama','ancak','artık','aslında','az','bana','bazı','belki','ben','beni',
    'benim','bile','bir','biri','birkaç','birşey','biz','bize','bizi','bizim','bu',
    'buna','bunda','bundan','bunu','bunun','çok','çünkü','da','daha','de','defa',
    'diye','eğer','en','gibi','göre','hem','hep','hepsi','her','hiç','için','ile',
    'ise','kadar','ki','kim','mı','mi','mu','mü','nasıl','ne','neden','nerde',
    'nerede','nereye','niye','niçin','o','olan','olarak','oldu','olduğu','olmak',
    'olması','on','ona','ondan','onlar','onları','onların','onu','onun','sadece',
    'sanki','sen','siz','şey','şu','şuna','şunu','tüm','ve','veya','ya','yani',
    'yok','zaten',
];
