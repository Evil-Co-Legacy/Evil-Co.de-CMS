{if $optionList->getOptionValue('general', 'size') == 1}
	<div class="mainHeadline">
		<img src="{$optionList->getOptionValue('general', 'headlineIcon')}" alt="" />
		<div class="headlineContainer">
			<h1>{$optionList->getOptionValue('general', 'content')}</h1>
			{if $optionList->getOptionValue('general', 'subHeadline') != ''}<p>{$optionList->getOptionValue('general', 'subHeadline')}</p>{/if}
		</div>
	</div>
{else}
	<h{$optionList->getOptionValue('general', 'size')}>{$optionList->getOptionValue('general', 'content')}</h{$optionList->getOptionValue('general', 'size')}>
{/if}