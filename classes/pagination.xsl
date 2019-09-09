<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform</a>">
                
<xsl:output method="xhtml" version="3.2" encoding="utf-8"/>

<xsl:param name="Page" select="0" />
<xsl:param name="PageSize" select="1" />
 
<xsl:template name="results" match="/">

<xsl:variable name="mycount" select="count(root/customer)"/>
<xsl:variable name="selectedRowCount" select="floor((number($numberOfRecords)-1) div $recordsPerPage)+1"/>

      <xsl:for-each select="root/customer">
       <!-- Pagination logic -->
       <xsl:if test="position() &gt;= ($Page * $PageSize) + 1">
        <xsl:if test="position() &lt;= $PageSize + ($PageSize * $Page)">

         <!-- Do display here -->
        </xsl:if>
       </xsl:if>
      </xsl:for-each>

      <!-- Prev link for pagination -->
      <xsl:choose>
       <xsl:when test="number($Page)-1 &gt;= 0">&#160;
        <a>
         <xsl:attribute name="href">_dirresult?page=<xsl:value-of select="number($Page)-1"/>&amp;pagesize=<xsl:value-of 
select="$PageSize"/></xsl:attribute>
          &lt;&lt;Prev
        </a>
       </xsl:when>
       <xsl:otherwise>
        <!-- display something else -->
       </xsl:otherwise>
      </xsl:choose>
      
      <xsl:if test="$selectedRowCount &gt; 1">
       &#160;<b class="blacktext"><xsl:value-of select="number($Page)+1"/>&#160;of&#160;<xsl:value-of 
select="number($selectedRowCount)"/></b>&#160;
      </xsl:if>
               
      <!-- Next link for pagination -->
      <xsl:choose>
       <xsl:when test="number($Page)+1 &lt; number($selectedRowCount)">&#160;
        <a>
         <xsl:attribute name="href">_dirresult?page=<xsl:value-of select="number($Page)+1"/>&amp;pagesize=<xsl:value-of 
select="$PageSize"/></xsl:attribute>
          Next&gt;&gt;
        </a>
       </xsl:when>
       <xsl:otherwise>
        <!-- display something else -->
       </xsl:otherwise>
      </xsl:choose>
</xsl:template>
 
</xsl:stylesheet>
