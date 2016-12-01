<?
$f=$_GET['font'];
$g_f=str_ireplace(" ","+",$f);
?>
<html>
    <head>
        <style>
            @font-face {
                font-family: '<?=$f;?>';
                src: url('/css/webfonts/<?=$f;?>.eot');
                src: url('/css/webfonts/<?=$f;?>.eot?#iefix') format('embedded-opentype'),
                url('/css/webfonts/<?=$f;?>.woff') format('woff'),
                url('/css/webfonts/<?=$f;?>.ttf') format('truetype'),
                url('/css/webfonts/<?=$f;?>.svg#<?=$f;?>') format('svg');
                font-weight: normal;
                font-style: normal;
        
        }
        
            body {font-size:12px;margin:0;padding:0;font-family:'<?=$f;?>'}
        </style>
        <link href='http://fonts.googleapis.com/css?family=<?=$g_f;?>' rel='stylesheet' type='text/css'>
    </head>
    <body>
        eXite - The impossible become <strong>possible</strong>!
    </body>
</html>