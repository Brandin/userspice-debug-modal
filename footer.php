<?php if (isLocalhost()) {?>
<div class="modal fade" id="debugmodal" tabindex="-1" role="dialog" aria-labelledby="debugLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="debugLabel">Debug Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        dump($_SESSION);
        if ($user->isLoggedIn()) {
            dump($user->data());
        }
        dump($abs_us_root);
        dump($us_url_root);
        ?>
      </div>
    </div>
  </div>
</div>
<script>
window.addEventListener('load', function () {
  document.querySelector('footer').innerHTML = document.querySelector('footer').innerHTML.replace("</p>"," | <a href='#' data-toggle='modal' data-target='#debugmodal'>Debug</a></p>");
});
</script>
<?php } ?>
