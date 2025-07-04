<?php
if (!isset($title)) {
    $title = 'Default Title';
}
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/layout/header.php';
?>
<!-- CONTENT -->
<div id="content">
    <?php if (isset($content)) { echo $content; } ?>
</div>
<!-- END CONTENT -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/layout/footer.php'; ?>