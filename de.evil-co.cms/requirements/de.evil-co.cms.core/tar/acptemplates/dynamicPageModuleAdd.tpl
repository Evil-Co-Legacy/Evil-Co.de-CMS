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
	{foreach from=$module->getOptionGroups() item='group'}
		<fieldset>
			<legend>{lang}wcf.cms.module.option.category.{$group->name}.title{/lang}</legend>
			
			{foreach from=$group->getOptions() item='option'}
				<div class="formField">
					{if $option->type != 'boolean'}
						<div class="formFieldLabel">
							<label for="{$group->name}[{$option->name}]">{lang}wcf.cms.module.option.{$option->name}.title</label>
						</div>
					{/if}
					<div class="formField">
						{if $option->type != 'boolean'}
							{if $option->type != 'textarea'}
								<input type="{$option->type}" name="{$group->name}[[$option->name}]" value="{$option->value}" class="{$option->cssClass}" />
							{else}
								<textarea rows="10" columns="40" name="{$group->name}[[$option->name}]">{$option->value}</textarea>
							{/if}
						{else}
							<label for="{$group->name}[{$option->name}]"><input type="checkbox" name="{$group->name}[{$option->name}]" {if $option->value}checked="checked" {/if} /> {lang}wcf.cms.module.option.{$option->name}.title{/lang}</label>
						{/if}
					</div>
					{if $option->displayDescription}
						<div class="formFieldDesc" id="{$group->name|concat:$option->name|sha1}HelpMessage">
							{lang}wcf.cms.module.option.{$option->name}.description{/lang}
						</div>
					{/if}
				</div>
				{if $option->displayDescription}
					<script type="text/javascript">
						inlineHelp.register('{$group->name|concat:$option->name|sha1|encodejs}');
					</script>
				{/if}
			{/foreach}
		</fieldset>
	{/foreach}
{/if}

{include file='footer'}