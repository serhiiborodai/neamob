<?php
/**
 * Native WordPress gallery meta box (no ACF PRO needed).
 * Uses wp.media frame for selecting/reordering images.
 */

function neamob_gallery_metaboxes() {
    global $post;
    if (!$post) return;

    $about_page = get_page_by_path('about-us');
    if ($about_page && $post->ID === $about_page->ID) {
        add_meta_box(
            'neamob_about_gallery',
            'Team Gallery Images',
            'neamob_render_gallery_metabox',
            'page',
            'normal',
            'high',
            ['meta_key' => '_neamob_about_gallery']
        );
    }

    $portfolio_page = get_page_by_path('portfolio');
    if ($portfolio_page && $post->ID === $portfolio_page->ID) {
        add_meta_box(
            'neamob_portfolio_static',
            'Portfolio — Static',
            'neamob_render_gallery_metabox',
            'page',
            'normal',
            'high',
            ['meta_key' => '_neamob_portfolio_static']
        );
        add_meta_box(
            'neamob_portfolio_video',
            'Portfolio — Video',
            'neamob_render_gallery_metabox',
            'page',
            'normal',
            'high',
            ['meta_key' => '_neamob_portfolio_video']
        );
        add_meta_box(
            'neamob_portfolio_ugc',
            'Portfolio — UGC-Video',
            'neamob_render_gallery_metabox',
            'page',
            'normal',
            'high',
            ['meta_key' => '_neamob_portfolio_ugc']
        );
    }
}
add_action('add_meta_boxes_page', 'neamob_gallery_metaboxes');

function neamob_render_gallery_metabox($post, $metabox) {
    $meta_key = $metabox['args']['meta_key'];
    $ids = get_post_meta($post->ID, $meta_key, true);
    $ids = is_array($ids) ? $ids : ($ids ? explode(',', $ids) : []);
    $ids = array_filter($ids);

    wp_nonce_field('neamob_gallery_save', 'neamob_gallery_nonce');
    ?>
    <div class="neamob-gallery-wrap" data-meta-key="<?php echo esc_attr($meta_key); ?>">
        <input type="hidden" name="<?php echo esc_attr($meta_key); ?>" class="neamob-gallery-ids" value="<?php echo esc_attr(implode(',', $ids)); ?>">
        <ul class="neamob-gallery-list">
            <?php foreach ($ids as $id):
                $thumb = wp_get_attachment_image_url($id, 'thumbnail');
                if (!$thumb) continue;
            ?>
            <li data-id="<?php echo esc_attr($id); ?>">
                <img src="<?php echo esc_url($thumb); ?>" alt="">
                <button type="button" class="neamob-gallery-remove">&times;</button>
            </li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="button neamob-gallery-add">Add Images</button>
    </div>
    <?php
}

function neamob_gallery_save($post_id) {
    if (!isset($_POST['neamob_gallery_nonce']) || !wp_verify_nonce($_POST['neamob_gallery_nonce'], 'neamob_gallery_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $keys = ['_neamob_about_gallery', '_neamob_portfolio_static', '_neamob_portfolio_video', '_neamob_portfolio_ugc'];
    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            $ids = array_filter(array_map('intval', explode(',', sanitize_text_field($_POST[$key]))));
            update_post_meta($post_id, $key, $ids);
        }
    }
}
add_action('save_post_page', 'neamob_gallery_save');

function neamob_gallery_admin_scripts($hook) {
    if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
    if (get_post_type() !== 'page') return;

    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-sortable');

    $css = '
    .neamob-gallery-list { display:flex; flex-wrap:wrap; gap:10px; list-style:none; margin:0 0 12px; padding:0; }
    .neamob-gallery-list li { position:relative; width:120px; height:120px; border:2px solid #ddd; border-radius:4px; overflow:hidden; cursor:move; }
    .neamob-gallery-list li img { width:100%; height:100%; object-fit:cover; }
    .neamob-gallery-remove { position:absolute; top:2px; right:2px; background:rgba(0,0,0,.6); color:#fff; border:none; border-radius:50%; width:22px; height:22px; font-size:14px; line-height:20px; cursor:pointer; text-align:center; padding:0; }
    .neamob-gallery-remove:hover { background:rgba(200,0,0,.8); }
    .neamob-gallery-list li.ui-sortable-placeholder { border:2px dashed #0073aa; background:#f0f6fc; }
    ';

    $js = "
    jQuery(function($){
        $('.neamob-gallery-wrap').each(function(){
            var wrap = $(this);
            var list = wrap.find('.neamob-gallery-list');
            var input = wrap.find('.neamob-gallery-ids');

            function updateInput(){
                var ids = [];
                list.find('li').each(function(){ ids.push($(this).data('id')); });
                input.val(ids.join(','));
            }

            list.sortable({ placeholder:'ui-sortable-placeholder', tolerance:'pointer', update:updateInput });

            wrap.on('click','.neamob-gallery-remove',function(e){
                e.preventDefault();
                $(this).closest('li').remove();
                updateInput();
            });

            wrap.find('.neamob-gallery-add').on('click',function(e){
                e.preventDefault();
                var frame = wp.media({ title:'Select Images', multiple:true, library:{type:'image'}, button:{text:'Add to Gallery'} });
                frame.on('select',function(){
                    frame.state().get('selection').each(function(att){
                        var d = att.toJSON();
                        var thumb = d.sizes && d.sizes.thumbnail ? d.sizes.thumbnail.url : d.url;
                        list.append('<li data-id=\"'+d.id+'\"><img src=\"'+thumb+'\"><button type=\"button\" class=\"neamob-gallery-remove\">&times;</button></li>');
                    });
                    updateInput();
                });
                frame.open();
            });
        });
    });
    ";

    wp_add_inline_style('wp-admin', $css);
    wp_add_inline_script('jquery-ui-sortable', $js);
}
add_action('admin_enqueue_scripts', 'neamob_gallery_admin_scripts');

/**
 * Helper: get gallery image URLs from native meta box.
 */
function neamob_get_gallery_images($meta_key, $post_id = null, $size = 'full') {
    if (!$post_id) $post_id = get_the_ID();
    $ids = get_post_meta($post_id, $meta_key, true);
    if (!is_array($ids)) $ids = $ids ? explode(',', $ids) : [];
    $images = [];
    foreach (array_filter($ids) as $id) {
        $url = wp_get_attachment_image_url($id, $size);
        $alt = get_post_meta($id, '_wp_attachment_image_alt', true) ?: 'Gallery image';
        if ($url) $images[] = ['url' => $url, 'alt' => $alt];
    }
    return $images;
}
