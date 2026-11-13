<?php
/**
 * wbce_search - languages/PT.php
 * Português
 * Plural keys are arrays for Ln_() (framework/i18n): 'zero' (optional, n = 0),
 * 'one', 'few', 'many', 'other' — whichever the language's CLDR rule uses.
 * @module wbce_search  @license GNU General Public License
 */
defined('WB_PATH') or die("No direct access");

$module_name        = 'WBCE Search';
$module_description = 'Configurações avançadas da pesquisa. Índice, módulos, layouts e estatísticas da pesquisa do WBCE CMS: pesquisa de texto completo com operadores, sugestões em tempo real, destaque dos resultados na página de destino e nuvem de tags.';

// ── Frontend (search page, live search, tag cloud droplet) ──────────────────────
$SEARCH['SEARCH']                            = 'Pesquisar';
$SEARCH['SEARCH_HEADING']                    = 'Pesquisa';
$SEARCH['RESULTS_FOR']                       = 'Resultados para';
$SEARCH['RESULT_COUNT']                      = [
    'zero' => 'Sem resultados',
    'one' => '%d resultado',
    'other' => '%d resultados',
];
$SEARCH['NO_RESULTS']                        = 'Nenhum resultado encontrado.';
$SEARCH['ALL_WORDS']                         = 'Todas as palavras';
$SEARCH['ANY_WORDS']                         = 'Qualquer palavra';
$SEARCH['EXACT_MATCH']                       = 'Frase exata';
$SEARCH['MATCH']                             = 'Modo de pesquisa';
$SEARCH['PAGES']                             = 'Páginas';
$SEARCH['TIPS_TITLE']                        = 'Dicas de pesquisa:';
$SEARCH['TIP_FEWER']                         = 'Use menos termos';
$SEARCH['TIP_OR']                            = 'Pesquisa OU:';
$SEARCH['TIP_OR_EXAMPLE']                    = 'outroTermo';
$SEARCH['TIP_NOT']                           = 'Excluir:';
$SEARCH['TIP_NOT_EXAMPLE']                   = 'excluir';
$SEARCH['TIP_PHRASE']                        = 'Frase exata:';
$SEARCH['TIP_WILDCARD']                      = 'Curinga:';
$SEARCH['TIP_FUZZY']                         = 'Tolerar erros de digitação:';
$SEARCH['DID_YOU_MEAN']                      = 'Quis dizer:';
$SEARCH['SCOPE_TITLE']                       = 'Apenas título';
$SEARCH['SCOPE_CONTENT']                     = 'Apenas conteúdo';
$SEARCH['SEARCH_OR']                         = 'Pesquisa OU (pelo menos um termo)';
$SEARCH['AREAS_TITLE']                       = 'Navegar por tema:';
$SEARCH['TAGCLOUD_LABEL']                    = 'Pesquisas frequentes:';
$SEARCH['TAG_SEARCHED']                      = [
    'one' => 'pesquisado uma vez',
    'other' => 'pesquisado %d vezes',
];
$SEARCH['HIT_CONTENT']                       = 'Conteúdo';
$SEARCH['HIT_KEYWORD']                       = 'Palavra-chave';
$SEARCH['HIT_DESCRIPTION']                   = 'Descrição';
$SEARCH['HIT_TITLE']                         = 'Título';
// search tips table + hit legend (layouts/search_default.htt)
$SEARCH['LEGEND_WILDCARD']                   = 'Curinga';
$SEARCH['LEGEND_FUZZY']                      = 'Tolerar erros de digitação';
$SEARCH['LEGEND_PHRASE']                     = 'Frase exata';
$SEARCH['LEGEND_EXCLUDE']                    = 'Excluir termo';
$SEARCH['LEGEND_OR']                         = 'Um ou outro termo';
$SEARCH['LEGEND_COMBINATION']                = 'Combinação';
$SEARCH['LEGEND_OPERATORS']                  = 'Operadores';
$SEARCH['OP_EXCLUDE']                        = 'excluir';
$SEARCH['OP_WILDCARD']                       = 'curinga';
$SEARCH['OP_TYPOS']                          = 'erros';
$SEARCH['OP_PHRASE']                         = 'frase';
$SEARCH['OP_OR']                             = 'ou';
$SEARCH['EXAMPLE_WORD']                      = 'mostarda';
$SEARCH['EXAMPLE_WORD2']                     = 'biológica';
$SEARCH['EXAMPLE_EXCLUDE']                   = 'picante';
$SEARCH['EXAMPLE_OR']                        = 'ketchup';
$SEARCH['EXAMPLE_PHRASE']                    = 'mostarda amarela';
$SEARCH['EXAMPLE_PHRASE2']                   = 'de milho';
$SEARCH['LABEL_LEGEND']                      = 'Legenda';
$SEARCH['LEGEND_HIT_CONTENT']                = 'Termo encontrado no conteúdo da página';
$SEARCH['LEGEND_HIT_KEYWORD']                = 'Termo encontrado nas palavras-chave da página';
$SEARCH['LEGEND_HIT_DESCRIPTION']            = 'Termo encontrado na descrição da página';
$SEARCH['LEGEND_HIT_TITLE']                  = 'Termo encontrado no título';
$SEARCH['LEGEND_HIT_CONTENT_KEYWORD']        = 'Termo no conteúdo e nas palavras-chave';
$SEARCH['LEGEND_HIT_CONTENT_DESCRIPTION']    = 'Termo no conteúdo e na descrição';
$SEARCH['LEGEND_HIT_KEYWORD_DESCRIPTION']    = 'Termo nas palavras-chave e na descrição';
$SEARCH['LEGEND_HIT_ALL']                    = 'Termo nos três campos';
$SEARCH['PAGE_PREV']                         = 'Página anterior';
$SEARCH['PAGE_NEXT']                         = 'Página seguinte';
$SEARCH['DROPLET_DESCRIPTION']               = 'Nuvem dos termos mais pesquisados. Parâmetros: max=20, min_count=1, desc=Rótulo, active=true (false = oculta)';

