{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/hostListL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wcf.cms.host.list.title{/lang}</h2>
	</div>
</div>

{if $this->user->getPermission('admin.content.cms.canAddHosts') || $additionalLargeButtons|isset}
	<div class="contentHeader">
		<div class="largeButtons">
			<ul>
				{if $this->user->getPermission('admin.content.cms.canAddHosts')}
					<li>
						<a href="index.php?form=DynamicHostAdd&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.host.add.title{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/hostAddM.png" alt="" /> <span>{lang}wcf.cms.host.add.title{/lang}</span></a>
					</li>
				{/if}
				{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
			</ul>
		</div>
	</div>
{/if}

<form action="index.php" method="get">
	<div class="border">
		<div class="container-1">
			<div class="formElement">
				<div class="formFieldLabel">
					<label for="hostID">{lang}wcf.cms.host.list.hostID{/lang}</label>
				</div>
				<div class="formField">
					<select name="hostID">
						{foreach from=$hosts item=$host}
							<option value="{$host->hostID}">{lang}{$host->getTitle()}{/lang}</option>
						{/foreach}
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" id="reset" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
		<input type="hidden" name="page" value="DynamicPageList" />
	 	{@SID_INPUT_TAG}
	 </div>
</form>

{include file='footer'}