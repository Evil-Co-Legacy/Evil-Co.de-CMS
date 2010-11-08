{include file='documentHeader'}
	<head>
		<title>{lang}{$page->title}{/lang} - {lang}{$this->activeHost->title}{/lang}</title>
		{assign var='allowSpidersToIndexThisPage' value=$page->getAllowSpidersToIndexThisPage()}
		{include file='headInclude' sandbox=false}
		
		{* Insert user defined tags *}
		{@$page->additionalHeadContent}
		
		{* Insert module defined tags *}
		{foreach from=$modules item='module'}
			{if $module->stylesheet != '' and $module->instanceNumber == 1}<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}style/{@$module->stylesheet}" />{/if}
			{if $module->additionalHeadContents != '' and $module->instanceNumber == 1}{@$module->additionalHeadContents}{/if}
		{/foreach}
		
		{* Placeholder for additional contents *}
		{if $additionalHeadContents|isset}{@$additionalHeadContents}{/if}
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
		{include file='header' sandbox=false}
		
		<div id="main">
			{foreach from=$modules item='module'}
				{if $module->getTemplateName() != ''}
					{assign var='optionList' value=$module->getOptions()}
					{include file=$module->getTemplateName()}
				{else}
					<!-- Module class {$module|get_class} ({$module->getName()}) does not define a template name -->
				{/if}
			{/foreach}
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>