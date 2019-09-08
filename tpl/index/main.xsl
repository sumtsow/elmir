<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : main.xsl
    Created on : 7 сентября 2019 г., 17:00
    Author     : sumtsow
    Description:
        Purpose of transformation follows.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <!-- TODO customize transformation rules 
         syntax recommendation http://www.w3.org/TR/xslt 
    -->

<xsl:template match="page">
    <html>
        <head>
            <title><xsl:value-of select="title" /></title>
        </head>
        <body>        
            <div class="page-container">
                <xsl:value-of select="blocks/menu_top/html" disable-output-escaping="yes"/>            
                <div class="main">         
                    <xsl:value-of select="blocks/content/html" disable-output-escaping="yes"/>
                </div>            
                <xsl:value-of select="blocks/footer/html" disable-output-escaping="yes"/>
            </div>
        </body>
    </html>
</xsl:template>

</xsl:stylesheet>
