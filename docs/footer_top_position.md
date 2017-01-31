Footer Top Position
===================

To insert Footer Top Position insert in your theme something like:

...
<div class="footer-top">

    <div class="col-md-3">

        <?php if ( is_active_sidebar( 'footer-top-1' ) ) { dynamic_sidebar( 'footer-top-1' ); }  ?>

    </div>

    <div class="col-md-3">

        <?php if ( is_active_sidebar( 'footer-top-2' ) ) { dynamic_sidebar( 'footer-top-2' ); }  ?>

    </div>

    <div class="col-md-3">

        <?php if ( is_active_sidebar( 'footer-top-3' ) ) { dynamic_sidebar( 'footer-top-3' ); }  ?>

    </div>

    <div class="col-md-3">

      <?php if ( is_active_sidebar( 'footer-top-4' ) ) { dynamic_sidebar( 'footer-top-4' ); }  ?>

    </div>

</div>
...
