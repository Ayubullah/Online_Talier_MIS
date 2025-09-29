<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Size Print - {{ $cloth->cm_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none; }
            .page-break { page-break-before: always; }
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
                            @if($invoice)
                                {{ $invoice->inc_date }}--{{ $cloth->R_date }}
                                -->
                                @php
                                    $orderDate = \Carbon\Carbon::parse($invoice->inc_date);
                                    $receiveDate = \Carbon\Carbon::parse($cloth->R_date);
                                    $daysDiff = $orderDate->diffInDays($receiveDate);
                                @endphp
                                {{ $daysDiff }} days
                            @else
                                {{ $cloth->O_date }}--{{ $cloth->R_date }}
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
