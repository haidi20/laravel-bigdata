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

            return response()->json([ "data" => $invoice, "messsage" => "Paying tenant success"], 200);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(["messsage" => $th]);
        }
    }

    public function rendeemVoucher(){
        try {
            if(request("invoice_id")) {
                $invoiceId = request(("invoice_id"));
                $vouchers = Voucher::whereHas("invoice", function($q) use($invoiceId){
                    $q->where("code", $invoiceId);
                });

                if($vouchers->get()[0]->expired_at){
                    return response()->json(["messsage" => "voucher it was redeemed"], 200);
                }else {
                    $vouchers->update(["expired_at" => Carbon::now()]);
                }


                return response()->json(["data" => $vouchers->get(), "messsage" => "rendeem voucher success"], 200);
            }

            return response()->json(["messsage" => "not found invoice id"]);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(["messsage" => $th]);
        }
    }

    public function useVoucher(){
        try {
            if(request("voucher_id")) {
                $voucher = Voucher::where("code", request("voucher_id"));

                if($voucher->first()->used_at) return response()->json(["messsage" => "voucher it was used"]);
                if($voucher->first()->expired_at <= Carbon::now()) return response()->json(["messsage" => "voucher it was expired"]);


                $voucher->update(["used_at" => Carbon::now()]);

                return response()->json(["data" => $voucher->first(), "messsage" => "use voucher success"], 200);
            }

            return response()->json(["messsage" => "not found voucher id"]);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(["messsage" => $th]);
        }
    }

}
