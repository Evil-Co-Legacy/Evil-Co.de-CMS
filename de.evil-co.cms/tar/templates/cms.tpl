{include file='documentHeader'}
	<head>
		<title>{lang}{$page->title}{/lang} - {lang}{PAGE_TITLE}{/lang}</title>
		{assign var='allowSpidersToIndexThisPage' value=$page->allowSpidersToIndexThisPage()}
		{include file='headInclude' sandbox=false}
		
		{* Insert user defined tags *}
		{@$page->additionalHeadContent}
		
		{foreach from=$modules item='module'}
			{if $module->stylesheet != ''}<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_CMS_DIR}style/{@$module->stylesheet}" />{/if}
			{if $module->additionalHeadContents != ''}{@$module->additionalHeadContents}{/if}
		{/foreach}
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
		{include file='header' sandbox=false}
		
		{foreach from=$modules item='module'}
			{include file=$module->display()}
		{/foreach}
		
		{include file='footer' sandbox=false}
	</body>
</html>