// ── Backend: Navigation / page headers ─────────────────────────────────────
$SEARCH['MENU_OVERVIEW']                     = 'Visão geral';
$SEARCH['MENU_MODULES']                      = 'Módulos';
$SEARCH['MENU_LAYOUT']                       = 'Layout';
$SEARCH['MENU_SETTINGS']                     = 'Configurações';
$SEARCH['MENU_STATS']                        = 'Estatísticas';
$SEARCH['CRUMB_OVERVIEW']                    = 'Estado e manutenção do índice de pesquisa';
$SEARCH['CRUMB_MODULES']                     = 'Que módulos alimentam o índice de pesquisa';
$SEARCH['CRUMB_LAYOUT']                      = 'Modelo da página de resultados';
$SEARCH['CRUMB_SETTINGS']                    = 'Comportamento da pesquisa, pesquisa ao vivo, nuvem de etiquetas';
$SEARCH['CRUMB_STATS']                       = 'O que os visitantes pesquisam';
$SEARCH['LEDE_OVERVIEW']                     = 'Estado atual do índice de pesquisa e da pesquisa no site.';
$SEARCH['LEDE_MODULES']                      = 'Como cada módulo instalado é indexado. Módulos sem definição contribuem apenas com o título da página.';
$SEARCH['LEDE_LAYOUT']                       = 'Que layout e que folha de estilos usam a página de pesquisa e a nuvem de etiquetas. Os ficheiros fornecidos e os do template ficam inalterados; edita sempre a sua própria cópia.';
$SEARCH['LAYOUT_CARD_SEARCH']                = 'Página de resultados';
$SEARCH['LAYOUT_CARD_SEARCH_SUB']            = 'Layout da página /search/';
$SEARCH['LAYOUT_CARD_TAGCLOUD']              = 'Nuvem de etiquetas';
$SEARCH['LAYOUT_CARD_TAGCLOUD_SUB']          = 'Layout do droplet [[wbce_search_tagcloud]]';
$SEARCH['LAYOUT_CARD_CSS']                   = 'Folha de estilos';
$SEARCH['LAYOUT_CARD_CSS_SUB']               = 'Para a página de resultados e a nuvem de etiquetas';
$SEARCH['LAYOUT_CSS_LEDE']                   = 'O CSS de %1$s aparece aqui · "Editar" cria %2$s';
$SEARCH['LAYOUT_CSS_NONE']                   = 'Sem folha de estilos';
$SEARCH['LAYOUT_CSS_NONE_HINT']              = 'o template traz todos os estilos';
$SEARCH['LAYOUT_ACTIVE']                     = 'ativo';
$SEARCH['LAYOUT_SRC_CUSTOM']                 = 'ficheiro próprio';
$SEARCH['LAYOUT_SRC_TEMPLATE']               = 'do template "%s"';
$SEARCH['LAYOUT_SRC_DEFAULT']                = 'fornecido';
$SEARCH['LAYOUT_READONLY']                   = 'só leitura';
$SEARCH['LAYOUT_MODIFIED']                   = 'alterado %s';
$SEARCH['LAYOUT_FROM_TEMPLATE']              = 'o ficheiro do template %s';
$SEARCH['LAYOUT_FROM_DEFAULT']               = 'o ficheiro fornecido %s';
$SEARCH['BTN_EDIT']                          = 'Editar';
$SEARCH['BTN_DELETE']                        = 'Eliminar';
$SEARCH['BTN_BACK']                          = 'Voltar';
$SEARCH['BTN_SAVE_BACK']                     = 'Guardar e voltar';
$SEARCH['CONFIRM_LAYOUT_CREATE']             = "Será criado um novo ficheiro %1\$s como cópia de %2\$s.\n\nA cópia é editada e passa a ser o layout ativo; o original fica inalterado.";
$SEARCH['CONFIRM_LAYOUT_OVERWRITE']          = "%1\$s já existe. Substituí-lo pelo conteúdo de %2\$s e editá-lo?\n\nA sua versão atual de %1\$s será perdida.";
$SEARCH['CONFIRM_LAYOUT_DELETE']             = "Eliminar %s?\n\nEsta ação não pode ser anulada.";
$SEARCH['MSG_LAYOUT_ACTIVE']                 = 'Layout ativo: %s';
$SEARCH['MSG_LAYOUT_CREATED']                = '%s criado';
$SEARCH['MSG_LAYOUT_DELETED']                = '%s eliminado';
$SEARCH['MSG_STYLESHEET_ACTIVE']             = 'Folha de estilos: %s';
$SEARCH['LEDE_SETTINGS']                     = 'Pontuação, excertos, pesquisa ao vivo e nuvem de etiquetas.';
$SEARCH['LEDE_STATS']                        = 'Termos de pesquisa registados para a nuvem de etiquetas (top 100).';

