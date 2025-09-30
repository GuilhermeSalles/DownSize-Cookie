/* public/assets/js/totem.js
   Fluxo estilo totem:
   - Step 1: escolhe serviço (Pick-up ou Delivery). Se Delivery, pede endereço + cidade (calcula taxa).
   - Step 2: adiciona itens usando os botões dos cards (.add-to-cart).
   - Step 3: drinks (quantidades).
   - Step 4: review & "pay" (simulado), envia WhatsApp.
*/

(function () {
    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

    const openBtn = $("#kiosk-open");
    const modal = $("#kiosk-modal");
    const closeBtn = $("#kiosk-close");

    const steps = $$(".kiosk-step", modal);
    const panels = $$(".kiosk-panel", modal);

    const next1 = $("#kiosk-next-from-1");
    const next2 = $("#kiosk-next-from-2");
    const next3 = $("#kiosk-next-from-3");
    const payBtn = $("#kiosk-pay");

    const serviceChoices = $$(".kiosk-choice", modal);
    const deliveryForm = $("#kiosk-delivery-form");

    const addrInput = $("#kiosk-address");
    const citySelect = $("#kiosk-city");

    const drinksWrap = $("#kiosk-drinks");
    const summaryBox = $("#kiosk-summary");
    const paymentSelect = $("#kiosk-payment");
    const obsTextarea = $("#kiosk-observation");

    const cartCount = $("#cart-count");

    const KIOSK = {
        step: 1,
        service_type: null, // 'Pick-up' | 'Delivery'
        address: "",
        city: "",
        delivery_fee: 0,

        items: [], // {id, name, price, qty, note?, category}
        drinks: [], // {id, name, price, qty}

        payment_method: "Bank Transfer",
        observation: "",

        get subtotal() {
            const itemsTotal = this.items.reduce(
                (s, it) => s + it.price * it.qty,
                0
            );
            const drinksTotal = this.drinks.reduce(
                (s, it) => s + it.price * it.qty,
                0
            );
            return +(itemsTotal + drinksTotal).toFixed(2);
        },
        get total() {
            return +(
                this.subtotal +
                (this.service_type === "Delivery" ? this.delivery_fee : 0)
            ).toFixed(2);
        },
        syncBadge() {
            const totalQty =
                this.items.reduce((s, it) => s + it.qty, 0) +
                this.drinks.reduce((s, it) => s + it.qty, 0);
            if (cartCount) cartCount.innerText = String(totalQty);
        },
    };

    function goto(step) {
        KIOSK.step = step;
        steps.forEach((s) =>
            s.classList.toggle("is-active", Number(s.dataset.step) === step)
        );
        panels.forEach(
            (p) =>
                (p.style.display =
                    Number(p.dataset.panel) === step ? "block" : "none")
        );
    }

    function open() {
        modal.style.display = "block";
        goto(1);
    }
    function close() {
        modal.style.display = "none";
    }

    if (openBtn) openBtn.addEventListener("click", open);
    if (closeBtn) closeBtn.addEventListener("click", close);
    window.addEventListener("keydown", (e) => {
        if (e.key === "Escape") close();
    });

    // Step 1: escolha do serviço
    serviceChoices.forEach((btn) => {
        btn.addEventListener("click", () => {
            const type = btn.dataset.service;
            KIOSK.service_type = type;
            if (type === "Delivery") {
                deliveryForm.style.display = "block";
            } else {
                deliveryForm.style.display = "none";
                KIOSK.address = "";
                KIOSK.city = "";
                KIOSK.delivery_fee = 0;
            }
        });
    });

    next1.addEventListener("click", () => {
        if (!KIOSK.service_type) {
            alert("Please select Pick-up or Delivery.");
            return;
        }
        if (KIOSK.service_type === "Delivery") {
            const addr = (addrInput.value || "").trim();
            if (!addr) {
                alert("Please fill the delivery address.");
                addrInput.focus();
                return;
            }
            const city = citySelect.value;
            const fee = Number(
                citySelect.selectedOptions[0].dataset.fee || "0"
            );
            KIOSK.address = addr;
            KIOSK.city = city;
            KIOSK.delivery_fee = fee;
        }
        goto(2);
    });

    // Step 2: adicionar itens pelos cards da página
    $$(".add-to-cart").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const card = e.currentTarget.closest(".popular__card");
            if (!card) return;

            const id = Number(card.dataset.id);
            const name = card.dataset.name;
            const price = Number(card.dataset.price);
            const category = card.dataset.category;

            const existing = KIOSK.items.find((i) => i.id === id);
            if (existing) existing.qty += 1;
            else KIOSK.items.push({ id, name, price, qty: 1, category });

            KIOSK.syncBadge();
        });
    });

    $('[data-panel="2"] [data-back]')?.addEventListener("click", () => goto(1));
    next2.addEventListener("click", () => {
        if (KIOSK.items.length === 0) {
            if (!confirm("No items added. Continue anyway?")) return;
        }
        goto(3);
    });

    // Step 3: drinks
    function renderDrinkQty(el, qty) {
        const n = $(".kiosk-qty-num", el);
        if (n) n.textContent = String(qty);
    }
    $$(".kiosk-drink", drinksWrap).forEach((el) => {
        const id = Number(el.dataset.id);
        const name = el.dataset.name;
        const price = Number(el.dataset.price);

        const minus = $(".kiosk-minus", el);
        const plus = $(".kiosk-plus", el);

        minus.addEventListener("click", () => {
            let d = KIOSK.drinks.find((x) => x.id === id);
            if (!d) return;
            d.qty = Math.max(0, d.qty - 1);
            if (d.qty === 0)
                KIOSK.drinks = KIOSK.drinks.filter((x) => x.id !== id);
            renderDrinkQty(el, d.qty || 0);
            KIOSK.syncBadge();
        });

        plus.addEventListener("click", () => {
            let d = KIOSK.drinks.find((x) => x.id === id);
            if (!d) {
                d = { id, name, price, qty: 0 };
                KIOSK.drinks.push(d);
            }
            d.qty += 1;
            renderDrinkQty(el, d.qty);
            KIOSK.syncBadge();
        });
    });

    $('[data-panel="3"] [data-back]')?.addEventListener("click", () => goto(2));
    next3.addEventListener("click", () => {
        buildSummary();
        goto(4);
    });

    // Step 4: review + pagamento simulado + WhatsApp
    $('[data-panel="4"] [data-back]')?.addEventListener("click", () => goto(3));
    payBtn.addEventListener("click", () => {
        KIOSK.payment_method = paymentSelect.value;
        KIOSK.observation = obsTextarea.value || "";

        // Simula pagamento OK e envia WhatsApp
        const txt = buildWhatsMessage();
        const phone = (window.KIOSK_CFG && window.KIOSK_CFG.phone) || "";
        const link = `https://api.whatsapp.com/send?phone=${encodeURIComponent(
            phone
        )}&text=${encodeURIComponent(txt)}`;
        window.open(link, "_blank");

        // Limpa carrinho
        KIOSK.items = [];
        KIOSK.drinks = [];
        KIOSK.syncBadge();
        close();
    });

    function buildSummary() {
        const fmtMoney = (n) => `£${Number(n).toFixed(2)}`;
        let html = "";

        if (KIOSK.items.length) {
            html +=
                '<h3 class="kiosk-subtitle">Items</h3><ul class="kiosk-list">';
            KIOSK.items.forEach((it) => {
                html += `<li><span>${it.name} × ${
                    it.qty
                }</span><span>${fmtMoney(it.price * it.qty)}</span></li>`;
            });
            html += "</ul>";
        }

        if (KIOSK.drinks.length) {
            html +=
                '<h3 class="kiosk-subtitle">Drinks</h3><ul class="kiosk-list">';
            KIOSK.drinks.forEach((it) => {
                html += `<li><span>${it.name} × ${
                    it.qty
                }</span><span>${fmtMoney(it.price * it.qty)}</span></li>`;
            });
            html += "</ul>";
        }

        html += `<div class="kiosk-totals">
      <div><span>Subtotal</span><span>${fmtMoney(KIOSK.subtotal)}</span></div>
      ${
          KIOSK.service_type === "Delivery"
              ? `<div><span>Delivery</span><span>${fmtMoney(
                    KIOSK.delivery_fee
                )}</span></div>`
              : ""
      }
      <div class="kiosk-total"><span>Total</span><span>${fmtMoney(
          KIOSK.total
      )}</span></div>
    </div>`;

        summaryBox.innerHTML = html;
    }

    function buildWhatsMessage() {
        const fmtMoney = (n) => `£${Number(n).toFixed(2)}`;
        const lines = [];
        lines.push("*New order — Cookieland*");
        lines.push(`Service: ${KIOSK.service_type}`);

        if (KIOSK.service_type === "Delivery") {
            lines.push(`Address: ${KIOSK.address}`);
            lines.push(`City: ${KIOSK.city}`);
            lines.push(`Delivery fee: ${fmtMoney(KIOSK.delivery_fee)}`);
        }

        if (KIOSK.items.length) {
            lines.push("");
            lines.push("*Items*");
            KIOSK.items.forEach((i) =>
                lines.push(
                    `- ${i.name} × ${i.qty} = ${fmtMoney(i.price * i.qty)}`
                )
            );
        }

        if (KIOSK.drinks.length) {
            lines.push("");
            lines.push("*Drinks*");
            KIOSK.drinks.forEach((i) =>
                lines.push(
                    `- ${i.name} × ${i.qty} = ${fmtMoney(i.price * i.qty)}`
                )
            );
        }

        lines.push("");
        lines.push(`Subtotal: ${fmtMoney(KIOSK.subtotal)}`);
        if (KIOSK.service_type === "Delivery") {
            lines.push(`Delivery: ${fmtMoney(KIOSK.delivery_fee)}`);
        }
        lines.push(`*Total: ${fmtMoney(KIOSK.total)}*`);

        lines.push("");
        lines.push(`Payment: ${KIOSK.payment_method}`);
        if ((KIOSK.observation || "").trim()) {
            lines.push("");
            lines.push("*Observations*");
            lines.push(KIOSK.observation.trim());
        }
        lines.push("");
        lines.push("— sent via Cookieland website");

        return lines.join("\n");
    }

    // Abre automaticamente o carrinho (ícone flutuante já abre)
    // document.addEventListener('DOMContentLoaded', open); // desabilitado
})();
