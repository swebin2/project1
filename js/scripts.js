jQuery(document).ready(function($) {
	"use strict";
	try {
			
		var owl = $('.slider-carousel').owlCarousel({
			items: 1,
			navigation : false,
			navigationText: true,
			pagination: true,
			autoPlay: true,
			itemsCustom: [[1300,1], [768,1], [600,1],[480,1],[320,1]],
			slideSpeed: 1000,

		});

	}
	catch(e) {
		console.log(e.message);
	}

	try {
			
		var owl = $('.main-slider-carousel').owlCarousel({
			items: 1,
			navigation : false,
			navigationText: true,
			pagination: true,
			autoPlay: true,
			itemsCustom: [[1300,1], [768,1], [600,1],[480,1],[320,1]],
			slideSpeed: 1000,
			paginationNumbers:true

		});



	}
	catch(e) {
		console.log(e.message);
	}


	//course carousel

	try {
			
		var owl = $('.courses-carousel').owlCarousel({
			items: 1,
			navigation : true,
			navigationText: true,
			pagination: false,
			autoPlay: true,
			itemsCustom: [[1300,1], [768,1], [600,1],[480,1],[320,1]],
			slideSpeed: 1000,

		});
	}
	catch(e) {
		console.log(e.message);
	}


	//featured post carousel

	try {
			
		var owl = $('.section-post').owlCarousel({
			items: 1,
			navigation : true,
			navigationText: true,
			pagination: true,
			autoPlay: false,
			itemsCustom: [[1300,1], [768,1], [600,1],[480,1],[320,1]],
			slideSpeed: 1000,

		});
	}
	catch(e) {
		console.log(e.message);
	}

	//featured post carousel

	try {
			
		var owl = $('.testi-slider').owlCarousel({
			items: 1,
			navigation : true,
			navigationText: true,
			pagination: true,
			autoPlay: false,
			itemsCustom: [[1300,1], [768,1], [600,1],[480,1],[320,1]],
			slideSpeed: 1000,

		});
	}
	catch(e) {
		console.log(e.message);
	}


	//faculaty filter

//
//    try {
//
//        $('.filter-content').mixItUp( {
//          effects: ['fade', 'blur'],
//        });
//      }
//      catch(e) {
//        console.log(e.message);
//      }


    //scroll bar

//    try {
//
//     (function($){
//        
//            $(".scrollbar").mCustomScrollbar();
//    })(jQuery);
//    }
//    catch(e) {
//        console.log(e.message);
//      }


      //scroll bar

//        try {
//
//         (function($){
//            
//                $(".scrollbar2").mCustomScrollbar();
//        })(jQuery);
//        }
//        catch(e) {
//            console.log(e.message);
//          }

      //radiobtn
      
      
        $(window).load(function(e){
        $('.radio input[type=radio]:checked').next('span').addClass('checked').parent('label').addClass('selected');    
    });
    
    $('.radio input[type=radio]').on('change', function(e) {
        e.preventDefault();
        $('.radio input[type=radio]').next('span').removeClass('checked');
        $('.radio input[type=radio]').parent('label').removeClass('selected');
        $(this).next('span').addClass('checked');
        $(this).parent('label').addClass('selected');
    });
    

    $(window).load(function(e){

        $('.checkbox input[type=checkbox]:checked').next('span').addClass('checked').parent('label').addClass('selected');  
    });
    
    $('.checkbox input[type=checkbox]').change(function(e) {
        e.preventDefault();
        $(this).next('span').toggleClass('checked');
        $(this).parent('label').toggleClass('selected');
    });

    //text-editor

   /* $(".editor").Editor({


        'texteffects':false,
        'aligneffects':false,
        'textformats':false,
        'fonteffects':false,
        'actions' : false,
        'insertoptions': false,
        'extraeffects': false,
        'advancedoptions': false,
        'screeneffects':false,
                'bold': true,
                'italics': true,
                'underline':true,
                'ol':true,
                'ul':true,
        'undo':false,
        'redo':false,
        'l_align':false,
        'r_align':false,
        'c_align':false,
        'justify':false,
             'insert_link':true,
        'unlink':true,
                'insert_img':true,
        'hr_line':false,
        'block_quote':false,
        'source':false,
                'strikeout':true,
        'indent':false,
        'outdent':false,
        'fonts':false,
        'styles':false,
        'print':false,
        'rm_format':false,
        'status_bar':false,
        'font_size':false,
                
        'splchars':false,
        'insert_table':false,
        'select_all':false,
        'togglescreen':false
    });*/

    //text-editor 2
    /*$(".editor2").Editor({


        'texteffects':false,
        'aligneffects':false,
        'textformats':false,
        'fonteffects':false,
        'actions' : false,
        'insertoptions': false,
        'extraeffects': false,
        'advancedoptions': false,
        'screeneffects':false,
                'bold': true,
                'italics': true,
                'underline':true,
                'ol':true,
                'ul':true,
        'undo':false,
        'redo':false,
        'l_align':false,
        'r_align':false,
        'c_align':false,
        'justify':false,
             'insert_link':true,
        'unlink':true,
                'insert_img':true,
        'hr_line':false,
        'block_quote':false,
        'source':false,
                'strikeout':true,
        'indent':false,
        'outdent':false,
        'fonts':false,
        'styles':false,
        'print':false,
        'rm_format':false,
        'status_bar':false,
        'font_size':false,
                
        'splchars':false,
        'insert_table':false,
        'select_all':false,
        'togglescreen':false
    });*/
    
    

     //text-editor 3
     /*$(".editor3").Editor({


        'texteffects':false,
        'aligneffects':false,
        'textformats':false,
        'fonteffects':false,
        'actions' : false,
        'insertoptions': false,
        'extraeffects': false,
        'advancedoptions': false,
        'screeneffects':false,
                'bold': true,
                'italics': true,
                'underline':true,
                'ol':true,
                'ul':true,
        'undo':false,
        'redo':false,
        'l_align':false,
        'r_align':false,
        'c_align':false,
        'justify':false,
             'insert_link':true,
        'unlink':true,
                'insert_img':true,
        'hr_line':false,
        'block_quote':false,
        'source':false,
                'strikeout':true,
        'indent':false,
        'outdent':false,
        'fonts':false,
        'styles':false,
        'print':false,
        'rm_format':false,
        'status_bar':false,
        'font_size':false,
                
        'splchars':false,
        'insert_table':false,
        'select_all':false,
        'togglescreen':false
    });*/


  //text-editor 4
   /* $(".editor4").Editor(
    {
        //"setText": "Hello",
        'texteffects':false,
        'aligneffects':false,
        'textformats':false,
        'fonteffects':false,
        'actions' : false,
        'insertoptions': false,
        'extraeffects': false,
        'advancedoptions': false,
        'screeneffects':false,
        'bold': true,
        'italics': true,
        'underline':true,
        'ol':true,
        'ul':true,
        'undo':false,
        'redo':false,
        'l_align':false,
        'r_align':false,
        'c_align':false,
        'justify':false,
        'insert_link':true,
        'unlink':true,
        'insert_img':true,
        'hr_line':false,
        'block_quote':false,
        'source':false,
        'strikeout':true,
        'indent':false,
        'outdent':false,
        'fonts':false,
        'styles':false,
        'print':false,
        'rm_format':false,
        'status_bar':false,
        'font_size':false,        
        'splchars':false,
        'insert_table':false,
        'select_all':false,
        'togglescreen':false,
        
    });*/
//text-editor 5
   /* $(".editor5").Editor({
        'texteffects':false,
        'aligneffects':false,
        'textformats':false,
        'fonteffects':false,
        'actions' : false,
        'insertoptions': false,
        'extraeffects': false,
        'advancedoptions': false,
        'screeneffects':false,
        'bold': true,
        'italics': true,
        'underline':true,
        'ol':true,
        'ul':true,
        'undo':false,
        'redo':false,
        'l_align':false,
        'r_align':false,
        'c_align':false,
        'justify':false,
        'insert_link':true,
        'unlink':true,
        'insert_img':true,
        'hr_line':false,
        'block_quote':false,
        'source':false,
        'strikeout':true,
        'indent':false,
        'outdent':false,
        'fonts':false,
        'styles':false,
        'print':false,
        'rm_format':false,
        'status_bar':false,
        'font_size':false,        
        'splchars':false,
        'insert_table':false,
        'select_all':false,
        'togglescreen':false
    });*/
//text-editor 6
    /*$(".editor6").Editor({
        'texteffects':false,
        'aligneffects':false,
        'textformats':false,
        'fonteffects':false,
        'actions' : false,
        'insertoptions': false,
        'extraeffects': false,
        'advancedoptions': false,
        'screeneffects':false,
        'bold': true,
        'italics': true,
        'underline':true,
        'ol':true,
        'ul':true,
        'undo':false,
        'redo':false,
        'l_align':false,
        'r_align':false,
        'c_align':false,
        'justify':false,
        'insert_link':true,
        'unlink':true,
        'insert_img':true,
        'hr_line':false,
        'block_quote':false,
        'source':false,
        'strikeout':true,
        'indent':false,
        'outdent':false,
        'fonts':false,
        'styles':false,
        'print':false,
        'rm_format':false,
        'status_bar':false,
        'font_size':false,        
        'splchars':false,
        'insert_table':false,
        'select_all':false,
        'togglescreen':false
    });*/
//text-editor 7
    /*$(".editor7").Editor({
        'texteffects':false,
        'aligneffects':false,
        'textformats':false,
        'fonteffects':false,
        'actions' : false,
        'insertoptions': false,
        'extraeffects': false,
        'advancedoptions': false,
        'screeneffects':false,
        'bold': true,
        'italics': true,
        'underline':true,
        'ol':true,
        'ul':true,
        'undo':false,
        'redo':false,
        'l_align':false,
        'r_align':false,
        'c_align':false,
        'justify':false,
        'insert_link':true,
        'unlink':true,
        'insert_img':true,
        'hr_line':false,
        'block_quote':false,
        'source':false,
        'strikeout':true,
        'indent':false,
        'outdent':false,
        'fonts':false,
        'styles':false,
        'print':false,
        'rm_format':false,
        'status_bar':false,
        'font_size':false,        
        'splchars':false,
        'insert_table':false,
        'select_all':false,
        'togglescreen':false
    });*/
//text-editor 8
   /* $(".editor8").Editor({
        'texteffects':false,
        'aligneffects':false,
        'textformats':false,
        'fonteffects':false,
        'actions' : false,
        'insertoptions': false,
        'extraeffects': false,
        'advancedoptions': false,
        'screeneffects':false,
        'bold': true,
        'italics': true,
        'underline':true,
        'ol':true,
        'ul':true,
        'undo':false,
        'redo':false,
        'l_align':false,
        'r_align':false,
        'c_align':false,
        'justify':false,
        'insert_link':true,
        'unlink':true,
        'insert_img':true,
        'hr_line':false,
        'block_quote':false,
        'source':false,
        'strikeout':true,
        'indent':false,
        'outdent':false,
        'fonts':false,
        'styles':false,
        'print':false,
        'rm_format':false,
        'status_bar':false,
        'font_size':false,        
        'splchars':false,
        'insert_table':false,
        'select_all':false,
        'togglescreen':false
    });*/
//text-editor 9
    /*$(".editor9").Editor({
        'texteffects':false,
        'aligneffects':false,
        'textformats':false,
        'fonteffects':false,
        'actions' : false,
        'insertoptions': false,
        'extraeffects': false,
        'advancedoptions': false,
        'screeneffects':false,
        'bold': true,
        'italics': true,
        'underline':true,
        'ol':true,
        'ul':true,
        'undo':false,
        'redo':false,
        'l_align':false,
        'r_align':false,
        'c_align':false,
        'justify':false,
        'insert_link':true,
        'unlink':true,
        'insert_img':true,
        'hr_line':false,
        'block_quote':false,
        'source':false,
        'strikeout':true,
        'indent':false,
        'outdent':false,
        'fonts':false,
        'styles':false,
        'print':false,
        'rm_format':false,
        'status_bar':false,
        'font_size':false,        
        'splchars':false,
        'insert_table':false,
        'select_all':false,
        'togglescreen':false
    });*/
	//try{
        //google-map
    function initialize() {
        "use strict";

     //var description, telephone, email, web, markericon, marker, link, iw, directionsService, directionsDisplay ;
            var locations = [
                                ['<div class="infobox">121 King Street, Melbourne Victoria 3000<br />United States of America, CA 90017</div>', 40.5458921,-74.1843522, 2],
                                ['<div class="infobox">121 King Street, Melbourne Victoria 3000<br />United States of America, CA 90017</div>', 40.5458999,-74.1843522, 3],
                                ['<div class="infobox">121 King Street, Melbourne Victoria 3000<br />United States of America, CA 90017</div>', 40.6758921,-74.1843076, 4],
                                ['<div class="infobox">121 King Street, Melbourne Victoria 3000<br />United States of America, CA 90017</div>', 40.4453451,-74.1843522, 5],
                                ['<div class="infobox">121 King Street, Melbourne Victoria 3000<br />United States of America, CA 90017</div>', 40.3258921,-74.1003522, 6]
                        		 //['<div class="infobox"><h4>TRANSPORTER<i class="fa fa-star-o"></i></h4><div class="pull-left"><p class="brown">255 Church Cross Street <br>Victoria Australia 3000</p><p class="brown">Transporters.org.Aus</p><p class="brown"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><span>64 reviews</span></p></div><div class="pull-right"><img src="images/69.jpg" alt="#" class="img-responsive"></div><div class="clearfix"></div> <ul class="list-unstyled list-inline"><li><a href="#">Directions</a></li> <li><a href="#">Search nearby</a></li><li><a href="#">Save to map</a></li> <li ><div class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">More<i class="fa fa-caret-down"></i> </a><ul class="dropdown-menu" role="menu"><li><a href="#">More1</a></li> <li><a href="#">More2</a></li><li><a href="#">More3</a></li></ul></div></li></ul></div>', 39.5458921, -75.1843522],
                         		 //['<div class="infobox"><h4>TRANSPORTER<i class="fa fa-star-o"></i></h4><div class="pull-left"><p class="brown">255 Church Cross Street <br>Victoria Australia 3000</p><p class="brown">Transporters.org.Aus</p><p class="brown"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><span>64 reviews</span></p></div><div class="pull-right"><img src="images/69.jpg" alt="#" class="img-responsive"></div><div class="clearfix"></div> <ul class="list-unstyled list-inline"><li><a href="#">Directions</a></li> <li><a href="#">Search nearby</a></li><li><a href="#">Save to map</a></li> <li ><div class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">More<i class="fa fa-caret-down"></i> </a><ul class="dropdown-menu" role="menu"><li><a href="#">More1</a></li> <li><a href="#">More2</a></li><li><a href="#">More3</a></li></ul></div></li></ul></div>', 38.5458921, -76.1843522]
                  ];
            var mapCanvas = document.getElementById('map-street');
            var mapOptions = {
              center: new google.maps.LatLng(40.5458921, -74.1843522),
              zoom: 7,
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              styles: [
    {
        "featureType": "all",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "saturation": 36
            },
            {
                "color": "#000000"
            },
            {
                "lightness": 40
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#000000"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 17
            },
            {
                "weight": 1.2
            }
        ]
    },
    {
        "featureType": "administrative.country",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.locality",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.land_parcel",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape.natural",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 21
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 17
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 29
            },
            {
                "weight": 0.2
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 18
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 19
            }
        ]
    },
    {
        "featureType": "transit.station",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "on"
            },
        ]
    },
    {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#3f4178"
            },
            {
                "lightness": 17
            }
        ]
    }
]
            }
            var map = new google.maps.Map(mapCanvas, mapOptions);

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {  

              marker = new google.maps.Marker({ 
                position: new google.maps.LatLng(locations[i][1], locations[i][2]), 
                map: map ,
                icon: 'images/marker.png'
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(locations[i][0]);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
        }

       /* google.maps.event.addDomListener(window, 'load', initialize);*/
    //} catch(e) {
      //  console.log( 'google map error' );
    //}


    //Events slider

    function syncPosition(el){
        var current = this.currentItem;
        $(".sync2")
          .find(".owl-item")
          .removeClass("synced")
          .eq(current)
          .addClass("synced")
        if($(".sync2").data("owlCarousel") !== undefined){
          center(current)
        }
      }
    
    
    try {
        //property carousel
          var sync1 = $(".sync1");
          var sync2 = $(".sync2");
         
          sync1.owlCarousel({
            items: 1,
            itemsCustom: [[1300,1], [768,1], [600,1],[480,1],[320,1]],
            singleItem : true,
            slideSpeed : 1000,
            navigation: false,
            pagination:false,
            afterAction : syncPosition,
            responsiveRefreshRate : 200,
            scrollPerPage:1
          });
         
          sync2.owlCarousel({
            items : 8,
            itemsCustom: [[1300,8], [768,6], [600,5],[480,4],[320,3],[240,2]],
            pagination:false,
            responsiveRefreshRate : 100,
            afterInit : function(el){
              el.find(".owl-item").eq(0).addClass("synced");
            },
            scrollPerPage: 1
          });
         
          
         
          $(".sync2").on("click", ".owl-item", function(e){
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo",number);
          });
         
          
    } catch(e) {
        console.log( 'owl carousel custom script error '+e.message );
    }     
    

    //Tooltip

    try {
          $('[data-toggle="tooltip"]').tooltip();
      }
      catch(e) {
        console.log('tooltip error' +e.message) ;
      }
    


      //map 2
         /* google.maps.event.addDomListener(window, 'load', init);
    var map;
    function init() {
        "use strict";
        var mapOptions = {
            center: new google.maps.LatLng(51.507621,-0.127892),
            zoom: 16,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.DEFAULT,
            },
            disableDoubleClickZoom: true,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            },
            scaleControl: true,
            scrollwheel: true,
            panControl: true,
            streetViewControl: true,
            draggable : true,
            overviewMapControl: true,
            overviewMapControlOptions: {
                opened: false,
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: [ { "featureType": "landscape", "elementType": "labels", "stylers": [ { "visibility": "off" } ] },{ "featureType": "transit", "elementType": "labels", "stylers": [ { "visibility": "off" } ] },{ "featureType": "poi", "elementType": "labels", "stylers": [ { "visibility": "off" } ] },{ "featureType": "water", "elementType": "labels", "stylers": [ { "visibility": "off" } ] },{ "featureType": "road", "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] },{ "stylers": [ { "hue": "#00aaff" }, { "saturation": -100 }, { "gamma": 2.15 }, { "lightness": 12 } ] },{ "featureType": "road", "elementType": "labels.text.fill", "stylers": [ { "visibility": "on" }, { "lightness": 24 } ] },{ "featureType": "road", "elementType": "geometry", "stylers": [ { "lightness": 57 } ] } ],
        }
        var mapElement = document.getElementById('map');
        var map = new google.maps.Map(mapElement, mapOptions);
        var locations = [
        ['<div class="map-info"><div class="map-img"><img src="images/resources/map-img.jpg" alt="#" /></div><h6 class="text-orange f-lato text-bold double-border">My LMS University</h6><div class="uni-timing"><img src="images/resources/calender.jpg" alt="#" /><span class="f-lato text-bold text-purple">Mon-Sat: </span><span class="f-lato text-normal text-purple">7:00am - 9:00pm</span><span class="f-lato text-bold text-purple">Sun:</span><span class="f-lato text-normal text-purple">9:00am - 5:00pm</span></div>', 'undefined', 'undefined', 'undefined', 'undefined', 51.5073509, -0.12775829999998223, 'images/marker.png']
        ];
        for (i = 0; i < locations.length; i++) {
   if (locations[i][1] =='undefined'){ description ='';} else { description = locations[i][1];}
   if (locations[i][2] =='undefined'){ telephone ='';} else { telephone = locations[i][2];}
   if (locations[i][3] =='undefined'){ email ='';} else { email = locations[i][3];}
           if (locations[i][4] =='undefined'){ web ='';} else { web = locations[i][4];}
           if (locations[i][7] =='undefined'){ markericon ='';} else { markericon = locations[i][7];}
            marker = new google.maps.Marker({
                icon: markericon,
                position: new google.maps.LatLng(locations[i][5], locations[i][6]),
                map: map,
                title: locations[i][0],
                desc: description,
                tel: telephone,
                email: email,
                web: web
            });
link = '';            bindInfoWindow(marker, map, locations[i][0], description, telephone, email, web, link);
     }
 function bindInfoWindow(marker, map, title, desc, telephone, email, web, link) {
      var infoWindowVisible = (function () {
              var currentlyVisible = false;
              return function (visible) {
                  if (visible !== undefined) {
                      currentlyVisible = visible;
                  }
                  return currentlyVisible;
               };
           }());
           iw = new google.maps.InfoWindow();
           google.maps.event.addListener(marker, 'click', function() {
               if (infoWindowVisible()) {
                   iw.close();
                   infoWindowVisible(false);
               } else {
                   var html= "<div style='color:#000;background-color:#fff;padding:5px;width:370px;overflow:visible;'><h4>"+title+"</h4><p>"+desc+"<p></div>";
                   iw = new google.maps.InfoWindow({content:html});
                   iw.open(map,marker);
                   infoWindowVisible(true);
               }
        });
        google.maps.event.addListener(iw, 'closeclick', function () {
            infoWindowVisible(false);
        });
 }
}*/

//Search-box
    $('#search-click').on("click", function(){
        $('#search-now').addClass('show');
    });
    $(document).click(function(e){
      if ( !$(e.target).is('#search-click, #search-now, #search-click > i')) {
            $('#search-now').removeClass('show');
      }
    });

});

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47162752-1', 'wow-themes.com');
  ga('send', 'pageview');