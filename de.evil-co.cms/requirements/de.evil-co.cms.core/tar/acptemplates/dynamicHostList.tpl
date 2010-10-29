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

{if $hosts|count}
	<div class="border content">
		<div class="container-1">
			<ol class="itemList" id="pageList">
				{foreach from=$hosts item=$host}
					{assign var=hostID value=$host->hostID}
					
					<li id="item_{@$hostID}" class="deletable">
						<div class="buttons">
							{if $this->user->getPermission('admin.content.cms.canEditHosts')}
								<a href="index.php?form=DynamicHostEdit&amp;hostID={@$hostID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" title="{lang}wcf.cms.host.edit.title{/lang}" /></a>

								<a href="index.php?action=DynamicHostDelete&amp;hostID={@$hostID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" class="deleteButton"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" title="{lang}wcf.cms.host.delete{/lang}" longdesc="{lang}wcf.cms.host.delete.sure{/lang}" /></a>
							{/if}
						</div>
						
						<h3 class="itemListTitle">
							ID-{@$hostID} {if $this->user->getPermission('admin.content.cms.canEditHosts')}<a href="index.php?page=DynamicPageList&amp;hostID={@$hostID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" class="title">{lang}{$host->getTitle()}{/lang} ({$host->getHostname()})</a>{else}{lang}{$host->getTitle()}{/lang} ({$host->getHostname()}){/if}
						</h3>
					</li>
				{/foreach}
			</ol>
		</div>
	</div>
{/if}

{include file='footer'}