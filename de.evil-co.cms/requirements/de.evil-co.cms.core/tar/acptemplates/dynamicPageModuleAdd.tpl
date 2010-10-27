{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/dynamicPageModule{$action|ucfirst}L.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wcf.cms.page.edit.module.{$action}.title{/lang}</h2>
	</div>
</div>

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li>
				<a href="index.php?page=DynamicHostList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.host.list.title{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/hostListM.png" alt="" /> <span>{lang}wcf.cms.host.list.title{/lang}</span></a>
			</li>
		</ul>
	</div>
</div>

{* Module add form *}
{if $action == 'add'}
	<fieldset>
		<legend>{lang}wcf.cms.page.edit.module.add.general{/lang}</legend>
		
		<div class="formElement">
			<div class="formFieldLabel">
				<label for="moduleID">{lang}wcf.cms.page.edit.module.add.general.moduleID{/lang}</label>
			</div>
			<div class="formField">
				<select name="moduleID">
					{foreach from=$moduleList item=$module}
						<option value="{$module.moduleID}">{lang}wcf.cms.module.{$module.name}.title{/lang}</option>
					{/foreach}
				</select>
			</div>
			<div class="formFieldDesc" id="moduleIDHelpMessage">
				{lang}wcf.cms.page.edit.module.add.general.moduleID.description{/lang}
			</div>
		</div>
		<script type="text/javascript">
			inlineHelp.register('moduleID');
		</script>
	</fieldset>
{/if}

{* Module edit form *}
{if $action == 'edit'}
	{foreach from=$module->options->getOptions() item='group'}
		<fieldset>
			<legend>{lang}wcf.cms.module.option.category.{$group->getName()}.title{/lang}</legend>
			
			{foreach from=$group->getOptions() item='option'}
				<div class="formField">
					{if $option->getType() != 'boolean'}
						<div class="formFieldLabel">
							<label for="{$group->getName()}[{$option->getName()}]">{lang}wcf.cms.module.option.{$option->getName()}.title</label>
						</div>
					{/if}
					<div class="formField">
						{if $option->getType() != 'boolean'}
							{if $option->getType() != 'textarea'}
								<input type="{$option->getType()}" name="{$group->getName()}[[$option->getName()}]" value="{$option->getValue()}" class="{$option->getCssClass()}" />
							{else}
								<textarea rows="10" columns="40" name="{$group->getName()}[[$option->getName()}]">{$option->getValue()}</textarea>
							{/if}
						{else}
							<label for="{$group->getName()}[{$option->getName()}]"><input type="checkbox" name="{$group->getName()}[{$option->getName()}]" {if $option->getValue()}checked="checked" {/if} /> {lang}wcf.cms.module.option.{$option->getName()}.title{/lang}</label>
						{/if}
					</div>
					{if $option->getDisplayDescription()}
						<div class="formFieldDesc" id="{$group->getName()|concat:$option->getName()|sha1}HelpMessage">
							{lang}wcf.cms.module.option.{$option->getName()}.description{/lang}
						</div>
					{/if}
				</div>
				{if $option->displayDescription}
					<script type="text/javascript">
						inlineHelp.register('{$group->getName()|concat:$option->getName()|sha1|encodejs}');
					</script>
				{/if}
			{/foreach}
		</fieldset>
	{/foreach}
{/if}

{include file='footer'}