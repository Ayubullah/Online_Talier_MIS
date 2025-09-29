<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloth Invoice - {{ $invoiceId }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .d-print-none { display: none !important; }
            body { font-size: 14px; }
            .table { page-break-inside: avoid; }
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

        <!-- Start Cloth invoice -->
        <div class="row">
            <div class="col-12">
                <div class="">
                    <div class="">
                        @if($cloths->count() > 0)
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
                                <div class="col-6"></div>
                                <div class="col-4">
                                    <div class="">
                                        <!-- Invoice info will be here -->
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Detail-->

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-group-divider m-0 p-0" style="border: 1px solid black;height:601px">
                                        <table class="table-bordered w-100">
                                            <thead class="">
                                                <tr>
                                                    <th colspan="6">
                                                        <strong>Date :</strong> {{ $invoice->inc_date }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <strong>ID :</strong> {{ $invoiceId }}
                                                    </th>
                                                    <th colspan="2" class="text-center">
                                                        <!-- Barcode placeholder -->
                                                        <div style="height: 50px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                                            Barcode: {{ $invoiceId }}
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
                                                @foreach($cloths as $index => $cloth)
                                                <tr>
                                                    <td class="text-black">{{ $index + 1 }}</td>
                                                    <td class="text-black">{{ $cloth->cm_id }}</td>
                                                    <td class="text-black">{{ $cloth->customer->cus_name }}</td>
                                                    <td class="text-black">{{ $cloth->customer->phone->pho_no ?? 'N/A' }}</td>
                                                    <td class="text-black">{{ $invoice->inc_date }}</td>
                                                    <td class="text-black">{{ $cloth->cloth_rate }}</td>
                                                    <td class="text-black">{{ $totalPaid }}</td>
                                                    <td class="text-black">{{ $totalRemain }}</td>
                                                </tr>
                                                @endforeach
                                                
                                                @php
                                                    $currentRows = $cloths->count();
                                                    $totalRows = 20;
                                                    $remainingRows = $totalRows - $currentRows;
                                                @endphp
                                                
                                                @for($i = $currentRows + 1; $i <= $totalRows; $i++)
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
                            @foreach($cloths as $cloth)
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-sm-12">
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

                                    <!-- Cloth Measurement Table -->
                                    <table class="table-bordered border-black w-100 text-black" style="font-size: 20px;">
                                        <tr>
                                            <td colspan="4" class="border-2"></td>
                                        </tr>
                                        <tr class="text-center text-black">
                                            <td style="border-right:none;">{{ $cloth->customer->cus_name }}</td>
                                            <td class="border-white p-2">مشتری</td>
                                            <td class="border-white">{{ $cloth->customer->phone->pho_no ?? 'N/A' }}</td>
                                            <td>شماره</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table1">{{ $cloth->Trousers ?? '0' }}</td>
                                            <td>قد تنبان</td>
                                            <td class="Inc_table1">{{ $cloth->cm_id }}</td>
                                            <td>ID</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table1">{{ $cloth->Pacha ?? '0' }}</td>
                                            <td>پاچه</td>
                                            <td class="Inc_table1">{{ $cloth->size }}</td>
                                            <td>نوع لباس</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table" colspan="2">فرمایش لباس</td>
                                            <td class="Inc_table1">{{ $cloth->Height }}</td>
                                            <td>قد</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $cloth->Kaff }}</td>
                                            <td class="Inc_table">انواع کف</td>
                                            <td class="Inc_table1">{{ $cloth->Shoulder }}</td>
                                            <td>شانه</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $cloth->Kalar }}</td>
                                            <td class="Inc_table">انواع کالر</td>
                                            <td class="Inc_table1">{{ $cloth->Sleeve }}</td>
                                            <td>آستین</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $cloth->sleeve_type }}</td>
                                            <td class="Inc_table">انواع أستين</td>
                                            <td class="Inc_table1">{{ $cloth->Collar }}</td>
                                            <td>یخن</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $cloth->Shalwar }}</td>
                                            <td class="Inc_table">انواع تنبان</td>
                                            <td class="Inc_table1">{{ $cloth->chati }}</td>
                                            <td>چهاتی</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $cloth->Daman }}</td>
                                            <td class="Inc_table">انواع دامن</td>
                                            <td class="Inc_table1">{{ $cloth->Armpit }}</td>
                                            <td>بغل</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="Inc_table">{{ $cloth->Jeb }}</td>
                                            <td class="Inc_table">انواع جیب</td>
                                            <td class="Inc_table1">{{ $cloth->Skirt }}</td>
                                            <td>دامن</td>
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
                                        <tr>
                                            <td colspan='2' class='text-center' style='border-bottom: 3px dashed black;border-right:1px solid white;'>
                                                <!-- Customer Phone Barcode -->
                                                <div style="height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                                    @if($cloth->customer && $cloth->customer->phone && $cloth->customer->phone->pho_no)
                                                        @php
                                                            try {
                                                                $barcode = new \Milon\Barcode\DNS1D();
                                                                // Display barcode with integrated text
                                                                echo $barcode->getBarcodeHTML($cloth->customer->phone->pho_no, 'C128', 1.5, 30, 'black', true);
                                                            } catch (\Exception $e) {
                                                                echo '<div style="height: 30px; width: 150px; background: repeating-linear-gradient(90deg, #000 0px, #000 2px, #fff 2px, #fff 4px);"></div>';
                                                                echo '<p style="margin-top: 5px; font-size: 12px; text-align: center;">{{ $cloth->customer->phone->pho_no }}</p>';
                                                            }
                                                        @endphp
                                                    @else
                                                        <div style="height: 30px; width: 150px; background: repeating-linear-gradient(90deg, #000 0px, #000 2px, #fff 2px, #fff 4px);"></div>
                                                        <p style="margin-top: 5px; font-size: 12px; text-align: center;">N/A</p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td colspan='2' class='text-center p-5' style='border-bottom: 3px dashed black;'>
                                                <!-- Measurement ID Barcode -->
                                                <div style="height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                                    @if($cloth->cm_id)
                                                        @php
                                                            try {
                                                                $barcode = new \Milon\Barcode\DNS1D();
                                                                // Display barcode with integrated text
                                                                echo $barcode->getBarcodeHTML($cloth->cm_id, 'C128', 1.5, 30, 'black', true);
                                                            } catch (\Exception $e) {
                                                                echo '<div style="height: 30px; width: 150px; background: repeating-linear-gradient(90deg, #000 0px, #000 2px, #fff 2px, #fff 4px);"></div>';
                                                                echo '<p style="margin-top: 5px; font-size: 12px; text-align: center;">{{ $cloth->cm_id }}</p>';
                                                            }
                                                        @endphp
                                                    @else
                                                        <div style="height: 30px; width: 150px; background: repeating-linear-gradient(90deg, #000 0px, #000 2px, #fff 2px, #fff 4px);"></div>
                                                        <p style="margin-top: 5px; font-size: 12px; text-align: center;">N/A</p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end font-monospace">
                                                <span>
                                                    {{ $invoice->inc_date }}--{{ $cloth->R_date }}
                                                    --> 
                                                    @php
                                                        $orderDate = \Carbon\Carbon::parse($invoice->inc_date);
                                                        $receiveDate = \Carbon\Carbon::parse($cloth->R_date);
                                                        $daysDiff = $orderDate->diffInDays($receiveDate);
                                                    @endphp
                                                    {{ $daysDiff }} days
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
        <!--End Cloth invoice -->
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
