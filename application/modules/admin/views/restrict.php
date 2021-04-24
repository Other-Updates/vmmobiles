<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<html>
<body>
<!-- <center><h2>Access Forbidden</h2><center> -->
<img style="width:100%;" id="image" src="<?= $theme_path; ?>/images/access-deny.jpg" alt="access denied">
</body>
</html>