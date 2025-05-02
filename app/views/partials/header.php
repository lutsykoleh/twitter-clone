<header>
  <nav>
    <a href="/">Twitter Clone</a>
    <ul>
      <li><a href="/">Tweets</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="/logout">Logout</a></li>
      <?php else: ?>
        <li><a href="/register">Register</a></li>
        <li><a href="/login">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>