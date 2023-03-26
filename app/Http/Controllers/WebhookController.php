<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class WebhookController extends Controller
{

    public function index(Request $req)
    {
        $secret = "50lu511T";
        $json = $req->getContent();
        // $json = file_get_contents('php://input');
        $payload = $json;
        $http_signature = $_SERVER['HTTP_SIGNATURE'];
        $signature = hash_hmac('sha256', $payload, $secret);
        $fp = fopen('log_moota.txt', 'w');
        fwrite($fp, $signature . "-" . "-" . $http_signature . "=" . $payload);
        fclose($fp);
        //echo ($signature . "-" . $http_signature);
        if ($signature == $http_signature) {
            $data = json_decode($json);
            $amount = $data[0]->amount;
            $trans = Transaction::where('total_bayar', $amount)
                ->where('status', 0)->first();
            if ($trans) {
                $hasil = $trans->update([
                    'status' => 1,
                    'detil_transaksi' => $data
                ]);
                $log_transaction = [
                    'id_transaction' => $trans->id_transaction,
                    'status' => '1',
                    'description' => 'Pesana Sudah dibayar',
                    'detail' => $data,
                    'created_by' => 'System'
                ];
                log_transaction($log_transaction);
                echo $hasil;
            }
        } else {

            echo 'Error Signature ' . $signature . '=' . $http_signature;
        }
    }
}
