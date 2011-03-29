{if XSLT}
	<?xml version="1.0" encoding="{@CHARSET}"?>
	<?xml-stylesheet href="{@RELATIVE_CMS_DIR}style/xslt/page.xsl" type="text/xsl"?>
	{if $additionalXSLTStylesheets|isset}{@$additionalXSLTStylesheets}{/if}
	<page dir="{lang}wcf.global.pageDirection{/lang}" language="{@LANGUAGE_CODE}" xmlns="http://www.evil-co.de" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.evil-co.de http://xsd.evil-co.de/cms/page.xsd">
{else}
	{if $this->session->userAgent|stripos:'MSIE' === false}<?xml version="1.0" encoding="{@CHARSET}"?>
	{/if}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" dir="{lang}wcf.global.pageDirection{/lang}" xml:lang="{@LANGUAGE_CODE}">
{/if}