<section class="register">
  <h1>Register</h1>
  <?php if (!empty($errors['general'])): ?>
    <div class="form-error">
      <?php echo htmlspecialchars($errors['general']); ?>
    </div>
  <?php endif; ?>
  <form method="POST" action="/register" class="register-form">
    <div>
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
      <?php echo $validator->listErrors('username'); ?>
    </div>
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
    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="/login">Login</a></p>
</section>