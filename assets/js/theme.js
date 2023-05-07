/**
 *  Custom JS Scripts
 *
 * @package folio
 */

 var folioApp = (function( $ ) {

	return {

		isotopeLoading: function() {

			var $container = $('.isotope');

			$container.imagesLoaded()

			.always( function( instance ) {
			    $container.fadeIn(); 
			})

			.progress( function( instance, image ) {
			    if(image.isLoaded) {
			    	$('.isotope-load').remove();
			    	$container.fadeIn();
			  	}
			});
		},

		/**
		* Isotope
		*/
		isotopeGallery: function() {
		    var $container = $('.isotope');
		    $container.imagesLoaded( function() {
		    	$container.isotope({
				    itemSelector: '.item',
					masonry: {
					    columnWidth: 0,
					}
				});

		        $container.isotope({
		            itemSelector: '.item'
		        });
		    });
		},

		/** 
		* Infinite Scroll Option
		*/
		infiniteScroll: function() {
			if(scrollSetting) {
				var $container = $('.isotope').imagesLoaded( function() {
				    $container.infinitescroll({
				        navSelector  : '.page-numbers',
				        nextSelector : '.next',
				        itemSelector : '.item',
				        loading: {
				        img: ' ',
				            finishedMsg: ' ',
				            msgText: ' ',
				            msg: ' '
				        }
				    },
				    // call Isotope as a callback
				    function( newElements ) {
					    var $newElems = $( newElements ).hide();
					    $newElems.imagesLoaded(function(){
						    $container.isotope( 'insert', $newElems );
						    $container.isotope('reloadItems');
						    folioApp.imageLightbox();
							folioApp.videoLightbox();
							folioApp.galleryLightbox();
						});
				    });
				});
			}
		},

		/** 
		* Filter Buttons
		*/
		galleryFilters: function() {
			$('#filters').on( 'click', 'button', function() {
				var $container = $('.isotope');
				var filterValue = $(this).attr('data-filter');
				$('#filters button').removeClass('active');
				$(this).addClass('active');
				
				var $container = $('.isotope').imagesLoaded( function() {
			    	$container.isotope({
			    		filter: filterValue,
					    itemSelector: '.item',
						masonry: {
						    columnWidth: 0,
						}
					});

			        $container.isotope({
			        	filter: filterValue,
			            itemSelector: '.item'
			        });
			    });
			});
		},

		/**
		* Single Image for Magnific Popup
		*/
		imageLightbox: function() {

			$('.image-link').magnificPopup({
				type:'image',
				mainClass: 'mfp-with-fade',
				titleSrc: 'title',
				callbacks: {
					markupParse: function(template, values, item) {
						values.description = item.el.data('description'); // or item.img.data('description');
					}
				},
			});
		},

		/** 
		* Video for Magnific Popup
		*/
		videoLightbox: function() {

			$('.mfp-video').magnificPopup({
				type: 'iframe',
				mainClass: 'mfp-with-fade',
				iframe: {
					markup: '<div class="mfp-iframe-scaler">'+
			                '<div class="mfp-close"></div>'+
			                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
			                '<div class="mfp-title mfp-title-video"></div>'+
			                '<div class="mfp-description mfp-description-video"></div>'+
			              '</div>',

					patterns: {
					    youtube: {
					      index: 'youtube.com/',
					      id: 'v=',
					      src: '//www.youtube.com/embed/%id%?autoplay=1'
					    },
					    vimeo: {
					      index: 'vimeo.com/',
					      id: '/',
					      src: '//player.vimeo.com/video/%id%?autoplay=1'
					    },

					},

					srcAction: 'iframe_src',
				},

				callbacks: {
				    markupParse: function(template, values, item) {
				     values.title = item.el.attr('title');
				     values.description = item.el.data('description');
				    }
				},
			});
		},

		/**
		* Gallery Lightbox
		*/
		galleryLightbox: function() {

			$('.open-gallery-link').on('click', function() {

				var gallery = $(this).data('name');
				var gallery = "." + gallery;

				$(gallery).magnificPopup({
					type: 'image',
					delegate: 'a',
					removalDelay: 300,
					mainClass: 'mfp-with-fade',
					titleSrc: 'title',
					gallery:{
						enabled: true
					},
					callbacks: {
						markupParse: function(template, values, item) {
							values.description = item.el.data('description'); // or item.img.data('description');
						}
					},
				});
			});
		},

		ajaxPages: function() {
			if(!ajaxPageSetting) {
				$('.main-navigation li a').on('click',function(event){

					if($(this).attr('target'))
						return;

					event.preventDefault();
					var $this = $(this);
					var post_id = $this.attr('id');
					var loadPages = $('.js-load-pages');

					$('.main-navigation li a').removeClass('active');
					$this.addClass('active');

					$this.addClass('active-loader'); // loader

					$.ajax({
						method: "POST",
						dataType: "HTML",
						url: loadPagesData.ajax_url,
						data: {
							action:"load_pages",
							id:post_id
						},
			            success: function( data ){
			            	$this.removeClass('active-loader');
				            var $ajax_response = $( data );
				            loadPages.html( $ajax_response );  
				            loadPages.hide().fadeIn(500); 


				         	$('.close').on('click', function(event) {
								event.preventDefault();
					            $('.main-navigation ul li a').removeClass('active');
					            $('.js-load-pages').hide();
					        });                         
			            }

					}); 
				});
			}
		},

		lazyLoad: function() {
			if(!scrollSetting) {
			    $("img.lazy").lazyload({});
			}
		},

		menuToggle: function() {
			$('.js-menu-icon').on('click', function() {
				$('.main-navigation').slideToggle();
				$(this).toggleClass('dashicons-no-alt');
			});
		},
	};

})( jQuery );

// Initialize folioApp functions

( function() {

	folioApp.isotopeLoading();
	folioApp.isotopeGallery();
	folioApp.infiniteScroll();
	folioApp.galleryFilters();
	folioApp.imageLightbox();
	folioApp.videoLightbox();
	folioApp.galleryLightbox();
	folioApp.ajaxPages();
	folioApp.lazyLoad();
	folioApp.menuToggle();

})();