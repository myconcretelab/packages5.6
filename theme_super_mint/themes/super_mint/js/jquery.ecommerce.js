// Amelioration pour pouvoir avoir des quantité dans différents endroits de la page



//refreshPageSlide placé dans footer.php

// Avec ce systeme le document herite de cart.settings et de  cart.quantityEl ;
// il a les deux adresses de la carte et des quantitées
// il lui manque l'adresse de la single page 'cart'.
// ainsi que toutes les méthodes

// La douleur c'est que parfois 'el' est le document, parfois le <form>

// Le formulaire, lui hérite de tout le reste en plus


(function($) {
    var defaults = {
        cartUrl:'',
        quantityUrl:'',
        formUrl:'',
        quantitySelector : 'a.cart-quantity', // le selecteur pour les element qui affichent les quantité
        togglePageSlideSelector: '.toggle-pageslide',
        remove : 'remove_product',
        update : 'update',

    }

    $.fn.slideCart = function(options){
        if(this.length == 0) return this;
        
        // support mutltiple elements
        if(this.length > 1){
            this.each(function(){$(this).slideCart(options)});
            return this;
        }
        
        var el = $(this);

        var windowWidth = $(window).width();
        var windowHeight = $(window).height();

        if(el.is(document)){
            // create a cart to be used throughout the slideCart
            var cart = {}; 
            
        };
        // On lance inti dans 
        var init = function(){
           // on melange les options
            cart.settings = $.extend({}, defaults, options);
            // le ou les textes affichant les quantité de produits
            cart.quantityEl = $(cart.settings.quantitySelector);
            // l'url de la balise action
            cart.actionurl = cart.settings.formUrl;
            // l'url pour l'update
            cart.updateurl = cart.actionurl + cart.settings.update;
            // l'url pour retirer un produit
            cart.removeurl = cart.actionurl + '/' + cart.settings.remove;
            // Les boutons qui peuvent ouvrir et fermer le page slide
            cart.togglePageSlide = $(cart.settings.togglePageSlideSelector);
            // On garde tout ça au chaud
            el.data('cart',cart);
            // On lance les evenement si il y en a
            initRootEvent();
        };

        var initForm = function () {
            cart.form = el;
            // on met à jour l'url du formulaire avec l'option 'update'
            el.attr('action',cart.updateurl);
            // L'id du formulaire
            cart.ID = el.attr('id'); 
            // LES bouton pour supprimer un produit de la carte (optionel)
            el.removebtn = el.find('.delete');
            // LES bouton pour augmenter la quantité d'un produit de la carte (optionel)
            el.increasebtn = el.find('#increase');
            // LES bouton pour descendre la quantité d'un produit de la carte (optionel)
            el.decreasebtn = el.find('#decrease');

            el.hidden = $('<input type="hidden" name="method" value="JSON" />').appendTo(el);            

            el.data('cart',cart);
            // On lance les evenement si il y en a
            initFormEvent();
            // On rafraichis les element du root
            initRootEvent();         
            // On initie le plugin Ajaxform
            initAjaxForm();

        }
        var initRootEvent = function () {
            // Si, dans la page il y a des bouton affichant le contenu du panier
            // On ouvre le pageslide à leur clic
            // Il sont défini à chaque fois pour prendre les nouveaux arrivant en ajax
            cart.togglePageSlide = $(cart.settings.togglePageSlideSelector);            
            if(cart.togglePageSlide.length) cart.togglePageSlide.on('click',onClickTogglePageSlide);
        }

        var initFormEvent = function () {
            if (el.removebtn.size())
                el.removebtn.on('click',removeProduct);
            if (el.increasebtn.size());
                el.increasebtn.on('click',increaseQuantity);
            if (el.decreasebtn.size())
                el.decreasebtn.on('click',decreaseQuantity);
        }

        var onClickTogglePageSlide = function (e) {
            el.togglePageSlide();
            e.preventDefault();
        }

        var initAjaxForm = function () {
            el.ajaxForm({
                beforeSubmit: function(formData, jqForm, options) {
                    el.find('input[type=submit]').attr('disabled', true);
                },  
                success: function(data) {

                    el.find('input[type=submit]').attr('disabled', false);
                    el.togglePageSlide(true, true);
                    el.updateQuantity();
                }
            });            
        }

        var removeProduct = function (e) {
            // l'element <a> qui a été cliqué
            var a = $(e.currentTarget);
            // l'id du produit
            var pid = a.data('pid');
            // Si l'attribut <a> a une info sur l'id du produit
            
            if (pid){
                // On apelle la methode publique pour retirer un produit
                el.removeProduct(pid);
                e.preventDefault();

            }
        }
        
        var increaseQuantity = function (e) {
            // Verifier si la quantité n'esede pas la quantité max
            obj = $(e.currentTarget).parent().parent().find('.ccm-core-commerce-max-quantity');
            $(obj).val(parseInt($(obj).val()) + 1);
        }
        var decreaseQuantity = function (e) {
            obj = $(e.currentTarget).parent().parent().find('.ccm-core-commerce-max-quantity');
            $(obj).val(parseInt($(obj).val()) - 1);
        }

        var logError = function (msg) {
            alert(msg);
        }

        // ------------------------------- //
        // ----- Methodes publiques ------ //
        // ------------------------------- //

        el.removeProduct = function(pid) {
            // on apelle la single page en ajax 
            // pour retirer un produit
            $.post(cart.removeurl + '/' + pid, {'method': 'JSON'}, function(data) {
                // une fois sa réponse reçue, on la teste
                if(data.error != '') {
                    logError(data.message);
                    return;
                }
                // Mettre à jour la quatité dans le carré panier
                el.updateQuantity();
                // On rafraichi la page laterale
                el.refreshPageSlide();
                
            }, "json");
        };
        el.updateQuantity =function () {
            // On charge l'info 
            $.getJSON(cart.settings.quantityUrl,function(data){
                cart.quantityEl.html(data);
            });

        }
        el.refreshPageSlide = function () {
            $('#pageslide').load(cart.settings.cartUrl);
        }


        el.togglePageSlide = function  (autoClose, forceOpen) {
            // Si l'objet carte est vide on le recupè
            // On teste si la fenetre est ouverte
            if ($("#pageslide").is(':visible')){
                // On la garde ouverte et on refraichi
                // surtout quand on met à jour le panier 
                // ou quand la personne fait ses course avec la carte ouverte
                if (forceOpen) {
                    // On rafraichi
                    el.refreshPageSlide();
                    // le timeout est ignoré
                    return;
                }
                // sinon, on ferme 
                $('.arrow_box_slide.arrow_box ').animate({right:-100});
                $.pageslide.close();
            } else {
                $.pageslide({ direction: 'left', iframe:false, href:cart.settings.cartUrl, modal:true});
                $('.arrow_box_slide.arrow_box ').animate({right:342});
            }

            // Si une fermeture automatique est demandée
            if(autoClose) {
                setTimeout(function(){                   
                    $('.arrow_box_slide.arrow_box ').animate({right:-100});
                    $.pageslide.close();
                },1500);
            }
        }


        $.slideCart = new Object(); 

        $.slideCart.initExternalAction = function () {

        }
        // @-arg l'id du formulaire qui a déjà été initié avec cartslide
        $.slideCart.updateQuantity = function(url) {
            // On recupère lobjet carte du formulaire

        };
        $.pageslide.init = function (options) {

        }

        $('document').ready(function(){

        });


        if(el.is(document)){
            init();
        } else if(el.is('form')) {
            // On herite de l'objet cart dejà créé
            // et on le defini dans le scope
            var cart = options;
            initForm();
        };
        
        return cart;
    }

})(jQuery);
