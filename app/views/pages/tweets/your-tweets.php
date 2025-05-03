<section>
  <!-- Navigation menu -->
  <nav class="tweet-menu">
    <a href="/">Tweets</a>
    <a href="/your-tweets" class="active">Your Tweets</a>
  </nav>

  <!-- List of user's tweets -->
  <h1>Your Tweets</h1>
  <?php if (empty($tweets)): ?>
    <p>You haven't posted any tweets yet.</p>
  <?php else: ?>
    <div class="tweets">
      <?php foreach ($tweets as $tweet): ?>
        <div class="tweet">
          <p><strong><?php echo htmlspecialchars($tweet['username']); ?></strong> <small><?php echo $tweet['created_at']; ?></small></p>
          <p><?php echo htmlspecialchars($tweet['content']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>