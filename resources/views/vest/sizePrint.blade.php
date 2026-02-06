<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Vest Size Print') }} - {{ $vest->V_M_ID }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none; }
            .page-break { page-break-before: always; }
            
            /* Ensure barcodes are visible when printing */
            img[alt*="barcode"],
            img[alt*="Barcode"],
            svg,
            canvas {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            /* Ensure barcode containers are visible */
            div[style*="barcode"],
            div[style*="Barcode"],
            th[colspan="2"],
            td[colspan="2"] {
                display: block !important;
                visibility: visible !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            
            /* Force print background colors and images */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }
        
        /* Ensure barcodes are visible on screen */
        img[alt*="barcode"],
        img[alt*="Barcode"],
        svg {
            display: inline-block !important;
            visibility: visible !important;
            max-width: 100% !important;
            width: 100% !important;
            height: auto !important;
        }
        
        /* Barcode specific styles */
        .barcode-container {
            display: block !important;
            visibility: visible !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        
        /* Ensure barcode images are properly sized and visible */
        .barcode-container img,
        .barcode-container svg {
            max-width: 100% !important;
            width: 100% !important;
            height: auto !important;
            display: block !important;
            margin: 0 auto !important;
        }
        
        /* Force barcode to take full width */
        .barcode-container img[alt*="barcode"],
        .barcode-container svg {
            width: 100% !important;
            max-width: 100% !important;
        }
        
        /* Side by side barcode layout */
        tr td[colspan='2'].barcode-container {
            display: table-cell !important;
            width: 50% !important;
        }
        
        /* Ensure barcode row displays horizontally */
        table tr.barcode-row,
        table tr[style*="table-row"] {
            display: table-row !important;
        }
        
        table tr.barcode-row td,
        table tr[style*="table-row"] td {
            display: table-cell !important;
            width: 50% !important;
        }
        
        @media print {
            tr td[colspan='2'].barcode-container {
                display: table-cell !important;
                width: 50% !important;
                page-break-inside: avoid !important;
            }
            
            table tr.barcode-row,
            table tr[style*="table-row"] {
                display: table-row !important;
            }
            
            table tr.barcode-row td,
            table tr[style*="table-row"] td {
                display: table-cell !important;
                width: 50% !important;
            }
        }

        .Inc_table {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            font-weight: bold;
        }

        .Inc_table1 {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .border-white {
            border-color: white !important;
        }

        .border-black {
            border-color: black !important;
        }

        .table-bordered {
            border-collapse: collapse;
        }

        .text-black {
            color: black !important;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .font-17 {
            font-size: 17px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="col-sm-12">
                <img src="{{ asset('image/logo.png') }}" alt="logo" width="97px" style="margin-top: -20px; margin-bottom:-118px">
                <h1 style="font-family:'Times New Roman', Times, serif;" class="text-center"><b>شاهید خیاطی و رخت فروشی</b></h1>
                <p class="font-17 text-black fw-bold text-center m-0" style="font-family:'Times New Roman', Times, serif;">
                    <span class="ri-whatsapp-line"></span><strong> +93784444247 </strong> &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="ri-phone-line"></span><strong>+93767958501</strong>&nbsp;&nbsp;&nbsp;: شماره تماس
                </p>
                <p class="font-17 text-black fw-bold text-end m-0" style="font-family:'Times New Roman', Times, serif;">
                    <strong> آدرس : ارزان قیمت چهاراهی محبس احمدزی مارکیت دوکان نمبر ۳ ، ۴ و ۵ </strong>
                </p>
            </div>

            <!-- Vest Measurement Table -->
            <table class="table-bordered border-black w-100 text-black" style="font-size: 20px;">
                <tr>
                    <td colspan="4" class="border-2"></td>
                </tr>
                <tr class="text-center text-black">
                    <td style="border-right:none;">{{ $vest->customer->cus_name }}</td>
                    <td class="border-white p-2">مشتری</td>
                    <td class="border-white">{{ $vest->customer->phone->pho_no ?? __('N/A') }}</td>
                    <td>شماره</td>
                </tr>
                <tr class="text-center">
                    <td class="Inc_table1">{{ $vest->Vest_Type ?? 'N/A' }}</td>
                    <td>نوع واسکت</td>
                    <td class="Inc_table1">{{ $vest->V_M_ID }}</td>
                    <td>ID</td>
                </tr>
                <tr class="text-center">
                    <td class="Inc_table1">{{ $vest->size ?? 'N/A' }}</td>
                    <td>سایز</td>
                    <td class="Inc_table1">{{ $vest->vest_rate ?? '0' }}</td>
                    <td>نرخ</td>
                </tr>
                <tr class="text-center">
                    <td class="Inc_table" colspan="2">فرمایش واسکت</td>
                    <td class="Inc_table1">{{ $vest->Height ?? '0' }}</td>
                    <td>قد</td>
                </tr>
                <tr class="text-center">
                    <td class="Inc_table">{{ $vest->Shoulder ?? '0' }}</td>
                    <td class="Inc_table">شانه</td>
                    <td class="Inc_table1">{{ $vest->Armpit ?? '0' }}</td>
                    <td>بغل</td>
                </tr>
                <tr class="text-center">
                    <td class="Inc_table">{{ $vest->Waist ?? '0' }}</td>
                    <td class="Inc_table">کمر</td>
                    <td class="Inc_table1">{{ $vest->Shana ?? 'N/A' }}</td>
                    <td>نوع شانه</td>
                </tr>
                <tr class="text-center">
                    <td class="Inc_table">{{ $vest->Kalar ?? 'N/A' }}</td>
                    <td class="Inc_table">انواع کالر</td>
                    <td class="Inc_table1">{{ $vest->Daman ?? 'N/A' }}</td>
                    <td>انواع دامن</td>
                </tr>
                <tr class="text-center">
                    <td class="Inc_table">{{ $vest->NawaWaskat ?? 'N/A' }}</td>
                    <td class="Inc_table">انواع واسکت</td>
                    <td class="Inc_table1">{{ $vest->Status ?? 'pending' }}</td>
                    <td>حالت</td>
                </tr>
                <tr>
                    <td colspan="4" style="border-bottom: 3px dashed black;">
                        <p class="text-end" style="margin-bottom:90px;">
                            <span>مطابق دیزاین پاکستان</span>
                            <span>0784444247</span>
                            <span>واتساپ</span>
                        </p>
                    </td>
                </tr>
                <tr style="display: table-row !important;">
                    <!-- Customer Phone Barcode - Left side -->
                    <td colspan='2' class='text-center barcode-container' style='border: none !important; border-left: none !important; border-right: 1px solid black !important; border-top: none !important; border-bottom: none !important; width: 50% !important; display: table-cell !important; vertical-align: middle; padding: 5px; margin: 0; background: #f0f0f0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important;'>
                        <div class="barcode-container" style="height: 60px; display: flex !important; align-items: center !important; justify-content: center !important; flex-direction: column; visibility: visible !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; width: 100%; margin: 0; padding: 0;">
                            @if($vest->customer && $vest->customer->phone && $vest->customer->phone->pho_no)
                                @php
                                    try {
                                        $barcode = new \Milon\Barcode\DNS1D();
                                        // Display barcode with integrated text, full width
                                        echo $barcode->getBarcodeHTML((string)$vest->customer->phone->pho_no, 'C128', 2.5, 35, 'black', true);
                                    } catch (\Exception $e) {
                                        echo '<div style="height: 30px; width: 100%; background: repeating-linear-gradient(90deg, #000 0px, #000 2px, #fff 2px, #fff 4px); -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; margin: 0 auto;"></div>';
                                        echo '<p style="margin-top: 5px; font-size: 12px; text-align: center;">' . htmlspecialchars($vest->customer->phone->pho_no) . '</p>';
                                    }
                                @endphp
                            @else
                                <div style="height: 30px; width: 100%; background: repeating-linear-gradient(90deg, #000 0px, #000 2px, #fff 2px, #fff 4px); -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; margin: 0 auto;"></div>
                                <p style="margin-top: 5px; font-size: 12px; text-align: center;">{{ __('N/A') }}</p>
                            @endif
                        </div>
                    </td>
                    <!-- Vest ID Barcode - Right side -->
                    <td colspan='2' class='text-center barcode-container' style='border: none !important; border-left: none !important; border-right: none !important; border-top: none !important; border-bottom: none !important; width: 50% !important; display: table-cell !important; vertical-align: middle; padding: 5px; margin: 0; background: #f0f0f0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important;'>
                        <div class="barcode-container" style="height: 60px; display: flex !important; align-items: center !important; justify-content: center !important; flex-direction: column; visibility: visible !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; width: 100%; margin: 0; padding: 0;">
                            @if($vest->V_M_ID)
                                @php
                                    try {
                                        $barcode = new \Milon\Barcode\DNS1D();
                                        // Display barcode with integrated text, full width
                                        echo $barcode->getBarcodeHTML((string)$vest->V_M_ID, 'C128', 2.5, 35, 'black', true);
                                    } catch (\Exception $e) {
                                        echo '<div style="height: 30px; width: 100%; background: repeating-linear-gradient(90deg, #000 0px, #000 2px, #fff 2px, #fff 4px); -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; margin: 0 auto;"></div>';
                                        echo '<p style="margin-top: 5px; font-size: 12px; text-align: center;">' . htmlspecialchars($vest->V_M_ID) . '</p>';
                                    }
                                @endphp
                            @else
                                <div style="height: 30px; width: 100%; background: repeating-linear-gradient(90deg, #000 0px, #000 2px, #fff 2px, #fff 4px); -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; margin: 0 auto;"></div>
                                <p style="margin-top: 5px; font-size: 12px; text-align: center;">N/A</p>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end font-monospace">
                        <span>
                            @if($vest->O_date && $vest->R_date)
                                {{ $vest->O_date }}--
                                {{ $vest->R_date }}
                                @php
                                    try {
                                        $date1 = new DateTime($vest->O_date);
                                        $date2 = new DateTime($vest->R_date);
                                        $interval = $date1->diff($date2);
                                        echo "--> " . $interval->format('%a') . ' {{ __('days') }}';
                                    } catch (\Exception $e) {
                                        echo "--> 0 {{ __('days') }}";
                                    }
                                @endphp
                            @else
                                {{ $vest->O_date ?? __('N/A') }}--{{ $vest->R_date ?? __('N/A') }}
                            @endif
                        </span>
                        <span>تاریخ واپسی ـ</span>
                    </td>
                </tr>
            </table>
            <br>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>
