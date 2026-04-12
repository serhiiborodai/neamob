<?php
/**
 * FAQ meta box for blog posts.
 * Repeater-style: question + answer pairs, sortable.
 */

function neamob_faq_metabox() {
    add_meta_box(
        'neamob_post_faq',
        'FAQ Section',
        'neamob_render_faq_metabox',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_post', 'neamob_faq_metabox');

function neamob_render_faq_metabox($post) {
    $faq_items = get_post_meta($post->ID, '_neamob_faq', true);
    if (!is_array($faq_items)) $faq_items = [];
    wp_nonce_field('neamob_faq_save', 'neamob_faq_nonce');
    ?>
    <div id="neamob-faq-wrap">
        <div id="neamob-faq-list">
            <?php foreach ($faq_items as $i => $item): ?>
            <div class="neamob-faq-row" data-index="<?php echo $i; ?>">
                <div class="neamob-faq-row__handle">&#9776;</div>
                <div class="neamob-faq-row__fields">
                    <input type="text" name="neamob_faq[<?php echo $i; ?>][q]" value="<?php echo esc_attr($item['q'] ?? ''); ?>" placeholder="Question" class="widefat">
                    <textarea name="neamob_faq[<?php echo $i; ?>][a]" placeholder="Answer" class="widefat" rows="2"><?php echo esc_textarea($item['a'] ?? ''); ?></textarea>
                </div>
                <button type="button" class="neamob-faq-remove button">&times;</button>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button button-primary" id="neamob-faq-add">+ Add FAQ Item</button>
    </div>
    <?php
}

function neamob_faq_save($post_id) {
    if (!isset($_POST['neamob_faq_nonce']) || !wp_verify_nonce($_POST['neamob_faq_nonce'], 'neamob_faq_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $faq = [];
    if (isset($_POST['neamob_faq']) && is_array($_POST['neamob_faq'])) {
        foreach ($_POST['neamob_faq'] as $item) {
            $q = sanitize_text_field($item['q'] ?? '');
            $a = sanitize_textarea_field($item['a'] ?? '');
            if ($q || $a) {
                $faq[] = ['q' => $q, 'a' => $a];
            }
        }
    }
    update_post_meta($post_id, '_neamob_faq', $faq);
}
add_action('save_post_post', 'neamob_faq_save');

function neamob_faq_admin_scripts($hook) {
    if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
    if (get_post_type() !== 'post') return;

    wp_enqueue_script('jquery-ui-sortable');

    $css = '
    #neamob-faq-list { margin-bottom: 12px; }
    .neamob-faq-row { display:flex; gap:8px; align-items:flex-start; padding:10px; margin-bottom:8px; background:#f9f9f9; border:1px solid #ddd; border-radius:4px; }
    .neamob-faq-row__handle { cursor:move; font-size:18px; padding:6px 4px 0 0; color:#999; }
    .neamob-faq-row__fields { flex:1; display:flex; flex-direction:column; gap:6px; }
    .neamob-faq-row__fields input,
    .neamob-faq-row__fields textarea { width:100%; }
    .neamob-faq-remove { color:#a00; border-color:#a00; font-size:16px; line-height:1; padding:4px 8px; margin-top:4px; }
    .neamob-faq-row.ui-sortable-placeholder { border:2px dashed #0073aa; background:#f0f6fc; visibility:visible !important; min-height:80px; }
    ';

    $js = "
    jQuery(function($){
        var list = $('#neamob-faq-list');
        var idx = list.find('.neamob-faq-row').length;

        list.sortable({ handle:'.neamob-faq-row__handle', placeholder:'ui-sortable-placeholder', tolerance:'pointer',
            stop: function(){ reindex(); }
        });

        $('#neamob-faq-add').on('click', function(){
            var row = '<div class=\"neamob-faq-row\" data-index=\"'+idx+'\">'
                + '<div class=\"neamob-faq-row__handle\">&#9776;</div>'
                + '<div class=\"neamob-faq-row__fields\">'
                + '<input type=\"text\" name=\"neamob_faq['+idx+'][q]\" placeholder=\"Question\" class=\"widefat\">'
                + '<textarea name=\"neamob_faq['+idx+'][a]\" placeholder=\"Answer\" class=\"widefat\" rows=\"2\"></textarea>'
                + '</div>'
                + '<button type=\"button\" class=\"neamob-faq-remove button\">&times;</button>'
                + '</div>';
            list.append(row);
            idx++;
        });

        list.on('click', '.neamob-faq-remove', function(){ $(this).closest('.neamob-faq-row').remove(); reindex(); });

        function reindex(){
            list.find('.neamob-faq-row').each(function(i){
                $(this).attr('data-index', i);
                $(this).find('input').attr('name', 'neamob_faq['+i+'][q]');
                $(this).find('textarea').attr('name', 'neamob_faq['+i+'][a]');
            });
            idx = list.find('.neamob-faq-row').length;
        }
    });
    ";

    wp_add_inline_style('wp-admin', $css);
    wp_add_inline_script('jquery-ui-sortable', $js);
}
add_action('admin_enqueue_scripts', 'neamob_faq_admin_scripts');
