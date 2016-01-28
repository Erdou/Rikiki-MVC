<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="apple-mobile-web-app-title" content="{$smarty.const.APP_TITLE}"/>
    {* Use if needed:
    <link rel="apple-touch-icon" sizes="57x57" href="{$smarty.const.ROOT_URL}i/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="{$smarty.const.ROOT_URL}i/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="{$smarty.const.ROOT_URL}i/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="{$smarty.const.ROOT_URL}i/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="60x60" href="{$smarty.const.ROOT_URL}i/apple-touch-icon-60x60.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="{$smarty.const.ROOT_URL}i/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="{$smarty.const.ROOT_URL}i/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="{$smarty.const.ROOT_URL}i/apple-touch-icon-152x152.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{$smarty.const.ROOT_URL}i/apple-touch-icon-180x180.png"/>
    <link rel="icon" type="image/png" href="{$smarty.const.ROOT_URL}i/favicon-192x192.png" sizes="192x192"/>
    <link rel="icon" type="image/png" href="{$smarty.const.ROOT_URL}i/favicon-160x160.png" sizes="160x160"/>
    <link rel="icon" type="image/png" href="{$smarty.const.ROOT_URL}i/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/png" href="{$smarty.const.ROOT_URL}i/favicon-16x16.png" sizes="16x16"/>
    <link rel="icon" type="image/png" href="{$smarty.const.ROOT_URL}i/favicon-32x32.png" sizes="32x32"/>
    <meta name="msapplication-TileColor" content="#2b5797"/>
    <meta name="msapplication-TileImage" content="{$smarty.const.ROOT_URL}i/mstile-144x144.png"/>
    *}
    <meta property="og:site_name" content="{$smarty.const.APP_TITLE}">
    <meta property="og:title" content="{$smarty.const.APP_TITLE}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{$rootUrl}{$page}">
    {if $metaDescription}
        <meta property="og:description" content="{$metaDescription}">
    {/if}
    {if $metaDescription}
        <meta name="description" content="{$metaDescription}">
        <meta name="keywords" content="{$metaDescription|genKeywords}">
    {/if}
    <title>{if $title}{$title}{else}{$smarty.const.APP_TITLE}{/if}</title>
    <link rel="stylesheet" type="text/css" href="{$rootUrl}css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{$rootUrl}css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="{$rootUrl}css/app.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        {include file="pages/$page.tpl"}

        <input type="hidden" id="js-root-url" value="{$rootUrl}">
    </div>
    <script charset="UTF-8" type="text/javascript" src="{$smarty.const.ROOT_URL}js/jquery.min.js"></script>
    <script charset="UTF-8" type="text/javascript" src="{$smarty.const.ROOT_URL}js/bootstrap.min.js"></script>
    <script charset="UTF-8" type="text/javascript" src="{$smarty.const.ROOT_URL}js/app.js"></script>
</body>
</html>
