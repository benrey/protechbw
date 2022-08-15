// chrome://flags/#unsafely-treat-insecure-origin-as-secure

window.initGeocoder = function () {
	geocoder = new google.maps.Geocoder();
};

jQuery( document ).ready(function($) {

	var contactData = window.theme_params ? JSON.parse(window.theme_params.contact_data) : {};
	var offices = contactData.locations || [];
	
	geocoder = window.geocoder;
	var sendingForm = false;
	var navigatorUserPosition = null;

	var MAX_DISTANCE = 200;
	var DISTANCE_UNIT = 'M';
	var geolocationOptions = {
  		enableHighAccuracy: true,
  		timeout: 30000,
  		maximumAge: 75000,
	};

	var overrideLocationPA = 1265; // Wexford, PA location
	var overrideBuffaloZipArray = [
		'14201',
		'14202',
		'14203',
		'14204',
		'14205',
		'14206',
		'14207',
		'14208',
		'14209',
		'14210',
		'14211',
		'14212',
		'14213',
		'14214',
		'14215',
		'14216',
		'14217',
		'14218',
		'14219',
		'14220',
		'14221',
		'14222',
		'14223',
		'14224',
		'14225',
		'14226',
		'14227',
		'14228',
		'14231',
		'14233',
		'14240',
		'14241',
		'14260',
		'14261',
		'14263',
		'14264',
		'14265',
		'14267',
		'14269',
		'14270',
		'14272',
		'14273',
		'14276',
		'14280'
		];

	// functions
	// https://www.htmlgoodies.com/javascript/calculate-the-distance-between-two-points-in-your-web-apps/
	function haversine(lat1, lon1, lat2, lon2, unit) {
        var radlat1 = Math.PI * lat1/180;
        var radlat2 = Math.PI * lat2/180;
        var radlon1 = Math.PI * lon1/180;
        var radlon2 = Math.PI * lon2/180;
        var theta = lon1-lon2;
        var radtheta = Math.PI * theta/180;
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        dist = Math.acos(dist);
        dist = dist * 180/Math.PI;
        dist = dist * 60 * 1.1515;
        if (unit=="K") { dist = dist * 1.609344; }
        if (unit=="N") { dist = dist * 0.8684; }
        return dist;
	}

	function sortByDistance(a, b) {
  		return (a.distance - b.distance);
	}

	function findClosestOffice(userLocation, offices) {
		for (let i in offices) {
			offices[i].distance = haversine(userLocation.lat, userLocation.lng, offices[i].position.lat, offices[i].position.lng, DISTANCE_UNIT);
		}
		offices.sort(sortByDistance);

		return offices[0];
	}

	function getUserLocation() {

		// get user location based on browser location permissions
		if (!navigatorUserPosition && navigator.geolocation) {
			$('form#contact #next').prop('disabled', true);
			$('form#contact .form-input-zipcode').addClass('loading');
			$('form#contact .form-input-zipcode label').text('Loading location...');

			function geolocationSuccess(position) {
				navigatorUserPosition = position;
				selectClosestOffice();
			}

			function geolocationError(error) {
				resetZipcodeInput();
			}

			navigator.geolocation.getCurrentPosition(geolocationSuccess, geolocationError, geolocationOptions);
		
		// select closest office based on saved browser location
		} else {
			selectClosestOffice();
		}
	}

	function getZipLocation(zip) {
		var override = checkZipOverride(zip);
		if (override) {
			selectOffice(override);
		}
		else {
			geocodeAddress(zip, (userLocation) => {
				var closestOffice = findClosestOffice(userLocation, offices);

				if(closestOffice) {
					selectOffice(closestOffice);
				} else {
					resetZipcodeInput('no-results');
				}
			});
		}
	}

	function checkZipOverride(zipcode) {
		override = false;

		if (zipcode.length > 7) { zipcode = zipcode.split('-')[0]; }
		
		// check for Buffalo, NY zip codes
		if (overrideBuffaloZipArray.indexOf( zipcode ) != -1) { override = true; }
		
		// check for canadian zip code
		var caZipcode = zipcode.toString().trim().toUpperCase();
		var regex = new RegExp(/^[ABCEGHJ-NPRSTVXY]\d[ABCEGHJ-NPRSTV-Z][ -]?\d[ABCEGHJ-NPRSTV-Z]\d$/i);
		if (regex.test(caZipcode)) { override = true; }
		
		// if override, get PA location from list
		if (override) {
			for (let i in offices) {			
				if (offices[i].id == overrideLocationPA) {
					return offices[i];
				}
			}
		}
		
		return false;
	}

	function geocodeAddress(address, callback) {
		geocoder.geocode({'address': address}, function(results, status) {
			if (status === 'OK') {
				var userLocation = {
					lat: results[0].geometry.location.lat(),
					lng: results[0].geometry.location.lng(),
				};

				return callback(userLocation);
			} else {
				resetZipcodeInput('no-results');
			}
		});
	}

	function selectClosestOffice() {
		var userLocation = {
    		lat: navigatorUserPosition.coords.latitude,
    		lng: navigatorUserPosition.coords.longitude,
  		};
  		var closestOffice = findClosestOffice(userLocation, offices);

  		if(closestOffice.distance <= MAX_DISTANCE) {
		    selectOffice(closestOffice);
		} else {
		    resetZipcodeInput('no-results');
		}
	}

	function selectOffice(office) {
		if(!office) {
    		return false;
  		}

  		$('form#contact .form-input-zipcode').hide();
  		$('form#contact .form-input-zipcode').removeClass('loading').addClass('found');
		$('form#contact .form-input-zipcode label').text('Local location found!');

  		$('#office').val(office.id);
        $('form#contact .alert .location').html('<a href="/contact/#location-' + office.id + '">' + office.name + ' Office</a>')
        $('#contactSuccess .message .location').html(office.name + ' Office');

  		$('form#contact #next').hide();
  		$('form#contact .section2').show();
	}

	function resetZipcodeInput(state = 'init') {
		$('form#contact .form-input-zipcode').removeClass('loading');
		$('form#contact #next').prop('disabled', false);

		if(state === 'no-results') {
			$('form#contact .form-input-zipcode label').html('No results for given zip code.');
  		} else {
			$('form#contact .form-input-zipcode label').html('Zip code <span>*</span>');
		}
	}

	function validateEmail(email) {
  		const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  		return re.test(String(email).toLowerCase());
	}




    // contact tabs switcher
    $('.block-contact-tabs .tabs li').click(function() {
        var id = $(this).data('tab');

        $('.block-contact-tabs .tabs li.active').removeClass('active');
        $(this).addClass('active');

        $('.block-contact-tabs .tab-content .tab.active').removeClass('active');
        $('.block-contact-tabs .tab-content .tab' + id).addClass('active');
    });

    // table sort
    $('.block-contact-tabs .tab-content .tab2 .table-header .cell1').click(function() {
        $(this).find('span, .toggle').toggleClass('active');
        var list = $('.block-contact-tabs .tab-content .tab2 .table-body');
        var listItems = list.children('div');
        list.append(listItems.get().reverse());
    });
    $('.block-contact-tabs .tab-content .tab3 .table-header .cell1').click(function() {
        $(this).find('span, .toggle').toggleClass('active');
        var list = $('.block-contact-tabs .tab-content .tab3 .table-body');
        var listItems = list.children('div');
        list.append(listItems.get().reverse());
    });

    // table row open/close
    $('.block-contact-tabs .tab-content .table-row').click(function() {
        $(this).toggleClass('active');
    });
    $('.block-contact-tabs .tab-content a').click(function(e) {
        e.stopPropagation();
    });

    // form inputs
    $('form#contact .form-input label').click(function() {
    	if (!$(this).parent().hasClass('loading') && !$(this).parent().hasClass('found')) {
    		$(this).hide();
        	$(this).next().focus();
    	}
    });
    $('form#contact .form-input input').focus(function() {
    	if (!$(this).parent().hasClass('loading') && !$(this).parent().hasClass('found')) {
        	$(this).prev().hide();
    	}
    });
    $('form#contact .form-input input').blur(function() {
        if ($(this).val() == '') { 
        	$(this).prev().show(); 
        } else { 
        	$(this).parent().removeClass('error'); 
        	if ($(this).attr('name') == 'email' && validateEmail($(this).val())) { $(this).parent().removeClass('invalid'); }
        }
    })

    $('form#contact div.checkbox').click(function() {
        jQuery(this).toggleClass('active');
        var checkbox = jQuery(this).find("input");
        checkbox.attr('checked', !jQuery(checkbox).attr('checked'));
    });



    // form actions
    if ($('body.page-id-9 form#contact').length && window.location.hash == '') {
    	getUserLocation();
    }
    $('.block-contact-tabs .tabs .tab1').click(function() {
    	if (window.location.hash == '') {
    		getUserLocation();
    	}
    });

    $('form#contact #next').click(function(e) {
    	e.preventDefault();
    	var zip = $('form#contact .form-input-zipcode input').val();

    	if (zip == '') {
    		$('form#contact .form-input-zipcode').addClass('error');
    	} else {
    		getZipLocation(zip);
    	}
    });

    // work, capability page contact toggle
    $('.work-contact h2, .single-capability .contact h2').click(function(e) {
    	e.preventDefault();
    	$('form#contact').slideToggle();
    	getUserLocation();
    })

    // form submit
    $('form#contact #submit').click(function(e) {
        e.preventDefault();

        // check for form data
        var refer = jQuery('form#contact input[name="_wp_http_referer"]').val();
        var office = jQuery('form#contact input#office').val();

        var name = jQuery('form#contact .form-input-name input').val();
  		var email = jQuery('form#contact .form-input-email input').val();
  		var phone = jQuery('form#contact .form-input-phone input').val();
  		var zipcode = jQuery('form#contact input#zipcode').val();

  		if(!name || !email || !validateEmail(email) || !office || sendingForm) {
  			if(!name) { jQuery('form#contact .form-input-name').addClass('error'); }
  			if(!email) { jQuery('form#contact .form-input-email').addClass('error'); }
  			else if (!validateEmail(email)) { jQuery('form#contact .form-input-email').addClass('invalid'); }
    		return false;
  		}

		var project_description = jQuery('form#contact textarea#project_description').val();
		var nonce = jQuery('form#contact input#sg_contact_form_nonce').val();
		var selected_services = jQuery('form#contact input[name="selected_services"]:checked').map(function() {
			return $(this).val();
		}).get();

		var data = {
			name,
			email,
			phone,
			office,
			project_description,
			nonce,
			selected_services,
			zipcode,
			refer
		};

		sendingForm = true;
		$('form#contact input#submit').val('Processing...');

        $.ajax({
			type: 'POST',
			url: window.theme_params.ajax_url + '?action=sg_send_contact_form_email',
			data: data,
			success: (response) => {
				if(response.success === true) {
					$('form#contact').hide();
					$('#contactSuccess').show(300, function() {
						sendingForm = false;

						// reset form
						$('form#contact .form-input label').show();
						$('form#contact input#name, form#contact input#email, form#contact input#phone, form#contact input#zipcode, form#contact input#phone').val('');
						$('form#contact .checkbox').removeClass('active');
						$('form#contact input[type=checkbox]').attr('checked', false);
						$('form#contact input#submit').val('Submit');
						$('form#contact fieldset.section2').hide();

						// scroll
		            	var toTop = $('#contactSuccess').offset().top;
		            	$('html, body').animate({ scrollTop: (toTop - 93) }, 1000);
					});
				}
			},
		});
    });
});

