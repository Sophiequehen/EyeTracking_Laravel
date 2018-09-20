@extends('layout.app')

@section('title')
{{ $comic->comic_title }} / Planche {{ $board->board_number }}
@endsection


@section('content')
<section class="page-titles">
	<h2>{{ $comic->comic_title }} - Planche n° {{ $board->board_number }}</h2>
	<p>/</p>
	<a id="full-screen" class="link-full-screen" href="{{ route('board-fullscreen',[$comic->comic_id, $board->board_id]) }}"><i class="material-icons">fullscreen</i><span>Lire en plein écran</span></a>
</section>

<div class="modal-delete-area">
	<p>Êtes-vous sûr(e) de vouloir supprimer cette zone ?</p>
	<div class="modal-delete-buttons">
		<div class="grp-delete-buttons"><a id="cancel-delete-area" href="">ANNULER</a></div>
		<div id="delete-area" class="grp-delete-buttons"><a href="">SUPPRIMER</a></div>
	</div>
</div>

<div class="container modify board-edit">
	<div class="card-body area">
		<div id="imgModif">

			@if ($board->board_number < count($allboards))
			<div class="board-pagination next"><a href="{{ route('board-edit',[$comic->comic_id, $nextboard->board_id]) }}"><img src="/img/next.png"></a></div>
			@endif
			@if ($board->board_number !== 1)
			<div class="board-pagination before"><a href="{{ route('board-edit',[$comic->comic_id, $previousboard->board_id]) }}"><img src="/img/previous.png"></a></div>
			@endif
			@if(Auth::check() && $comic->fk_user_id === Auth::user()->id || Auth::check() && Auth::user()->fk_role_id === 3) 
			<p id="see-areas" class="link-see-areas"><i class="material-icons">visibility</i><span>Voir toutes les zones</span></p>
			<p id="hide-areas" class="link-hide-areas" style="display: none"><i class="material-icons">visibility_off</i><span>Cacher les zones</span></p>
			@endif

			<img id="background_map" src="{{ $board->board_image }}" alt="Planets" usemap="#planetmap" class="map">

			@if(Auth::check() && $comic->fk_user_id === Auth::user()->id || Auth::check() && Auth::user()->fk_role_id === 3) 
			<a id="add-area" class="link-add-area" href="{{ route('mapping_create',[$comic->comic_id, $board->board_id]) }}"><i class="material-icons">add_circle</i><span>Ajouter des zones</span></a>
			@endif

			<map id="map_object" name="planetmap">
				@foreach ($areas as $zone) 
				<area id="map{{ $zone->area_id }}" shape="poly" coords="{{ $zone->area_coord }}" data-maphilight='{"alwaysOn": true,"strokeColor":"0000ff","strokeWidth":2,"fillColor":"0000ff","fillOpacity":0.6}' data-style= "without-media" href="">
				@endforeach
			</map>  
		</div>
	</div>
</div>
@foreach ($areas as $zone) 
@foreach ($medias as $media)
@if($media->media_id === $zone->fk_media_id)
<audio id="audio{{ $media->media_id }}"><source src="{{ $media->media_path }}" type="audio/mp3">
</audio>
@endif
@endforeach
@endforeach

@endsection

@section('extraJS')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!-- <script src="http://davidlynch.org/projects/maphilight/jquery.maphilight.js"></script> -->
<!-- <script src="/js/jquery.maphilight.js"></script> -->