// ── Backend: Overview ──────────────────────────────────────────────────────
$SEARCH['CARD_INDEX']                        = 'Índice de pesquisa';
$SEARCH['INDEX_BUILD']                       = 'Reconstrução completa';
$SEARCH['INDEX_UPDATE']                      = 'Atualizar alterações';
$SEARCH['INDEX_CLEAR']                       = 'Esvaziar índice';
$SEARCH['ENTRIES']                           = 'Entradas';
$SEARCH['MSG_INDEX_BUILT']                   = [
    'zero' => 'Índice criado — nada para indexar.',
    'one' => 'Índice criado: %d entrada.',
    'other' => 'Índice criado: %d entradas.',
];
$SEARCH['MSG_INDEX_UPDATED']                 = [
    'zero' => 'Nada para atualizar.',
    'one' => '%d entrada atualizada.',
    'other' => '%d entradas atualizadas.',
];
$SEARCH['MSG_INDEX_DELETED']                 = 'Índice eliminado.';
$SEARCH['CONFIRM_INDEX_DELETE']              = 'Eliminar mesmo todo o índice?';
$SEARCH['LABEL_FRONTEND_SEARCH']             = 'Pesquisa no site';
$SEARCH['LABEL_LAST_INDEXED']                = 'Última indexação';
$SEARCH['INDEX_BUILD_DESC']                  = 'Volta a ler <b>todas</b> as secções pesquisáveis. Demora em sites grandes.';
$SEARCH['INDEX_UPDATE_DESC']                 = 'Lê apenas as secções alteradas ou em falta. Mais rápido do que uma reconstrução completa.';
$SEARCH['INDEX_UPDATE_DESC_NONE']            = 'Lê apenas as secções alteradas ou em falta. Neste momento não há nada a fazer.';
$SEARCH['INDEX_CLEAR_DESC']                  = 'Esvazia o índice. A pesquisa não encontra nada até ser reconstruído.';
$SEARCH['LABEL_FRESHNESS']                   = 'Atualidade';
$SEARCH['FRESH_ALL']                         = '<b>O índice está atualizado</b> — todas as %d secções correspondem à última alteração.';
$SEARCH['FRESH_STALE']                       = '<b>%1$d de %2$d</b> secções foram alteradas ou estão em falta.';
$SEARCH['FRESH_NONE']                        = 'Ainda não há secções pesquisáveis.';
$SEARCH['LABEL_SITE_SEARCH']                 = 'Pesquisa no site';
$SEARCH['LABEL_SITE_SEARCH_SRC']             = 'Configurações › Pesquisa';
$SEARCH['SITE_SEARCH_PUBLIC']                = 'Pública';
$SEARCH['SITE_SEARCH_REGISTERED']            = 'Registados';
$SEARCH['SITE_SEARCH_PRIVATE']               = 'Privada';
$SEARCH['SITE_SEARCH_NONE']                  = 'Desligada';
$SEARCH['HINT_SITE_SEARCH']                  = 'Quem pode pesquisar — para cada campo de pesquisa do site, seja qual for a pesquisa por trás. A mesma configuração que em <a href="%s">Configurações › Pesquisa</a>; "Registados" e "Privada" significam ambos: apenas visitantes com sessão iniciada.';
$SEARCH['CONFIRM_SITE_SEARCH']               = "Definir a pesquisa no site como \"%s\"?\n\nIsto altera a configuração \"Pesquisa\" do site para todos os visitantes.";
$SEARCH['MSG_SITE_SEARCH_SAVED']             = 'Pesquisa no site: %s';
$SEARCH['LABEL_LANGUAGES']                   = 'Idiomas';
$SEARCH['LABEL_NO_LANG_INFO']                = 'Sem informação de idioma';
$SEARCH['VIS_HIDDEN']                        = 'Oculta';
$SEARCH['VIS_PUBLIC']                        = 'Pública';
$SEARCH['VIS_PRIVATE']                       = 'Privada';
$SEARCH['VIS_REGISTERED']                    = 'Registados';
$SEARCH['VIS_NONE']                          = 'Nenhuma';

