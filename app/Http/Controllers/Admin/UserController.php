<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\user\User;
use App\Model\admin\role;
use App\Mail\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\StripeClient;

class UserController extends Controller
{
    private function stripePaymentLink($customer)
    {
        $stripe = new StripeClient('sk_test_51GspqPCGY6FvdoyjgWgpNxB2al2R6ZPxbumRTTIOK2OjRHIpuRwHWmZyymOs2itJMUZHz0TQLvXk37clOSyvXyNv00KFGood2n');


        $product = $stripe->products->create([
            'name' => 'PAY AREA CAR SERVICE',
            'description' => "
                Name:" . $customer->name . "
                Email:" . $customer->email . "
                Phone:" . $customer->phone . "
                Pick:" . $customer->pickup . "
                Destination:" . $customer->destination . "
                Date:" . $customer->date . "
                Passangers:" . $customer->nop . "
                Luggages:" . $customer->nol . "
                Vehicle:" . $customer->vehicle . "
            "
        ]);

        $price = $stripe->prices->create([
            'currency' => 'usd',
            'unit_amount' => $customer->price * 100,
            'product' => $product->id,
        ]);

        $payment_link = $stripe->paymentLinks->create([
            'line_items' => [
                [
                    'price' => $price->id,
                    'quantity' => 1,
                ],
            ],
            'after_completion' => [
                'type' => 'redirect',
                'redirect' => ['url' => 'https://areacarservice.com'],
            ],
        ]);

        return $payment_link->url;
    }


