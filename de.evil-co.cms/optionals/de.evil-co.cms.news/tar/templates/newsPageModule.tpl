<div id="newsPageModule{$module->instanceID}" class="newsPageModule">
	<div class="contentHeader">
		{if $this->user->getPermission('user.cms.news.canAddItems') || $additionalLargeButtons|isset}
			<div class="largeButtons">
				<ul>
					{if $this->user->getPermission('user.cms.news.canAddItems')}
						<li>
							<a href="index.php?form=NewsPageModuleItemAdd&amp;instanceID={@$module->instanceID}{@SID_ARG_2ND}" title="{lang}wcf.cms.module.news.add.title{/lang}">
								<img src="{icon}newsItemAddM.png{/icon}" alt="" /> <span>{lang}wcf.cms.module.news.add.title{/lang}</span>
							</a>
						</li>
					{/if}
					{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
				</ul>
			</div>
		{/if}
	</div>
	<div id="newsPageModule{$module->instanceID}Inner" class="newsPageModuleInner">
		{if $module->newsItems|count}
			{counter name='newsCount' start=1 assign='newsCount' print=false}
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
	<div class="contentFooter">
		{if $this->user->getPermission('user.cms.news.canAddItems') || $additionalLargeButtons|isset}
			<div class="largeButtons">
				<ul>
					{if $this->user->getPermission('user.cms.news.canAddItems')}
						<li>
							<a href="index.php?form=NewsPageModuleItemAdd&amp;instanceID={@$module->instanceID}{@SID_ARG_2ND}" title="{lang}wcf.cms.module.news.add.title{/lang}">
								<img src="{icon}newsItemAddM.png{/icon}" alt="" /> <span>{lang}wcf.cms.module.news.add.title{/lang}</span>
							</a>
						</li>
					{/if}
					{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
				</ul>
			</div>
		{/if}
	</div>
</div>