<?php

require_once 'classes/Post.php';

$page = (isset($_GET['page'])) ? filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT) : 0;

$xml = Post::postsAsXml($page);

$xslt = new xsltProcessor;

$xslt->importStyleSheet(DomDocument::load('tpl/posts.xsl'));

$output = $xslt->transformToXML($xml);

echo str_replace("&lt;br /&gt;","<br />",$output);