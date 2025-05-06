<section>
  <!-- Navigation menu -->
  <nav class="tweet-menu">
    <a href="/" class="active">Tweets</a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="/your-tweets">Your Tweets</a>
    <?php endif; ?>
  </nav>

  <!-- Form to create a tweet -->
  <?php if (isset($_SESSION['user_id'])): ?>
    <?php if (!empty($formErrors['general'])): ?>
      <div class="form-error">
        <?php echo htmlspecialchars($formErrors['general']); ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="/tweets/create" class="create-form">
      <div class="form-field">
        <label for="content">What's on your mind?</label>
        <textarea id="content" name="content" required maxlength="280" minlength="5"><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
        <?php if (isset($validator)): ?>
          <?php echo $validator->listErrors('content'); ?>
        <?php endif; ?>
      </div>
      <button type="submit">Tweet</button>
    </form>
  <?php endif; ?>

  <!-- List of tweets -->
  <?php if (empty($tweets)): ?>
    <p class="no-content">No tweets yet. Be the first!</p>
  <?php else: ?>
    <div class="tweets">
      <h1>Tweets</h1>
      <?php foreach ($tweets as $tweet): ?>
        <a class="tweet-link" href="/tweet/<?php echo $tweet['id']; ?>">
          <div class="tweet">
            <p><strong><?php echo htmlspecialchars($tweet['username']); ?></strong> <small><?php echo $tweet['created_at']; ?></small></p>
            <p><?php echo htmlspecialchars($tweet['content']); ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>