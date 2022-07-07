<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class TenantController extends Controller
{
    //table :
    // vouchers
    // invoices
    // customers

    //relation:
    // customers -> invoice -> invoice
    //              invoice -> voucher

    //roadmap
    // customer paying tenant (identity?, name_tenant?, nominal) => get invoice: transaction ID / code
    // customer rendeem voucher (transaction ID) => customer get all voucher : voucher ID / code, name, value, expired_at, used_at
    // customer use voucher (voucher ID) => #update used_at

    public function registerCustomer(){
        try {
            $customer = new Customer;
            $customer->identity = request("identity");
            $customer->name = request("name");
            $customer->save();

            return response()->json(["data" => "register customer success"], 200);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(["data" => $th]);
        }
    }

    public function payingTenant(){
        $digits = 9;

        $customer = Customer::where("identity", request("identity"))->first();

        if(!$customer && !request("customer_name")) return response()->json(["data" => "not found customer"]);

        try {
            $invoice = new Invoice;

            if($customer) {
                $invoice->customer_id = $customer->id;
                $invoice->customer_name = $customer->name;

            }else {
                $invoice->customer_name = request("customer_name");
            }

            $invoice->code = rand(pow(10, $digits-1), pow(10, $digits)-1);
            $invoice->tenant_name = request("tenant_name");
            $invoice->nominal = request("nominal");
            $invoice->save();

            if($customer) {
                // create voucher
                $countVoucher = request("nominal") >= 1000000 ? request("nominal") / 1000000 : 0;
                $countVoucher = intval($countVoucher);

                for ($gen=0; $gen < $countVoucher; $gen++) {
                    $voucher = new Voucher;
                    $voucher->invoice_id = $invoice->id;
                    $voucher->code = rand(pow(10, $digits-1), pow(10, $digits)-1);
                    $voucher->value = 10000;
                    $voucher->save();
                }
            }

            return response()->json(["data" => "Paying tenant success"], 200);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(["data" => $th]);
        }
    }

    public function rendeemVoucher(){
        try {
            if(request("invoice_id")) {
                $voucher = Voucher::where("invoice_id", request("invoice_id"));

                if($voucher->first()->expired_at) return response()->json(["data" => "voucher it was redeemed"], 200);

                $voucher->update(["expired_at" => Carbon::now()->addMonths(3)]);

                return response()->json(["data" => "rendeem voucher success"], 200);
            }

            return response()->json(["data" => "not found invoice id"]);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(["data" => $th]);
        }
    }

    public function useVoucher(){
        return "use voucher";
    }

}
