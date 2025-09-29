<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Cookies in Craigavon - Cookieland at 107 Baltylum Meadows</title>
    <meta name="description"
        content="Discover the best cookies in Craigavon at Cookieland. Located at 107 Baltylum Meadows, BT62 4BW, indulge in freshly baked cookies with unique and classic flavours. Visit us or order online today!">
    <meta name="keywords"
        content="cookies in Craigavon, best cookies Northern Ireland, Cookieland cookies, chocolate chip cookies, freshly baked cookies, 107 Baltylum Meadows, cookie shop, cookie delivery, cookies near me">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Best Cookies in Craigavon - Cookieland at 107 Baltylum Meadows">
    <meta property="og:description"
        content="Looking for the best cookies in Craigavon? Visit Cookieland at 107 Baltylum Meadows, BT62 4BW, for delicious freshly baked cookies. Perfect for takeaway or delivery.">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css?v=1.0') }}">
</head>

<body>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo">
                <div>
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo image">
                </div>
            </a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li><a href="#home" class="nav__link active-link">Home</a></li>
                    <li><a href="#sandwich" class="nav__link">Cookie Sandwiches</a></li>
                    <li><a href="#popular" class="nav__link">Cookies</a></li>
                    <li><a href="#delivery" class="nav__link">Delivery</a></li>
                    <li><a href="#contact" class="nav__link">Contact</a></li>
                    <li><a href="{{ route('admin.google.redirect') }}">Login com Google</a></li>
                </ul>
                <div class="nav__close" id="nav-close">
                    <i class="ri-close-large-line"></i>
                </div>
            </div>
            <div class="nav__toggle" id="nav-toggle">
                <i class="ri-apps-2-fill"></i>
            </div>
        </nav>
    </header>

    <main class="main">

        @if (session('message'))
            <div class="alert" style="margin:1rem 0;padding:.75rem;border:1px solid #ddd;border-radius:.5rem;">
                {{ session('message') }}
            </div>
        @endif


        <section class="home section" id="home">
            <div class="home__container container grid">
                <div class="home__data">
                    <h1 class="home__title">Love Every <br> Cookie</h1>
                    <p class="home__description">
                        Experience pure joy with handmade cookies! <br>
                        Open every Friday and Saturday from <br>
                        <span style="font-weight: bold;">6:30 PM</span> till
                        <span style="font-weight: bold;">10:00 PM</span>.
                        <br><br>
                        Just drop by or place your order online during these days. <br>
                        Choose from <span style="font-weight: bold;">11 irresistible flavours</span>, all crafted with
                        <span style="font-weight: bold;">100% natural ingredients</span> and baked to perfection.
                        <br><br>
                        Whether you love classic chocolate chip or crave something unique, we’ve got the perfect cookie
                        for you!
                        <br><br>
                        <span style="font-weight: bold;">Planning a party?</span> Let us know at least <span
                            style="font-weight: bold;">5 days in advance</span> to ensure everything is just right!
                        <br><br>
                        <span style="color: red; font-weight: bold; font-size: 1.1rem;">
                            Allergen Advice: May contain nuts, peanuts, sesame.
                        </span>
                    </p>
                    <a href="#popular" class="button">Order Now!</a>
                    <img src="{{ asset('assets/img/sticker-pepi.svg') }}" alt="image of a delicious cookie"
                        class="home__sticker">
                </div>
                <div class="home__images">
                    <img src="{{ asset('assets/img/home-removebg-preview.png') }}" alt="image" class="home__burger">
                    <img src="{{ asset('assets/img/avela.png') }}" style="display: none;" alt="image"
                        class="home__ingredient home__potato-1">
                    <img src="{{ asset('assets/img/avela.png') }}" style="display: none;" alt="image"
                        class="home__ingredient home__potato-2">
                    <img src="{{ asset('assets/img/oreo.png') }}" style="display: none;" alt="image"
                        class="home__ingredient home__tomato-1">
                    <img src="{{ asset('assets/img/oreo.png') }}" style="display: none;" alt="image"
                        class="home__ingredient home__tomato-2">
                    <img src="{{ asset('assets/img/pistache.png') }}" style="display: none;" alt="image"
                        class="home__ingredient home__lettuce-1">
                    <img src="{{ asset('assets/img/chocolate.png') }}" style="display: none;" alt="image"
                        class="home__ingredient home__lettuce-2">
                </div>
            </div>
        </section>

        <section class="popular section" id="sandwich">
            <h2 class="section__title">Sandwich <br> Cookies</h2>
            <h4 class="section__notice">⚠️ Pre-order required until Thursday. Orders placed after Thursday will not be
                accepted.</h4>
            <div class="popular__container container grid">
                <article class="popular__card" data-sku="love-sandwich">
                    <span class="badge badge--new">NEW</span>
                    <img src="{{ asset('assets/img/sandu-love.jpg') }}"
                        alt="Love Sandwich - Red Velvet with Vanilla & Strawberry Brigadeiro" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Love Sandwich</h2>
                    <span class="popular__price">£3.50</span>
                    <button class="note-toggle" aria-expanded="false" aria-controls="note-sandwich-ninho">
                        <i class="ri-alert-line" aria-hidden="true"></i>
                        Important: coating preference
                        <i class="ri-arrow-down-s-line chevron" aria-hidden="true"></i>
                    </button>
                    <div class="note-panel" id="note-sandwich-ninho" hidden>
                        You can ask to have the sandwich cookie <em>coated in milk powder (Ninho)</em> or
                        <em>plain</em>. Add your preference in <strong>Observations</strong>.
                    </div>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card" data-sku="ninho-sandwich">
                    <span class="badge badge--new">NEW</span>
                    <img src="{{ asset('assets/img/sandu-ninho.jpg') }}"
                        alt="Ninho Sandwich - Milk Powder Brigadeiro with Nutella" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Ninho Sandwich</h2>
                    <span class="popular__price">£3.50</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card" data-sku="chocolate-sandwich">
                    <span class="badge badge--new">NEW</span>
                    <img src="{{ asset('assets/img/sandu-choco.jpg') }}"
                        alt="Chocolate Sandwich - Chocolate Brigadeiro with Chips" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Chocolate Sandwich</h2>
                    <span class="popular__price">£3.50</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card" data-sku="duo-sandwich">
                    <span class="badge badge--new">NEW</span>
                    <img src="{{ asset('assets/img/sandu-duo.jpg') }}"
                        alt="Duo Sandwich - Half Chocolate Brigadeiro, Half Ninho Brigadeiro" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Duo Sandwich</h2>
                    <span class="popular__price">£3.50</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card" data-sku="pistachio-sandwich">
                    <span class="badge badge--new">NEW</span>
                    <img src="{{ asset('assets/img/sandu-pista.jpg') }}"
                        alt="Pistachio Sandwich - Pistachio Cookie with Pistachio Brigadeiro" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Pistachio Sandwich</h2>
                    <span class="popular__price">£3.50</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>
            </div>
        </section>

        <section class="popular section" id="popular">
            <h2 class="section__title">Most Loved <br> Cookies</h2>
            <div class="popular__container container grid">
                <article class="popular__card" data-sku="golden-bites">
                    <span class="badge badge--new">NEW</span>
                    <img src="{{ asset('assets/img/new-product-2.jpg') }}"
                        alt="The golden bites: Box Special with Kinder, Nutella & Lotus" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">The golden bites</h2>
                    <span class="popular__price">£12.50</span>
                    <button class="note-toggle" aria-expanded="false" aria-controls="note-golden-bites">
                        <i class="ri-alert-line" aria-hidden="true"></i>
                        Important: flavour selection
                        <i class="ri-arrow-down-s-line chevron" aria-hidden="true"></i>
                    </button>
                    <div class="note-panel" id="note-golden-bites" hidden>
                        If you’d like all 3 cookies in the same flavour, add it in <strong>Observations</strong>. e.g.
                        “Box Special: only Nutella”.
                    </div>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card" data-sku="pot-classic-nutella">
                    <span class="badge badge--new">NEW</span>
                    <img src="{{ asset('assets/img/new-product-1.jpg') }}" alt="Pot Classic Cookies with Nutella"
                        class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Pot Classic Cookies with Nutella</h2>
                    <span class="popular__price">£4.00</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card" data-sku="pot-classic-nutella">
                    <span class="badge badge--new">NEW</span>
                    <img src="{{ asset('assets/img/alpino_black.jpg') }}" alt="Alpino Black" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Alpino Black</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-lutus.jpg') }}" alt="Lotus Cookie" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Lotus Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-lindt.jpg') }}" alt="Lindt Cookie" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Lindt Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-oreo.jpg') }}" alt="Oreo Cookie" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Oreo Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-cacau.jpg') }}" alt="100% Cocoa Cookie"
                        class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">100% Cocoa Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-kitkat.jpg') }}" alt="KitKat Cookie" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">KitKat Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-churro.jpg') }}" alt="Churro Cookie" class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Churro Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-tradicional.jpg') }}" alt="Traditional Cookie"
                        class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Traditional Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-avela.jpg') }}" alt="Kinder Bueno Cookie"
                        class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Kinder Bueno Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-ganache.jpg') }}" alt="Red Velvet Cookie"
                        class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Red Velvet Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-nutella.jpg') }}" alt="Nutella Cookie"
                        class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Nutella Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>

                <article class="popular__card">
                    <img src="{{ asset('assets/img/cookie-pistache.jpg') }}" alt="Dubai Cookie"
                        class="popular__img">
                    <button class="info__button"><i class="ri-information-fill"></i></button>
                    <h2 class="popular__title">Dubai Cookie</h2>
                    <span class="popular__price">£2.70</span>
                    <button class="popular__button"><i class="ri-shopping-bag-3-fill"></i></button>
                </article>
            </div>
        </section>

        <div id="info-modal" class="cart-modal">
            <div class="cart-modal-content">
                <span id="close-info-modal" class="close">&times;</span>
                <div id="info-modal-content">
                    <img id="info-modal-img" src="" alt="Item Image" class="info-modal-img">
                    <h2 id="info-modal-title"></h2>
                    <p id="info-modal-description"></p>
                </div>
            </div>
        </div>

        <section class="delivery section" id="delivery">
            <div class="delivery__container container grid">
                <div class="delivery__data">
                    <h2 class="section__title">Fast Delivery</h2>
                    <p class="delivery__description">
                        Order your favourite cookies from Cookieland, and we’ll have them delivered to your doorstep in
                        no time. Make or oder now and satisfy your cravings!
                    </p>
                    <a href="#popular" class="button">Order Now</a>
                    <img src="{{ asset('assets/img/sticker-glass.svg') }}" alt="image glass"
                        class="delivery__sticker">
                </div>
                <img src="{{ asset('assets/img/delivery-cookie.png') }}" alt="image burger" class="delivery__img">
            </div>
        </section>

        <section class="contact section" id="contact">
            <div class="contact__container container grid">
                <h2 class="section__title">Contact Now</h2>
                <div class="contact__content grid">
                    <div class="contact__data grid">
                        <div>
                            <h3 class="contact__title">Write Us</h3>
                            <div class="contact__social">
                                <a href="https://api.whatsapp.com/send?phone=447850988160&text=Hello, I need more information!"
                                    target="_blank">
                                    <i class="ri-whatsapp-fill" style="color: hsla(130, 23%, 58%, 0.65);"></i>
                                </a>
                                <a href="https://www.instagram.com/cookieland202?utm_source=qr&igsh=MWtheXppaHJwZ2o1Zg%3D%3D"
                                    target="_blank">
                                    <i class="ri-instagram-fill" style="color: hsla(296, 23%, 58%, 0.65);"></i>
                                </a>
                                <a href="https://www.tiktok.com/@cookieland2025?_t=ZN-8x4KVpRxfwk&_r=1"
                                    target="_blank">
                                    <i class="ri-tiktok-fill" style="color: hsla(200, 23%, 58%, 0.65);"></i>
                                </a>
                                <a href="https://www.facebook.com/share/1BFaRgQPDL/" target="_blank">
                                    <i class="ri-facebook-fill" style="color: hsla(220, 37%, 56%, 0.65);"></i>
                                </a>
                            </div>
                        </div>

                        <div>
                            <h3 class="contact__title">Call Us</h3>
                            <address class="contact__info">+44 7850-988160</address>
                        </div>

                        <div>
                            <h3 class="contact__title">Find us here</h3>
                            <address class="contact__info">
                                107 Baltylum Meadows, Portadown, Craigavon <br>
                                BT62 4BW <br>
                                Armagh, Northern Ireland
                            </address>
                        </div>
                    </div>

                    <div class="contact__image">
                        <img src="{{ asset('assets/img/contact-man.png') }}" alt="image contact man"
                            class="contact__img">
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer__container container grid">
            <a href="\" class="footer__logo">Cookieland's</a>
            <div class="footer__content">
                <a href="{{ route('site.terms') }}" class="footer__link">Terms & Agreements</a>
                <a href="{{ route('site.privacy') }}" class="footer__link">Privacy Policy</a>

                <div class="footer__social">
                    <a href="https://api.whatsapp.com/send?phone=447850988160&text=Hello, I need more information!"
                        target="_blank">
                        <i class="ri-whatsapp-fill" style="color: hsla(130, 23%, 58%, 0.65);"></i>
                    </a>
                    <a href="https://www.instagram.com/cookieland202?utm_source=qr&igsh=MWtheXppaHJwZ2o1Zg%3D%3D"
                        target="_blank">
                        <i class="ri-instagram-fill" style="color: hsla(296, 23%, 58%, 0.65);"></i>
                    </a>
                    <a href="https://www.tiktok.com/@cookieland2025?_t=ZN-8x4KVpRxfwk&_r=1" target="_blank">
                        <i class="ri-tiktok-fill" style="color: hsla(200, 23%, 58%, 0.65);"></i>
                    </a>
                    <a href="https://www.facebook.com/share/1BFaRgQPDL/" target="_blank">
                        <i class="ri-facebook-fill" style="color: hsla(220, 37%, 56%, 0.65);"></i>
                    </a>
                </div>
            </div>
            <div class="footer__badge">
                <img src="{{ asset('assets/img/foodRating.png') }}" alt="Food Hygiene Rating"
                    class="footer__badge-img">
            </div>
        </div>
        <span class="footer__copy">&#169; All Rights Reserved By Guilherme Baltazar</span>
    </footer>

    <a class="scrollup" id="cart-icon">
        <i class="ri-shopping-bag-3-fill"></i>
        <span id="cart-count" class="cart-count">0</span>
    </a>

    <div id="status-modal" class="cart-modal">
        <div class="cart-modal-content">
            <span id="close-status-modal" class="close">&times;</span>
            <h2 id="status-modal-title">We are currently closed</h2>
            <p id="status-modal-description">
                Our opening hours are from <strong>6:30 PM</strong> to <strong>10:00 PM</strong> on Fridays and
                Saturdays. Please visit us during these times.
            </p>
        </div>
    </div>

    <div id="cart-modal" class="cart-modal">
        <div class="cart-modal-content">
            <span id="close-modal" class="close">&times;</span>
            <h2>Your Cart</h2>
            <div id="cart-items" class="cart-items"></div>
            <div class="cart-total">
                <h3>Total: £<span id="cart-total">0</span></h3>
            </div>

            <div class="cart-form" id="form-step-1">
                <label for="customer-name">Name:</label>
                <input type="text" id="customer-name" placeholder="Your Name" required>
                <label for="customer-address">Address:</label>
                <input type="text" id="customer-address" placeholder="Your Address" required>
                <label for="service-type">Service Type:</label>
                <select id="service-type">
                    <option value="none">Choose</option>
                    <option value="Pick-up">Pick-up</option>
                    <option value="Delivery">Delivery</option>
                </select>

                <div id="delivery-location" style="display: none;">
                    <label for="delivery-location-select">Select your city:</label>
                    <p id="status-modal-description" style="padding: 0.3rem;">
                        The <strong>limit is 25 miles.</strong> However, exceeding this limit will incur an
                        <strong>additional</strong> charge of <strong>£2 per mile.</strong>
                    </p>
                    <select id="delivery-location-select">
                        <option value="Portadown">Portadown - £3</option>
                        <option value="Lugan">Lugan - £5</option>
                        <option value="Craigavon">Craigavon - £4</option>
                        <option value="Dungannon">Dungannon - £30</option>
                        <option value="Belfast">Belfast - £30</option>
                        <option value="Other">Other locations</option>
                    </select>
                </div>

                <div id="delivery-day" style="display: none;">
                    <label for="delivery-day-select">Choose a delivery day:</label>
                    <select id="delivery-day-select">
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                </div>

                <div id="delivery-time" style="display: none;">
                    <label for="delivery-time-select">Choose a delivery time:</label>
                    <select id="delivery-time-select"></select>
                </div>

                <div id="pickup-day" style="display: none;">
                    <label for="pickup-day-select">Choose a pick-up day:</label>
                    <select id="pickup-day-select">
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                </div>

                <div id="pickup-time" style="display: none;">
                    <label for="pickup-time-select">Choose a pick-up time:</label>
                    <select id="pickup-time-select"></select>
                </div>

                <label for="payment-method">Payment Method:</label>
                <select id="payment-method">
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Cash">Cash</option>
                </select>

                <label for="customer-observation">Observation:</label>
                <textarea id="customer-observation" placeholder="Any details you want to mention..."></textarea>
                <button id="next-step" class="order-button">Next</button>
            </div>

            <div class="cart-form" id="form-step-2" style="display: none;">
                <p id="status-modal-description" style="padding: 0.3rem;">
                    <strong>Drinks</strong>
                </p>
                <div id="drinks">
                    <div class="addon-item cart-item" style="flex-direction: row;">
                        <img src="{{ asset('assets/img/coke.png') }}" alt="Coke" class="addon-img">
                        <span>Coke</span>
                        <span>£1.10</span>
                        <button class="addon-decrement" data-item="Coke">-</button>
                        <span class="addon-quantity" data-item="Coke">0</span>
                        <button class="addon-increment" data-item="Coke">+</button>
                    </div>
                    <div class="addon-item cart-item" style="flex-direction: row;">
                        <img src="{{ asset('assets/img/fanta-laranja.png') }}" alt="Fanta" class="addon-img">
                        <span>Fanta</span>
                        <span>£1.10</span>
                        <button class="addon-decrement" data-item="Fanta">-</button>
                        <span class="addon-quantity" data-item="Fanta">0</span>
                        <button class="addon-increment" data-item="Fanta">+</button>
                    </div>
                </div>

                <p id="status-modal-description" style="padding: 0.3rem; display: none;">
                    <strong>Add-ons</strong>
                </p>
                <div id="cream-cheese" class="addon-section" style="display: none;">
                    <div class="addon-item cart-item">
                        <img src="{{ asset('assets/img/cream_cheese.png') }}" alt="Fanta" class="addon-img">
                        <span>Catupiry</span>
                        <span>£2.0</span>
                        <button class="addon-decrement" data-item="Catupiry">-</button>
                        <span class="addon-quantity" data-item="Catupiry">0</span>
                        <button class="addon-increment" data-item="Catupiry">+</button>
                    </div>
                    <div class="addon-item cart-item">
                        <img src="{{ asset('assets/img/nutella.png') }}" alt="Fanta" class="addon-img">
                        <span>Nutella Border</span>
                        <span>£2.0</span>
                        <button class="addon-decrement" data-item="Nutella Border">-</button>
                        <span class="addon-quantity" data-item="Nutella Border">0</span>
                        <button class="addon-increment" data-item="Nutella Border">+</button>
                    </div>
                    <textarea id="cream-cheese-observation" placeholder="Specify pizzas for Catupiry and Nutella Border"
                        style="margin-top: 1rem; display: block;margin-bottom: 1rem;"></textarea>
                </div>

                <button id="submit-order" class="order-button">Place Order</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js?v=1.0') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cartIcon = document.getElementById("cart-icon")
            const statusModal = document.getElementById("status-modal")
            if (cartIcon) cartIcon.style.display = "block"
            if (statusModal) statusModal.style.display = "none"
        })
        document.querySelectorAll(".note-toggle").forEach((btn) => {
            btn.addEventListener("click", () => {
                const panelId = btn.getAttribute("aria-controls")
                const panel = document.getElementById(panelId)
                const isOpen = btn.getAttribute("aria-expanded") === "true"
                btn.setAttribute("aria-expanded", String(!isOpen))
                if (panel) panel.hidden = isOpen
            })
        })
    </script>

</body>

</html>
