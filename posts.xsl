<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" >

<xsl:template match="/">
    <html>
        <head>
            <title>Мини-блог</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
       </head>
      <body>
         <h1 class="text-center">Мини-блог</h1>
         <div class="container">
            <xsl:apply-templates select="posts"> </xsl:apply-templates>
         </div>
      </body>
    </html>
</xsl:template>

<xsl:template match="posts/post">
   <div class="card border-dark mb-3">
      <xsl:apply-templates select="title" />
      <xsl:apply-templates select="text" />
      <xsl:apply-templates select="created_at" />
      <xsl:apply-templates select="comments" />
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
    <div class="card-footer text-right">
           Опубликовано: <xsl:apply-templates/>
    </div>
</xsl:template>

<xsl:template match="comments">
    <div class="card-footer text-right">
           Комментариев: <xsl:apply-templates/>
    </div>
</xsl:template>

</xsl:stylesheet>
