//:Randomly display one WYSIWYG section from a given list
//:Use [[ShowRandomWysiwyg?section=10,12,15,20]] possible Delimiters: [ ,;:|-+#/ ]
$content = '';
if (isset($section) && preg_match('/^[0-9]+(?:\s*[\,\|\-\;\:\+\#\/]\s*[0-9]+\s*)*$/', $section)) {
    // split and sanitize arguments, pick one at random
    $aSections = preg_split('/[\s\,\|\-\;\:\+\#\/]+/', $section);
    $iSection  = (int) $aSections[array_rand($aSections)];
    $aSection  = get_section_array($iSection);
    // only WYSIWYG sections; get_section_content() renders a section only
    // if the visitor may see its page
    if (!empty($aSection) && $aSection['module'] === 'wysiwyg') {
        $content = get_section_content($iSection);
    }
}
return $content;