jQuery(window).on("load", function() {
	var contactData = window.theme_params ? JSON.parse(window.theme_params.contact_data) : {};
	var offices = contactData.locations || [];

    function animate_page(){
        if(window.location.hash) {
            var id = window.location.hash.substring(1);

            // open location info
            if (id.indexOf('location') >= 0) {
            	id = id.replace('location-', '');

            	// open tab, open contact details for contact id
	            var tab = jQuery('.table-row[data-id="' + id + '"]').data('tab');
	            jQuery('.block-contact-tabs .tab' + tab).click();
            	setTimeout(function () {
	            	jQuery('.table-row[data-id="' + id + '"]:not(.active)').click();

		            // scroll
		            var toTop = jQuery('.table-row[data-id="' + id + '"]').offset().top;
		            jQuery('html, body').animate({ scrollTop: (toTop - 93) }, 1000);

		            history.pushState("", document.title, window.location.pathname);
	        	}, 500);
            }

            // open contact form for specific location
            else if (id.indexOf('contact') >= 0) {
            	officeId = id.replace('contact-', '');

            	// open tab, open contact details for contact id
	            jQuery('.block-contact-tabs .tab1').click();

	            // update form data
	            jQuery('#office').val(officeId);

	            var officeData = '';
	            for (var i in offices) {
	            	if (offices[i].id == officeId) {
	            		officeData = offices[i];
	            	}
	            } // officeData.id, .name, .position.lat, .position.lng

	            var name = officeData.name;
	            jQuery('.block-contact-tabs .alert .location').html('<a href="/contact/#location-' + officeId + '">' + name + ' Office</a>')
	            jQuery('.block-contact-tabs .message .location').html(name + ' Office');

	            // toggle form
	            jQuery('form#contact .form-input-zipcode').hide();
	            jQuery('form#contact #next').hide();
	            jQuery('form#contact fieldset.section2').show();

	            // scroll
	            var toTop = jQuery('#contact').offset().top;
	            jQuery('html, body').animate({ scrollTop: (toTop - 93) }, 1000);

	            history.pushState("", document.title, window.location.pathname);
            }

        }
    }
    window.setTimeout( animate_page, 200 );
});

