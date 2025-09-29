<!DOCTYPE html>
<html>
<head>
    <title>Header</title>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* --- HEADER IMAGE --- */
        .letterhead {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            text-align: center;
            height: 151px; /* actual header image height */
        }

        .letterhead img {
            width: 100%;
            height: auto;
            max-height: 151px; /* match your letterhead (810x151) */
            object-fit: contain;
        }
    </style>
</head>
<body>
    <!-- HEADER IMAGE -->
    <div class="letterhead">
        @php
            $headerImagePath = public_path('assets/img/kop-nobg.png');
            if(file_exists($headerImagePath)) {
                $headerImageMimeType = mime_content_type($headerImagePath);
                $headerImageData = base64_encode(file_get_contents($headerImagePath));
                $headerImageSrc = 'data:' . $headerImageMimeType . ';base64,' . $headerImageData;
                echo '<img src="' . $headerImageSrc . '" alt="KONI Letterhead">';
            } else {
                // Fallback if image doesn't exist
                echo '<div style="height: 151px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                        <span style="color: #6c757d; font-weight: bold;">LOGO KONI</span>
                      </div>';
            }
        @endphp
    </div>
</body>
</html>