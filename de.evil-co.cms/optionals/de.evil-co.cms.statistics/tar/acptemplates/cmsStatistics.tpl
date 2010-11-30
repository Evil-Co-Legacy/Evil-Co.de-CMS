{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/statsL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}cms.acp.statistics.title{/lang}</h2>
	</div>
</div>

<div id="hostStatistics">
	<h3 class="subHeadline">{lang}cms.acp.statistics.host.title{/lang}</h3>
	
	{include file='openFlashChart' openFlashChartSource="index.php?page=HostStatisticsChartSource&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
</div>

<div id="pageStatistics">
	<h3 class="subHeadline">{lang}cms.acp.statistics.page.title{/lang}</h3>
	
	{include file='openFlashChart' openFlashChartSource="index.php?page=PageStatisticsChartSource&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
</div>

<div id="refererStatistics">
	<h3 class="subHeadline">{lang}cms.acp.statistics.referer.title{/lang}</h3>
	
	{include file='openFlashChart' openFlashChartSource="index.php?page=RefererStatisticsChartSource&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
	
	<div id="refererDetails">
		<div class="border titleBarPanel">
			<div class="containerHead"><h3>{lang}cms.acp.statistics.referer.details.count{/lang}</h3></div>
		</div>
		<div class="border borderMarginRemove">
			<table class="tableList">
				<thead>
					<tr class="tableHead">
						<th id="columnHostname"><div><span class="emptyHead">{lang}cms.acp.statistics.referer.details.hostname{/lang}</span></div></th>
						<th id="columnCount"><div><span class="emptyHead">{lang}cms.acp.statistics.referer.details.count{/lang}</span></div></th>
						
						{if $additionalColumns|isset}{@$additionalColumns}{/if}
					</tr>
				</thead>
				<tbody>
					{foreach from=$hosts item=$host}
						<tr class="{cycle values="container-1,container-2"}">
							<td class="columnHostname">
								{if $host.children|count}
									<a href="javascript:void(openList('hostUrls{$host.hostID}',{ openTitle: '{lang}cms.acp.statistics.referer.details.moreDetails{/lang}', closeTitle: '{lang}cms.acp.statistics.referer.details.lessDetails{/lang}' }));">
										<span>{$host.url}</span>
									</a>

									<div id="hostUrls{$host.hostID}" style="display: none;">
										{foreach from=$host.children item=$url}
											<a title="{#$url.count}{lang}cms.acp.statistics.referer.details.urlCount{/lang}">{$url.url}</a>
										{/foreach}
									</div>
								{else}
									<span>{$host.url}</span>
								{/if}
							</td>
							<td class="columnCount">
								<span>{#$host.count}</span>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
</div>

{include file='footer'}