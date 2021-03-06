<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Feed
 * @version 		$Id: display.html.php 6569 2013-09-03 06:48:49Z Miguel_Espinoza $
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{if !$bIsHashTagPop && !PHPFOX_IS_AJAX && !empty($sIsHashTagSearch)}
	<h1>#{$sIsHashTagSearchValue|clean}</h1>
{/if}
{plugin call='feed.component_block_display_process_header'}
{if isset($sActivityFeedHeader)}
	{if !PHPFOX_IS_AJAX}
		<div class="mb_feed_header">
			{$sActivityFeedHeader}
		</div>
	{/if}
{/if}
{if isset($bForceFormOnly) && $bForceFormOnly}
	{template file='feed.block.form'}
{else}
	{if Phpfox::getService('profile')->timeline()}
		<div class="main_timeline {if isset($aUser.page_user_id)}content4 content_float{/if}" style="background:url('{img theme='layout/timeline.png' return_url=true}') repeat-y 50%;">
	{/if}

	{if Phpfox::isUser() && !PHPFOX_IS_AJAX && $sCustomViewType === null}
		{if (Phpfox::getUserBy('profile_page_id') > 0 && defined('PHPFOX_IS_USER_PROFILE')) 
			|| (isset($aFeedCallback.disable_share) && $aFeedCallback.disable_share) 
			|| (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'feed.share_on_wall'))
			|| (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getUserParam('profile.can_post_comment_on_profile') && $aUser.user_id != Phpfox::getUserId())
		}

		{else}
		
                <?php
                    /*
                    {if !Phpfox::getService('profile')->timeline()}
				<div id="js_main_feed_holder">
					{template file='feed.block.form'}
				</div>
                    {/if} 
                    */
                ?>
                
                    {if !defined('PHPFOX_IS_USER_PROFILE') }

                    <div class="activity_feed_form_button" style="display:block;">
                        <div class="activity_feed_form_button_position">

                             <div class="activity_feed_form_button_position_button submit_button_form_ex">
    <!--                             <span class="ex_button_arrow"></span>-->
                                 <a id="activity_feed_popup_ex" href="#" class="button dont-unbind" onclick="tb_show('Ex life', $.ajaxBox('feed.popup', 'height=300&width=550')); return false;" title="{phrase var='feed.submit_ex_tooltip'}"></a>
                             </div>	
                           <div id="img_bar" class="activity_feed_image">
                               <div id="img_bar_position">{$sUserProfileImage}</div>
		
	                    </div>
                            
                             <div class="activity_feed_form_button_position_button submit_button_form_next">
                                 <a id="activity_feed_popup_next" href="#" class="button dont-unbind" onclick="tb_show('Next life', $.ajaxBox('feed.popup', 'height=300&width=550')); return false;" title="{phrase var='feed.submit_next_tooltip'}"></a>
    <!--                             <span class="next_button_arrow"></span>-->
                             </div>

                             <div class="clear"></div>
                         </div>
                    </div>
                    
                    {else}
                    <div id="holder_green"> 
                        
                        <div id="my-book-wrapper">
                       <!--     <div id="my-book-left">
                                <div id="my-book-basic">
                                    {if isset($aUser.is_online) && $aUser.is_online || $aUser.is_friend === 2 || $aUser.is_friend === 3}
                                            <span class="profile_online_status">
                                                    {if !$aUser.is_friend && $aUser.is_friend_request === 2}
                                                            <span class="js_profile_online_friend_request">{phrase var='profile.pending_friend_confirmation'}{if $aUser.is_online} {/if}</span>
                                                    {elseif !$aUser.is_friend && $aUser.is_friend_request === 3}
                                                            <span class="js_profile_online_friend_request">{phrase var='profile.pending_friend_request'}{if $aUser.is_online} {/if}</span>
                                                    {/if}
                                                    {if $aUser.is_online}
                                                            ({phrase var='profile.online'}) IS ONLINE
                                                    {/if}
                                            </span>
                                    {/if}
                                    <div class="my-book-block">
                                        <h3>{$aUser.full_name|clean|split:30|shorten:50:'...'}</h3> Nombre
                                        <p style="overflow: auto; height: 90%;">
                                        <b></b> <br>
                                        {if Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'profile.view_location') && (!empty($aUser.city_location) || !empty($aUser.country_child_id) || !empty($aUser.location))}
                                        {phrase var='profile.lives_in'} {if !empty($aUser.city_location)}{$aUser.city_location}{/if}
                                                {if !empty($aUser.city_location) && (!empty($aUser.country_child_id) || !empty($aUser.location))},{/if}
                                                {if !empty($aUser.country_child_id)} {$aUser.country_child_id|location_child}{/if} {if !empty($aUser.location)}{$aUser.location}{/if} <br>
                                        {/if}
                                        {if isset($aUser.birthdate_display) && is_array($aUser.birthdate_display) && count($aUser.birthdate_display)}
                                                {foreach from=$aUser.birthdate_display key=sAgeType item=sBirthDisplay}
                                                        {if $aUser.dob_setting == '2'}
                                                                {phrase var='profile.age_years_old' age=$sBirthDisplay}
                                                        {else}
                                                                {phrase var='profile.born_on_birthday' birthday=$sBirthDisplay} <br>
                                                        {/if}
                                                {/foreach}
                                        {/if}
                                        {if Phpfox::getParam('user.enable_relationship_status') && isset($sRelationship) && $sRelationship != ''}{$sRelationship} <br> {/if}
                                        {php}Phpfox::getBlock('userinfo.profileinfo', array('aUser' => $this->getVar('aUser')));{/php}
                                        {if isset($aUser.category_name)}{$aUser.category_name|convert}{/if}
                                        </p>
                                    </div>
                                </div>
                                <img src="static/image/my-book-left-top.png" />
                            </div>
                            <div id="my-book-right">
                                <div id="my-book-right-link">
                                    {if Phpfox::getUserId() == $aUser.user_id}
                                        <a href="{url link='user.profile'}">{phrase var='profile.edit_profile'}</a>
                                    {elseif Phpfox::isModule('mail') && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'mail.send_message')}
                                        <a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aUser.user_id}{right_curly}); return false;">{phrase var='profile.send_message'}</a>
                                    {/if}
                                </div>
                                <div id="my-book-bookmark" onclick="$('#my-book-more-tooltip').fadeToggle();" {if Phpfox::getUserId() == $aUser.user_id}style="display: none;"{/if}></div>
                                <div id="my-book-more-tooltip">
                                
                                {if Phpfox::getUserBy('profile_page_id') <= 0}
                                    <ul>
                                            {if Phpfox::isModule('mail') && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'mail.send_message')}
                                                    <li><a href="#" onclick="$Core.composeMessage({left_curly}user_id: {$aUser.user_id}{right_curly}); return false;">{phrase var='profile.send_message'}</a></li>
                                            {/if}
                                            {if Phpfox::isUser() && Phpfox::isModule('friend') && Phpfox::getUserParam('friend.can_add_friends') && !$aUser.is_friend && $aUser.is_friend_request !== 2}
                                                    <li id="js_add_friend_on_profile"{if !$aUser.is_friend && $aUser.is_friend_request === 3} class="js_profile_online_friend_request"{/if}>
                                                            <a href="#" onclick="return $Core.addAsFriend('{$aUser.user_id}');" title="{phrase var='profile.add_to_friends'}">
                                                                    {if !$aUser.is_friend && $aUser.is_friend_request === 3}{phrase var='profile.confirm_friend_request'}{else}{phrase var='profile.add_to_friends'}{/if}
                                                            </a>
                                                    </li>
                                            {/if}
                                            {if $bCanPoke && Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'poke.can_send_poke')}
                                                    <li id="liPoke">
                                                            <a href="#" id="section_poke" onclick="$Core.box('poke.poke', 400, 'user_id={$aUser.user_id}'); return false;">{phrase var='poke.poke' full_name=''}</a>
                                                    </li>
                                            {/if}
                                            {plugin call='profile.template_block_menu_more'}
                                            {if (Phpfox::getUserParam('user.can_block_other_members') && isset($aUser.user_group_id) && Phpfox::getUserGroupParam('' . $aUser.user_group_id . '', 'user.can_be_blocked_by_others'))
                                                    || (isset($aUser.is_online) && $aUser.is_online && Phpfox::isModule('im') && Phpfox::getParam('im.enable_im_in_footer_bar') && $aUser.is_friend == 1)
                                                    || (Phpfox::getUserParam('user.can_feature'))
                                                    || (isset($bPassMenuMore))
                                                    || (Phpfox::getUserParam('core.can_gift_points'))
                                            }
                                            <li><a href="#" id="section_menu_more" class="js_hover_title"><span class="section_menu_more_image"></span><span class="js_hover_info">{phrase var='profile.more'}</span></a></li>
                                            {/if}
                                            {if Phpfox::getUserParam('user.can_block_other_members') && isset($aUser.user_group_id) && Phpfox::getUserGroupParam('' . $aUser.user_group_id . '', 'user.can_be_blocked_by_others')}
                                                    <li><a href="#?call=user.block&amp;height=120&amp;width=400&amp;user_id={$aUser.user_id}" class="inlinePopup js_block_this_user" title="{if $bIsBlocked}{phrase var='profile.unblock_this_user'}{else}{phrase var='profile.block_this_user'}{/if}">{if $bIsBlocked}{phrase var='profile.unblock_this_user'}{else}{phrase var='profile.block_this_user'}{/if}</a></li>
                                            {/if}
                                            {if isset($aUser.is_online) && $aUser.is_online && Phpfox::isModule('im') && Phpfox::getParam('im.enable_im_in_footer_bar') && $aUser.is_friend == 1}
                                                    <li><a href="#" onclick="$.ajaxCall('im.chat', 'user_id={$aUser.user_id}'); return false;">{phrase var='profile.instant_chat'}</a></li>
                                            {/if}
                                            {if Phpfox::getUserParam('user.can_feature')}
                                                    <li {if isset($aUser.is_featured) && !$aUser.is_featured} style="display:none;" {/if} class="user_unfeature_member">
                                                            <a href="#" title="{phrase var='profile.un_feature_this_member'}" onclick="$(this).parent().hide(); $(this).parents('#section_menu_drop').find('.user_feature_member:first').show(); $.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=0&amp;type=1'); return false;">{phrase var='profile.unfeature'}</a></li>
                                                    <li {if isset($aUser.is_featured) && $aUser.is_featured} style="display:none;" {/if} class="user_feature_member">
                                                            <a href="#" title="{phrase var='profile.feature_this_member'}" onclick="$(this).parent().hide(); $(this).parents('#section_menu_drop').find('.user_unfeature_member:first').show(); $.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=1&amp;type=1'); return false;">{phrase var='profile.feature'}</a></li>
                                            {/if}
                                            {if Phpfox::getUserParam('core.can_gift_points')}
                                                    <li>
                                                            <a href="#?call=core.showGiftPoints&amp;height=120&amp;width=400&amp;user_id={$aUser.user_id}" class="inlinePopup js_gift_points" title="{phrase var='core.gift_points'}">
                                                                    {phrase var='core.gift_points'}
                                                            </a>
                                                    </li>
                                            {/if}
                                            {if Phpfox::isModule('friend') && Phpfox::getUserParam('friend.link_to_remove_friend_on_profile') && isset($aUser.is_friend) && $aUser.is_friend === true}
                                                    <li>
                                                            <a href="#" onclick="if (confirm('{phrase var='core.are_you_sure'}'))$.ajaxCall('friend.delete', 'friend_user_id={$aUser.user_id}&reload=1'); return false;">
                                                                    {phrase var='friend.remove_friend'}
                                                            </a>
                                                    </li>
                                            {/if}
                                            {plugin call='profile.template_block_menu'}
                                    </ul>
				{/if}
                                    
                                </div>
                                <div id="my-book-about">
                                    <div class="my-book-block">
                                        <h3>{phrase var='user.custom_about_me'}</h3> 
                                        <p style="overflow: auto; height: 90%;">{$aAboutMe}</p>
                                    </div>
                                </div>
                                <img src="static/image/my-book-right-top.png" />
                            </div>
                            -->
                             
               
                                 
                            
                            
                        </div>
                    </div>
                    {/if}
                
		{/if}
	{/if}
        
       
        
        

	{if Phpfox::isUser() && !defined('PHPFOX_IS_USER_PROFILE') && !PHPFOX_IS_AJAX && !defined('PHPFOX_IS_PAGES_VIEW')}
		<div class="feed_sort_order">
                    
                    <a href="#" class="feed_sort_order_link">{phrase var='feed.sort'}</a>
			<div class="feed_sort_holder">
				<ul>
					<li><a href="#"{if !$iFeedUserSortOrder} class="active"{/if} rel="0">{phrase var='feed.top_stories'}</a></li>
					<li><a href="#"{if $iFeedUserSortOrder} class="active"{/if} rel="1">{phrase var='feed.most_recent'}</a></li>
				</ul>
			</div>
		</div>
	{/if}
	{if Phpfox::getParam('feed.refresh_activity_feed') > 0 && Phpfox::getLib('module')->getFullControllerName() == 'core.index-member'}
		<div id="activity_feed_updates_link_holder">
			<a href="#" id="activity_feed_updates_link_single" class="activity_feed_updates_link" onclick="return $Core.loadMoreFeeds();">{phrase var='feed.1_new_update'}</a>
			<a href="#" id="activity_feed_updates_link_plural" class="activity_feed_updates_link" onclick="return $Core.loadMoreFeeds();">{phrase var='feed.span_id_js_new_update_view_span_new_updates'}</a>
		</div>
	{/if}
	{if Phpfox::isModule('captcha') && Phpfox::getUserParam('captcha.captcha_on_comment')}
		{module name='captcha.form' sType='comment' captcha_popup=true}
	{/if}
