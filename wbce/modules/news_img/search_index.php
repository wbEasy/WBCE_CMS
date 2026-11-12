<?php
/**
 * news_img — search_index.php
 *
 * Tells WBCE Search (core module wbce_search, WBCE 1.7+) what to index for a
 * news_img section: one entry per post a visitor can open. Only WBCE Search
 * reads this file; news_img never loads it.
 *
 * This file is the worked example of modules/wbce_search/SEARCH_INDEX_HOWTO.md.
 *
 * Kept up to date by the core: the news_img scripts that write posts or
 * groups set $update_when_modified before including modules/admin.php, which
 * bumps the section's and the page's modified_when. WBCE Search re-indexes a
 * section whose page changed after its entries were written. A post moved or
 * copied into another section touches that one too ($admin->touchSection() in
 * manage_posts.php and save_post.php).
 *
 * @license GNU GPL2
 */

defined('WB_PATH') or die();

return [
    'callback' => static function (
        Database $database, array $def, array $section,
        int $pid, int $sid, string $module,
        string $page_title, string $description, string $keywords,
        string $visibility, int $searching, int $now
    ): int {
        // The index row. title/description/keywords are the PAGE's (passed in),
        // item_title is the post's own title. WBCE Search has already deleted
        // this section's old rows before calling us.
        $insert = static function (int $itemId, string $itemTitle, string $html, string $detailUrl, string $thumbUrl) use (
            $database, $pid, $sid, $module, $page_title, $description, $keywords, $visibility, $searching, $now
        ): int {
            $database->insertRow('{TP_SEARCH}index', [
                'page_id'     => $pid,
                'section_id'  => $sid,
                'item_id'     => $itemId,
                'module'      => $module,
                'title'       => $page_title,
                'item_title'  => $itemTitle,
                'description' => $description,
                'keywords'    => $keywords,
                'content'     => WbceSearchIndexer::plainText($html),
                'detail_url'  => WbceSearch::urlToToken($detailUrl),
                'thumb_url'   => WbceSearch::urlToToken($thumbUrl),
                'visibility'  => $visibility,
                'searching'   => $searching,
                'indexed_at'  => $now,
            ]);
            return $database->hasError() ? 0 : 1;
        };

        // Exactly the posts the frontend shows: active, with a title, inside
        // the publishing window, in an active group (or in none). WBCE Search
        // checks only the PAGE's rights — whatever is indexed here can be found
        // by everyone who may see the page.
        $posts = $database->fetchAll(
            "SELECT p.`post_id`, p.`title`, p.`link`, p.`image`,
                    p.`content_short`, p.`content_long`, p.`content_block2`
               FROM `{TP}mod_news_img_posts` p
               LEFT JOIN `{TP}mod_news_img_groups` g ON g.`group_id` = p.`group_id`
              WHERE p.`section_id` = ?
                AND p.`active` = 1
                AND p.`title` != ''
                AND (p.`published_when`  = 0 OR p.`published_when`  <= ?)
                AND (p.`published_until` = 0 OR p.`published_until` >= ?)
                AND (g.`group_id` IS NULL OR g.`active` = 1)
              ORDER BY p.`post_id`",
            [$sid, $now, $now]
        );

        $count = 0;
        foreach ($posts as $post) {
            $count += $insert(
                (int) $post['post_id'],
                (string) $post['title'],
                $post['content_short'] . ' ' . $post['content_long'] . ' ' . $post['content_block2'],
                // The post's own page. Built here, not with page_link(): that
                // needs a $wb/$admin object, and an index run may have none.
                WB_URL . PAGES_DIRECTORY . $post['link'] . PAGE_EXTENSION,
                $post['image'] !== ''                         // preview image (already resized)
                    ? WB_URL . MEDIA_DIRECTORY . '/.news_img/' . $post['image']
                    : ''
            );
        }

        // No visible post: keep the news page itself findable by its title.
        // Returning 0 instead would make WBCE Search store a marker row
        // ("processed, nothing to find") — the page would not be found at all.
        if ($count === 0 && $page_title !== '') {
            $count = $insert(0, '', '', '', '');
        }

        return $count;
    },
];