// ── Backend: Layout ────────────────────────────────────────────────────────
$SEARCH['MSG_LAYOUT_EMPTY']                  = 'O layout está vazio e não foi guardado.';
$SEARCH['MSG_LAYOUT_SAVE_FAILED']            = 'Não foi possível escrever search_custom.htt. Verifique as permissões de escrita da pasta layouts.';
$SEARCH['HINT_LAYOUT_SAVE']                  = 'Com "AjaxSave" marcado, Guardar e Ctrl+S guardam sem recarregar a página; "Guardar e voltar" fica então oculto.';

// ── Backend: Settings ──────────────────────────────────────────────────────
$SEARCH['SET_MIN_LENGTH']                    = 'Comprimento mínimo da palavra';
$SEARCH['SET_MIN_LENGTH_HINT']               = 'Palavras mais curtas são ignoradas';
$SEARCH['SET_TITLE_WEIGHT']                  = 'Peso do título';
$SEARCH['SET_TITLE_WEIGHT_HINT']             = 'Ocorrências no título × fator';
$SEARCH['SET_MAX_EXCERPT']                   = 'Comprimento máx. do excerto';
$SEARCH['SET_MAX_EXCERPT_HINT']              = 'Caracteres por excerto';
$SEARCH['SET_HIGHLIGHT']                     = 'Realce';
$SEARCH['SET_HIGHLIGHT_HINT']                = 'Realçar os termos pesquisados no excerto';
$SEARCH['SET_HIGHLIGHT_TAG']                 = 'Tag de realce';
$SEARCH['SET_HIGHLIGHT_TAG_HINT']            = 'Tag HTML usada para o realce';
$SEARCH['SET_RESULTS_PER_PAGE']              = 'Resultados por página';
$SEARCH['SET_AUTO_REINDEX']                  = 'Reindexação automática ao pesquisar';
$SEARCH['SET_AUTO_REINDEX_HINT']             = 'Atualiza discretamente as entradas desatualizadas em cada pesquisa';
$SEARCH['SET_TAGCLOUD_SHOW']                 = 'Mostrar nuvem de etiquetas';
$SEARCH['SET_TAGCLOUD_SHOW_HINT']            = 'Na página de pesquisa. O droplet tem o seu próprio parâmetro active=true/false';
$SEARCH['SET_TAGCLOUD_TRACK']                = 'Registar pesquisas';
$SEARCH['SET_TAGCLOUD_TRACK_HINT']           = 'Regista as pesquisas para a nuvem de etiquetas e as estatísticas — desligar não oculta a nuvem';
$SEARCH['SET_AJAX_SUGGEST']                  = 'Pesquisa ao vivo AJAX';
$SEARCH['SET_AJAX_SUGGEST_HINT']             = 'Mostrar sugestões durante a escrita';
$SEARCH['SET_DEBUG_RESULTS']                 = 'Modo de depuração';
$SEARCH['SET_DEBUG_RESULTS_HINT']            = 'Mostra dados técnicos sob cada resultado (apenas administradores)';
$SEARCH['SET_PAGE_TEMPLATE']                 = 'Template da página de pesquisa';
$SEARCH['SET_PAGE_TEMPLATE_HINT']            = 'Template do frontend em que a página /search/ é mostrada.';
$SEARCH['OPT_TEMPLATE_DEFAULT']              = 'Template predefinido do site (%s)';
$SEARCH['GROUP_SEARCH']                      = 'Pesquisa';
$SEARCH['GROUP_DISPLAY']                     = 'Apresentação dos resultados';
$SEARCH['GROUP_INDEX']                       = 'Manutenção do índice';
$SEARCH['GROUP_LIVE']                        = 'Pesquisa ao vivo';
$SEARCH['GROUP_TAGCLOUD']                    = 'Nuvem de etiquetas';
$SEARCH['GROUP_ADMIN']                       = 'Ferramenta de administração';
$SEARCH['SET_RESULTS_PER_PAGE_HINT']         = 'Tamanho de página da lista de resultados';
$SEARCH['SET_LANGUAGE_FILTER']               = 'Filtro de idioma';
$SEARCH['SET_LANGUAGE_FILTER_HINT']          = 'Mostrar apenas páginas no idioma do visitante (predefinição do site: %s)';
$SEARCH['SET_ADVANCED_SEARCH']               = 'Pesquisa avançada';
$SEARCH['SET_ADVANCED_SEARCH_HINT']          = 'Mostrar no formulário as caixas de âmbito e a opção OU';
$SEARCH['SET_AUTO_REINDEX_LIMIT']            = 'Máx. secções por pesquisa';
$SEARCH['SET_AUTO_REINDEX_LIMIT_HINT']       = 'Limite da reindexação automática (controlo de carga)';
$SEARCH['SET_AJAX_SUGGEST_MODE']             = 'Origem das sugestões';
$SEARCH['SET_AJAX_SUGGEST_MODE_HINT']        = 'Híbrido mostra primeiro as correspondências no título e completa com páginas que contêm a palavra no texto';
$SEARCH['SET_AJAX_SUGGEST_LIMIT']            = 'Máx. sugestões';
$SEARCH['SET_AJAX_SUGGEST_LIMIT_HINT']       = 'Número de sugestões mostradas';
$SEARCH['SET_AJAX_SUGGEST_THUMBS']           = 'Imagens nas sugestões';
$SEARCH['SET_AJAX_SUGGEST_THUMBS_HINT']      = 'Mostra a imagem do item (catálogo, notícias …) ao lado da sugestão, se o módulo indexar uma';
$SEARCH['SET_TAGCLOUD_MAX']                  = 'Máx. etiquetas';
$SEARCH['SET_TAGCLOUD_MAX_HINT']             = 'Número de termos mostrados na nuvem';
$SEARCH['SET_TAGCLOUD_MIN_COUNT']            = 'Mín. pesquisas';
$SEARCH['SET_TAGCLOUD_MIN_COUNT_HINT']       = 'Número mínimo de pesquisas antes de um termo aparecer';
$SEARCH['SET_NAV_STYLE']                     = 'Navegação';
$SEARCH['SET_NAV_STYLE_HINT']                = 'Separadores em cima ou uma barra de ícones à esquerda';
$SEARCH['OPT_HIGHLIGHT_TAG_MARK']            = '&lt;mark&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_STRONG']          = '&lt;strong&gt;';
$SEARCH['OPT_HIGHLIGHT_TAG_EM']              = '&lt;em&gt;';
$SEARCH['OPT_AJAX_SUGGEST_MODE_HYBRID']      = 'Primeiro títulos, completados pelo texto integral (recomendado)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_TITLE']       = 'Título + descrição (rápido)';
$SEARCH['OPT_AJAX_SUGGEST_MODE_FULLTEXT']    = 'Índice de texto integral (exaustivo)';
$SEARCH['OPT_NAV_STYLE_HORIZONTAL']          = 'Separadores em cima';
$SEARCH['OPT_NAV_STYLE_VERTICAL']            = 'Barra lateral à esquerda';
$SEARCH['LABEL_AJAX_ENDPOINT']               = 'Endpoint';
$SEARCH['HINT_LIVE_SEARCH_FIELDS']           = 'Detetado automaticamente na página de pesquisa para campos com o nome "string", type="search" ou classe ws-input.';
$SEARCH['MSG_SETTINGS_SAVED']                = 'Configurações guardadas.';

