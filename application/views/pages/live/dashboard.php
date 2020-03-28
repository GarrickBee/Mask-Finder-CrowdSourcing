<style media="screen">
.beero-live-badge .btn {
  font-size:3rem !important;
  width: 80px !important;
  height: 80px !important;
}
.beero-live-badge .strong {
  font-size:2rem !important;
}
.beero-live-badge .text-muted {
  font-size:1.3rem !important;
}
#result {
  position: absolute;
  width: 100%;
  max-width:870px;
  cursor: pointer;
  overflow-y: auto;
  max-height: 400px;
  box-sizing: border-box;
  z-index: 1001;
}
.link-class:hover{
  background-color:#f1f1f1;
}
</style>
<div class="page-header">
  <div class="row align-items-center">
    <div class="col-12 col-md-5">
      <div class="page-pretitle">
        Overview
      </div>
      <h2 class="page-title">
        Live Update - <span  class="font-weight-bold country-name">World</span>
      </h2>
    </div>
    <div class="col-md-7 col-12">
      <div class="page-pretitle">
        Search Your Own Country
      </div>
      <div class="input-group mb-2">
        <select class="form-select" id="country_search_value" name="" >
          <option value="all" selected >World</option>
          <?php
          $country = json_decode(file_get_contents(base_url("assets/json/country.json")),TRUE);
          foreach ($country as $key => $value) {
            echo "<option value='{$value['name']}'>{$value['name']}</option>";
          }
          ?>
        </select>
        <span class="input-group-append">
          <button id="country_search_button" class="btn btn-primary" type="button">Search Now!</button>
        </span>
      </div>

    </div>
  </div>
</div>
<!-- World Live Count -->
<section class="row">
  <div class="col-12 col-md-4">
    <div class="card card-sm beero-live-badge">
      <div class="card-body d-flex align-items-center">
        <span class="btn btn-danger">
          <i class="fas fa-skull-crossbones"></i>
        </span>
        <div class="mx-3 lh-sm">
          <div id="deathTotal" class="strong" >
            0
          </div>
          <div class="text-muted">Deaths</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Infected -->
  <div class="col-12 col-md-4">
    <div class="card card-sm beero-live-badge">
      <div class="card-body d-flex align-items-center">
        <span class="btn btn-warning">
          <i class="fas fa-lungs-virus"></i>
        </span>
        <div class="mx-3 lh-sm">
          <div id="confirmTotal" class="strong">
            0
          </div>
          <div class="text-muted">Confirms</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Heal -->
  <div class="col-12 col-md-4">
    <div class="card card-sm beero-live-badge">
      <div class="card-body d-flex align-items-center">
        <span class="btn btn-success">
          <i class="fas fa-running"></i>
        </span>
        <div class="mx-3 lh-sm">
          <div id="healTotal" class="strong">
            0
          </div>
          <div class="text-muted">Heal</div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Today Live Count -->
<section class="row country-row" style="display:none">
  <div class="col-12 mb-3">
    <h2 class="page-title">
      Today
    </h2>
  </div>
  <!-- Death -->
  <div class="col-12 col-md-4">
    <div class="card card-sm beero-live-badge">
      <div class="card-body d-flex align-items-center">
        <span class="btn btn-danger">
          <i class="fas fa-skull-crossbones"></i>
        </span>
        <div class="mx-3 lh-sm">
          <div id="deathToday" class="strong" >
            0
          </div>
          <div class="text-muted">Deaths</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Infected -->
  <div class="col-12 col-md-4">
    <div class="card card-sm beero-live-badge">
      <div class="card-body d-flex align-items-center">
        <span class="btn btn-warning">
          <i class="fas fa-lungs-virus"></i>
        </span>
        <div class="mx-3 lh-sm">
          <div id="confirmToday" class="strong">
            0
          </div>
          <div class="text-muted">Confirms</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Heal -->
  <div class="col-12 col-md-4">
    <div class="card card-sm beero-live-badge">
      <div class="card-body d-flex align-items-center">
        <span class="btn btn-success">
          <i class="fas fa-running"></i>
        </span>
        <div class="mx-3 lh-sm">
          <div id="healToday" class="strong">
            0
          </div>
          <div class="text-muted">Heal</div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Counr -->


</section>
