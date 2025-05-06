<section>
  <!-- Navigation menu -->
  <nav class="tweet-menu">
    <a href="/">Tweets</a>
    <a href="/your-tweets" class="active">Your Tweets</a>
  </nav>

  <!-- List of user's tweets -->
  <?php if (empty($tweets)): ?>
    <p class="no-content">You haven't posted any tweets yet.</p>
  <?php else: ?>
    <div class="tweets">
      <h1>Your Tweets</h1>
      <?php foreach ($tweets as $tweet): ?>
        <a class="tweet-link" href="/tweet/<?php echo $tweet['id']; ?>">
          <div class="tweet">
            <p class="tweet-header"><strong><?php echo htmlspecialchars($tweet['username']); ?></strong> <small><?php echo $tweet['created_at']; ?></small></p>
            <p class="tweet-content"><?php echo htmlspecialchars($tweet['content']); ?></p>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $tweet['user_id']): ?>
              <a class="button" href="/tweets/edit/<?php echo $tweet['id']; ?>">Edit</a>
              <form action="/tweets/delete/<?php echo $tweet['id']; ?>" method="POST" style="display:inline;">
                <button class="button" type="submit" onclick="return confirm('Are you sure you want to delete this tweet?');">Delete</button>
              </form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>