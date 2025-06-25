document.addEventListener('DOMContentLoaded', async () => {
    const interactionToken = await browser.sessionStorage.getItem(
        "frak-wallet-interaction-token"
    );
    if (!interactionToken) {
        return;
    }

    const frakOrderData = document.getElementById('frak-order-data');
    if (!frakOrderData) {
        return;
    }

    const customerId = frakOrderData.dataset.customerId;
    const orderId = frakOrderData.dataset.orderId;
    const token = frakOrderData.dataset.token;

    if (!customerId || !orderId || !token) {
        console.log('[FRAK] Missing required fields in order data');
        return;
    }

    const payload = {
        customerId,
        orderId,
        token,
    };

    fetch(`${window.FrakSetup.config.backendHost}/interactions/listenForPurchase`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'x-wallet-sdk-auth': interactionToken,
        },
        body: JSON.stringify(payload),
        keepalive: true,
    });
});