<!-- Script to maphillight, davidlynch.org doesn't work because of the security certificate expired, and when the script is minified, it doesn't work -->
<script type="text/javascript">
	(function(root, factory) {
		if (typeof define === 'function' && define.amd) {
			define(['jquery'], factory);
		} else {
			factory(root.jQuery);
		}
	})(this, function($) {
		var has_VML, has_canvas, create_canvas_for, add_shape_to, clear_canvas, shape_from_area,
		canvas_style, hex_to_decimal, css3color, is_image_loaded, options_from_area;

		has_canvas = !!document.createElement('canvas').getContext;

	// VML: more complex
	has_VML = (function() {
		var a = document.createElement('div');
		a.innerHTML = '<v:shape id="vml_flag1" adj="1" />';
		var b = a.firstChild;
		b.style.behavior = "url(#default#VML)";
		return b ? typeof b.adj == "object": true;
	})();

	if(!(has_canvas || has_VML)) {
		$.fn.maphilight = function() { return this; };
		return;
	}

	if(has_canvas) {
		hex_to_decimal = function(hex) {
			return Math.max(0, Math.min(parseInt(hex, 16), 255));
		};
		css3color = function(color, opacity) {
			return 'rgba('+hex_to_decimal(color.substr(0,2))+','+hex_to_decimal(color.substr(2,2))+','+hex_to_decimal(color.substr(4,2))+','+opacity+')';
		};
		create_canvas_for = function(img) {
			var c = $('<canvas style="width:'+$(img).width()+'px;height:'+$(img).height()+'px;"></canvas>').get(0);
			c.getContext("2d").clearRect(0, 0, $(img).width(), $(img).height());
			return c;
		};
		var draw_shape = function(context, shape, coords, x_shift, y_shift) {
			x_shift = x_shift || 0;
			y_shift = y_shift || 0;

			context.beginPath();
			if(shape == 'rect') {
				// x, y, width, height
				context.rect(coords[0] + x_shift, coords[1] + y_shift, coords[2] - coords[0], coords[3] - coords[1]);
			} else if(shape == 'poly') {
				context.moveTo(coords[0] + x_shift, coords[1] + y_shift);
				for(i=2; i < coords.length; i+=2) {
					context.lineTo(coords[i] + x_shift, coords[i+1] + y_shift);
				}
			} else if(shape == 'circ') {
				// x, y, radius, startAngle, endAngle, anticlockwise
				context.arc(coords[0] + x_shift, coords[1] + y_shift, coords[2], 0, Math.PI * 2, false);
			}
			context.closePath();
		};
		add_shape_to = function(canvas, shape, coords, options, name) {
			var i, context = canvas.getContext('2d');

			// Because I don't want to worry about setting things back to a base state

			// Shadow has to happen first, since it's on the bottom, and it does some clip /
			// fill operations which would interfere with what comes next.
			if(options.shadow) {
				context.save();
				if(options.shadowPosition == "inside") {
					// Cause the following stroke to only apply to the inside of the path
					draw_shape(context, shape, coords);
					context.clip();
				}

				// Redraw the shape shifted off the canvas massively so we can cast a shadow
				// onto the canvas without having to worry about the stroke or fill (which
				// cannot have 0 opacity or width, since they're what cast the shadow).
				var x_shift = canvas.width * 100;
				var y_shift = canvas.height * 100;
				draw_shape(context, shape, coords, x_shift, y_shift);

				context.shadowOffsetX = options.shadowX - x_shift;
				context.shadowOffsetY = options.shadowY - y_shift;
				context.shadowBlur = options.shadowRadius;
				context.shadowColor = css3color(options.shadowColor, options.shadowOpacity);

				// Now, work out where to cast the shadow from! It looks better if it's cast
				// from a fill when it's an outside shadow or a stroke when it's an interior
				// shadow. Allow the user to override this if they need to.
				var shadowFrom = options.shadowFrom;
				if (!shadowFrom) {
					if (options.shadowPosition == 'outside') {
						shadowFrom = 'fill';
					} else {
						shadowFrom = 'stroke';
					}
				}
				if (shadowFrom == 'stroke') {
					context.strokeStyle = "rgba(0,0,0,1)";
					context.stroke();
				} else if (shadowFrom == 'fill') {
					context.fillStyle = "rgba(0,0,0,1)";
					context.fill();
				}
				context.restore();

				// and now we clean up
				if(options.shadowPosition == "outside") {
					context.save();
					// Clear out the center
					draw_shape(context, shape, coords);
					context.globalCompositeOperation = "destination-out";
					context.fillStyle = "rgba(0,0,0,1);";
					context.fill();
					context.restore();
				}
			}

			context.save();

			draw_shape(context, shape, coords);

			// fill has to come after shadow, otherwise the shadow will be drawn over the fill,
			// which mostly looks weird when the shadow has a high opacity
			if(options.fill) {
				context.fillStyle = css3color(options.fillColor, options.fillOpacity);
				context.fill();
			}
			// Likewise, stroke has to come at the very end, or it'll wind up under bits of the
			// shadow or the shadow-background if it's present.
			if(options.stroke) {
				context.strokeStyle = css3color(options.strokeColor, options.strokeOpacity);
				context.lineWidth = options.strokeWidth;
				context.stroke();
			}

			context.restore();

			if(options.fade) {
				$(canvas).css('opacity', 0).animate({opacity: 1}, 100);
			}
		};
		clear_canvas = function(canvas) {
			canvas.getContext('2d').clearRect(0, 0, canvas.width,canvas.height);
		};
	} else {   // ie executes this code
		create_canvas_for = function(img) {
			return $('<var style="zoom:1;overflow:hidden;display:block;width:'+img.width+'px;height:'+img.height+'px;"></var>').get(0);
		};
		add_shape_to = function(canvas, shape, coords, options, name) {
			var fill, stroke, opacity, e;
			for (var i in coords) { coords[i] = parseInt(coords[i], 10); }
				fill = '<v:fill color="#'+options.fillColor+'" opacity="'+(options.fill ? options.fillOpacity : 0)+'" />';
			stroke = (options.stroke ? 'strokeweight="'+options.strokeWidth+'" stroked="t" strokecolor="#'+options.strokeColor+'"' : 'stroked="f"');
			opacity = '<v:stroke opacity="'+options.strokeOpacity+'"/>';
			if(shape == 'rect') {
				e = $('<v:rect name="'+name+'" filled="t" '+stroke+' style="zoom:1;margin:0;padding:0;display:block;position:absolute;left:'+coords[0]+'px;top:'+coords[1]+'px;width:'+(coords[2] - coords[0])+'px;height:'+(coords[3] - coords[1])+'px;"></v:rect>');
			} else if(shape == 'poly') {
				e = $('<v:shape name="'+name+'" filled="t" '+stroke+' coordorigin="0,0" coordsize="'+canvas.width+','+canvas.height+'" path="m '+coords[0]+','+coords[1]+' l '+coords.join(',')+' x e" style="zoom:1;margin:0;padding:0;display:block;position:absolute;top:0px;left:0px;width:'+canvas.width+'px;height:'+canvas.height+'px;"></v:shape>');
			} else if(shape == 'circ') {
				e = $('<v:oval name="'+name+'" filled="t" '+stroke+' style="zoom:1;margin:0;padding:0;display:block;position:absolute;left:'+(coords[0] - coords[2])+'px;top:'+(coords[1] - coords[2])+'px;width:'+(coords[2]*2)+'px;height:'+(coords[2]*2)+'px;"></v:oval>');
			}
			e.get(0).innerHTML = fill+opacity;
			$(canvas).append(e);
		};
		clear_canvas = function(canvas) {
			// jquery1.8 + ie7
			var $html = $("<div>" + canvas.innerHTML + "</div>");
			$html.children('[name=highlighted]').remove();
			canvas.innerHTML = $html.html();
		};
	}

	shape_from_area = function(area) {
		var i, coords = area.getAttribute('coords').split(',');
		for (i=0; i < coords.length; i++) { coords[i] = parseFloat(coords[i]); }
			return [area.getAttribute('shape').toLowerCase().substr(0,4), coords];
	};

	options_from_area = function(area, options) {
		var $area = $(area);
		return $.extend({}, options, $.metadata ? $area.metadata() : false, $area.data('maphilight'));
	};

	is_image_loaded = function(img) {
		if(!img.complete) { return false; } // IE
		if(typeof img.naturalWidth != "undefined" && img.naturalWidth === 0) { return false; } // Others
		return true;
	};

	canvas_style = {
		position: 'absolute',
		left: 0,
		top: 0,
		padding: 0,
		border: 0
	};

	var ie_hax_done = false;
	$.fn.maphilight = function(opts) {
		opts = $.extend({}, $.fn.maphilight.defaults, opts);

		if(!has_canvas && !ie_hax_done) {
			$(window).ready(function() {
				document.namespaces.add("v", "urn:schemas-microsoft-com:vml");
				var style = document.createStyleSheet();
				var shapes = ['shape','rect', 'oval', 'circ', 'fill', 'stroke', 'imagedata', 'group','textbox'];
				$.each(shapes,
					function() {
						style.addRule('v\\:' + this, "behavior: url(#default#VML); antialias:true");
					}
					);
			});
			ie_hax_done = true;
		}

		return this.each(function() {
			var img, wrap, options, map, canvas, canvas_always, highlighted_shape, usemap;
			img = $(this);

			if(!is_image_loaded(this)) {
				// If the image isn't fully loaded, this won't work right.  Try again later.
				return window.setTimeout(function() {
					img.maphilight(opts);
				}, 200);
			}

			options = $.extend({}, opts, $.metadata ? img.metadata() : false, img.data('maphilight'));

			// jQuery bug with Opera, results in full-url#usemap being returned from jQuery's attr.
			// So use raw getAttribute instead.
			usemap = img.get(0).getAttribute('usemap');

			if (!usemap) {
				return;
			}

			map = $('map[name="'+usemap.substr(1)+'"]');

			if(!(img.is('img,input[type="image"]') && usemap && map.length > 0)) {
				return;
			}

			if(img.hasClass('maphilighted')) {
				// We're redrawing an old map, probably to pick up changes to the options.
				// Just clear out all the old stuff.
				var wrapper = img.parent();
				img.insertBefore(wrapper);
				wrapper.remove();
				$(map).unbind('.maphilight');
			}

			wrap = $('<div></div>').css({
				display:'block',
				backgroundImage:'url("'+this.src+'")',
				backgroundSize:'contain',
				position:'relative',
				padding:0,
				width:this.width,
				height:this.height
			});
			if(options.wrapClass) {
				if(options.wrapClass === true) {
					wrap.addClass($(this).attr('class'));
				} else {
					wrap.addClass(options.wrapClass);
				}
			}
			// Firefox has a bug that prevents tabbing into the image map if
			// we set opacity of the image to 0, but very nearly 0 works!
			img.before(wrap).css('opacity', 0.0000000001).css(canvas_style).remove();
			if(has_VML) { img.css('filter', 'Alpha(opacity=0)'); }
			wrap.append(img);

			canvas = create_canvas_for(this);
			$(canvas).css(canvas_style);
			canvas.height = this.height;
			canvas.width = this.width;

			$(map).bind('alwaysOn.maphilight', function() {
				// Check for areas with alwaysOn set. These are added to a *second* canvas,
				// which will get around flickering during fading.
				if(canvas_always) {
					clear_canvas(canvas_always);
				}
				if(!has_canvas) {
					$(canvas).empty();
				}
				$(map).find('area[coords]').each(function() {
					var shape, area_options;
					area_options = options_from_area(this, options);
					if(area_options.alwaysOn) {
						if(!canvas_always && has_canvas) {
							canvas_always = create_canvas_for(img[0]);
							$(canvas_always).css(canvas_style);
							canvas_always.width = img[0].width;
							canvas_always.height = img[0].height;
							img.before(canvas_always);
						}
						area_options.fade = area_options.alwaysOnFade; // alwaysOn shouldn't fade in initially
						shape = shape_from_area(this);
						if (has_canvas) {
							add_shape_to(canvas_always, shape[0], shape[1], area_options, "");
						} else {
							add_shape_to(canvas, shape[0], shape[1], area_options, "");
						}
					}
				});
			}).trigger('alwaysOn.maphilight')
			.bind('mouseover.maphilight focusin.maphilight', function(e) {
				var shape, area_options, area = e.target;
				area_options = options_from_area(area, options);
				if(!area_options.neverOn && !area_options.alwaysOn) {
					shape = shape_from_area(area);
					add_shape_to(canvas, shape[0], shape[1], area_options, "highlighted");
					if(area_options.groupBy) {
						var areas;
						// two ways groupBy might work; attribute and selector
						if(/^[a-zA-Z][\-a-zA-Z]+$/.test(area_options.groupBy)) {
							areas = map.find('area['+area_options.groupBy+'="'+$(area).attr(area_options.groupBy)+'"]');
						} else {
							areas = map.find(area_options.groupBy);
						}
						var first = area;
						areas.each(function() {
							if(this != first) {
								var subarea_options = options_from_area(this, options);
								if(!subarea_options.neverOn && !subarea_options.alwaysOn) {
									var shape = shape_from_area(this);
									add_shape_to(canvas, shape[0], shape[1], subarea_options, "highlighted");
								}
							}
						});
					}
					// workaround for IE7, IE8 not rendering the final rectangle in a group
					if(!has_canvas) {
						$(canvas).append('<v:rect></v:rect>');
					}
				}
			}).bind('mouseout.maphilight focusout.maphilight', function(e) { clear_canvas(canvas); });

			img.before(canvas); // if we put this after, the mouseover events wouldn't fire.

			img.addClass('maphilighted');
		});
};
$.fn.maphilight.defaults = {
	fill: true,
	fillColor: '000000',
	fillOpacity: 0.2,
	stroke: true,
	strokeColor: 'ff0000',
	strokeOpacity: 1,
	strokeWidth: 1,
	fade: true,
	alwaysOn: false,
	neverOn: false,
	groupBy: false,
	wrapClass: true,
		// plenty of shadow:
		shadow: false,
		shadowX: 0,
		shadowY: 0,
		shadowRadius: 6,
		shadowColor: '000000',
		shadowOpacity: 0.8,
		shadowPosition: 'outside',
		shadowFrom: false
	};
});

