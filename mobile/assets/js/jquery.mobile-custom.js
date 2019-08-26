$(document).on('swipeleft swiperight', function (e) {
		// We check if there is no open panel on the page because otherwise
		// a swipe to close the left panel would also open the right panel (and v.v.).
		// We do this by checking the data that the framework stores on the page element (panel: open).
		if ( $( ".ui-page-active" ).jqmData( "panel" ) !== "open" ) {
			if ( e.type === "swipeleft" ) {
				$.mobile.activePage.find( "#right-panel" ).panel( "open" );	
			} else if ( e.type === "swiperight" ) {
				$.mobile.activePage.find( "#left-panel" ).panel( "open" );
			}
		} 
});

$(document).on("pageshow", function () {  			   

	$( ".nav-toggle" ).click(function() {
	   $.mobile.activePage.find( "#left-panel" ).panel( "open" );
	});

    $(document).on("panelopen", "#left-panel", function ( e ) { 
        $(".nav-toggle").addClass("navtoggleon");
    });

    $(document).on("panelclose", "#left-panel", function ( e ) {
        $(".nav-toggle").removeClass("navtoggleon");
    });
	 
});

	
$( document ).delegate("#photos", "pagecreate", function() {
  $(".swipebox").swipebox();
});

$( document ).delegate("#blog", "pagecreate", function() {
		$(".posts li").hide();	
		size_li = $(".posts li").size();
		x=4;
		$('.posts li:lt('+x+')').show();
		$('#loadMore').click(function () {
			x= (x+2 <= size_li) ? x+2 : size_li;
			$('.posts li:lt('+x+')').show();
			if(x == size_li){
				$('#loadMore').hide();
				$('#showLess').show();
			}
			$("html, body").animate({ scrollTop: $(document).height() }, 1000);
		});
});

$.widget( "ui.tabs", $.ui.tabs, {

_createWidget: function( options, element ) {
    var page, delayedCreate,
        that = this;

    if ( $.mobile.page ) {
        page = $( element )
            .parents( ":jqmData(role='page'),:mobile-page" )
            .first();

        if ( page.length > 0 && !page.hasClass( "ui-page-active" ) ) {
            delayedCreate = this._super;
            page.one( "pagebeforeshow", function() {
                delayedCreate.call( that, options, element );
            });
        }
    } else {
        return this._super();
    }
}

});


$( document ).delegate("#contact", "pagecreate", function() {
  		$("#ContactForm").validate({
		submitHandler: function(form) {
		ajaxContact(form);
		return false;
		}
		});
});


