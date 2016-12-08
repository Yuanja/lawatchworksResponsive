        <footer class="mdl-mega-footer">
          <div class="footer">
            <div class="mdl-grid footerContent">
              <div class="mdl-cell mdl-cell--4-col">
                <a href="index.html">Los Angeles Watch Works</a>
              </div>
              <div class="mdl-cell mdl-cell--4-col">
                <a href="mailto:hello@lawatchworks.com">hello@lawatchworks.com</a>
              </div>
              <div class="mdl-cell mdl-cell--4-col">
                626.714.7288
              </div>
            </div>
        </div>
        </footer>
      </div>

      <div id="overlay"></div>
      <div id="loading">
        <h4><?php echo __('Please Wait!');?></h4>
        <p><?php echo __('Please wait... it will take a second!');?></p>
      </div>

<script type="text/javascript">
    getConfig().resolve(<?php
        include INCLUDE_DIR . 'ajax.config.php';
        $api = new ConfigAjaxAPI();
        print $api->client(false);
    ?>);
</script>
</body>
</html>
