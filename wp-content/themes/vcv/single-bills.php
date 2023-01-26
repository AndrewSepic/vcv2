<?php get_header(); ?>
    <section id='content' class='container '>
        <h1><?php  the_field('bill_number');  ?> &ndash; <?php the_title(); ?></h1>
        <?php the_content(); ?>
    </section>
    <?php get_footer(); ?>