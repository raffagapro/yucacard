
<nav class="navbar navbar-expand-lg navbar-dark bg-dark flex flex-end">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <?php
        if ($_SESSION['access'] == 0) {
          echo '
          <a class="nav-item nav-link" href="admin_panel.php">Admin Panel</a>
          <a class="nav-item nav-link" href="add_user_form.php">Add User</a>
          <a class="nav-item nav-link" href="add_city_form.php">Add City</a>
          ';
        } else {
          echo '<a class="nav-item nav-link" href="dashboard.php">Dashboard</a>';
        }
      ?>
      <a class="nav-item nav-link" href="add_afiliado_form.php">Add Afiliado</a>
      <a class="nav-item nav-link" href="buy_giftCard_form.php">Buy GiftCard</a>
      <a class="nav-item nav-link" href="includes/logout.inc.php">Log out</a>
    </div>
  </div>
</nav>
