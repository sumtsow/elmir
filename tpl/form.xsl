<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    
    <xsl:output method="html" />
    
    <xsl:template name="form">
        <!-- Form -->
        <h4 class="h4">Оставить комментарий</h4>
        <form id="commentSender" onkeydown="return event.key != 'Enter';">
            <div class="form-group" onsubmit="return false;">
                <label for="author">Ваше имя: </label>
                <input type="text" class="form-control" name="author" id="author" />
            </div>            
            <div class="form-group">
                <label for="text">Ваш комментарий: </label>
                <textarea class="form-control" name="text" id="text" />
            </div>
            <input type="hidden" name="post_id" value="{post/@id}"/>            
        </form>
        <!-- Form end -->        
        <div id="sendResult" role="alert"></div>
        <div id="sendError" role="alert"></div>
        <button id="btn" class="btn btn-dark" onClick="sendForm();" >Отправить</button>     
    </xsl:template>
    
</xsl:stylesheet>
