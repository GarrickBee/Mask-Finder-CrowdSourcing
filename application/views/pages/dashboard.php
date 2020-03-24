<div class="page-header">
  <div class="row align-items-center">
    <div class="col-auto">
      <h2 class="page-title">
        Mask Finder
      </h2>
    </div>
  </div>
</div>
<section class="row">
  <div class=" col-12 col-lg-4">
    <div class="card">
      <div class="card-body">
        <form id="mask_form" method="POST" action="<?php echo base_url('api/mask_submit') ?>" >
          <input id="location_longitude" type="hidden" name="data[longitude]" value="">
          <input id="location_latitude" type="hidden" name="data[latitude]" value="">
          <div class="row">
            <!-- Shop -->
            <div class="form-group col-12 mb-3">
              <label for="data[shop]" class="form-label">Shop Name <span class="text-danger">*</span></label>
              <input type="text" name="data[shop]" class="form-control" placeholder="Shop Name" value="" required>
            </div>
            <!-- Location -->
            <div class="form-group col-12 mb-3">
              <label for="data[location]" class="form-label">Location<span class="text-danger">*</span></label>
              <input type="text" id="google_location" name="data[location]" class="form-control" placeholder="Location" value="" required>
            </div>
            <!-- Item  -->
            <div class="form-group col-12 mb-3">
              <label for="data[item]" class="form-label">Item <span class="text-danger">*</span></label>
              <select name="data[item]" class="form-control text-capitalize" required="">
                <option selected disabled value="">Select the item</option>
                <?php
                if (!empty(FORM_DATA['item_type']))
                {
                  foreach (FORM_DATA['item_type'] as $type_key => $type_value)
                  {
                    echo "<option value='{$type_value}'>{$type_value}</option>";
                  }
                }
                ?>
              </select>
            </div>
            <!-- Price -->
            <div class="form-group col-12 mb-3">
              <label for="data[price]" class="form-label">Price <span class="text-danger">*</span></label>
              <small class="form-text text-muted">Price per Unit</small>
              <div class="input-group">
                <select class="form-control col-6 col-md-4 col-lg-3" name="data[price][currency]" required>
                  <option selected disabled value="">Currency</option>
                  <?php
                  if (!empty(FORM_DATA['currency']))
                  {
                    foreach (FORM_DATA['currency'] as $currency_key => $currency_value)
                    {
                      echo "<option value='{$currency_value}'>{$currency_value}</option>";
                    }
                  }
                  ?>
                </select>
                <input type="number" name="data[price][number]" class="form-control col-9" value="" min="0.01" step="0.01" placeholder="Price per Unit" required>
              </div>

            </div>
            <!-- Stock -->
            <div class="form-group col-12 mb-3">
              <label for="data[stock]" class="form-label">Stock <span class="text-danger">*</span></label>
              <select class="form-control text-capitalize" name="data[stock]">
                <?php
                if (!empty(FORM_DATA['stock']))
                {
                  foreach (FORM_DATA['stock'] as $stock_key => $stock_value)
                  {
                    echo "<option value='{$stock_value}'>{$stock_value}</option>";
                  }
                }
                ?>
              </select>
            </div>
            <!-- Remark -->
            <div class="form-group col-12 mb-3">
              <label for="data[price]" class="form-label">Remark</label>
              <input type="text" name="data[remark]" value="" class="form-control" placeholder="Write your own remark">
            </div>
          </div>
          <button id="mask_form_submit" type="submit" class="btn btn-primary m-t-30 mt-3">Submit</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-8">
    <div id="google_map_mask" style="min-height:500px;height:100%;width:100%"></div>
  </div>
</section>

<section class="row">
  <div class="col-12 mt-3">
    <div class="fb-comments" data-href="<?php echo current_url() ?>" data-width="100%" data-numposts="5"></div>
  </div>
</section>
