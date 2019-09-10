<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    
    <xsl:output method="html"/>
    
    <xsl:template name="form">
        <form>
            <div class="form-group">
                <label for="newComment">Email address</label>
                <input type="textarea" class="form-control" id="newComment" placeholder="Enter your comment" />
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </xsl:template>
    
</xsl:stylesheet>
