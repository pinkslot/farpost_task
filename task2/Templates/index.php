<?php
  $app = app\App\App::Instance();
?>

<!DOCTYPE html>
<html>
<head>
  <?php include 'header.php'?>
  <title> Index | <?= $args['site']; ?></title>
</head>
<body>
<?php include 'layout_auth_bar.php'?>

<?php if ($app->user): ?>
  <form id="index-form" method="POST" action="/upload" enctype="multipart/form-data">
    <div class="form-group">
      <label class="control-label" for="index-files">Select images</label>
      <input
        type="file"
        id="index-files"
        class="form-control"
        name="imgs[]"
        aria-required="1"
        multiple
      >
    </div>
    <button class="btn btn-default">Submit</button>
    <iframe id="index-hack_frame" name="hack_frame" src="" class="hidden"></iframe>
  </form>
  <br/>
  <div id="index-errors"></div>
  <div id="index-imgs">
    <?php foreach ($args['imgs'] as $img): ?>
      <a target="_blank" href="<?= $img ?>">
        <img src="<?= $img ?>" height="100"/>
      </a>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  Login to upload images.
<?php endif; ?>
</body>
</html>
