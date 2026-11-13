<?php
/**
 * wbce_search - languages/IT.php
 * Italiano
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Impostazioni avanzate della ricerca. Indice, moduli, layout e statistiche della ricerca di WBCE CMS: ricerca full-text con operatori, suggerimenti in tempo reale, evidenziazione dei risultati nella pagina di destinazione e nuvola di tag.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Cerca';
$SEARCH['SEARCH_HEADING']                    = 'Ricerca';
$SEARCH['RESULTS_FOR']                       = 'Risultati per';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Nessun risultato',
    'one' => '%d risultato',
    'other' => '%d risultati',
];
$SEARCH['NO_RESULTS']                        = 'Nessun risultato trovato.';
$SEARCH['ALL_WORDS']                         = 'Tutte le parole';
$SEARCH['ANY_WORDS']                         = 'Almeno una parola';
$SEARCH['EXACT_MATCH']                       = 'Frase esatta';
$SEARCH['MATCH']                             = 'Modalità di ricerca';
$SEARCH['PAGES']                             = 'Pagine';
$SEARCH['TIPS_TITLE']                        = 'Suggerimenti per la ricerca:';
$SEARCH['TIP_FEWER']                         = 'Usa meno termini';
$SEARCH['TIP_OR']                            = 'Ricerca OR:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'altroTermine';
$SEARCH['TIP_NOT']                           = 'Escludere:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'escludere';
$SEARCH['TIP_PHRASE']                        = 'Frase esatta:';
$SEARCH['TIP_WILDCARD']                      = 'Carattere jolly:';
$SEARCH['TIP_FUZZY']                         = 'Tollera errori di battitura:';
$SEARCH['DID_YOU_MEAN']                      = 'Forse cercavi:';
$SEARCH['SCOPE_TITLE']                       = 'Solo titolo';
$SEARCH['SCOPE_CONTENT']                     = 'Solo contenuto';
$SEARCH['SEARCH_OR']                         = 'Ricerca OR (almeno un termine)';
$SEARCH['AREAS_TITLE']                       = 'Sfoglia per argomento:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Ricerche frequenti:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'cercato una volta',
    'other' => 'cercato %d volte',
];
$SEARCH['HIT_CONTENT']                       = 'Contenuto';
$SEARCH['HIT_KEYWORD']                       = 'Parola chiave';
$SEARCH['HIT_DESCRIPTION']                   = 'Descrizione';
$SEARCH['HIT_TITLE']                         = 'Titolo';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Carattere jolly';
$SEARCH['LEGEND_FUZZY']                      = 'Tollera errori di battitura';
$SEARCH['LEGEND_PHRASE']                     = 'Frase esatta';
$SEARCH['LEGEND_EXCLUDE']                    = 'Escludi termine';
$SEARCH['LEGEND_OR']                         = 'Uno dei due termini';
$SEARCH['LEGEND_COMBINATION']                = 'Combinazione';
$SEARCH['LEGEND_OPERATORS']                  = 'Operatori';
$SEARCH['OP_EXCLUDE']                        = 'escludi';
$SEARCH['OP_WILDCARD']                       = 'jolly';
$SEARCH['OP_TYPOS']                          = 'refusi';
$SEARCH['OP_PHRASE']                         = 'frase';
$SEARCH['OP_OR']                             = 'o';
$SEARCH['EXAMPLE_WORD']                      = 'senape';
$SEARCH['EXAMPLE_WORD2']                     = 'biologica';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'piccante';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'senape gialla';
$SEARCH['EXAMPLE_PHRASE2']                   = 'di mais';
$SEARCH['LABEL_LEGEND']                      = 'Legenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Termine trovato nel contenuto della pagina';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Termine trovato nelle parole chiave della pagina';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Termine trovato nella descrizione della pagina';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Termine trovato nel titolo';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Termine nel contenuto e nelle parole chiave';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Termine nel contenuto e nella descrizione';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Termine nelle parole chiave e nella descrizione';
$SEARCH['LEGEND_HIT_ALL']                    = 'Termine in tutti e tre i campi';
$SEARCH['PAGE_PREV']                         = 'Pagina precedente';
$SEARCH['PAGE_NEXT']                         = 'Pagina successiva';
$SEARCH['DROPLET_DESCRIPTION']               = 'Nuvola dei termini più cercati. Parametri: max=20, min_count=1, desc=Etichetta, active=true (false = nascosta)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Panoramica';
$SEARCH['MENU_MODULES']                      = 'Moduli';
$SEARCH['MENU_LAYOUT']                       = 'Layout';
$SEARCH['MENU_SETTINGS']                     = 'Impostazioni';
$SEARCH['MENU_STATS']                        = 'Statistiche';
$SEARCH['CRUMB_OVERVIEW']                    = 'Stato e manutenzione dell\'indice di ricerca';
$SEARCH['CRUMB_MODULES']                     = 'Quali moduli alimentano l\'indice di ricerca';
$SEARCH['CRUMB_LAYOUT']                      = 'Modello della pagina dei risultati';
$SEARCH['CRUMB_SETTINGS']                    = 'Comportamento della ricerca, ricerca live, nuvola di tag';
$SEARCH['CRUMB_STATS']                       = 'Cosa cercano i visitatori';
$SEARCH['LEDE_OVERVIEW']                     = 'Stato attuale dell\'indice di ricerca e della ricerca sul sito.';
$SEARCH['LEDE_MODULES']                      = 'Come viene indicizzato ogni modulo installato. I moduli senza definizione contribuiscono solo con il titolo della pagina.';
$SEARCH['LEDE_LAYOUT']                       = 'Quale layout e quale foglio di stile usano la pagina di ricerca e la nuvola di tag. I file forniti e quelli del template restano invariati; modifichi sempre una tua copia.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Pagina dei risultati';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Layout della pagina /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Nuvola di tag';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Layout del droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Foglio di stile';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Per la pagina dei risultati e la nuvola di tag';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'I CSS di %1$s compaiono qui · "Modifica" crea %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Nessun foglio di stile';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'il template porta tutti gli stili da sé';
$SEARCH['LAYOUT_ACTIVE']                     = 'attivo';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'file proprio';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'dal template "%s"';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'fornito';
$SEARCH['LAYOUT_READONLY']                   = 'sola lettura';
$SEARCH['LAYOUT_MODIFIED']                   = 'modificato %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'il file del template %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'il file fornito %s';
$SEARCH['BTN_EDIT']                          = 'Modifica';
$SEARCH['BTN_DELETE']                        = 'Elimina';
$SEARCH['BTN_BACK']                          = 'Indietro';
$SEARCH['BTN_SAVE_BACK']                     = 'Salva e torna';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Verrà creato un nuovo file %1\$s come copia di %2\$s.\n\nLa copia viene modificata e diventa il layout attivo; l'originale resta invariato.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s esiste già. Sovrascriverlo con il contenuto di %2\$s e modificarlo?\n\nLa tua versione attuale di %1\$s andrà persa.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Eliminare %s?\n\nL'operazione non può essere annullata.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Layout attivo: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s creato';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s eliminato';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Foglio di stile: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Punteggio, estratti, ricerca live e nuvola di tag.';
$SEARCH['LEDE_STATS']                        = 'Termini di ricerca registrati per la nuvola di tag (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Indice di ricerca';
$SEARCH['INDEX_BUILD']                       = 'Ricostruzione completa';
$SEARCH['INDEX_UPDATE']                      = 'Aggiorna modifiche';
$SEARCH['INDEX_CLEAR']                       = 'Svuota indice';
$SEARCH['ENTRIES']                           = 'Voci';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Indice creato — niente da indicizzare.',
    'one' => 'Indice creato: %d voce.',
    'other' => 'Indice creato: %d voci.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Niente da aggiornare.',
    'one' => '%d voce aggiornata.',
    'other' => '%d voci aggiornate.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Indice eliminato.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Eliminare davvero l\'intero indice?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Ricerca sul sito';
$SEARCH['LABEL_LAST_INDEXED']                = 'Ultima indicizzazione';
$SEARCH['INDEX_BUILD_DESC']                  = 'Rilegge <b>tutte</b> le sezioni ricercabili. Richiede tempo sui siti grandi.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Rilegge solo le sezioni modificate o mancanti. Più veloce di una ricostruzione completa.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Rilegge solo le sezioni modificate o mancanti. Al momento non c\'è niente da fare.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Svuota l\'indice. La ricerca non trova nulla finché non viene ricostruito.';
$SEARCH['LABEL_FRESHNESS']                   = 'Aggiornamento';
$SEARCH['FRESH_ALL']                         = '<b>L\'indice è aggiornato</b> — tutte le %d sezioni corrispondono all\'ultima modifica.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d su %2$d</b> sezioni sono state modificate o mancano.';
$SEARCH['FRESH_NONE']                        = 'Ancora nessuna sezione ricercabile.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Ricerca sul sito';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Impostazioni › Ricerca';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Pubblica';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registrati';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privata';
$SEARCH['SITE_SEARCH_NONE']                  = 'Disattivata';
$SEARCH['HINT_SITE_SEARCH']                  = 'Chi può cercare — per ogni campo di ricerca del sito, qualunque ricerca ci sia dietro. La stessa impostazione di <a href="%s">Impostazioni › Ricerca</a>; "Registrati" e "Privata" significano entrambi: solo visitatori connessi.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Impostare la ricerca sul sito su \"%s\"?\n\nQuesto modifica l'impostazione \"Ricerca\" del sito per tutti i visitatori.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Ricerca sul sito: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Lingue';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Nessuna informazione sulla lingua';
$SEARCH['VIS_HIDDEN']                        = 'Nascosta';
$SEARCH['VIS_PUBLIC']                        = 'Pubblica';
$SEARCH['VIS_PRIVATE']                       = 'Privata';
$SEARCH['VIS_REGISTERED']                    = 'Registrati';
$SEARCH['VIS_NONE']                          = 'Nessuna';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Il layout è vuoto e non è stato salvato.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Impossibile scrivere search_custom.htt. Controlla i permessi di scrittura della cartella layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Con "AjaxSave" selezionato, Salva e Ctrl+S salvano senza ricaricare la pagina; "Salva e torna" viene allora nascosto.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Lunghezza minima delle parole';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Le parole più corte vengono ignorate';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Peso del titolo';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Corrispondenze nel titolo × fattore';
$SEARCH['SET_MAX_EXCERPT']                   = 'Lunghezza max. dell\'estratto';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Caratteri per estratto';
$SEARCH['SET_HIGHLIGHT']                     = 'Evidenziazione';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Evidenzia i termini cercati nell\'estratto';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Tag di evidenziazione';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Tag HTML usato per l\'evidenziazione';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Risultati per pagina';
$SEARCH['SET_AUTO_REINDEX']                  = 'Reindicizzazione automatica durante la ricerca';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Aggiorna silenziosamente le voci obsolete a ogni ricerca';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Mostra nuvola di tag';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Nella pagina di ricerca. Il droplet ha un proprio parametro active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Registra le ricerche';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Registra le ricerche per la nuvola di tag e le statistiche — disattivarlo non nasconde la nuvola';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Ricerca live AJAX';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Mostra suggerimenti durante la digitazione';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Modalità debug';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Mostra dati tecnici sotto ogni risultato (solo amministratori)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Template della pagina di ricerca';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Template del frontend in cui viene mostrata la pagina /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Template predefinito del sito (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Ricerca';
$SEARCH['GROUP_DISPLAY']                     = 'Visualizzazione dei risultati';
$SEARCH['GROUP_INDEX']                       = 'Manutenzione dell\'indice';
$SEARCH['GROUP_LIVE']                        = 'Ricerca live';
$SEARCH['GROUP_TAGCLOUD']                    = 'Nuvola di tag';
$SEARCH['GROUP_ADMIN']                       = 'Strumento di amministrazione';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Numero di risultati per pagina';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Filtro lingua';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Mostra solo pagine nella lingua del visitatore (predefinita del sito: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Ricerca avanzata';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Mostra nel modulo le caselle per l\'ambito e l\'opzione OR';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Max. sezioni per ricerca';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Limite per la reindicizzazione automatica (controllo del carico)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Fonte dei suggerimenti';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Ibrido elenca prima le corrispondenze nel titolo e completa con le pagine che contengono la parola nel testo';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Max. suggerimenti';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Numero di suggerimenti mostrati';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Immagini nei suggerimenti';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Mostra l\'immagine dell\'elemento (catalogo, notizie …) accanto al suggerimento, se il modulo ne indicizza una';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Max. tag';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Numero di termini mostrati nella nuvola';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Min. ricerche';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Numero minimo di ricerche prima che un termine compaia';
$SEARCH['SET_NAV_STYLE']                     = 'Navigazione';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Schede in alto o una barra di icone a sinistra';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Prima i titoli, completati dal testo completo (consigliato)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Titolo + descrizione (veloce)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Indice full-text (approfondito)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Schede in alto';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Barra laterale a sinistra';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpoint';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Rilevato automaticamente nella pagina di ricerca per i campi con nome "string", type="search" o classe ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Impostazioni salvate.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Statistiche di ricerca eliminate.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Eliminare davvero tutte le statistiche?';
$SEARCH['STATS_DELETE']                      = 'Elimina statistiche';
$SEARCH['STATS_TERM']                        = 'Termine di ricerca';
$SEARCH['STATS_COUNT']                       = 'Numero';
$SEARCH['STATS_LAST']                        = 'Ultima ricerca';
$SEARCH['STATS_TERMS']                       = 'Termini';
$SEARCH['STATS_SEARCHES']                    = 'Ricerche';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 di %d termine.',
    'other' => 'Top 100 di %d termini.',
];
$SEARCH['STATS_EMPTY']                       = 'Nessun termine di ricerca registrato.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Cercato, niente trovato';
$SEARCH['HINT_STATS_MISSES']                 = 'Ricerche complete senza risultati — un indizio sui contenuti che i visitatori si aspettano ma non trovano. Mai mostrato pubblicamente.';
$SEARCH['STATS_QUERY']                       = 'Ricerca';
$SEARCH['STATS_MISSES_EMPTY']                = 'Nessuna ricerca senza risultati registrata.';
$SEARCH['CARD_WORDS']                        = 'Indice delle parole';
$SEARCH['HINT_WORDS']                        = 'Per siti grandi: un elenco di tutte le parole, così una ricerca non deve più leggere l\'intero indice. Creato automaticamente da %s voci di indice in su.';
$SEARCH['WORDS_INACTIVE']                    = 'Non attivo — il sito è sotto la soglia (%2$s voci di indice, attualmente %1$s); la ricerca normale è abbastanza veloce.';
$SEARCH['WORDS_OFF']                         = 'Disattivato nelle impostazioni.';
$SEARCH['WORDS_BUILDING']                    = 'In costruzione';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Continua la costruzione';
$SEARCH['MSG_WORDS_READY']                   = 'Indice delle parole completo.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Indice delle parole: ancora %d voce in sospeso — fino ad allora si usa la ricerca normale.',
    'other' => 'Indice delle parole: ancora %d voci in sospeso — fino ad allora si usa la ricerca normale.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'In uso — %d voce di parola.',
    'other' => 'In uso — %d voci di parole.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Indice delle parole';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatico: creato solo quando il sito raggiunge la soglia indicata sotto. I siti piccoli non ne hanno bisogno.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatico';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Sempre attivo';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Disattivato';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Indice delle parole da';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Numero di voci indicizzate (sezioni ed elementi dei moduli) a partire dal quale l\'indice delle parole viene creato automaticamente';
$SEARCH['BTN_DELETE_TERM']                   = 'Rimuovi questo termine';
$SEARCH['MSG_TERM_DELETED']                  = 'Termine rimosso.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semi-configurazione per <b>%s</b> precompilata da search.php — verificala e adattala.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semi-configurazione per \'%s\' salvata.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Configurazione e voci di indice per %s eliminate.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php generato. Ricostruisci l\'indice.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Eliminare configurazione e voci di indice per %s?';
$SEARCH['STATUS_SEMI']                       = 'Semi-configurazione';
$SEARCH['LABEL_GUIDE']                       = 'Mostra la guida per questo modulo';
$SEARCH['LABEL_TABLE_HINT']                  = 'Scegli la tabella → le colonne si caricano automaticamente';
$SEARCH['LABEL_TABLE_SELECT']                = 'Scegli tabella';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Ancora di pagina WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Solo pagine ricercabili';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Tutte le sezioni (pool di contenuti)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Solo voci attive (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Controllo temporale (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Join (facoltativi, max. 3) — dati da tabelle aggiuntive';
$SEARCH['LABEL_GENERATE_DEF']                = 'Genera file module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Da search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Elimina configurazione';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Nessuna colonna di testo';
$SEARCH['LABEL_ERROR']                       = 'Errore';
$SEARCH['LABEL_MODULE']                      = 'Modulo';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Non ricercabile';
$SEARCH['LABEL_HELP']                        = 'Aiuto';
$SEARCH['BTN_CONFIGURE']                     = 'Configura';
$SEARCH['BTN_CLOSE']                         = 'Chiudi';
$SEARCH['DEF_GENERATED']                     = 'generata';
$SEARCH['DEF_SHIPPED']                       = 'integrata';
$SEARCH['LABEL_KIND']                        = 'Tipo';
$SEARCH['LABEL_INDEXING']                    = 'Indicizzazione';
$SEARCH['LABEL_SECTIONS']                    = 'Sezioni';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtra …';
$SEARCH['MODULES_SHOWN']                     = '%1$d di %2$d moduli mostrati';
$SEARCH['KIND_PAGE']                         = 'Moduli di pagina';
$SEARCH['KIND_SNIPPET']                      = 'Snippet';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtri';
$SEARCH['KIND_TOOL']                         = 'Strumenti di amministrazione';
$SEARCH['BADGE_PAGE']                        = 'Pagina';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtro';
$SEARCH['BADGE_TOOL']                        = 'Strumento';
$SEARCH['GROUP_DEF']                         = 'con definizione';
$SEARCH['GROUP_OPEN']                        = 'incompleto';
$SEARCH['GROUP_TITLE']                       = 'solo titolo della pagina';
$SEARCH['SOURCE_MODULE']                     = 'Dal modulo';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Integrata';
$SEARCH['SOURCE_GENERATED']                  = 'Semi-configurazione';
$SEARCH['SOURCE_SEMI']                       = 'Semi-configurazione – non generata';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php trovato';
$SEARCH['SOURCE_TITLE']                      = 'Solo titolo della pagina';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Il modulo fornisce una propria definizione di ricerca (search_index.php) — non modificabile qui.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indicizzato tramite un callback PHP — non modificabile qui.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definizione fornita con WBCE Search (module_defs/). Una semi-configurazione ha la precedenza.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definizione generata dalla semi-configurazione.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semi-configurazione salvata, ma nessuna definizione ancora generata.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Ancora nessuna definizione — può essere precompilata dal vecchio search.php del modulo.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Nessuna definizione — l\'indice contiene solo il titolo della pagina.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Nessuna sezione di pagina — niente da indicizzare.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Ricerca disattivata per questa pagina';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Definizione integrata. Salvando si crea una semi-configurazione che ha la precedenza.';
$SEARCH['LABEL_TABLE']                       = 'Tabella';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabelle di questo modulo';
$SEARCH['LABEL_OTHER_TABLES']                = 'Altre tabelle dei moduli';
$SEARCH['HINT_TABLE']                        = 'Si possono indicizzare solo tabelle mod_* con una colonna section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Colonna ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Chiave elemento';
$SEARCH['HINT_ITEM_KEY']                     = 'Chiave univoca per elemento (modalità multi).';
$SEARCH['LABEL_TITLE_COL']                   = 'Colonna titolo';
$SEARCH['LABEL_TEXT_COLS']                   = 'Colonne di testo';
$SEARCH['LABEL_LINK_COL']                    = 'Colonna link';
$SEARCH['HINT_LINK_PREFIX']                  = 'Prefisso facoltativo: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Colonna immagine';
$SEARCH['HINT_IMAGE_PATH']                   = 'Percorso sotto /media, segnaposti come {item_id} consentiti.';
$SEARCH['LABEL_NONE']                        = 'nessuna';
$SEARCH['LABEL_MODE']                        = 'Modalità';
$SEARCH['MODE_SINGLE']                       = 'Singola — una voce per sezione';
$SEARCH['MODE_MULTI']                        = 'Multi — una voce per elemento';
$SEARCH['LABEL_INDEX_BASE']                  = 'Base dell\'indice';
$SEARCH['LABEL_FILTER']                      = 'Filtro';
$SEARCH['LABEL_NO_JOIN']                     = 'nessun join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Scegli una tabella di modulo valida.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Nessuna tabella utilizzabile trovata nel search.php di %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Nessuna pagina',
    'one' => '%d pagina',
    'other' => '%d pagine',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Salva';
$SEARCH['MSG_SECURITY_ERROR']                = 'Controllo di sicurezza non riuscito.';
$SEARCH['STATUS_ACTIVE']                     = 'Attivo';
$SEARCH['STATUS_INACTIVE']                   = 'Inattivo';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'a','ad','agli','ai','al','alla','alle','allo','anche','avere','c','che','chi',
    'ci','come','con','cosa','così','cui','da','dagli','dai','dal','dalla','dalle',
    'dallo','degli','dei','del','della','delle','dello','di','dove','e','è','ed',
    'era','erano','essere','fa','gli','ha','hanno','ho','i','il','in','io','l','la',
    'le','lei','li','lo','loro','lui','ma','mi','mio','ne','negli','nei','nel',
    'nella','nelle','nello','noi','non','nostro','o','ogni','per','perché','più',
    'poi','quale','quando','quanto','quella','quelle','quelli','quello','questa',
    'queste','questi','questo','se','sei','si','sia','siamo','sono','su','sua',
    'sue','sugli','sui','sul','sulla','sulle','suo','suoi','te','ti','tra','tu',
    'tuo','un','una','uno','vi','voi',
];
