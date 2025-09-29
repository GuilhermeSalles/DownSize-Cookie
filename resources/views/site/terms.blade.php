<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terms & Conditions - Cookieland</title>
  <meta name="description" content="Discover the best cookies in Craigavon at Cookieland. Located at 107 Baltylum Meadows, BT62 4BW, indulge in freshly baked cookies with unique and classic flavours. Visit us or order online today!">
  <meta name="keywords" content="cookies in Craigavon, best cookies Northern Ireland, Cookieland cookies, chocolate chip cookies, freshly baked cookies, 107 Baltylum Meadows, cookie shop, cookie delivery, cookies near me">
  <meta name="robots" content="index, follow">
  <meta property="og:title" content="Best Cookies in Craigavon - Cookieland at 107 Baltylum Meadows">
  <meta property="og:description" content="Looking for the best cookies in Craigavon? Visit Cookieland at 107 Baltylum Meadows, BT62 4BW, for delicious freshly baked cookies. Perfect for takeaway or delivery.">
  <meta property="og:image" content="https://cookieland.uk/assets/img/cookie-banner.jpg">
  <meta property="og:url" content="https://cookieland.uk">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Cookieland">
  <meta property="og:locale" content="en_GB">
  <meta name="geo.placename" content="107 Baltylum Meadows, BT62 4BW, Craigavon, Northern Ireland">
  <meta name="geo.region" content="GB">
  <meta name="geo.position" content="54.4339;-6.3846">
  <meta name="ICBM" content="54.4339, -6.3846">
  <link rel="shortcut icon" href="{{ asset('assets/img/icon.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
</head>
<body>
  <header class="header" id="header">
    <nav class="nav container">
      <a href="{{ route('site.home') }}" class="nav__logo">
        <div><img src="{{ asset('assets/img/logo.png') }}" alt="Cookieland Logo"></div>
      </a>
      <div class="nav__menu" id="nav-menu">
        <ul class="nav__list">
          <li><a href="{{ route('site.home') }}" class="nav__link">Home</a></li>
          <li><a href="{{ route('site.home') }}#popular" class="nav__link">Cookies</a></li>
          <li><a href="{{ route('site.home') }}#delivery" class="nav__link">Delivery</a></li>
          <li><a href="{{ route('site.home') }}#contact" class="nav__link">Contact</a></li>
        </ul>
        <div class="nav__close" id="nav-close"><i class="ri-close-large-line"></i></div>
      </div>
      <div class="nav__toggle" id="nav-toggle"><i class="ri-apps-2-fill"></i></div>
    </nav>
  </header>

  <main class="main">
    <section class="legal section" id="legal">
      <div class="legal__container container">
        <h1 class="section__title">Terms & Conditions</h1>
        <div class="legal__content">
          <div class="legal__card">
            <h2><i class="ri-cookie-line"></i> Orders & Payments</h2>
            <p>All orders are subject to availability. We reserve the right to refuse any order.</p>
            <p>Payment must be made in full at the time of ordering via bank transfer or cash on collection.</p>
          </div>
          <div class="legal__card">
            <h2><i class="ri-truck-line"></i> Delivery & Collection</h2>
            <p>Delivery is available within 25 miles of BT62 4BW for a standard fee of £5.</p>
            <p>Collection is available Fridays and Saturdays from 6:30 PM to 10:00 PM.</p>
          </div>
          <div class="legal__card">
            <h2><i class="ri-arrow-go-back-line"></i> Returns & Refunds</h2>
            <p>Due to the perishable nature of our products, we cannot accept returns.</p>
            <p>Refunds are given at our discretion for unsatisfactory products.</p>
          </div>
          <div class="legal__card">
            <h2><i class="ri-cake-line"></i> Party Orders</h2>
            <p>Party orders require at least 5 days notice.</p>
            <p>A 50% deposit may be required for large orders.</p>
          </div>
          <div class="legal__card">
            <h2><i class="ri-information-line"></i> General</h2>
            <p>We reserve the right to modify these terms at any time.</p>
            <p>Last updated: 01/01/2023</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="footer__container container grid">
      <a href="{{ route('site.home') }}" class="footer__logo">Cookieland's</a>
      <div class="footer__content">
        <a href="{{ route('site.terms') }}" class="footer__link">Terms & Agreements</a>
        <a href="{{ route('site.privacy') }}" class="footer__link">Privacy Policy</a>
        <div class="footer__social">
          <a href="https://api.whatsapp.com/send?phone=447850988160&text=Hello, I need more information!" target="_blank"><i class="ri-whatsapp-fill" style="color: hsla(130, 23%, 58%, 0.65);"></i></a>
          <a href="https://www.instagram.com/cookieland202?utm_source=qr&igsh=MWtheXppaHJwZ2o1Zg%3D%3D" target="_blank"><i class="ri-instagram-fill" style="color: hsla(296, 23%, 58%, 0.65);"></i></a>
          <a href="https://www.tiktok.com/@cookieland2025?_t=ZN-8x4KVpRxfwk&_r=1" target="_blank"><i class="ri-tiktok-fill" style="color: hsla(200, 23%, 58%, 0.65);"></i></a>
          <a href="https://www.facebook.com/share/1BFaRgQPDL/" target="_blank"><i class="ri-facebook-fill" style="color: hsla(220, 37%, 56%, 0.65);"></i></a>
        </div>
      </div>
      <div class="footer__badge">
        <img src="{{ asset('assets/img/foodRating.png') }}" alt="Food Hygiene Rating" class="footer__badge-img">
      </div>
    </div>
    <span class="footer__copy">&#169; All Rights Reserved By Guilherme Baltazar</span>
  </footer>

  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