// ── Backend: Statistics ────────────────────────────────────────────────────
$SEARCH['MSG_STATS_DELETED']                 = 'Estatísticas de pesquisa eliminadas.';
$SEARCH['CONFIRM_STATS_DELETE']              = 'Eliminar mesmo todas as estatísticas?';
$SEARCH['STATS_DELETE']                      = 'Eliminar estatísticas';
$SEARCH['STATS_TERM']                        = 'Termo de pesquisa';
$SEARCH['STATS_COUNT']                       = 'Quantidade';
$SEARCH['STATS_LAST']                        = 'Última pesquisa';
$SEARCH['STATS_TERMS']                       = 'Termos';
$SEARCH['STATS_SEARCHES']                    = 'Pesquisas';
$SEARCH['STATS_SHOWING']                     = [
    'one' => 'Top 100 de %d termo.',
    'other' => 'Top 100 de %d termos.',
];
$SEARCH['STATS_EMPTY']                       = 'Ainda não há termos de pesquisa registados.';

// ── 0.5.0: word index + searches without results ──────────────────────────
$SEARCH['STATS_MISSES']                      = 'Pesquisado, nada encontrado';
$SEARCH['HINT_STATS_MISSES']                 = 'Consultas completas sem resultado — uma pista sobre conteúdos que os seus visitantes esperam mas não encontram. Nunca mostrado publicamente.';
$SEARCH['STATS_QUERY']                       = 'Consulta';
$SEARCH['STATS_MISSES_EMPTY']                = 'Não há pesquisas sem resultado registadas.';
$SEARCH['CARD_WORDS']                        = 'Índice de palavras';
$SEARCH['HINT_WORDS']                        = 'Para sites grandes: uma lista de todas as palavras, para que uma pesquisa já não tenha de ler todo o índice. Criado automaticamente a partir de %s entradas de índice.';
$SEARCH['WORDS_INACTIVE']                    = 'Inativo — o site está abaixo do limiar (%2$s entradas de índice, atualmente %1$s); a pesquisa normal é suficientemente rápida.';
$SEARCH['WORDS_OFF']                         = 'Desligado nas configurações.';
$SEARCH['WORDS_BUILDING']                    = 'Em construção';
$SEARCH['BTN_WORDS_CONTINUE']                = 'Continuar a construção';
$SEARCH['MSG_WORDS_READY']                   = 'Índice de palavras completo.';
$SEARCH['MSG_WORDS_PENDING']                 = [
    'one' => 'Índice de palavras: falta %d entrada — até lá é usada a pesquisa normal.',
    'other' => 'Índice de palavras: faltam %d entradas — até lá é usada a pesquisa normal.',
];
$SEARCH['WORDS_READY_ROWS']                  = [
    'one' => 'Em uso — %d entrada de palavra.',
    'other' => 'Em uso — %d entradas de palavras.',
];
$SEARCH['SET_WORD_INDEX']                    = 'Índice de palavras';
$SEARCH['SET_WORD_INDEX_HINT']               = 'Automático: criado apenas quando o site atinge o limiar abaixo. Sites pequenos não precisam dele.';
$SEARCH['OPT_WORD_INDEX_AUTO']               = 'Automático';
$SEARCH['OPT_WORD_INDEX_ON']                 = 'Sempre ligado';
$SEARCH['OPT_WORD_INDEX_OFF']                = 'Desligado';
$SEARCH['SET_WORD_INDEX_THRESHOLD']          = 'Índice de palavras a partir de';
$SEARCH['SET_WORD_INDEX_THRESHOLD_HINT']     = 'Número de entradas indexadas (secções e itens de módulos) a partir do qual o índice de palavras é criado automaticamente';
$SEARCH['BTN_DELETE_TERM']                   = 'Remover este termo';
$SEARCH['MSG_TERM_DELETED']                  = 'Termo removido.';

