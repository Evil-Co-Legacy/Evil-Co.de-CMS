{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/host{$action}L.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wcf.cms.host.{$action}.title{/lang}</h2>
	</div>
</div>

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li>
				<a href="index.php?page=DynamicHostList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.host.list.title{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/hostListM.png" alt="" /> <span>{lang}wcf.cms.host.list.title{/lang}</span></a>
			</li>
			
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wcf.cms.host.{$action}.success{/lang}</p>
{/if}

<form action="index.php?form=DynamicHost{$action|ucfirst}" method="post">
	<fieldset>
		<legend>{lang}wcf.cms.host.add.general{/lang}</legend>
		
		<div class="formElement"{if $errorField == 'title'} class="formError"{/if}>
			<div class="formFieldLabel">
				<label for="title">{lang}wcf.cms.host.add.general.title{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" value="{$title}" name="title" />
				{if $errorField == 'title'}
					<p class="innerError">
						{lang}wcf.global.error.empty{/lang}
					</p>
				{/if}
			</div>
			<div class="formFieldDesc">
				{lang}wcf.cms.host.add.general.title.description{/lang}
			</div>
		</div>
		
		<div class="formElement"{if $errorField == 'hostname'} class="formError"{/if}>
			<div class="formFieldLabel">
				<label for="hostname">{lang}wcf.cms.host.add.general.hostname{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" value="{$hostname}" name="hostname" />
				{if $errorField == 'hostname'}
					<p class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'invalid'}{lang}wcf.cms.host.add.general.hostname.invalid{/lang}{/if}
					</p>
				{/if}
			</div>
			<div class="formFieldDesc">
				{lang}wcf.cms.host.add.general.hostname.description{/lang}
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend><a href="javascript:void(openList('expertSettingsContent',{ openTitle: '{lang}wcf.cms.host.add.expertSettings.show{/lang}', closeTitle: '{lang}wcf.cms.host.add.expertSettings.hide{/lang}' }));"><img src="{@RELATIVE_WCF_DIR}icon/plusS.png" id="expertSettingsContentImage" alt="" title="{lang}wcf.cms.host.add.expertSettings.show{/lang}" /> <span>{lang}wcf.cms.host.add.expertSettings{/lang}</span></a></legend>
	
		<div id="expertSettingsContent" style="display: none;">
			<div class="formElement">
				<div class="formField">
					<label for="isFallback"><input type="checkbox" {if $isFallback}checked="checked" {/if}value="1" name="isFallback" /> {lang}wcf.cms.host.add.expertSettings.isFallback{/lang}</label>
				</div>
				<div class="formFieldDesc">
					{lang}wcf.cms.host.add.expertSettings.isFallback.description{/lang}
				</div>
			</div>
			
			<div class="formElement">
				<div class="formFieldLabel">
					<label for="languageCode">{lang}wcf.cms.host.add.expertSettings.languageCode{/lang}</label>
				</div>
				<div class="formField">
					<input type="text" class="inputText" name="languageCode" value="{$languageCode}" />
				</div>
				<div class="formFieldDesc">
					{lang}wcf.cms.host.add.expertSettings.languageCode.description{/lang}
				</div>
			</div>
		</div>
	</fieldset>
	
	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" id="reset" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
		{if $action == 'edit'}<input type="hidden" name="hostID" value="{@$hostID}" />{/if}
	 	{@SID_INPUT_TAG}
	 </div>
</form>

{include file='footer'}