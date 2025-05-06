<section class="tweet-page">
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
</section>