// ── Backend: Modules ───────────────────────────────────────────────────────
$SEARCH['MSG_SEMI_PRESET']                   = 'Semiconfiguração de <b>%s</b> pré-preenchida a partir de search.php — verifique e ajuste.';
$SEARCH['MSG_SEMI_SAVED']                    = 'Semiconfiguração de \'%s\' guardada.';
$SEARCH['MSG_SEMI_DELETED']                  = 'Configuração e entradas de índice de %s eliminadas.';
$SEARCH['MSG_DEF_GENERATED']                 = 'module_defs/%s.php gerado. Reconstrua o índice.';
$SEARCH['CONFIRM_MOD_DELETE']                = 'Eliminar a configuração e as entradas de índice de %s?';
$SEARCH['STATUS_SEMI']                       = 'Semiconfiguração';
$SEARCH['LABEL_GUIDE']                       = 'Mostrar o guia deste módulo';
$SEARCH['LABEL_TABLE_HINT']                  = 'Escolha a tabela → as colunas carregam automaticamente';
$SEARCH['LABEL_TABLE_SELECT']                = 'Escolher tabela';
$SEARCH['LABEL_PAGE_ANCHOR']                 = 'Âncora de página WBCE';
$SEARCH['LABEL_SEARCHABLE_PAGES']            = 'Apenas páginas pesquisáveis';
$SEARCH['LABEL_ALL_SECTIONS']                = 'Todas as secções (reservatório de conteúdo)';
$SEARCH['LABEL_ACTIVE_ONLY']                 = 'Apenas entradas ativas (active = 1)';
$SEARCH['LABEL_TIME_CONTROL']                = 'Controlo temporal (published_when / published_until)';
$SEARCH['LABEL_JOIN_CONFIG']                 = 'Joins (opcional, máx. 3) — dados de tabelas adicionais';
$SEARCH['LABEL_GENERATE_DEF']                = 'Gerar ficheiro module_defs';
$SEARCH['LABEL_FROM_SEARCH_PHP']             = 'A partir de search.php';
$SEARCH['LABEL_DELETE_CONFIG']               = 'Eliminar configuração';
$SEARCH['LABEL_NO_TEXT_COLS']                = 'Sem colunas de texto';
$SEARCH['LABEL_ERROR']                       = 'Erro';
$SEARCH['LABEL_MODULE']                      = 'Módulo';
$SEARCH['LABEL_NOT_SEARCHABLE']              = 'Não pesquisável';
$SEARCH['LABEL_HELP']                        = 'Ajuda';
$SEARCH['BTN_CONFIGURE']                     = 'Configurar';
$SEARCH['BTN_CLOSE']                         = 'Fechar';
$SEARCH['DEF_GENERATED']                     = 'gerada';
$SEARCH['DEF_SHIPPED']                       = 'integrada';
$SEARCH['LABEL_KIND']                        = 'Tipo';
$SEARCH['LABEL_INDEXING']                    = 'Indexação';
$SEARCH['LABEL_SECTIONS']                    = 'Secções';
$SEARCH['PLACEHOLDER_FILTER']                = 'Filtrar …';
$SEARCH['MODULES_SHOWN']                     = '%1$d de %2$d módulos mostrados';
$SEARCH['KIND_PAGE']                         = 'Módulos de página';
$SEARCH['KIND_SNIPPET']                      = 'Snippets';
$SEARCH['KIND_OUTPUT_FILTER']                = 'Filtros';
$SEARCH['KIND_TOOL']                         = 'Ferramentas de administração';
$SEARCH['BADGE_PAGE']                        = 'Página';
$SEARCH['BADGE_SNIPPET']                     = 'Snippet';
$SEARCH['BADGE_OUTPUT_FILTER']               = 'Filtro';
$SEARCH['BADGE_TOOL']                        = 'Ferramenta';
$SEARCH['GROUP_DEF']                         = 'com definição';
$SEARCH['GROUP_OPEN']                        = 'incompleto';
$SEARCH['GROUP_TITLE']                       = 'apenas título da página';
$SEARCH['SOURCE_MODULE']                     = 'Do módulo';
$SEARCH['SOURCE_CALLBACK']                   = 'Callback';
$SEARCH['SOURCE_SHIPPED']                    = 'Integrada';
$SEARCH['SOURCE_GENERATED']                  = 'Semiconfiguração';
$SEARCH['SOURCE_SEMI']                       = 'Semiconfiguração – não gerada';
$SEARCH['SOURCE_SEARCH_PHP']                 = 'search.php encontrado';
$SEARCH['SOURCE_TITLE']                      = 'Apenas título da página';
$SEARCH['SOURCE_NONE']                       = '—';
$SEARCH['HINT_SOURCE_MODULE']                = 'O módulo traz a sua própria definição de pesquisa (search_index.php) — não editável aqui.';
$SEARCH['HINT_SOURCE_CALLBACK']              = 'Indexado através de um callback PHP — não editável aqui.';
$SEARCH['HINT_SOURCE_SHIPPED']               = 'Definição fornecida com o WBCE Search (module_defs/). Uma semiconfiguração tem prioridade.';
$SEARCH['HINT_SOURCE_GENERATED']             = 'Definição gerada a partir da semiconfiguração.';
$SEARCH['HINT_SOURCE_SEMI']                  = 'Semiconfiguração guardada, mas ainda sem definição gerada.';
$SEARCH['HINT_SOURCE_SEARCH_PHP']            = 'Ainda sem definição — pode ser pré-preenchida a partir do antigo search.php do módulo.';
$SEARCH['HINT_SOURCE_TITLE']                 = 'Sem definição — o índice contém apenas o título da página.';
$SEARCH['HINT_SOURCE_NONE']                  = 'Sem secções de página — nada para indexar.';
$SEARCH['HINT_PAGE_SEARCH_OFF']              = 'Pesquisa desligada para esta página';
$SEARCH['HINT_SHIPPED_DEF']                  = 'Definição integrada. Guardar cria uma semiconfiguração que tem prioridade.';
$SEARCH['LABEL_TABLE']                       = 'Tabela';
$SEARCH['LABEL_OWN_TABLES']                  = 'Tabelas deste módulo';
$SEARCH['LABEL_OTHER_TABLES']                = 'Outras tabelas de módulos';
$SEARCH['HINT_TABLE']                        = 'Só podem ser indexadas tabelas mod_* com uma coluna section_id.';
$SEARCH['LABEL_ID_FIELD']                    = 'Coluna ID';
$SEARCH['LABEL_ITEM_KEY']                    = 'Chave do item';
$SEARCH['HINT_ITEM_KEY']                     = 'Chave única por item (modo multi).';
$SEARCH['LABEL_TITLE_COL']                   = 'Coluna do título';
$SEARCH['LABEL_TEXT_COLS']                   = 'Colunas de texto';
$SEARCH['LABEL_LINK_COL']                    = 'Coluna do link';
$SEARCH['HINT_LINK_PREFIX']                  = 'Prefixo opcional: {page_link} {item_id} {section_id} {page_id}';
$SEARCH['LABEL_IMAGE_COL']                   = 'Coluna da imagem';
$SEARCH['HINT_IMAGE_PATH']                   = 'Caminho sob /media, marcadores como {item_id} permitidos.';
$SEARCH['LABEL_NONE']                        = 'nenhuma';
$SEARCH['LABEL_MODE']                        = 'Modo';
$SEARCH['MODE_SINGLE']                       = 'Simples — uma entrada por secção';
$SEARCH['MODE_MULTI']                        = 'Multi — uma entrada por item';
$SEARCH['LABEL_INDEX_BASE']                  = 'Base do índice';
$SEARCH['LABEL_FILTER']                      = 'Filtro';
$SEARCH['LABEL_NO_JOIN']                     = 'sem join';
$SEARCH['MSG_SEMI_INVALID_TABLE']            = 'Escolha uma tabela de módulo válida.';
$SEARCH['MSG_IMPORT_FAILED']                 = 'Nenhuma tabela utilizável encontrada no search.php de %s.';
$SEARCH['PAGE_COUNT']                        = [
    'zero' => 'Sem páginas',
    'one' => '%d página',
    'other' => '%d páginas',
];

// ── Backend: General ───────────────────────────────────────────────────────
$SEARCH['SAVE']                              = 'Guardar';
$SEARCH['MSG_SECURITY_ERROR']                = 'A verificação de segurança falhou.';
$SEARCH['STATUS_ACTIVE']                     = 'Ativo';
$SEARCH['STATUS_INACTIVE']                   = 'Inativo';

// ── Stop words ─────────────────────────────────────────────────────────────
// Never searched, never put into the word index — lower case. Used when the
// site has pages in this language (WbceSearchStopwords). Translators: the
// most frequent filler words of the language, not a full dictionary list.
$SEARCH['STOPWORDS'] = [
    'a','à','ao','aos','as','às','até','com','como','da','das','de','dela','dele',
    'do','dos','e','é','ela','elas','ele','eles','em','entre','era','essa','esse',
    'esta','está','este','eu','foi','há','isso','isto','já','lhe','mais','mas','me',
    'mesmo','meu','minha','muito','na','não','nas','nem','no','nos','nós','num',
    'numa','o','os','ou','para','pela','pelo','por','qual','quando','que','quem',
    'se','sem','ser','seu','sua','são','também','te','tem','têm','teu','tu','um',
    'uma','você','vos',
];
