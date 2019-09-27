<?php

require_once 'classes/Post.php';

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);

$page = (isset($page)) ? $page : 0;

$dom = Post::postsAsDOM($page);

$postsElement = $dom->getElementsByTagName('posts')->item(0);

if(($postsElement->getAttribute('count') / $postsElement->getAttribute('itemsPerPage') < $page) || $page < 0) {
    header('Location: /errors/404.html');
    exit;
}

$xslt = new xsltProcessor;

$doc = new DOMDocument();

$doc->load('tpl/posts.xsl');

$xslt->importStyleSheet($doc);

$output = $xslt->transformToXML($dom);

echo str_replace("&lt;br /&gt;","<br />",$output);