<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >
    
<xsl:output method="html"/>

<xsl:include href="form.xsl"/>
<xsl:include href="links.xsl"/>

<xsl:template match="/">
    <html>
        <head>
            <title>Мини-блог</title>
            <xsl:call-template name="links"> </xsl:call-template>
            <script src="js/formSend.js"></script>
        </head>
        <body>
            <nav class="navbar navbar-dark bg-dark">
                <a class="navbar-brand" href="/">Главная</a>
            </nav>
            <h1 class="text-center">Мини-блог</h1>
            <div class="container">
                <xsl:apply-templates select="post"> </xsl:apply-templates>
                <div id="empty"></div>
                <xsl:apply-templates select="post/comment"> </xsl:apply-templates>
                <xsl:call-template name="form"> </xsl:call-template>
            </div>
        </body>
    </html>
</xsl:template>

<xsl:template match="post">
    <h2 class="h2">
        <xsl:apply-templates select="@title" />
    </h2>
    <h6 class="h6">
        <xsl:text>Опубликовано: </xsl:text>    
        <xsl:apply-templates select="@created_at" />
    </h6>    
    <div class="row my-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                        <xsl:apply-templates select="@text"/>
                    </p>
                </div>
            </div>              
        </div>
    </div>
    <h6 class="h6">
        <xsl:text> Комментариев: </xsl:text>
        <xsl:apply-templates select="@comments" />
    </h6>    
</xsl:template>

<xsl:template match="/post/comment">
    <div class="card border-dark mb-3">
        <div class="card-header bg-dark text-light">
            <span class="font-weight-bold">
                <xsl:apply-templates select="@author" />
            </span>
            <xsl:text> в </xsl:text>        
            <xsl:apply-templates select="@created_at" />
            <xsl:text> ( с IP: </xsl:text>
            <xsl:apply-templates select="@ip" />            
            <xsl:text> ) </xsl:text>    
        </div>
        <div class="card-body">
            <p class="card-text"> <xsl:apply-templates select="@text" /> </p>
        </div>    
    </div>
</xsl:template>

</xsl:stylesheet>
