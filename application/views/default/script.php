<?php defined('BASEPATH') or die('Unauthorized Access'); ?>
<!-- GLOBAL JS VARRIABLE -->
<script type="text/javascript">
var base_url = "<?php echo base_url() ?>";
var mask_form_processing = false;
</script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="<?php echo base_url("assets/plugin/") ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-notify@3.1.3/bootstrap-notify.min.js" integrity="sha256-DRllCE/8rrevSAnSMWB4XO3zpr+3WaSuqUSNLD5NAzg=" crossorigin="anonymous"></script>
<!-- ApexCharts  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.16.1/apexcharts.min.js" integrity="sha256-t1PGu7L/PEJSDZD5hdyz1XcowWvxN0rPtSeWz1R2G08=" crossorigin="anonymous"></script>
<!-- peity loader -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/peity/3.3.0/jquery.peity.min.js" integrity="sha256-B+xyblmehefmEUu8NIsuz32NsVFta9t+Y/SpAy6noc4=" crossorigin="anonymous"></script>
<!-- Tabler Core -->
<script src="<?php echo base_url("assets/js/") ?>tabler.min.js"></script>
<script src="<?php echo base_url("assets/js/custom/") ?>function.js"></script>
<!-- Layout JS -->
<?php
if (!empty($script_custom))
{
  foreach ($script_custom as $script_value)
  {
    echo "<script src='{$script_value}'></script>";
  }
}
?>
<!-- Alert  -->
<script type="text/javascript">
<?php
// SYSTEM ALERT NOTIFICATION
if (!empty($_SESSION['system_alert']))
{
  foreach ($_SESSION['system_alert'] as $key => $value)
  {
    echo "beero_alert('{$value['system_alert_title']}','{$value['system_alert_message']}','{$value['system_alert_state']}','{$value['system_alert_delay']}');";
  }
}
?>
</script>
<script>
document.body.style.display = "block"
</script>
<script type="text/javascript">
