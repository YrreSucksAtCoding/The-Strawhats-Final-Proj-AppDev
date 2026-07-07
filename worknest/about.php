<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>

<section class="wn-hero">
    <div class="container">
        <h1>About WorkNest</h1>
        <p>Furniture and equipment for workspaces that actually work.</p>
    </div>
</section>

<div class="container">
    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <h2 class="wn-page-title">Our company</h2>
            <p>
                WorkNest is a fictional office equipment retailer created as a final project for our
                web development course. The store carries ergonomic chairs, desks and tables, storage
                solutions, and desk accessories for home offices and small businesses.
            </p>
            <p>
                The site demonstrates a complete buyer flow (registration with email verification,
                browsing, cart, checkout, and payment) and a seller flow (user management, inventory
                management, and reports with an audit log), built with PHP, MySQL, and Bootstrap 5.
            </p>
        </div>
        <div class="col-lg-5">
            <h2 class="wn-page-title">The Strawhats</h2>
            <ul class="list-group">
                <li class="list-group-item d-flex align-items-center">
                    <img src="<?php echo BASE_URL; ?>/assets/img/members/yrre.jpg" alt="Yrre" class="wn-member-photo me-3">
                    <div><strong>Yrre Suguitan</strong> &mdash; Backend &amp; database</div>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <img src="<?php echo BASE_URL; ?>/assets/img/members/ains.jpg" alt="Ains" class="wn-member-photo me-3">
                    <div><strong>Ains Gonzaga</strong> &mdash; Frontend &amp; design</div>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
