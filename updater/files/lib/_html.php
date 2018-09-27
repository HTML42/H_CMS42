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
            <div class="buttons">
                <div class="button update_trigger">UPDATE</div>
                <div class="button missing_trigger">CREATE MISSING</div>
            </div>
        </header>
        <main><?= $content ?></main>
        <script src="script<?= (IS_DEMO ? '' : '.min') ?>.js" async></script>
    </body>
</html>