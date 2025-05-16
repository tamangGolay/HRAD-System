<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Google\Service\Drive as Google_Service_Drive;
use Google\Service\Drive\DriveFile as Google_Service_Drive_DriveFile;

class DocumentController extends Controller
{
    
    public function view($filename)
    {
        // Initialize Google Client
        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));

        $driveService = new Google_Service_Drive($client);

        // Define the folder ID where the file is stored on Google Drive
        $folderId = env('GOOGLE_DRIVE_FOLDER_ID');

        // Step 1: Get the list of files in the folder
        try {
            $files = $driveService->files->listFiles([
                'q' => "'{$folderId}' in parents and name = '{$filename}'",  // Retrieve file by name and folder ID
                'spaces' => 'drive',
               'fields' => 'files(webViewLink)' 
            ]);

            if (count($files->files) > 0) {
                $file = $files->files[0];  
    
                // Step 2: Get the public URL for viewing the file in the browser
                $webViewLink = $file->getWebViewLink(); // This is the public URL
    
                // Redirect to the public URL to view the file in a new tab
                return redirect()->away($webViewLink);
            } else {
                return response()->json(['error' => 'File not found'], 404);
            }
        } catch (\Exception $e) {
            // Handle errors
            return response()->json(['error' => 'Error retrieving file: ' . $e->getMessage()], 500);
        }
    }
}
