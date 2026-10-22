<?php

// getIDKEY(value) — use IDKEYs in Twig templates directly, no need to hand them over.
//
// One-time, page-bound key, e.g. for action links:
//   <a href="{{ TOOL_URI }}&amp;del={{ getIDKEY(file) }}">
// redeemed with $admin->checkIDKEY('del', false, 'GET'). The value itself stays
// in the session, never in the URL. Prefer this over FTAN in links: FTAN is
// session-wide and reusable, so a leaked URL (Referer, logs, history) would
// leak a token that validates every POST form, too.
//
// Optional second argument: the key's purpose, e.g. getIDKEY(page.page_id, 'page'),
// redeemed with checkIDKEY(…, purpose: 'page') — see SecureForm::getIDKEY().
$oTwig->addFunction(new \Twig\TwigFunction("getIDKEY",
    function ($uID, string $purpose = '') {
        $oEngine = isset($GLOBALS['wb']) ? $GLOBALS['wb'] : $GLOBALS['admin'];
        return $oEngine->getIDKEY($uID, $purpose);
    }
));

