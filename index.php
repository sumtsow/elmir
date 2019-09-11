<?php

require_once 'classes/Post.php';

$page = (isset($_GET['page'])) ? preg_replace("/[^0-9]/", '', $_GET['page']) : 0;

$xml = Post::postsAsXml($page);

$xslt = new xsltProcessor;

$xslt->importStyleSheet(DomDocument::load('tpl/posts.xsl'));

$output = $xslt->transformToXML($xml);

echo str_replace("&lt;br /&gt;","<br />",$output);