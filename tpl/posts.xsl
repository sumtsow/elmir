<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
    
<xsl:output method="html"/>
<xsl:include href="links.xsl"/>
<xsl:include href="pagination.xsl"/>

<xsl:template match="/">
    <html>
        <head>
            <title>Мини-блог</title>
            <xsl:call-template name="links"> </xsl:call-template>
        </head>
        <body>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="/">Главная</a>
        </nav>
        <h1 class="text-center">Мини-блог</h1>
        <div class="container">
            <xsl:call-template name="pagination"> </xsl:call-template>
            <xsl:apply-templates select="posts/post" />
            <xsl:call-template name="pagination"> </xsl:call-template>
         </div>
      </body>
    </html>
</xsl:template>

<xsl:template match="post">
   <div class="card border-dark mb-3">
      <xsl:apply-templates select="title" />
      <xsl:apply-templates select="text" />

      <div class="card-footer text-right">
        <xsl:apply-templates select="created_at" />
        <a href="/post.php?id={id}">
            <xsl:apply-templates select="comments" />
        </a>
      </div>
      
   </div>
</xsl:template>

<xsl:template match="title">
   <div class="card-header bg-dark text-light"> <xsl:apply-templates /> </div>
</xsl:template>

<xsl:template match="text">
    <div class="card-body">    
        <p class="card-text"> <xsl:apply-templates /> </p>
    </div>
</xsl:template>

<xsl:template match="created_at">
    <xsl:text>Опубликовано: </xsl:text>
        <xsl:value-of select=" 
        concat(
        format-number( substring-after(substring-after(substring-before(.,' '),'-'),'-'), '00'), '.',
        format-number( substring-before(substring-after(.,'-'),'-'), '00'), '.',
        substring-before(.,'-'), ' ',
        substring-after(.,' ')
        )
        " />
</xsl:template>

<xsl:template match="comments">
    <xsl:text> Комментариев: </xsl:text>
        <xsl:apply-templates />
</xsl:template>

</xsl:stylesheet>
