{if $optionList->getOptionValue('general', 'size') == 2}
	<div class="mainHeadline">
		<img src="{icon}{$optionList->getOptionValue('general', 'headlineIcon')}{/icon}" alt="" />
		<div class="headlineContainer">
			<h2>{$optionList->getOptionValue('general', 'content')}</h2>
			{if $optionList->getOptionValue('general', 'subHeadline') != ''}<p>{$optionList->getOptionValue('general', 'subHeadline')}</p>{/if}
		</div>
	</div>
{else}
	<h{$optionList->getOptionValue('general', 'size')}>{$optionList->getOptionValue('general', 'content')}</h{$optionList->getOptionValue('general', 'size')}>
{/if}