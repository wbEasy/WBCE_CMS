<?php
/**
 * wbce_search - guide_popup.php
 * Standalone popup window for module guides (MD rendered as HTML)
 * Called via window.open() from tool.php
 *
 * @module    wbce_search
 * @author    Peter Kitzinger (Slugger)
 * @author    Christian M. Stefan (https://www.wbEasy.de)
 * @copyright WBCE Project (2026-)
 * @license   GNU General Public License
 * @platform  WBCE 1.7.0+
 *
 * Developed with AI assistance (Claude).
 */

$bootstrap = dirname(__FILE__, 3) . '/config.php';
if (!file_exists($bootstrap)) { http_response_code(404); exit; }
require $bootstrap;

// Backend access to this AdminTool required — a plain logged-in session is
// not enough (frontend members have USER_ID/GROUP_ID too).
$admin = new Admin('admintools', 'admintools', false, false);
if (!$admin->is_authenticated() || !$admin->hasToolPermission('wbce_search')) {
    http_response_code(403);
    echo '<p>Access denied.</p>';
    exit;
}

// Force UTF-8 before any output
header('Content-Type: text/html; charset=utf-8');

$mod = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['module'] ?? '');
// Language-aware guide: try {mod}_{LANGUAGE}.md first, fall back to {mod}.md
$guide_lang = defined('LANGUAGE') ? LANGUAGE : 'EN';
$guide_file_lang = WB_PATH . '/modules/wbce_search/module_defs/guides/' . $mod . '_' . $guide_lang . '.md';
$guide_file      = WB_PATH . '/modules/wbce_search/module_defs/guides/' . $mod . '.md';
if(file_exists($guide_file_lang)) $guide_file = $guide_file_lang;
$md = '';
if ($mod && file_exists($guide_file)) {
    $md = file_get_contents($guide_file);
} else {
    $md = '# No guide found' . PHP_EOL . 'No guide available for module: `' . htmlspecialchars($mod) . '`';
}

?><!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Guide: <?php echo htmlspecialchars($mod); ?> — wbce_search</title>
<link rel="stylesheet" href="<?php echo WB_URL; ?>/include/font-awesome/css/font-awesome.min.css">
<style>
/* wbce_search guide_popup.php styles */
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
       font-size: 14px; line-height: 1.6; color: #333;
       padding: 1.25em 1.5em; background: #fff; }
