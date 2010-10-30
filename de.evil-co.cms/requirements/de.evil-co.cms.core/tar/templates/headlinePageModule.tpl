{if $optionList->getGroup('general')->getOption('size') == 1}
	<div class="mainHeadline">
		<img src="{$optionList->getGroup('general')->getOption('headlineIcon')}" alt="" />
		<div class="headlineContainer">
			<h1>{$optionList->getGroup('general')->getOption('content')}</h1>
			{if $optionList->getGroup('general')->getOption('subHeadline') != ''}<p>{$optionList->getGroup('general')->getOption('subHeadline')}</p>{/if}
		</div>
	</div>
{else}
	<h{$optionList->getGroup('general')->getOption('size')}>{$optionList->getGroup('general')->getOption('content')}</h{$optionList->getGroup('general')->getOption('size')}>
{/if}