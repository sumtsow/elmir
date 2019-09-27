<?php

require_once 'classes/Post.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$post = new Post($id);

if(!$post->id) {
    header('Location: /errors/404.html');
    exit;
}

$dom = $post->asDOM();
        
$xslt = new xsltProcessor;

$doc = new DOMDocument();

$doc->load('tpl/post.xsl');

$xslt->importStyleSheet($doc);

$output = $xslt->transformToXML($dom);

echo str_replace("&lt;br /&gt;","<br />",$output);
