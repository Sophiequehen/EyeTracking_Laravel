@extends('layout.app')

@section('title')
Créer une zone
@endsection

@section('content')

<!-- ALERT UPON ADDING MEDIA -->
@if ($message = Session::get('add'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- ALERT UPON MEDIA CREATION FAILURE -->
@if ($message = Session::get('duplicate'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


<div class="container modify">

    @php if(isset($result)) echo $result; @endphp
    <div class="card-body area">
        <form class="area-form" method="post" action=" {{action('AreaController@store', [$comic->comic_id, $board->board_id])}}" enctype="multipart/form-data">
            @csrf

            <div class="area-form-manage">
                <!-- <div>
                    <div id="form-tps" >
                        <label for="tpsDeclenchement">Temps de déclenchement :</label>
                        <input type="number" name="trigger" class="form-control" id="tpsDeclenchement" value="1">
                        <p>Millisecondes</p>
                    </div>
                </div> -->
                
                <!-- if file does not comply / do not pass validations -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- if the sending in the db is successful. the two possible $ results are modifiable in mediascontroller line 45 & 50 -->
                <a id="go-board" class="link-go-board" href="{{ route('board-edit',[$comic->comic_id, $board->board_id]) }}"><i class="material-icons">arrow_back</i><span>Retourner à la planche</span></a>

                <select name="dataType" required>
                    <option selected disabled>Sélectionner un média</option> 
                    @foreach($medias as $media)
                    @if($media->media_type == 'son')
                    <option value="{{ $media->media_id }}">{{ $media->media_filename }}</option>
                    @endif
                    @endforeach
                </select>
                <a href="{{ route('medias_create_from_board',[$comic->comic_id, $board->board_id]) }}"><img class="add-media" src="/img/add.png"></a>
                <input type="submit" class="btn-outline" value="Valider"/>
            </div>

            <div id="imgModif">
                <!-- TO SEE ALL AREAS
                <div class="see-all">
                    <a class="" href="{{ route('mapping_show',[$board->board_id]) }}"><i class="material-icons">visibility</i><span>Voir toutes les zones</span></a>
                </div> -->
                <div class="page">

                    <textarea name="coords1" class="canvas-area input-xxlarge" placeholder="Shape Coordinates" data-image-url="{{ $board->board_image }}" style="display: none;">
                    </textarea>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection



@section('extraJS')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.js"></script>
<script src={{ asset("js/canvasAreaDraw.js") }}></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="http://davidlynch.org/projects/maphilight/jquery.maphilight.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.js"></script>

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
// //init the map for highlighting
$('.map').maphilight();

$(document).ready(function(){
    $('area').each(function(){
        //   console.log($(this), 'ici');
        var data = $(this).data('maphilight');  
        $(this).data('maphilight', data).trigger('alwaysOn.maphilight');
        $(this).click(function(){
            //    console.log($(this))
            //    redirige vers ./area/{id}
        });
    });
});
</script>
@endsection
