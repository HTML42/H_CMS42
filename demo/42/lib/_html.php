<!DOCTYPE-->
<html>
    <head>
        <title>CMS42</title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
    </head>
    <body>
        <header>
            <div class="logo">CMS42</div>
            <div class="version">
                <span class="current"><?= VERSION ?></span>
                <span class="cdn_version"><?= CDN_VERSION ?></span>
            </div>
            <div class="button update_trigger">UPDATE</div>
        </header>
        <main><?= $content ?></main>
        <script src="script.js" async></script>
    </body>
</html>