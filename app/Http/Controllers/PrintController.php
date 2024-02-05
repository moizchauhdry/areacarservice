<?php

namespace App\Http\Controllers;

use App\Model\user\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use PDF;

class PrintController extends Controller
{
    private function customerContractEmail($customer)
    {
        try {
            $mail_data = [
                "personalizations" => [
                    [
                        "to" => [
                            [
                                "email" => $customer->email,
                            ],
                            [
                                "email" => 'info@areacarservice.com',
                            ],
                        ],
                        "dynamic_template_data" => [
                            "image_url" => 'https://admin.areacarservice.com/public/images/logo.png',
                            "confirmation_no" => $customer->id,
                            "customer_contract_url" => 'https://admin.areacarservice.com/generate/' . $customer->id
                        ]
                    ]
                ],
                "from" => [
                    "email" => "info@areacarservice.com",
                    "name" => "Area Car Service"
                ],
                "subject" => "Customer Contract",
                "content" => [
                    ["type" => "text/html", "value" => "Customer Contract"]
                ],
                "template_id" =>  "d-85c5ccc3903e49e195e75bd8d69f5aed "
            ];

            $url = 'https://api.sendgrid.com/v3/mail/send';
            $_data = json_encode($mail_data);
            $headers = array(
                'Content-Type: application/json',
                'Authorization:Bearer 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',
            );

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $_data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($curl);
        } catch (\Throwable $th) {
            // dd($th);
        }
    }

    public function invoice($id)
    {
        $customer = User::find($id);
        $data = [
            "image_url" => 'https://www.admin.areacarservice.com/public/images/logo.png',
            "confirmation_no" => $customer->id,
            "booking_date" => date('m/d/Y h:i A', strtotime($customer->date)),
            "pickup_location" => $customer->pickup,
            "dropoff_location" => $customer->destination,
            "flight_no" => $customer->flight_no,
            "vehicle" => $customer->vehicle,
            "payment_type" => $customer->pay_type,
            "base_fare" => $customer->actual_price,
            "toll" => $customer->toll,
            "tip" => $customer->tip,
            "processing_fee" => $customer->process_fee,
            "discount" => $customer->discount,
            "price_charged" => $customer->price,
            "total_price" => $customer->price,
            "addt_msg" => $customer->addt_msg,
            "price_reason" => $customer->price_reason,
            "clear" => $customer->clear,
        ];

        $pdf = PDF::loadView('prints.invoice', $data);

        return $pdf->download('invoice.pdf');
    }

    public function signature($id)
    {
        return view('admin.user.signature', compact('id'));
    }

    public function uploadSignature(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $this->validate($request, [
            'legal_name' => 'required|string|max:100',
            'signed' => 'required',
        ]);

        $customer->update([
            'legal_name' => $request->legal_name,
            'signature_date' => Carbon::now(),
        ]);

        $image_parts = explode(";base64,", $request->signed);
        $image_base64 = base64_decode($image_parts[1]);
        Storage::put('public\\signatures\\' . $id . '-signature.png', $image_base64);

        $this->customerContractEmail($customer);

        $booking_date = date('m/d/Y h:i A', strtotime($customer->date));
        $url = 'https://admin.areacarservice.com/public/payment/checkout.php?pickup=' . $customer->pickup . "&&destination=" . $customer->destination . ' Booking Date: ' . $booking_date . '&&amount=' . $customer->price;

        return Redirect::to($url);
    }

    public function generate($id)
    {
        $user = User::find($id);
        $filePath = public_path("files/customer-contract.pdf");
        $outputFilePath = storage_path("app/public/customer-contracts/" . $user->id . ".pdf");
        $this->fill_pdf_file($filePath, $outputFilePath, $id);
        return response()->file($outputFilePath);
    }

    public function fill_pdf_file($file, $outputFilePath, $id)
    {
        $user = User::find($id);

        $booking_date = Carbon::parse($user->date)->format('m/d/Y h:i A');
        $signature_date = Carbon::parse($user->signature_date)->format('m/d/Y');
        $price = '$' . $user->price;

        $fpdi = new FPDI;
        $count = $fpdi->setSourceFile($file);

        for ($i = 1; $i <= $count; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            $fpdi->SetFont("Courier", "B", 14);
            $fpdi->SetTextColor(0, 0, 0);

            $fpdi->Text(25, 86, $user->legal_name);
            $fpdi->Text(150, 86, $user->plan);
            $fpdi->Text(45, 95, $price);
            $fpdi->Text(140, 96, $booking_date);
            $fpdi->Text(45, 105, $user->phone);
            $fpdi->Text(40, 114, $user->email);
            $fpdi->Text(25, 124, $user->pickup);
            $fpdi->Text(135, 124, $user->destination);
            $fpdi->Text(32, 267, $signature_date);
            $fpdi->Text(50, 253, $user->legal_name);

            $path = 'http://admin.areacarservice.com/storage/app/public/signatures/' . $user->id . '-signature.png';

            $fpdi->Image($path, 134, 240, 80, 15);
        }

        return $fpdi->Output($outputFilePath, 'F');
    }
}
