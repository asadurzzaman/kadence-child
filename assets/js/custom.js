(function($){

    jQuery(".price-tab").hide();
    jQuery(".price-tab[data-id='tab_annual']").show();


    jQuery(".price-table-tab .nav-link").unbind("click");
    jQuery(".price-table-tab .nav-link").bind("click", function () {

        jQuery(".price-table-tab .nav-link").removeClass('active');
        jQuery(this).addClass('active');

        jQuery("price-tab").hide();
        jQuery("price-tab[data-id='" + $(this).data('target') + "']").show();
    });
}(jQuery));