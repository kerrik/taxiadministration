<!DOCTYPE html>
        <?=$tango->head()?>
    <body>
        <div id='wrapper'>
            <div id='header'>
                <?=$tango->header()?>
                <?=$tango->menu($main_menu) ?>
            </div><!-- header -->
            <div id='main'>
                <div id='content'>
                    <?=$tango->main()?>
                </div> <!-- content -->
                <footer id='footer'>
                    <?=$tango->footer()?>
                </footer>
            </div><!-- main -->
            <?= $tango->scripts_footer(); ?>
        </div> <!-- wrapper -->
    </body>
</html>