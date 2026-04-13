<?php
/**
 * Template Name: Case Study — Rehab Center
 *
 * @package Neamob_Theme
 */

get_header();
?>

<main class="cs-rehab">
    <?php
    remove_filter('the_content', 'wpautop');
    if (have_posts()):
        while (have_posts()): the_post();
            the_content();
        endwhile;
    endif;
    add_filter('the_content', 'wpautop');
    ?>
</main>

<?php
get_template_part('template-parts/contact-form');
get_footer();
?>

<script>
(function(){
    var observer = new IntersectionObserver(function(entries){
        entries.forEach(function(entry, i){
            if(entry.isIntersecting){
                setTimeout(function(){ entry.target.classList.add('visible'); }, i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, {threshold: 0.15});
    document.querySelectorAll('.cs-rehab .fade-in').forEach(function(el){ observer.observe(el); });
})();
</script>
