<?php
if (!isset($title)) {
    $title = 'Default Title';
}
include __DIR__ . '/layout/header.php';
?>
<!-- CONTENT -->
<div id="content">
    <?php if (isset($content)) { echo $content; } ?>
</div>
<!-- END CONTENT -->
<?php include __DIR__ . '/layout/footer.php'; ?>