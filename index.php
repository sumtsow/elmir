<?php

require_once 'classes/Post.php';

$xml = Post::allAsXml();

$xslt = new xsltProcessor;

$xslt->importStyleSheet(DomDocument::load('posts.xsl'));

echo $xslt->transformToXML($xml);