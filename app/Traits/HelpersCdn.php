<?php
namespace App\Traits;


trait HelpersCdn
{
    public function handleUploadFilesCdn($file, $custom_filename, $params = [])
    {
        $response = new \GuzzleHttp\Client(['verify' => false]);
        $response = $response->request('POST', 'https://cdn.oganilirkab.go.id/api/v1/upload-insert', [
            'headers' => [
                'X-API-Key' => 'cdn-oganilir-2024'
            ],
            'multipart' => [
                [
                    'name' => 'files[]',
                    'contents' => file_get_contents($file->getRealPath()),
                    'filename' => $custom_filename
                ],
                [
                    'name' => 'path',
                    'contents' => $params['path']
                ],
                [
                    'name' => 'sub_path',
                    'contents' => $params['sub_path']
                ]
            ]
        ]);

        return $response;
    }


    public function handleUploadFilesCdn_old($file, $custom_filename, $params = [])
    {
        $response = new \GuzzleHttp\Client(['verify' => false]);
        $response = $response->request('POST', 'https://cdn.oganilirkab.go.id/api/v1/upload-insert', [
            'headers' => [
                'X-API-Key' => 'cdn-oganilir-2024'
            ],
            'multipart' => [
                [
                    'name' => 'files[]',
                    'contents' => file_get_contents($file),
                    'filename' => $custom_filename
                ],
                [
                    'name' => 'path',
                    'contents' => $params['path']
                ],
                [
                    'name' => 'sub_path',
                    'contents' => $params['sub_path']
                ]
            ]
        ]);
        return $response;
    }

    public function handleUpdateFilesCdn($file, $custom_filename, $params = [])
    {
        $response = new \GuzzleHttp\Client(['verify' => false]);
        $response = $response->request('POST', 'https://cdn.oganilirkab.go.id/api/v1/upload-update', [
            'headers' => [
                'X-API-Key' => 'cdn-oganilir-2024'
            ],
            'multipart' => [
                [
                    'name' => 'files[]',
                    'contents' => file_get_contents($file),
                    'filename' => $custom_filename
                ],
                [
                    'name' => 'files_old[]',
                    'contents' => $params['files_old']
                ],
                [
                    'name' => 'path',
                    'contents' => $params['path']
                ],
                [
                    'name' => 'sub_path',
                    'contents' => $params['sub_path']
                ],
            ]
        ]);
        return $response;
    }

    // public function watermark($img)
    // {
    //     // Logo Watermark
    //     $resizeLogo = Image::make(public_path('storage/images/1.png'));
    //     $resizeLogo->resize(70, 70, function ($constraint) {
    //         $constraint->aspectRatio();
    //         $constraint->upsize();
    //     });
    //     $img->insert($resizeLogo, 'bottom-right', 10, 10);
    //     $img->save();

    //     return $img;
    //     // Akhir Logo Watermark
    // }

    public function handleDeleteFileCdn($file_name, $params = [])
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $response = $client->request('POST', 'https://cdn.oganilirkab.go.id/api/v1/delete-image', [
            'headers' => [
                'X-API-Key' => 'cdn-oganilir-2024'
            ],
            'form_params' => [
                'file' => $params['file'],
                'path' => $params['path'],
                'sub_path' => $params['sub_path'],
            ]
        ]);

        return $response;
    }

    // insert file type storage cdn
    public function typeInsertStorage($type)
    {
        if ($type == 'lkh') {
            return 'cdn';
        } elseif ($type == 'absen') {
            return 'cdn';
        } elseif ($type == 'helpdesk') {
            return 'cdn';
        } else {
            return 'local';
        }
    }
}
