<?php
$this->load->view('maps');
?>
<p id="test"></p>
<script>
  var getFeature;
  var getCoordinates;
  create_map();
  document.getElementById('test').innerHTML = jalanLayer;
</script>