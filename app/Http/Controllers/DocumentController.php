<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Drive;
use GuzzleHttp\Psr7\Stream;
use Google\Service\Drive as Google_Service_Drive;

class DocumentController extends Controller
{
public function view($filename)
{
    try {
        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

        $driveService = new Google_Service_Drive($client);

        // Define the folder ID where the file is stored on Google Drive
        $folderId = env('GOOGLE_DRIVE_FOLDER_ID');

        // Fetch file by name and folder ID
        $files = $driveService->files->listFiles([
            'q' => "'{$folderId}' in parents and name = '{$filename}'",
            'spaces' => 'drive',
            'fields' => 'files(id, name, mimeType)'
        ]);

        if (count($files->files) > 0) {
            $file = $files->files[0];
            $fileId = $file->getId();
            $mimeType = $file->getMimeType();

            
            $http = $client->authorize();
            $response = $http->request('GET', "https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media");

            // Get raw resource stream
            $resource = $response->getBody()->detach();  

            if (!is_resource($resource)) {
                return response()->json(['error' => 'Failed to get file resource'], 500);
            }

            $stream = new Stream($resource);

            // Stream the file to the browser
            return response()->stream(
                function () use ($stream) {
                    while (!$stream->eof()) {
                        echo $stream->read(1024);
                    }
                },
                200,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline; filename="' . $filename . '"'
                ]
            );

        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
 }
}