h1, h2, h3, h4 { margin: 1em 0 .4em; color: #1a1a2e; }
h2 { font-size: 1.25em; border-bottom: 2px solid #2980b9; padding-bottom: .3em; }
h3 { font-size: 1.05em; color: #2471a3; }
h4 { font-size: .95em; color: #555; }
p  { margin: .5em 0; }
ul { margin: .4em 0 .4em 1.5em; }
li { margin: .2em 0; }
hr { border: none; border-top: 1px solid #ddd; margin: 1em 0; }
code { background: #f0f4f8; color: #1a5a9a; padding: .15em .4em;
       border-radius: 3px; font-size: .88em; border: 1px solid #d0dce8; }
pre  { background: #1e2a3a; color: #e8f0f8; padding: .75em 1em;
       border-radius: 4px; overflow-x: auto; margin: .6em 0; }
pre code { background: none; color: inherit; border: none;
           padding: 0; font-size: .88em; }
table { border-collapse: collapse; width: 100%; margin: .75em 0; font-size: .88em; table-layout: fixed; }
th { background: #2980b9; color: #fff; padding: .45em .75em; text-align: left;
     border: 1px solid #1f6fa5; word-wrap: break-word; }
td { padding: .35em .75em; border: 1px solid #d8e4f0; word-wrap: break-word; vertical-align: top; }
tr:nth-child(even) td { background: #f4f8fc; }
tr:hover td { background: #eaf2fb; }
strong { color: #1a1a2e; }
.ws-popup-header { display: flex; justify-content: space-between;
                   align-items: center; padding-bottom: .6em;
                   border-bottom: 2px solid #2980b9; margin-bottom: 1em; }
.ws-popup-title  { font-size: 1.1em; font-weight: 700; color: #1a1a2e; }
.ws-popup-close  { background: none; border: none; font-size: 1.4em;
                   cursor: pointer; color: #999; line-height: 1; }
.ws-popup-close:hover { color: #333; }
</style>
</head>
<body>
<div class="ws-popup-header">
  <span class="ws-popup-title"><i class="fa fa-book"></i> Guide: <?php echo htmlspecialchars($mod); ?></span>
  <button class="ws-popup-close" onclick="window.close()" title="Close">&times;</button>
</div>
<div id="ws-guide-content">
<?php
// Simple MD to HTML converter (server-side)
// Parse MD lines into tokens first, then render
$lines   = explode("\n", $md);
$tokens  = [];
$inCode  = false;
$codeBuf = '';

foreach ($lines as $line) {
    if (preg_match('/^```/', $line)) {
        if ($inCode) {
            $tokens[] = ['type' => 'code', 'text' => $codeBuf];
            $codeBuf = ''; $inCode = false;
        } else { $inCode = true; }
        continue;
    }
    if ($inCode) { $codeBuf .= $line . "\n"; continue; }

    if (preg_match('/^\|/', $line)) {
        // Skip separator rows: |---|---|
        if (preg_match('/^\|[\s\-|:]+\|\s*$/', $line)) {
            // Mark last table-row as header
            for ($i = count($tokens)-1; $i >= 0; $i--) {
                if ($tokens[$i]['type'] === 'tr') { $tokens[$i]['header'] = true; break; }
            }
            continue;
        }
        $cells = array_map('trim', array_slice(explode('|', $line), 1, -1));
        $tokens[] = ['type' => 'tr', 'cells' => $cells, 'header' => false];
        continue;
    }

    if (preg_match('/^### (.+)/', $line, $m)) { $tokens[] = ['type'=>'h4','text'=>$m[1]]; continue; }
    if (preg_match('/^## (.+)/',  $line, $m)) { $tokens[] = ['type'=>'h3','text'=>$m[1]]; continue; }
    if (preg_match('/^# (.+)/',   $line, $m)) { $tokens[] = ['type'=>'h2','text'=>$m[1]]; continue; }
    if (preg_match('/^---+$/',    $line))      { $tokens[] = ['type'=>'hr']; continue; }
    if (preg_match('/^- (.+)/',   $line, $m)) { $tokens[] = ['type'=>'li','text'=>$m[1]]; continue; }
    if (trim($line) === '')                    { $tokens[] = ['type'=>'br']; continue; }
    $tokens[] = ['type'=>'p','text'=>$line];
}

// Render tokens
$html   = '';
$inList = false;
$inTbl  = false;

foreach ($tokens as $i => $tok) {
    // Close list if needed
    if ($inList && $tok['type'] !== 'li') { $html .= '</ul>'; $inList = false; }
    // Close table if needed
    if ($inTbl && $tok['type'] !== 'tr')  { $html .= '</tbody></table>'; $inTbl = false; }

    switch ($tok['type']) {
        case 'h2': $html .= '<h2>' . ws_inline($tok['text']) . '</h2>'; break;
        case 'h3': $html .= '<h3>' . ws_inline($tok['text']) . '</h3>'; break;
        case 'h4': $html .= '<h4>' . ws_inline($tok['text']) . '</h4>'; break;
        case 'hr': $html .= '<hr>'; break;
        case 'br': $html .= ''; break;  // skip extra blank lines
        case 'p':  $html .= '<p>' . ws_inline($tok['text']) . '</p>'; break;
        case 'li':
            if (!$inList) { $html .= '<ul>'; $inList = true; }
            $html .= '<li>' . ws_inline($tok['text']) . '</li>';
            break;
        case 'code':
            $html .= '<pre><code>' . htmlspecialchars($tok['text']) . '</code></pre>';
            break;
        case 'tr':
            if (!$inTbl) {
                $html .= '<table><tbody>';
                $inTbl = true;
            }
            $tag = $tok['header'] ? 'th' : 'td';
            $html .= '<tr>' . implode('', array_map(
                fn($c) => "<$tag>" . ws_inline($c) . "</$tag>",
                $tok['cells']
            )) . '</tr>';
            break;
    }
}
if ($inList) $html .= '</ul>';
if ($inTbl)  $html .= '</tbody></table>';

echo $html;

function ws_inline(string $s): string {
    $s = htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    $s = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $s);
    $s = preg_replace('/`([^`]+)`/', '<code>$1</code>', $s);
    return $s;
}
?>
</div>
</body>
</html>
