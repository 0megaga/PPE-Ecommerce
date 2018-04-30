<!DOCTYPE html> 

<html> 

    <head>

        <title><?php echo $title; ?></title>

        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />

<?php foreach($css as $url): ?>

        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />

<?php endforeach; ?>


    </head>


    <body>

        <div id="contenu">

            <?php echo $output; ?>

        </div>

        

<?php foreach($js as $url): ?>

        <script type="text/javascript" src="<?php echo $url; ?>"></script> 

<?php endforeach; ?>


    </body>


</html>