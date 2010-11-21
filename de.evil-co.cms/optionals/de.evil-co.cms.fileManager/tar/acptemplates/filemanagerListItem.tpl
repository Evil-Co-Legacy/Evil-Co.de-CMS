<li id="item_{@$item->getPathname()|urlencode}" class="deletable">
	<div class="buttons">
		{if $this->user->getPermission('admin.content.cms.filemanager.canEditFiles')}
			{if $item->isDir()}
				<a href="index.php?form=FilemanagerCreateHtaccess&amp;dir={@$item->getPathname()|urlencode}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" class="deleteButton"><img src="{@RELATIVE_CMS_DIR}icon/createHtaccessS.png" alt="" title="{lang}cms.filemanager.list.item.createHtaccess{/lang}" /></a>
			{/if}
			<a href="index.php?action=FilemanagerDelete&amp;file={@$item->getPathname()|urlencode}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" class="deleteButton"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" title="{lang}cms.filemanager.list.item.delete{/lang}" longdesc="{lang}cms.filemanager.list.item.delete.sure{/lang}" /></a>
		{/if}
	</div>
	
	<h3 class="itemListTitle{if $item->isDir()} itemListCategory{/if}">
		{$item->getFilename()} ({lang owner=$item->getOwner() timestamp=$item->getMTime() creationTimestamp=$item->getCTime() size=$item->getSize()}cms.filemanager.list.item.details{/lang})
	</h3>
	
	{if $item->isDir() && $item->hasChildren()}
		<ol id="parentItem_{@$item->getPathname()|urlencode}">
			{foreach from=$item->getChildren() item=$child}
				{include file='filemanagerListItem' item=$child}
			{/foreach}
		</ol>
	{/if}
</li>