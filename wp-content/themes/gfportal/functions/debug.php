<?php

function gf_debug($collapse=true) { ?>
<div class="panel-group" id="debug" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="<?php echo (($collapse == true) ? 'false' : 'true'); ?>" aria-controls="collapseTwo">Debug</a>
        <div class="pull-right"><label><input class="no-redirect" type="checkbox"> No Redirect</label></div>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse <?php echo (($collapse == true) ? '' : 'in'); ?>" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body"></div>
    </div>
  </div>
</div>
<?php }