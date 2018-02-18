Copyright Top Position
-------------------

To insert Footer Top Position insert in your theme something like:

```
<div class="copyright-top">

    <div class="row">
        
        <div class="col-md-3">

            <?php if ( is_active_sidebar( 'footer-copyright-top1' ) ) { dynamic_sidebar( 'footer-copyright-top1' ); }  ?>

        </div>

        <div class="col-md-3">

            <?php if ( is_active_sidebar( 'footer-copyright-top2' ) ) { dynamic_sidebar( 'footer-copyright-top2' ); }  ?>

        </div>

        <div class="col-md-3">

            <?php if ( is_active_sidebar( 'footer-copyright-top3' ) ) { dynamic_sidebar( 'footer-copyright-top3' ); }  ?>

        </div>

        <div class="col-md-3">

            <?php if ( is_active_sidebar( 'footer-copyright-top4' ) ) { dynamic_sidebar( 'footer-copyright-top4' ); }  ?>

        </div>

   </div>

</div>

<div class="clearfix"></div>
```
