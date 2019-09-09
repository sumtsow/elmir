<?php

require_once 'classes/Post.php';

$xml = Post::postsAsXml();

$xslt = new xsltProcessor;

$xslt->importStyleSheet(DomDocument::load('tpl/posts.xsl'));

echo $xslt->transformToXML($xml);