</script>
<!-- script to resize areas following the image -->
<script type="text/javascript">
     (function(modules) { // webpackBootstrap
    // The module cache
    var installedModules = {};

    // The require function
    function __webpack_require__(moduleId) {

        // Check if module is in cache
        if(installedModules[moduleId]) {
        	return installedModules[moduleId].exports;
        }
        // Create a new module (and put it into the cache)
        var module = installedModules[moduleId] = {
        	i: moduleId,
        	l: false,
        	exports: {}
        };

        // Execute the module function
        modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

        // Flag the module as loaded
        module.l = true;

        // Return the exports of the module
        return module.exports;
    }


    // expose the modules object (__webpack_modules__)
    __webpack_require__.m = modules;

    // expose the module cache
    __webpack_require__.c = installedModules;

    // define getter function for harmony exports
    __webpack_require__.d = function(exports, name, getter) {
    	if(!__webpack_require__.o(exports, name)) {
    		Object.defineProperty(exports, name, {
    			configurable: false,
    			enumerable: true,
    			get: getter
    		});
    	}
    };

    // getDefaultExport function for compatibility with non-harmony modules
    __webpack_require__.n = function(module) {
    	var getter = module && module.__esModule ?
    	function getDefault() { return module['default']; } :
    	function getModuleExports() { return module; };
    	__webpack_require__.d(getter, 'a', getter);
    	return getter;
    };

    // Object.prototype.hasOwnProperty.call
    __webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };

    // __webpack_public_path__
    __webpack_require__.p = "/";

    // Load entry module and return exports
    return __webpack_require__(__webpack_require__.s = 49);
})
     /************************************************************************/
     ({

     	49:
     	(function(module, exports, __webpack_require__) {

     		module.exports = __webpack_require__(50);


     	}),

     	50:
     	(function(module, exports, __webpack_require__) {

     		var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

     		!function () {
     			"use strict";
     			function a() {
     				function a() {
     					function a(a, d) {
     						function e(a) {
     							var d = 1 === (f = 1 - f) ? "width" : "height";return c[d] + Math.floor(Number(a) * b[d]);
     						}var f = 0;j[d].coords = a.split(",").map(e).join(",");
     					}var b = { width: l.width / l.naturalWidth, height: l.height / l.naturalHeight },
     					c = { width: parseInt(window.getComputedStyle(l, null).getPropertyValue("padding-left"), 10), height: parseInt(window.getComputedStyle(l, null).getPropertyValue("padding-top"), 10) };k.forEach(a);
     				}function b(a) {
     					return a.coords.replace(/ *, */g, ",").replace(/ +/g, ",");
     				}function c() {
     					clearTimeout(m), m = setTimeout(a, 250);
     				}function d() {
     					l.width === l.naturalWidth && l.height === l.naturalHeight || a();
     				}function e() {
     					l.addEventListener("load", a, !1), window.addEventListener("focus", a, !1), window.addEventListener("resize", c, !1), window.addEventListener("readystatechange", a, !1), document.addEventListener("fullscreenchange", a, !1);
     				}function f() {
     					return "function" == typeof i._resize;
     				}function g(a) {
     					return document.querySelector('img[usemap="' + a + '"]');
     				}function h() {
     					j = i.getElementsByTagName("area"), k = Array.prototype.map.call(j, b), l = g("#" + i.name) || g(i.name), i._resize = a;
     				}var i = this,
     				j = null,
     				k = null,
     				l = null,
     				m = null;f() ? i._resize() : (h(), e(), d());
     			}function b() {
     				function b(a) {
     					if (!a.tagName) throw new TypeError("Object is not a valid DOM element");if ("MAP" !== a.tagName.toUpperCase()) throw new TypeError("Expected <MAP> tag, found <" + a.tagName + ">.");
     				}function c(c) {
     					c && (b(c), a.call(c), d.push(c));
     				}var d;return function (a) {
     					switch (d = [], typeof a === "undefined" ? "undefined" : _typeof(a)) {case "undefined":case "string":
     					Array.prototype.forEach.call(document.querySelectorAll(a || "map"), c);break;case "object":
     					c(a);break;default:
     					throw new TypeError("Unexpected data type (" + (typeof a === "undefined" ? "undefined" : _typeof(a)) + ").");}return d;
     				};
     			} true ? !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (b),
     				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
     					(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
     				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && "object" == _typeof(module.exports) ? module.exports = b() : window.imageMapResize = b(), "jQuery" in window && (jQuery.fn.imageMapResize = function () {
     					return this.filter("map").each(a).end();
     				});
     			}();
     		})

     });
 </script>
 <script>
//To scale areas to their image
imageMapResize();
</script>

<script>
	$('#see-areas').click(function(){
		$('.map').maphilight();
		// $('area').css("cursor", "url(/img/delete.svg), pointer" );
		$('area').css("cursor", "url(/img/delete.png), pointer" );
		$( "#hide-areas" ).toggle();
		$( "#see-areas" ).toggle();
	});
	$('#hide-areas').click(function(){
		$( "#hide-areas" ).toggle();
		$( "#see-areas" ).toggle();
		location.reload(true);
	});

	$('#cancel-delete-area').click(function(event){
		event.preventDefault();
		$('.modal-delete-area').toggle();
	});
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$('area').each(function(){
		var data = $(this).data('maphilight');  
		$(this).click(function(event){
			event.preventDefault();
			// console.log($(this));
			console.log($(this)[0].attributes[0].nodeValue);
			var idtostore = $(this)[0].attributes[0].nodeValue.substr(3);
			// console.log($(this)[0].coords);
			console.log(idtostore);
			$('.modal-delete-area').toggle();
			$('#delete-area').html('<a href="/mapping/delete/'+idtostore+'">SUPPRIMER</a>');

// tests to post js variable in AjaxController to get a variable utilisable in blade
// finally the route is used directly with slashes with .html() so we can use the js variable but keep it in exemple
			// $.ajax({
			// 	/* the route pointing to the post function */
			// 	url: '/postajax',
			// 	type: 'POST',
			// 	/* send the csrf-token and the input to the controller */
			// 	data: {_token: CSRF_TOKEN, idstored: idtostore},
			// 	dataType: 'JSON',
			// 	/* remind that 'data' is the response of the AjaxController */
			// 	success: function (data) { 
			// 		console.log(data);
			// 		console.log(data.idArea);
			// 	}, 

			// 	error: function(error){
			// 		console.log('error');
			// 	}
			// })
		});
	});
</script>

<script type="text/javascript">

	var tabMedias = {!! json_encode($medias->toArray()) !!};
	var tabAreas = {!! json_encode($areas->toArray()) !!};

	console.log(tabMedias);
	console.log(tabAreas);

	Object.keys(tabAreas).forEach(function(area){

 // var value = obj[key];
	// tabAreas.forEach(function(area){
		tabMedias.forEach(function(media){


			var mediaId = media.media_id;
			// var zoneId = area.fk_media_id;
			var zoneId = tabAreas[area].area_id;
			var zoneMediaId = tabAreas[area].fk_media_id;

			// console.log(zone);

			if(mediaId === zoneMediaId){
				console.log('media'+mediaId);
				console.log('zone'+zoneId);

				// console.log(mediaId);
				// console.log(zoneId);

				var test = "test_" + mediaId;
				$( "#map" + zoneId ).hover(function() {
					$("#audio" + mediaId).animate({volume: 1}, 100);
					test = setTimeout(function(){document.getElementById('audio'+mediaId).play()}, 500);
				});
				$( "#map" + zoneId ).mouseout(function() {
					clearTimeout(test);
					$("#audio" + mediaId).animate({volume: 0}, 1000);
				});
			};
		});
	});
</script>
@endsection
