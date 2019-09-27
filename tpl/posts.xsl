<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
    
<xsl:output method="html"/>
<xsl:include href="links.xsl"/>
<xsl:include href="pagination.xsl"/>

<xsl:template match="posts">
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
                <xsl:apply-templates select="post" />
                <xsl:call-template name="pagination"> </xsl:call-template>
            </div>
        </body>
    </html>
</xsl:template>

<xsl:template match="post">
   <div class="card border-dark mb-3">
        <div class="card-header bg-dark text-light">
            <xsl:apply-templates select="@title" />
        </div>       
        <div class="card-body">
            <p class="card-text">
                <xsl:apply-templates select="@text" />
            </p>
        </div>
        <div class="card-footer text-right">
            <xsl:text>Опубликовано: </xsl:text>
            <xsl:apply-templates select="@created_at" />
            <a href="/post.php?id={@id}">
                <xsl:text> Комментариев: </xsl:text>
                <xsl:apply-templates select="@comments" />
            </a>
        </div>
   </div>
</xsl:template>

</xsl:stylesheet>
