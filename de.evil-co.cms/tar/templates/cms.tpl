{include file='documentHeader'}
	<head>
		<title>{lang}{$page->title}{/lang} - {lang}{PAGE_TITLE}{/lang}</title>
		{assign var='allowSpidersToIndexThisPage' value=$page->getAllowSpidersToIndexThisPage()}
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
			{assign var='optionList' value=$module->getOptions()}
			{if $module->getTemplateName() != ''}
				{include file=$module->getTemplateName()}
			{else}
				<!-- Module class {$module|get_class} does not define a template name -->
			{/if}
		{/foreach}
		
		{include file='footer' sandbox=false}
	</body>
</html>