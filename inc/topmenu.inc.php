<?
//include_once("./language.inc.php");
function SetSideMenu($urlKey) {
	global $ADMIN_TRANS;
	global $SITE;
	global $LABEL;
	global $CHECK_PAGE;
	if ($CHECK_PAGE) {
		$PageCatUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
		if ($CHECK_PAGE[ProductID]) $PageCatUrlKey=GetCatUrlKeyFromCatID($CHECK_PAGE[parentID]);
		elseif ($CHECK_PAGE[productUrlKey]) $PageCatUrlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);

		$urlKey=$PageCatUrlKey;
	}
	$PAGE_ID=GetIDFromUrlKey($urlKey);
	$Pre_subID=$PAGE_ID[parentID];
	$AnchorName="";
	if ($SITE[isMiddleAnchor]) $AnchorName="#".$SITE[isMiddleAnchor];
	?>
	<ul id="sideMenuContainer" class="SideMenu">
	
	<?
		$toggle_HTMLSTRING="";

		$SUBMENU=GetParentMenu($urlKey);
		$SUB_SUB_MENU=GetSubMenu($urlKey);
		$selectedColor=$bgColor;
		
		for ($a=0;$a<count($SUBMENU[CatID]);$a++){
			if ($SUBMENU[ViewStatus][$a]==0 AND !isset($_SESSION['LOGGED_ADMIN'])) continue;
			$target="_self";
					
			//if ($SUBMENU[isSubCat][$a]==1) $indent='&nbsp;&nbsp;';
			$ExternalUrl="";
			if (!$SUBMENU[PageUrl][$a]) $SUBMENU[PageUrl][$a]=$SITE[media]."/category/".$SUBMENU[UrlKey][$a].$AnchorName;
			else {
				$SUBMENU[PageUrl][$a]=urldecode($SUBMENU[PageUrl][$a]).$AnchorName;
				$ExternalUrl=str_ireplace($AnchorName,"",$SUBMENU[PageUrl][$a]);
			}
			if (!stripos($ExternalUrl,"/")==0 AND $ExternalUrl!="") $target="_blank";
			$right_menu_class="rightMenuItem";
			$right_menu_selected_bg_class="";
			$indent='<font size="4pt" style="line-height:1em;font-family:arial">›› </font>';
			if ($SITE[submenuicon])  $indent='<img  src="'.SITE_MEDIA.'/gallery/sitepics/'.$SITE[submenuicon].'" border="0" align="absmiddle" alt="" /> ';
			if ($SUBMENU[UrlKey][$a]==$urlKey) {
				$right_menu_class="rightMenuItem_selected";
				if ($SITE[submenuselectedbgphoto]) $right_menu_selected_bg_class="sub_menu_selected_bg";
				if ($SITE[submenuselectedicon]) $indent='<img  src="'.SITE_MEDIA.'/gallery/sitepics/'.$SITE[submenuselectedicon].'" border="0" align="absmiddle" alt="" /> ';
			}
			?>
			
			<li id="cat_item-<?=$SUBMENU[CatID][$a];?>" class="">
			
			<?if (isset($_SESSION['LOGGED_ADMIN'])) {
				?><i class="fa fa-arrows-v move_vertical_cat"></i><?
			}
			if ($SITE[submenubgphoto] OR $SITE[submenuselectedbgphoto]) {
				print '<div class="top_bg_sidemenu '.$right_menu_selected_bg_class.'"></div>';
			}
			print '<div class="middle_bg_sidemenu '.$right_menu_selected_bg_class.'">';

			?>
			<div class="<?=$right_menu_class;?> iconPlaceHolder"><?=$indent;?>
			
			
			</div>
			<div class="<?=$right_menu_class;?>"  style="cursor:pointer;padding-top:3px;" id="s_menu">
			<?if (isset($_SESSION['LOGGED_ADMIN'])) {
				?>
				
				<input type="hidden" value="<?=$ExternalUrl;?>" id="url_<?=$SUBMENU[CatID][$a];?>" />
				<input type="hidden" value="<?=htmlspecialchars($SUBMENU[MenuTitle][$a]);?>" id="text_<?=$SUBMENU[CatID][$a];?>" />
				<label class="sideMenuEditTools">
					<a onclick="EditCat(event,<?=$SUBMENU[CatID][$a];?>,<?=$SUBMENU[ViewStatus][$a];?>,'<?=$SUBMENU[UrlKey][$a];?>',<?=($SITE[orderpage] == $SUBMENU[UrlKey][$a]) ? 1 : 0;?>);"><i class="fa fa-pencil-square-o edit"></i><?=$ADMIN_TRANS['edit menu'];?></a> | <a class="del" onclick="DelCat(<?=$SUBMENU[CatID][$a];?>);"><i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete'];?></a>
					<i class="fa fa-chevron-down arrow"></i>
				</label>
				<?
				//$toggle_HTMLSTRING='onmouseover="ToggleMoveIcon(1,'.$SUBMENU[CatID][$a].')" onmouseout="ToggleMoveIcon(0,'.$SUBMENU[CatID][$a].')"';
			}
			?>
			<a href="<?=$SUBMENU[PageUrl][$a];?>" id="menu_item-<?=$SUBMENU[CatID][$a];?>" target="<?=$target;?>"><?=$SUBMENU[MenuTitle][$a];?></a></div>
			</div>
			<?if ($SITE[submenubgphoto] OR $SITE[submenuselectedbgphoto]) print '<div class="bottom_bg_sidemenu '.$right_menu_selected_bg_class.'"></div>';?>
			
			<?
			if (is_array($SUB_SUB_MENU) AND ($urlKey==$SUBMENU[UrlKey][$a] OR $SUBMENU[UrlKey][$a]==$SUBMENU[ParentParentUrlKey])) {
				SetSubMenu($urlKey);
			}
			?>
			</li>
			<?
		} //End SubCat Loop

	?>
	</ul>
	<?if (isset($_SESSION['LOGGED_ADMIN'])) {
		?>
		<script type="text/javascript" language="javascript">
		jQuery(function() {
			jQuery("#sideMenuContainer").sortable({
		 		update: function(event, ui) {
		  			MakeTopDragable(jQuery("#sideMenuContainer").sortable('serialize'));
		   		}
		   		,handle: 'div',
		   		scroll:false,
		   		axis:'y'
			});
		});
		</script>
		<?
	}


}
function SetSubMenu($urlKey,$level=0) {
	global $SITE;
	global $ADMIN_TRANS;
	$SUB_SUB_MENU=GetSubMenu($urlKey,$level);
	$AnchorName="";
	if ($SITE[isMiddleAnchor]) $AnchorName="#".$SITE[isMiddleAnchor];
	print "<div style='padding-".$SITE[align].":0px' id='sideSubMenuContainer'>";
	for ($b=0;$b<count($SUB_SUB_MENU[CatID]);$b++) {
		if ($SUB_SUB_MENU[ViewStatus][$b]==0 AND !isset($_SESSION['LOGGED_ADMIN'])) continue;
		$ExternalUrl="";
		if (!$SUB_SUB_MENU[PageUrl][$b]) $SUB_SUB_MENU[PageUrl][$b]=$SITE[media]."/category/".$SUB_SUB_MENU[UrlKey][$b].$AnchorName;
			else {
				$SUB_SUB_MENU[PageUrl][$b]=urldecode($SUB_SUB_MENU[PageUrl][$b]).$AnchorName;
				$ExternalUrl=$SUB_SUB_MENU[PageUrl][$b];
			}
			$right_menu_class="rightMenuItem";
			if ($SITE[subsubmenucolor]) $right_menu_class.=" rightMenuSubSubItem";
			if ($SUB_SUB_MENU[UrlKey][$b]==$urlKey AND $level==0) {
				$right_menu_class="rightMenuItem_selected";
				if ($SITE[subsubmenuselectedcolor]) $right_menu_class.=" rightMenuSubSubItem_selected";
			}
				
			?>
			
			<div id="cat_item-<?=$SUB_SUB_MENU[CatID][$b];?>"  class="SubSubCategory">
			<?
			if (isset($_SESSION['LOGGED_ADMIN'])) {
				?>
				<input type="hidden" value="<?=$ExternalUrl;?>" id="url_<?=$SUB_SUB_MENU[CatID][$b];?>" />
				<input type="hidden" value="<?=htmlspecialchars($SUB_SUB_MENU[MenuTitle][$b]);?>" id="text_<?=$SUB_SUB_MENU[CatID][$b];?>" />
				<label class="sideMenuEditTools">
					<a onclick="EditCat(event,<?=$SUB_SUB_MENU[CatID][$b];?>,<?=$SUB_SUB_MENU[ViewStatus][$b];?>,'<?=$SUB_SUB_MENU[UrlKey][$b];?>',<?=($SITE[orderpage] == $SUB_SUB_MENU[UrlKey][$b]) ? 1 : 0;?>);"><i class="fa fa-pencil-square-o edit"></i><?=$ADMIN_TRANS['edit menu'];?></a> | <a class="del" onclick="DelCat(<?=$SUB_SUB_MENU[CatID][$b];?>);"><i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete'];?></a>
					<i class="fa fa-chevron-down arrow"></i>
				</label>
				
				<?

			}
			if ($SITE[subsubmenubgphoto]) {
				print '<div class="top_bg_sub_sidemenu" style="margin-top:3px;"></div>';
				
			}
			else print '<div style="margin:0px;padding:0px;clear:both"></div>';
			print '<div class="middle_bg_sub_sidemenu">';
			$sidePadding=10;
			if ($level==1) $sidePadding=20;
			
			?>
			<label class="<?=$right_menu_class;?>"  style="cursor:pointer;padding:2px;direction:rtl;" id="subsubMenu">
			<font size="4pt" style="font-family:arial;padding-<?=$SITE[opalign];?>:3px;margin-<?=$SITE[align];?>:<?=$sidePadding;?>px;">›</font><a href="<?=$SUB_SUB_MENU[PageUrl][$b];?>" id="menu_item-<?=$SUB_SUB_MENU[CatID][$b];?>"><?=$SUB_SUB_MENU[MenuTitle][$b];?></a></label>
			</div>
			
			<?if ($SITE[subsubmenubgphoto]) print '<div class="bottom_bg_sub_sidemenu"></div>';?>
			</div>
			<?
			
			
			if ($SUB_SUB_MENU[HaveChild][$b]==1) SetSubMenu($SUB_SUB_MENU[SubUrlKey][$b],1);
		}
			print "</div>";
			if (isset($_SESSION['LOGGED_ADMIN']) AND $level==0) {
				?>
				<script type="text/javascript" language="javascript">
				jQuery(function() {
					jQuery("#sideSubMenuContainer").sortable({
				 		update: function(event, ui) {
				  			MakeTopDragable(jQuery("#sideSubMenuContainer").sortable('serialize'));
				   		}
				   		,handle: 'label',
				   		scroll:false,
				   		axis:'y'
					});
				});
				</script>
				<?
			}
}
function SetTopMenuNew() {
	global $LOGGED;
	global $LABEL;
	global $SITE;
	global $urlKey;
	global $CHECK_PAGE;
	global $ADMIN_TRANS;
	$ADMIN_TRANS['edit menu']="Edit";
	if ($SITE['align']=='right') {
		$ADMIN_TRANS['edit menu']="ערוך ";
	}
	$menuBullet="|";
	$topmenuWidth=$SITE[width];
	if ($tid=="") $tid=1;
	$TOPCONTENTMENU=GetParentMenu(0);
	$ROOT_URL_KEY=GetRootUrlKey($urlKey);
	$top_UrlKey=$ROOT_URL_KEY[ParentUrlKey];
	if ($CHECK_PAGE) {
		$PageCatUrlKey=GetCatUrlKeyFromPageID($CHECK_PAGE[parentID]);
		if ($CHECK_PAGE[ProductID]) $PageCatUrlKey=GetCatUrlKeyFromCatID($CHECK_PAGE[parentID]);
		elseif ($CHECK_PAGE[productUrlKey]) $PageCatUrlKey=GetCatUrlKeyFromProductPage($CHECK_PAGE[productUrlKey]);

	}
	?>
		<div class="topMenuNew">
			<nav>
			<ul class="dropdown" id="topMenuContainer">
		<?
		if (ieversion()<8 AND ieversion()>0) $SITE[topmenuitembgpic]=$SITE[topmenuselecteditembgpic]="";
		if ($SITE[topmenuitembgpic]) {
				?>
				<style type="text/css">
				ul.dropdown li.hover,ul.dropdown li:hover{background-color:transparent;}
				ul.dropdown li{padding-top:10px;padding-bottom:0px;padding-<?=$SITE[align];?>:<?=$SITE[topmenusidemargin];?>px;padding-<?=$SITE[opalign];?>:0px;}
				ul.dropdown ul{<?=$SITE[align];?>:<?=$SITE[topmenusidemargin];?>px;}
				</style>
				<?
		}
		
		for ($a=0;$a<count($TOPCONTENTMENU[CatID]);$a++){
			$endstyle="";
			$ExternalUrl="";
			$topMenu_style="";
			$topMenuBG_style="";
			$target="_self";
			//$viewSeperator=1;
			//if ($TOPCONTENTMENU[ViewStatus][$a+1]==0 AND $a<=count($TOPCONTENTMENU[CatID]) AND !isset($_SESSION['LOGGED_ADMIN'])) $viewSeperator=0;
			if ($urlKey==$TOPCONTENTMENU[UrlKey][$a] OR $PageCatUrlKey==$TOPCONTENTMENU[UrlKey][$a] OR $top_UrlKey==$TOPCONTENTMENU[UrlKey][$a]) {
				$topMenu_style="topMenu_selected";
				if ($SITE[topmenuitembgpic]) $topMenu_style="topMenu_selectedWithBG";
				if ($SITE[topmenuselecteditembgpic]) $topMenuBG_style=" selectedTopMenu";
			}
			
			if ($TOPCONTENTMENU[ViewStatus][$a]==0 AND !isset($_SESSION['LOGGED_ADMIN'])) continue;
			if (!$TOPCONTENTMENU[PageUrl][$a]) {
				$TOPCONTENTMENU[PageUrl][$a]=$SITE[media]."/category/".$TOPCONTENTMENU[UrlKey][$a];
				if ($TOPCONTENTMENU[UrlKey][$a]=="home") $TOPCONTENTMENU[PageUrl][$a]=$SITE[media];
			}
			
			else {
				$TOPCONTENTMENU[PageUrl][$a]=urldecode($TOPCONTENTMENU[PageUrl][$a]);
				$ExternalUrl=$TOPCONTENTMENU[PageUrl][$a];
			}
			if (!stripos($ExternalUrl,"/")==0 AND $ExternalUrl!="") $target="_blank";
			$TOPCONTENTMENU_LINK=$TOPCONTENTMENU[PageUrl][$a];
			$TOPSUB=GetParentMenu($TOPCONTENTMENU[UrlKey][$a]);
			$sum_topsub=0;
			if (is_array($TOPSUB[ViewStatus])) $sum_topsub=array_sum($TOPSUB[ViewStatus]);
			$dd_class="";
			if (count($TOPSUB[CatID])<1 OR !$SITE[subtopmenuhover] OR $sum_topsub<1 AND !isset($_SESSION['LOGGED_ADMIN'])) $dd_class="nobg";
			if ($TOPCONTENTMENU[enableRichTextPopUp][$a]) {
				$dd_class="popUp";
			}
			?> 
			
			<li id="cat_item-<?=$TOPCONTENTMENU[CatID][$a];?>"  class="<?=$dd_class;?>" catItemID="<?=$TOPCONTENTMENU[CatID][$a];?>">
			
			<?
			if (isset($_SESSION['LOGGED_ADMIN']) AND $a<count($TOPCONTENTMENU[CatID])) {
				$endstyle="";
				?>
				<input type="hidden" value="<?=$ExternalUrl;?>" id="url_<?=$TOPCONTENTMENU[CatID][$a];?>" />
				<input type="hidden" value="<?=htmlspecialchars($TOPCONTENTMENU[MenuTitle][$a]);?>" id="text_<?=$TOPCONTENTMENU[CatID][$a];?>" />
				<label class="topMenuEditTools">
					<a onclick="EditCat(event,<?=$TOPCONTENTMENU[CatID][$a];?>,<?=$TOPCONTENTMENU[ViewStatus][$a];?>,'<?=$TOPCONTENTMENU[UrlKey][$a];?>',<?=($SITE[orderpage] == $TOPCONTENTMENU[UrlKey][$a]) ? 1 : 0;?>);"><i class="fa fa-pencil-square-o edit"></i><?=$ADMIN_TRANS['edit menu'];?></a> | <a class="del" onclick="DelCat(<?=$TOPCONTENTMENU[CatID][$a];?>);"><i class="fa fa-trash-o"></i> <?=$ADMIN_TRANS['delete'];?></a>
					<i class="fa fa-chevron-down arrow"></i>
				</label>
				<?
			}
			
			if ($SITE[topmenuitembgpic] OR $SITE[topmenuselecteditembgpic]) print '<div class="right_bg_topmenu'.$topMenuBG_style.'"></div>';
			?>
			<span class="<?=$topMenu_style;?>">
			<?if ($SITE[topmenuitembgpic] OR $SITE[topmenuselecteditembgpic]) print '<div class="middle_bg_topmenu'.$topMenuBG_style.'">';?>
			<a  id="menu_item-<?=$TOPCONTENTMENU[CatID][$a];?>" href="<?=$TOPCONTENTMENU_LINK;?>" target="<?=$target;?>"><?=$TOPCONTENTMENU[MenuTitle][$a];?><?=$endstyle;?></a>
			<?if ($SITE[topmenuitembgpic] OR $SITE[topmenuselecteditembgpic]) print '</div><div class="left_bg_topmenu'.$topMenuBG_style.'"></div>';?>
			</span>
			
			
			<?
			$viewableItems=$real_counter=0;
			if ($SITE[subtopmenuhover]) {
				if ($TOPCONTENTMENU[enableRichTextPopUp][$a]) {
					

				}
				else {
					print '<ul>';
					for ($c=0;$c<count($TOPSUB[CatID]);$c++) {
						$subExternal="";
						$target_sub="_self";
						$real_counter++;
						if ($TOPSUB[ViewStatus][$c]==0 AND !isset($_SESSION['LOGGED_ADMIN'])) continue;
						$topSubMenu_style=$topSubMenuBottomBorder="";
						if ($c==count($TOPSUB[CatID])-1) $topSubMenuBottomBorder='style="border-bottom:0px;border-radius:0px 0px 8px 8px / 0px 0px 8px 8px;"';
						if ($urlKey==$TOPSUB[UrlKey][$c]) $topSubMenu_style="topSubMenu_selected";
						if (!$TOPSUB[PageUrl][$c]) $TOPSUB[PageUrl][$c]=$SITE[media]."/category/".$TOPSUB[UrlKey][$c];
							else {
								$TOPSUB[PageUrl][$c]=urldecode($TOPSUB[PageUrl][$c]);
								$subExternal=$TOPSUB[PageUrl][$c];
							}
							
						$TOPSUBMENU_LINK=$TOPSUB[PageUrl][$c];
						if (!stripos($subExternal,"/")==0 AND $subExternal!="") $target_sub="_blank";
						?>
						<li <?=$topSubMenuBottomBorder;?>>
						<span class="<?=$topSubMenu_style;?>">
						<a href="<?=$TOPSUBMENU_LINK;?>" target="<?=$target_sub;?>"><?=$TOPSUB[MenuTitle][$c];?></a>
						</span>
						</li>
						<?
					}
					print '</ul>';
				}
			}
				
				print '</li>';
				$menuBulletImage='<img src="'.SITE_MEDIA.'/gallery/sitepics/'.$SITE[topmenuseperatoricon].'"  border=0 valign=top />';
				if ($a<count($TOPCONTENTMENU[CatID])-1 AND !$SITE[topmenuitembgpic] AND $SITE[topmenuseperatoricon]=="") print "<li class='seperator'>".$menuBullet."</li>";
				if ($a<count($TOPCONTENTMENU[CatID])-1 AND !$SITE[topmenuseperatoricon]=="") print "<li class='seperator_icon'>".$menuBulletImage."</li>";
				
		}
		
		?>
		</ul>
		</nav>
			<div class="richTextPopup"> </div>
		</div>

		<?
		if (isset($_SESSION['LOGGED_ADMIN'])) {
			?>
			<script type="text/javascript" language="javascript">
			jQuery(function() {
					jQuery("#topMenuContainer").sortable({
			   		update: function(event, ui) {
			   			MakeTopDragable(jQuery("#topMenuContainer").sortable('serialize'));
			   		}
			   		,handle: 'span',
			   		scroll:true,
			   		axis:'x,y',
			   		dropOnEmpty: false
				});
					
				//jQuery("#boxes").disableSelection();
				});
			var editorInlneIsinitieted=false;
			</script>
			<?
		}
		?>
		<script type="text/javascript" language="javascript">
		var topMenuWidthGlobal=jQuery(".topMenuNew").width();
		var cumulativeTopMenuWidth=0;
		jQuery(".richTextPopup").width(topMenuWidthGlobal+"px");
			jQuery("ul.dropdown li:not(.popUp)").on("mouseover",function(){jQuery(".richTextPopup.show").removeClass("show")});
			jQuery("ul.dropdown li.popUp").each(function() {
				jQuery(this).hover(function() {
					jQuery(this).addClass("on");
					toggleTopRichTextPopup(jQuery(this).attr("catItemID"));
					jQuery("div.richTextPopup.show :not(.editing_one)").mouseleave(function(){jQuery(this).removeClass("show")});
				});
				if (GlobalWinWidth<1024) {
					jQuery(this).on("tap",function(event){jQuery(".richTextPopup").toggleClass("show");jQuery(this).hover();event.preventDefault()});
					jQuery(this).click(function(event){jQuery(this).hover();event.preventDefault()});
				}

			});

			function toggleTopRichTextPopup(iID) {

					jQuery("div.richTextPopup").addClass('show',function() {
						jQuery(".richTextPopup").load("/GetRichTextPopup.php?cID="+iID);
						if (jQuery(".richTextPopup.show").length>0) {
							jQuery("ul.dropdown li#cat_item-"+iID).addClass("on");
							<?if (!isset($_SESSION['LOGGED_ADMIN'])) {
								?>
								jQuery(".richTextPopup.show :not(#popUpRichTextContent)").on("mouseout",function(){jQuery(this).removeClass("show");});
								<?
							}
							?>
						}
				});
			}
			jQuery("#topMenuContainer>li").not(".seperator_icon").each(function(){cumulativeTopMenuWidth+=jQuery(this).outerWidth();});
			if (cumulativeTopMenuWidth>jQuery("ul.dropdown#topMenuContainer").width()) {
					var topMenuFontSize="<?=$SITE[menutextsize];?>";
					var topMenuSideMargin="<?=$SITE[topmenusidemargin];?>";
					while (cumulativeTopMenuWidth>jQuery(".topMenuNew").width()) {
						cumulativeTopMenuWidth=0;
						jQuery("#topMenuContainer>li").not(".seperator_icon").each(function(){cumulativeTopMenuWidth+=jQuery(this).outerWidth();});
						console.log(jQuery("ul.dropdown#topMenuContainer").width());
						//topMenuFontSize=topMenuFontSize-1;
						topMenuSideMargin=topMenuSideMargin-1;
						//jQuery(".topMenuNew ul.dropdown li").css("font-size",topMenuFontSize+"px");
						jQuery("ul.dropdown li").not(".seperator_icon").css({"padding-right":topMenuSideMargin+"px","padding-left":topMenuSideMargin+"px"});
						//if (cumulativeTopMenuWidth<=jQuery(".topMenuNew").width() || topMenuFontSize<=10) break;
						if (cumulativeTopMenuWidth<=jQuery(".topMenuNew").width() || topMenuSideMargin<=1) break;
						
					}

			}
			</script>
		<?


}