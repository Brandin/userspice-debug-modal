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
        <p>
          <button class="btn btn-sm btn-secondary" id="DebugModal_auto_open_debug" onclick="DebugModal_autoOpenToggle()">Auto-Open Debug On Page Load</button>
        </p>
        <?php if (!$user->isLoggedIn() && pluginActive('localhostlogin', true)) { ?>
          <p>
            <a href="<?php echo $us_url_root; ?>usersc/plugins/localhostlogin/files/index.php" class="btn btn-sm btn-secondary" id="DebugModal_LocalhostLogin">Localhost Login</a>
          </p>
        <?php } ?>
        <?php if ($user->isLoggedIn() && hasPerm(2) && currentPage() != 'admin.php') { ?>
          <p>
            <a href="<?php echo $us_url_root; ?>users/admin.php" class="btn btn-sm btn-secondary" id="DebugModal_ACPLink">Admin Panel</a>
          </p>
        <?php } ?>
        <h5>Session</h5>
        <p id="DebugModal_session_destroy_parent"><button class="btn btn-sm btn-danger" id="DebugModal_session_destroy" onclick="DebugModal_destroySession()">Destroy Session</button></p>
        <?php dump($_SESSION); ?>
        <h5>POST</h5>
        <?php dump($_POST); ?>
        <h5>User Data</h5>
        <?php
        if ($user->isLoggedIn()) {
            dump($user->data());
        } else {
            dump('Not Logged In');
        }
        ?>
        <h5>Misc</h5>
        <?php dump(['abs_us_root' => $abs_us_root, 'us_url_root' => $us_url_root]); ?>
      </div>
    </div>
  </div>
</div>
<script>
window.addEventListener('load', function () {
  document.querySelector('footer').innerHTML = document.querySelector('footer').innerHTML.replace("</p>"," | <a href='#' data-toggle='modal' data-target='#debugmodal'>Debug</a></p>");
  var autoOpen = localStorage.getItem('DebugModal_auto_open_debug');
  DebugModal_updateOpenToggleButton(autoOpen);
  if(autoOpen == 'enabled') {
    $("#debugmodal").modal()
  }
});

function DebugModal_autoOpenToggle() {
  var autoOpen = localStorage.getItem('DebugModal_auto_open_debug');
  if(!autoOpen) {
    localStorage.setItem('DebugModal_auto_open_debug', "disabled");
    autoOpen = localStorage.getItem('DebugModal_auto_open_debug');
  }

  if(autoOpen == "disabled") {
    autoOpen = "enabled";
  } else if(autoOpen == "enabled") {
    autoOpen = "disabled";
  }

  localStorage.setItem('DebugModal_auto_open_debug', autoOpen);
  autoOpen = localStorage.getItem('DebugModal_auto_open_debug');
  DebugModal_updateOpenToggleButton(autoOpen);
  return;
}

function DebugModal_updateOpenToggleButton(state) {
  if(state == 'enabled') {
    document.getElementById('DebugModal_auto_open_debug').classList.replace('btn-secondary', 'btn-success');
  }
  if(state == 'disabled') {
    document.getElementById('DebugModal_auto_open_debug').classList.replace('btn-success', 'btn-secondary');
  }

  return;
}

function DebugModal_destroySession() {
  fetch('//<?php echo "{$_SERVER['HTTP_HOST']}{$us_url_root}usersc/plugins/debugmodal/files/destroy_session.php"; ?>')
  .then(response => response.json())
  .then(data => {
    if(data == 'success') {
      location.reload();
    } else {
      document.getElementById('DebugModal_session_destroy_parent').innerHTML = document.getElementById('DebugModal_session_destroy_parent').innerHTML + '<p id="DebugModal_session_destroy_warning_text">There was an error destroying the session</p>';
    }
  });
}
</script>
<?php } ?>
