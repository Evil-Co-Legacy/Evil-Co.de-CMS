{include file="documentHeader"}
	<head>
		<title>{lang}wcf.cms.module.news.{$action}.title{/lang} - {lang}{PAGE_TITLE}{/lang}</title>

		{include file='headInclude' sandbox=false}
		<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/TabbedPane.class.js"></script>
		{if $canUseBBCodes}{include file="wysiwyg"}{/if}
	</head>
	<body{if $templateName|isset} id="tpl{$templateName|ucfirst}"{/if}>
		{include file='header' sandbox=false}

		<div id="main">
			<ul class="breadCrumbs">
				<li><a href="index.php?page=Index{@SID_ARG_2ND}"><img src="{icon}indexS.png{/icon}" alt="" /> <span>{lang}{PAGE_TITLE}{/lang}</span></a> &raquo;</li>
				{@$category->getBreadCrumbs()}
			</ul>
		
			<div class="mainHeadline">
				<img src="{icon}ticket{@$action|ucfirst}L.png{/icon}" alt="" />
				<div class="headlineContainer">
					<h2>{lang}wcf.cms.module.news.{@$action}.title{/lang}</h2>
				</div>
			</div>
			
			{if $userMessages|isset}{@$userMessages}{/if}
			
			{if $errorField}
				<p class="error">{lang}wcf.global.form.error{/lang}</p>
			{/if}
			
			<form method="post" action="index.php?form=NewsPageModuleItem{@$action|ucfirst}">
				<div class="border content">
					<div class="container-1">
						<fieldset>
							<legend>{lang}wcf.cms.module.news.add.information{/lang}</legend>
								
							{if !$this->user->userID}
								<div class="formElement{if $errorField == 'username'} formError{/if}">
									<div class="formFieldLabel">
										<label for="username">{lang}wcf.user.username{/lang}</label>
									</div>
									<div class="formField">
										<input type="text" class="inputText" name="username" id="username" value="{$username}" tabindex="{counter name='tabindex'}" />
										{if $errorField == 'username'}
											<p class="innerError">
												{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
												{if $errorType == 'notValid'}{lang}wcf.user.error.username.notValid{/lang}{/if}
												{if $errorType == 'notAvailable'}{lang}wcf.user.error.username.notUnique{/lang}{/if}
											</p>
										{/if}
									</div>
								</div>
							{/if}
							
							<div class="formElement{if $errorField == 'subject'} formError{/if}">
								<div class="formFieldLabel">
									<label for="subject">{lang}wcf.cms.module.news.add.subject{/lang}</label>
								</div>
								<div class="formField">
									<input type="text" class="inputText" id="subject" name="subject" value="{$subject}" tabindex="{counter name='tabindex'}" />
									{if $errorField == 'subject'}
										<p class="innerError">
											{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
										</p>
									{/if}
								</div>
							</div>
								
							{if $additionalInformationFields|isset}{@$additionalInformationFields}{/if}
						</fieldset>
						
						<fieldset>
							<legend>{lang}wcf.cms.module.news.add.text{/lang}</legend>
							
							<div class="editorFrame formElement{if $errorField == 'text'} formError{/if}" id="textDiv">
			
								<div class="formFieldLabel">
									<label for="text">{lang}wcf.cms.module.news.add.text{/lang}</label>
								</div>
								
								<div class="formField">				
									<textarea name="text" id="text" rows="15" cols="40" tabindex="{counter name='tabindex'}">{$text}</textarea>
									{if $errorField == 'text'}
										<p class="innerError">
											{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
											{if $errorType == 'censoredWordsFound'}{lang}wcf.message.error.censoredWordsFound{/lang}{/if}
										</p>
									{/if}
								</div>
								
							</div>
							
							{include file='messageFormTabs'}
							
						</fieldset>
						
						{include file='captcha'}
						{if $additionalFields|isset}{@$additionalFields}{/if}
					</div>
				</div>
		
				<div class="formSubmit">
					<input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" tabindex="{counter name='tabindex'}" />
					<input type="reset" name="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" tabindex="{counter name='tabindex'}" />
					<input type="hidden" name="{if $action == 'add'}instanceID{else}itemID{/if}" value="{if $action='add'}{@$instanceID}{else}{@$itemID}{/if}" />
					{@SID_INPUT_TAG}
				</div>
			</form>
		</div>
		
		{include file='footer' sandbox=false}
	</body>
</html>