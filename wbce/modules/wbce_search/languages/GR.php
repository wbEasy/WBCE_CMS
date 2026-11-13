<?php
/**
 * wbce_search - languages/GR.php
 * Ελληνικά
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Προηγμένες ρυθμίσεις αναζήτησης. Ευρετήριο, ενότητες, διατάξεις και στατιστικά της αναζήτησης του WBCE CMS: αναζήτηση πλήρους κειμένου με τελεστές, προτάσεις σε πραγματικό χρόνο, επισήμανση αποτελεσμάτων στη σελίδα προορισμού και σύννεφο ετικετών.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Αναζήτηση';
$SEARCH['SEARCH_HEADING']                    = 'Αναζήτηση';
$SEARCH['RESULTS_FOR']                       = 'Αποτελέσματα για';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Κανένα αποτέλεσμα',
    'one' => '%d αποτέλεσμα',
    'other' => '%d αποτελέσματα',
];
$SEARCH['NO_RESULTS']                        = 'Δεν βρέθηκαν αποτελέσματα.';
$SEARCH['ALL_WORDS']                         = 'Όλες οι λέξεις';
$SEARCH['ANY_WORDS']                         = 'Οποιαδήποτε λέξη';
$SEARCH['EXACT_MATCH']                       = 'Ακριβής φράση';
$SEARCH['MATCH']                             = 'Τρόπος αναζήτησης';
$SEARCH['PAGES']                             = 'Σελίδες';
$SEARCH['TIPS_TITLE']                        = 'Συμβουλές αναζήτησης:';
$SEARCH['TIP_FEWER']                         = 'Χρησιμοποιήστε λιγότερους όρους';
$SEARCH['TIP_OR']                            = 'Αναζήτηση Ή:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'άλλοςΌρος';
$SEARCH['TIP_NOT']                           = 'Εξαίρεση:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'εξαίρεση';
$SEARCH['TIP_PHRASE']                        = 'Ακριβής φράση:';
$SEARCH['TIP_WILDCARD']                      = 'Μπαλαντέρ:';
$SEARCH['TIP_FUZZY']                         = 'Ανοχή σε τυπογραφικά λάθη:';
$SEARCH['DID_YOU_MEAN']                      = 'Μήπως εννοείτε:';
$SEARCH['SCOPE_TITLE']                       = 'Μόνο τίτλος';
$SEARCH['SCOPE_CONTENT']                     = 'Μόνο περιεχόμενο';
$SEARCH['SEARCH_OR']                         = 'Αναζήτηση Ή (τουλάχιστον ένας όρος)';
$SEARCH['AREAS_TITLE']                       = 'Περιήγηση ανά θέμα:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Συχνές αναζητήσεις:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'αναζητήθηκε μία φορά',
    'other' => 'αναζητήθηκε %d φορές',
];
$SEARCH['HIT_CONTENT']                       = 'Περιεχόμενο';
$SEARCH['HIT_KEYWORD']                       = 'Λέξη-κλειδί';
$SEARCH['HIT_DESCRIPTION']                   = 'Περιγραφή';
$SEARCH['HIT_TITLE']                         = 'Τίτλος';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Μπαλαντέρ';
$SEARCH['LEGEND_FUZZY']                      = 'Ανοχή σε τυπογραφικά λάθη';
$SEARCH['LEGEND_PHRASE']                     = 'Ακριβής φράση';
$SEARCH['LEGEND_EXCLUDE']                    = 'Εξαίρεση όρου';
$SEARCH['LEGEND_OR']                         = 'Ένας από τους όρους';
$SEARCH['LEGEND_COMBINATION']                = 'Συνδυασμός';
$SEARCH['LEGEND_OPERATORS']                  = 'Τελεστές';
$SEARCH['OP_EXCLUDE']                        = 'εξαίρεση';
$SEARCH['OP_WILDCARD']                       = 'μπαλαντέρ';
$SEARCH['OP_TYPOS']                          = 'λάθη';
$SEARCH['OP_PHRASE']                         = 'φράση';
$SEARCH['OP_OR']                             = 'ή';
$SEARCH['EXAMPLE_WORD']                      = 'μουστάρδα';
$SEARCH['EXAMPLE_WORD2']                     = 'βιολογική';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'καυτερή';
$SEARCH['EXAMPLE_OR']                        = 'κέτσαπ';
$SEARCH['EXAMPLE_PHRASE']                    = 'κίτρινη μουστάρδα';
$SEARCH['EXAMPLE_PHRASE2']                   = 'από καλαμπόκι';
$SEARCH['LABEL_LEGEND']                      = 'Υπόμνημα';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Ο όρος βρέθηκε στο περιεχόμενο της σελίδας';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Ο όρος βρέθηκε στις λέξεις-κλειδιά της σελίδας';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Ο όρος βρέθηκε στην περιγραφή της σελίδας';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Ο όρος βρέθηκε στον τίτλο';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Όρος στο περιεχόμενο και στις λέξεις-κλειδιά';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Όρος στο περιεχόμενο και στην περιγραφή';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Όρος στις λέξεις-κλειδιά και στην περιγραφή';
$SEARCH['LEGEND_HIT_ALL']                    = 'Όρος και στα τρία πεδία';
$SEARCH['PAGE_PREV']                         = 'Προηγούμενη σελίδα';
$SEARCH['PAGE_NEXT']                         = 'Επόμενη σελίδα';
$SEARCH['DROPLET_DESCRIPTION']               = 'Σύννεφο των πιο συχνών όρων αναζήτησης. Παράμετροι: max=20, min_count=1, desc=Ετικέτα, active=true (false = κρυφό)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Επισκόπηση';
$SEARCH['MENU_MODULES']                      = 'Πρόσθετα';
$SEARCH['MENU_LAYOUT']                       = 'Διάταξη';
$SEARCH['MENU_SETTINGS']                     = 'Ρυθμίσεις';
$SEARCH['MENU_STATS']                        = 'Στατιστικά';
$SEARCH['CRUMB_OVERVIEW']                    = 'Κατάσταση και συντήρηση του ευρετηρίου αναζήτησης';
$SEARCH['CRUMB_MODULES']                     = 'Ποια πρόσθετα τροφοδοτούν το ευρετήριο αναζήτησης';
$SEARCH['CRUMB_LAYOUT']                      = 'Πρότυπο της σελίδας αποτελεσμάτων';
$SEARCH['CRUMB_SETTINGS']                    = 'Συμπεριφορά αναζήτησης, ζωντανή αναζήτηση, σύννεφο ετικετών';
$SEARCH['CRUMB_STATS']                       = 'Τι αναζητούν οι επισκέπτες';
$SEARCH['LEDE_OVERVIEW']                     = 'Τρέχουσα κατάσταση του ευρετηρίου αναζήτησης και της αναζήτησης στον ιστότοπο.';
$SEARCH['LEDE_MODULES']                      = 'Πώς ευρετηριάζεται κάθε εγκατεστημένο πρόσθετο. Πρόσθετα χωρίς ορισμό συνεισφέρουν μόνο τον τίτλο της σελίδας τους.';
$SEARCH['LEDE_LAYOUT']                       = 'Ποια διάταξη και ποιο φύλλο στυλ χρησιμοποιούν η σελίδα αναζήτησης και το σύννεφο ετικετών. Τα παρεχόμενα αρχεία και τα αρχεία του προτύπου μένουν αμετάβλητα· επεξεργάζεστε πάντα το δικό σας αντίγραφο.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Σελίδα αποτελεσμάτων';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Διάταξη της σελίδας /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Σύννεφο ετικετών';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Διάταξη του droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Φύλλο στυλ';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Για τη σελίδα αποτελεσμάτων και το σύννεφο ετικετών';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'Το CSS από %1$s εμφανίζεται εδώ · Η «Επεξεργασία» δημιουργεί το %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Χωρίς φύλλο στυλ';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'το πρότυπο φέρνει μόνο του όλα τα στυλ';
$SEARCH['LAYOUT_ACTIVE']                     = 'ενεργό';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'δικό σας αρχείο';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'από το πρότυπο «%s»';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'παρεχόμενο';
$SEARCH['LAYOUT_READONLY']                   = 'μόνο ανάγνωση';
$SEARCH['LAYOUT_MODIFIED']                   = 'τροποποιήθηκε %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'το αρχείο του προτύπου %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'το παρεχόμενο αρχείο %s';
$SEARCH['BTN_EDIT']                          = 'Επεξεργασία';
$SEARCH['BTN_DELETE']                        = 'Διαγραφή';
$SEARCH['BTN_BACK']                          = 'Πίσω';
$SEARCH['BTN_SAVE_BACK']                     = 'Αποθήκευση & επιστροφή';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Θα δημιουργηθεί νέο αρχείο %1\$s ως αντίγραφο του %2\$s.\n\nΤο αντίγραφο επεξεργάζεται και γίνεται η ενεργή διάταξη· το πρωτότυπο μένει αμετάβλητο.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "Το %1\$s υπάρχει ήδη. Να αντικατασταθεί με το περιεχόμενο του %2\$s και να γίνει επεξεργασία;\n\nΗ τρέχουσα έκδοσή σας του %1\$s θα χαθεί.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Διαγραφή του %s;\n\nΑυτό δεν μπορεί να αναιρεθεί.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Ενεργή διάταξη: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = 'Το %s δημιουργήθηκε';
$SEARCH['MSG_LAYOUT_DELETED']                = 'Το %s διαγράφηκε';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Φύλλο στυλ: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Βαθμολόγηση, αποσπάσματα, ζωντανή αναζήτηση και σύννεφο ετικετών.';
$SEARCH['LEDE_STATS']                        = 'Όροι αναζήτησης που καταγράφηκαν για το σύννεφο ετικετών (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Ευρετήριο αναζήτησης';
$SEARCH['INDEX_BUILD']                       = 'Πλήρης ανακατασκευή';
$SEARCH['INDEX_UPDATE']                      = 'Ενημέρωση αλλαγών';
$SEARCH['INDEX_CLEAR']                       = 'Άδειασμα ευρετηρίου';
$SEARCH['ENTRIES']                           = 'Εγγραφές';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Το ευρετήριο δημιουργήθηκε — τίποτα για ευρετηρίαση.',
    'one' => 'Το ευρετήριο δημιουργήθηκε: %d εγγραφή.',
    'other' => 'Το ευρετήριο δημιουργήθηκε: %d εγγραφές.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Τίποτα για ενημέρωση.',
    'one' => '%d εγγραφή ενημερώθηκε.',
    'other' => '%d εγγραφές ενημερώθηκαν.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Το ευρετήριο διαγράφηκε.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Να διαγραφεί πραγματικά ολόκληρο το ευρετήριο;';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Αναζήτηση στον ιστότοπο';
$SEARCH['LABEL_LAST_INDEXED']                = 'Τελευταία ευρετηρίαση';
$SEARCH['INDEX_BUILD_DESC']                  = 'Διαβάζει ξανά <b>όλες</b> τις ενότητες με δυνατότητα αναζήτησης. Παίρνει χρόνο σε μεγάλους ιστότοπους.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Διαβάζει μόνο τις αλλαγμένες ή ελλείπουσες ενότητες. Ταχύτερο από πλήρη ανακατασκευή.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Διαβάζει μόνο τις αλλαγμένες ή ελλείπουσες ενότητες. Αυτή τη στιγμή δεν υπάρχει τίποτα να γίνει.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Αδειάζει το ευρετήριο. Η αναζήτηση δεν βρίσκει τίποτα μέχρι να ανακατασκευαστεί.';
$SEARCH['LABEL_FRESHNESS']                   = 'Επικαιρότητα';
$SEARCH['FRESH_ALL']                         = '<b>Το ευρετήριο είναι ενημερωμένο</b> — και οι %d ενότητες αντιστοιχούν στην τελευταία τους αλλαγή.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d από %2$d</b> ενότητες άλλαξαν ή λείπουν.';
$SEARCH['FRESH_NONE']                        = 'Δεν υπάρχουν ακόμη ενότητες με δυνατότητα αναζήτησης.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Αναζήτηση στον ιστότοπο';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Ρυθμίσεις › Αναζήτηση';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Δημόσια';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Εγγεγραμμένοι';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Ιδιωτική';
$SEARCH['SITE_SEARCH_NONE']                  = 'Ανενεργή';
$SEARCH['HINT_SITE_SEARCH']                  = 'Ποιος μπορεί να αναζητά — για κάθε πεδίο αναζήτησης του ιστότοπου, όποια αναζήτηση κι αν βρίσκεται από πίσω. Η ίδια ρύθμιση με το <a href="%s">Ρυθμίσεις › Αναζήτηση</a>· «Εγγεγραμμένοι» και «Ιδιωτική» σημαίνουν και τα δύο: μόνο συνδεδεμένοι επισκέπτες.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Να οριστεί η αναζήτηση στον ιστότοπο σε «%s»;\n\nΑυτό αλλάζει τη ρύθμιση «Αναζήτηση» του ιστότοπου για όλους τους επισκέπτες.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Αναζήτηση στον ιστότοπο: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Γλώσσες';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Χωρίς πληροφορίες γλώσσας';
$SEARCH['VIS_HIDDEN']                        = 'Κρυφή';
$SEARCH['VIS_PUBLIC']                        = 'Δημόσια';
$SEARCH['VIS_PRIVATE']                       = 'Ιδιωτική';
$SEARCH['VIS_REGISTERED']                    = 'Εγγεγραμμένοι';
$SEARCH['VIS_NONE']                          = 'Καμία';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'Η διάταξη είναι κενή και δεν αποθηκεύτηκε.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Δεν ήταν δυνατή η εγγραφή του search_custom.htt. Ελέγξτε τα δικαιώματα εγγραφής του φακέλου layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Με επιλεγμένο το «AjaxSave», η Αποθήκευση και το Ctrl+S αποθηκεύουν χωρίς επαναφόρτωση της σελίδας· το «Αποθήκευση & επιστροφή» τότε κρύβεται.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Ελάχιστο μήκος λέξης';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Οι μικρότερες λέξεις αγνοούνται';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Βαρύτητα τίτλου';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Ευρήματα στον τίτλο × συντελεστής';
$SEARCH['SET_MAX_EXCERPT']                   = 'Μέγιστο μήκος αποσπάσματος';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Χαρακτήρες ανά απόσπασμα';
$SEARCH['SET_HIGHLIGHT']                     = 'Επισήμανση';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Επισήμανση των όρων αναζήτησης στο απόσπασμα';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Ετικέτα επισήμανσης';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Ετικέτα HTML για την επισήμανση';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Αποτελέσματα ανά σελίδα';
$SEARCH['SET_AUTO_REINDEX']                  = 'Αυτόματη επανευρετηρίαση κατά την αναζήτηση';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Ενημερώνει αθόρυβα τις παρωχημένες εγγραφές σε κάθε αναζήτηση';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Εμφάνιση σύννεφου ετικετών';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Στη σελίδα αναζήτησης. Το droplet έχει δική του παράμετρο active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Καταγραφή αναζητήσεων';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Καταγράφει τις αναζητήσεις για το σύννεφο ετικετών και τα στατιστικά — η απενεργοποίηση δεν κρύβει το σύννεφο';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Ζωντανή αναζήτηση AJAX';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Εμφάνιση προτάσεων κατά την πληκτρολόγηση';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Λειτουργία αποσφαλμάτωσης';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Εμφάνιση τεχνικών δεδομένων κάτω από κάθε αποτέλεσμα (μόνο διαχειριστές)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Πρότυπο σελίδας αναζήτησης';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Πρότυπο frontend στο οποίο εμφανίζεται η σελίδα /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Προεπιλεγμένο πρότυπο ιστότοπου (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Αναζήτηση';
$SEARCH['GROUP_DISPLAY']                     = 'Εμφάνιση αποτελεσμάτων';
$SEARCH['GROUP_INDEX']                       = 'Συντήρηση ευρετηρίου';
$SEARCH['GROUP_LIVE']                        = 'Ζωντανή αναζήτηση';
$SEARCH['GROUP_TAGCLOUD']                    = 'Σύννεφο ετικετών';
$SEARCH['GROUP_ADMIN']                       = 'Εργαλείο διαχείρισης';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Μέγεθος σελίδας της λίστας αποτελεσμάτων';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Φίλτρο γλώσσας';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Εμφάνιση μόνο σελίδων στη γλώσσα του επισκέπτη (προεπιλογή ιστότοπου: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Σύνθετη αναζήτηση';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Εμφάνιση πλαισίων εύρους και επιλογής Ή στη φόρμα αναζήτησης';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Μέγ. ενότητες ανά αναζήτηση';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Όριο αυτόματης επανευρετηρίασης (έλεγχος φόρτου)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Πηγή προτάσεων';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Το υβριδικό εμφανίζει πρώτα ευρήματα τίτλου και συμπληρώνει με σελίδες που περιέχουν τη λέξη στο κείμενό τους';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Μέγ. προτάσεις';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Αριθμός εμφανιζόμενων προτάσεων';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Εικόνες στις προτάσεις';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Εμφανίζει την εικόνα του στοιχείου (κατάλογος, νέα …) δίπλα στην πρόταση, αν το πρόσθετο ευρετηριάζει μία';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Μέγ. ετικέτες';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Αριθμός όρων στο σύννεφο ετικετών';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Ελάχ. αναζητήσεις';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Ελάχιστος αριθμός αναζητήσεων πριν εμφανιστεί ένας όρος';
$SEARCH['SET_NAV_STYLE']                     = 'Πλοήγηση';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Καρτέλες επάνω ή γραμμή εικονιδίων αριστερά';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Πρώτα τίτλοι, συμπληρωμένοι από το πλήρες κείμενο (συνιστάται)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Τίτλος + περιγραφή (γρήγορο)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Ευρετήριο πλήρους κειμένου (διεξοδικό)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Καρτέλες επάνω';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Πλαϊνή γραμμή αριστερά';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpoint';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Ανιχνεύεται αυτόματα στη σελίδα αναζήτησης για πεδία με όνομα «string», type="search" ή κλάση ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Οι ρυθμίσεις αποθηκεύτηκαν.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Τα στατιστικά αναζήτησης διαγράφηκαν.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Να διαγραφούν πραγματικά όλα τα στατιστικά;';
$SEARCH['STATS_DELETE']                      = 'Διαγραφή στατιστικών';
$SEARCH['STATS_TERM']                        = 'Όρος αναζήτησης';
$SEARCH['STATS_COUNT']                       = 'Πλήθος';
$SEARCH['STATS_LAST']                        = 'Τελευταία αναζήτηση';
$SEARCH['STATS_TERMS']                       = 'Όροι';
$SEARCH['STATS_SEARCHES']                    = 'Αναζητήσεις';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 από %d όρο.',
    'other' => 'Top 100 από %d όρους.',
];
$SEARCH['STATS_EMPTY']                       = 'Δεν έχουν καταγραφεί ακόμη όροι αναζήτησης.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Αναζητήθηκε, δεν βρέθηκε τίποτα';
$SEARCH['HINT_STATS_MISSES']                 = 'Ολόκληρες αναζητήσεις χωρίς αποτέλεσμα — ένδειξη για περιεχόμενο που περιμένουν οι επισκέπτες αλλά δεν βρίσκουν. Δεν εμφανίζεται ποτέ δημόσια.';
$SEARCH['STATS_QUERY']                       = 'Ερώτημα';
$SEARCH['STATS_MISSES_EMPTY']                = 'Δεν έχουν καταγραφεί αναζητήσεις χωρίς αποτέλεσμα.';
$SEARCH['CARD_WORDS']                        = 'Ευρετήριο λέξεων';
$SEARCH['HINT_WORDS']                        = 'Για μεγάλους ιστότοπους: μια λίστα όλων των λέξεων, ώστε η αναζήτηση να μη χρειάζεται να διαβάζει όλο το ευρετήριο. Δημιουργείται αυτόματα από %s εγγραφές ευρετηρίου και πάνω.';
$SEARCH['WORDS_INACTIVE']                    = 'Ανενεργό — ο ιστότοπος είναι κάτω από το όριο (%2$s εγγραφές ευρετηρίου, τώρα %1$s)· η κανονική αναζήτηση είναι αρκετά γρήγορη.';
$SEARCH['WORDS_OFF']                         = 'Απενεργοποιημένο στις ρυθμίσεις.';
$SEARCH['WORDS_BUILDING']                    = 'Σε κατασκευή';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Συνέχεια κατασκευής';
$SEARCH['MSG_WORDS_READY']                   = 'Το ευρετήριο λέξεων ολοκληρώθηκε.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Ευρετήριο λέξεων: απομένει %d εγγραφή — ως τότε χρησιμοποιείται η κανονική αναζήτηση.',
    'other' => 'Ευρετήριο λέξεων: απομένουν %d εγγραφές — ως τότε χρησιμοποιείται η κανονική αναζήτηση.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Σε χρήση — %d εγγραφή λέξης.',
    'other' => 'Σε χρήση — %d εγγραφές λέξεων.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Ευρετήριο λέξεων';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Αυτόματο: δημιουργείται μόνο όταν ο ιστότοπος φτάσει το παρακάτω όριο. Οι μικροί ιστότοποι δεν το χρειάζονται.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Αυτόματο';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Πάντα ενεργό';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Ανενεργό';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Ευρετήριο λέξεων από';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Αριθμός ευρετηριασμένων εγγραφών (ενότητες και στοιχεία πρόσθετων) από τον οποίο το ευρετήριο λέξεων δημιουργείται αυτόματα';
$SEARCH['BTN_DELETE_TERM']                   = 'Αφαίρεση αυτού του όρου';
$SEARCH['MSG_TERM_DELETED']                  = 'Ο όρος αφαιρέθηκε.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Η ημι-ρύθμιση για το <b>%s</b> προσυμπληρώθηκε από το search.php — ελέγξτε και προσαρμόστε.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Η ημι-ρύθμιση για το \'%s\' αποθηκεύτηκε.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Η ρύθμιση και οι εγγραφές ευρετηρίου για το %s διαγράφηκαν.';
$SEARCH['MSG_DEF_GENERATED']                 = 'Το module_defs/%s.php δημιουργήθηκε. Ανακατασκευάστε το ευρετήριο.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Διαγραφή της ρύθμισης και των εγγραφών ευρετηρίου για το %s;';
$SEARCH['STATUS_SEMI']                       = 'Ημι-ρύθμιση';
$SEARCH['LABEL_GUIDE']                       = 'Εμφάνιση οδηγού για αυτό το πρόσθετο';
$SEARCH['LABEL_TABLE_HINT']                  = 'Επιλέξτε πίνακα → οι στήλες φορτώνονται αυτόματα';
$SEARCH['LABEL_TABLE_SELECT']                = 'Επιλογή πίνακα';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Άγκυρα σελίδας WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Μόνο σελίδες με δυνατότητα αναζήτησης';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Όλες οι ενότητες (δεξαμενή περιεχομένου)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Μόνο ενεργές εγγραφές (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Χρονικός έλεγχος (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (προαιρετικά, μέγ. 3) — δεδομένα από επιπλέον πίνακες';
$SEARCH['LABEL_GENERATE_DEF']                = 'Δημιουργία αρχείου module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Από το search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Διαγραφή ρύθμισης';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Χωρίς στήλες κειμένου';
$SEARCH['LABEL_ERROR']                       = 'Σφάλμα';
$SEARCH['LABEL_MODULE']                      = 'Πρόσθετο';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Χωρίς δυνατότητα αναζήτησης';
$SEARCH['LABEL_HELP']                        = 'Βοήθεια';
$SEARCH['BTN_CONFIGURE']                     = 'Ρύθμιση';
$SEARCH['BTN_CLOSE']                         = 'Κλείσιμο';
$SEARCH['DEF_GENERATED']                     = 'δημιουργημένος';
$SEARCH['DEF_SHIPPED']                       = 'ενσωματωμένος';
$SEARCH['LABEL_KIND']                        = 'Τύπος';
$SEARCH['LABEL_INDEXING']                    = 'Ευρετηρίαση';
$SEARCH['LABEL_SECTIONS']                    = 'Ενότητες';
$SEARCH['PLACEHOLDER_FILTER']                = 'Φιλτράρισμα …';
$SEARCH['MODULES_SHOWN']                     = 'Εμφανίζονται %1$d από %2$d πρόσθετα';
$SEARCH['KIND_PAGE']                         = 'Πρόσθετα σελίδας';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Φίλτρα';
$SEARCH['KIND_TOOL']                         = 'Εργαλεία διαχείρισης';
$SEARCH['BADGE_PAGE']                        = 'Σελίδα';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Φίλτρο';
$SEARCH['BADGE_TOOL']                        = 'Εργαλείο';
$SEARCH['GROUP_DEF']                         = 'με ορισμό';
$SEARCH['GROUP_OPEN']                        = 'ημιτελές';
$SEARCH['GROUP_TITLE']                       = 'μόνο τίτλος σελίδας';
$SEARCH['SOURCE_MODULE']                     = 'Από το πρόσθετο';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Ενσωματωμένος';
$SEARCH['SOURCE_GENERATED']                  = 'Ημι-ρύθμιση';
$SEARCH['SOURCE_SEMI']                       = 'Ημι-ρύθμιση – δεν δημιουργήθηκε';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'Βρέθηκε search.php';
$SEARCH['SOURCE_TITLE']                      = 'Μόνο τίτλος σελίδας';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Το πρόσθετο έχει δικό του ορισμό αναζήτησης (search_index.php) — δεν επεξεργάζεται εδώ.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Ευρετηριάζεται μέσω PHP callback — δεν επεξεργάζεται εδώ.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Ορισμός που συνοδεύει το WBCE Search (module_defs/). Η ημι-ρύθμιση έχει προτεραιότητα.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Ορισμός που δημιουργήθηκε από την ημι-ρύθμιση.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Η ημι-ρύθμιση αποθηκεύτηκε, αλλά δεν έχει δημιουργηθεί ακόμη ορισμός.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Δεν υπάρχει ακόμη ορισμός — μπορεί να προσυμπληρωθεί από το παλιό search.php του πρόσθετου.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Χωρίς ορισμό — το ευρετήριο περιέχει μόνο τον τίτλο της σελίδας.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Χωρίς ενότητες σελίδας — τίποτα για ευρετηρίαση.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Η αναζήτηση είναι απενεργοποιημένη για αυτή τη σελίδα';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Ενσωματωμένος ορισμός. Η αποθήκευση δημιουργεί ημι-ρύθμιση με προτεραιότητα.';
$SEARCH['LABEL_TABLE']                       = 'Πίνακας';
$SEARCH['LABEL_OWN_TABLES']                  = 'Πίνακες αυτού του πρόσθετου';
$SEARCH['LABEL_OTHER_TABLES']                = 'Άλλοι πίνακες πρόσθετων';
$SEARCH['HINT_TABLE']                        = 'Μόνο πίνακες mod_* με στήλη section_id μπορούν να ευρετηριαστούν.';
$SEARCH['LABEL_ID_FIELD']                    = 'Στήλη ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Κλειδί στοιχείου';
$SEARCH['HINT_ITEM_KEY']                     = 'Μοναδικό κλειδί ανά στοιχείο (λειτουργία πολλαπλών).';
$SEARCH['LABEL_TITLE_COL']                   = 'Στήλη τίτλου';
$SEARCH['LABEL_TEXT_COLS']                   = 'Στήλες κειμένου';
$SEARCH['LABEL_LINK_COL']                    = 'Στήλη συνδέσμου';
$SEARCH['HINT_LINK_PREFIX']                  = 'Προαιρετικό πρόθεμα: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Στήλη εικόνας';
$SEARCH['HINT_IMAGE_PATH']                   = 'Διαδρομή κάτω από το /media, επιτρέπονται σύμβολα κράτησης όπως {item_id}.';
$SEARCH['LABEL_NONE']                        = 'καμία';
$SEARCH['LABEL_MODE']                        = 'Λειτουργία';
$SEARCH['MODE_SINGLE']                       = 'Μονή — μία εγγραφή ανά ενότητα';
$SEARCH['MODE_MULTI']                        = 'Πολλαπλή — μία εγγραφή ανά στοιχείο';
$SEARCH['LABEL_INDEX_BASE']                  = 'Βάση ευρετηρίου';
$SEARCH['LABEL_FILTER']                      = 'Φίλτρο';
$SEARCH['LABEL_NO_JOIN']                     = 'χωρίς join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Επιλέξτε έγκυρο πίνακα πρόσθετου.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Δεν βρέθηκε χρήσιμος πίνακας στο search.php του %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Καμία σελίδα',
    'one' => '%d σελίδα',
    'other' => '%d σελίδες',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Αποθήκευση';
$SEARCH['MSG_SECURITY_ERROR']                = 'Ο έλεγχος ασφαλείας απέτυχε.';
$SEARCH['STATUS_ACTIVE']                     = 'Ενεργό';
$SEARCH['STATUS_INACTIVE']                   = 'Ανενεργό';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'ο','η','το','οι','τα','του','της','των','τον','την','τη','τους','τις','ένας',
    'μια','μία','ένα','ενός','και','κι','ή','να','θα','δεν','δε','μη','μην','με',
    'σε','στο','στη','στην','στον','στα','στις','στους','από','για','προς','ως',
    'αν','ότι','πως','που','πού','όπως','αλλά','όμως','ενώ','είναι','ήταν','έχει',
    'έχουν','είχε','αυτό','αυτή','αυτός','αυτά','αυτοί','αυτές','εκείνος','εγώ',
    'εσύ','εμείς','εσείς','μου','σου','μας','σας','πολύ','πιο','όλα','όλοι','κάθε',
    'μόνο','επίσης','ακόμη','ήδη','τι','ποιος','πότε','εδώ','εκεί','μετά','πριν',
    'χωρίς','μέχρι','κατά','μέσα','έξω','πάνω','κάτω','ένασ','τησ','τουσ','τισ',
    'πωσ','ωσ','αυτόσ','εκείνοσ','ποιοσ','όλοσ','χωρίσ',
];
