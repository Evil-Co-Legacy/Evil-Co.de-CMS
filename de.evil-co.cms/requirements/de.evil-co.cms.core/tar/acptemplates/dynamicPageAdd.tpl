{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/pageAddL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wcf.cms.page.add.title{/lang}</h2>
	</div>
</div>


<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li>
				<a href="index.php?page=DynamicHostList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.host.list.title{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/hostListM.png" alt="" /> <span>{lang}wcf.cms.host.list.title{/lang}</span></a>
			</li>
			
			<li>
				<a href="index.php?page=DynamicPageList&amp;hostID={if $action == 'add'}{$host->hostID}{else}{$page->hostID}{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.page.list.title{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/pageAddM.png" alt="" /> <span>{lang}wcf.cms.page.list.title{/lang}</span></a>
			</li>
			
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

<form action="index.php?form=DynamicPage{$action|ucfirst}{if $action == 'add'}&amp;hostID={$hostID}{else}&amp;pageID={$pageID}{/if}" method="post">
	<fieldset>
		<legend><a href="javascript:void(openList('detailsContent',{ openTitle: '{lang}wcf.cms.page.add.details.show{/lang}', closeTitle: '{lang}wcf.cms.page.add.details.hide{/lang}' }));"><img src="{@RELATIVE_WCF_DIR}icon/minusS.png" id="detailsContentImage" alt="" title="{lang}wcf.cms.page.add.details.hide{/lang}" /> <span>{lang}wcf.cms.page.add.details{/lang}</span></a></legend>
		
		<div id="detailsContent">
			<div class="formElement{if $errorField == 'title'} formError{/if}">
				<div class="formFieldLabel">
					<label for="title">{lang}wcf.cms.page.add.details.title{/lang}</label>
				</div>
				<div class="formField">
					<input type="text" class="inputText" name="title" value="{$title}" />
					{if $errorField == 'title'}
						<p class="innerError">
							{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
							{if $errorType == 'notAvailable'}{lang}wcf.cms.page.add.details.title.notAvailable{/lang}{/if}
						</p>
					{/if}
				</div>
				<div class="formFieldDesc" id="titleHelpMessage">
					{lang}wcf.cms.page.add.details.title.description{/lang}
				</div>
			</div>
			<script type="text/javascript">
				inlineHelp.register('title');
			</script>
		</div>
	</fieldset>
	
	{if $action == 'add'}
		<fieldset>
			<legend><a href="javascript:void(openList('menuContent',{ openTitle: '{lang}wcf.cms.page.add.menu.show{/lang}', closeTitle: '{lang}wcf.cms.page.add.menu.hide{/lang}' }));"><img src="{@RELATIVE_WCF_DIR}icon/plusS.png" id="menuContentImage" alt="" title="{lang}wcf.cms.page.add.menu.show{/lang}" /> <span>{lang}wcf.cms.page.add.menu{/lang}</span></a></legend>
			
			<div id="menuContent" style="display: none;">
				<div class="formElement">
					<div class="formField">
						<label for="createMenuItem"><input type="checkbox" value="1" name="createMenuItem" {if $createMenuItem}checked="checked" {/if}/> {lang}wcf.cms.page.add.menu.createMenuItem{/lang}</label>
					</div>
					<div class="formFieldDesc" id="createMenuItemHelpMessage">
						{lang}wcf.cms.page.add.menu.createMenuItem.description{/lang}
					</div>
				</div>
				<script type="text/javascript">
					inlineHelp.register('createMenuItem');
				</script>
				
				<div class="formElement">
					<div class="formFieldLabel">
						<label for="menuItemPosition">{lang}wcf.cms.page.add.menu.menuItemPosition{/lang}</label>
					</div>
					<div class="formField">
						<select name="menuItemPosition">
							<option value="header" {if $menuItemPosition == 'header'}selected="selected"{/if}>{lang}wcf.cms.page.add.menu.menuItemPosition.header{/lang}</option>
							<option value="footer" {if $menuItemPosition == 'footer'}selected="selected"{/if}>{lang}wcf.cms.page.add.menu.menuItemPosition.footer{/lang}</option>
						</select>
					</div>
					<div class="formFieldDesc" id="menuItemPositionHelpMessage">
						{lang}wcf.cms.page.add.menu.menuItemPosition.description{/lang}
					</div>
				</div>
				<script type="text/javascript">
					inlineHelp.register('menuItemPosition');
				</script>
				
				<div class="formElement">
					<div class="formFieldLabel">
						<label for="menuItemSortOrder">{lang}wcf.cms.page.add.menu.menuItemSortOrder{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" name="menuItemSortOrder" class="inputText" value="{$menuItemSortOrder}" />
					</div>
					<div class="formFieldDesc" id="menuItemSortOrderHelpMessage">
						{lang}wcf.cms.page.add.menu.menuItemSortOrder.description{/lang}
					</div>
				</div>
				<script type="text/javascript">
					inlineHelp.register('menuItemSortOrder');
				</script>
				
				<div class="formElement{if $errorField == 'menuItemIconS'} formError{/if}">
					<div class="formFieldLabel">
						<label for="menuItemIconS">{lang}wcf.cms.page.add.menu.menuItemIconS{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" name="menuItemIconS" class="inputText" value="{$menuItemIconS}" />
						{if $errorField == 'menuItemIconS'}
							<p class="innerError">
								{lang}wcf.global.error.empty{/lang}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc" id="menuItemIconSHelpMessage">
						{lang}wcf.cms.page.add.menu.menuItemIconS.description{/lang}
					</div>
				</div>
				<script type="text/javascript">
					inlineHelp.register('menuItemIconS');
				</script>
				
				<div class="formElement{if $errorField == 'menuItemIconM'} formError{/if}">
					<div class="formFieldLabel">
						<label for="menuItemIconM">{lang}wcf.cms.page.add.menu.menuItemIconM{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" name="menuItemIconM" class="inputText" value="{$menuItemIconM}" />
						{if $errorField == 'menuItemIconM'}
							<p class="innerError">
								{lang}wcf.global.error.empty{/lang}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc" id="menuItemIconMHelpMessage">
						{lang}wcf.cms.page.add.menu.menuItemIconM.description{/lang}
					</div>
				</div>
				<script type="text/javascript">
					inlineHelp.register('menuItemIconM');
				</script>
				
				<div class="formElement">
					<div class="formFieldLabel">
						<label for="menuItemTitle">{lang}wcf.cms.page.add.menu.menuItemTitle{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" name="menuItemTitle" class="inputText" value="{$menuItemTitle}" />
					</div>
					<div class="formFieldDesc" id="menuItemTitleHelpMessage">
						{lang}wcf.cms.page.add.menu.menuItemTitle.description{/lang}
					</div>
				</div>
				<script type="text/javascript">
					inlineHelp.register('menuItemTitle');
				</script>
			</div>
		</fieldset>
	{/if}
		
	<fieldset>
			<legend><a href="javascript:void(openList('publishContent',{ openTitle: '{lang}wcf.cms.page.add.publish.show{/lang}', closeTitle: '{lang}wcf.cms.page.add.publish.hide{/lang}' }));"><img src="{@RELATIVE_WCF_DIR}icon/minusS.png" id="publishContentImage" alt="" title="{lang}wcf.cms.page.add.publish.hide{/lang}" /> <span>{lang}wcf.cms.page.add.publish{/lang}</span></a></legend>
	
			<div id="publishContent">
				<div class="formElement">
					<div class="formField">
						<label for="isPublic"><input type="checkbox" name="isPublic" value="1" {if $isPublic}checked="checked" {/if} /> {lang}wcf.cms.page.add.publish.isPublic{/lang}</label>
					</div>
					<div class="formFieldDesc" id="isPublicHelpMessage">
						{lang}wcf.cms.page.add.publish.isPublic.description{/lang}
					</div>
				</div>
				<script type="text/javascript">
					inlineHelp.register('isPublic');
				</script>
				
				<div class="formElement">
					<div class="formField">
						<label for="isDefaultPage"><input type="checkbox" name="isDefaultPage" value="1" {if $isDefaultPage}checked="checked" {/if} /> {lang}wcf.cms.page.add.publish.isDefaultPage{/lang}</label>
					</div>
					<div class="formFieldDesc" id="isDefaultPageHelpMessage">
						{lang}wcf.cms.page.add.publish.isDefaultPage.description{/lang}
					</div>
				</div>
				<script type="text/javascript">
					inlineHelp.register('isDefaultPage');
				</script>
			</div>
	</fieldset>
	
	<fieldset>
		<legend><a href="javascript:void(openList('expertContent',{ openTitle: '{lang}wcf.cms.page.add.expert.show{/lang}', closeTitle: '{lang}wcf.cms.page.add.expert.hide{/lang}' }));"><img src="{@RELATIVE_WCF_DIR}icon/plusS.png" id="expertContentImage" alt="" title="{lang}wcf.cms.page.add.expert.show{/lang}" /> <span>{lang}wcf.cms.page.add.expert{/lang}</span></a></legend>
		
		<div id="expertContent" style="display: none;">
			<div class="formElement">
				<div class="formField">
					<label for="allowSpidersToIndexThisPage"><input type="checkbox" value="1" name="allowSpidersToIndexThisPage" {if $allowSpidersToIndexThisPage}checked="checked"{/if} /> {lang}wcf.cms.page.add.expert.allowSpidersToIndexThisPage{/lang}</label>
				</div>
				<div class="formFieldDesc" id="allowSpidersToIndexThisPageHelpMessage">
					{lang}wcf.cms.page.add.expert.allowSpidersToIndexThisPage.description{/lang}
				</div>
			</div>
			<script type="text/javascript">
				inlineHelp.register('allowSpidersToIndexThisPage');
			</script>
			
			<div class="formElement">
				<div class="formFieldLabel">
					<label for="additionalHeadContent">{lang}wcf.cms.page.add.expert.additionalHeadContent{/lang}</label>
				</div>
				<div class="formField">
					<textarea rows="10" columns="40" name="additionalHeadContent">{$additionalHeadContent}</textarea>
				</div>
				<div class="formFieldDesc" id="additionalHeadContentHelpMessage">
					{lang}wcf.cms.page.add.expert.additionalHeadContent.description{/lang}
				</div>
			</div>
			<script type="text/javascript">
				inlineHelp.register('additionalHeadContent');
			</script>
		</div>
	</fieldset>
	
	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" name="submit" />
		<input type="reset" accesskey="r" id="reset" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
		{if $action == 'edit'}<input type="hidden" name="pageID" value="{@$pageID}" />{/if}
	 	{@SID_INPUT_TAG}
	 </div>
</form>

{include file='footer'}