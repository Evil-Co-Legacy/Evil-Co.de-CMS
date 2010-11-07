{if $usersOnlineTotal|isset}
	<div class="border infoBox usersOnlineListPageModule">
		<div class="container-1">
			<div class="containerIcon"> <img src="{icon}membersM.png{/icon}" alt="" /></div>
			<div class="containerContent">
				<h3>{if $this->user->getPermission('user.usersOnline.canView')}<a href="index.php?page=UsersOnline{@SID_ARG_2ND}">{lang}wcf.cms.module.usersOnlineList.page.title{/lang}</a>{else}{lang}wcf.cms.module.usersOnlineList.page.title{/lang}{/if}</h3> 
				<p class="smallFont">{lang}wcf.cms.module.usersOnlineList.page.detail{/lang}</p>
				{if $usersOnline|count}
					<p class="smallFont">
						{implode from=$usersOnline item=userOnline}<a href="index.php?page=User&amp;userID={@$userOnline.userID}{@SID_ARG_2ND}">{@$userOnline.username}</a>{/implode}
					</p>
					{if $usersOnlineMarkings|count}
						<p class="smallFont">
							{lang}wcf.usersOnline.marking.legend{/lang} {implode from=$usersOnlineMarkings item=usersOnlineMarking}{@$usersOnlineMarking}{/implode}
						</p>
					{/if}
				{/if}
			</div>
		</div>
	</div>
{/if}