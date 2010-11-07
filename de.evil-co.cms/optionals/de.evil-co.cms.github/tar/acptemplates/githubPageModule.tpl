<div class="formElement">
	<p class="formFieldLabel">{lang}wcf.cms.module.github.username{/lang}</p>
	<p class="formField">{$optionList->getOptions()->getGroup('general')->getOption('username')->getValue()}</p>
</div>
<div class="formElement">
	<p class="formFieldLabel">{lang}wcf.cms.module.github.repository{/lang}</p>
	<p class="formField">{$optionList->getOptions()->getGroup('general')->getOption('repository')->getValue()}</p>
</div>
<div class="formElement">
	<p class="formFieldLabel">{lang}wcf.cms.module.github.branch{/lang}</p>
	<p class="formField">{$optionList->getOptions()->getGroup('general')->getOption('branch')->getValue()}</p>
</div>