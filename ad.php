<center>
    <?php
    $blacklisted = ["my-gdps", "create-gdps", "management"]; // todo: blacklist gdps/index.php as well
    if (in_array($_SERVER["SCRIPT_FILENAME"], $blacklisted)) {
        ?>
        <script type="text/javascript" src="https://udbaa.com/bnr.php?section=Footer&pub=628861&format=468x60&ga=g&bg=1"></script>
        <noscript><a href="https://yllix.com/publishers/628861" target="_blank"><img
            src="//ylx-aff.advertica-cdn.com/pub/468x60.png"
            style="border:none;margin:0;padding:0;vertical-align:baseline;"
            alt="ylliX - Online Advertising Network" /></a></noscript>
    <?php } else { ?>
        <script type="text/javascript" src="https://udbaa.com/bnr.php?section=FooterAllType&pub=628861&format=468x60&ga=g"></script>
        <noscript><a href="https://yllix.com/publishers/628861" target="_blank"><img
            src="//ylx-aff.advertica-cdn.com/pub/468x60.png"
            style="border:none;margin:0;padding:0;vertical-align:baseline;"
            alt="ylliX - Online Advertising Network" /></a></noscript>
    <?php
    }
    /*
        <script type="text/javascript" src="https://udbaa.com/bnr.php?section=FooterMobile&pub=628861&format=300x50&ga=g&bg=1"></script>
        <noscript><a href="https://yllix.com/publishers/628861" target="_blank"><img src="//ylx-aff.advertica-cdn.com/pub_zn9ugf.png" style="border:none;margin:0;padding:0;vertical-align:baseline;" alt="ylliX - Online Advertising Network" /></a></noscript>
    */
    ?>
</center>