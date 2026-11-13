<?php
/**
 * wbce_search - languages/FR.php
 * Français
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Paramètres avancés de la recherche. Index, modules, mises en page et statistiques de la recherche de WBCE CMS : recherche plein texte avec opérateurs, suggestions en direct, surlignage des résultats sur la page cible et nuage de mots-clés.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Rechercher';
$SEARCH['SEARCH_HEADING']                    = 'Recherche';
$SEARCH['RESULTS_FOR']                       = 'Résultats pour';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Aucun résultat',
    'one' => '%d résultat',
    'other' => '%d résultats',
];
$SEARCH['NO_RESULTS']                        = 'Aucun résultat trouvé.';
$SEARCH['ALL_WORDS']                         = 'Tous les mots';
$SEARCH['ANY_WORDS']                         = 'Un des mots';
$SEARCH['EXACT_MATCH']                       = 'Expression exacte';
$SEARCH['MATCH']                             = 'Mode de recherche';
$SEARCH['PAGES']                             = 'Pages';
$SEARCH['TIPS_TITLE']                        = 'Conseils de recherche :';
$SEARCH['TIP_FEWER']                         = 'Utilisez moins de termes';
$SEARCH['TIP_OR']                            = 'Recherche OU :';
$SEARCH['TIP_OR_EXAMPLE']                    = 'autreTerme';
$SEARCH['TIP_NOT']                           = 'Exclure :';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'exclure';
$SEARCH['TIP_PHRASE']                        = 'Expression exacte :';
$SEARCH['TIP_WILDCARD']                      = 'Joker :';
$SEARCH['TIP_FUZZY']                         = 'Tolérer les fautes :';
$SEARCH['DID_YOU_MEAN']                      = 'Vouliez-vous dire :';
$SEARCH['SCOPE_TITLE']                       = 'Titre uniquement';
$SEARCH['SCOPE_CONTENT']                     = 'Contenu uniquement';
$SEARCH['SEARCH_OR']                         = 'Recherche OU (au moins un terme)';
$SEARCH['AREAS_TITLE']                       = 'Parcourir par thème :';
$SEARCH['TAGCLOUD_LABEL']                    = 'Recherches fréquentes :';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'recherché une fois',
    'other' => 'recherché %d fois',
];
$SEARCH['HIT_CONTENT']                       = 'Contenu';
$SEARCH['HIT_KEYWORD']                       = 'Mot-clé';
$SEARCH['HIT_DESCRIPTION']                   = 'Description';
$SEARCH['HIT_TITLE']                         = 'Titre';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Joker';
$SEARCH['LEGEND_FUZZY']                      = 'Tolérer les fautes';
$SEARCH['LEGEND_PHRASE']                     = 'Expression exacte';
$SEARCH['LEGEND_EXCLUDE']                    = 'Exclure un terme';
$SEARCH['LEGEND_OR']                         = 'L\'un ou l\'autre';
$SEARCH['LEGEND_COMBINATION']                = 'Combinaison';
$SEARCH['LEGEND_OPERATORS']                  = 'Opérateurs';
$SEARCH['OP_EXCLUDE']                        = 'exclure';
$SEARCH['OP_WILDCARD']                       = 'joker';
$SEARCH['OP_TYPOS']                          = 'fautes';
$SEARCH['OP_PHRASE']                         = 'expression';
$SEARCH['OP_OR']                             = 'ou';
$SEARCH['EXAMPLE_WORD']                      = 'moutarde';
$SEARCH['EXAMPLE_WORD2']                     = 'bio';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'forte';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'moutarde jaune';
$SEARCH['EXAMPLE_PHRASE2']                   = 'de maïs';
$SEARCH['LABEL_LEGEND']                      = 'Légende';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Terme trouvé dans le contenu de la page';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Terme trouvé dans les mots-clés de la page';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Terme trouvé dans la description de la page';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Terme trouvé dans le titre';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Terme dans le contenu et les mots-clés';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Terme dans le contenu et la description';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Terme dans les mots-clés et la description';
$SEARCH['LEGEND_HIT_ALL']                    = 'Terme dans les trois champs';
$SEARCH['PAGE_PREV']                         = 'Page précédente';
$SEARCH['PAGE_NEXT']                         = 'Page suivante';
$SEARCH['DROPLET_DESCRIPTION']               = 'Nuage des termes les plus recherchés. Paramètres : max=20, min_count=1, desc=Libellé, active=true (false = masqué)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Aperçu';
$SEARCH['MENU_MODULES']                      = 'Modules';
$SEARCH['MENU_LAYOUT']                       = 'Mise en page';
$SEARCH['MENU_SETTINGS']                     = 'Réglages';
$SEARCH['MENU_STATS']                        = 'Statistiques';
$SEARCH['CRUMB_OVERVIEW']                    = 'État et maintenance de l\'index de recherche';
$SEARCH['CRUMB_MODULES']                     = 'Modules qui alimentent l\'index de recherche';
$SEARCH['CRUMB_LAYOUT']                      = 'Modèle de la page de résultats';
$SEARCH['CRUMB_SETTINGS']                    = 'Comportement de la recherche, recherche en direct, nuage de mots-clés';
$SEARCH['CRUMB_STATS']                       = 'Ce que cherchent les visiteurs';
$SEARCH['LEDE_OVERVIEW']                     = 'État actuel de l\'index de recherche et de la recherche publique.';
$SEARCH['LEDE_MODULES']                      = 'Comment chaque module installé est indexé. Les modules sans définition n\'apportent que leur titre de page.';
$SEARCH['LEDE_LAYOUT']                       = 'Mise en page et feuille de style utilisées par la page de recherche et le nuage de mots-clés. Les fichiers fournis et ceux du modèle restent inchangés ; vous modifiez toujours votre propre copie.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Page de résultats';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Mise en page de la page /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Nuage de mots-clés';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Mise en page du droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Feuille de style';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Pour la page de résultats et le nuage de mots-clés';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'Les CSS de %1$s apparaissent ici · « Modifier » crée %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Aucune feuille de style';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'le modèle apporte lui-même tous les styles';
$SEARCH['LAYOUT_ACTIVE']                     = 'actif';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'fichier personnel';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'du modèle « %s »';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'fourni';
$SEARCH['LAYOUT_READONLY']                   = 'lecture seule';
$SEARCH['LAYOUT_MODIFIED']                   = 'modifié le %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'le fichier du modèle %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'le fichier fourni %s';
$SEARCH['BTN_EDIT']                          = 'Modifier';
$SEARCH['BTN_DELETE']                        = 'Supprimer';
$SEARCH['BTN_BACK']                          = 'Retour';
$SEARCH['BTN_SAVE_BACK']                     = 'Enregistrer et retour';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Un nouveau fichier %1\$s sera créé comme copie de %2\$s.\n\nLa copie est modifiée et devient la mise en page active ; l'original reste inchangé.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s existe déjà. L'écraser avec le contenu de %2\$s et le modifier ?\n\nVotre version actuelle de %1\$s sera perdue.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Supprimer %s ?\n\nCette action est irréversible.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Mise en page active : %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s créé';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s supprimé';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Feuille de style : %s';
$SEARCH['LEDE_SETTINGS']                     = 'Pondération, extraits, recherche en direct et nuage de mots-clés.';
$SEARCH['LEDE_STATS']                        = 'Termes de recherche enregistrés pour le nuage de mots-clés (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Index de recherche';
$SEARCH['INDEX_BUILD']                       = 'Reconstruction complète';
$SEARCH['INDEX_UPDATE']                      = 'Mettre à jour les modifications';
$SEARCH['INDEX_CLEAR']                       = 'Vider l\'index';
$SEARCH['ENTRIES']                           = 'Entrées';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Index construit — rien à indexer.',
    'one' => 'Index construit : %d entrée.',
    'other' => 'Index construit : %d entrées.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Rien à mettre à jour.',
    'one' => '%d entrée mise à jour.',
    'other' => '%d entrées mises à jour.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Index supprimé.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Vraiment supprimer tout l\'index ?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Recherche publique';
$SEARCH['LABEL_LAST_INDEXED']                = 'Dernière indexation';
$SEARCH['INDEX_BUILD_DESC']                  = 'Relit <b>toutes</b> les sections consultables. Prend du temps sur les grands sites.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Ne relit que les sections modifiées ou manquantes. Plus rapide qu\'une reconstruction complète.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Ne relit que les sections modifiées ou manquantes. Rien à faire pour le moment.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Vide l\'index. La recherche ne trouve plus rien jusqu\'à sa reconstruction.';
$SEARCH['LABEL_FRESHNESS']                   = 'À jour';
$SEARCH['FRESH_ALL']                         = '<b>L\'index est à jour</b> — les %d sections correspondent à leur dernière modification.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d sur %2$d</b> sections ont été modifiées ou manquent.';
$SEARCH['FRESH_NONE']                        = 'Aucune section consultable pour l\'instant.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Recherche sur le site';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Réglages › Recherche';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Public';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Inscrits';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privé';
$SEARCH['SITE_SEARCH_NONE']                  = 'Désactivée';
$SEARCH['HINT_SITE_SEARCH']                  = 'Qui peut chercher — pour chaque champ de recherche du site, quelle que soit la recherche derrière. Le même réglage que sous <a href="%s">Réglages › Recherche</a> ; « Inscrits » et « Privé » signifient tous deux : visiteurs connectés uniquement.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Régler la recherche sur le site sur « %s » ?\n\nCela modifie le réglage « Recherche » du site pour tous les visiteurs.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Recherche sur le site : %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Langues';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Aucune information de langue';
$SEARCH['VIS_HIDDEN']                        = 'Masqué';
$SEARCH['VIS_PUBLIC']                        = 'Public';
$SEARCH['VIS_PRIVATE']                       = 'Privé';
$SEARCH['VIS_REGISTERED']                    = 'Inscrits';
$SEARCH['VIS_NONE']                          = 'Aucun';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'La mise en page est vide et n\'a pas été enregistrée.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Impossible d\'écrire search_custom.htt. Vérifiez les droits d\'écriture du dossier layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Avec « AjaxSave » coché, Enregistrer et Ctrl+S enregistrent sans recharger la page ; « Enregistrer et retour » est alors masqué.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Longueur minimale des mots';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Les mots plus courts sont ignorés';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Poids du titre';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Occurrences dans le titre × facteur';
$SEARCH['SET_MAX_EXCERPT']                   = 'Longueur max. de l\'extrait';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Caractères par extrait';
$SEARCH['SET_HIGHLIGHT']                     = 'Surlignage';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Surligner les termes recherchés dans l\'extrait';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Balise de surlignage';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Balise HTML utilisée pour le surlignage';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Résultats par page';
$SEARCH['SET_AUTO_REINDEX']                  = 'Réindexation automatique à la recherche';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Met à jour discrètement les entrées obsolètes à chaque recherche';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Afficher le nuage de mots-clés';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Sur la page de recherche. Le droplet a son propre paramètre active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Enregistrer les recherches';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Enregistre les recherches pour le nuage de mots-clés et les statistiques — désactiver ne masque pas le nuage';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Recherche en direct AJAX';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Afficher des suggestions pendant la saisie';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Mode débogage';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Affiche des données techniques sous chaque résultat (administrateurs uniquement)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Modèle de la page de recherche';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Modèle du site dans lequel la page /search/ est affichée.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Modèle par défaut du site (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Recherche';
$SEARCH['GROUP_DISPLAY']                     = 'Affichage des résultats';
$SEARCH['GROUP_INDEX']                       = 'Maintenance de l\'index';
$SEARCH['GROUP_LIVE']                        = 'Recherche en direct';
$SEARCH['GROUP_TAGCLOUD']                    = 'Nuage de mots-clés';
$SEARCH['GROUP_ADMIN']                       = 'Outil d\'administration';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Nombre de résultats par page de la liste';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Filtre de langue';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'N\'afficher que les pages dans la langue du visiteur (langue par défaut du site : %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Recherche avancée';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Afficher les cases de portée et l\'option OU dans le formulaire';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Sections max. par recherche';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Limite de la réindexation automatique (contrôle de charge)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Source des suggestions';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Hybride liste d\'abord les titres correspondants et complète avec les pages qui contiennent le mot dans leur texte';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Suggestions max.';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Nombre de suggestions affichées';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Images dans les suggestions';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Affiche l\'image de l\'élément (catalogue, actualités …) à côté de la suggestion, si le module en indexe une';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Mots-clés max.';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Nombre de termes affichés dans le nuage';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Recherches min.';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Nombre minimal de recherches avant qu\'un terme apparaisse';
$SEARCH['SET_NAV_STYLE']                     = 'Navigation';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Onglets en haut ou barre d\'icônes à gauche';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Titres d\'abord, complétés par le texte intégral (recommandé)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Titre + description (rapide)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Index plein texte (approfondi)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Onglets en haut';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Barre latérale à gauche';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Point d\'accès';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Détecté automatiquement sur la page de recherche pour les champs nommés « string », type="search" ou de classe ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Réglages enregistrés.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Statistiques de recherche supprimées.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Vraiment supprimer toutes les statistiques ?';
$SEARCH['STATS_DELETE']                      = 'Supprimer les statistiques';
$SEARCH['STATS_TERM']                        = 'Terme recherché';
$SEARCH['STATS_COUNT']                       = 'Nombre';
$SEARCH['STATS_LAST']                        = 'Dernière recherche';
$SEARCH['STATS_TERMS']                       = 'Termes';
$SEARCH['STATS_SEARCHES']                    = 'Recherches';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 sur %d terme.',
    'other' => 'Top 100 sur %d termes.',
];
$SEARCH['STATS_EMPTY']                       = 'Aucun terme de recherche enregistré.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Recherché, rien trouvé';
$SEARCH['HINT_STATS_MISSES']                 = 'Requêtes complètes sans résultat — un indice des contenus que vos visiteurs attendent sans les trouver. Jamais affiché publiquement.';
$SEARCH['STATS_QUERY']                       = 'Requête';
$SEARCH['STATS_MISSES_EMPTY']                = 'Aucune recherche sans résultat enregistrée.';
$SEARCH['CARD_WORDS']                        = 'Index des mots';
$SEARCH['HINT_WORDS']                        = 'Pour les grands sites : une liste de tous les mots, pour qu\'une recherche n\'ait plus à lire tout l\'index. Construit automatiquement à partir de %s entrées d\'index.';
$SEARCH['WORDS_INACTIVE']                    = 'Inactif — le site est sous le seuil (%2$s entrées d\'index, actuellement %1$s) ; la recherche normale est assez rapide.';
$SEARCH['WORDS_OFF']                         = 'Désactivé dans les réglages.';
$SEARCH['WORDS_BUILDING']                    = 'En construction';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Poursuivre la construction';
$SEARCH['MSG_WORDS_READY']                   = 'Index des mots complet.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Index des mots : %d entrée encore en attente — la recherche normale est utilisée d\'ici là.',
    'other' => 'Index des mots : %d entrées encore en attente — la recherche normale est utilisée d\'ici là.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'En service — %d entrée de mot.',
    'other' => 'En service — %d entrées de mots.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Index des mots';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automatique : construit seulement quand le site atteint le seuil ci-dessous. Les petits sites n\'en ont pas besoin.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automatique';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Toujours actif';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Désactivé';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Index des mots à partir de';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Nombre d\'entrées indexées (sections et éléments de modules) à partir duquel l\'index des mots est construit automatiquement';
$SEARCH['BTN_DELETE_TERM']                   = 'Retirer ce terme';
$SEARCH['MSG_TERM_DELETED']                  = 'Terme retiré.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semi-configuration de <b>%s</b> préremplie depuis search.php — veuillez la vérifier et l\'ajuster.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semi-configuration de « %s » enregistrée.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Configuration et entrées d\'index de %s supprimées.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php généré. Veuillez reconstruire l\'index.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Supprimer la configuration et les entrées d\'index de %s ?';
$SEARCH['STATUS_SEMI']                       = 'Semi-configuration';
$SEARCH['LABEL_GUIDE']                       = 'Afficher le guide de ce module';
$SEARCH['LABEL_TABLE_HINT']                  = 'Choisir une table → les colonnes se chargent automatiquement';
$SEARCH['LABEL_TABLE_SELECT']                = 'Choisir une table';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Ancre de page WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Pages consultables uniquement';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Toutes les sections (réservoir de contenu)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Entrées actives uniquement (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Contrôle temporel (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Jointures (facultatif, max. 3) — données d\'autres tables';
$SEARCH['LABEL_GENERATE_DEF']                = 'Générer le fichier module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Depuis search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Supprimer la configuration';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Aucune colonne de texte';
$SEARCH['LABEL_ERROR']                       = 'Erreur';
$SEARCH['LABEL_MODULE']                      = 'Module';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Non consultable';
$SEARCH['LABEL_HELP']                        = 'Aide';
$SEARCH['BTN_CONFIGURE']                     = 'Configurer';
$SEARCH['BTN_CLOSE']                         = 'Fermer';
$SEARCH['DEF_GENERATED']                     = 'généré';
$SEARCH['DEF_SHIPPED']                       = 'intégré';
$SEARCH['LABEL_KIND']                        = 'Type';
$SEARCH['LABEL_INDEXING']                    = 'Indexation';
$SEARCH['LABEL_SECTIONS']                    = 'Sections';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrer …';
$SEARCH['MODULES_SHOWN']                     = '%1$d sur %2$d modules affichés';
$SEARCH['KIND_PAGE']                         = 'Modules de page';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtres';
$SEARCH['KIND_TOOL']                         = 'Outils d\'administration';
$SEARCH['BADGE_PAGE']                        = 'Page';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtre';
$SEARCH['BADGE_TOOL']                        = 'Outil';
$SEARCH['GROUP_DEF']                         = 'avec définition';
$SEARCH['GROUP_OPEN']                        = 'incomplet';
$SEARCH['GROUP_TITLE']                       = 'titre de page uniquement';
$SEARCH['SOURCE_MODULE']                     = 'Du module';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Intégré';
$SEARCH['SOURCE_GENERATED']                  = 'Semi-configuration';
$SEARCH['SOURCE_SEMI']                       = 'Semi-configuration – non générée';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php trouvé';
$SEARCH['SOURCE_TITLE']                      = 'Titre de page uniquement';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'Le module fournit sa propre définition de recherche (search_index.php) — non modifiable ici.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indexé par un callback PHP — non modifiable ici.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Définition fournie avec WBCE Search (module_defs/). Une semi-configuration a priorité sur elle.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Définition générée à partir de la semi-configuration.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semi-configuration enregistrée, mais aucune définition générée.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Pas encore de définition — peut être préremplie depuis l\'ancien search.php du module.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Pas de définition — l\'index ne contient que le titre de la page.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Aucune section de page — rien à indexer.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Recherche désactivée pour cette page';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Définition intégrée. L\'enregistrement crée une semi-configuration prioritaire.';
$SEARCH['LABEL_TABLE']                       = 'Table';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tables de ce module';
$SEARCH['LABEL_OTHER_TABLES']                = 'Autres tables de modules';
$SEARCH['HINT_TABLE']                        = 'Seules les tables mod_* avec une colonne section_id peuvent être indexées.';
$SEARCH['LABEL_ID_FIELD']                    = 'Colonne ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Clé d\'élément';
$SEARCH['HINT_ITEM_KEY']                     = 'Clé unique par élément (mode multi).';
$SEARCH['LABEL_TITLE_COL']                   = 'Colonne titre';
$SEARCH['LABEL_TEXT_COLS']                   = 'Colonnes de texte';
$SEARCH['LABEL_LINK_COL']                    = 'Colonne lien';
$SEARCH['HINT_LINK_PREFIX']                  = 'Préfixe facultatif : {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Colonne image';
$SEARCH['HINT_IMAGE_PATH']                   = 'Chemin sous /media, espaces réservés comme {item_id} autorisés.';
$SEARCH['LABEL_NONE']                        = 'aucune';
$SEARCH['LABEL_MODE']                        = 'Mode';
$SEARCH['MODE_SINGLE']                       = 'Simple — une entrée par section';
$SEARCH['MODE_MULTI']                        = 'Multi — une entrée par élément';
$SEARCH['LABEL_INDEX_BASE']                  = 'Base de l\'index';
$SEARCH['LABEL_FILTER']                      = 'Filtre';
$SEARCH['LABEL_NO_JOIN']                     = 'pas de jointure';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Veuillez choisir une table de module valide.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Aucune table exploitable trouvée dans le search.php de %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Aucune page',
    'one' => '%d page',
    'other' => '%d pages',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Enregistrer';
$SEARCH['MSG_SECURITY_ERROR']                = 'Échec du contrôle de sécurité.';
$SEARCH['STATUS_ACTIVE']                     = 'Actif';
$SEARCH['STATUS_INACTIVE']                   = 'Inactif';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'à','au','aux','avec','ce','ces','cette','cet','dans','de','des','du','elle',
    'elles','en','et','eux','il','ils','je','la','le','les','leur','leurs','lui',
    'ma','mais','me','même','mes','moi','mon','ne','nos','notre','nous','on','ou',
    'où','par','pas','pour','qu','que','qui','sa','se','ses','son','sur','ta','te',
    'tes','toi','ton','tu','un','une','vos','votre','vous','été','être','est',
    'sont','était','ont','avait','avoir','fait','faire','comme','plus','tout',
    'tous','toute','toutes','aussi','donc','alors','si','sans','sous','entre',
    'vers','chez','ainsi','car','ni','très','bien','peu','déjà','encore','y','dont',
    'cela','ça','ceci','celui','celle','ceux',
];
