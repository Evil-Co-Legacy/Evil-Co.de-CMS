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
				<a href="index.php?form=DynamicPageEdit&amp;pageID={$pageID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.page.edit.title{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/pageEditM.png" alt="" /> <span>{lang}wcf.cms.page.edit.title{/lang}</span></a>
			</li>
		</ul>
	</div>
</div>

<form action="index.php?form=DynamicPageModule{$action|ucfirst}" method="post">
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
		{foreach from=$options->getOptionGroups() item='group'}
			<fieldset>
				<legend>{lang}wcf.cms.module.{$instance->getName()}.option.category.{$group->getName()}.title{/lang}</legend>
				
				{foreach from=$group->getOptions() item='option'}
					<div class="formElement">
						{if $option->getType() != 'boolean'}
							<div class="formFieldLabel">
								<label for="{$group->getName()}[{$option->getName()}]">{lang}wcf.cms.module.{$instance->getName()}.option.{$option->getName()}.title{/lang}</label>
							</div>
						{/if}
						<div class="formField">
							{if $option->getType() != 'boolean'}
								{if $option->getType() == 'textarea'}
									<textarea rows="10" columns="40" name="{$group->getName()}[{$option->getName()}]">{$option->getValue()}</textarea>
								{elseif $option->getType() == 'select'}
									<select name="{$group->getName()}[{$option->getName()}]">
										{foreach from=$option->getFields() item='field'}
											<option value="{$field.value}" {if $option->getValue() == $field.value}selected="selected" {/if}>{lang}{$field.name}{/lang}</option>
										{/foreach}
									</select>
								{else}
									<input type="{$option->getType()}" name="{$group->getName()}[{$option->getName()}]" value="{$option->getValue()}" class="{$option->getCssClass()}" />
								{/if}
							{else}
								<label for="{$group->getName()}[{$option->getName()}]"><input type="checkbox" name="{$group->getName()}[{$option->getName()}]" {if $option->getValue()}checked="checked" {/if} value="1" /> {lang}wcf.cms.module.option.{$option->getName()}.title{/lang}</label>
							{/if}
						</div>
						{if $option->getDisplayDescription()}
							<div class="formFieldDesc" id="{$group->getName()|concat:$option->getName()|sha1}HelpMessage">
								{lang}wcf.cms.module.{$instance->getName()}.option.{$option->getName()}.description{/lang}
							</div>
						{/if}
					</div>
					{if $option->getDisplayDescription()}
						<script type="text/javascript">
							inlineHelp.register('{$group->getName()|concat:$option->getName()|sha1|encodejs}');
						</script>
					{/if}
				{/foreach}
			</fieldset>
		{/foreach}
	{/if}
	
	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" name="submit" />
		<input type="reset" accesskey="r" id="reset" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
		<input type="hidden" name="pageID" value="{@$pageID}" />
		{if $action == 'edit'}
			<input type="hidden" name="instanceID" value="{@$instanceID}" />
		{/if}
	 	{@SID_INPUT_TAG}
	 </div>
 </form>

{include file='footer'}