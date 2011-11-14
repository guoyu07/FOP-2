<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<xslt:stylesheet xmlns:xslt="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format" xmlns:svg="http://www.w3.org/2000/svg" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xslt:output indent="yes" encoding="utf-8"/>
    <xslt:param name="XFOutputFormat"/>
    <xsl:template match="/">
        <fo:root>
            <fo:layout-master-set>
                <fo:simple-page-master master-name="Letter Page" page-width="8.500in" page-height="11.000in">
                    <fo:region-body region-name="xsl-region-body" margin="0.700in"/>
                    <fo:region-before region-name="xsl-region-before" display-align="after" extent="0.700in"/>
                    <fo:region-after region-name="xsl-region-after" display-align="before" extent="0.700in"/>
                    <fo:region-start region-name="xsl-region-start" extent="0.700in"/>
                    <fo:region-end region-name="xsl-region-end" extent="0.700in"/>
                </fo:simple-page-master>
            </fo:layout-master-set>
            <fo:page-sequence master-reference="Letter Page">
                <fo:static-content flow-name="xsl-region-before" font-size="12pt" font-family="Times">
                    <fo:block></fo:block>
                </fo:static-content>
                <fo:static-content flow-name="xsl-region-after" font-size="12pt" font-family="Times">
                    <fo:block> </fo:block>
                </fo:static-content>
                <fo:static-content flow-name="xsl-region-start" font-size="12pt" font-family="Times">
                    <fo:block> </fo:block>
                </fo:static-content>
                <fo:static-content flow-name="xsl-region-end" font-size="12pt" font-family="Times">
                    <fo:block> </fo:block>
                </fo:static-content>
                <fo:flow flow-name="xsl-region-body" font-family="Times" font-size="12pt">
	                <fo:block>
		                <xslt:value-of select="//var" />
			        </fo:block>
                </fo:flow>
            </fo:page-sequence>
        </fo:root>
    </xsl:template>
</xslt:stylesheet>
