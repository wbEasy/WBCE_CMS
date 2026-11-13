<?php
/**
 * wbce_search - languages/ES.php
 * Español
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Configuración avanzada de la búsqueda. Índice, módulos, diseños y estadísticas de la búsqueda de WBCE CMS: búsqueda de texto completo con operadores, sugerencias en vivo, resaltado de resultados en la página de destino y nube de etiquetas.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Buscar';
$SEARCH['SEARCH_HEADING']                    = 'Búsqueda';
$SEARCH['RESULTS_FOR']                       = 'Resultados para';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Sin resultados',
    'one' => '%d resultado',
    'other' => '%d resultados',
];
$SEARCH['NO_RESULTS']                        = 'No se encontraron resultados.';
$SEARCH['ALL_WORDS']                         = 'Todas las palabras';
$SEARCH['ANY_WORDS']                         = 'Alguna palabra';
$SEARCH['EXACT_MATCH']                       = 'Frase exacta';
$SEARCH['MATCH']                             = 'Modo de búsqueda';
$SEARCH['PAGES']                             = 'Páginas';
$SEARCH['TIPS_TITLE']                        = 'Consejos de búsqueda:';
$SEARCH['TIP_FEWER']                         = 'Use menos términos';
$SEARCH['TIP_OR']                            = 'Búsqueda O:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'otroTérmino';
$SEARCH['TIP_NOT']                           = 'Excluir:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'excluir';
$SEARCH['TIP_PHRASE']                        = 'Frase exacta:';
$SEARCH['TIP_WILDCARD']                      = 'Comodín:';
$SEARCH['TIP_FUZZY']                         = 'Tolerar errores:';
$SEARCH['DID_YOU_MEAN']                      = '¿Quiso decir:';
$SEARCH['SCOPE_TITLE']                       = 'Solo título';
$SEARCH['SCOPE_CONTENT']                     = 'Solo contenido';
$SEARCH['SEARCH_OR']                         = 'Búsqueda O (al menos un término)';
$SEARCH['AREAS_TITLE']                       = 'Explorar por tema:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Búsquedas frecuentes:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'buscado una vez',
    'other' => 'buscado %d veces',
];
$SEARCH['HIT_CONTENT']                       = 'Contenido';
$SEARCH['HIT_KEYWORD']                       = 'Palabra clave';
$SEARCH['HIT_DESCRIPTION']                   = 'Descripción';
$SEARCH['HIT_TITLE']                         = 'Título';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Comodín';
$SEARCH['LEGEND_FUZZY']                      = 'Tolerar errores';
$SEARCH['LEGEND_PHRASE']                     = 'Frase exacta';
$SEARCH['LEGEND_EXCLUDE']                    = 'Excluir término';
$SEARCH['LEGEND_OR']                         = 'Uno u otro término';
$SEARCH['LEGEND_COMBINATION']                = 'Combinación';
$SEARCH['LEGEND_OPERATORS']                  = 'Operadores';
$SEARCH['OP_EXCLUDE']                        = 'excluir';
$SEARCH['OP_WILDCARD']                       = 'comodín';
$SEARCH['OP_TYPOS']                          = 'errores';
$SEARCH['OP_PHRASE']                         = 'frase';
$SEARCH['OP_OR']                             = 'o';
$SEARCH['EXAMPLE_WORD']                      = 'mostaza';
$SEARCH['EXAMPLE_WORD2']                     = 'ecológica';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'picante';
$SEARCH['EXAMPLE_OR']                        = 'kétchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'mostaza amarilla';
$SEARCH['EXAMPLE_PHRASE2']                   = 'de maíz';
$SEARCH['LABEL_LEGEND']                      = 'Leyenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Término encontrado en el contenido de la página';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Término encontrado en las palabras clave de la página';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Término encontrado en la descripción de la página';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Término encontrado en el título';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Término en contenido y palabras clave';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Término en contenido y descripción';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Término en palabras clave y descripción';
$SEARCH['LEGEND_HIT_ALL']                    = 'Término en los tres campos';
$SEARCH['PAGE_PREV']                         = 'Página anterior';
$SEARCH['PAGE_NEXT']                         = 'Página siguiente';
$SEARCH['DROPLET_DESCRIPTION']               = 'Nube de los términos más buscados. Parámetros: max=20, min_count=1, desc=Etiqueta, active=true (false = oculta)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Resumen';
$SEARCH['MENU_MODULES']                      = 'Módulos';
$SEARCH['MENU_LAYOUT']                       = 'Diseño';
$SEARCH['MENU_SETTINGS']                     = 'Ajustes';
$SEARCH['MENU_STATS']                        = 'Estadísticas';
$SEARCH['CRUMB_OVERVIEW']                    = 'Estado y mantenimiento del índice de búsqueda';
$SEARCH['CRUMB_MODULES']                     = 'Qué módulos alimentan el índice de búsqueda';
$SEARCH['CRUMB_LAYOUT']                      = 'Plantilla de la página de resultados';
$SEARCH['CRUMB_SETTINGS']                    = 'Comportamiento de la búsqueda, búsqueda en vivo, nube de etiquetas';
$SEARCH['CRUMB_STATS']                       = 'Qué buscan los visitantes';
$SEARCH['LEDE_OVERVIEW']                     = 'Estado actual del índice de búsqueda y de la búsqueda en el sitio.';
$SEARCH['LEDE_MODULES']                      = 'Cómo se indexa cada módulo instalado. Los módulos sin definición solo aportan el título de su página.';
$SEARCH['LEDE_LAYOUT']                       = 'Qué diseño y qué hoja de estilos usan la página de búsqueda y la nube de etiquetas. Los archivos incluidos y los de la plantilla no se modifican; siempre edita su propia copia.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Página de resultados';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Diseño de la página /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Nube de etiquetas';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Diseño del droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Hoja de estilos';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Para la página de resultados y la nube de etiquetas';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'El CSS de %1$s aparece aquí · "Editar" crea %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Sin hoja de estilos';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'la plantilla trae todos los estilos';
$SEARCH['LAYOUT_ACTIVE']                     = 'activo';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'archivo propio';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'de la plantilla "%s"';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'incluido';
$SEARCH['LAYOUT_READONLY']                   = 'solo lectura';
$SEARCH['LAYOUT_MODIFIED']                   = 'modificado %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'el archivo de la plantilla %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'el archivo incluido %s';
$SEARCH['BTN_EDIT']                          = 'Editar';
$SEARCH['BTN_DELETE']                        = 'Eliminar';
$SEARCH['BTN_BACK']                          = 'Volver';
$SEARCH['BTN_SAVE_BACK']                     = 'Guardar y volver';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Se creará un nuevo archivo %1\$s como copia de %2\$s.\n\nLa copia se edita y pasa a ser el diseño activo; el original no cambia.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s ya existe. ¿Sobrescribirlo con el contenido de %2\$s y editarlo?\n\nSu versión actual de %1\$s se perderá.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "¿Eliminar %s?\n\nEsta acción no se puede deshacer.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Diseño activo: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s creado';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s eliminado';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Hoja de estilos: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Puntuación, extractos, búsqueda en vivo y nube de etiquetas.';
$SEARCH['LEDE_STATS']                        = 'Términos de búsqueda registrados para la nube de etiquetas (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Índice de búsqueda';
$SEARCH['INDEX_BUILD']                       = 'Reconstrucción completa';
$SEARCH['INDEX_UPDATE']                      = 'Actualizar cambios';
$SEARCH['INDEX_CLEAR']                       = 'Vaciar índice';
$SEARCH['ENTRIES']                           = 'Entradas';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Índice creado — nada que indexar.',
    'one' => 'Índice creado: %d entrada.',
    'other' => 'Índice creado: %d entradas.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Nada que actualizar.',
    'one' => '%d entrada actualizada.',
    'other' => '%d entradas actualizadas.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Índice eliminado.';
$SEARCH['CONFIRM_INDEX_DELETE']              = '¿Eliminar realmente todo el índice?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Búsqueda en el sitio';
$SEARCH['LABEL_LAST_INDEXED']                = 'Última indexación';
$SEARCH['INDEX_BUILD_DESC']                  = 'Vuelve a leer <b>todas</b> las secciones buscables. Tarda en sitios grandes.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Lee solo las secciones modificadas o que faltan. Más rápido que una reconstrucción completa.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Lee solo las secciones modificadas o que faltan. Ahora mismo no hay nada que hacer.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Vacía el índice. La búsqueda no encuentra nada hasta que se reconstruya.';
$SEARCH['LABEL_FRESHNESS']                   = 'Actualidad';
$SEARCH['FRESH_ALL']                         = '<b>El índice está al día</b> — las %d secciones coinciden con su último cambio.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d de %2$d</b> secciones han cambiado o faltan.';
$SEARCH['FRESH_NONE']                        = 'Todavía no hay secciones buscables.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Búsqueda en el sitio';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Ajustes › Búsqueda';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Pública';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registrados';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privada';
$SEARCH['SITE_SEARCH_NONE']                  = 'Desactivada';
$SEARCH['HINT_SITE_SEARCH']                  = 'Quién puede buscar — para cada campo de búsqueda del sitio, sea cual sea la búsqueda que haya detrás. El mismo ajuste que en <a href="%s">Ajustes › Búsqueda</a>; "Registrados" y "Privada" significan ambos: solo visitantes con sesión iniciada.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "¿Establecer la búsqueda en el sitio en \"%s\"?\n\nEsto cambia el ajuste \"Búsqueda\" del sitio para todos los visitantes.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Búsqueda en el sitio: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Idiomas';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Sin información de idioma';
$SEARCH['VIS_HIDDEN']                        = 'Oculta';
$SEARCH['VIS_PUBLIC']                        = 'Pública';
$SEARCH['VIS_PRIVATE']                       = 'Privada';
$SEARCH['VIS_REGISTERED']                    = 'Registrados';
$SEARCH['VIS_NONE']                          = 'Ninguna';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'El diseño está vacío y no se ha guardado.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'No se pudo escribir search_custom.htt. Compruebe los permisos de escritura de la carpeta layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Con "AjaxSave" marcado, Guardar y Ctrl+S guardan sin recargar la página; "Guardar y volver" se oculta entonces.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Longitud mínima de palabra';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Las palabras más cortas se ignoran';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Peso del título';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Coincidencias en el título × factor';
$SEARCH['SET_MAX_EXCERPT']                   = 'Longitud máx. del extracto';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Caracteres por extracto';
$SEARCH['SET_HIGHLIGHT']                     = 'Resaltado';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Resaltar los términos buscados en el extracto';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Etiqueta de resaltado';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Etiqueta HTML usada para el resaltado';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Resultados por página';
$SEARCH['SET_AUTO_REINDEX']                  = 'Reindexación automática al buscar';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Actualiza en silencio las entradas obsoletas en cada búsqueda';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Mostrar nube de etiquetas';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'En la página de búsqueda. El droplet tiene su propio parámetro active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Registrar búsquedas';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Registra las búsquedas para la nube de etiquetas y las estadísticas — desactivarlo no oculta la nube';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Búsqueda en vivo AJAX';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Mostrar sugerencias mientras se escribe';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Modo de depuración';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Muestra datos técnicos bajo cada resultado (solo administradores)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Plantilla de la página de búsqueda';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Plantilla del frontend en la que se muestra la página /search/.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Plantilla predeterminada del sitio (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Búsqueda';
$SEARCH['GROUP_DISPLAY']                     = 'Presentación de resultados';
$SEARCH['GROUP_INDEX']                       = 'Mantenimiento del índice';
$SEARCH['GROUP_LIVE']                        = 'Búsqueda en vivo';
$SEARCH['GROUP_TAGCLOUD']                    = 'Nube de etiquetas';
$SEARCH['GROUP_ADMIN']                       = 'Herramienta de administración';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Tamaño de página de la lista de resultados';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Filtro de idioma';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Mostrar solo páginas en el idioma del visitante (predeterminado del sitio: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Búsqueda avanzada';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Mostrar las casillas de ámbito y la opción O en el formulario';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Máx. secciones por búsqueda';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Límite para la reindexación automática (control de carga)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Origen de las sugerencias';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Híbrido muestra primero las coincidencias de título y completa con páginas que contienen la palabra en su texto';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Máx. sugerencias';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Número de sugerencias mostradas';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Imágenes en las sugerencias';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Muestra la imagen del elemento (catálogo, noticias …) junto a la sugerencia, si el módulo indexa una';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Máx. etiquetas';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Número de términos mostrados en la nube';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Mín. búsquedas';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Número mínimo de búsquedas antes de que aparezca un término';
$SEARCH['SET_NAV_STYLE']                     = 'Navegación';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Pestañas arriba o una barra de iconos a la izquierda';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Primero títulos, completados con el texto completo (recomendado)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Título + descripción (rápido)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Índice de texto completo (exhaustivo)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Pestañas arriba';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Barra lateral a la izquierda';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpoint';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Se detecta automáticamente en la página de búsqueda para campos con nombre "string", type="search" o clase ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Ajustes guardados.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Estadísticas de búsqueda eliminadas.';
$SEARCH['CONFIRM_STATS_DELETE']              = '¿Eliminar realmente todas las estadísticas?';
$SEARCH['STATS_DELETE']                      = 'Eliminar estadísticas';
$SEARCH['STATS_TERM']                        = 'Término de búsqueda';
$SEARCH['STATS_COUNT']                       = 'Cantidad';
$SEARCH['STATS_LAST']                        = 'Última búsqueda';
$SEARCH['STATS_TERMS']                       = 'Términos';
$SEARCH['STATS_SEARCHES']                    = 'Búsquedas';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 de %d término.',
    'other' => 'Top 100 de %d términos.',
];
$SEARCH['STATS_EMPTY']                       = 'Todavía no hay términos de búsqueda registrados.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Buscado, nada encontrado';
$SEARCH['HINT_STATS_MISSES']                 = 'Consultas completas sin resultado — una pista sobre contenidos que sus visitantes esperan y no encuentran. Nunca se muestra públicamente.';
$SEARCH['STATS_QUERY']                       = 'Consulta';
$SEARCH['STATS_MISSES_EMPTY']                = 'No hay búsquedas sin resultado registradas.';
$SEARCH['CARD_WORDS']                        = 'Índice de palabras';
$SEARCH['HINT_WORDS']                        = 'Para sitios grandes: una lista de todas las palabras, para que una búsqueda ya no tenga que leer todo el índice. Se crea automáticamente a partir de %s entradas de índice.';
$SEARCH['WORDS_INACTIVE']                    = 'Inactivo — el sitio está por debajo del umbral (%2$s entradas de índice, ahora %1$s); la búsqueda normal es suficientemente rápida.';
$SEARCH['WORDS_OFF']                         = 'Desactivado en los ajustes.';
$SEARCH['WORDS_BUILDING']                    = 'En construcción';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Continuar la construcción';
$SEARCH['MSG_WORDS_READY']                   = 'Índice de palabras completo.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Índice de palabras: queda %d entrada pendiente — hasta entonces se usa la búsqueda normal.',
    'other' => 'Índice de palabras: quedan %d entradas pendientes — hasta entonces se usa la búsqueda normal.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'En uso — %d entrada de palabra.',
    'other' => 'En uso — %d entradas de palabras.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Índice de palabras';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automático: se crea solo cuando el sitio alcanza el umbral de abajo. Los sitios pequeños no lo necesitan.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automático';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Siempre activo';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Desactivado';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Índice de palabras desde';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Número de entradas indexadas (secciones y elementos de módulos) a partir del cual el índice de palabras se crea automáticamente';
$SEARCH['BTN_DELETE_TERM']                   = 'Quitar este término';
$SEARCH['MSG_TERM_DELETED']                  = 'Término quitado.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semiconfiguración de <b>%s</b> precargada desde search.php — revísela y ajústela.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semiconfiguración de \'%s\' guardada.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Configuración y entradas de índice de %s eliminadas.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php generado. Reconstruya el índice.';
$SEARCH['CONFIRM_MOD_DELETE']                = '¿Eliminar la configuración y las entradas de índice de %s?';
$SEARCH['STATUS_SEMI']                       = 'Semiconfiguración';
$SEARCH['LABEL_GUIDE']                       = 'Mostrar la guía de este módulo';
$SEARCH['LABEL_TABLE_HINT']                  = 'Elija una tabla → las columnas se cargan automáticamente';
$SEARCH['LABEL_TABLE_SELECT']                = 'Elegir tabla';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Ancla de página WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Solo páginas buscables';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Todas las secciones (fondo de contenido)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Solo entradas activas (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Control temporal (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (opcional, máx. 3) — datos de tablas adicionales';
$SEARCH['LABEL_GENERATE_DEF']                = 'Generar archivo module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'Desde search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Eliminar configuración';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Sin columnas de texto';
$SEARCH['LABEL_ERROR']                       = 'Error';
$SEARCH['LABEL_MODULE']                      = 'Módulo';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'No buscable';
$SEARCH['LABEL_HELP']                        = 'Ayuda';
$SEARCH['BTN_CONFIGURE']                     = 'Configurar';
$SEARCH['BTN_CLOSE']                         = 'Cerrar';
$SEARCH['DEF_GENERATED']                     = 'generada';
$SEARCH['DEF_SHIPPED']                       = 'integrada';
$SEARCH['LABEL_KIND']                        = 'Tipo';
$SEARCH['LABEL_INDEXING']                    = 'Indexación';
$SEARCH['LABEL_SECTIONS']                    = 'Secciones';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrar …';
$SEARCH['MODULES_SHOWN']                     = '%1$d de %2$d módulos mostrados';
$SEARCH['KIND_PAGE']                         = 'Módulos de página';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtros';
$SEARCH['KIND_TOOL']                         = 'Herramientas de administración';
$SEARCH['BADGE_PAGE']                        = 'Página';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtro';
$SEARCH['BADGE_TOOL']                        = 'Herramienta';
$SEARCH['GROUP_DEF']                         = 'con definición';
$SEARCH['GROUP_OPEN']                        = 'incompleto';
$SEARCH['GROUP_TITLE']                       = 'solo título de página';
$SEARCH['SOURCE_MODULE']                     = 'Del módulo';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Integrada';
$SEARCH['SOURCE_GENERATED']                  = 'Semiconfiguración';
$SEARCH['SOURCE_SEMI']                       = 'Semiconfiguración – no generada';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php encontrado';
$SEARCH['SOURCE_TITLE']                      = 'Solo título de página';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'El módulo trae su propia definición de búsqueda (search_index.php) — no editable aquí.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indexado mediante un callback PHP — no editable aquí.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definición incluida con WBCE Search (module_defs/). Una semiconfiguración tiene prioridad.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definición generada a partir de la semiconfiguración.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semiconfiguración guardada, pero aún sin definición generada.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Aún sin definición — puede precargarse desde el antiguo search.php del módulo.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Sin definición — el índice solo contiene el título de la página.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Sin secciones de página — nada que indexar.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Búsqueda desactivada para esta página';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Definición integrada. Al guardar se crea una semiconfiguración que tiene prioridad.';
$SEARCH['LABEL_TABLE']                       = 'Tabla';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tablas de este módulo';
$SEARCH['LABEL_OTHER_TABLES']                = 'Otras tablas de módulos';
$SEARCH['HINT_TABLE']                        = 'Solo se pueden indexar tablas mod_* con una columna section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Columna ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Clave de elemento';
$SEARCH['HINT_ITEM_KEY']                     = 'Clave única por elemento (modo multi).';
$SEARCH['LABEL_TITLE_COL']                   = 'Columna de título';
$SEARCH['LABEL_TEXT_COLS']                   = 'Columnas de texto';
$SEARCH['LABEL_LINK_COL']                    = 'Columna de enlace';
$SEARCH['HINT_LINK_PREFIX']                  = 'Prefijo opcional: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Columna de imagen';
$SEARCH['HINT_IMAGE_PATH']                   = 'Ruta bajo /media, se permiten marcadores como {item_id}.';
$SEARCH['LABEL_NONE']                        = 'ninguna';
$SEARCH['LABEL_MODE']                        = 'Modo';
$SEARCH['MODE_SINGLE']                       = 'Simple — una entrada por sección';
$SEARCH['MODE_MULTI']                        = 'Multi — una entrada por elemento';
$SEARCH['LABEL_INDEX_BASE']                  = 'Base del índice';
$SEARCH['LABEL_FILTER']                      = 'Filtro';
$SEARCH['LABEL_NO_JOIN']                     = 'sin join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Elija una tabla de módulo válida.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'No se encontró ninguna tabla utilizable en el search.php de %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Sin páginas',
    'one' => '%d página',
    'other' => '%d páginas',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Guardar';
$SEARCH['MSG_SECURITY_ERROR']                = 'Falló la comprobación de seguridad.';
$SEARCH['STATUS_ACTIVE']                     = 'Activo';
$SEARCH['STATUS_INACTIVE']                   = 'Inactivo';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'a','al','algo','algunos','ante','antes','como','con','contra','cual','cuando',
    'de','del','desde','donde','durante','e','el','él','ella','ellas','ellos','en',
    'entre','era','es','esa','esas','ese','eso','esos','esta','está','están',
    'estas','este','esto','estos','fue','fueron','ha','han','hasta','hay','la',
    'las','le','les','lo','los','más','me','mi','mis','mucho','muy','nada','ni',
    'no','nos','nosotros','o','otra','otro','para','pero','poco','por','porque',
    'que','qué','quien','se','sea','ser','si','sí','sin','sobre','son','su','sus',
    'también','tanto','te','tiene','todo','todos','tu','tus','un','una','uno',
    'unos','y','ya','yo',
];
