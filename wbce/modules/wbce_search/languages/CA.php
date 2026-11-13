<?php
/**
 * wbce_search - languages/CA.php
 * Català
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Configuració avançada de la cerca. Índex, mòduls, dissenys i estadístiques de la cerca de WBCE CMS: cerca de text complet amb operadors, suggeriments en directe, ressaltat dels resultats a la pàgina de destinació i núvol d\'etiquetes.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Cerca';
$SEARCH['SEARCH_HEADING']                    = 'Cerca';
$SEARCH['RESULTS_FOR']                       = 'Resultats per a';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Cap resultat',
    'one' => '%d resultat',
    'other' => '%d resultats',
];
$SEARCH['NO_RESULTS']                        = 'No s\'ha trobat cap resultat.';
$SEARCH['ALL_WORDS']                         = 'Totes les paraules';
$SEARCH['ANY_WORDS']                         = 'Alguna paraula';
$SEARCH['EXACT_MATCH']                       = 'Frase exacta';
$SEARCH['MATCH']                             = 'Mode de cerca';
$SEARCH['PAGES']                             = 'Pàgines';
$SEARCH['TIPS_TITLE']                        = 'Consells de cerca:';
$SEARCH['TIP_FEWER']                         = 'Feu servir menys termes';
$SEARCH['TIP_OR']                            = 'Cerca O:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'altreTerme';
$SEARCH['TIP_NOT']                           = 'Excloure:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'excloure';
$SEARCH['TIP_PHRASE']                        = 'Frase exacta:';
$SEARCH['TIP_WILDCARD']                      = 'Comodí:';
$SEARCH['TIP_FUZZY']                         = 'Tolerar errors:';
$SEARCH['DID_YOU_MEAN']                      = 'Volíeu dir:';
$SEARCH['SCOPE_TITLE']                       = 'Només el títol';
$SEARCH['SCOPE_CONTENT']                     = 'Només el contingut';
$SEARCH['SEARCH_OR']                         = 'Cerca O (almenys un terme)';
$SEARCH['AREAS_TITLE']                       = 'Navega per tema:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Cerques freqüents:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'cercat una vegada',
    'other' => 'cercat %d vegades',
];
$SEARCH['HIT_CONTENT']                       = 'Contingut';
$SEARCH['HIT_KEYWORD']                       = 'Paraula clau';
$SEARCH['HIT_DESCRIPTION']                   = 'Descripció';
$SEARCH['HIT_TITLE']                         = 'Títol';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Comodí';
$SEARCH['LEGEND_FUZZY']                      = 'Tolerar errors';
$SEARCH['LEGEND_PHRASE']                     = 'Frase exacta';
$SEARCH['LEGEND_EXCLUDE']                    = 'Excloure un terme';
$SEARCH['LEGEND_OR']                         = 'Un o altre terme';
$SEARCH['LEGEND_COMBINATION']                = 'Combinació';
$SEARCH['LEGEND_OPERATORS']                  = 'Operadors';
$SEARCH['OP_EXCLUDE']                        = 'excloure';
$SEARCH['OP_WILDCARD']                       = 'comodí';
$SEARCH['OP_TYPOS']                          = 'errors';
$SEARCH['OP_PHRASE']                         = 'frase';
$SEARCH['OP_OR']                             = 'o';
$SEARCH['EXAMPLE_WORD']                      = 'mostassa';
$SEARCH['EXAMPLE_WORD2']                     = 'ecològica';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'picant';
$SEARCH['EXAMPLE_OR']                        = 'quetxup';
$SEARCH['EXAMPLE_PHRASE']                    = 'mostassa groga';
$SEARCH['EXAMPLE_PHRASE2']                   = 'de blat de moro';
$SEARCH['LABEL_LEGEND']                      = 'Llegenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Terme trobat al contingut de la pàgina';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Terme trobat a les paraules clau de la pàgina';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Terme trobat a la descripció de la pàgina';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Terme trobat al títol';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Terme al contingut i a les paraules clau';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Terme al contingut i a la descripció';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Terme a les paraules clau i a la descripció';
$SEARCH['LEGEND_HIT_ALL']                    = 'Terme als tres camps';
$SEARCH['PAGE_PREV']                         = 'Pàgina anterior';
$SEARCH['PAGE_NEXT']                         = 'Pàgina següent';
$SEARCH['DROPLET_DESCRIPTION']               = 'Núvol dels termes més cercats. Paràmetres: max=20, min_count=1, desc=Etiqueta, active=true (false = amagat)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Resum';
$SEARCH['MENU_MODULES']                      = 'Mòduls';
$SEARCH['MENU_LAYOUT']                       = 'Disseny';
$SEARCH['MENU_SETTINGS']                     = 'Configuració';
$SEARCH['MENU_STATS']                        = 'Estadístiques';
$SEARCH['CRUMB_OVERVIEW']                    = 'Estat i manteniment de l\'índex de cerca';
$SEARCH['CRUMB_MODULES']                     = 'Quins mòduls alimenten l\'índex de cerca';
$SEARCH['CRUMB_LAYOUT']                      = 'Plantilla de la pàgina de resultats';
$SEARCH['CRUMB_SETTINGS']                    = 'Comportament de la cerca, cerca en directe, núvol d\'etiquetes';
$SEARCH['CRUMB_STATS']                       = 'Què cerquen els visitants';
$SEARCH['LEDE_OVERVIEW']                     = 'Estat actual de l\'índex de cerca i de la cerca al lloc web.';
$SEARCH['LEDE_MODULES']                      = 'Com s\'indexa cada mòdul instal·lat. Els mòduls sense definició només aporten el títol de la pàgina.';
$SEARCH['LEDE_LAYOUT']                       = 'Quin disseny i quin full d\'estil fan servir la pàgina de cerca i el núvol d\'etiquetes. Els fitxers inclosos i els de la plantilla no es modifiquen; sempre editeu la vostra pròpia còpia.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Pàgina de resultats';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Disseny de la pàgina /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Núvol d\'etiquetes';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Disseny del droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Full d\'estil';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Per a la pàgina de resultats i el núvol d\'etiquetes';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'El CSS de %1$s apareix aquí · "Edita" crea %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Sense full d\'estil';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'la plantilla porta tots els estils';
$SEARCH['LAYOUT_ACTIVE']                     = 'actiu';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'fitxer propi';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'de la plantilla "%s"';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'inclòs';
$SEARCH['LAYOUT_READONLY']                   = 'només lectura';
$SEARCH['LAYOUT_MODIFIED']                   = 'modificat %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'el fitxer de la plantilla %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'el fitxer inclòs %s';
$SEARCH['BTN_EDIT']                          = 'Edita';
$SEARCH['BTN_DELETE']                        = 'Elimina';
$SEARCH['BTN_BACK']                          = 'Torna';
$SEARCH['BTN_SAVE_BACK']                     = 'Desa i torna';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Es crearà un fitxer nou %1\$s com a còpia de %2\$s.\n\nLa còpia s'edita i esdevé el disseny actiu; l'original no canvia.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s ja existeix. Sobreescriure'l amb el contingut de %2\$s i editar-lo?\n\nEs perdrà la vostra versió actual de %1\$s.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Eliminar %s?\n\nAquesta acció no es pot desfer.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Disseny actiu: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s creat';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s eliminat';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Full d\'estil: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Puntuació, extractes, cerca en directe i núvol d\'etiquetes.';
$SEARCH['LEDE_STATS']                        = 'Termes de cerca registrats per al núvol d\'etiquetes (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Índex de cerca';
$SEARCH['INDEX_BUILD']                       = 'Reconstrucció completa';
$SEARCH['INDEX_UPDATE']                      = 'Actualitza els canvis';
$SEARCH['INDEX_CLEAR']                       = 'Buida l\'índex';
$SEARCH['ENTRIES']                           = 'Entrades';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Índex creat — res a indexar.',
    'one' => 'Índex creat: %d entrada.',
    'other' => 'Índex creat: %d entrades.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Res a actualitzar.',
    'one' => '%d entrada actualitzada.',
    'other' => '%d entrades actualitzades.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Índex eliminat.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Segur que voleu eliminar tot l\'índex?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Cerca al lloc web';
$SEARCH['LABEL_LAST_INDEXED']                = 'Darrera indexació';
$SEARCH['INDEX_BUILD_DESC']                  = 'Torna a llegir <b>totes</b> les seccions cercables. Triga en llocs grans.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Llegeix només les seccions modificades o que falten. Més ràpid que una reconstrucció completa.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Llegeix només les seccions modificades o que falten. Ara mateix no cal fer res.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Buida l\'índex. La cerca no troba res fins que es reconstrueixi.';
$SEARCH['LABEL_FRESHNESS']                   = 'Actualitat';
$SEARCH['FRESH_ALL']                         = '<b>L\'índex està al dia</b> — les %d seccions coincideixen amb el seu darrer canvi.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d de %2$d</b> seccions s\'han modificat o falten.';
$SEARCH['FRESH_NONE']                        = 'Encara no hi ha seccions cercables.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Cerca al lloc web';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Configuració › Cerca';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Pública';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registrats';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privada';
$SEARCH['SITE_SEARCH_NONE']                  = 'Desactivada';
$SEARCH['HINT_SITE_SEARCH']                  = 'Qui pot cercar — per a cada camp de cerca del lloc web, sigui quina sigui la cerca que hi ha darrere. La mateixa opció que a <a href="%s">Configuració › Cerca</a>; "Registrats" i "Privada" volen dir tots dos: només visitants que han iniciat sessió.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Establir la cerca al lloc web a \"%s\"?\n\nAixò canvia l'opció \"Cerca\" del lloc web per a tots els visitants.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Cerca al lloc web: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Idiomes';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Sense informació d\'idioma';
$SEARCH['VIS_HIDDEN']                        = 'Amagada';
$SEARCH['VIS_PUBLIC']                        = 'Pública';
$SEARCH['VIS_PRIVATE']                       = 'Privada';
$SEARCH['VIS_REGISTERED']                    = 'Registrats';
$SEARCH['VIS_NONE']                          = 'Cap';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'El disseny és buit i no s\'ha desat.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'No s\'ha pogut escriure search_custom.htt. Comproveu els permisos d\'escriptura de la carpeta layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Amb "AjaxSave" marcat, Desa i Ctrl+S desen sense recarregar la pàgina; aleshores "Desa i torna" s\'amaga.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Longitud mínima de paraula';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Les paraules més curtes s\'ignoren';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Pes del títol';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Coincidències al títol × factor';
$SEARCH['SET_MAX_EXCERPT']                   = 'Longitud màx. de l\'extracte';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Caràcters per extracte';
$SEARCH['SET_HIGHLIGHT']                     = 'Ressaltat';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Ressalta els termes cercats a l\'extracte';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Etiqueta de ressaltat';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Etiqueta HTML usada per al ressaltat';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Resultats per pàgina';
$SEARCH['SET_AUTO_REINDEX']                  = 'Reindexació automàtica en cercar';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Actualitza discretament les entrades obsoletes a cada cerca';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Mostra el núvol d\'etiquetes';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'A la pàgina de cerca. El droplet té el seu propi paràmetre active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Registra les cerques';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Registra les cerques per al núvol d\'etiquetes i les estadístiques — desactivar-ho no amaga el núvol';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Cerca en directe AJAX';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Mostra suggeriments mentre s\'escriu';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Mode de depuració';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Mostra dades tècniques sota cada resultat (només administradors)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Plantilla de la pàgina de cerca';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Plantilla del frontend on es mostra la pàgina /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Plantilla per defecte del lloc web (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Cerca';
$SEARCH['GROUP_DISPLAY']                     = 'Presentació dels resultats';
$SEARCH['GROUP_INDEX']                       = 'Manteniment de l\'índex';
$SEARCH['GROUP_LIVE']                        = 'Cerca en directe';
$SEARCH['GROUP_TAGCLOUD']                    = 'Núvol d\'etiquetes';
$SEARCH['GROUP_ADMIN']                       = 'Eina d\'administració';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Mida de pàgina de la llista de resultats';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Filtre d\'idioma';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Mostra només pàgines en l\'idioma del visitant (per defecte del lloc: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Cerca avançada';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Mostra al formulari les caselles d\'àmbit i l\'opció O';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Màx. seccions per cerca';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Límit de la reindexació automàtica (control de càrrega)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Origen dels suggeriments';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Híbrid mostra primer les coincidències de títol i completa amb pàgines que contenen la paraula al text';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Màx. suggeriments';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Nombre de suggeriments mostrats';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Imatges als suggeriments';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Mostra la imatge de l\'element (catàleg, notícies …) al costat del suggeriment, si el mòdul n\'indexa una';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Màx. etiquetes';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Nombre de termes mostrats al núvol';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Mín. cerques';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Nombre mínim de cerques abans que aparegui un terme';
$SEARCH['SET_NAV_STYLE']                     = 'Navegació';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Pestanyes a dalt o una barra d\'icones a l\'esquerra';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Primer títols, completats amb el text complet (recomanat)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Títol + descripció (ràpid)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Índex de text complet (exhaustiu)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Pestanyes a dalt';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Barra lateral a l\'esquerra';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpoint';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Es detecta automàticament a la pàgina de cerca per a camps amb el nom "string", type="search" o classe ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Configuració desada.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Estadístiques de cerca eliminades.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Segur que voleu eliminar totes les estadístiques?';
$SEARCH['STATS_DELETE']                      = 'Elimina les estadístiques';
$SEARCH['STATS_TERM']                        = 'Terme de cerca';
$SEARCH['STATS_COUNT']                       = 'Quantitat';
$SEARCH['STATS_LAST']                        = 'Darrera cerca';
$SEARCH['STATS_TERMS']                       = 'Termes';
$SEARCH['STATS_SEARCHES']                    = 'Cerques';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 de %d terme.',
    'other' => 'Top 100 de %d termes.',
];
$SEARCH['STATS_EMPTY']                       = 'Encara no s\'ha registrat cap terme de cerca.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Cercat, res trobat';
$SEARCH['HINT_STATS_MISSES']                 = 'Consultes completes sense resultat — una pista sobre continguts que els visitants esperen però no troben. No es mostra mai públicament.';
$SEARCH['STATS_QUERY']                       = 'Consulta';
$SEARCH['STATS_MISSES_EMPTY']                = 'No s\'ha registrat cap cerca sense resultat.';
$SEARCH['CARD_WORDS']                        = 'Índex de paraules';
$SEARCH['HINT_WORDS']                        = 'Per a llocs grans: una llista de totes les paraules, perquè una cerca ja no hagi de llegir tot l\'índex. Es crea automàticament a partir de %s entrades d\'índex.';
$SEARCH['WORDS_INACTIVE']                    = 'Inactiu — el lloc és per sota del llindar (%2$s entrades d\'índex, ara %1$s); la cerca normal és prou ràpida.';
$SEARCH['WORDS_OFF']                         = 'Desactivat a la configuració.';
$SEARCH['WORDS_BUILDING']                    = 'En construcció';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Continua la construcció';
$SEARCH['MSG_WORDS_READY']                   = 'Índex de paraules complet.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Índex de paraules: queda %d entrada pendent — fins aleshores es fa servir la cerca normal.',
    'other' => 'Índex de paraules: queden %d entrades pendents — fins aleshores es fa servir la cerca normal.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'En ús — %d entrada de paraula.',
    'other' => 'En ús — %d entrades de paraules.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Índex de paraules';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automàtic: només es crea quan el lloc arriba al llindar de sota. Els llocs petits no el necessiten.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automàtic';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Sempre actiu';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Desactivat';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Índex de paraules a partir de';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Nombre d\'entrades indexades (seccions i elements de mòduls) a partir del qual l\'índex de paraules es crea automàticament';
$SEARCH['BTN_DELETE_TERM']                   = 'Treu aquest terme';
$SEARCH['MSG_TERM_DELETED']                  = 'Terme tret.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semiconfiguració de <b>%s</b> preomplerta des de search.php — reviseu-la i ajusteu-la.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semiconfiguració de \'%s\' desada.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Configuració i entrades d\'índex de %s eliminades.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php generat. Reconstruïu l\'índex.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Eliminar la configuració i les entrades d\'índex de %s?';
$SEARCH['STATUS_SEMI']                       = 'Semiconfiguració';
$SEARCH['LABEL_GUIDE']                       = 'Mostra la guia d\'aquest mòdul';
$SEARCH['LABEL_TABLE_HINT']                  = 'Trieu la taula → les columnes es carreguen automàticament';
$SEARCH['LABEL_TABLE_SELECT']                = 'Trieu la taula';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Àncora de pàgina WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Només pàgines cercables';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Totes les seccions (fons de contingut)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Només entrades actives (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Control temporal (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (opcional, màx. 3) — dades de taules addicionals';
$SEARCH['LABEL_GENERATE_DEF']                = 'Genera el fitxer module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Des de search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Elimina la configuració';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Sense columnes de text';
$SEARCH['LABEL_ERROR']                       = 'Error';
$SEARCH['LABEL_MODULE']                      = 'Mòdul';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'No cercable';
$SEARCH['LABEL_HELP']                        = 'Ajuda';
$SEARCH['BTN_CONFIGURE']                     = 'Configura';
$SEARCH['BTN_CLOSE']                         = 'Tanca';
$SEARCH['DEF_GENERATED']                     = 'generada';
$SEARCH['DEF_SHIPPED']                       = 'integrada';
$SEARCH['LABEL_KIND']                        = 'Tipus';
$SEARCH['LABEL_INDEXING']                    = 'Indexació';
$SEARCH['LABEL_SECTIONS']                    = 'Seccions';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtra …';
$SEARCH['MODULES_SHOWN']                     = '%1$d de %2$d mòduls mostrats';
$SEARCH['KIND_PAGE']                         = 'Mòduls de pàgina';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtres';
$SEARCH['KIND_TOOL']                         = 'Eines d\'administració';
$SEARCH['BADGE_PAGE']                        = 'Pàgina';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtre';
$SEARCH['BADGE_TOOL']                        = 'Eina';
$SEARCH['GROUP_DEF']                         = 'amb definició';
$SEARCH['GROUP_OPEN']                        = 'incomplet';
$SEARCH['GROUP_TITLE']                       = 'només títol de pàgina';
$SEARCH['SOURCE_MODULE']                     = 'Del mòdul';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Integrada';
$SEARCH['SOURCE_GENERATED']                  = 'Semiconfiguració';
$SEARCH['SOURCE_SEMI']                       = 'Semiconfiguració – no generada';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php trobat';
$SEARCH['SOURCE_TITLE']                      = 'Només títol de pàgina';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'El mòdul porta la seva pròpia definició de cerca (search_index.php) — no es pot editar aquí.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indexat mitjançant un callback PHP — no es pot editar aquí.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definició inclosa amb WBCE Search (module_defs/). Una semiconfiguració hi té prioritat.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definició generada a partir de la semiconfiguració.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semiconfiguració desada, però encara sense definició generada.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Encara sense definició — es pot preomplir des de l\'antic search.php del mòdul.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Sense definició — l\'índex només conté el títol de la pàgina.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Sense seccions de pàgina — res a indexar.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Cerca desactivada per a aquesta pàgina';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Definició integrada. En desar es crea una semiconfiguració que hi té prioritat.';
$SEARCH['LABEL_TABLE']                       = 'Taula';
$SEARCH['LABEL_OWN_TABLES']                  = 'Taules d\'aquest mòdul';
$SEARCH['LABEL_OTHER_TABLES']                = 'Altres taules de mòduls';
$SEARCH['HINT_TABLE']                        = 'Només es poden indexar taules mod_* amb una columna section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Columna ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Clau d\'element';
$SEARCH['HINT_ITEM_KEY']                     = 'Clau única per element (mode multi).';
$SEARCH['LABEL_TITLE_COL']                   = 'Columna del títol';
$SEARCH['LABEL_TEXT_COLS']                   = 'Columnes de text';
$SEARCH['LABEL_LINK_COL']                    = 'Columna de l\'enllaç';
$SEARCH['HINT_LINK_PREFIX']                  = 'Prefix opcional: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Columna de la imatge';
$SEARCH['HINT_IMAGE_PATH']                   = 'Camí sota /media, es permeten marcadors com {item_id}.';
$SEARCH['LABEL_NONE']                        = 'cap';
$SEARCH['LABEL_MODE']                        = 'Mode';
$SEARCH['MODE_SINGLE']                       = 'Simple — una entrada per secció';
$SEARCH['MODE_MULTI']                        = 'Multi — una entrada per element';
$SEARCH['LABEL_INDEX_BASE']                  = 'Base de l\'índex';
$SEARCH['LABEL_FILTER']                      = 'Filtre';
$SEARCH['LABEL_NO_JOIN']                     = 'sense join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Trieu una taula de mòdul vàlida.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'No s\'ha trobat cap taula utilitzable al search.php de %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Cap pàgina',
    'one' => '%d pàgina',
    'other' => '%d pàgines',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Desa';
$SEARCH['MSG_SECURITY_ERROR']                = 'Ha fallat la comprovació de seguretat.';
$SEARCH['STATUS_ACTIVE']                     = 'Actiu';
$SEARCH['STATUS_INACTIVE']                   = 'Inactiu';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'a','al','als','amb','aquell','aquella','aquest','aquesta','aquests','aquí',
    'així','cap','com','d','de','del','dels','des','dins','el','ell','ella','elles',
    'ells','els','en','entre','era','és','esta','està','et','fa','fins','ha','han',
    'hi','i','jo','l','la','les','li','lo','més','me','mes','meu','meva','molt','n',
    'ni','no','nos','o','on','per','però','perquè','poc','que','què','qui','s','se',
    'sense','ser','seu','seva','si','sí','sobre','són','també','te','tot','tots',
    'tu','un','una','uns','unes','va','van','vosaltres','nosaltres',
];
