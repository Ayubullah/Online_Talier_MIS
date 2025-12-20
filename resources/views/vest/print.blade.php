<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vest Invoice - {{ $invoiceId }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .d-print-none { display: none !important; }
            body { font-size: 14px; }
            .table { page-break-inside: avoid; }
            
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
            height: auto !important;
        }
        
        .Inc_table1 { 
            border: 1px solid black; 
            padding: 8px; 
            text-align: center; 
        }
        
        .Inc_table { 
            border: 1px solid black; 
            padding: 8px; 
            text-align: center; 
        }
        
        .table-bordered {
            border: 2px solid black !important;
        }
        
        .table-bordered td, .table-bordered th {
            border: 1px solid black !important;
        }
        
        .border-white {
            border-left: none !important;
            border-right: none !important;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        
        .font-17 {
            font-size: 17px;
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
    </style>
</head>
<body>

<script type="text/javascript">
    window.onload = function() {
        window.print();
    };
</script>

<div class="container m-0 p-0">
    <div class="container-fluid m-0 p-0">
        <button class="btn btn-outline-primary btn-back d-print-none" onclick="history.back()">Back</button>

        <!-- Start Vest invoice -->
        <div class="row">
            <div class="col-12">
                <div class="">
                    <div class="">
                        @if($vests->count() > 0)
                            <!-- Invoice Logo-->
                            <div class="clearfix">
                                <div class="mt-1 text-black fw-bold">
                                    <img src="{{ asset('image/logo.jpg') }}" alt="logo" width="97px" style="margin-top: -20px; margin-bottom:-118px">
                                    <h1 style="font-family:'Times New Roman', Times, serif;" class="text-center"><b>شاهید خیاطی و رخت فروشی</b></h1>
                                    <p class="font-17 text-black fw-bold text-center m-0" style="font-family:'Times New Roman', Times, serif;">
                                        <span class="ri-whatsapp-line"></span><strong> +93784444247 </strong> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="ri-phone-line"></span><strong>+93767958501</strong>&nbsp;&nbsp;&nbsp;: شماره تماس
                                    </p>
                                    <p class="font-17 text-black fw-bold text-end m-0" style="font-family:'Times New Roman', Times, serif;">
                                        <strong> آدرس : ارزان قیمت چهاراهی محبس احمدزی مارکیت دوکان نمبر ۳ ، ۴ و ۵ </strong>
                                    </p>
                                </div>
                            </div>
                            <!-- Invoice Logo-->

                            <!-- Invoice Detail-->
                            <div class="row">
                                <div class="col-6">
                                    <!-- <img src="barcode.png" alt="" srcset=""> -->
                                </div>
                                <!-- end col -->
                                <div class="col-4">
                                    <div class="">
                                        <!-- Invoice info will be here -->
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <!-- Invoice Detail-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-group-divider m-0 p-0" style="border: 1px solid black;height:601px">
                                        <table class="table-bordered w-100">
                                            <thead class="">
                                                <tr>
                                                    <th colspan="7">
                                                        <strong>Date :</strong> {{ $invoice->inc_date }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <strong>ID :</strong> {{ $invoiceId }}
                                                    </th>
                                                    <th colspan="3" class="text-center barcode-container" style="padding: 5px; border: none !important; border-left: none !important; border-right: none !important; border-top: none !important; border-bottom: none !important; width: 100%; background: #f0f0f0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important;">
                                                        <!-- Invoice ID Barcode - Full width -->
                                                        <div class="barcode-container" style="display: flex !important; justify-content: center !important; align-items: center !important; width: 100% !important; visibility: visible !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; margin: 0; padding: 0;">
                                                            @php
                                                                try {
                                                                    $barcode = new \Milon\Barcode\DNS1D();
                                                                    // Display barcode with integrated text, full width
                                                                    echo $barcode->getBarcodeHTML((string)$invoiceId, 'C128', 3, 40, 'black', true);
                                                                } catch (\Exception $e) {
                                                                    echo '<div style="height: 50px; display: flex; align-items: center; justify-content: center; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important;">Barcode: ' . htmlspecialchars($invoiceId) . '</div>';
                                                                }
                                                            @endphp
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="text-white bg-info">SO</th>
                                                    <th class="text-white bg-info">RO</th>
                                                    <th class="text-white bg-info">Name</th>
                                                    <th class="text-white bg-info">Phone</th>
                                                    <th class="text-white bg-info">Date</th>
                                                    <th class="text-white bg-info">Rate</th>
                                                    <th class="text-white bg-info">Paid</th>
                                                    <th class="text-white bg-info">Remain</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $num = 0;
                                                @endphp
                                                @foreach($vests as $vest)
                                                @php
                                                    $num += 1;
                                                @endphp
                                                <tr>
                                                    <td class="text-black">{{ $num }}</td>
                                                    <td class="text-black">{{ $vest->V_M_ID }}</td>
                                                    <td class="text-black">{{ $vest->customer->cus_name }}</td>
                                                    <td class="text-black">{{ $vest->customer->phone->pho_no ?? 'N/A' }}</td>
                                                    <td class="text-black">{{ $invoice->inc_date }}</td>
                                                    <td class="text-black">{{ $vest->vest_rate }}</td>
                                                    <td class="text-black">{{ $totalPaid }}</td>
                                                    <td class="text-black">{{ $totalRemain }}</td>
                                                </tr>
                                                @endforeach
                                                
                                                @php
                                                    $send = $num;
                                                    $totalRows = 20; // Total number of rows you want to echo
                                                    $remainingRows = $totalRows - $send; // Calculate how many more rows to echo
                                                @endphp
                                                
                                                @for($i = $send + 1; $i <= $remainingRows + $send; $i++)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4 col-lg-4 order-1">
                                    <div class="float-end mt-3 mt-sm-0">
                                        <div class="">
                                            <table class="table-bordered table-group-divider">
                                                <thead>
                                                    <tr>
                                                        <th class='text-black'>Total</th>
                                                        <td class='text-black'><b>{{ $totalRate }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th class='text-black'>Discount:</th>
                                                        <td class="text-end text-black"><b>0</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th class='text-black'>Total Remain :</th>
                                                        <td class='text-black text-end'><b>{{ $totalRemain }}</b></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-8 col-lg-8">
                                    <div class="clearfix pt-3 text-black fw-bold">
                                        <small class="text-black">
                                            Total Amount is : <b>{{ ucwords(\Illuminate\Support\Str::title(number_to_words($totalRate))) }}</b><br>
                                            <small>
                                                Note: If a Bill Paper Is Lost, It Will Not Be Returned.<br>
                                            </small>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <!-- ========== Start Size section ========== -->
                            @foreach($vests as $vest)
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-sm-12">
                                        <div class="mt-1 text-black fw-bold">
                                            <img src="{{ asset('image/logo.jpg') }}" alt="logo" width="97px" style="margin-top: -20px; margin-bottom:-118px">
                                            <h1 style="font-family:'Times New Roman', Times, serif;" class="text-center"><b>شاهید خیاطی و رخت فروشی</b></h1>
                                            <p class="font-17 text-black fw-bold text-center m-0" style="font-family:'Times New Roman', Times, serif;">
                                                <span class="ri-whatsapp-line"></span><strong> +93784444247 </strong> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <span class="ri-phone-line"></span><strong>+93767958501</strong>&nbsp;&nbsp;&nbsp;: شماره تماس
                                            </p>
                                            <p class="font-17 text-black fw-bold text-end m-0" style="font-family:'Times New Roman', Times, serif;">
                                                <strong> آدرس : ارزان قیمت چهاراهی محبس احمدزی مارکیت دوکان نمبر ۳ ، ۴ و ۵ </strong>
                                            </p>
                                            <!-- <p class="text-black font-13"><span>0093 784444247 : الیاس شاهد </span> : 767645757 0093 | <span>خالد شاهد </span></p> -->
                                        </div>
                                    </div>

                                    <!-- Vest Measurement Table -->
                                    <table class="table-bordered border-black w-100 text-black" style="font-size: 20px;">
                                        <tr>
                                            <td colspan="4" class="border-2"></td>
                                        </tr>
                                        <tr class="text-center text-black">
                                            <td style="border-right:none;">{{ $vest->customer->cus_name }}</td>
                                            <td class="border-white p-2">مشتری</td>
                                            <td class="border-white">{{ $vest->customer->phone->pho_no ?? 'N/A' }}</td>
                                            <td>شماره</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table1">0</td>
                                            <td>خالی</td>
                                            <td class="Inc_table1">{{ $vest->V_M_ID }}</td>
                                            <td>ID</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table1">0</td>
                                            <td>خالی</td>
                                            <td class="Inc_table1">{{ $vest->Vest_Type ?? '0' }}</td>
                                            <td>ډول</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table" colspan="2">فرمایش واسکت</td>
                                            <td class="Inc_table1">{{ $vest->size }}</td>
                                            <td>نوع لباس</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $vest->Shana ?? '' }}</td>
                                            <td class="Inc_table">نوع شانه</td>
                                            <td class="Inc_table1">{{ $vest->Height ?? '' }}</td>
                                            <td>قد</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $vest->Kalar ?? '' }}</td>
                                            <td class="Inc_table">انواع کالر</td>
                                            <td class="Inc_table1">{{ $vest->Shoulder ?? '' }}</td>
                                            <td>شانه</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $vest->Daman ?? '' }}</td>
                                            <td class="Inc_table">انواع دامن</td>
                                            <td class="Inc_table1">{{ $vest->Armpit ?? '' }}</td>
                                            <td>بغل</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $vest->NawaWaskat ?? '' }}</td>
                                            <td class="Inc_table">انواع واسکت</td>
                                            <td class="Inc_table1">{{ $vest->Waist ?? '' }}</td>
                                            <td>کمر</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $vest->Daman ?? '' }}</td>
                                            <td class="Inc_table">انواع دامن</td>
                                            <td class="Inc_table1">{{ $vest->Armpit ?? '' }}</td>
                                            <td>بغل</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table" style="">0</td>
                                            <td class="Inc_table">خالی</td>
                                            <td class="Inc_table1">0</td>
                                            <td>خالی</td>
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
                                                        <p style="margin-top: 5px; font-size: 12px; text-align: center;">N/A</p>
                                                    @endif
                                                </div>
                                            </td>
                                            <!-- Vest Measurement ID Barcode - Right side -->
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
                                                    {{ $invoice->inc_date }}--
                                                    {{ $vest->R_date }}
                                                    @php
                                                        try {
                                                            $date1 = new DateTime($invoice->inc_date);
                                                            $date2 = new DateTime($vest->R_date);
                                                            $interval = $date1->diff($date2);
                                                            echo "--> " . $interval->format('%a days');
                                                        } catch (\Exception $e) {
                                                            echo "--> 0 days";
                                                        }
                                                    @endphp
                                                </span>
                                                <span>تاریخ واپسی ـ</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                </div>
                            </div>
                            @endforeach
                            <!-- ========== End Size section ========== -->

                        @else
                            <h1 class='text-center text-danger'>
                                No Invoice Record found!<br>
                                Please Enter the Record
                            </h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--End Vest invoice -->
    </div>
</div>

@php
function number_to_words($number) {
    $ones = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    $teens = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    $tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    $thousands = ['', 'thousand', 'million', 'billion'];

    if ($number < 10) {
        return $ones[$number];
    } elseif ($number < 20) {
        return $teens[$number - 10];
    } elseif ($number < 100) {
        return $tens[floor($number / 10)] . ($number % 10 > 0 ? ' ' . $ones[$number % 10] : '');
    } elseif ($number < 1000) {
        return $ones[floor($number / 100)] . ' hundred' . ($number % 100 > 0 ? ' and ' . number_to_words($number % 100) : '');
    } elseif ($number < 1000000) {
        return number_to_words(floor($number / 1000)) . ' ' . $thousands[1] . ($number % 1000 > 0 ? ' ' . number_to_words($number % 1000) : '');
    } elseif ($number < 1000000000) {
        return number_to_words(floor($number / 1000000)) . ' ' . $thousands[2] . ($number % 1000000 > 0 ? ' ' . number_to_words($number % 1000000) : '');
    } else {
        return number_to_words(floor($number / 1000000000)) . ' ' . $thousands[3] . ($number % 1000000000 > 0 ? ' ' . number_to_words($number % 1000000000) : '');
    }
}
@endphp

</body>
</html>
