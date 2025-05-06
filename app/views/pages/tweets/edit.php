<?php if (!empty($formErrors['general'])): ?>
  <div class="form-error">
    <?php echo htmlspecialchars($formErrors['general']); ?>
  </div>
<?php endif; ?>
<form class="edit-form" method="POST" action="/tweets/edit/<?php echo $tweet['id']; ?>">
  <h2>Edit Tweet</h2>
  <textarea name="content" rows="4" cols="50" minlength="5" maxlength="280"><?php echo htmlspecialchars($tweet['content'] ?? ''); ?></textarea><br>
  <?php if (isset($validator)): ?>
    <?php echo $validator->listErrors('content'); ?>
  <?php endif; ?>
  <button type="submit">Update Tweet</button>
</form>