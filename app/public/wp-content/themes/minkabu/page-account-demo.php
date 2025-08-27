<?php
/**
 * Template Name: Account Opening Demo
 * Description: Demo page for account opening section
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="site-content">
    <?php
    // Include the account opening section
    get_template_part('template-parts/account-opening-enhanced');
    ?>
</div>

<?php
get_footer();
?>