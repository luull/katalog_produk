<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MootaController extends Controller
{

    public function test()
    {
        $cek = $this->get_mutation_by_amount(24401, '2022-07-18');
        if ($cek['status'] == 200) {
            echo 'ketemu';
            dd($cek['data']);
        } else {
            echo 'tidak ketemu';
        }
    }


    public function get_mutation_by_amount($amount, $tgl)
    {

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJucWllNHN3OGxsdyIsImp0aSI6IjdjM2E1ZGY3OTM4NGZiZDliYjZhMjhiZmM3NTA4ZTg1ODJhOTY1MDBlODk2MzkxZWE0YjA0OWUxMWNkMjM2Y2JhMjlmZThjZjMxZmVhZTRjIiwiaWF0IjoxNjU4Mjc1NjQxLjU3OTIyNCwibmJmIjoxNjU4Mjc1NjQxLjU3OTIyNywiZXhwIjoxNjg5ODExNjQxLjU3NjI2Niwic3ViIjoiMjI0OTkiLCJzY29wZXMiOlsiYXBpIiwidXNlciIsInVzZXJfcmVhZCIsImJhbmsiLCJiYW5rX3JlYWQiLCJtdXRhdGlvbiIsIm11dGF0aW9uX3JlYWQiXX0.QONnJdHEwSXbHI1RZo2UmLZl5CXvHYnpVmwywpd3ihxOj3JmmBx08_AkTS8g7Z4SXI1_nlZh2-KN7_cg3CNNXJM6-Gcb6VWyIWpmmmpMjUtlqOjJRtTyO-9IWrEw0jC4QPQTGg4P4OEHiJP5KvJ1rDyJWY6CRiRPTCPV4pWN2i3P35vc_CU3Ji6noi3339bWfVbo2CRYMipjb10lrzNGmXmER3iMtesLqDd8DxlzNtSUASIx92psnOExoPcgyicCZxPeqqJShi-Jb9xDTnpJ22jkn7Fb_3Y0e3EcPBABXwYZghPXB15sU6Mu6sBal9EwCKVxQKZMJJluYsG4JoleZedUX4k96UzMGo9CC53B8bUrGNecgtwypxcEZK5yato4UdudiwyLMdh_3BCFIcbEKU2HQhu7CQpF1Nifyhl7EbJu5oQ2VR0yJ9E6DupCUKYySllCNUKruFfOnhEj45assSbSmPNDaZgDW5cFdnPobQIhP2yHdywAE_zID0qBWu8Vt71qYOTmkVqYYkz8fPVRfAQTZ1dpzCTfq5b6t6F8D4ROVxt0c0RQW8YsDeFwwk-TNL4CI8Guq-jXiaA3g7XsNrIEDbCHH9qG6_1nT3I8XSdyJoOK8Ct55k_fdmdtc2P-Ks4WPZAKhbLeBnF-UX9d-rBo5r7z6GPcYEP2fGu0CbI";
        $url = "https://app.moota.co/api/v2/mutation";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        // get stringified data/output. See CURLOPT_RETURNTRANSFER
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        $data = $result->data;
        foreach ($data as $dt) {
            if (substr($dt->date, 0, 10) >= $tgl) {
                if ($dt->amount == $amount) {
                    $result = ([
                        'status' => 200,
                        'data' => $dt,
                    ]);
                    return $result;
                }
            }
        }
        $result = ([
            'status' => '404',
            'message' => 'Data not found'
        ]);
        return $result;
    }

    public function cek_mutasi($tg1)

    {
        $tg2 = date('Y-m-d');
        if ($tg2 == $tg1) {
            $tg2 = date('Y-m-d', strtotime("+1 day"));
        }
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJucWllNHN3OGxsdyIsImp0aSI6IjdjM2E1ZGY3OTM4NGZiZDliYjZhMjhiZmM3NTA4ZTg1ODJhOTY1MDBlODk2MzkxZWE0YjA0OWUxMWNkMjM2Y2JhMjlmZThjZjMxZmVhZTRjIiwiaWF0IjoxNjU4Mjc1NjQxLjU3OTIyNCwibmJmIjoxNjU4Mjc1NjQxLjU3OTIyNywiZXhwIjoxNjg5ODExNjQxLjU3NjI2Niwic3ViIjoiMjI0OTkiLCJzY29wZXMiOlsiYXBpIiwidXNlciIsInVzZXJfcmVhZCIsImJhbmsiLCJiYW5rX3JlYWQiLCJtdXRhdGlvbiIsIm11dGF0aW9uX3JlYWQiXX0.QONnJdHEwSXbHI1RZo2UmLZl5CXvHYnpVmwywpd3ihxOj3JmmBx08_AkTS8g7Z4SXI1_nlZh2-KN7_cg3CNNXJM6-Gcb6VWyIWpmmmpMjUtlqOjJRtTyO-9IWrEw0jC4QPQTGg4P4OEHiJP5KvJ1rDyJWY6CRiRPTCPV4pWN2i3P35vc_CU3Ji6noi3339bWfVbo2CRYMipjb10lrzNGmXmER3iMtesLqDd8DxlzNtSUASIx92psnOExoPcgyicCZxPeqqJShi-Jb9xDTnpJ22jkn7Fb_3Y0e3EcPBABXwYZghPXB15sU6Mu6sBal9EwCKVxQKZMJJluYsG4JoleZedUX4k96UzMGo9CC53B8bUrGNecgtwypxcEZK5yato4UdudiwyLMdh_3BCFIcbEKU2HQhu7CQpF1Nifyhl7EbJu5oQ2VR0yJ9E6DupCUKYySllCNUKruFfOnhEj45assSbSmPNDaZgDW5cFdnPobQIhP2yHdywAE_zID0qBWu8Vt71qYOTmkVqYYkz8fPVRfAQTZ1dpzCTfq5b6t6F8D4ROVxt0c0RQW8YsDeFwwk-TNL4CI8Guq-jXiaA3g7XsNrIEDbCHH9qG6_1nT3I8XSdyJoOK8Ct55k_fdmdtc2P-Ks4WPZAKhbLeBnF-UX9d-rBo5r7z6GPcYEP2fGu0CbI";
        $url = "https://app.moota.co/api/v2/mutation?start_date=$tg1&end_date=$tg2";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        // get stringified data/output. See CURLOPT_RETURNTRANSFER
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);
        $data = $result->data;
        $title = "Transaki Moota Tanggal " . convert_tgl1($tg1) . " s/d " . convert_tgl1($tg2);
        return view('backend.pages.cek_mutasi_moota', compact('data', 'title'));
    }
    public function get_mutation()
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJucWllNHN3OGxsdyIsImp0aSI6IjdjM2E1ZGY3OTM4NGZiZDliYjZhMjhiZmM3NTA4ZTg1ODJhOTY1MDBlODk2MzkxZWE0YjA0OWUxMWNkMjM2Y2JhMjlmZThjZjMxZmVhZTRjIiwiaWF0IjoxNjU4Mjc1NjQxLjU3OTIyNCwibmJmIjoxNjU4Mjc1NjQxLjU3OTIyNywiZXhwIjoxNjg5ODExNjQxLjU3NjI2Niwic3ViIjoiMjI0OTkiLCJzY29wZXMiOlsiYXBpIiwidXNlciIsInVzZXJfcmVhZCIsImJhbmsiLCJiYW5rX3JlYWQiLCJtdXRhdGlvbiIsIm11dGF0aW9uX3JlYWQiXX0.QONnJdHEwSXbHI1RZo2UmLZl5CXvHYnpVmwywpd3ihxOj3JmmBx08_AkTS8g7Z4SXI1_nlZh2-KN7_cg3CNNXJM6-Gcb6VWyIWpmmmpMjUtlqOjJRtTyO-9IWrEw0jC4QPQTGg4P4OEHiJP5KvJ1rDyJWY6CRiRPTCPV4pWN2i3P35vc_CU3Ji6noi3339bWfVbo2CRYMipjb10lrzNGmXmER3iMtesLqDd8DxlzNtSUASIx92psnOExoPcgyicCZxPeqqJShi-Jb9xDTnpJ22jkn7Fb_3Y0e3EcPBABXwYZghPXB15sU6Mu6sBal9EwCKVxQKZMJJluYsG4JoleZedUX4k96UzMGo9CC53B8bUrGNecgtwypxcEZK5yato4UdudiwyLMdh_3BCFIcbEKU2HQhu7CQpF1Nifyhl7EbJu5oQ2VR0yJ9E6DupCUKYySllCNUKruFfOnhEj45assSbSmPNDaZgDW5cFdnPobQIhP2yHdywAE_zID0qBWu8Vt71qYOTmkVqYYkz8fPVRfAQTZ1dpzCTfq5b6t6F8D4ROVxt0c0RQW8YsDeFwwk-TNL4CI8Guq-jXiaA3g7XsNrIEDbCHH9qG6_1nT3I8XSdyJoOK8Ct55k_fdmdtc2P-Ks4WPZAKhbLeBnF-UX9d-rBo5r7z6GPcYEP2fGu0CbI";
        $url = "https://app.moota.co/api/v2/mutation";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        // get stringified data/output. See CURLOPT_RETURNTRANSFER
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        $data = $result->data;
        return $data;
    }
    public function get_mutation_by_date($tg1, $tg2)
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJucWllNHN3OGxsdyIsImp0aSI6IjdjM2E1ZGY3OTM4NGZiZDliYjZhMjhiZmM3NTA4ZTg1ODJhOTY1MDBlODk2MzkxZWE0YjA0OWUxMWNkMjM2Y2JhMjlmZThjZjMxZmVhZTRjIiwiaWF0IjoxNjU4Mjc1NjQxLjU3OTIyNCwibmJmIjoxNjU4Mjc1NjQxLjU3OTIyNywiZXhwIjoxNjg5ODExNjQxLjU3NjI2Niwic3ViIjoiMjI0OTkiLCJzY29wZXMiOlsiYXBpIiwidXNlciIsInVzZXJfcmVhZCIsImJhbmsiLCJiYW5rX3JlYWQiLCJtdXRhdGlvbiIsIm11dGF0aW9uX3JlYWQiXX0.QONnJdHEwSXbHI1RZo2UmLZl5CXvHYnpVmwywpd3ihxOj3JmmBx08_AkTS8g7Z4SXI1_nlZh2-KN7_cg3CNNXJM6-Gcb6VWyIWpmmmpMjUtlqOjJRtTyO-9IWrEw0jC4QPQTGg4P4OEHiJP5KvJ1rDyJWY6CRiRPTCPV4pWN2i3P35vc_CU3Ji6noi3339bWfVbo2CRYMipjb10lrzNGmXmER3iMtesLqDd8DxlzNtSUASIx92psnOExoPcgyicCZxPeqqJShi-Jb9xDTnpJ22jkn7Fb_3Y0e3EcPBABXwYZghPXB15sU6Mu6sBal9EwCKVxQKZMJJluYsG4JoleZedUX4k96UzMGo9CC53B8bUrGNecgtwypxcEZK5yato4UdudiwyLMdh_3BCFIcbEKU2HQhu7CQpF1Nifyhl7EbJu5oQ2VR0yJ9E6DupCUKYySllCNUKruFfOnhEj45assSbSmPNDaZgDW5cFdnPobQIhP2yHdywAE_zID0qBWu8Vt71qYOTmkVqYYkz8fPVRfAQTZ1dpzCTfq5b6t6F8D4ROVxt0c0RQW8YsDeFwwk-TNL4CI8Guq-jXiaA3g7XsNrIEDbCHH9qG6_1nT3I8XSdyJoOK8Ct55k_fdmdtc2P-Ks4WPZAKhbLeBnF-UX9d-rBo5r7z6GPcYEP2fGu0CbI";
        $url = "https://app.moota.co/api/v2/mutation?start_date=$tg1&end_date=$tg2";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        // get stringified data/output. See CURLOPT_RETURNTRANSFER
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        $data = $result->data;
        return $data;
    }

    public function get_bank_id()
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJucWllNHN3OGxsdyIsImp0aSI6IjdjM2E1ZGY3OTM4NGZiZDliYjZhMjhiZmM3NTA4ZTg1ODJhOTY1MDBlODk2MzkxZWE0YjA0OWUxMWNkMjM2Y2JhMjlmZThjZjMxZmVhZTRjIiwiaWF0IjoxNjU4Mjc1NjQxLjU3OTIyNCwibmJmIjoxNjU4Mjc1NjQxLjU3OTIyNywiZXhwIjoxNjg5ODExNjQxLjU3NjI2Niwic3ViIjoiMjI0OTkiLCJzY29wZXMiOlsiYXBpIiwidXNlciIsInVzZXJfcmVhZCIsImJhbmsiLCJiYW5rX3JlYWQiLCJtdXRhdGlvbiIsIm11dGF0aW9uX3JlYWQiXX0.QONnJdHEwSXbHI1RZo2UmLZl5CXvHYnpVmwywpd3ihxOj3JmmBx08_AkTS8g7Z4SXI1_nlZh2-KN7_cg3CNNXJM6-Gcb6VWyIWpmmmpMjUtlqOjJRtTyO-9IWrEw0jC4QPQTGg4P4OEHiJP5KvJ1rDyJWY6CRiRPTCPV4pWN2i3P35vc_CU3Ji6noi3339bWfVbo2CRYMipjb10lrzNGmXmER3iMtesLqDd8DxlzNtSUASIx92psnOExoPcgyicCZxPeqqJShi-Jb9xDTnpJ22jkn7Fb_3Y0e3EcPBABXwYZghPXB15sU6Mu6sBal9EwCKVxQKZMJJluYsG4JoleZedUX4k96UzMGo9CC53B8bUrGNecgtwypxcEZK5yato4UdudiwyLMdh_3BCFIcbEKU2HQhu7CQpF1Nifyhl7EbJu5oQ2VR0yJ9E6DupCUKYySllCNUKruFfOnhEj45assSbSmPNDaZgDW5cFdnPobQIhP2yHdywAE_zID0qBWu8Vt71qYOTmkVqYYkz8fPVRfAQTZ1dpzCTfq5b6t6F8D4ROVxt0c0RQW8YsDeFwwk-TNL4CI8Guq-jXiaA3g7XsNrIEDbCHH9qG6_1nT3I8XSdyJoOK8Ct55k_fdmdtc2P-Ks4WPZAKhbLeBnF-UX9d-rBo5r7z6GPcYEP2fGu0CbI";
        $url = "https://app.moota.co/api/v2/bank";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        // get stringified data/output. See CURLOPT_RETURNTRANSFER
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result);
        $bank_id = ($data->data[0]->bank_id);
        return $bank_id;
    }
    public function getProfile(Request $req)
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJucWllNHN3OGxsdyIsImp0aSI6IjIwM2YwMjZmMzA3NzM4YmFiYTk0NWViMjkyOWEzZTRjNzRkODJiMjVlMmY5OTJhZDk3N2U1MTcxOGU2NmM1OTBmMzhiMTdiZTM3NDViNGI2IiwiaWF0IjoxNjU4MjExODQ1LjIzNzQwMiwibmJmIjoxNjU4MjExODQ1LjIzNzQwNSwiZXhwIjoxNjg5NzQ3ODQ1LjIzNDkwMywic3ViIjoiMjI0OTkiLCJzY29wZXMiOlsiYXBpIiwidXNlciIsInVzZXJfcmVhZCIsImJhbmsiLCJiYW5rX3JlYWQiLCJtdXRhdGlvbiIsIm11dGF0aW9uX3JlYWQiXX0.OyGpaFvYzRE8DHgpa-zdwcah3DIrpQ7nagfjOeflKWaAxyhPVPDGWy3bENh_9PbD2orRdVExL9W1dd_XR2BSp_gl8sPLnGmCt8NRn6E5fXJ9CmfAWwe2AndtlQA4v0lfkN-RvlIgmCzR3cEsNF4nGabk2wj3i1n-d2W2P_l1wljJvFXRB4AjjZqkhn-wTmwm7-u7WgkFxZqt8DQTdzFXXj1ng1XSKCjVjzcNZLHPmvdqZFM7SU6cJgMx4kwIUSvPBU-9kfhcuBVEC2nT4f1spdddFT_ejNIxScDK4RVK25zM1tJsoJshbA72ru2kxlFcOjlzHPolhsF6qvompaKcNC1TczHzh2huBqY98cbi1lEmIBeqPCFmVfci90vDbogaycLtEFsi1TPBuPzuXoOv4lEl3ooJe9RK8MmPebpLYdJ6aaMXAWjaI-_all3FhZFJ36bx_io_OQDbtXtqNPiQSXoBtZzk6egBdp8PjEC0-TwvtD7KcxqazQOX7T7HNmVt2iA2L9cPKLYOPDFgL-oM9lDqPTuSQiKLJWzThz8WCYlh3R40AWmWAoyxGNXhX4vkbGugLCYvD1YN80p9yejK6_TCNr5dQARO0roAP0eCr1DStqcKL2sRhfyBbDBiQvcvPba-8YYp5lkTCPP7G-qMFyFIaF5O3p9SoQ0P0cchrKg";
        $url = "https://app.moota.co/api/v1/profile";
        $request = HTTP::get($url, [
            'headers' => ['Authorization' => 'Bearer ' . $token]

        ]);
        echo $request->body();
        $request->body();
    }
}
