<?php
/**
 * The template for displaying the footer
 * Contains the closing of the #content div and all content after.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<footer class="footer">

    <hr class="footer-line">

    <div class="footer-table">

        <div class="footer-table-cell_1">
            <span>
            <b>CRS Laboratories Oy</b><br>
            Y-tunnus: 0971958-0<br>
            <a class="a" href="">Tietosuojalauseke</a>
            </span>
        </div>

        <div class="footer-table-cell_2">
            <span>
        Näytelistojen ja lähetteiden toimitus: <a class="a" href="">samples@crs.fi</a><br>
        Näytteiden vastaanotto: ovi P8<br>
        Käyntiosoite: Takatie 6, 90440 Kempele
            </span>
        </div>

        <div class="footer-table-cell_3">
            <img class="footer_img_1"
                 src="/wp-content/themes/project-01/assets/images/Screenshot%20from%202021-03-26%2010-09-41.png"
                 alt="logo">
            <img class="footer_img_2" src="/wp-content/themes/project-01/assets/images/vipuvoima-300x197.png"
                 alt="logo">
            <img class="footer_img_1" src="/wp-content/themes/project-01/assets/images/aluekehitysrahasto-300x280.png"
                 alt="logo">
        </div>

    </div>

    <hr class="footer-line">

    <span class="footer-copyright">Copyright © <?php echo date('Y') ?> CRS Laboratories. All Rights Reserved.</span>

</footer>

<?php wp_footer(); ?>

</body>

</html>