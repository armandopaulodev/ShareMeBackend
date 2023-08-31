<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/convert/docx-to-pdf', function (Request $request) {
    // Validate the uploaded DOCX file
    $request->validate([
        'docx' => 'required|mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ]);

    // Get the path to the uploaded DOCX file
    $docxPath = $request->file('docx')->getPathName();

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

    // Save the generated PDF temporarily
    $tempPdfPath = storage_path('app/temp/converted.pdf');

    // Ensure the directory exists and is writable
    if (!file_exists(dirname($tempPdfPath))) {
        if (!mkdir(dirname($tempPdfPath), 0777, true)) {
            // Handle directory creation failure
            abort(500, 'Failed to create temporary directory.');
        }
    }

    // Write PDF contents to the file
    file_put_contents($tempPdfPath, $pdfContents);

    // Stream the temporary PDF as a response
    return response()->stream(
        function () use ($tempPdfPath) {
            // Check if the file exists before reading
            if (file_exists($tempPdfPath)) {
                readfile($tempPdfPath);
                unlink($tempPdfPath); // Clean up by deleting the temporary PDF file
            } else {
                // Handle the case if the file doesn't exist
                abort(404, 'Temporary PDF file not found.');
            }
        },
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="converted.pdf"',
        ]
    );
})->name('convert.docxToPdf');
