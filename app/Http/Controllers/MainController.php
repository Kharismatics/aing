<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected $token;
    public function __construct()
    {
        $this->token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI2NjQ3MWUwYjM3ZThlNDI0MGYwNGNjNDIiLCJqdGkiOiIyYWUxZTZiNWY5NDY3ZWI2YmM3M2ZmNDc0MDhlMDlmMDgxODc2NGI3MTQxN2M3MjcwNjQ4Y2Y2YTZkMzUzZjhjZGRhMjYxMDJlNGNiNTk0YiIsImlhdCI6MTcxOTIxMzA0MiwibmJmIjoxNzE5MjEzMDQyLCJleHAiOjMyNTE4Nzc0ODAwLCJzdWIiOiI2Njc5MWIyZWYwMDFhNzEyYjc3YjM2MjciLCJzY29wZXMiOltdfQ.XCfRpL-AiridpuZh-UkIhLdtiDHGx9YE8_zNtz4QMSocu8aHAoydJ2UFA_UuhsPorcX3FunAah9nJJElqMUMuPNmUineAtmano2P92PWxLd1oix8GEoyxUqUeyHS8BZJJWGeKH2wUrID0sMrRxIXfBWZ7HOG8JxTNUJr0jwbioppsAwjH9RMaGdMFWA3eSuA2lhr5gB45hpj_bfbCNX1-9TSjA8kcJw4oYd-njevWn4aInGefn8leDCqxIh-w0nBJkGFBac91DRaxX3gjAvRpI1OI_v44YV-3hYo5SLXFoi9JAgcVVu38J2xBBJf93GlMpf8Er554txstS8aw01erANplgMbxSVaE0otQXxv8XId2waq-r-qf6oWkUfytot-fGltns2mh_RsLMq9J3QY7QELKgPA1WJ6qxTHt8N1RiNaw7yzTXNylfmGdMmoDVzG_cXKNxLYFvNe2IajJ2-oXaiBGvXQtn2Y2LF8lwSQg7IPoWsI6J8hnEzGUMSW0CIokMO278tec9xAHJis8rMWOqhSiJ48YOpa5XAMV3OiKItG9N9bD2DRhFxc_Qdp29uoSY4ogm2nQBrMxkqctnVjY6ySF39swVr-E5H29HGN1cdQiUbNc1dVzkwqxaZCT703lxhYdwuQVEhSti583hkUp6lHW0PA4Z9bQ6uQxJMZQZc';
    }
    public function predict(Request $request)
    {
        $input = $request->only([
            '_id',
            'pilihKonversi',
            'deskripsi',
            'gambar_0_url',
            'ulangiPrediksi',
            'hasilPrediksi'
        ]);
        if (!isset($input['pilihKonversi'])) {
            return response()->json([
                'success' => false,
                'message' => 'Pilih jenis konversi terlebih dulu',
            ], 400);
        }
        if (!isset($input['_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan, ulangi proses',
            ], 400);
        }
        $predictionType = $input['pilihKonversi'][0];
        $image = $input['gambar_0_url'] ?? null;
        $text = $input['deskripsi'] ?? null;
        $rePredict = 0;
        $currentResult = $input['hasilPrediksi'] ?? null;

        if (isset($input['ulangiPrediksi']) && $input['ulangiPrediksi']) {
            if ($input['ulangiPrediksi'][0] == 'YA') {
                $rePredict = 1;
            }
        }
        // ----------------
        if (!$currentResult) {
            // update task and suggest refresh
            $response = Http::withToken($this->token)
                ->patch('https://apiwebdev.mile.app/api/v3/task/' . $input['_id'], [
                    'hasilPrediksi' => 'wkwk'
                ]);
            return response()->json([
                'success' => false,
                'message' => 'Silahkan refresh halaman untuk munculkan hasil prediksi',
            ], 400);
        }
        if ($currentResult && $rePredict) {
            // update task and suggest refresh
            return response()->json([
                'success' => false,
                'message' => 'Silahkan refresh halaman untuk munculkan hasil prediksi',
            ], 400);
        }
        if ($currentResult && !$rePredict) {
            return response()->json([
                'success' => true
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Terjadi Kesalahan, mohon ulangi proses',
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // {
        //     "_id": "67640ea106f1cdc8a908be02",
        //     "idLocal": "kharisma+1@paket.id_2024-12-19T19:15:05+07:00",
        //     "flow": "AingDistortion",
        //     "flowId": "675bec2c48eeedcf5f072242",
        //     "hubId": "66791ba47b28d74dab531db2",
        //     "organization": {
        //         "name": "kharismatics",
        //         "email": "kharisma@paket.id"
        //     },
        //     "organizationId": "66791b2bf001a712b77b3622",
        //     "createdTime": "2024-12-19T12:15:05+00:00",
        //     "startTime": "2024-12-19T12:15:05+00:00",
        //     "expectedDoneTime": null,
        //     "expectedCoordinate": null,
        //     "createdCoordinate": null,
        //     "doneCoordinate": "-6.9561655,107.8441733",
        //     "createdBy": "kharisma+1@paket.id",
        //     "createdFrom": "Mobile",
        //     "assignedBy": "kharisma+1@paket.id",
        //     "assignee": [
        //         "kharisma+1@paket.id"
        //     ],
        //     "useGeoLock": false,
        //     "geoLockTrigger": "onTaskStart",
        //     "geoLock": [],
        //     "label": [
        //         "Gambar"
        //     ],
        //     "refId": null,
        //     "status": "DONE",
        //     "inLocation": null,
        //     "outLocation": null,
        //     "title": "test 1",
        //     "kode": "test 1",
        //     "openTaskTime": "2024-12-19T19:16:46+07:00",
        //     "pilihKonversi": [
        //         "Gambar"
        //     ],
        //     "gambar_0_path": "/storage/emulated/0/Android/data/app.paket.mile_field_dev/files/mile_images/-1734610515095-0-gambar.jpg",
        //     "gambar_0_url": "https://apistorage.mile.app/v3-public-dev/dev/66791b2bf001a712b77b3622/2024/12/19/kharisma1paketid20241219T1915050700-1734610516947-gambar_0_url.jpg",
        //     "gambar_0_id": "photo_1734610516947_0",
        //     "hub": {
        //         "_id": "66791ba47b28d74dab531db2",
        //         "name": "Surabaya",
        //         "lat": -7.28747,
        //         "lng": 112.7226,
        //         "country": null
        //     },
        //     "endTime": "2024-12-20T12:15:05+00:00",
        //     "isDeleted": false,
        //     "orderIndex": 17346105938,
        //     "content": null,
        //     "assignedTo": {
        //         "_id": "667a5f88a2cf6a5dda0d8562",
        //         "name": "Kharisma worker 1",
        //         "email": "kharisma+1@paket.id",
        //         "hubId": [
        //         "66791ba47b28d74dab531db2"
        //         ],
        //         "role": null,
        //         "firstLogin": true
        //     },
        //     "assignedTime": "2024-12-19T12:16:33+00:00",
        //     "updatedTime": "2024-12-19T12:16:33+00:00",
        //     "appVersion": {
        //         "name": "1.22.08",
        //         "version": "309"
        //     },
        //     "deviceInformation": {
        //         "os": "13"
        //     },
        //     "doneBy": "kharisma+1@paket.id",
        //     "doneFrom": "MOBILE",
        //     "doneOrder": 1,
        //     "doneTime": "2024-12-19T12:17:18+00:00",
        //     "duration": 0,
        //     "idleDuration": 0,
        //     "isLastDoneOrder": true,
        //     "page1DoneTime": "2024-12-19T19:17:06+07:00",
        //     "page2DoneTime": "2024-12-19T19:17:18+07:00",
        //     "travelDistance": 681264.1,
        //     "travelDuration": 4.375816666666666,
        //     "ulangiPrediksi": [
        //         "YA"
        //     ],
        //     "updatedBy": "kharisma+1@paket.id",
        // }
    }
}
