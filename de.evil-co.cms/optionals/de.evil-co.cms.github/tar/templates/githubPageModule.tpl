{if $module->apiError == ''}
	{if $module->commits|count}
		<div class="border borderMarginRemove">
			<table class="tableList">
				<thead>
					<tr class="tableHead">
						<th><div><a id="id">{lang}wcf.cms.module.github.page.commitID{/lang}</a></div></th>
						<th><div><a id="message">{lang}wcf.cms.module.github.page.message{/lang}</a></div></th>
						<th><div><a id="author">{lang}wcf.cms.module.github.page.author{/lang}</a></div></th>
						<th><div><a id="date">{lang}wcf.cms.module.github.page.date{/lang}</a></div></th>
									
						{if $additionalColumns|isset}{@$additionalColumns}{/if}
					</tr>
				</thead>
				<tbody>
					{foreach from=$module->commits item='commit'}
						<tr>
							<td><a href="{$commit.url}">{$commit.id}</a></td>
							<td>{$commit.message}</td>
							<td>{$commit.author} ({$commit.authorEmail})</td>
							<td>{@$commit.date|time}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	{else}
		<p class="info">{lang}wcf.cms.module.github.page.noCommits{/lang}</p>
	{/if}
{else}
	<p class="error">{lang}wcf.cms.module.github.page.apiError{/lang}<!-- Error: {$module->apiError} --></p>
{/if}