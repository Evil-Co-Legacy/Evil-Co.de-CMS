{include file='header'}

<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/ItemListEditor.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	function init() {
		{if $fileList|count > 0 && $fileList|count < 100 && $this->user->getPermission('admin.content.cms.filemanager.canEditFiles')}
			new ItemListEditor('fileList', { itemTitleEdit: true, itemTitleEditURL: 'index.php?action=FilemanagerRename&fileID=', tree: false, treeTag: 'ol' });
		{/if}
	}
	
	// when the dom is fully loaded, execute these scripts
	document.observe("dom:loaded", init);
</script>

<div class="mainHeadline">
	<img src="{@RELATIVE_CMS_DIR}icon/filemanagerL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}cms.filemanager.list.title{/lang}</h2>
	</div>
</div>

{if $displayNoHtaccessWarning|isset}
	<p class="warning">{lang}cms.filemanager.list.noHtaccess{/lang}</p>
{/if}

{if $this->user->getPermission('admin.content.cms.filemanager.canUploadFiles') || $additionalLargeButtons|isset}
	<div class="contentHeader">
		<div class="largeButtons">
			<ul>
				{if $this->user->getPermission('admin.content.cms.filemanager.canUploadFiles')}
					<li>
						<a href="index.php?form=FilemanagerUpload&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}cms.filemanager.upload.title{/lang}"><img src="{@RELATIVE_CMS_DIR}icon/filemanagerUploadM.png" alt="" /> <span>{lang}cms.filemanager.upload.title{/lang}</span></a>
					</li>
				{/if}
				{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
			</ul>
		</div>
	</div>
{/if}

{if $fileList|count}
	<div class="border content">
		<div class="container-1">
			<ol class="itemList" id="bugtrackerCategoryList">
				{foreach from=$fileList item='file'}
					{include file='filemanagerListItem' item=$file}
				{/foreach}
			</ol>
		</div>
	</div>
{/if}

{include file='footer'}