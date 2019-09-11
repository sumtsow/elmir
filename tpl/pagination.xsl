<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    
    <xsl:output method="html" />
    
    <xsl:template name="pagination">
        <!--  Pagination -->
        <nav>
            <ul class="pagination justify-content-end">
                <xsl:if test="number(posts/page)-1 &gt;= 0">                    
                    <li class="page-item mr-3">
                        <a class="page-link" href="?page={number(posts/page)-1}">&#171;Назад</a>
                    </li>
                </xsl:if>
                <xsl:if test="(number(posts/page)+1) * number(posts/itemsPerPage) &lt; number(posts/count)">
                    <li class="page-item">
                        <a class="page-link" href="?page={number(posts/page)+1}">Вперед&#187;</a>
                    </li>
                </xsl:if>                        
            </ul>
        </nav>
        <!-- Pagination end --> 
    </xsl:template>
    
</xsl:stylesheet>
