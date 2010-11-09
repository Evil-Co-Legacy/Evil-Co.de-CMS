{counter name='newsCount' assign='newsCount' print=false}
<div class="message{if $item->isDeleted} deleted{/if}{if !$item->isPublic} disabled{/if}">
	<div class="messageInner message{if $this->getStyle()->getVariable('messages.framed')}Framed{/if}{@$this->getStyle()->getVariable('messages.sidebar.alignment')|ucfirst} container-3">
		<a id="newsPageModule{@$module->instanceID}Item{@$item->itemID}"></a>

		{assign var="sidebar" value=$sidebarFactory->get('newsItem', $item->itemID)}
		{include file='messageSidebar'}

		<div class="messageContent">
			<div class="messageContentInner color-1">
				<div class="messageHeader">
					<p class="messageCount">
						<a href="{$this->session->requestURI}#newsPageModule{@$module->instanceID}Item{@$item->itemID}" title="{lang}wcf.cms.module.news.page.permalink{/lang}" class="messageNumber">{#$newsCount}</a>
					</p>

					<div class="containerIcon">
						<img src="{icon}{$ticket->getIcon()}{/icon}" alt="" title="{lang}wcf.cms.module.news.page.itemTitle{/lang}" />
					</div>
					
					<div class="containerContent">
						<p class="smallFont light">{lang}wcf.cms.module.news.page.timestamp{/lang}</p>
					</div>
				</div>
							
				<div class="messageBody">
					<div id="itemText{@$item->itemID}">
						{@$item->getFormatedMessage()}
					</div>
				</div>
							
				<div class="messageFooter">
					<div class="smallButtons">
						<ul>
							<li class="extraButton"><a href="#top" title="{lang}wcf.global.scrollUp{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/upS.png" alt="{lang}wcf.global.scrollUp{/lang}" /></a></li>
							{if $this->user->userID > 0 && $item->getAuthorID() == $this->user->userID || $this->user->getPermission('user.cms.news.canDeleteItems')}<li><a id="delete{@$item->itemID}" onclick="return confirm('{lang}wcf.cms.module.news.page.deleteItem.confirm{/lang}');" href="index.php?action=NewsPageModuleItemDelete&amp;itemID={@$item->itemID}{@SID_ARG_2ND}" title="{lang}wcf.cms.module.news.page.deleteItem{/lang}"><img src="{icon}deleteS.png{/icon}" alt="" /> <span>{lang}wcf.cms.module.news.page.deleteItem{/lang}</span></a></li>{/if}
							{if $this->user->userID > 0 && $item->getAuthorID() == $this->user->userID || $this->user->getPermission('user.cms.news.canEditItems')}<li><a id="edit{@$item->itemID}" href="index.php?form=NewsPageModuleItemEdit&amp;itemID={@$item->itemID}{@SID_ARG_2ND}" title="{lang}wcf.cms.module.news.page.editItem{/lang}"><img src="{icon}editS.png{/icon}" alt="" /> <span>{lang}wcf.cms.module.news.page.editItem{/lang}</span></a></li>{/if}
							{if $additionalButtons|isset}{@$additionalButtons}{/if}
						</ul>
					</div>
				</div>
				<hr />	
			</div>
		</div>
	</div>
</div>