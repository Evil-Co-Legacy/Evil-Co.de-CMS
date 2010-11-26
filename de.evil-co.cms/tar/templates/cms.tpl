{include file='documentHeader'}
	<head>
		<title>{lang}{$page->title}{/lang} - {lang}{$this->activeHost->title}{/lang}</title>
		{assign var='allowSpidersToIndexThisPage' value=$page->getAllowSpidersToIndexThisPage()}
		{include file='headInclude' sandbox=false}
		
		{* Insert user defined tags *}
		{@$page->additionalHeadContent}
		
		{* Insert module defined tags *}
		{foreach from=$modules item='position'}
			{foreach from=$position item='module'}
				{if $module->stylesheet != '' && $module->instanceNumber == 1}<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}style/{@$module->stylesheet}" />{/if}
				{if $module->additionalHeadContents != '' && $module->instanceNumber == 1}{@$module->additionalHeadContents}{/if}
			{/foreach}
		{/foreach}
		
		{* Placeholder for additional contents *}
		{if $additionalHeadContents|isset}{@$additionalHeadContents}{/if}
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
		{include file='header' sandbox=false}
		
		<div id="main">
			{foreach from=$modules.top item='module'}
				{if $module->getTemplateName() != ''}
					{assign var='optionList' value=$module->getOptions()}
					{include file=$module->getTemplateName()}
				{else}
					<!-- Module class {$module|get_class} ({$module->getName()}) does not define a template name -->
				{/if}
			{/foreach}
			
			<div class="layout-4">
				<div class="columnContainer">
					{if $modules.left|count}
						<div id="modulesLeft" class="first column">
							{foreach from=$modules.left item='module'}
								{if $module->getTemplateName() != ''}
									{assign var='optionList' value=$module->getOptions()}
									{include file=$module->getTemplateName()}
								{else}
									<!-- Module class {$module|get_class} ({$module->getName()}) does not define a template name -->
								{/if}
							{/foreach}
						</div>
					{/if}
					{if $modules.center|count}
						<div id="modulesCenter" class="{if $modules.left|count}second{else}first{/if} column">
							{foreach from=$modules.center item='module'}
								{if $module->getTemplateName() != ''}
									{assign var='optionList' value=$module->getOptions()}
									{include file=$module->getTemplateName()}
								{else}
									<!-- Module class {$module|get_class} ({$module->getName()}) does not define a template name -->
								{/if}
							{/foreach}
						</div>
					{/if}
					{if $modules.right|count}
						<div id="modulesRight" class="{if $modules.left|count && $modules.center|count}third{elseif $modules.left|count || $modules.right|count}second{else}first{/if}">
							{foreach from=$modules.right item='module'}
								{if $module->getTemplateName() != ''}
									{assign var='optionList' value=$module->getOptions()}
									{include file=$module->getTemplateName()}
								{else}
									<!-- Module class {$module|get_class} ({$module->getName()}) does not define a template name -->
								{/if}
							{/foreach}
						</div>
					{/if}
				</div>
			</div>
			
			{foreach from=$modules.bottom item='module'}
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