<div id="githubPageModule{$module->instanceID}">
	<noscript>
		<p class="info">{lang}wcf.cms.module.github.page.noJS{/lang}</p>
	</noscript>
</div>
<script type="text/javascript">
	onloadEvents.push(function() {
		githubPageModule.init('githubPageModule{$module->instanceID}', {$module->instanceID});
	});
</script>