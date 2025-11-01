<html lang="en" class="layout-navbar-fixed layout-compact layout-menu-fixed layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="{{asset('assets/')}}"
    data-template="vertical-menu-template" data-bs-theme="default">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Venta</title>
    <script src="{{asset('assets/js/ui-toasts.js')}}"></script>

    <!-- Canonical SEO -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    <script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-5DDHKGP"></script>
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5DDHKGP');
    </script>
    <!-- End Google Tag Manager -->
    @vite([ 'resources/js/app.js'])
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/gato.svg')}}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/iconify-icons.css')}}">

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->
    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>

    <link rel="stylesheet" href="{{asset('assets/vendor/libs/pickr/pickr-themes.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}}">



    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icons.css')}}">


    <script>
        window.CUSTOMIZER_BASE = "{{ asset('assets/img/customizer') }}";
    </script>
    <!-- Page CSS -->


    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('assets/js/forms-file-upload.js')}}"></script>

    <style type="text/css">
        .layout-menu-fixed .layout-navbar-full .layout-menu,
        .layout-menu-fixed-offcanvas .layout-navbar-full .layout-menu {
            top: 64px !important;
        }

        .layout-page {
            padding-top: 64px !important;
        }

        .content-wrapper {
            padding-bottom: 54px !important;
        }
    </style>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>-->

    <style>
        #template-customizer {
            position: fixed;
            z-index: 99999999;
            display: flex;
            flex-direction: column;
            block-size: 100%;
            -webkit-box-direction: normal;
            -webkit-box-orient: vertical;
            box-shadow: 0 .3125rem 1.375rem 0 rgba(34, 48, 62, .18);
            font-family: "Public Sans", -apple-system, blinkmacsystemfont, "Segoe UI", Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            font-size: inherit;
            inline-size: 400px;
            inset-block-start: 0;
            inset-inline-end: 0;
            transform: translateX(420px);
            transition: transform .2s ease-in
        }

        [data-bs-theme=dark] #template-customizer {
            box-shadow: 0 .3125rem 1.375rem 0 rgba(20, 20, 29, .26)
        }

        #template-customizer h5 {
            position: relative;
            font-size: 11px
        }

        #template-customizer .form-label {
            font-size: .9375rem;
            font-weight: 500
        }

        #template-customizer .template-customizer-colors-options {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            margin: 0;
            gap: .3rem
        }

        #template-customizer .template-customizer-colors-options .custom-option {
            inline-size: 50px
        }

        #template-customizer .template-customizer-colors-options .custom-option .custom-option-content {
            padding: 0;
            min-block-size: 46px
        }

        #template-customizer .template-customizer-colors-options .custom-option .custom-option-content .pcr-button {
            padding: .625rem;
            block-size: 30px;
            inline-size: 30px
        }

        #template-customizer .template-customizer-colors-options .custom-option .custom-option-content .pcr-button::before,
        #template-customizer .template-customizer-colors-options .custom-option .custom-option-content .pcr-button::after {
            border-radius: .5rem
        }

        #template-customizer .template-customizer-colors-options .custom-option .custom-option-content .pcr-button:focus {
            box-shadow: none
        }

        #template-customizer .template-customizer-colors-options .custom-option-body {
            border-radius: .5rem;
            block-size: 30px;
            inline-size: 30px
        }

        #template-customizer .custom-option-icon {
            padding: 0
        }

        #template-customizer .custom-option-icon .custom-option-content {
            display: flex;
            align-items: center;
            justify-content: center;
            min-block-size: 50px
        }

        #template-customizer hr {
            border-color: var(--bs-border-color)
        }

        #template-customizer .custom-option {
            border-width: 2px;
            margin: 0
        }

        #template-customizer .custom-option.custom-option-image .custom-option-content .custom-option-body svg {
            inline-size: 100%
        }

        #template-customizer.template-customizer-open {
            transform: none;
            transition-delay: .1s
        }

        #template-customizer.template-customizer-open .template-customizer-theme .custom-option.checked {
            background-color: rgba(var(--bs-primary-rgb), 0.08)
        }

        #template-customizer.template-customizer-open .template-customizer-theme .custom-option.checked *,
        #template-customizer.template-customizer-open .template-customizer-theme .custom-option.checked *::before,
        #template-customizer.template-customizer-open .template-customizer-theme .custom-option.checked *::after {
            color: var(--bs-primary)
        }

        #template-customizer.template-customizer-open .custom-option.checked {
            border-width: 2px;
            color: var(--bs-primary)
        }

        #template-customizer.template-customizer-open .custom-option.checked .custom-option-content {
            border: none
        }

        #template-customizer .template-customizer-header a:hover,
        #template-customizer .template-customizer-header a:hover .icon-base {
            color: inherit !important
        }

        #template-customizer .template-customizer-open-btn {
            position: absolute;
            z-index: -1;
            display: block;
            background: var(--bs-primary);
            block-size: 38px;
            border-end-start-radius: .375rem;
            border-start-start-radius: .375rem;
            box-shadow: 0 .125rem .25rem 0 rgba(var(--bs-primary-rgb), 0.4);
            color: #fff;
            font-size: 18px;
            inline-size: 38px;
            inset-block-start: 180px;
            inset-inline-start: 0;
            line-height: 38px;
            opacity: 1;
            text-align: center;
            transform: translateX(-58px);
            transition: all .1s linear .2s
        }

        #template-customizer .template-customizer-open-btn::before {
            position: absolute;
            display: block;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAAXNSR0IArs4c6QAABClJREFUaEPtmY1RFEEQhbsjUCIQIhAiUCNQIxAiECIQIxAiECIAIpAMhAiECIQI2vquZqnZvp6fhb3SK5mqq6Ju92b69bzXf6is+dI1t1+eAfztG5z1BsxsU0S+ici2iPB3vm5E5EpEDlSVv2dZswFIxv8UkZcNy+5EZGcuEHMCOBeR951uvVDVD53vVl+bE8DvDu8Pxtyo6ta/BsByg1R15Bwzqz5/LJgn34CZwfnPInI4BUB6/1hV0cSjVxcAM4PbcBZjL0XklIPN7Is3fLCkdQPpPYw/VNXj5IhPIvJWRIhSl6p60ULWBGBm30Vk123EwRxCuIzWkkjNrCZywith10ewE1Xdq4GoAjCz/RTXW44Ynt+LyBEfT43kYfbj86J3w5Q32DNcRQDpwF+dkQXDMey8xem0L3TEqB4g3PZWad8agBMRgZPeu96D1/C2Zbh3X0p80Op1xxloztN48bMQQNoc7+eLEuAoPSPiIDY4Ooo+E6ixeNXM+D3GERz2U3CIqMstLJUgJQDe+7eq6mub0NYEkLAKwEHkiBQDCZtddZCZ8d6r7JDwFkoARklHRPZUFVDVZWbwGuNrC4EfdOzFrRABh3Wnqhv+d70AEBLGFROPmeHlnM81G69UdSd6IUuM0GgUVn1uqWmg5EmMfBeEyB7Pe3txBkY+rGT8j0J+WXq/BgDkUCaqLgEAnwcRog0veMIqFAAwCy2wnw+bI2GaGboBgF9k5N0o0rUSGUb4eO0BeO9j/GYhkSHMHMTIqwGARX6p6a+nlPBl8kZuXMD9j6pKfF9aZuaFOdJCEL5D4eYb9wCYVCanrBmGyii/tIq+SLj/HQBCaM5bLzwfPqdQ6FpVHyra4IbuVbXaY7dETC2ESPNNWiIOi69CcdgSMXsh4tNSUiklMgwmC0aNd08Y5WAES6HHehM4gu97wyhBgWpgqXsrASglprDy7CwhehMZOSbK6JMSma+Fio1KltCmlBIj7gfZOGx8ppQSXrhzFnOhJ/31BDkjFHRvOd09x0mRBA9SFgxUgHpQg0q0t5ymPMlL+EnldFTfDA0NAmf+OTQ0X0sRouf7NNkYGhrOYNrxtIaGg83MNzVDSe3LXLhP7O/yrCsCz1zlWTpjWkuZAOBpX3yVnLqI1yLCOKU6qMrmP7SSrUEw54XF4WBIK5FxCMOr3lVsfGqNSmPzBXUnJTIX1jyVBq9wO6UObOpgC5GjO98vFKnTdQMZXxEsWZlDiCZMIxAbNxQOqlpVZtobejBaZNoBnRDzMFpkxvTQOD36BlrcySZuI6p1ACB6LU3wWuf5581+oHfD1vi89bz3nFUC8Nm7ZlP3nKkFbM4bWPt/MSFwklprYItwt6cmvpWJ2IVcQBCz6bLysSCv3SaANCiTsnaNRrNRqMXVVT1/BrAqz/buu/Y38Ad3KC5PARej0QAAAABJRU5ErkJggg==);
            background-size: 100% 100%;
            block-size: 22px;
            content: "";
            inline-size: 22px;
            inset-block-start: 50%;
            inset-inline-start: 50%;
            transform: translate(-50%, -50%)
        }

        :dir(rtl) #template-customizer .template-customizer-open-btn::before {
            margin-inline-start: 2px;
            transform: translate(50%, -50%)
        }

        .customizer-hide #template-customizer .template-customizer-open-btn {
            display: none
        }

        :dir(rtl) #template-customizer .template-customizer-open-btn {
            transform: translateX(58px)
        }

        #template-customizer.template-customizer-open .template-customizer-open-btn {
            opacity: 0;
            transform: none;
            transition-delay: 0s
        }

        #template-customizer .template-customizer-inner {
            position: relative;
            overflow: auto;
            flex: 0 1 auto;
            -webkit-box-flex: 0;
            opacity: 1;
            transition: opacity .2s
        }

        @media(max-width: 1200px) {
            #template-customizer {
                display: none;
                visibility: hidden
            }
        }

        .layout-menu-100vh #template-customizer {
            block-size: 100dvh
        }

        :dir(rtl) #template-customizer:not(.template-customizer-open) {
            transform: translateX(-420px)
        }
    </style>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{asset('assets/js/config.js')}}"></script>
    <style id="custom-css">
        :root,
        [data-bs-theme=light],
        [data-bs-theme=dark] {
            --bs-primary: #B2606B;
            --bs-primary-rgb: 178, 96, 107;
            --bs-primary-bg-subtle: color-mix(in sRGB, var(--bs-paper-bg) 84%, #B2606B);
            --bs-primary-border-subtle: rgba(178, 96, 107, 0.3);
            --bs-primary-contrast: #fff
        }
    </style>

    <style id="apexcharts-css">
        @keyframes opaque {
            0% {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes resizeanim {

            0%,
            to {
                opacity: 0
            }
        }

        .apexcharts-canvas {
            position: relative;
            direction: ltr !important;
            user-select: none
        }

        .apexcharts-canvas ::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 6px
        }

        .apexcharts-canvas ::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: rgba(0, 0, 0, .5);
            box-shadow: 0 0 1px rgba(255, 255, 255, .5);
            -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5)
        }

        .apexcharts-inner {
            position: relative
        }

        .apexcharts-text tspan {
            font-family: inherit
        }

        rect.legend-mouseover-inactive,
        .legend-mouseover-inactive rect,
        .legend-mouseover-inactive path,
        .legend-mouseover-inactive circle,
        .legend-mouseover-inactive line,
        .legend-mouseover-inactive text.apexcharts-yaxis-title-text,
        .legend-mouseover-inactive text.apexcharts-yaxis-label {
            transition: .15s ease all;
            opacity: .2
        }

        .apexcharts-legend-text {
            padding-left: 15px;
            margin-left: -15px;
        }

        .apexcharts-series-collapsed {
            opacity: 0
        }

        .apexcharts-tooltip {
            border-radius: 5px;
            box-shadow: 2px 2px 6px -4px #999;
            cursor: default;
            font-size: 14px;
            left: 62px;
            opacity: 0;
            pointer-events: none;
            position: absolute;
            top: 20px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            white-space: nowrap;
            z-index: 12;
            transition: .15s ease all
        }

        .apexcharts-tooltip.apexcharts-active {
            opacity: 1;
            transition: .15s ease all
        }

        .apexcharts-tooltip.apexcharts-theme-light {
            border: 1px solid #e3e3e3;
            background: rgba(255, 255, 255, .96)
        }

        .apexcharts-tooltip.apexcharts-theme-dark {
            color: #fff;
            background: rgba(30, 30, 30, .8)
        }

        .apexcharts-tooltip * {
            font-family: inherit
        }

        .apexcharts-tooltip-title {
            padding: 6px;
            font-size: 15px;
            margin-bottom: 4px
        }

        .apexcharts-tooltip.apexcharts-theme-light .apexcharts-tooltip-title {
            background: #eceff1;
            border-bottom: 1px solid #ddd
        }

        .apexcharts-tooltip.apexcharts-theme-dark .apexcharts-tooltip-title {
            background: rgba(0, 0, 0, .7);
            border-bottom: 1px solid #333
        }

        .apexcharts-tooltip-text-goals-value,
        .apexcharts-tooltip-text-y-value,
        .apexcharts-tooltip-text-z-value {
            display: inline-block;
            margin-left: 5px;
            font-weight: 600
        }

        .apexcharts-tooltip-text-goals-label:empty,
        .apexcharts-tooltip-text-goals-value:empty,
        .apexcharts-tooltip-text-y-label:empty,
        .apexcharts-tooltip-text-y-value:empty,
        .apexcharts-tooltip-text-z-value:empty,
        .apexcharts-tooltip-title:empty {
            display: none
        }

        .apexcharts-tooltip-text-goals-label,
        .apexcharts-tooltip-text-goals-value {
            padding: 6px 0 5px
        }

        .apexcharts-tooltip-goals-group,
        .apexcharts-tooltip-text-goals-label,
        .apexcharts-tooltip-text-goals-value {
            display: flex
        }

        .apexcharts-tooltip-text-goals-label:not(:empty),
        .apexcharts-tooltip-text-goals-value:not(:empty) {
            margin-top: -6px
        }

        .apexcharts-tooltip-marker {
            width: 12px;
            height: 12px;
            position: relative;
            top: 0;
            margin-right: 10px;
            border-radius: 50%
        }

        .apexcharts-tooltip-series-group {
            padding: 0 10px;
            display: none;
            text-align: left;
            justify-content: left;
            align-items: center
        }

        .apexcharts-tooltip-series-group.apexcharts-active .apexcharts-tooltip-marker {
            opacity: 1
        }

        .apexcharts-tooltip-series-group.apexcharts-active,
        .apexcharts-tooltip-series-group:last-child {
            padding-bottom: 4px
        }

        .apexcharts-tooltip-y-group {
            padding: 6px 0 5px
        }

        .apexcharts-custom-tooltip,
        .apexcharts-tooltip-box {
            padding: 4px 8px
        }

        .apexcharts-tooltip-boxPlot {
            display: flex;
            flex-direction: column-reverse
        }

        .apexcharts-tooltip-box>div {
            margin: 4px 0
        }

        .apexcharts-tooltip-box span.value {
            font-weight: 700
        }

        .apexcharts-tooltip-rangebar {
            padding: 5px 8px
        }

        .apexcharts-tooltip-rangebar .category {
            font-weight: 600;
            color: #777
        }

        .apexcharts-tooltip-rangebar .series-name {
            font-weight: 700;
            display: block;
            margin-bottom: 5px
        }

        .apexcharts-xaxistooltip,
        .apexcharts-yaxistooltip {
            opacity: 0;
            pointer-events: none;
            color: #373d3f;
            font-size: 13px;
            text-align: center;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
            background: #eceff1;
            border: 1px solid #90a4ae
        }

        .apexcharts-xaxistooltip {
            padding: 9px 10px;
            transition: .15s ease all
        }

        .apexcharts-xaxistooltip.apexcharts-theme-dark {
            background: rgba(0, 0, 0, .7);
            border: 1px solid rgba(0, 0, 0, .5);
            color: #fff
        }

        .apexcharts-xaxistooltip:after,
        .apexcharts-xaxistooltip:before {
            left: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none
        }

        .apexcharts-xaxistooltip:after {
            border-color: transparent;
            border-width: 6px;
            margin-left: -6px
        }

        .apexcharts-xaxistooltip:before {
            border-color: transparent;
            border-width: 7px;
            margin-left: -7px
        }

        .apexcharts-xaxistooltip-bottom:after,
        .apexcharts-xaxistooltip-bottom:before {
            bottom: 100%
        }

        .apexcharts-xaxistooltip-top:after,
        .apexcharts-xaxistooltip-top:before {
            top: 100%
        }

        .apexcharts-xaxistooltip-bottom:after {
            border-bottom-color: #eceff1
        }

        .apexcharts-xaxistooltip-bottom:before {
            border-bottom-color: #90a4ae
        }

        .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark:after,
        .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark:before {
            border-bottom-color: rgba(0, 0, 0, .5)
        }

        .apexcharts-xaxistooltip-top:after {
            border-top-color: #eceff1
        }

        .apexcharts-xaxistooltip-top:before {
            border-top-color: #90a4ae
        }

        .apexcharts-xaxistooltip-top.apexcharts-theme-dark:after,
        .apexcharts-xaxistooltip-top.apexcharts-theme-dark:before {
            border-top-color: rgba(0, 0, 0, .5)
        }

        .apexcharts-xaxistooltip.apexcharts-active {
            opacity: 1;
            transition: .15s ease all
        }

        .apexcharts-yaxistooltip {
            padding: 4px 10px
        }

        .apexcharts-yaxistooltip.apexcharts-theme-dark {
            background: rgba(0, 0, 0, .7);
            border: 1px solid rgba(0, 0, 0, .5);
            color: #fff
        }

        .apexcharts-yaxistooltip:after,
        .apexcharts-yaxistooltip:before {
            top: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none
        }

        .apexcharts-yaxistooltip:after {
            border-color: transparent;
            border-width: 6px;
            margin-top: -6px
        }

        .apexcharts-yaxistooltip:before {
            border-color: transparent;
            border-width: 7px;
            margin-top: -7px
        }

        .apexcharts-yaxistooltip-left:after,
        .apexcharts-yaxistooltip-left:before {
            left: 100%
        }

        .apexcharts-yaxistooltip-right:after,
        .apexcharts-yaxistooltip-right:before {
            right: 100%
        }

        .apexcharts-yaxistooltip-left:after {
            border-left-color: #eceff1
        }

        .apexcharts-yaxistooltip-left:before {
            border-left-color: #90a4ae
        }

        .apexcharts-yaxistooltip-left.apexcharts-theme-dark:after,
        .apexcharts-yaxistooltip-left.apexcharts-theme-dark:before {
            border-left-color: rgba(0, 0, 0, .5)
        }

        .apexcharts-yaxistooltip-right:after {
            border-right-color: #eceff1
        }

        .apexcharts-yaxistooltip-right:before {
            border-right-color: #90a4ae
        }

        .apexcharts-yaxistooltip-right.apexcharts-theme-dark:after,
        .apexcharts-yaxistooltip-right.apexcharts-theme-dark:before {
            border-right-color: rgba(0, 0, 0, .5)
        }

        .apexcharts-yaxistooltip.apexcharts-active {
            opacity: 1
        }

        .apexcharts-yaxistooltip-hidden {
            display: none
        }

        .apexcharts-xcrosshairs,
        .apexcharts-ycrosshairs {
            pointer-events: none;
            opacity: 0;
            transition: .15s ease all
        }

        .apexcharts-xcrosshairs.apexcharts-active,
        .apexcharts-ycrosshairs.apexcharts-active {
            opacity: 1;
            transition: .15s ease all
        }

        .apexcharts-ycrosshairs-hidden {
            opacity: 0
        }

        .apexcharts-selection-rect {
            cursor: move
        }

        .svg_select_shape {
            stroke-width: 1;
            stroke-dasharray: 10 10;
            stroke: black;
            stroke-opacity: 0.1;
            pointer-events: none;
            fill: none;
        }

        .svg_select_handle {
            stroke-width: 3;
            stroke: black;
            fill: none;
        }

        .svg_select_handle_r {
            cursor: e-resize;
        }

        .svg_select_handle_l {
            cursor: w-resize;
        }

        .apexcharts-svg.apexcharts-zoomable.hovering-zoom {
            cursor: crosshair
        }

        .apexcharts-svg.apexcharts-zoomable.hovering-pan {
            cursor: move
        }

        .apexcharts-menu-icon,
        .apexcharts-pan-icon,
        .apexcharts-reset-icon,
        .apexcharts-selection-icon,
        .apexcharts-toolbar-custom-icon,
        .apexcharts-zoom-icon,
        .apexcharts-zoomin-icon,
        .apexcharts-zoomout-icon {
            cursor: pointer;
            width: 20px;
            height: 20px;
            line-height: 24px;
            color: #6e8192;
            text-align: center
        }

        .apexcharts-menu-icon svg,
        .apexcharts-reset-icon svg,
        .apexcharts-zoom-icon svg,
        .apexcharts-zoomin-icon svg,
        .apexcharts-zoomout-icon svg {
            fill: #6e8192
        }

        .apexcharts-selection-icon svg {
            fill: #444;
            transform: scale(.76)
        }

        .apexcharts-theme-dark .apexcharts-menu-icon svg,
        .apexcharts-theme-dark .apexcharts-pan-icon svg,
        .apexcharts-theme-dark .apexcharts-reset-icon svg,
        .apexcharts-theme-dark .apexcharts-selection-icon svg,
        .apexcharts-theme-dark .apexcharts-toolbar-custom-icon svg,
        .apexcharts-theme-dark .apexcharts-zoom-icon svg,
        .apexcharts-theme-dark .apexcharts-zoomin-icon svg,
        .apexcharts-theme-dark .apexcharts-zoomout-icon svg {
            fill: #f3f4f5
        }

        .apexcharts-canvas .apexcharts-reset-zoom-icon.apexcharts-selected svg,
        .apexcharts-canvas .apexcharts-selection-icon.apexcharts-selected svg,
        .apexcharts-canvas .apexcharts-zoom-icon.apexcharts-selected svg {
            fill: #008ffb
        }

        .apexcharts-theme-light .apexcharts-menu-icon:hover svg,
        .apexcharts-theme-light .apexcharts-reset-icon:hover svg,
        .apexcharts-theme-light .apexcharts-selection-icon:not(.apexcharts-selected):hover svg,
        .apexcharts-theme-light .apexcharts-zoom-icon:not(.apexcharts-selected):hover svg,
        .apexcharts-theme-light .apexcharts-zoomin-icon:hover svg,
        .apexcharts-theme-light .apexcharts-zoomout-icon:hover svg {
            fill: #333
        }

        .apexcharts-menu-icon,
        .apexcharts-selection-icon {
            position: relative
        }

        .apexcharts-reset-icon {
            margin-left: 5px
        }

        .apexcharts-menu-icon,
        .apexcharts-reset-icon,
        .apexcharts-zoom-icon {
            transform: scale(.85)
        }

        .apexcharts-zoomin-icon,
        .apexcharts-zoomout-icon {
            transform: scale(.7)
        }

        .apexcharts-zoomout-icon {
            margin-right: 3px
        }

        .apexcharts-pan-icon {
            transform: scale(.62);
            position: relative;
            left: 1px;
            top: 0
        }

        .apexcharts-pan-icon svg {
            fill: #fff;
            stroke: #6e8192;
            stroke-width: 2
        }

        .apexcharts-pan-icon.apexcharts-selected svg {
            stroke: #008ffb
        }

        .apexcharts-pan-icon:not(.apexcharts-selected):hover svg {
            stroke: #333
        }

        .apexcharts-toolbar {
            position: absolute;
            z-index: 11;
            max-width: 176px;
            text-align: right;
            border-radius: 3px;
            padding: 0 6px 2px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .apexcharts-menu {
            background: #fff;
            position: absolute;
            top: 100%;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 3px;
            right: 10px;
            opacity: 0;
            min-width: 110px;
            transition: .15s ease all;
            pointer-events: none
        }

        .apexcharts-menu.apexcharts-menu-open {
            opacity: 1;
            pointer-events: all;
            transition: .15s ease all
        }

        .apexcharts-menu-item {
            padding: 6px 7px;
            font-size: 12px;
            cursor: pointer
        }

        .apexcharts-theme-light .apexcharts-menu-item:hover {
            background: #eee
        }

        .apexcharts-theme-dark .apexcharts-menu {
            background: rgba(0, 0, 0, .7);
            color: #fff
        }

        @media screen and (min-width:768px) {
            .apexcharts-canvas:hover .apexcharts-toolbar {
                opacity: 1
            }
        }

        .apexcharts-canvas .apexcharts-element-hidden,
        .apexcharts-datalabel.apexcharts-element-hidden,
        .apexcharts-hide .apexcharts-series-points {
            opacity: 0;
        }

        .apexcharts-hidden-element-shown {
            opacity: 1;
            transition: 0.25s ease all;
        }

        .apexcharts-datalabel,
        .apexcharts-datalabel-label,
        .apexcharts-datalabel-value,
        .apexcharts-datalabels,
        .apexcharts-pie-label {
            cursor: default;
            pointer-events: none
        }

        .apexcharts-pie-label-delay {
            opacity: 0;
            animation-name: opaque;
            animation-duration: .3s;
            animation-fill-mode: forwards;
            animation-timing-function: ease
        }

        .apexcharts-radialbar-label {
            cursor: pointer;
        }

        .apexcharts-annotation-rect,
        .apexcharts-area-series .apexcharts-area,
        .apexcharts-gridline,
        .apexcharts-line,
        .apexcharts-point-annotation-label,
        .apexcharts-radar-series path:not(.apexcharts-marker),
        .apexcharts-radar-series polygon,
        .apexcharts-toolbar svg,
        .apexcharts-tooltip .apexcharts-marker,
        .apexcharts-xaxis-annotation-label,
        .apexcharts-yaxis-annotation-label,
        .apexcharts-zoom-rect,
        .no-pointer-events {
            pointer-events: none
        }

        .apexcharts-tooltip-active .apexcharts-marker {
            transition: .15s ease all
        }

        .resize-triggers {
            animation: 1ms resizeanim;
            visibility: hidden;
            opacity: 0;
            height: 100%;
            width: 100%;
            overflow: hidden
        }

        .contract-trigger:before,
        .resize-triggers,
        .resize-triggers>div {
            content: " ";
            display: block;
            position: absolute;
            top: 0;
            left: 0
        }

        .resize-triggers>div {
            height: 100%;
            width: 100%;
            background: #eee;
            overflow: auto
        }

        .contract-trigger:before {
            overflow: hidden;
            width: 200%;
            height: 200%
        }

        .apexcharts-bar-goals-markers {
            pointer-events: none
        }

        .apexcharts-bar-shadows {
            pointer-events: none
        }

        .apexcharts-rangebar-goals-markers {
            pointer-events: none
        }

        #aa-DetachedContainer.aa-DetachedContainer--modal {
            display: none;
            /* Oculto hasta que se active */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
            z-index: 9999;
        }

        .aa-DetachedOverlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            display: flex;
            justify-content: center;
            align-items: start;
            padding-top: 5%;
        }

        .aa-DetachedContainer {
            background: #fff;
            border-radius: 12px;
            width: 600px;
            max-height: 80%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .aa-Input {
            font-size: 16px;
            padding: 10px;
            outline: none;
            width: 100%;
        }

        .command-item {
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
        }

        .command-item:hover,
        .command-item.active {
            background: #f5f5f5;
        }
         #commandResults {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* dos columnas */
    gap: 0.75rem; /* espacio entre columnas y filas */
    max-height: 400px; /* altura máxima */
    overflow-y: auto;  /* scroll vertical */
  }

  /* Cada item del listado */
  #commandResults .command-item {
    background: #f8f9fa;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: background 0.2s ease;
  }

  #commandResults .command-item:hover {
    background: #e9ecef;
  }
    </style>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'system';
            let themeToApply = savedTheme;

            if (savedTheme === 'system') {
                themeToApply = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            document.documentElement.setAttribute('data-bs-theme', themeToApply);
        })();
    </script>
    <script>
        (function() {
            // Color guardado en localStorage
            const savedColor = localStorage.getItem('primaryColor') || '#696cff';

            // Aplicar color como variable CSS antes de que se pinte la página
            document.documentElement.style.setProperty('--bs-primary', savedColor);

            // Si quieres, también puedes aplicar a otros colores usados en tu customizer
            // document.documentElement.style.setProperty('--bs-success', savedSuccessColor);
        })();
    </script>

