<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    
    <xsl:output method="html" />
    
    <xsl:template name="form">
        <!-- Form -->
        <h4 class="h4">Оставить комментарий </h4>
        <form method="post" action="" id="commentSender">
            <div class="form-group">
                <label for="author">Ваше имя: </label>
                <input type="text" class="form-control" name="author" id="author" />
            </div>            
            <div class="form-group">
                <label for="text">Ваш комментарий: </label>
                <textarea class="form-control" name="text" id="text" />
            </div>
            <input type="hidden" name="post_id" value="{post/id}"/>            
            <input type="submit" id="btn" class="btn btn-dark" value="Save" onClick="sendForm();" />
        </form>
        <div id="sendResult"></div>
        <!-- Form end -->
    </xsl:template>
    
</xsl:stylesheet>
