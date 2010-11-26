<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" indent="yes" omit-xml-declaration="no" />

	<xsl:template match="@*|node()">
		<xsl:copy>
			<xsl:apply-templates select="@*|node()"/>
		</xsl:copy>
	</xsl:template>
	
	<!-- Basic html layout -->
	<xsl:template match="page">
		<html xmlns="http://www.w3.org/1999/xhtml" dir="{@dir}" xml:lang="{@language}">
			<xsl:comment>page start</xsl:comment>
			<xsl:apply-templates />
			<xsl:comment>page end</xsl:comment>
		</html>
	</xsl:template>
</xsl:stylesheet>