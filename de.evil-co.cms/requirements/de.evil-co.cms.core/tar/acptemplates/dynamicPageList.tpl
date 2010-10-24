{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/pageListL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wcf.cms.page.list.title{/lang}</h2>
	</div>
</div>


<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li>
				<a href="index.php?page=DynamicHostList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.host.list.title{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/hostListM.png" alt="" /> <span>{lang}wcf.cms.host.list.title{/lang}</span></a>
			</li>
			
			<li>
				<a href="index.php?form=DynamicHostEdit&amp;hostID={$host->hostID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.host.edit.title{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/hostEditM.png" alt="" /> <span>{lang}wcf.cms.host.edit.title{/lang}</span></a>
			</li>
			
			<li>
				<a href="index.php?action=DynamicHostDelete&amp;hostID={$host->hostID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.host.delete{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/hostDeleteM.png" alt="" /> <span>{lang}wcf.cms.host.delete{/lang}</span></a>
			</li>
			
			{if $this->user->getPermission('admin.content.cms.canAddPages')}
				<li>
					<a href="index.php?form=DynamicPageAdd&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.cms.page.add.title{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/pageAddM.png" alt="" /> <span>{lang}wcf.cms.page.add.title{/lang}</span></a>
				</li>
			{/if}
			
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>

{if $pages|count}
	<div class="border content">
		<div class="container-1">
			<ol class="itemList" id="pageList">
				{foreach from=$pages item=$page}
					{assign var=pageID value=$page->pageID}
					
					<li id="item_{@$categoryID}" class="deletable">
						<div class="buttons">
							{if $this->user->getPermission('admin.content.cms.canEditPages')}
								<a href="index.php?form=DynamicPageEdit&amp;pageID={@$pageID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" title="{lang}wcf.cms.page.edit{/lang}" /></a>

								<a href="index.php?action=DynamicPageDelete&amp;pageID={@$pageID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" class="deleteButton"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" title="{lang}wcf.cms.page.delete{/lang}" longdesc="{lang}wcf.cms.page.delete.sure{/lang}" /></a>
							{/if}
						</div>
						
						<h3 class="itemListTitle">
							ID-{@$pageID} {if $this->user->getPermission('admin.content.cms.canEditPages')}<a href="index.php?form=DynamicPageEdit&amp;pageID={@$pageID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" class="title">{lang}{$page->getTitle()}{/lang}</a>{else}{lang}{$page->getTitle()}{/lang}{/if}
						</h3>
					</li>
				{/foreach}
			</ol>
		</div>
	</div>
{/if}

{include file='footer'}