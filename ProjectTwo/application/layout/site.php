<!DOCTYPE html> 

<html> 

    <head>

        <title><?php echo $title; ?></title>

        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />


<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('Bootstrap/v4.1.0/dist/css/bootstrap.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= font_url('font-awesome-4.7.0/css/font-awesome.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= font_url('themify/themify-icons'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= font_url('Linearicons-Free-v1.0.0/icon-font.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= font_url('elegant-font/html-css/style'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('ColorlibVendor/animate/animate'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('ColorlibVendor/css-hamburgers/hamburgers.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('ColorlibVendor/animsition/css/animsition.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('ColorlibVendor/select2/select2.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('ColorlibVendor/slick/slick'); ?>">
<!--===============================================================================================-->

<?php foreach($css as $url): ?>
        <link rel="stylesheet" type="text/css" href="<?= $url; ?>" />
<?php endforeach; ?>

        <link rel="icon" type="image/png" href="<?= img_url('icons/favicon.png'); ?>" sizes="16x16" />

    </head>


    <body class="animsition">
        
<?= $output; ?>

<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('Jquery/jquery/jquery-3.2.1.min'); ?>"></script>
<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('ColorlibVendor/animsition/js/animsition.min'); ?>"></script>
<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('Bootstrap/v4.1.0/assets/js/vendor/popper.min'); ?>"></script>
        <script type="text/javascript" src="<?= cmp_js_url('Bootstrap/v4.1.0/dist/js/bootstrap.min'); ?>"></script>  
<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('ColorlibVendor/select2/select2.min'); ?>"></script>
<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('ColorlibVendor/slick/slick.min'); ?>"></script>
        <script type="text/javascript" src="<?= js_url('Fashe/slick-custom'); ?>"></script>
<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('ColorlibVendor/sweetalert/sweetalert.min'); ?>"></script>
<!--===============================================================================================-->
        <script type="text/javascript">
            var url = {
                'atc':      '<?= $this->config->item('url_addCartItem'); ?>',
                'rci':      '<?= $this->config->item('url_removeCartItem'); ?>',
                'ac':       '<?= $this->config->item('url_applyCoupon'); ?>',
                'rc':       '<?= $this->config->item('url_removeCoupon'); ?>',
                'bn':       '<?= $this->config->item('url_order'); ?>',
                'cart':     '<?= $this->config->item('url_cart'); ?>'
            };

        <?php if ( isset( $_SESSION['rank'] ) && $_SESSION['rank'] == "admin" ) : ?>
            var dt = {
                'u':        '<?= $this->config->item('url_users_dataTable'); ?>',
                'p':        '<?= $this->config->item('url_products_dataTable'); ?>',
                'c':        '<?= $this->config->item('url_categories_dataTable'); ?>'
            };

            var aCmd = {
                'allowP':   '<?= $this->config->item('url_allowProduct'); ?>',
                'deleteP':         '<?= $this->config->item('url_deleteProduct'); ?>'
            };
        <?php endif; ?>
        </script>
<!--===============================================================================================-->
        <script type="text/javascript" src="<?= js_url('main.custom'); ?>"></script>
<!--===============================================================================================-->

<?php foreach($js as $url): ?>
        <script type="text/javascript" src="<?php echo $url; ?>"></script> 
<?php endforeach; ?>    
        
    </body>

</html>