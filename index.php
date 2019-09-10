<?php

require_once 'classes/Post.php';

// добавить регулярное выражение
$page = (int) @strip_tags(@htmlspecialchars($_GET['page']));

$xml = Post::postsAsXml($page);

$xslt = new xsltProcessor;

$xslt->importStyleSheet(DomDocument::load('tpl/posts.xsl'));

echo $xslt->transformToXML($xml);