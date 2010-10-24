{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/host{$action}L.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wcf.cms.page.{$action}.title{/lang}</h2>
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

<form action="index.php?form=DynamicHostAdd" method="post">
	<fieldset>
		<legend>{lang}wcf.cms.page.add.general{/lang}</legend>
		
		<div class="formElement">
			<div class="formFieldLabel">
				<label for="title">{lang}wcf.cms.page.add.general.title{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" value="{$title}" name="title" />
			</div>
		</div>
		
		<div class="formElement">
			<div class="formFieldLabel">
				<label for="hostname">{lang}wcf.cms.page.add.general.hostname{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" value="{$hostname}" name="hostname" />
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend><a href="javascript:void(openList('expertSettingsContent',{ openTitle: '{lang}wcf.cms.page.add.expertSettings.show{/lang}', closeTitle: '{lang}wcf.cms.page.add.expertSettings.hide{/lang}' }));"><img src="{icon}plusS.png{/icon}" id="expertSettingsImage" alt="" title="{lang}wcf.cms.page.add.expertSettings.show{/lang}" /> <span>{lang}wcf.cms.page.add.expertSettings{/lang}</span></a></legend>
	
		<div class="formElement">
			<div class="formFieldLabel">
				<label for="isFallback"><input type="checkbox" value="{if $isFallback}1{else}0{/if}" name="isFallback" /> {lang}wcf.cms.page.add.expertSettings.isFallback{/lang}</label>
			</div>
		</div>
		
		<div class="formElement">
			<div class="formFieldLabel">
				<label for="languageCode">{lang}wcf.cms.page.add.expertSettings.languageCode{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" name="languageCode" value="{$languageCode}" />
			</div>
		</div>
	</fieldset>
	
	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" id="reset" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
	 	{@SID_INPUT_TAG}
	 </div>
</form>

{include file='footer'}