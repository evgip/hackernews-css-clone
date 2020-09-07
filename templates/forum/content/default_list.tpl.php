<?php
    if( $ctype['options']['list_show_filter'] ) {
        $this->renderAsset('ui/filter-panel', array(
            'css_prefix'   => $ctype['name'],
            'page_url'     => $page_url,
            'fields'       => $fields,
            'props_fields' => $props_fields,
            'props'        => $props,
            'filters'      => $filters,
            'ext_hidden_params' => $ext_hidden_params,
            'is_expanded'  => $ctype['options']['list_expand_filter']
        ));
    }
?>

<?php if ($items){ ?>
 
    <div class="content_list default_list <?php echo $ctype['name']; ?>_list">

        <?php foreach($items as $item){ ?>

              

            <?php $stop = 0; ?>
			
			<div class="content_list_item <?php echo $ctype['name']; ?>_list_item<?php if (!empty($item['is_vip'])){ ?> is_vip<?php } ?>">

            <div class="post_rating">
			      <div>▲</div>
               <?php html($item['rating']) ?>
            </div>
            <div class="post_telo">
                <div class="fields">

                <?php foreach($item['fields'] as $field){ ?>
 
                    <?php if ($stop === 2) { break; } ?>

                    <div class="field ft_<?php echo $field['type']; ?> f_<?php echo $field['name']; ?>">

                        <?php if ($field['label_pos'] != 'none'){ ?>
                            <div class="title_<?php echo $field['label_pos']; ?>">
                                <?php echo $field['title'] . ($field['label_pos']=='left' ? ': ' : ''); ?>
                            </div>
                        <?php } ?>

                        <?php if ($field['name'] == 'title' && $ctype['options']['item_on']){ ?>
                            <h2 class="value">
                            <?php if (!empty($this->menus['list_actions_menu'])){ ?>
                                <div class="list_actions_menu controller_actions_menu dropdown_menu">
                                    <input tabindex="-1" type="checkbox" id="menu_label_<?php echo $item['id']; ?>">
                                    <label for="menu_label_<?php echo $item['id']; ?>" class="group_menu_title"></label>
                                    <ul class="list_actions menu">
                                        <?php foreach($this->menus['list_actions_menu'] as $menu){ ?>
                                            <li>
                                                <a class="<?php echo isset($menu['options']['class']) ? $menu['options']['class'] : ''; ?>" href="<?php echo string_replace_keys_values($menu['url'], $item); ?>" title="<?php html($menu['title']); ?>">
                                                    <?php echo $menu['title']; ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <?php if ($item['parent_id']){ ?>
                                <a class="parent_title" href="<?php echo rel_to_href($item['parent_url']); ?>"><?php html($item['parent_title']); ?></a>
                                &rarr;
                            <?php } ?>

                            <?php if (!empty($item['is_private_item'])) { $stop++; ?>
                                <?php html($item[$field['name']]); ?> <span class="is_private" title="<?php html($item['private_item_hint']); ?>"></span>
                            <?php } else { ?>
                                <a class="title" href="<?php echo href_to($ctype['name'], $item['slug'].'.html'); ?>"><?php html($item[$field['name']]); ?></a>
                                <?php if ($item['is_private']) { ?>
                                    <span class="is_private" title="<?php echo LANG_PRIVACY_HINT; ?>"></span>
                                <?php } ?>
                            <?php } ?>
                            </h2>

						   <?php if($item['top'] == '1') { ?>
							 <div class="red noline">↑</div>
						   <?php } ?>

                            <?php if (!empty($item['category_id'])){ ?>
								<?php $category = cmsCore::getModel('content')->getCategory($ctype['name'], $item['category_id']); ?>
								<a class="cat cat-<?php html($category['id']) ?>" href="/forum/<?php html($category['slug']) ?>"><?php html($category['title']) ?></a>
                            <?php } ?>
 
							<?php if (!empty($item['show_tags'])){ ?>
								<div class="tags_bar">
									<?php echo html_tags_bar($item['tags'], 'content-'.$ctype['name']); ?>
								</div>
							<?php } ?>
 
                        <?php } else { ?>
                            <div class="value">
                                <?php if (!empty($item['is_private_item'])) { ?>
                                    <div class="private_field_hint"><?php echo $item['private_item_hint']; ?></div>
                                <?php } else { ?>
                                    <!-- ?php echo $field['html']; ?-->
                                <?php } ?>
                            </div>
                        <?php } ?>

                    </div>

                <?php } ?>

                </div>

 

 

 


	<?php if (!empty($item['info_bar'])){ ?>
		<div class="info_bar cent">
		
		
  			       <div class="icon-home-user">
				      <?php echo html_avatar_image($item['user']['avatar'], 'micro', $item['user']['nickname']); ?>
			       </div>
   
			       <a class="parent_user" href="/users/<?php html($item['user']['id']); ?>"><?php html($item['user']['nickname']); ?></a>

			       <?php print_r  (string_date_format($item['date_pub'] ))  ?>  <?php  echo date('H:i', strtotime($item['date_pub']));?>
		
	
		
			<?php foreach($item['info_bar'] as $bar){ ?>
			    <?php if ($bar['css'] == 'bi_comments'  ) { ?> 
				    
                      
                    <?php if ($bar['html'] == '0') { ?> 
					 
						| ответов нет
					<?php } else { ?> 	
						
						| ответов  <?php echo $bar['html']; ?> 
					 		
                    <?php } ?> 
                    
				<?php } ?> 
			<?php } ?>
			
			 <?php if (!empty($item['fields']['photo'])){ ?>
                 <div class="green noline">+ фото</div>
             <?php } ?>
			
		</div>
	<?php } ?>
         </div>
             </div>

        <?php } ?>
      
    </div>

    <?php if ($perpage < $total) { ?>
        <?php echo html_pagebar($page, $perpage, $total, $page_url, array_merge($filters, $ext_hidden_params)); ?>
    <?php } ?>

<?php } else {

    if(!empty($ctype['labels']['many'])){
        echo sprintf(LANG_TARGET_LIST_EMPTY, $ctype['labels']['many']);
    } else {
        echo LANG_LIST_EMPTY;
    }

}
