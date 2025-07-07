<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($title)) {
    $title = 'Default Title';
}
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/layout/header.php';
?>
<!-- CONTENT -->
<div id="content">
    <?php if (isset($content)) { echo $content; } else { echo '<div style="color:red">Konten tidak ditemukan (variabel $content kosong)</div>'; } ?>
</div>
<!-- END CONTENT -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/layout/footer.php'; ?>