<?php

namespace App\Http\Controllers\api\classroom;

use App\Http\Controllers\Controller;
use App\Models\Attachment\Attachment;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function convertion(Request $request)
    {

        try {
            // Check if a file was uploaded
            if ($request->hasFile('file')) {
                // Get the path to the uploaded DOCX file
                $docxPath = $request->file('file')->getPathName();

                // Convert DOCX to HTML using phpoffice/phpword
                $phpWord = IOFactory::load($docxPath);
                $htmlWriter = new \PhpOffice\PhpWord\Writer\HTML($phpWord);
                $html = $htmlWriter->getContent();

                // Generate PDF from HTML using dompdf
                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                $pdfContents = $dompdf->output();

                // Define the storage path for the PDF file (e.g., storage/app/pdf)
                $storagePath = 'pdf';

                // Generate a unique filename for the PDF (you can use a UUID or a timestamp)
                $pdfFilename = uniqid('converted_', true) . '.pdf';

                // Save the PDF to Laravel's storage
                Storage::disk('public')->put($storagePath . '/' . $pdfFilename, $pdfContents);

                // Return a response with the file path or URL
                $pdfFilePath = Storage::url($storagePath . '/' . $pdfFilename);

                return response()->json(['message' => $pdfFilePath], 200);
            } else {
                return response()->json(['message' => 'No file uploaded'], 400);
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors that may occur during file processing
            return response()->json(['message' => 'File upload failed'], 500);
        }
    }
}
