(function ($, root, undefined) {
	
$(function () {

// animate to category
$( '.menu-item' ).find( 'a' ).click(function(e){

	if( $( 'body' ).hasClass( 'home' ) ) {

		e.preventDefault();

		var cat = $( this ).attr( "href" ).replace( '/', '' ),
			catPos = $( cat ).offset(),
			trigger = $( this ).parents( '.nav' ).children( '.nav-trigger' );

		$( "html, body" ).animate({
			"scrollTop"	:	catPos.top - 39
		}, 500
		);

		// close drop-down nav on mobile
		if ( trigger.hasClass( 'open' ) ) trigger.removeClass( 'open' );

	}
	
});

// mobile navigation trigger
$( '.nav-trigger' ).click(function(){
    $( this ).toggleClass( 'open' );
});

// responsive dimensions for triangle backgrounds
function triangleSides() {

$( '.triangle-side' ).each(function(){
	
	var t = $( this ),
		r;	
	
	if ( t.hasClass( 'banner-heading' ) ) {
		r = 0.0956175299;
	} else if ( t.hasClass( 'more' ) && t.hasClass( 'thick' ) ) {
		r = 0.153846154;
	} else {
		r = 0.24;
	}

	var	s = t.children( '.triangle' ),
		bg = t.css( 'background-color' ),
		w = t.outerHeight() * r,
		h = t.outerHeight();

	// create triangle if it doesn't exist
	if ( s.length < 1 ) {

		t.prepend( '<span class="triangle"></span>' );
		s = t.children( '.triangle' );

	}

	s.css({
		'border-right-width' : w +  'px',
		'border-bottom-width' : h + 'px',
		'border-right-color' : bg,
		'left' : '-' + Math.floor( w ) + 'px'
	});
});

}

// add triangle sides (to be run again on load)
triangleSides();

// display/transition service descriptions
function trigger_slider( t, e ) {

	e.preventDefault();

	// check if active slide
	if ( !t.hasClass( 'current' ) ) {
	
		var p = t.parents( '.slider' ),
			c = p.find( '.slider-container' ),
			a = t.attr( "data-service" ),
			s = p.find( '.slider-trigger[data-service="' + a + '"]' ),
			v = c.find( '.current' );
	
		// scripts strictly for technology section
		if ( t.parents( '.technologies' ).length ) {
	
			t.parents( '.technologies' ).addClass( 'active' );
			
			s = t;
	
		}
	
		// clone content based on section
		var content = ( t.parents( '.technologies' ).length ) ? "full" : "content";
		
		var d = ( content == "full" ) ? s.parents( '.slider-content' ) : s.parents( '.slider-content' ).find( '.slider-desc' );
		
		d = d.clone().prependTo( c );
		var h = d.outerHeight();
	
		c.css( "height", h + "px" );
	
		if ( v.length > 0 ) {
	
			v.next().remove();
	
			v.css({
				'left' : '-100%',
				'opacity' : '0'
			});
	
			p.find( '.current' ).removeClass( 'current' );
			
	
		}
	
		d.css({
			'left' : '0',
			'opacity' : '1'
		})
		.addClass( 'current' );
	
		s.addClass( 'current' );
	
	}

}

// trigger services slider
$( '.services' ).find( '.slider-trigger, .service-map' ).click(function( e ){

	// for services: use slider on larger screens, otherwise content accordian
	if ( $( window ).width() > 630 ) {

		trigger_slider( $( this ), e );

		// slide screen to top of services section
		var section_services = $( '#section-services' ).offset();
		$( "html, body" )
			.animate({
				"scrollTop"	:	section_services.top - 39
			}, 500
		);

		// trigger services highlighting to display when navigation link clicked
		highlightService( $( this ), true );

	} else {

		e.preventDefault();

		var t = $( this ),
			p = t.parents( '.slider-content' ),
			c = p.find( '.slider-desc' ),
			w = p.parent(),
			v = w.find( '.current' );
			
		if( !t.hasClass( 'current' ) ) {	

			if ( v.length > 0 ) {

				//v.parents( '.slider-content' ).find( '.slider-desc' ).addClass( 'collapse' );
				v.removeClass( 'current' );
				v.parents( '.slider-content' ).addClass( 'collapse' );

			}

			c.addClass( 'current' );
			p.removeClass( 'collapse' );

		}

	}

});

// hide services content on initial load of mobile
if ( $( window ).width() < 630 ) {

	$( '.service' ).addClass( 'collapse' );

}

// calculate height of services slider
function servicesHeight() {

	$( '.service' ).find( '.slider-desc' ).each(function(){
	
		if ( $( window ).width() < 630 ) {
	
			var t = $( this ),
				c = t.outerHeight( true ),
				f = parseInt( t.css( 'font-size' ) ),
				h = c + ( f * 2.06666667 );

			t.parents( '.service' ).css({
				"height" : h + "px"
			});
	
		}
	
	});

}

// add services images on larger screens
function addServiceImgs(){

	if ( $( window ).width() > 630 || $( window ).height() > 630 ) {

		$( '.service' ).find( '.slider-trigger' ).each(function(){

			var t = $( this ),
				i = "/wp-content/uploads" + t.attr( 'data-graphic' ),
				s = t.attr( 'data-service' ),
				c = t.text();

			$( '.services-graphic-container' ).append(function(){
				return '<img class="services-graphic hidden" src="' + i + '" data-service="' + s + '" alt="Illustration highlighting ' + c + ' service provided by Co-Operations">';
			});

		});

	}

}

// show/hide services images
function highlightService( t, current ) { // t: trigger element, current: set as current

	current = typeof current !== 'undefined' ? current : false; // default current to false

	var s = t.attr( 'data-service' ), // target graphic for selected service
		h = 'hidden', // class name to hide graphics
		i = $( '.services-graphic[data-service="' + s + '"]' ); // image to display

	$( '.services-graphic' ).not( '.' + h + ', .services-all, .current' ).addClass( h );
	i.removeClass( h );
	
	if ( current )  {

		i.addClass( 'current' );
		$( '.service-map[data-service="' + s + '"]' ).addClass( 'current' );

	}

}

// trigger services highlighting when hovered over on illustration
$( '.services' ).find( '.slider-trigger, .service-map' ).mouseenter(function(){

		highlightService( $( this ) );
		
		var s = $( this ).attr( 'data-service' ); // target graphic for selected service
		
		$( '.services' ).find( '[data-service="' + s + '"]' ).addClass( 'focus' );

	})
	.mouseleave(function(){

		var s = $( this ).attr( 'data-service' ); // target graphic for selected service
		
		$( '.services' ).find( '[data-service="' + s + '"]' ).removeClass( 'focus' );

		if ( !$( this ).hasClass( 'current' ) ) {

			$( this ).removeClass( 'current' );
			$( '.services-graphic[data-service="' + s + '"]' ).addClass( 'hidden' );
		
		}

	}
);

// trigger technologies slider
$( '.technology' ).find( '.slider-trigger' ).click(function( e ){

	trigger_slider( $( this ), e );

});

// set active technology images as backgrounds (pre-loading)
$( '.technology-img' ).not( '.active' ).each(function(){

	var t = $( this ),
		s = t.attr( 'src' ).slice( 0, -4 ),
		e = t.attr( 'src' ).slice( -4 );

	t.css( 'background-image', 'url( ' + s + '-active' + e + ' )' );

});

// hide team members
$( '.team' ).addClass( 'hidden' );

// calculate team section height
function teamHeight() {

	var t = $( '.team' ),
		c = $( '.team-container' ),
		h = c.outerHeight();

	t.css( 'height', h + 'px' );

}

//display team members
$( '.showTeam' ).show().click(function(e){

	$( '.team' ).toggleClass( 'hidden' );

});

// contact form validation events
var submit_btn = $( 'input[type="submit"]' );
var submit_message = "Submit Your Message";

$( '.wpcf7' ).find( submit_btn ).click(function(e) {

	submit_message = $( this ).val();

	$( this ).val( "Sending..." );

});

$( '.contact .wpcf7' ).on( 'wpcf7:invalid wpcf7:mailfailed', function(){
		$( this ).find( submit_btn ).val( submit_message );
	})
	.on( 'wpcf7:mailsent', function(){
		$( this ).find( submit_btn ).val( 'Sent!' );
});

// position background image for sidebar
function asideBg() {

	$( '#content.hasAside' ).css( 'background-position-x', function(){
	
		var t = $( this ),
			s = t.find( '.sidebar' ),
			r = s.offset().left + s.outerWidth(), // right position of sidebar element
			p = r - 534; // left position of bg image ( r-pos of sidebar minus width of bg image )
	
		return p + 'px';
	
	});

}

// functions to fire on screen size or orientation change
function screenChange() {
	
	triangleSides();
	asideBg();
	servicesHeight();
	teamHeight();
	
	$( '.slider-container' ).each(function(){

		var h = $( this ).children().first().outerHeight();

		$( this ).css( "height", h + "px" );

	});

}

$( window ).load(function(){
	triangleSides();
	addServiceImgs();
	servicesHeight();
	teamHeight();
	asideBg();
});
$( window ).resize(function(){
	screenChange();
});
window.addEventListener("orientationchange", function() {
	screenChange();
}, false);


});
	
})(jQuery, this);
