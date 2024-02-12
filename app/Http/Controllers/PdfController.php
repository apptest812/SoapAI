<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function convert(Request $request)
    {
        $text = $request->input('text');
        dd($text);
        $jsonData = json_decode($text);
        
        if ($jsonData) {
            $formattedText = "";
        
            foreach ($jsonData as $item) {
                if (isset($item->message->content)) {
                    $content = $item->message->content;
                    $formattedText .= str_replace("\n", "<br>", $content) . "\n\n"; // Replace newlines with "\\n"
                }
            }
        
            $formattedText = rtrim($formattedText, "\n\n"); // Remove trailing newlines
            $formattedText = str_replace("\t", "&nbsp;", $formattedText); // Replace tabs with "\\t"
        
            // dd($formattedText);
        } else {
            dd("Invalid JSON input");
        }
        
        $pdf = PDF::loadHTML($formattedText);

        return $pdf->download('operative_report.pdf');
        //   $jsonData = json_decode($request->input('jsonInput'), true);

        // // Extract the content from the JSON data
        // $content = $jsonData[0]['message']['content'];

        // // Load the HTML content into the PDF
        // $pdf = PDF::loadHTML($content);

        // // Download the PDF file
        // return $pdf->download('operative_report.pdf');
    }
}
