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
                <xsl:apply-templates select="post/comment"> </xsl:apply-templates>
                <xsl:call-template name="form"> </xsl:call-template>
            </div>
        </body>
    </html>
</xsl:template>

<xsl:template match="post">
    <xsl:apply-templates select="title" />
    <xsl:apply-templates select="created_at" />
    <div class="row mb-3">
        <div class="col">
            <xsl:apply-templates select="text" />                
        </div>
    </div>
    <xsl:apply-templates select="comments" />        
</xsl:template>

<xsl:template match="post/title">
   <h2 class="h2"> <xsl:apply-templates /> </h2>
</xsl:template>

<xsl:template match="post/created_at">
    <h6 class="h6">
        <xsl:text>Опубликовано: </xsl:text>
        <xsl:value-of select=" 
            concat(
            format-number( substring-after(substring-after(substring-before(.,' '),'-'),'-'), '00'), '.',
            format-number( substring-before(substring-after(.,'-'),'-'), '00'), '.',
            substring-before(.,'-'), ' ',
            substring-after(.,' ')
            )
        " />
    </h6>
</xsl:template>

<xsl:template match="post/text">
    <div class="card-body">    
        <p class="card-text"> <xsl:apply-templates /> </p>
    </div>
</xsl:template>

<xsl:template match="post/comments">
    <h6 class="h6">
        <xsl:text> Комментариев: </xsl:text>
        <xsl:apply-templates />
    </h6>
</xsl:template>

<xsl:template match="post/comment">
    <div class="card border-dark mb-3">
        <div class="card-header bg-dark text-light">  
            <xsl:apply-templates select="author" />
            <xsl:apply-templates select="created_at" />            
            <xsl:apply-templates select="ip" />
        </div>
        <xsl:apply-templates select="text" />
    </div>
</xsl:template>

<xsl:template match="post/comment/author">
    <span class="font-weight-bold"> 
        <xsl:apply-templates /> 
    </span>
</xsl:template>

<xsl:template match="post/comment/created_at">
    <xsl:text> в </xsl:text>
    <xsl:value-of select=" 
        concat(
        format-number( substring-after(substring-after(substring-before(.,' '),'-'),'-'), '00'), '.',
        format-number( substring-before(substring-after(.,'-'),'-'), '00'), '.',
        substring-before(.,'-'), ' ',
        substring-after(.,' ')
        )
    " />
</xsl:template>

<xsl:template match="post/comment/ip">
    <xsl:text> ( с IP: </xsl:text>
    <xsl:apply-templates />
    <xsl:text> ) </xsl:text>
</xsl:template>

<xsl:template match="post/comment/text">
    <div class="card-body">    
        <p class="card-text"> <xsl:apply-templates /> </p>
    </div>
</xsl:template>

</xsl:stylesheet>
