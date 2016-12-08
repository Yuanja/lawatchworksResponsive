<?php
$title=($cfg && is_object($cfg) && $cfg->getTitle())
    ? $cfg->getTitle() : 'osTicket :: '.__('Support Ticket System');
$signin_url = ROOT_PATH . "login.php"
    . ($thisclient ? "?e=".urlencode($thisclient->getEmail()) : "");
$signout_url = ROOT_PATH . "logout.php?auth=".$ost->getLinkToken();

header("Content-Type: text/html; charset=UTF-8");
if (($lang = Internationalization::getCurrentLanguage())) {
    $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
    $langs = Internationalization::rfc1766($langs);
    header("Content-Language: ".implode(', ', $langs));
}
?>
<!DOCTYPE html>
<html<?php
if ($lang
        && ($info = Internationalization::getLanguageInfo($lang))
        && (@$info['direction'] == 'rtl'))
    echo ' dir="rtl" class="rtl"';
if ($lang) {
    echo ' lang="' . $lang . '"';
}
?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo Format::htmlchars($title); ?></title>
    <meta name="description" content="Los Angeles Watchworks was founded by Beau Goorey and Eric Ku, with the goal of bringing high level restoration and watchmaking services to collectors from around the world."">
    <meta name="keywords" content="Vintage Rolex, Los Angeles Watchworks, Beau Goorey, Eric Ku, restoration, watchmaking, collectors">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Watch works framework styles -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/material.css">
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>css/material.js"></script>
    
    <style>
    #view-source {
      position: fixed;
      display: block;
      right: 0;
      bottom: 0;
      margin-right: 40px;
      margin-bottom: 40px;
      z-index: 900;
    }
    </style>
    
    <!-- osticket default styles -->
	<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css?907ec36" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/theme.css?907ec36" media="screen"/>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css?907ec36" media="print"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css?907ec36"
         media="screen" />
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css?907ec36"
        rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css?907ec36" media="screen"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?907ec36" media="screen"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?907ec36"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?907ec36"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?907ec36"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?907ec36"/>
    
    <!--  Watchworks assets -->
    <script type="text/javascript" src="<?php echo ASSETS_PATH; ?>css/watchworks.js"></script>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/watchworks.css">
    <!-- End of Watchworks -->
    
    <!-- osTT Client Theme Stylesheets -->
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/osttclient/css/bootstrap.min.css" media="screen"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/osttclient/css/osttclient.theme.min.css?v1" media="screen"/>
       
    <!-- Change your colour scheme here. Replace the below stylesheet with your preferred colour from the /assets/osttclient/css/colours directory -->
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/osttclient/css/colours/blue-scheme.css" media="screen"/>
    <!-- End colour scheme -->
            
    <!-- End osTT Client Theme Stylesheets -->
    
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.11.2.min.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.10.3.custom.min.js?907ec36"></script>
    <script src="<?php echo ROOT_PATH; ?>js/osticket.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js?907ec36"></script>
    <script src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js?907ec36"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/fabric.min.js?907ec36"></script>
    
    <!-- osTT Client Theme Scripts -->
        <script type="text/javascript" src="<?php echo ROOT_PATH; ?>assets/osttclient/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo ROOT_PATH; ?>assets/osttclient/js/osticket.osttclient.js"></script>
    <!-- osTT Client Theme Scripts -->
    
    
    <?php
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }

    // Offer alternate links for search engines
    // @see https://support.google.com/webmasters/answer/189077?hl=en
    if (($all_langs = Internationalization::getConfiguredSystemLanguages())
        && (count($all_langs) > 1)
    ) {
        $langs = Internationalization::rfc1766(array_keys($all_langs));
        $qs = array();
        parse_str($_SERVER['QUERY_STRING'], $qs);
        foreach ($langs as $L) {
            $qs['lang'] = $L; ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?<?php
            echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>" />
<?php
        } ?>
        <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
            hreflang="x-default" />
<?php
    }
    ?>
</head>
  <body id="home">
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--no-desktop-drawer-button wrapper">
      <div class="mdl-layout__header-row">
        <div aria-expanded="false" role="button" tabindex="0" class="mdl-layout__drawer-button"><i class="material-icons"></i></div>
        <div>
          <!-- Add spacer, to align navigation to the right in desktop -->
          <!-- <div class="header-spacer mdl-layout-spacer"></div> -->
          <!-- Navigation -->
          <div class="navigation-container">
            <nav>
              <ul>
                <li>
                  <a href="<?php echo ROOT_PATH; ?>index.php"><img class="logo-image" src="<?php echo ASSETS_PATH; ?>images/watchworks/logo.png"></a>
              <?php if ($thisclient && is_object($thisclient) && $thisclient->isValid() && !$thisclient->isGuest()) {?>
                <li>
                    <a href="<?php echo ROOT_PATH; ?>profile.php"><?php echo Format::htmlchars($thisclient->getName()).'&nbsp;'; ?></a> 
                </li>
                <li>
                    <a href="<?php echo ROOT_PATH; ?>open.php">Open a New Ticket</a>
                </li>
                <li>
                    <a href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a>
                </li>
                <li>
                    <a href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a>
                </li>
                <?php } else { ?>
                <li>
                    <a href="<?php echo $signin_url; ?>">Fix My Watch</a>
                </li>
                <?php } ?>
                <li>
                  <a href="<?php echo ROOT_PATH; ?>service.php">Services</a>
                </li>
                <li>
                  <a href="<?php echo ROOT_PATH; ?>about.php">About Us / Contact</a>
                </li>
                <li>
                  <a href="<?php echo ROOT_PATH; ?>tandc.php">Terms and Conditions</a>
                </li>
                
              </ul>
            </nav>
          </div>
        </div>
        <a href="<?php echo ROOT_PATH; ?>index.php"><img class="logo-image-mobile" src="<?php echo ASSETS_PATH; ?>images/watchworks/logo.png"></a>
      </div>
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
          <?php if ($thisclient && is_object($thisclient) && $thisclient->isValid() && !$thisclient->isGuest()) {?>
              <a class="mdl-navigation__link" href="<?php echo ROOT_PATH; ?>profile.php"><?php echo Format::htmlchars($thisclient->getName()).'&nbsp;'; ?></a>
              <a class="mdl-navigation__link" href="<?php echo ROOT_PATH; ?>open.php">Open a New Ticket</a>
              <a class="mdl-navigation__link" href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a>
              <a class="mdl-navigation__link" href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a>
          <?php } else { ?>
              <a class="mdl-navigation__link" href="<?php echo $signin_url; ?>">Fix My Watch</a>
          <?php } ?>  
          <a class="mdl-navigation__link" href="<?php echo $signin_url; ?>">Fix My Watch</a>
          <a class="mdl-navigation__link" href="<?php echo ROOT_PATH; ?>service.php">Services</a>
          <a class="mdl-navigation__link" href="<?php echo ROOT_PATH; ?>about.php">About Us / Contact</a>
          <a class="mdl-navigation__link" href="<?php echo ROOT_PATH; ?>tandc.php">Terms and Conditions</a>
        </nav>
      </div>

      <?php if($errors['err']) { ?>
        <div id="msg_error"><?php echo $errors['err']; ?></div>
      <?php }elseif($msg) { ?>
        <div id="msg_notice"><?php echo $msg; ?></div>
      <?php }elseif($warn) { ?>
        <div id="msg_warning"><?php echo $warn; ?></div>
      <?php } ?>
