<!--=== JavaScript ===-->

    <script type="text/javascript" src="{{asset('melon/assets/js/libs/jquery-1.10.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('melon/bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/assets/js/libs/lodash.compat.min.js')}}"></script> 

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="assets/js/libs/html5shiv.js"></script>
    <![endif]-->

    <!-- Smartphone Touch Events -->
    <script type="text/javascript" src="{{asset('melon/plugins/touchpunch/jquery.ui.touch-punch.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/event.swipe/jquery.event.move.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/event.swipe/jquery.event.swipe.js')}}"></script>

    <!-- General -->
    <script type="text/javascript" src="{{asset('melon/assets/js/libs/breakpoints.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/respond/respond.min.js')}}"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
    <script type="text/javascript" src="{{asset('melon/plugins/cookie/jquery.cookie.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/slimscroll/jquery.slimscroll.horizontal.min.js')}}"></script>

    <!-- Page specific plugins -->
    <!-- Charts -->
    <!--[if lt IE 9]>
        <script type="text/javascript" src="plugins/flot/excanvas.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="{{asset('melon/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    
   
    <!-- Forms -->
    <script type="text/javascript" src="{{asset('melon/plugins/uniform/jquery.uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/plugins/select2/select2.min.js')}}"></script>

    <!-- App -->
    <script type="text/javascript" src="{{asset('melon/assets/js/app_them.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/assets/js/plugins.js')}}"></script>
    <script type="text/javascript" src="{{asset('melon/assets/js/plugins.form-components.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <!-- Demo JS -->
    <script type="text/javascript" src="{{asset('melon/assets/js/custom.js')}}"></script>
   
    <script>
        function initAllJs(){            
            "use strict";
            App.init(); // Init layout and core plugins
            Plugins.init(); // Init all plugins
            FormComponents.init(); // Init all form-specific plugins    
        }
        $(document).ready(function(){
           /* setTimeout(function(){
                "use strict";

                App.init(); // Init layout and core plugins
                Plugins.init(); // Init all plugins
                FormComponents.init(); // Init all form-specific plugins
            }, 1000);*/
            $('#set-dropdown>a').click(function(){
                if($(this).parent().hasClass("show")){
                    $(this).parent().removeClass("open");
                }else{
                    $(this).parent().addClass("open");
                }
            });
        });
    </script>