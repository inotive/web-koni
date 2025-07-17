<div class="py-4 footer d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">
                <script>
                    document.write(new Date().getFullYear())
                </script>
                &copy;
            </span>
            <a href="#" class="text-muted fw-bold">Perumda</a>
            <a href="#" class="text-orange fw-bold text-hover-primary">Varia Niaga</a>
            <span class="text-muted ms-1">- Content Management System</span>
        </div>
        <!--end::Copyright-->

        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1 order-md-2">
            <li class="menu-item">
                <span class="menu-link px-2">Versi 1.0.0</span>
            </li>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Container-->
</div>

<style>
    /* Memastikan footer selalu berada di bawah */
    html,
    body {
        height: 100%;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    .wrapper {
        flex: 1 0 auto;
        min-height: calc(100vh - 70px);
    }

    #kt_footer {
        flex-shrink: 0;
        margin-top: auto;
    }
</style>
