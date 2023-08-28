<?php

function parse_correctimg(string $html)
{
    $html = preg_replace('|href="\/[^"]+\/File:([^"]+).jpg"|', 'href="' . IMAGE_DIR . '/$1.jpg"', $html);
    $html = preg_replace('|src="\/[^"]+\/images\/([^"]+)\/([^"]+).jpg"|', 'src="' . IMAGE_DIR . '/$2.jpg"', $html);
    $html = preg_replace('|src="img\/([^"]+)px-([^"]+).jpg"|', 'src="' . IMAGE_DIR . '/$2.jpg"', $html);

    $html = preg_replace('|href="\/[^"]+\/File:([^"]+).png"|', 'href="' . IMAGE_DIR . '/$1.png"', $html);
    $html = preg_replace('|src="\/[^"]+\/images\/([^"]+)\/([^"]+).png"|', 'src="' . IMAGE_DIR . '/$2.png"', $html);
    $html = preg_replace('|src="img\/([^"]+)px-([^"]+).png"|', 'src="' . IMAGE_DIR . '/$2.png"', $html);

    $html = preg_replace('|href="\/[^"]+\/File:([^"]+).svg"|', 'href="' . IMAGE_DIR . '/$1.svg"', $html);
    $html = preg_replace('|src="\/[^"]+\/images\/([^"]+)\/([^"]+).svg"|', 'src="' . IMAGE_DIR . '/$2.svg"', $html);
    $html = preg_replace('|src="img\/([^"]+)px-([^"]+).svg"|', 'src="' . IMAGE_DIR . '/$2.svg"', $html);

    return $html;
}

function parse_correctlinks(string $html)
{
    $html = preg_replace('|href="\/[^"]+\/([^"#]+)"|', 'href="$1.html"', $html);
    $html = preg_replace('|href="\/[^"]+\/([^"#]+)#([^"#]+)"|', 'href="$1.html#$2"', $html);
    $html = preg_replace('|<img alt="([^"]+)" src="/[^"]+/images/thumb/[^"]/[^"]+/[^"]+/[^"]+"|', '<img alt="$1" src="' . IMAGE_DIR . '/$1"', $html);

    $html = str_replace("?redlink=1", "", $html);

    return $html;
}

function parse_correctformatting(string $html)
{
    $html = preg_replace('%<h([0-9])>([^\n]+)<span class="mw-editsection">([^\n]+)</span></h[0-9]>%', '<h$1>$2</h$1>', $html);

    return $html;
}

function parse_correcttables(string $html)
{
    $html = str_replace('cellspacing="0"', '', $html);
    $html = preg_replace('|border="[^"]+"|', '', $html);

    return $html;
}

function parse_addheader(string $html, string $title)
{
    $html = '<link rel="stylesheet" href="' . CSS_SCHEME . '">' . "\n" .
            '<title>' . $title . "</title>\n" .
            "<h1>" . $title . "</h1>" . "\n" .
            $html;

    return $html;
}

function parse_addfooter(string $html)
{
    $html = $html . "\n<footer>\n" .
    "This page was copied from <a href=\"" . WIKILINK . "\">" . WIKILINK . "</a>.\n" .
    "</footer>";

    return $html;
}

?>