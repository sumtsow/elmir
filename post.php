<?php

require_once 'classes/Post.php';

$id = (isset($_GET['id'])) ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;

if(!$id) {
    header('Location: /');
    exit;
}

$post = new Post($id);

if(!$post->id) {
    header('Location: /errors/404.html');
    exit;
}

$xml = $post->asXml();

$xslt = new xsltProcessor;

$xslt->importStyleSheet(DomDocument::load('tpl/post.xsl'));

$output = $xslt->transformToXML($xml);

echo str_replace("&lt;br /&gt;","<br />",$output);
