<div id="newsPageModule{$module->instanceID}" class="newsPageModule">
	{if $module->newsItems|count}
		{foreach from=$module->newsItems item='newsItem'}
			{include file='newsPageModuleItem' item=$newsItem}
		{/foreach}
	{else}
		<div class="border content">
			<div class="container-1">
				<p>{lang}wcf.cms.module.news.page.noNewsItems{/lang}</p>
			</div>
		</div>
	{/if}
</div>