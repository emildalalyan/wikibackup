<?php

function download_pagelist()
{
    $json = file_get_contents(WIKILINK . "/api.php?action=query" .
        "&list=allpages&format=json&aplimit=500");
    $response = json_decode($json, true);
    // Getting response from server.

    print("Downloading the page list...\n");
    // Printing downloading status.

    if($response == null) return null;
    return $response["query"]["allpages"];
    // Returning the list.
}

function download_page(string $title)
{
    print("Downloading " . $title . " page...\n");
    // Printing downloading status.

    $json = file_get_contents(WIKILINK . "/api.php?action=parse" .
        "&prop=wikitext|text|images&format=json&page=" . urlencode($title));
    $response = json_decode($json, true);
    // Getting response from server.

    if($response == null) return null;
    return $response["parse"];
    // Returning the page.
}

function download_images(mixed $imagearr, string $dir)
{
    if($imagearr == null) return;
    $length = count($imagearr);

    foreach($imagearr as $index => $image)
    {
        $json = file_get_contents(WIKILINK . "/api.php?action=query" .
            "&prop=imageinfo&format=json&titles=File:" . urlencode($image) . "&iiprop=url");
        $response = json_decode($json, true);
        if($response == null) continue;
        // Getting response from server.

        $pages = $response["query"]["pages"];
        $page = array_values($pages)[0];
        if($page == null || !array_key_exists("imageinfo", $page)) continue;
        // Collecting URL info from this response.
        
        print(" (image " . ($index+1) . "/" . $length . ") " . $image . "\n");
        // Printing downloading status.

        $url = $page["imageinfo"]["0"]["url"];
        if($url == null) continue;

        $img = file_get_contents($url);
        file_put_contents($dir . "/" . $image, $img);
        // Downloading the image.
    }
}

?>