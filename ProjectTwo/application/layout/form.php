<!DOCTYPE html> 

<html> 

    <head>

        <title><?php echo $title; ?></title>

        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('Bootstrap/v4.0.0-beta.3/dist/css/bootstrap.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= font_url('font-awesome-4.7.0/css/font-awesome.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('ColorlibVendor/animate/animate'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('ColorlibVendor/css-hamburgers/hamburgers.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('ColorlibVendor/select2/select2.min'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= cmp_css_url('ColorlibVendor/slick/slick'); ?>">
<!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="<?= css_url('Form/util'); ?>">
        <link rel="stylesheet" type="text/css" href="<?= css_url('Form/main'); ?>">
<!--===============================================================================================-->

<?php foreach($css as $url): ?>
        <link rel="stylesheet" type="text/css" href="<?= $url; ?>" />
<?php endforeach; ?>

        <!--<link rel="icon" type="image/png" href="<?= img_url('fav.favicon'); ?>" sizes="16x16" />-->

    </head>


    <body>
        
<?= $output; ?>

<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('Jquery/jquery/jquery-3.2.1.min'); ?>"></script>
<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('Bootstrap/v4.0.0-beta.3/dist/js/bootstrap.min'); ?>"></script>
        <script type="text/javascript" src="<?= cmp_js_url('Bootstrap/v4.0.0-beta.3/assets/js/vendor/popper.min'); ?>"></script>
<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('ColorlibVendor/select2/select2.min'); ?>"></script>
<!--===============================================================================================-->
        <script type="text/javascript" src="<?= cmp_js_url('ColorlibVendor/tilt/tilt.jquery.min'); ?>"></script>

<?php foreach($js as $url): ?>
        <script type="text/javascript" src="<?php echo $url; ?>"></script> 
<?php endforeach; ?>    
        
    </body>

</html>