jQuery(window).on("hashchange", function() {
	var contactData = window.theme_params ? JSON.parse(window.theme_params.contact_data) : {};
	var offices = contactData.locations || [];

    function animate_page2(){
        if(window.location.hash) {
            var id = window.location.hash.substring(1);

            // open location info
            if (id.indexOf('location') >= 0) {
            	id = id.replace('location-', '');

            	// open tab, open contact details for contact id
	            var tab = jQuery('.table-row[data-id="' + id + '"]').data('tab');
	            jQuery('.block-contact-tabs .tab' + tab).click();
            	setTimeout(function () {
	            	jQuery('.table-row[data-id="' + id + '"]:not(.active)').click();

		            // scroll
		            var toTop = jQuery('.table-row[data-id="' + id + '"]').offset().top;
		            jQuery('html, body').animate({ scrollTop: (toTop - 93) }, 1000);

		            history.pushState("", document.title, window.location.pathname);
	        	}, 500);
            }

            // open contact form for specific location
            else if (id.indexOf('contact') >= 0) {
            	officeId = id.replace('contact-', '');

            	// open tab, open contact details for contact id
	            jQuery('.block-contact-tabs .tab1').click();

	            // update form data
	            jQuery('#office').val(officeId);

	            var officeData = '';
	            for (var i in offices) {
	            	if (offices[i].id == officeId) {
	            		officeData = offices[i];
	            	}
	            } // officeData.id, .name, .position.lat, .position.lng

	            var name = officeData.name;
	            jQuery('.block-contact-tabs .alert .location').html('<a href="/contact/#location-' + officeId + '">' + name + ' Office</a>')
	            jQuery('.block-contact-tabs .message .location').html(name + ' Office');

	            // toggle form
	            jQuery('form#contact .form-input-zipcode').hide();
	            jQuery('form#contact #next').hide();
	            jQuery('form#contact fieldset.section2').show();

	            // scroll
	            var toTop = jQuery('#contact').offset().top;
	            jQuery('html, body').animate({ scrollTop: (toTop - 93) }, 1000);

	            history.pushState("", document.title, window.location.pathname);
            }
        }
    }
    window.setTimeout( animate_page2, 200 );
});