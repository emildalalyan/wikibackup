<?php

// WARNING =================================
// This script has restriction of 500 pages.

/* Settings =========== */

// Path to backup directory.
define("BACKUP_DIR", "backup");

// Path to images directory (RELATIVE TO BACKUP DIRECTORY)
define("IMAGE_DIR", "img");

// Link to the wiki, that you want to download.
define("WIKILINK", "");

// Specify name of the CSS scheme file.
define("CSS_SCHEME", "theme.css");

// Defines our user-agent.
// You can just leave it alone.
ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64)');

/* ==================== */

include("download.php");
include("parse.php");

mkdir(BACKUP_DIR . "/" . IMAGE_DIR, 0777, true);

$pages = download_pagelist();
if($pages == null) die("Error! Couldn't get page list.");

print("This wiki has " . count($pages) . " pages.\n");

print("Copying CSS scheme file... ");
copy(CSS_SCHEME, BACKUP_DIR . "/" . CSS_SCHEME);
print("Done!\n");

foreach($pages as $key => $value)
{
    print(($key+1) . ") ");
    $title = $value["title"];
    $titleint = str_replace(" ", "_", $title);
    // titleint stands for "title internal"

    $page = download_page($titleint);
    if($page == null) continue;

    $text = $page["text"]["*"];
    $wikitext = $page["wikitext"]["*"];
    $images = $page["images"];

    download_images($images, BACKUP_DIR . "/" . IMAGE_DIR);

    $text = parse_correctimg($text);
    $text = parse_correctlinks($text);
    $text = parse_correctformatting($text);
    $text = parse_correcttables($text);
    $text = parse_addheader($text, $title);
    $text = parse_addfooter($text);

    file_put_contents(BACKUP_DIR . "/" . $titleint . ".html", $text);
    file_put_contents(BACKUP_DIR . "/" . $titleint . ".txt", $wikitext);
}

?>