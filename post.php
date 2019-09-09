<?php

require_once 'classes/Post.php';

$id = @strip_tags(@htmlspecialchars($_GET['id']));

if(!$id) {
    header('Location: /');
    exit;
}

$post = new Post($id);

$xml = $post->asXml();

//echo $xml->asXML();

$xslt = new xsltProcessor;

$xslt->importStyleSheet(DomDocument::load('tpl/post.xsl'));

echo $xslt->transformToXML($xml);