</head>

<body class="{{ $bodyClass }}" style="--bs-scrollbar-width: 15px;">

    <!-- ?PROD Only: Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu" style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

                <div class="app-brand demo">
                    <a href="{{ route('Inicio') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <span class="text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="2000" height="2000"
                                    viewBox="0 0 1500 1500"
                                    fill="currentColor">

                                    <path d="M 1199 1844.933594 C 1197.101562 
                                    1861.714844 1185.410156 1871.304688 1170.398438 1876.808594 C 1169.558594 1877.109375 1169.738281 1878.332031 
                                    1170.640625 1878.386719 C 1173.308594 1878.523438 1177.261719 1877.296875 1179.390625 1877.296875 C 1203.199219 
                                    1877.078125 1227.058594 1877.460938 1250.960938 1878.441406 C 1252.179688 1878.496094 1252.269531 1878.167969 1251.261719 
                                    1877.488281 C 1235.640625 1867.082031 1227.609375 1859.097656 1220.039062 1841.609375 C 1212.320312 1823.765625 1205 1805.675781 
                                    1196.578125 1788.375 C 1180.691406 1755.710938 1164.839844 1723.019531 1148.980469 1690.328125 C 1148.609375 1689.566406 1147.480469 
                                    1689.648438 1147.210938 1690.4375 C 1135.5 1723.046875 1113.410156 1759.988281 1083.769531 1779.46875 C 1082.921875 1780.011719 
                                    1083.359375 1781.347656 1084.359375 1781.292969 C 1103.628906 1780.503906 1122.859375 1781.566406 1142.039062 1784.480469 
                                    C 1172.578125 1789.113281 1202.839844 1811.453125 1199 1844.933594 M 610.253906 1876.96875 C 602.652344 1872.9375 596.085938 
                                    1867.625 590.558594 1861.0625 C 589.957031 1860.351562 589.195312 1859.996094 588.292969 1859.972656 C 380.921875 1853.269531 
                                    221.359375 1740.484375 205.421875 1523.054688 C 196.1875 1397.03125 227.105469 1261.824219 301.589844 1158.191406 C 316.054688 
                                    1138.082031 332.398438 1122.609375 350.652344 1111.742188 C 389.230469 1088.773438 425.761719 1117.871094 413.257812 1160.070312 
                                    C 409.90625 1171.402344 405.492188 1182.355469 400.019531 1192.898438 C 344.167969 1300.425781 316.21875 1433.753906 341.988281 
                                    1553.105469 C 363.074219 1650.855469 421.402344 1714.902344 523.675781 1732.285156 C 524.871094 1732.472656 525.308594 1732.011719 
                                    524.980469 1730.839844 C 513.566406 1689.972656 505.640625 1648.183594 501.226562 1605.496094 C 480.085938 1400.625 514.765625 
                                    1185.921875 635.5625 1015.925781 C 699.472656 925.941406 784.144531 860.910156 871.539062 795.558594 C 911.207031 765.921875 951.0625 
                                    727.609375 953.324219 675.140625 C 953.925781 660.730469 954.304688 639.160156 954.46875 610.410156 C 954.496094 605.699219 955.804688 
                                    598.671875 958.335938 589.300781 C 968.664062 551.429688 990.566406 518.308594 992.117188 477.738281 C 992.664062 463.550781 989.066406
                                    448.621094 986.34375 434.148438 C 983.617188 419.550781 984.683594 402.980469 989.558594 384.429688 C 993.699219 368.660156 1002.578125 344.140625 1016.199219 310.929688 C 1032.679688 270.769531 1050.089844 231.03125 1068.480469 191.691406 C 1081.5 163.871094 1089.789062 141.421875 1095.691406 114.148438 C 1095.859375 113.339844 1096.949219 113.140625 1097.410156 113.828125 C 1105.96875 126.390625 1113.890625 139.429688 1121.21875 152.96875 C 1140.871094 189.339844 1159.121094 226.371094 1175.980469 263.988281 C 1176.148438 264.371094 1176.691406 264.449219 1176.960938 264.101562 L 1261.988281 156.898438 C 1262.691406 156 1264.109375 156.378906 1264.328125 157.5 L 1290.980469 298.070312 C 1291.25 299.429688 1292.339844 300.519531 1293.699219 300.738281 C 1331.378906 306.949219 1362.300781 324.820312 1386.460938 354.359375 C 1390.089844 358.800781 1395.941406 362.148438 1404.039062 364.378906 C 1411.230469 366.371094 1417.078125 370.890625 1410.359375 378.078125 C 1409.761719 378.710938 1409.460938 379.578125 1409.539062 380.449219 C 1410.648438 393.5 1411.988281 408.410156 1420.628906 418.539062 C 1426.921875 425.949219 1434.570312 431.621094 1443.570312 435.570312 C 1451.359375 438.941406 1460.671875 438.621094 1469.421875 439.761719 C 1489.328125 442.320312 1470.429688 473.25 1463.78125 480.359375 C 1463.179688 481.011719 1462.800781 481.769531 1462.609375 482.671875 C 1458.410156 503.101562 1457.429688 517.648438 1443.320312 534.429688 C 1419.730469 562.488281 1389.320312 571.480469 1353.820312 581.179688 C 1341.699219 584.480469 1331.429688 590.820312 1323.039062 600.21875 C 1290.398438 636.761719 1331.761719 687.070312 1351.128906 717.941406 C 1363.46875 737.578125 1369.949219 757.660156 1370.640625 778.179688 C 1371.289062 797.980469 1362.929688 819.070312 1363.039062 839.988281 C 1363.109375 853.480469 1365.289062 865.730469 1369.628906 876.800781 C 1395.210938 942.148438 1392.808594 1006.800781 1362.488281 1070.738281 C 1349.980469 1097.136719 1339.140625 1118.496094 1329.988281 1134.871094 C 1301.03125 1186.660156 1284.191406 1242.96875 1279.480469 1303.75 C 1276.699219 1339.765625 1275.148438 1370.222656 1276.320312 1407.328125 C 1278.769531 1483.582031 1280.628906 1559.832031 1281.851562 1636.117188 C 1282.53125 1677.25 1285.28125 1718.144531 1298.980469 1757.753906 C 1303.019531 1769.441406 1309.75 1778.621094 1319.171875 1785.296875 C 1319.960938 1785.871094 1320.859375 1786.140625 1321.820312 1786.140625 C 1345.109375 1786.46875 1363.328125 1794.640625 1376.550781 1810.632812 C 1385.941406 1822.046875 1390.410156 1833.679688 1389.890625 1845.503906 C 1389.238281 1860.515625 1379.761719 1871.332031 1361.429688 1877.980469 C 1361.261719 1878.035156 1361.289062 1878.304688 1361.480469 1878.304688 L 1502.328125 1883.644531 C 1503.5 1883.671875 1503.53125 1883.945312 1502.460938 1884.410156 C 1501.160156 1884.980469 1499.960938 1885.253906 1498.890625 1885.226562 C 1439.179688 1885.007812 1379.488281 1886.640625 1319.769531 1886.585938 C 1081.390625 1886.398438 843.019531 1886.371094 604.640625 1886.5625 C 539.992188 1886.585938 475.316406 1885.117188 410.695312 1884.734375 C 410.589844 1884.734375 410.480469 1884.652344 410.480469 1884.542969 C 410.453125 1884.410156 410.535156 1884.328125 410.644531 1884.296875 C 414.292969 1883.617188 418 1883.210938 421.757812 1883.074219 C 482.046875 1880.921875 542.308594 1879.121094 602.597656 1877.652344 C 605.023438 1877.597656 607.476562 1877.707031 609.953125 1878.003906 C 611.886719 1878.25 611.96875 1877.898438 610.253906 1876.96875 " />
                                </svg>
                            </span>
                        </span>

                        <span class="app-brand-text demo menu-text fw-bold ms-2">TUXON</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="icon-base bx bx-chevron-left"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1 ps ps--active-y">
                    <!-- Dashboards -->
                    <li class="menu-item {{ Request::routeIs('Inicio') ? 'active open' : '' }}">
                        <a href="{{ route('Inicio') }}" class="menu-link">
                            <i class="menu-icon icon-base bx bx-home-smile"></i>
                            <div data-i18n="Inicio">Inicio</div>
                        </a>
                    </li>

                    <!-- Apps & Pages -->
                    <li class="menu-header small">
                        <span class="menu-header-text" data-i18n="Modulo">Modulo</span>
                    </li>
                    <li class="menu-item {{ Request::routeIs('Empresa') ? 'active' : '' }}">
                        <a href="{{ route('Empresa') }}" class="menu-link">
                            <i class="menu-icon icon-base bx bx-buildings"></i>
                            <div data-i18n="Empresa">Empresa</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::routeIs('Cliente') ? 'active' : '' }}">
                        <a href="{{ route('Cliente') }}" class="menu-link">
                            <i class="menu-icon icon-base bx bx-user-circle"></i>
                            <div data-i18n="Cliente">Cliente</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::routeIs('sucursal.index') ? 'active' : '' }}">
                        <a href="{{ route('sucursal.index') }}" class="menu-link">
                            <i class="menu-icon icon-base bx bx-git-branch"></i>
                            <div data-i18n="Sucursal">Sucursal</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::routeIs('almacen.index') ? 'active' : '' }}">
                        <a href="{{ route('almacen.index') }}" class="menu-link">
                            <i class="menu-icon icon-base bx bx-store-alt"></i>
                            <div data-i18n="Almacen">Almacén</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::routeIs('productos.index') || Request::routeIs('categorias.index') || Request::routeIs('unidad_medida.index') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-package"></i>
                            <div data-i18n="Productos">Productos</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::routeIs('categorias.index') ? 'active' : '' }}">
                                <a href="{{ route('categorias.index') }}" class="menu-link">
                                    <div data-i18n="Categoría">Categoría</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::routeIs('unidad_medida.index') ? 'active' : '' }}">
                                <a href="{{ route('unidad_medida.index') }}" class="menu-link">
                                    <div data-i18n="Unidad de medida">Unidad de medida</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::routeIs('productos.index') ? 'active' : '' }}">
                                <a href="{{ route('productos.index') }}" class="menu-link">
                                    <div data-i18n="Registrar Producto">Registrar Producto</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::routeIs('producto.importar') ? 'active' : '' }}">
                                <a href="{{ route('producto.importar') }}" class="menu-link">
                                    <div data-i18n="Importar productos">Importar productos</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ Request::routeIs('Crear Usuario') ? 'active' : '' }}">
                        <a href="{{ route('Crear Usuario') }}" class="menu-link">
                            <i class="menu-icon icon-base bx bx-user-plus"></i>
                            <div data-i18n="Crear Usuario">Crear Usuario</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::routeIs('rol.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-check-shield"></i>
                            <div data-i18n="Roles &amp; Permissions">Roles &amp; Permissions</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::routeIs('rol.index') ? 'active' : '' }}">
                                <a href="{{ route('rol.index') }}" class="menu-link">
                                    <div data-i18n="Roles">Roles</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::routeIs('permiso.*') ? 'active' : '' }}">
                                <a href="" class="menu-link">
                                    <div data-i18n="Permisos">Permisos</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item {{ Request::routeIs('venta.*') ? 'active open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon bx bx-cart"></i>
                            <div data-i18n="Ventas">Ventas</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::routeIs('ventas.index') ? 'active' : '' }}">
                                <a href="{{ route('ventas.index') }}" class="menu-link">
                                    <div data-i18n="Registrar Venta">Registrar Venta</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::routeIs('ventas.registradas') ? 'active' : '' }}">
                                <a href="{{ route('ventas.registradas') }}" class="menu-link">
                                    <div data-i18n="Lista de Ventas">Lista de Ventas</div>
                                </a>
                            </li>
                            <li class="menu-item ">
                                <a href="" class="menu-link">
                                    <div data-i18n="Reportes de Ventas">Reportes de Ventas</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item {{ Request::routeIs('compras.index') ? 'active' : '' }}">
                        <a href="{{ route('compras.index') }}" class="menu-link">
                            <i class="menu-icon bx bx-shopping-bag"></i>
                            <div data-i18n="Compra">Compra</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-lock-open-alt"></i>
                            <div data-i18n="Authentications">Authentications</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Login">Login</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-login-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-login-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Register">Register</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-register-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-register-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-register-multisteps.html" class="menu-link" target="_blank">
                                            <div data-i18n="Multi-steps">Multi-steps</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Verify Email">Verify Email</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-verify-email-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-verify-email-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Reset Password">Reset Password</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-reset-password-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-reset-password-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Forgot Password">Forgot Password</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-forgot-password-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Two Steps">Two Steps</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-two-steps-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-two-steps-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-spreadsheet"></i>
                            <div data-i18n="Wizard Examples">Wizard Examples</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="wizard-ex-checkout.html" class="menu-link">
                                    <div data-i18n="Checkout">Checkout</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="wizard-ex-property-listing.html" class="menu-link">
                                    <div data-i18n="Property Listing">Property Listing</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="wizard-ex-create-deal.html" class="menu-link">
                                    <div data-i18n="Create Deal">Create Deal</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="modal-examples.html" class="menu-link">
                            <i class="menu-icon icon-base bx bx-window-open"></i>
                            <div data-i18n="Modal Examples">Modal Examples</div>
                        </a>
                    </li>

                    <!-- Components -->
                    <li class="menu-header small">
                        <span class="menu-header-text" data-i18n="Components">Components</span>
                    </li>
                    <!-- Cards -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-collection"></i>
                            <div data-i18n="Inventario">Inventario</div>
                            <div class="badge text-bg-primary rounded-pill ms-auto">6</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::routeIs('inventario.view') ? 'active' : '' }}">
                                <a href="{{ route('inventario.view') }}" class="menu-link">
                                    <div data-i18n="Rep. de inventario">Rep. de inventario</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="cards-advance.html" class="menu-link">
                                    <div data-i18n="Advance">Advance</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="cards-statistics.html" class="menu-link">
                                    <div data-i18n="Statistics">Statistics</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="cards-analytics.html" class="menu-link">
                                    <div data-i18n="Analytics">Analytics</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="cards-gamifications.html" class="menu-link">
                                    <div data-i18n="Gamifications">Gamifications</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="cards-actions.html" class="menu-link">
                                    <div data-i18n="Actions">Actions</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- FIANZAS -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-collection"></i>
                            <div data-i18n="Finanzas">Finanzas</div>
                            <div class="badge text-bg-primary rounded-pill ms-auto">6</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::routeIs('finanzas.*') ? 'active' : '' }}">
                                <a href="{{ route('finanzas.view') }}" class="menu-link">
                                    <div data-i18n="Rep. diario de ganancias">Rep. diario de ganancias</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::routeIs('finanzas.mensual.*') ? 'active' : '' }}">
                                <a href="{{ route('finanzas.mensual.view') }}" class="menu-link">
                                    <div data-i18n="Rep. mensual de ganancias">Rep. mensual de ganancias</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::routeIs('finanzas.vp.*') ? 'active' : '' }}">
                                <a href="{{ route('finanzas.vp.view') }}" class="menu-link">
                                    <div data-i18n="Rep. ventas por producto">Rep. ventas por producto</div>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                    <!-- User interface -->
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-box"></i>
                            <div data-i18n="User interface">User interface</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="ui-accordion.html" class="menu-link">
                                    <div data-i18n="Accordion">Accordion</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-alerts.html" class="menu-link">
                                    <div data-i18n="Alerts">Alerts</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-badges.html" class="menu-link">
                                    <div data-i18n="Badges">Badges</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-buttons.html" class="menu-link">
                                    <div data-i18n="Buttons">Buttons</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-carousel.html" class="menu-link">
                                    <div data-i18n="Carousel">Carousel</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-collapse.html" class="menu-link">
                                    <div data-i18n="Collapse">Collapse</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-dropdowns.html" class="menu-link">
                                    <div data-i18n="Dropdowns">Dropdowns</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-footer.html" class="menu-link">
                                    <div data-i18n="Footer">Footer</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-list-groups.html" class="menu-link">
                                    <div data-i18n="List Groups">List Groups</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-modals.html" class="menu-link">
                                    <div data-i18n="Modals">Modals</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-navbar.html" class="menu-link">
                                    <div data-i18n="Navbar">Navbar</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-offcanvas.html" class="menu-link">
                                    <div data-i18n="Offcanvas">Offcanvas</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-pagination-breadcrumbs.html" class="menu-link">
                                    <div data-i18n="Pagination &amp; Breadcrumbs">Pagination &amp; Breadcrumbs</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-progress.html" class="menu-link">
                                    <div data-i18n="Progress">Progress</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-spinners.html" class="menu-link">
                                    <div data-i18n="Spinners">Spinners</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-tabs-pills.html" class="menu-link">
                                    <div data-i18n="Tabs &amp; Pills">Tabs &amp; Pills</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-toasts.html" class="menu-link">
                                    <div data-i18n="Toasts">Toasts</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-tooltips-popovers.html" class="menu-link">
                                    <div data-i18n="Tooltips &amp; Popovers">Tooltips &amp; Popovers</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-typography.html" class="menu-link">
                                    <div data-i18n="Typography">Typography</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Extended components -->
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-copy"></i>
                            <div data-i18n="Extended UI">Extended UI</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="extended-ui-avatar.html" class="menu-link">
                                    <div data-i18n="Avatar">Avatar</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-blockui.html" class="menu-link">
                                    <div data-i18n="BlockUI">BlockUI</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-drag-and-drop.html" class="menu-link">
                                    <div data-i18n="Drag &amp; Drop">Drag &amp; Drop</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-media-player.html" class="menu-link">
                                    <div data-i18n="Media Player">Media Player</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
                                    <div data-i18n="Perfect Scrollbar">Perfect Scrollbar</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-star-ratings.html" class="menu-link">
                                    <div data-i18n="Star Ratings">Star Ratings</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-sweetalert2.html" class="menu-link">
                                    <div data-i18n="SweetAlert2">SweetAlert2</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-text-divider.html" class="menu-link">
                                    <div data-i18n="Text Divider">Text Divider</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Timeline">Timeline</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="extended-ui-timeline-basic.html" class="menu-link">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="extended-ui-timeline-fullscreen.html" class="menu-link">
                                            <div data-i18n="Fullscreen">Fullscreen</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-tour.html" class="menu-link">
                                    <div data-i18n="Tour">Tour</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-treeview.html" class="menu-link">
                                    <div data-i18n="Treeview">Treeview</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ui-misc.html" class="menu-link">
                                    <div data-i18n="Miscellaneous">Miscellaneous</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Icons -->
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-crown"></i>
                            <div data-i18n="Icons">Icons</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="icons-boxicons.html" class="menu-link">
                                    <div data-i18n="Boxicons">Boxicons</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="icons-font-awesome.html" class="menu-link">
                                    <div data-i18n="Font Awesome">Font Awesome</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Forms & Tables -->
                    <li class="menu-header small">
                        <span class="menu-header-text" data-i18n="Forms &amp; Tables">Forms &amp; Tables</span>
                    </li>
                    <!-- Forms -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-detail"></i>
                            <div data-i18n="Form Elements">Form Elements</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="forms-basic-inputs.html" class="menu-link">
                                    <div data-i18n="Basic Inputs">Basic Inputs</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-input-groups.html" class="menu-link">
                                    <div data-i18n="Input groups">Input groups</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-custom-options.html" class="menu-link">
                                    <div data-i18n="Custom Options">Custom Options</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-editors.html" class="menu-link">
                                    <div data-i18n="Editors">Editors</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-file-upload.html" class="menu-link">
                                    <div data-i18n="File Upload">File Upload</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-pickers.html" class="menu-link">
                                    <div data-i18n="Pickers">Pickers</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-selects.html" class="menu-link">
                                    <div data-i18n="Select &amp; Tags">Select &amp; Tags</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-sliders.html" class="menu-link">
                                    <div data-i18n="Sliders">Sliders</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-switches.html" class="menu-link">
                                    <div data-i18n="Switches">Switches</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-extras.html" class="menu-link">
                                    <div data-i18n="Extras">Extras</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-detail"></i>
                            <div data-i18n="Form Layouts">Form Layouts</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="form-layouts-vertical.html" class="menu-link">
                                    <div data-i18n="Vertical Form">Vertical Form</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="form-layouts-horizontal.html" class="menu-link">
                                    <div data-i18n="Horizontal Form">Horizontal Form</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="form-layouts-sticky.html" class="menu-link">
                                    <div data-i18n="Sticky Actions">Sticky Actions</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-carousel"></i>
                            <div data-i18n="Form Wizard">Form Wizard</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="form-wizard-numbered.html" class="menu-link">
                                    <div data-i18n="Numbered">Numbered</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="form-wizard-icons.html" class="menu-link">
                                    <div data-i18n="Icons">Icons</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="form-validation.html" class="menu-link">
                            <i class="menu-icon icon-base bx bx-list-check"></i>
                            <div data-i18n="Form Validation">Form Validation</div>
                        </a>
                    </li>
                    <!-- Tables -->
                    <li class="menu-item">
                        <a href="tables-basic.html" class="menu-link">
                            <i class="menu-icon icon-base bx bx-table"></i>
                            <div data-i18n="Tables">Tables</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-grid"></i>
                            <div data-i18n="Datatables">Datatables</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="tables-datatables-basic.html" class="menu-link">
                                    <div data-i18n="Basic">Basic</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="tables-datatables-advanced.html" class="menu-link">
                                    <div data-i18n="Advanced">Advanced</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="tables-datatables-extensions.html" class="menu-link">
                                    <div data-i18n="Extensions">Extensions</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Charts & Maps -->
                    <li class="menu-header small">
                        <span class="menu-header-text" data-i18n="Charts &amp; Maps">Charts &amp; Maps</span>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-chart"></i>
                            <div data-i18n="Charts">Charts</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="charts-apex.html" class="menu-link">
                                    <div data-i18n="Apex Charts">Apex Charts</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-chartjs.html" class="menu-link">
                                    <div data-i18n="ChartJS">ChartJS</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="maps-leaflet.html" class="menu-link">
                            <i class="menu-icon icon-base bx bx-map-alt"></i>
                            <div data-i18n="Leaflet Maps">Leaflet Maps</div>
                        </a>
                    </li>

                    <!-- Misc -->
                    <li class="menu-header small">
                        <span class="menu-header-text" data-i18n="Misc">Misc</span>
                    </li>

                    <!-- Multi Level Menu -->
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-grid"></i>
                            <div data-i18n="Multi Level">Multi Level</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <div data-i18n="Level 2">Level 2</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="javascript:void(0)" class="menu-link">
                                            <div data-i18n="Level 3">Level 3</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="https://themeselection.com/support/" target="_blank" class="menu-link">
                            <i class="menu-icon icon-base bx bx-support"></i>
                            <div data-i18n="Support">Support</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="menu-link">
                            <i class="menu-icon icon-base bx bx-file"></i>
                            <div data-i18n="Documentation">Documentation</div>
                        </a>
                    </li>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; height: 881px; right: 4px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 433px;"></div>
                    </div>
                </ul>


            </aside>

            <div class="menu-mobile-toggler d-xl-none rounded-1">
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                    <i class="bx bx-menu icon-base"></i>
                    <i class="bx bx-chevron-right icon-base"></i>
                </a>
            </div>
            <!-- / Menu -->



            <!-- Layout container -->
            <div class="layout-page">





                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">





                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0   d-xl-none ">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base bx bx-menu icon-md"></i>
                        </a>
                    </div>


                    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

                        <!-- Trigger -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <input type="text" class="form-control" placeholder="Search [CTRL + K]" id="searchTrigger" readonly>
                            </div>
                        </div>

                        <!-- Command Palette Modal -->
                        <div id="commandPalette" class="aa-DetachedOverlay d-none">
                            <div class="aa-DetachedContainer d-flex flex-column aa-DetachedContainer--modal">

                                <!-- Header con input -->
                                <div class="aa-DetachedFormContainer d-flex align-items-center justify-content-between border-bottom">
                                    <form class="aa-Form d-flex align-items-center" action="" novalidate role="search">
                                        <!-- Input wrapper prefix: icono submit -->
                                        <div class="aa-InputWrapperPrefix">
                                            <label class="aa-Label" aria-label="Submit" for="commandInput">
                                                <button class="aa-SubmitButton" type="submit" title="Buscar">
                                                    <svg class="aa-SubmitIcon" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                                        <path d="M16.041 15.856c-0.034 0.026-0.067 0.055-0.099 0.087s-0.060 0.064-0.087 0.099c-1.258 1.213-2.969 1.958-4.855 1.958-1.933 0-3.682-0.782-4.95-2.050s-2.050-3.017-2.050-4.95 0.782-3.682 2.050-4.95 3.017-2.050 4.95-2.050 3.682 0.782 4.95 2.050 2.050 3.017 2.050 4.95c0 1.886-0.745 3.597-1.959 4.856zM21.707 20.293l-3.675-3.675c1.231-1.54 1.968-3.493 1.968-5.618 0-2.485-1.008-4.736-2.636-6.364s-3.879-2.636-6.364-2.636-4.736 1.008-6.364 2.636-2.636 3.879-2.636 6.364 1.008 4.736 2.636 6.364 3.879 2.636 6.364 2.636c2.125 0 4.078-0.737 5.618-1.968l3.675 3.675c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414z" />
                                                    </svg>
                                                </button>
                                            </label>
                                            <div class="aa-LoadingIndicator" hidden>
                                                <svg class="aa-LoadingIcon" viewBox="0 0 100 100" width="20" height="20">
                                                    <circle cx="50" cy="50" r="35" fill="none" stroke="currentColor" stroke-dasharray="164.93361431346415 56.97787143782138" stroke-width="6">
                                                        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s"
                                                            values="0 50 50;90 50 50;180 50 50;360 50 50" keyTimes="0;0.40;0.65;1"></animateTransform>
                                                    </circle>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Input principal -->
                                        <div class="aa-InputWrapper">
                                            <input class="aa-Input search-control border-none"
                                                id="commandInput"
                                                autocomplete="off" autocorrect="off" autocapitalize="off" enterkeyhint="go" spellcheck="false"
                                                placeholder="Buscar rutas..." maxlength="512" type="search">
                                        </div>

                                        <!-- Input wrapper suffix: clear button -->
                                        <div class="aa-InputWrapperSuffix">
                                            <button class="aa-ClearButton d-none" type="reset" title="Clear" hidden>
                                                <svg class="aa-ClearIcon" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                                                    <path d="M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Botón cerrar -->
                                    <button type="button" class="aa-DetachedCancelButton btn-search-close" onclick="closePalette()">
                                        <span class="text-body-secondary">[esc]</span>
                                        <span class="icon-base icon-md bx bx-x text-heading"></span>
                                    </button>
                                </div>

                                <!-- Panel de resultados: vacío, el script llenará dinámicamente -->
                                <div class="aa-Panel flex-grow content-wrapper overflow-hidden position-relative ps">
                                    <div class="p-5 p-lg-12" id="commandResults">
                                        <!-- Aquí se cargarán las rutas dinámicamente -->
                                    </div>
                                </div>

                            </div>
                        </div>




                        <ul class="navbar-nav flex-row align-items-center ms-md-auto">






                            <!-- Style Switcher -->
                            <li class="nav-item dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown" aria-label="Toggle theme (system)" aria-expanded="false">
                                    <i class="bx-desktop icon-base bx icon-md theme-icon-active"></i>
                                    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="light" aria-pressed="false">
                                            <span><i class="icon-base bx bx-sun icon-md me-3" data-icon="sun"></i>Light</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                                            <span><i class="icon-base bx bx-moon icon-md me-3" data-icon="moon"></i>Dark</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center active" data-bs-theme-value="system" aria-pressed="true">
                                            <span><i class="icon-base bx bx-desktop icon-md me-3" data-icon="desktop"></i>System</span>
                                        </button>
                                    </li>
                                </ul>
                            </li>




                            <!-- Notification -->
                            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <span class="position-relative">
                                        <i class="icon-base bx bx-bell icon-md"></i>
                                        <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-0">
                                    <li class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h6 class="mb-0 me-auto">Notification</h6>
                                            <div class="d-flex align-items-center h6 mb-0">
                                                <span class="badge bg-label-primary me-2">8 New</span>
                                                <a href="javascript:void(0)" class="dropdown-notifications-all p-2" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Mark all as read" data-bs-original-title="Mark all as read"><i class="icon-base bx bx-envelope-open text-heading"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-notifications-list scrollable-container ps">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/1.png" alt="" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">Congratulation Lettie 🎉</h6>
                                                        <small class="mb-1 d-block text-body">Won the monthly best seller gold badge</small>
                                                        <small class="text-body-secondary">1h ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">Charles Franklin</h6>
                                                        <small class="mb-1 d-block text-body">Accepted your connection</small>
                                                        <small class="text-body-secondary">12hr ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/2.png" alt="" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">New Message ✉️</h6>
                                                        <small class="mb-1 d-block text-body">You have new message from Natalie</small>
                                                        <small class="text-body-secondary">1h ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span class="avatar-initial rounded-circle bg-label-success"><i class="icon-base bx bx-cart"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">Whoo! You have new order 🛒</h6>
                                                        <small class="mb-1 d-block text-body">ACME Inc. made new order $1,154</small>
                                                        <small class="text-body-secondary">1 day ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/9.png" alt="" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">Application has been approved 🚀</h6>
                                                        <small class="mb-1 d-block text-body">Your ABC project application has been approved.</small>
                                                        <small class="text-body-secondary">2 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span class="avatar-initial rounded-circle bg-label-success"><i class="icon-base bx bx-pie-chart-alt"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">Monthly report is generated</h6>
                                                        <small class="mb-1 d-block text-body">July monthly financial report is generated </small>
                                                        <small class="text-body-secondary">3 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/5.png" alt="" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">Send connection request</h6>
                                                        <small class="mb-1 d-block text-body">Peter sent you connection request</small>
                                                        <small class="text-body-secondary">4 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="../../assets/img/avatars/6.png" alt="" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">New message from Jane</h6>
                                                        <small class="mb-1 d-block text-body">Your have new message from Jane</small>
                                                        <small class="text-body-secondary">5 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <span class="avatar-initial rounded-circle bg-label-warning"><i class="icon-base bx bx-error"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">CPU is running high</h6>
                                                        <small class="mb-1 d-block text-body">CPU Utilization Percent is currently at 88.63%,</small>
                                                        <small class="text-body-secondary">5 days ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                        </div>
                                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                        </div>
                                    </li>
                                    <li class="border-top">
                                        <div class="d-grid p-4">
                                            <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                                                <small class="align-middle">View all notifications</small>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!--/ Notification -->
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : asset('assets/img/avatars/cat4.gif') }}" alt="" class=" rounded-circle">
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="pages-account-settings-account.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : asset('assets/img/avatars/cat4.gif') }}" alt="" class=" w-px-40 h-auto rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                                    <small class="text-body-secondary">@foreach(auth()->user()->roles as $role)
                                                        {{ $role->name }}@endforeach</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('Perfil') }}"> <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span> </a>
                                    </li>

                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>

                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <a href="{{ route('logout') }}" class="dropdown-item"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>
                                            </a>
                                        </form>
                                    </li>

                                </ul>
                            </li>
                            <!--/ User -->

                        </ul>
                    </div>

                </nav>

                <!-- / Navbar -->


                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="row">

                            {{ $slot }}
                        </div>

                    </div>
                    <!-- / Content -->

                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>



            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>


            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target" style="touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>

        </div>
        <!-- / Layout wrapper -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/theme.js  -->


        <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

        <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
        <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/@algolia/autocomplete-js.js')}}"></script>



        <script src="{{asset('assets/vendor/libs/pickr/pickr.js')}}"></script>



        <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>


        <script src="{{asset('assets/vendor/libs/hammer/hammer.js')}}"></script>

        <script src="{{asset('assets/vendor/libs/i18n/i18n.js')}}"></script>


        <script src="{{asset('assets/vendor/js/menu.js')}}"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

        <!-- Main JS -->

        <script src="{{asset('assets/js/main.js')}}"></script>


        <!-- Page JS -->
        <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
        <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>

        <div id="template-customizer" class="card rounded-0" style="visibility: visible">
            <a href="javascript:void(0)" class="template-customizer-open-btn" tabindex="-1"></a>

            <div class="p-6 m-0 lh-sm border-bottom template-customizer-header position-relative py-4">
                <h6 class="template-customizer-t-panel_header mb-1">
                    Personalizadores de plantillas</h6>
                <p class="template-customizer-t-panel_sub_header mb-0 small">Personaliza y previsualiza en tiempo real</p>
                <div class="d-flex align-items-center gap-2 position-absolute end-0 top-0 mt-6 me-5">
                    <a href="javascript:void(0)" class="template-customizer-reset-btn text-heading" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Reset Customizer"><i class="icon-base bx bx-refresh icon-24px"></i><span class="badge rounded-pill bg-danger badge-dot badge-notifications"></span></a>
                    <a href="javascript:void(0)" class="template-customizer-close-btn fw-light text-heading" tabindex="-1">
                        <i class="icon-base bx bx-x icon-lg"></i>
                    </a>
                </div>
            </div>

            <div class="template-customizer-inner pt-6">
                <!-- Theming -->
                <div class="template-customizer-theming">
                    <h5 class="m-0 px-6 pb-6">
                        <span class="template-customizer-t-theming_header bg-label-primary rounded-1 py-1 px-3 small">
                            Tematización</span>
                    </h5>

                    <!-- Color -->
                    <div class="m-0 px-6 pb-6 template-customizer-color w-100">
                        <label for="customizerColor" class="form-label d-block template-customizer-t-color_label mb-2">
                            Color primario</label>
                        <div class="row template-customizer-colors-options">
                            <div class="form-check custom-option custom-option-icon mb-0">
                                <label class="form-check-label custom-option-content p-0" for="colorRadioIconprimary">
                                    <span class="custom-option-body mb-0 scaleX-n1-rtl" style="background-color: #0d3c94ff;"></span>
                                </label>
                                <input name="colorRadioIcon" class="form-check-input d-none" type="radio" value="#0d3c94ff" data-color="#0D9394" id="colorRadioIconprimary" checked="checked">
                            </div>
                            <div class="form-check custom-option custom-option-icon mb-0">
                                <label class="form-check-label custom-option-content p-0" for="colorRadioIconsuccess">
                                    <span class="custom-option-body mb-0 scaleX-n1-rtl" style="background-color: #0D9394;"></span>
                                </label>
                                <input name="colorRadioIcon" class="form-check-input d-none" type="radio" value="#0D9394" data-color="#0D9394" id="colorRadioIconsuccess">
                            </div>
                            <div class="form-check custom-option custom-option-icon mb-0 checked">
                                <label class="form-check-label custom-option-content p-0" for="colorRadioIconwarning">
                                    <span class="custom-option-body mb-0 scaleX-n1-rtl" style="background-color: #FFAB1D;"></span>
                                </label>
                                <input name="colorRadioIcon" class="form-check-input d-none" type="radio" value="#FFAB1D" data-color="#FFAB1D" id="colorRadioIconwarning">
                            </div>
                            <div class="form-check custom-option custom-option-icon mb-0">
                                <label class="form-check-label custom-option-content p-0" for="colorRadioIcondanger">
                                    <span class="custom-option-body mb-0 scaleX-n1-rtl" style="background-color: #EB3D63;"></span>
                                </label>
                                <input name="colorRadioIcon" class="form-check-input d-none" type="radio" value="#EB3D63" data-color="#EB3D63" id="colorRadioIcondanger">
                            </div>
                            <div class="form-check custom-option custom-option-icon mb-0">
                                <label class="form-check-label custom-option-content p-0" for="colorRadioIconinfo">
                                    <span class="custom-option-body mb-0 scaleX-n1-rtl" style="background-color: #2092EC;"></span>
                                </label>
                                <input name="colorRadioIcon" class="form-check-input d-none" type="radio" value="#2092EC" data-color="#2092EC" id="colorRadioIconinfo">
                            </div>
                            <div class="form-check custom-option custom-option-icon mb-0"><label class="form-check-label custom-option-content" for="colorRadioIcon">
                                    <div class="pickr">

                                        <button type="button" class="pcr-button bx bxs-color-fill" role="button" aria-label="toggle color picker dialog" style="transition: none; --pcr-color: rgba(13, 147, 148, 1);"></button>


                                    </div>
                                </label><input name="colorRadioIcon" class="form-check-input picker d-none" type="radio" value="picker" id="colorRadioIcon"> </div>
                        </div>
                    </div>

                    <!-- Theme -->
                    <div class="m-0 px-6 pb-6 template-customizer-theme w-100">
                        <label for="customizerTheme" class="form-label d-block template-customizer-t-theme_label mb-2">Tema</label>
                        <div class="row px-1 template-customizer-themes-options">
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-icon mb-0">
                                    <label class="form-check-label custom-option-content p-0" for="customRadioIconlight">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><i class="bx bx-sun icon-base mb-0"></i></span>
                                    </label>
                                    <input name="customRadioIcon" class="form-check-input d-none" type="radio" value="light" id="customRadioIconlight">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="customRadioIconlight">Claro</label>
                            </div>
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-icon mb-0">
                                    <label class="form-check-label custom-option-content p-0" for="customRadioIcondark">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><i class="bx bx-moon icon-base mb-0"></i></span>
                                    </label>
                                    <input name="customRadioIcon" class="form-check-input d-none" type="radio" value="dark" id="customRadioIcondark">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="customRadioIcondark">Oscuro</label>
                            </div>
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-icon mb-0 checked">
                                    <label class="form-check-label custom-option-content p-0" for="customRadioIconsystem">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><i class="bx bx-desktop icon-base mb-0"></i></span>
                                    </label>
                                    <input name="customRadioIcon" class="form-check-input d-none" type="radio" value="system" id="customRadioIconsystem" checked="checked">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="customRadioIconsystem">Sistema</label>
                            </div>
                        </div>
                    </div>

                    <!-- Skins -->
                    <div class="m-0 px-6 pb-6 template-customizer-skins w-100">
                        <label for="customizerSkin" class="form-label template-customizer-t-skin_label mb-2">Apariencia</label>
                        <div class="row px-1 template-customizer-skins-options">
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0 checked">
                                    <label class="form-check-label custom-option-content p-0" for="skinRadiosdefault">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 66" height="62" width="98">
                                                <rect fill-opacity="0.02" fill="currentColor" rx="4" height="66" width="104"></rect>
                                                <path fill-opacity="0.08" fill="currentColor" d="M0 4C0 1.79086 1.79086 0 4 0H27.4717V66H4C1.79086 66 0 64.2091 0 62V4Z"></path>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="23.8839" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="2" height="9.70588" width="9.81132" y="5.88135" x="8.83008"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="34.4381" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="44.9923" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="55.5462" x="4.90625"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="8.8" width="64.7547" y="4.67166" x="34.1152"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="37.0391"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="80.21"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="86.0957"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="91.9824"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="40.2264" y="19.6134" x="58.4844"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="19.0455" y="19.6134" x="34.1152"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="64.7547" y="42.4545" x="34.1152"></rect>
                                            </svg>
                                        </span>
                                    </label>
                                    <input name="skinRadios" class="form-check-input d-none" type="radio" value="default" id="skinRadiosdefault" checked="checked">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="skinRadiosdefault">Predeterminado</label>
                            </div>
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                                    <label class="form-check-label custom-option-content p-0" for="skinRadiosbordered">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 66" height="62" width="98">
                                                <rect fill-opacity="0.02" fill="currentColor" rx="4" height="66" width="104"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="23.8839" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="2" height="9.70588" width="9.81132" y="5.88135" x="8.83008"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="34.4381" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="44.9923" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="55.5462" x="4.90625"></rect>
                                                <rect stroke-opacity="0.12" stroke="currentColor" rx="1.5" height="7.8" width="63.7547" y="5.17166" x="34.6152"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="37.0391"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="80.21"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="86.0957"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="91.002"></rect>
                                                <rect stroke-opacity="0.12" stroke="currentColor" rx="1.5" height="16.6" width="39.2264" y="20.1134" x="58.9844"></rect>
                                                <rect stroke-opacity="0.12" stroke="currentColor" rx="1.5" height="16.6" width="18.0455" y="20.1134" x="34.6152"></rect>
                                                <rect stroke-opacity="0.12" stroke="currentColor" rx="1.5" height="16.6" width="63.7547" y="42.9545" x="34.6152"></rect>
                                            </svg>
                                        </span>
                                    </label>
                                    <input name="skinRadios" class="form-check-input d-none" type="radio" value="bordered" id="skinRadiosbordered">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="skinRadiosbordered">Bordeado</label>
                            </div>
                        </div>
                    </div>

                    <!-- Semi Dark -->
                    <div class="m-0 px-6 template-customizer-semiDark w-100 d-flex justify-content-between pe-12 d-none">
                        <span class="form-label template-customizer-t-semiDark_label">Semi Oscuro</span>
                        <label class="switch template-customizer-t-semiDark_label">
                            <input type="checkbox" class="template-customizer-semi-dark-switch switch-input">
                            <span class="switch-toggle-slider">
                                <span class="switch-on"></span>
                                <span class="switch-off"></span>
                            </span>
                        </label>
                    </div>
                    <hr class="m-0 px-6 my-6">
                </div>
                <!--/ Theming -->

                <!-- Layout -->
                <div class="template-customizer-layout">
                    <h5 class="m-0 px-6 pb-6">
                        <span class="template-customizer-t-layout_header bg-label-primary rounded-2 py-1 px-3 small">Diseño</span>
                    </h5>

                    <!-- Layout(Menu) -->
                    <div class="m-0 px-6 pb-6 d-block template-customizer-layouts">
                        <label for="customizerStyle" class="form-label d-block template-customizer-t-layout_label mb-2">Menu (Navegación)</label>
                        <div class="row px-1 template-customizer-layouts-options">
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0 checked">
                                    <label class="form-check-label custom-option-content p-0" for="layoutsRadiosexpanded">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 66" height="62" width="98">
                                                <rect fill-opacity="0.02" fill="currentColor" rx="4" height="66" width="104"></rect>
                                                <path fill-opacity="0.08" fill="currentColor" d="M0 4C0 1.79086 1.79086 0 4 0H27.4717V66H4C1.79086 66 0 64.2091 0 62V4Z"></path>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="23.8839" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="2" height="9.70588" width="9.81132" y="5.88135" x="8.83008"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="34.4381" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="44.9923" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="55.5462" x="4.90625"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="8.8" width="64.7547" y="4.67166" x="34.1152"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="37.0391"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="80.21"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="86.0957"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="91.9824"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="40.2264" y="19.6134" x="58.4844"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="19.0455" y="19.6134" x="34.1152"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="64.7547" y="42.4545" x="34.1152"></rect>
                                            </svg>
                                        </span>
                                    </label>
                                    <input name="layoutsRadios" class="form-check-input d-none" type="radio" value="expanded" id="layoutsRadiosexpanded" checked="checked">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="layoutsRadiosexpanded">Expandido</label>
                            </div>
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                                    <label class="form-check-label custom-option-content p-0" for="layoutsRadioscollapsed">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 66" height="62" width="98">
                                                <rect fill-opacity="0.02" fill="currentColor" rx="4" height="66" width="104"></rect>
                                                <path fill-opacity="0.04" fill="currentColor" d="M0 4C0 1.79086 1.79086 0 4 0H13.7359V66H4C1.79086 66 0 64.2091 0 62V4Z"></path>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="7.84906" y="23.8839" x="2.94336"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="2" height="6.79412" width="6.86793" y="5.88135" x="3.43359"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="7.84906" y="34.4382" x="2.94336"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="7.84906" y="44.9923" x="2.94336"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="7.84906" y="55.5463" x="2.94336"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="8.8" width="75.437" y="4.67169" x="21.4717"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="25.6172"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="78.248"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="84.1348"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="90.0215"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="46.8212" y="19.6134" x="50.4912"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="22.1679" y="19.6134" x="21.4717"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="75.8413" y="42.4545" x="21.4717"></rect>
                                            </svg>
                                        </span>
                                    </label>
                                    <input name="layoutsRadios" class="form-check-input d-none" type="radio" value="collapsed" id="layoutsRadioscollapsed">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="layoutsRadioscollapsed">Colapsado</label>
                            </div>
                        </div>
                    </div>

                    <!-- Header Options for Horizontal -->


                    <!-- Fixed navbar -->
                    <div class="m-0 px-6 pb-6 template-customizer-layoutNavbarOptions w-100">
                        <label for="customizerNavbar" class="form-label template-customizer-t-layout_navbar_label mb-2">Tipo de Barra de Navegación</label>
                        <div class="row px-1 template-customizer-navbar-options">
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0 checked">
                                    <label class="form-check-label custom-option-content p-0" for="navbarOptionRadiossticky">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 66" height="62" width="98">
                                                <rect fill-opacity="0.02" fill="currentColor" rx="4" height="66" width="104"></rect>
                                                <path fill-opacity="0.08" fill="currentColor" d="M0 4C0 1.79086 1.79086 0 4 0H27.4717V66H4C1.79086 66 0 64.2091 0 62V4Z"></path>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="23.8839" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="2" height="9.70588" width="9.81132" y="5.88135" x="8.83008"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="34.4382" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="44.9923" x="4.90625"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="17.6604" y="55.5463" x="4.90625"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="8.8" width="64.7547" y="4.67169" x="32.1523"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="35.0781"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="78.248"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="84.1348"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="90.0215"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="40.2264" y="19.6134" x="57.0859"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="19.0455" y="19.6134" x="32.1523"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="65.1591" y="42.4545" x="32.1523"></rect>
                                            </svg>
                                        </span>
                                    </label>
                                    <input name="navbarOptionRadios" class="form-check-input d-none" type="radio" value="sticky" id="navbarOptionRadiossticky" checked="checked">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="navbarOptionRadiossticky">Fijo</label>
                            </div>
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                                    <label class="form-check-label custom-option-content p-0" for="navbarOptionRadiosstatic">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 66" height="62" width="98">
                                                <rect fill-opacity="0.02" fill="currentColor" rx="4" height="66" width="104"></rect>
                                                <path fill-opacity="0.06" fill="currentColor" d="M0 4C0 1.79086 1.79086 0 4 0H13.7359V66H4C1.79086 66 0 64.2091 0 62V4Z"></path>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="7.84906" y="23.8839" x="2.94336"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="2" height="6.79412" width="6.86793" y="5.88135" x="3.43359"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="7.84906" y="34.4382" x="2.94336"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="7.84906" y="44.9923" x="2.94336"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.39473" height="2.78946" width="7.84906" y="55.5463" x="2.94336"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="8.8" width="75.437" y="4.67169" x="21.4717"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="25.6172"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="78.248"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="84.1348"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87158" x="90.0215"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="46.8212" y="19.6134" x="50.4912"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="22.1679" y="19.6134" x="21.4717"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="75.8413" y="42.4545" x="21.4717"></rect>
                                            </svg>
                                        </span>
                                    </label>
                                    <input name="navbarOptionRadios" class="form-check-input d-none" type="radio" value="static" id="navbarOptionRadiosstatic">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="navbarOptionRadiosstatic">Estático</label>
                            </div>
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                                    <label class="form-check-label custom-option-content p-0" for="navbarOptionRadioshidden">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 66" height="62" width="98">
                                                <rect fill-opacity="0.02" fill="currentColor" rx="4" height="66" width="104"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="46.8212" y="19.6136" x="44.0068"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="22.1679" y="19.6136" x="14.9854"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="75.8413" y="42.4547" x="14.9854"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="9.00999" width="74.1506" y="4.68896" x="14.9248"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="5.38019" width="6.00327" y="6.50403" x="20.0264"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.23064" height="2.46129" width="6.6372" y="7.96356" x="33.877"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.23064" height="2.46129" width="6.6372" y="7.96356" x="48.3652"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.23064" height="2.46129" width="6.6372" y="7.96356" x="62.8506"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1.23064" height="2.46129" width="6.6372" y="7.96356" x="77.3379"></rect>
                                            </svg>
                                        </span>
                                    </label>
                                    <input name="navbarOptionRadios" class="form-check-input d-none" type="radio" value="hidden" id="navbarOptionRadioshidden">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="navbarOptionRadioshidden">Oculto</label>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="m-0 px-6 pb-6 template-customizer-content w-100">
                        <label for="customizerContent" class="form-label template-customizer-t-content_label mb-2">Contenido</label>
                        <div class="row px-1 template-customizer-content-options">
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0 checked">
                                    <label class="form-check-label custom-option-content p-0" for="contentRadioIconcompact">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 66" height="62" width="98">
                                                <rect fill-opacity="0.02" fill="currentColor" rx="4" height="66" width="104"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="8.8" width="64.7547" y="4.67169" x="19.4209"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87164" x="22.3447"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87164" x="65.5146"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87164" x="71.4014"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="3.92453" y="6.87164" x="77.2881"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="40.2264" y="19.6135" x="44.3525"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="19.0455" y="19.6135" x="19.4209"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="65.1591" y="42.4545" x="19.4209"></rect>
                                            </svg>
                                        </span>
                                    </label>
                                    <input name="contentRadioIcon" class="form-check-input d-none" type="radio" value="compact" id="contentRadioIconcompact" checked="checked">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="contentRadioIconcompact">Compacto</label>
                            </div>
                            <div class="col-4 px-2">
                                <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                                    <label class="form-check-label custom-option-content p-0" for="contentRadioIconwide">
                                        <span class="custom-option-body mb-0 scaleX-n1-rtl"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 104 66" height="62" width="98">
                                                <rect fill-opacity="0.02" fill="currentColor" rx="4" height="66" width="104"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="8.8" width="90.6244" y="4.67169" x="6.6875"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="4.90566" y="6.87164" x="10.165"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="4.90566" y="6.87164" x="75.2002"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="4.90566" y="6.87164" x="82.0674"></rect>
                                                <rect fill-opacity="0.3" fill="currentColor" rx="1" height="4.4" width="4.90566" y="6.87164" x="88.9346"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="55.9476" y="19.6135" x="41.3652"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="26.4888" y="19.6135" x="6.6875"></rect>
                                                <rect fill-opacity="0.08" fill="currentColor" rx="2" height="17.6" width="90.6244" y="42.4545" x="6.6875"></rect>
                                            </svg>
                                        </span>
                                    </label>
                                    <input name="contentRadioIcon" class="form-check-input d-none" type="radio" value="wide" id="contentRadioIconwide">
                                </div>
                                <label class="form-check-label small text-nowrap text-body" for="contentRadioIconwide">Amplio</label>
                            </div>
                        </div>
                    </div>

                </div>
                <!--/ Layout -->
            </div>
        </div>
        <div class="pcr-app " data-theme="nano" aria-label="color picker dialog" role="window" style="top: 372.734px; left: 853.125px;">
            <div class="pcr-selection">
                <div class="pcr-color-preview">
                    <button type="button" class="pcr-last-color" aria-label="use previous color" style="transition: none; --pcr-color: rgba(13, 147, 148, 1);"></button>
                    <div class="pcr-current-color" style="--pcr-color: rgba(13, 147, 148, 1);"></div>
                </div>

                <div class="pcr-color-palette">
                    <div class="pcr-picker" style="left: calc(91.2162% - 9px); top: calc(41.9608% - 9px); background: rgb(13, 147, 148);"></div>
                    <div class="pcr-palette" tabindex="0" aria-label="color selection area" role="listbox" style="background: linear-gradient(to top, rgb(0, 0, 0), transparent), linear-gradient(to left, rgb(0, 253, 255), rgb(255, 255, 255));"></div>
                </div>

                <div class="pcr-color-chooser">
                    <div class="pcr-picker" style="left: calc(50.1235% - 9px); background-color: rgb(0, 253, 255);"></div>
                    <div class="pcr-hue pcr-slider" tabindex="0" aria-label="hue selection slider" role="slider"></div>
                </div>

                <div class="pcr-color-opacity" style="display:none" hidden="">
                    <div class="pcr-picker"></div>
                    <div class="pcr-opacity pcr-slider" tabindex="0" aria-label="selection slider" role="slider"></div>
                </div>
            </div>

            <div class="pcr-swatches "></div>

            <div class="pcr-interaction">
                <input class="pcr-result" type="text" spellcheck="false" aria-label="color input field">

                <input class="pcr-type active" data-type="HEXA" value="HEXA" type="button" style="display:none" hidden="">
                <input class="pcr-type" data-type="RGBA" value="RGBA" type="button" style="display:none" hidden="">
                <input class="pcr-type" data-type="HSLA" value="HSLA" type="button" style="display:none" hidden="">
                <input class="pcr-type" data-type="HSVA" value="HSVA" type="button" style="display:none" hidden="">
                <input class="pcr-type" data-type="CMYK" value="CMYK" type="button" style="display:none" hidden="">

                <input class="pcr-save" value="Save" type="button" style="display:none" hidden="" aria-label="save and close">
                <input class="pcr-cancel" value="Cancel" type="button" style="display:none" hidden="" aria-label="cancel and close">
                <input class="pcr-clear" value="Clear" type="button" style="display:none" hidden="" aria-label="clear and close">
            </div>
        </div>
        <script src="{{asset('assets/js/ui-toasts.js')}}"></script>
        <div id="liveToast" class="bs-toast toast toast-placement-ex m-2 fade bg-primary top-0 end-0 hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">TUXON</div>
                <small>Ahora</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div>
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}">
        <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
        <script>
            //colores picker
            document.addEventListener("DOMContentLoaded", function() {
                const radios = document.querySelectorAll('input[name="colorRadioIcon"]');
                const root = document.documentElement;

                // referencias del logo
                const catWrapper = document.querySelector(".app-brand-logo .text-primary");
                const catSvg = document.querySelector(".app-brand-logo svg");

                // util: hex -> rgb (soporta #RRGGBB, #RGB, #RRGGBBAA)
                function hexToRgb(h) {
                    let hex = h.trim();
                    if (hex.startsWith('#')) hex = hex.slice(1);
                    if (hex.length === 8) hex = hex.slice(0, 6); // ignoramos alfa para --bs-primary-rgb
                    if (hex.length === 3) hex = hex.split('').map(x => x + x).join('');
                    const num = parseInt(hex, 16);
                    return [(num >> 16) & 255, (num >> 8) & 255, num & 255];
                }

                // --- Función para aplicar color y guardar
                function aplicarColor(color) {
                    // variables Bootstrap
                    root.style.setProperty("--bs-primary", color);
                    const [r, g, b] = hexToRgb(color);
                    root.style.setProperty("--bs-primary-rgb", `${r}, ${g}, ${b}`);
                    localStorage.setItem("primaryColor", color);

                    // color del logo (ganar a .text-primary !important)
                    if (catWrapper) {
                        catWrapper.style.setProperty('color', color, 'important');
                    }
                    if (catSvg) {
                        // asegurar que el svg pinta con currentColor y que nadie lo pisa
                        catSvg.style.setProperty('fill', 'currentColor', 'important');

                        // si hubiese paths con fill hardcodeado, los pasamos a currentColor una vez
                        catSvg.querySelectorAll('[fill]').forEach(el => {
                            if (el.getAttribute('fill') !== 'currentColor') {
                                el.setAttribute('fill', 'currentColor');
                            }
                        });
                    }
                }

                // --- Marcar visualmente
                function marcarChecked(radio) {
                    document.querySelectorAll(".custom-option").forEach(el => el.classList.remove("checked"));
                    radio.closest(".custom-option").classList.add("checked");
                }

                // --- Aplicar el color guardado al cargar
                const savedColor = localStorage.getItem("primaryColor") || "#696cff";
                aplicarColor(savedColor);

                // Buscar si coincide con un radio
                let radioMatch = [...radios].find(r => r.value.toLowerCase() === savedColor.toLowerCase());
                if (radioMatch) {
                    radioMatch.checked = true;
                    marcarChecked(radioMatch);
                } else {
                    const pickerRadio = document.querySelector('input[value="picker"]');
                    if (pickerRadio) {
                        pickerRadio.checked = true;
                        marcarChecked(pickerRadio);
                    }
                }

                // --- Detectar cambio en radios
                radios.forEach(radio => {
                    radio.addEventListener("change", function() {
                        if (this.value !== "picker") {
                            aplicarColor(this.value);
                            marcarChecked(this);
                        }
                    });
                });

                // --- Inicializar Pickr
                const pickr = Pickr.create({
                    el: '.pcr-button',
                    theme: 'classic',
                    default: savedColor,
                    components: {
                        preview: true,
                        opacity: true,
                        hue: true,
                        interaction: {
                            hex: true,
                            rgba: true,
                            input: true,
                            save: true
                        }
                    }
                });

                // --- Guardar color al elegir en Pickr
                pickr.on("save", (color) => {
                    const hex = color.toHEXA().toString();
                    aplicarColor(hex);

                    // Marcar radio "picker"
                    const pickerRadio = document.querySelector('input[value="picker"]');
                    if (pickerRadio) {
                        pickerRadio.checked = true;
                        marcarChecked(pickerRadio);
                    }
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const radiosTheme = document.querySelectorAll('input[name="customRadioIcon"]'); // Customizer
                const navbarButtons = document.querySelectorAll('[data-bs-theme-value]'); // Botones dropdown
                const semiDarkDiv = document.querySelector('.template-customizer-semiDark');
                const navbarIcon = document.querySelector('#nav-theme .theme-icon-active'); // Icono visible en navbar

                // --- Función para aplicar tema
                function aplicarTema(selectedTheme) {
                    let appliedTheme = selectedTheme;

                    if (selectedTheme === 'system') {
                        appliedTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    }

                    // Aplicar tema real al HTML
                    document.documentElement.setAttribute('data-bs-theme', appliedTheme);
                    localStorage.setItem('theme', selectedTheme);

                    // Mostrar u ocultar semiDark
                    if (appliedTheme === 'light') {
                        semiDarkDiv.classList.remove('d-none');
                    } else {
                        semiDarkDiv.classList.add('d-none');
                    }

                    // Actualizar iconos dropdown y active
                    navbarButtons.forEach(btn => {
                        const value = btn.getAttribute('data-bs-theme-value');
                        const icon = btn.querySelector('i[data-icon]');
                        if (icon) {
                            icon.className = 'icon-base bx icon-md ' +
                                (value === 'light' ? 'bx-sun' : value === 'dark' ? 'bx-moon' : 'bx-desktop');
                        }
                        btn.classList.toggle('active', value === selectedTheme);
                    });

                    // Actualizar icono visible del navbar (usa selectedTheme, no appliedTheme)
                    if (navbarIcon) {
                        navbarIcon.className = 'bx icon-base bx icon-md ' +
                            (selectedTheme === 'light' ? 'bx-sun' : selectedTheme === 'dark' ? 'bx-moon' : 'bx-desktop');
                    }

                    // Marcar en customizer
                    radiosTheme.forEach(radio => {
                        radio.checked = (radio.value === selectedTheme);
                        radio.closest('.custom-option').classList.toggle('checked', radio.value === selectedTheme);
                    });
                }

                // --- Cargar tema guardado
                const savedTheme = localStorage.getItem('theme') || 'system';
                aplicarTema(savedTheme);

                // --- Detectar cambios en customizer
                radiosTheme.forEach(radio => {
                    radio.addEventListener('change', function() {
                        aplicarTema(this.value);
                    });
                });

                // --- Detectar cambios en navbar
                navbarButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const value = this.getAttribute('data-bs-theme-value');
                        aplicarTema(value);
                    });
                });

                // --- Cambios del sistema si está en system
                window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", e => {
                    const currentTheme = localStorage.getItem("theme") || "system";
                    if (currentTheme === "system") {
                        aplicarTema("system");
                    }
                });
            });
        </script>

        <script>
            //skins dafault borderd
            document.addEventListener("DOMContentLoaded", function() {
                const root = document.documentElement;
                const skinOptions = document.querySelectorAll(".template-customizer-skins .custom-option");
                const skinRadios = document.querySelectorAll('input[name="skinRadios"]');

                // --- Función para aplicar skin
                function aplicarSkin(skin) {
                    // Actualizar atributo data-skin en <html>
                    root.setAttribute("data-skin", skin);

                    // Guardar en localStorage
                    localStorage.setItem("skin", skin);

                    // Actualizar visualmente las opciones del customizer
                    skinOptions.forEach(option => option.classList.remove("checked"));
                    const selectedOption = [...skinOptions].find(o => o.querySelector('input[name="skinRadios"]').value === skin);
                    if (selectedOption) {
                        selectedOption.classList.add("checked");
                        const radio = selectedOption.querySelector('input[name="skinRadios"]');
                        if (radio) radio.checked = true;
                    }
                }

                // --- Cargar skin guardado o default al inicio
                const savedSkin = localStorage.getItem("skin") || "default";
                aplicarSkin(savedSkin);

                // --- Click en toda la opción (div, label, svg)
                skinOptions.forEach(option => {
                    option.addEventListener("click", function() {
                        const radio = option.querySelector('input[name="skinRadios"]');
                        if (radio) aplicarSkin(radio.value);
                    });
                });

                // --- Cambio directo en radios (accesibilidad)
                skinRadios.forEach(radio => {
                    radio.addEventListener("change", function() {
                        aplicarSkin(this.value);
                    });
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const DEFAULTS = {
                    primaryColor: "#696cff",
                    menuColor: "#0d3c94ff",
                    theme: "light",
                };

                const root = document.documentElement;
                const layoutMenu = document.getElementById("layout-menu");
                const semiDarkDiv = document.querySelector(".template-customizer-semiDark");
                const semiDarkSwitch = document.querySelector(".template-customizer-semi-dark-switch");
                const colorRadios = Array.from(document.querySelectorAll('input[name="colorRadioIcon"]'));
                const themeRadios = Array.from(document.querySelectorAll('input[name="customRadioIcon"]'));
                const resetBtn = document.querySelector(".template-customizer-reset-btn");
                const notificationDot = resetBtn ? resetBtn.querySelector(".badge-notifications") : null;
                const logoCatWrapper = document.querySelector(".app-brand-logo .text-primary");

                function mostrarNotificacion() {
                    if (notificationDot) notificationDot.classList.add("show");
                }

                function ocultarNotificacion() {
                    if (notificationDot) notificationDot.classList.remove("show");
                }

                function aplicarPrimaryColor(color, guardar = true, desdeUsuario = false) {
                    if (!color) return;
                    root.style.setProperty("--bs-primary", color);
                    if (guardar) localStorage.setItem("primaryColor", color);

                    colorRadios.forEach(r => r.closest(".custom-option")?.classList.remove("checked"));
                    const matched = colorRadios.find(r => r.value && r.value.toLowerCase() === color.toLowerCase());
                    if (matched) {
                        matched.checked = true;
                        matched.closest(".custom-option")?.classList.add("checked");
                    }

                    if (logoCatWrapper) logoCatWrapper.style.color = color;

                    if (desdeUsuario) mostrarNotificacion();
                }

                function aplicarMenuColor(color, guardar = true) {
                    if (!layoutMenu || !color) return;
                    layoutMenu.style.setProperty("--menu-bg-color", color);
                    if (guardar) localStorage.setItem("menuColor", color);
                }

                function aplicarSemiDark(enable, guardar = true, desdeUsuario = false) {
                    if (!layoutMenu) return;
                    if (enable) {
                        layoutMenu.classList.add("layout-menu-dark");
                        layoutMenu.setAttribute("data-semidark-menu", "true");
                    } else {
                        layoutMenu.classList.remove("layout-menu-dark");
                        layoutMenu.removeAttribute("data-semidark-menu");
                    }
                    if (semiDarkSwitch) semiDarkSwitch.checked = enable;
                    if (guardar) localStorage.setItem("semiDark", enable ? "true" : "false");
                    if (desdeUsuario) mostrarNotificacion();
                }

                function actualizarVisibilitySemiDark(theme) {
                    if (!semiDarkDiv) return;
                    if (theme === "light") semiDarkDiv.classList.remove("d-none");
                    else {
                        semiDarkDiv.classList.add("d-none");
                        aplicarSemiDark(false, false, false);
                    }
                }

                function aplicarTheme(themeValue, guardar = true, desdeUsuario = false) {
                    let applied = themeValue === "system" ? (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light") : themeValue;
                    root.setAttribute("data-bs-theme", applied);
                    if (guardar) localStorage.setItem("theme", themeValue);

                    themeRadios.forEach(r => {
                        r.checked = (r.value === themeValue);
                        r.closest(".custom-option")?.classList.remove("checked");
                        if (r.checked) r.closest(".custom-option")?.classList.add("checked");
                    });

                    actualizarVisibilitySemiDark(applied);
                    if (desdeUsuario) mostrarNotificacion();
                }

                // ---------- Inicialización ----------
                (function init() {
                    const savedPrimary = localStorage.getItem("primaryColor") || DEFAULTS.primaryColor;
                    aplicarPrimaryColor(savedPrimary, false, false);

                    const savedMenu = localStorage.getItem("menuColor") || savedPrimary || DEFAULTS.menuColor;
                    aplicarMenuColor(savedMenu, false);

                    const savedTheme = localStorage.getItem("theme") || DEFAULTS.theme;
                    aplicarTheme(savedTheme, false, false);

                    const savedSemi = localStorage.getItem("semiDark") === "true";
                    const currentTheme = root.getAttribute("data-bs-theme") || DEFAULTS.theme;
                    if (savedSemi && currentTheme === "light") aplicarSemiDark(true, false, false);
                    else aplicarSemiDark(false, false, false);

                    ocultarNotificacion(); // reset inicial oculto
                })();

                // ---------- Listeners UI ----------
                colorRadios.forEach(radio => radio.addEventListener("change", function() {
                    if (this.value === "picker") {
                        mostrarNotificacion();
                        return;
                    }
                    aplicarPrimaryColor(this.value, true, true);
                    aplicarMenuColor(this.value, true);
                }));

                if (semiDarkSwitch) {
                    semiDarkSwitch.addEventListener("change", function() {
                        aplicarSemiDark(this.checked, true, true);
                    });
                }

                themeRadios.forEach(radio => radio.addEventListener("change", function() {
                    aplicarTheme(this.value, true, true);
                    if (this.value === "dark") aplicarSemiDark(false, true, true);
                }));

                // cambios sistema si theme=system
                try {
                    window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", e => {
                        const saved = localStorage.getItem("theme") || DEFAULTS.theme;
                        if (saved === "system") {
                            const newTh = e.matches ? "dark" : "light";
                            root.setAttribute("data-bs-theme", newTh);
                            actualizarVisibilitySemiDark(newTh);
                        }
                    });
                } catch (ignored) {}

                // ---------- RESET ----------
                if (resetBtn) {
                    resetBtn.addEventListener("click", function(ev) {
                        ev.preventDefault();

                        // Limpiar localStorage completamente
                        localStorage.clear();

                        // 🔹 Recargar página para aplicar defaults reales
                        location.reload();
                    });
                }
            });
        </script>

        <script>
            //menu navehation
            document.addEventListener("DOMContentLoaded", function() {
                const layoutMenu = document.getElementById('layout-menu');
                const layoutRadios = document.querySelectorAll('input[name="layoutsRadios"]');
                const htmlTag = document.documentElement;

                // --- Aplicar layout
                function aplicarLayout(layout) {
                    if (layout === 'expanded') {
                        htmlTag.classList.remove('layout-menu-collapsed');
                        layoutMenu.classList.remove('layout-menu-collapsed');
                    } else if (layout === 'collapsed') {
                        htmlTag.classList.add('layout-menu-collapsed');
                        layoutMenu.classList.add('layout-menu-collapsed');
                    }

                    localStorage.setItem('menuLayout', layout);

                    // Marcar visualmente
                    layoutRadios.forEach(r => r.closest('.custom-option')?.classList.remove('checked'));
                    const selected = [...layoutRadios].find(r => r.value === layout);
                    if (selected) selected.closest('.custom-option')?.classList.add('checked');

                    // Marcar el radio correspondiente
                    const radio = document.querySelector(`input[name="layoutsRadios"][value="${layout}"]`);
                    if (radio) radio.checked = true;
                }

                // --- Cargar layout guardado o por defecto
                const savedLayout = localStorage.getItem('menuLayout') || 'expanded';
                aplicarLayout(savedLayout);

                // --- Escuchar cambios desde el customizer
                layoutRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        aplicarLayout(this.value);
                    });

                    // Capturar clic en label/SVG
                    radio.closest('.custom-option')?.addEventListener('click', function() {
                        aplicarLayout(radio.value);
                    });
                });
            });
        </script>
        <script>
            //navbar type
            document.addEventListener("DOMContentLoaded", function() {
                const navbarRadios = document.querySelectorAll('input[name="navbarOptionRadios"]');
                const htmlTag = document.documentElement;

                // --- Aplicar tipo de navbar
                function aplicarNavbar(type) {
                    // Partimos de clases base
                    let baseClasses = ['layout-compact', 'layout-menu-fixed'];

                    // Añadir clases según tipo
                    if (type === 'sticky') baseClasses.push('layout-navbar-fixed');
                    else if (type === 'hidden') baseClasses.push('layout-navbar-hidden');
                    // Static no necesita clase extra

                    // Aplicar al html
                    htmlTag.className = baseClasses.join(' ');

                    // Guardar en localStorage
                    localStorage.setItem('navbarType', type);

                    // Marcar visualmente el radio
                    navbarRadios.forEach(r => r.closest('.custom-option')?.classList.remove('checked'));
                    const selected = [...navbarRadios].find(r => r.value === type);
                    if (selected) selected.closest('.custom-option')?.classList.add('checked');

                    // Marcar el radio
                    const radio = document.querySelector(`input[name="navbarOptionRadios"][value="${type}"]`);
                    if (radio) radio.checked = true;
                }

                // --- Cargar valor guardado o default
                const savedNavbar = localStorage.getItem('navbarType') || 'sticky';
                aplicarNavbar(savedNavbar);

                // --- Escuchar cambios en el customizer
                navbarRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        aplicarNavbar(this.value);
                    });

                    // Capturar clic en label/SVG
                    radio.closest('.custom-option')?.addEventListener('click', function() {
                        aplicarNavbar(radio.value);
                    });
                });
            });
        </script>

        <script>
            //content compact wide
            document.addEventListener("DOMContentLoaded", function() {
                const contentRadios = document.querySelectorAll('input[name="contentRadioIcon"]');
                const htmlTag = document.documentElement;

                // Selecciona el nav y el div principal del contenido
                const navBar = document.querySelector('nav.layout-navbar');
                const contentDiv = document.querySelector('div.flex-grow-1.container-p-y');

                function aplicarContent(type) {
                    // --- Cambiar clase en html
                    htmlTag.classList.remove('layout-compact', 'layout-wide');
                    if (type === 'compact') htmlTag.classList.add('layout-compact');
                    else if (type === 'wide') htmlTag.classList.add('layout-wide');

                    // --- Cambiar clases del nav
                    if (navBar) {
                        navBar.classList.remove('container-xxl', 'container-fluid');
                        if (type === 'compact') navBar.classList.add('container-xxl');
                        else if (type === 'wide') navBar.classList.add('container-fluid');
                    }

                    // --- Cambiar clases del div de contenido
                    if (contentDiv) {
                        contentDiv.classList.remove('container-xxl', 'container-fluid');
                        if (type === 'compact') contentDiv.classList.add('container-xxl');
                        else if (type === 'wide') contentDiv.classList.add('container-fluid');
                    }

                    // --- Guardar en localStorage
                    localStorage.setItem('contentType', type);

                    // --- Marcar radio visualmente
                    contentRadios.forEach(r => r.closest('.custom-option')?.classList.remove('checked'));
                    const selected = [...contentRadios].find(r => r.value === type);
                    if (selected) selected.closest('.custom-option')?.classList.add('checked');

                    // --- Marcar el radio
                    const radio = document.querySelector(`input[name="contentRadioIcon"][value="${type}"]`);
                    if (radio) radio.checked = true;
                }

                // --- Cargar valor guardado o default
                const savedContent = localStorage.getItem('contentType') || (htmlTag.classList.contains('layout-wide') ? 'wide' : 'compact');
                aplicarContent(savedContent);

                // --- Escuchar cambios
                contentRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        aplicarContent(this.value);
                    });
                    // Clic en la opción completa
                    radio.closest('.custom-option')?.addEventListener('click', function() {
                        aplicarContent(radio.value);
                    });
                });
            });
        </script>


        <script>
            //el div customizer
            document.addEventListener("DOMContentLoaded", () => {
                const customizer = document.getElementById("template-customizer");
                const openBtn = document.querySelector(".template-customizer-open-btn");
                const closeBtn = document.querySelector(".template-customizer-close-btn");

                // Abrir
                openBtn.addEventListener("click", () => {
                    customizer.classList.add("template-customizer-open");
                    customizer.style.visibility = "visible";
                });

                // Cerrar
                closeBtn.addEventListener("click", () => {
                    customizer.classList.remove("template-customizer-open");
                    customizer.style.visibility = "visible";
                });
            });
        </script>

        <script>
            const commandPalette = document.getElementById('commandPalette');
            const commandInput = document.getElementById('commandInput');
            const commandResults = document.getElementById('commandResults');
            const searchTrigger = document.getElementById('searchTrigger');

            let routesCache = [];
            let selectedIndex = -1;

            // Abrir con click
            searchTrigger.addEventListener('click', async () => {
                openPalette();
            });

            // Abrir con CTRL+K
            document.addEventListener('keydown', async e => {
                if (e.ctrlKey && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    openPalette();
                }
                if (e.key === 'Escape') {
                    closePalette();
                }
            });

            async function openPalette() {
                commandPalette.classList.remove('d-none');
                commandInput.focus();
                await loadRoutes();
                showRoutes(routesCache);
            }

            function closePalette() {
                commandPalette.classList.add('d-none');
                selectedIndex = -1;
                commandInput.value = '';
            }

            async function loadRoutes() {
                if (routesCache.length > 0) return routesCache;
                const res = await fetch('{{ route("routes.list") }}');
                routesCache = await res.json();
                return routesCache;
            }

            function showRoutes(routes) {
                commandResults.innerHTML = '';

                if (!routes.length) {
                    commandResults.innerHTML = `<div class="text-muted">No se encontraron rutas</div>`;
                    return;
                }

                // Agrupar rutas por categoría
                const grouped = {};
                routes.forEach(r => {
                    const category = r.category || 'Otras rutas';
                    if (!grouped[category]) grouped[category] = [];
                    grouped[category].push(r);
                });

                // Iconos por categoría
                const categoryIcons = {
                    'Dashboard': ['menu-icon icon-base bx bx-home-circle', 'menu-icon icon-base bx bx-grid-alt', 'menu-icon icon-base bx bx-bar-chart'],
                    'Clientes': ['menu-icon icon-base bx bx-user-circle', 'menu-icon icon-base bx bx-user', 'menu-icon icon-base bx bx-group'],
                    'Empresas': ['menu-icon icon-base bx bx-building', 'menu-icon icon-base bx bx-briefcase', 'menu-icon icon-base bx bx-store'],
                    'Perfil': ['menu-icon icon-base bx bx-id-card', 'menu-icon icon-base bx bx-cog', 'menu-icon icon-base bx bx-shield'],
                    'Otras rutas': ['menu-icon icon-base bx bx-link', 'menu-icon icon-base bx bx-folder', 'menu-icon icon-base bx bx-layer']
                };

                Object.keys(grouped).forEach(section => {
                    const col = document.createElement('div');
                    col.className = 'col-md-6 suggestion-section';

                    col.innerHTML = `
            <p class="search-headings mb-2">${section}</p>
            <div class="suggestion-items"></div>
        `;

                    const container = col.querySelector('.suggestion-items');

                    grouped[section].forEach(r => {
                        const a = document.createElement('a');
                        a.href = r.url;
                        a.className = 'suggestion-item d-flex align-items-center';

                        // Elegir icono al azar de la categoría
                        const icons = categoryIcons[section] || ['menu-icon icon-base bx bx-link'];
                        const iconClass = icons[Math.floor(Math.random() * icons.length)];

                        // Formatear nombre de la ruta
                        let displayName = r.name.includes('.') ? r.name.split('.')[0] : r.name;
                        displayName = displayName.charAt(0).toUpperCase() + displayName.slice(1);

                        a.innerHTML = `<i class="${iconClass} me-2"></i><span>${displayName}</span>`;
                        container.appendChild(a);
                    });

                    commandResults.appendChild(col);
                });
            }


            commandInput.addEventListener('input', () => {
                const term = commandInput.value.toLowerCase();
                const filtered = routesCache.filter(r =>
                    (r.name && r.name.toLowerCase().includes(term)) ||
                    (r.uri && r.uri.toLowerCase().includes(term)) ||
                    (r.url && r.url.toLowerCase().includes(term))
                );
                showRoutes(filtered);
            });

            commandInput.addEventListener('keydown', e => {
                const items = commandResults.querySelectorAll('.command-item');
                if (items.length === 0) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex + 1) % items.length;
                    updateActive(items);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                    updateActive(items);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (selectedIndex >= 0) {
                        window.location.href = items[selectedIndex].dataset.uri;
                    }
                }
            });

            function updateActive(items) {
                items.forEach(i => i.classList.remove('active'));
                if (selectedIndex >= 0 && items[selectedIndex]) {
                    items[selectedIndex].classList.add('active');
                    items[selectedIndex].scrollIntoView({
                        block: "nearest"
                    });
                }
            }
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // --- Toast Bootstrap ---
                function showToast(message, type = 'primary') {
                    const toastEl = document.querySelector('.bs-toast');
                    toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
                    toastEl.querySelector('.toast-body').textContent = message;
                    const toast = new bootstrap.Toast(toastEl);
                    toast.show();
                }

                @if(session('success'))
                showToast("{{ session('success') }}", 'success');
                @endif

                @if($errors -> any())
                let errorMsg = '';
                @foreach($errors -> all() as $error)
                errorMsg += "{{ $error }}\n";
                @endforeach
                showToast(errorMsg.trim(), 'danger');
                @endif
            });
        </script>

        </script>


</body>

</html>