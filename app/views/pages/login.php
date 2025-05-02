<section>
  <h1>Login</h1>
  <?php if (!empty($formErrors['general'])): ?>
    <div class="form-error">
      <?php echo htmlspecialchars($formErrors['general']); ?>
    </div>
  <?php endif; ?>
  <form method="POST" action="/login">
    <div>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
      <?php echo $validator->listErrors('email'); ?>
    </div>
    <div>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <?php echo $validator->listErrors('password'); ?>
    </div>
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="/register">Register</a></p>
</section>