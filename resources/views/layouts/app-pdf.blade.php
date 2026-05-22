<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

        <!-- Fonts -->
        <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('/assets/vendor/css/core.css') }}" />
        <link rel="stylesheet" href="{{ asset('/assets/vendor/css/theme-default.css') }}"/>
        <link rel="stylesheet" href="{{ asset('/assets/css/custom.css') }}" />
        @if(isset($type) && $type && $type == 'print')
        <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/app-invoice-print.css') }}" />
        @endif
        <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
        @if(isset($type) && $type && $type == 'download')
        @stack('styles')
        @endif
        <style type="text/css" media="print">
          @page
          {
              size: auto;   /* auto is the initial value */
              margin: 0mm;  /* this affects the margin in the printer settings */
          }
        </style>
    </head>

    <body>
        <!-- Content -->
        <div class="invoice-print p-5" id="content-to-pdf">
            @yield('content')
        </div>
        <!-- / Content -->
        @if(isset($type) && $type && $type == 'download')
            <script>
                generatePDF()
                function generatePDF() {
                    const element = document.getElementById('content-to-pdf');
                    const pdfName = "{{ $file_pdf }}";
                    html2pdf()
                        .from(element)
                        .set({
                            filename: pdfName,
                        })
                        .save();

                }
            </script>
        @endif
        @if(isset($type) && $type && $type == 'print')
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
            window.addEventListener("load", window.print());
            </script>
        @endif
    </body>
</html>
