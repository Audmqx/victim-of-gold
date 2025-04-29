jQuery(function($) {
    // Mise à jour du mini panier
    function updateMiniCart() {
        // Éviter les appels multiples en vérifiant si une requête est déjà en cours
        if (updateMiniCart.request) {
            return;
        }
        
        updateMiniCart.request = $.ajax({
            url: victim_ajax.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments'),
            type: 'POST',
            success: function(response) {
                if (response.fragments) {
                    $.each(response.fragments, function(key, value) {
                        $(key).replaceWith(value);
                    });
                }
                updateMiniCart.request = null;
            },
            error: function() {
                updateMiniCart.request = null;
            }
        });
    }

    // Gérer l'ajout au panier via AJAX
    $(document).on('click', '.ajax_add_to_cart', function(e) {
        e.preventDefault();
        
        var $thisbutton = $(this);
        var $form = $thisbutton.closest('form.cart');
        var quantity = $form.find('input[name=quantity]').val() || 1;

        var data = {
            product_id: $thisbutton.val(),
            quantity: quantity
        };

        // Déclencher l'événement avant l'ajout
        $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

        $.ajax({
            type: 'POST',
            url: victim_ajax.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
            data: data,
            beforeSend: function() {
                $thisbutton.removeClass('added').addClass('loading');
            },
            complete: function() {
                $thisbutton.addClass('added').removeClass('loading');
            },
            success: function(response) {
                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                }

                // Déclencher l'événement après l'ajout réussi
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                
                // Mettre à jour le mini panier
                updateMiniCart();
            }
        });
    });

    // Mise à jour de la quantité dans le panier
    $(document).on('change', '.woocommerce-cart-form .qty', function() {
        // Utiliser un délai pour éviter les appels multiples lors de changements rapides
        clearTimeout($(this).data('timeout'));
        $(this).data('timeout', setTimeout(function() {
            $('[name="update_cart"]').trigger('click');
        }, 500));
    });

    // Animation du mini panier lors de l'ajout d'un produit
    $(document.body).on('added_to_cart', function() {
        $('.cart-count').addClass('bounce');
        setTimeout(function() {
            $('.cart-count').removeClass('bounce');
        }, 1000);
    });
}); 