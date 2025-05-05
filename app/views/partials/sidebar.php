<aside class="sidebar">
  <nav class="main-nav">
    <img src="/images/icon.svg" alt="Logo" class="logo">
    <ul class="menu">
      <li><a href="/">Home</a></li>
    </ul>
  </nav>

  <nav class="user-nav">
    <ul class="menu">
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="#" class="btn" id="create-tweet-btn">Create Tweet</a></li>
        <li><a href="/logout">Logout</a></li>
      <?php else: ?>
        <li><a href="/register">Register</a></li>
        <li><a href="/login">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <!-- Pop-up form -->
  <div id="tweet-popup" class="popup">
    <div class="popup-content">
      <span id="close-popup" class="close">×</span>
      <h2>Create Tweet</h2>
      <form id="tweet-form" method="POST" action="/tweets/create">
        <div>
          <label for="content">What's on your mind?</label>
          <textarea id="content" name="content" required maxlength="280" minlength="5"></textarea>
          <div id="content-errors" class="validation-errors"></div>
        </div>
        <button type="submit">Tweet</button>
      </form>
    </div>
  </div>
</aside>