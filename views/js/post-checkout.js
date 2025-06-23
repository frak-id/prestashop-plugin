// Post-checkout hook for Frak Integration
console.log('Frak Integration post-checkout hook loaded');

prestashop.on('updatedCart', function (event) {
    console.log('Cart updated', event);
});
