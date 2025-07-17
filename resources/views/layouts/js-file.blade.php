<!--begin::Javascript-->
<script>
    var hostUrl = "assets/";
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>

<!--CKEditor Build Bundles:: Only include the relevant bundles accordingly-->
<script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
{{-- <script src=" {{ asset('assets/plugins/custom/ckeditor/ckeditor-inline.bundle.js') }}"></script> --}}
{{-- <script src=" {{ asset('assets/plugins/custom/ckeditor/ckeditor-balloon.bundle.js') }}"></script>
<script src=" {{ asset('assets/plugins/custom/ckeditor/ckeditor-balloon-block.bundle.js') }} "></script>
<script src=" {{ asset('assets/plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script> --}}

<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        preventDuplicates: true,
        positionClass: "toastr-top-right",
        timeOut: "5000",
        showDuration: "300",
        hideDuration: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };
</script>

@if (session()->has('OK'))
    <script>
        toastr.success({!! json_encode(session()->pull('OK')) !!}, 'Success!');
    </script>
@endif

@if (session()->has('SUC'))
    <script>
        toastr.success({!! json_encode(session()->pull('SUC')) !!}, 'Success!');
    </script>
@endif

@if (session()->has('ERR'))
    <script>
        toastr.error({!! json_encode(session()->pull('ERR')) !!}, 'Error!');
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error({!! json_encode($error) !!}, "Error!");
        </script>
    @endforeach
@endif

<script>
    $('.datatable').DataTable();
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