<div id="feed"><a name="feed"></a></div>
<div>
<div {if !$bIsHashTagPop}id="js_feed_content"{/if} class="js_feed_content">
	{if $sCustomViewType !== null}
		<h2>{$sCustomViewType}</h2>
	{/if}
	<div id="js_new_feed_update"></div>
	<div id="js_new_feed_comment"></div>
	
	{if Phpfox::getService('profile')->timeline()}
		{if isset($bNoLoadFeedContent)}
		{else}
			<div>
				{if PHPFOX_IS_AJAX && !empty($sLastDayInfo) && !Phpfox::getLib('request')->get('resettimeline')}
					<div class="timeline_date">
						<span>{$sLastDayInfo}</span>
					</div>
				{/if}
				<div class="timeline_left">			
					{if (!PHPFOX_IS_AJAX && Phpfox::getService('profile')->timeline()) || Phpfox::getLib('request')->get('resettimeline')}
						{if (Phpfox::isUser() && !PHPFOX_IS_AJAX && $sCustomViewType === null) || Phpfox::getLib('request')->get('resettimeline')}
							{if (Phpfox::getUserBy('profile_page_id') > 0 && defined('PHPFOX_IS_USER_PROFILE')) 
								|| (isset($aFeedCallback.disable_share) && $aFeedCallback.disable_share) 
								|| (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getService('user.privacy')->hasAccess('' . $aUser.user_id . '', 'feed.share_on_wall'))
								|| (defined('PHPFOX_IS_USER_PROFILE') && !Phpfox::getUserParam('profile.can_post_comment_on_profile') && $aUser.user_id != Phpfox::getUserId())
							}

							{else}	
								<div class="timeline_feed_row">
									<div class="timeline_arrow_left">0</div>
									<div class="timeline_float_left">0</div>			
									<div class="timeline_holder">
										{template file='feed.block.form'}
									</div>
								</div>
								<div class="timeline_left_new"></div>
							{/if}
						{/if}
					{/if}
					{foreach from=$aFeedTimeline.left name=iFeed item=aFeed}
						<div class="timeline_feed_row">
							<div class="timeline_arrow_left">{$aFeed.feed_id}</div>
							<div class="timeline_float_left">{$aFeed.time_stamp|convert_time}</div>
							{template file='feed.block.timeline'}
						</div>		
					{/foreach}
				</div>
				<div class="timeline_right">
					{if !PHPFOX_IS_AJAX || Phpfox::getLib('request')->get('resettimeline')}
						<div class="timeline_feed_row">				
							{module name='friend.timeline'}
						</div>
					{/if}
					{foreach from=$aFeedTimeline.right name=iFeed item=aFeed}
						<div class="timeline_feed_row">
							<div class="timeline_arrow_right">{$aFeed.feed_id}</div>
							<div class="timeline_float_right">{$aFeed.time_stamp|convert_time}</div>
							{template file='feed.block.timeline'}
						</div>
					{/foreach}
				</div>		
				<div class="clear"></div>
			</div>	
	
			{if !PHPFOX_IS_AJAX}
				{foreach from=$aTimelineDates item=aTimelineDate}
					<div id="js_timeline_year_holder_{$aTimelineDate.year}"></div>
					{foreach from=$aTimelineDate.months item=aMonth}
						<div id="js_timeline_month_holder_{$aTimelineDate.year}_{$aMonth.id}"></div>
					{/foreach}
				{/foreach}
			{/if}
		
		{/if}	
			
	{else}	
	
		{if isset($bNoLoadFeedContent)}
		{else}
			{foreach from=$aFeeds name=iFeed item=aFeed}
				{if isset($aFeed.feed_mini) && !isset($bHasRecentShow)}
					{if $bHasRecentShow = true}{/if}
					<div class="activity_recent_holder">
						<div class="activity_recent_title">
							{phrase var='feed.recent_activity'}
						</div>
				{/if}
				{if !isset($aFeed.feed_mini) && isset($bHasRecentShow)}
					</div>
					{unset var=$bHasRecentShow}
				{/if}
		
				<div class="js_feed_view_more_entry_holder post_type_{$aFeed.type_ex_next}">
					{template file='feed.block.entry'}
					{if isset($aFeed.more_feed_rows) && is_array($aFeed.more_feed_rows) && count($aFeed.more_feed_rows)}
						{foreach from=$aFeed.more_feed_rows item=aFeed}
							{if $bChildFeed = true}{/if}
							<div class="js_feed_view_more_entry" style="display:none;">
								{template file='feed.block.entry'}
							</div>
						{/foreach}
						{unset var=$bChildFeed}
					{/if}
				</div>
                                
			{/foreach}
		{/if}
	{/if}
	
	{if isset($bHasRecentShow)}
		</div>
	{/if}	
	{if $sCustomViewType === null}
		{if defined('PHPFOX_IN_DESIGN_MODE')}		
		{else}
			{if count($aFeeds) || (isset($bForceReloadOnPage) && $bForceReloadOnPage)}
				<div id="feed_view_more">
					{if $bIsHashTagPop}
					{if count($aFeeds) > 8}
					<a href="{url link='hashtag'}{{$sIsHashTagSearch}/page_1/" class="global_view_more no_ajax_link" style="display:block;">{phrase var='feed.view_more'}</a>
					{/if}
					{else}
					<div id="js_feed_pass_info" style="display:none;">page={$iFeedNextPage}{if defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id)}&profile_user_id={$aUser.user_id}{/if}{if isset($aFeedCallback.module)}&callback_module_id={$aFeedCallback.module}&callback_item_id={$aFeedCallback.item_id}{/if}&year={$sTimelineYear}&month={$sTimelineMonth}{if !empty($sIsHashTagSearch)}&hashtagsearch={$sIsHashTagSearch}{/if}</div>
					<div id="feed_view_more_loader">{img theme='ajax/add.gif'}</div>
					<a {if !PHPFOX_IS_AJAX && isset($bForceReloadOnPage) && $bForceReloadOnPage} style="text-indent:-1000px; overflow:hidden; background:transparent; border:0px;"{/if} href="{if Phpfox::getLib('module')->getFullControllerName() == 'core.index-visitor'}{url link='core.index-visitor' page=$iFeedNextPage}{else}{url link='current' page=$iFeedNextPage}{/if}" onclick="$(this).hide(); $('#feed_view_more_loader').show(); $.ajaxCall('feed.viewMore', 'page={$iFeedNextPage}{if defined('PHPFOX_IS_USER_PROFILE') && isset($aUser.user_id)}&profile_user_id={$aUser.user_id}{/if}{if isset($aFeedCallback.module)}&callback_module_id={$aFeedCallback.module}&callback_item_id={$aFeedCallback.item_id}{/if}&year={$sTimelineYear}&month={$sTimelineMonth}', 'GET'); return false;" class="global_view_more no_ajax_link">{phrase var='feed.view_more'}</a>
					{/if}
				</div>				
			{else}
				{if defined('PHPFOX_IS_USER_PROFILE') && Phpfox::getService('profile')->timeline()}
					{module name='user.birth'}
				{else}
					<br />
					<div class="message js_no_feed_to_show">{phrase var='feed.there_are_no_new_feeds_to_view_at_this_time'}</div>
				{/if}
			{/if}
		{/if}
	{/if}
	{if !PHPFOX_IS_AJAX || (PHPFOX_IS_AJAX && count($aFeedVals))}
		</div>
	{/if}
	{if Phpfox::getParam('feed.refresh_activity_feed') > 0 && Phpfox::getLib('module')->getFullControllerName() == 'core.index-member'}
		<script type="text/javascript">
			$Behavior.reloadActivity = function() {l} $Core.reloadActivityFeed();	{r};
		</script>
	{/if} 

	{if Phpfox::getService('profile')->timeline()}
		</div>
		{if isset($aUser.page_user_id)}
			<div id="right">
                            <div id="eventCalendarHumanDate"></div>
                            {module name='feed.time'}
                            {foreach from=$aLoadBlocks item=sBlock}
                                    {module name=$sBlock}
                            {/foreach}
			</div>
		{/if}
	{/if}
{/if}
</div>