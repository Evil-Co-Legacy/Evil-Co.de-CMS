{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/statsL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}cms.acp.statistics.title{/lang}</h2>
	</div>
</div>

<div id="hostStatistics">
	<h3 class="subHeadline">{lang}cms.acp.statistics.host.title{/lang}</h3>
	
	{include file='openFlashChart'}
</div>

<div id="pageStatistics">
	<h3 class="subHeadline">{lang}cms.acp.statistics.page.title{/lang}</h3>
	
	{include file='openFlashChart' openFlashChartSource="index.php?page=PageStatisticsChartSource&packageID="|concat:PACKAGE_ID:SID_ARG_2ND}
</div>

{include file='footer'}