    private function invoiceConfirmationMail($customer)
    {
        try {

            $booking_date = date('m/d/Y h:i A', strtotime($customer->date));
            if ($customer->signature_date) {
                // $payment_url = 'https://admin.areacarservice.com/public/payment/checkout.php?pickup=' . $customer->pickup . "&&destination=" . $customer->destination . ' Booking Date: ' . $booking_date . '&&amount=' . $customer->price;
                $payment_url = $this->stripePaymentLink($customer);
            } else {
                $payment_url = route('admin.signature', $customer->id);
            }

            $mail_data = [
                "personalizations" => [
                    [
                        "to" => [
                            [
                                "email" => $customer->email
                            ]
                        ],
                        "dynamic_template_data" => [
                            "image_url" => 'https://admin.areacarservice.com/public/images/logo.png',
                            "confirmation_no" => $customer->id,
                            "booking_date" => $booking_date,
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
                            "payment_url" => $payment_url,
                        ]
                    ]
                ],
                "from" => [
                    "email" => "info@areacarservice.com",
                    "name" => "Area Car Service"
                ],
                "subject" => "Booking Confirmation",
                "content" => [
                    ["type" => "text/html", "value" => "Booking Confirmation"]
                ],
                "template_id" =>  "d-d27727401663431eb1c11ee68b3eb34f"
            ];

            $url = 'https://api.sendgrid.com/v3/mail/send';
            $_data = json_encode($mail_data);
            $headers = array(
                'Content-Type: application/json',
                'Authorization:Bearer ' . config('app.SEND_GRID_API_KEY'),
            );

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $_data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($curl);

        } catch (\Throwable $th) {
            return $th;
            // dd($th);
        }
    }

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.user.show', compact('users'));
    }

    public function create()
    {
        $roles = role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|regex:/^\+1\d{10}$/',
            'pickup' => 'required',
            'destination' => 'required',
            'nop' => 'required',
            'nol' => 'required',
            'date' => 'required',
            'vehicle' => 'required',
            'plan' => 'required',
            'flight_no' => 'nullable',
            'discount' => 'nullable',
            'no_of_vehicles' => 'required|numeric',
            'tip' => 'nullable|numeric',
            'toll' => 'nullable|numeric',
            'process_fee' => 'nullable|numeric',
            'pay_type' => 'nullable|string',
            'addt_msg' => 'nullable|string',
        ]);

        mt_srand((float)microtime() * 10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*", $charid);
        $c = implode("", $c);

        $hash = substr($c, 0, 15);
        $request->request->add(['password' => $hash]);
        $extra_price = isset($request->extra_price) ? array_sum($request->extra_price) : 0;
        $calculated_price = ($request->price + $request->toll + $request->tip + $request->process_fee + $extra_price) - $request->discount;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $hash,
            'pickup' => $request->pickup,
            'destination' => $request->destination,
            'nop' => $request->nop,
            'nol' => $request->nol,
            'flight_no' => $request->flight_no,
            'actual_price' => $request->price,
            'discount' => $request->discount,
            'price' => $calculated_price,
            'date' => $request->date,
            'vehicle' => $request->vehicle,
            'no_of_vehicles' => $request->no_of_vehicles,
            'plan' => $request->plan,
            'tip' => $request->tip,
            'toll' => $request->toll,
            'process_fee' => $request->process_fee,
            'pay_type' => $request->pay_type,
            'addt_msg' => $request->addt_msg,
        ];

        $arr = "";

        if (isset($request->price_reason)) {
            foreach ($request->price_reason as $key => $reason) {
                $arr .= $reason . ":" . $request->extra_price[$key] . "|";
            }
            $data['price_reason'] = rtrim($arr, "|");
        }

        $customer = User::create($data);

        $this->invoiceConfirmationMail($customer);

        return redirect(route('user.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric',
            'pickup' => 'required',
            'destination' => 'required',
            'nop' => 'required',
            'nol' => 'required',
            'date' => 'required',
            'vehicle' => 'required',
            'plan' => 'required',
            'flight_no' => 'nullable',
            'discount' => 'nullable',
            'no_of_vehicles' => 'required|numeric',
            'tip' => 'nullable|numeric',
            'toll' => 'nullable|numeric',
            'process_fee' => 'nullable|numeric',
            'pay_type' => 'nullable|string',
            'addt_msg' => 'nullable|string',
        ]);

        $extra_price = isset($request->extra_price) ? array_sum($request->extra_price) : 0;
        $calculated_price = ($request->price + $request->toll + $request->tip + $request->process_fee + $extra_price) - $request->discount;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'pickup' => $request->pickup,
            'destination' => $request->destination,
            'nop' => $request->nop,
            'nol' => $request->nol,
            'flight_no' => $request->flight_no,
            'actual_price' => $request->price,
            'discount' => $request->discount,
            'price' => $calculated_price,
            'date' => $request->date,
            'vehicle' => $request->vehicle,
            'no_of_vehicles' => $request->no_of_vehicles,
            'plan' => $request->plan,
            'tip' => $request->tip,
            'toll' => $request->toll,
            'process_fee' => $request->process_fee,
            'pay_type' => $request->pay_type,
            'addt_msg' => $request->addt_msg,
        ];


        $arr = "";
        if (isset($request->price_reason)) {
            foreach ($request->price_reason as $key => $reason) {
                $arr .= $reason . ":" . $request->extra_price[$key] . "|";
            }
            $data['price_reason'] = rtrim($arr, "|");
        }
        $user = User::where('id', $id)->update($data);
        return redirect(route('user.index'))->with('message', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Customer is deleted successfully');
    }

    public function clear($id)
    {
        User::where('id', $id)->update(['clear' => 1]);
        return redirect()->back()->with('message', 'Customer ride completed successfully');
    }

    public function reminder($id)
    {
        $user = User::where('id', $id)->first();
        Mail::to($user->email)->send(new Reminder($user->toArray()));
        $user->update(['reminder' => 1]);
        return redirect()->back()->with('message', 'Customer is reminded successfully');
    }

    public function resendInvoiceConfirmationMail($id)
    {
        $customer = User::find($id);
        $this->invoiceConfirmationMail($customer);
        return redirect()->back()->with('message', 'Invoice confirmation mail have been resent successfully.');
    }

    public function sendSms($id)
    {
        try {
            $customer = User::find($id);

            $booking_date = date('m/d/Y h:i A', strtotime($customer->date));
            if ($customer->signature_date) {
                $payment_url = 'https://highstarlimo.com/payment/checkout.php?pickup=' . $customer->pickup . "&&destination=" . $customer->destination . ' Booking Date: ' . $booking_date . '&&amount=' . $customer->price;
            } else {
                $payment_url = route('admin.signature', $customer->id);
            }

            $username = 'ACf0f39cd61b42ca08eab150ad0ab82c58';
            $password = '4cc4f5efa0da669e0d154c363733b03e';

            $url = 'https://api.twilio.com/2010-04-01/Accounts/ACf0f39cd61b42ca08eab150ad0ab82c58/Messages.json';

            $data = array(
                'To' => $customer->phone,
                'From' => '+18776604564',
                'Body' => $payment_url
            );

            $body = http_build_query($data);

            $headers = array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . base64_encode($username . ':' . $password)
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            curl_close($ch);
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->back()->with('message', 'The sms have been sent successfully.');
    }
}
