<p{if $optionList->getGroup('general')->getOption('cssClass')->getValue() != ''} class="{$optionList->getGroup('general')->getOption('cssClass')->getValue()}"{/if}>{@$optionList->getGroup('general')->getOption('content')->getValue()}</p>