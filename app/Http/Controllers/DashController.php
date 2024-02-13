<?php

namespace App\Http\Controllers;
require '../vendor/autoload.php';

use GuzzleHttp\Psr7\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use PDF;


class DashController extends Controller
{
    public function dashboard_show (Request $req)
    {
        return view('dashboard');
    }
    
    public function store_audio_file (Request $req)
    {
        
        $file = $req->file('audio_file');
        $filename = time() . '_' .$file->getClientOriginalName(); 
        // $fileUrl = Storage::disk('public')->exists('/Audio'.$filename);
        Storage::disk('public')->put('/'.$filename, file_get_contents($file));
        $path = str_replace('/', '\\', Storage::disk('public')->path('/' . $filename));
        
        $client = new Client();

        $headers = [
            'Authorization' => 'Bearer ' . getenv('OPENAI_API_KEY') ?? '',
            // 'Cookie' => '__cf_bm=hMtT10inLh1to1BHEoJAcm0wody2YzdK1FX7tz9JoOk-1707386194-1-AWsLbMEzmHV7Oqd1VcP3hIXXuqTSGLBn+nsZi0/axZqCAlC2ErT8Hw0o7j3ZD1RstzLq/djgY5TZ29YT/H8BQm0=; _cfuvid=lx8x4XHVex.CsTQQIxi88nwGPEM32Hxz4Fhq09Nrxag-1707382541088-0-604800000'
        ];
        $options = [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => Utils::tryFopen($path, 'r'),
                    'filename' => $path,
                    'headers'  => [
                        'Content-Type' => 'multipart/form-data'
                    ]
                ],
                [
                    'name' => 'model',
                    'contents' => 'whisper-1'
                ],
                [
                    'name' => 'response_format',
                    'contents' => 'json'
                ]
            ]
        ];

        try {
            $response = $client->post('https://api.openai.com/v1/audio/transcriptions', [
                'headers' => $headers,
                'multipart' => $options['multipart'],
            ]);

            $responseData = json_decode($response->getBody(), true);
            dd($responseData);
            $body = $responseData['text'];
            
            return view('show_chat_completions_data',compact('body'));
        
        } catch (RequestException $e) {
            
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorMessage = $response->getBody()->getContents();
        
            echo  "Coode :" . $statusCode . "\n" . "Message :". $errorMessage;
        } catch (\Exception $e) {
            echo   "Error: " .  $e->getMessage() . "\n";
        }
        // if ($fileUrl == true) {

        //     return response()->json(['file' => 'Audio File Already Exists.']);

        // } else {
        // }
    }

    public function show_audio_file(Request $req)
    {
        $body = "102 most eyeful volunteers Several millions still has people to attend. It is important for them to know that this issue Irma is a complex one. This issue does not need to be dealt with at one time. It is a huge respect for them, as a united society, will take more responsibility to come up with the solutions. As Brandi mentioned, we have to spare no effort and be mean to people who are in this hospital. Leaders of their sectors can make conscious decisions and effective measures to reduce and prevent such diseases from ever occurring and better care for them. Come in. Hi Ms. Jones. I'm Jane Cronan, I'm a medical student with the university here. Nice to meet you. I've been sent in by Dr. Smith as part of our training as a medical student to do an interview with you, and then I'll take that information back to Dr. Smith and then she will come back in and see you then after that. Okay. Alright. How may I address you? Mrs. Jones is fine. Alright. Thank you. Is that okay with you today to talk? Yes, that would be fine. Okay. Thank you. I'm going to start out today by just talking a little bit with you about your chief complaint. What brings you here today? Sure. My left elbow has actually been bugging me a lot. Every once in a while I've been getting a little bit of pain extending my arm and going back to bending it. Really that's the primary reason I've come in. I've attempted to take a little bit of Tylenol to relieve the pain but it's not really seeming to help much. Okay. Before we talk a little bit more about that, is there anything else that you want to talk with either me or Dr. Smith today? Not that I can think of, no. Okay. Tell me more about this pain. It's just kind of a throbbing pain. It'll act up kind of randomly throughout the day. It doesn't, it's not specific to, you know, the morning or evening or even in the middle of the day or night. It just kind of randomly acts up. I would say excessively like when I'm doing work, like after the dishes. It'll start to act up. If I, you know, lift one of my children up, it'll start to act up. So any sort of exertion is kind of where I've noticed a lot of the pain coming from. And tell me, when did it start for you? I would say in the area about maybe a week and a half to two weeks ago. Okay. Okay. Okay. Okay. Okay. Okay. Okay. Okay. Okay. Okay. Okay. Okay. Okay. And you described the pain as throbbing. Is there anything else about the pain in terms of the quality of the pain that you want to describe for me? No. Just really throbbing. Okay. Started about a week to two weeks ago? Okay. And do you recall what you were doing at the time that it started? I've been helping my husband clean out the garage lately and we were lifting some boxes. And that's kind of, I didn't notice it at the moment but later in the evening it started to act up. Okay. And I would like to hear a little bit about the severity of it. On a pain scale of one to ten, ten being the worst pain you've ever had, one or zero being no pain. At this, how bad is this pain? I would measure it probably at a six or seven. Six or seven? It's become more of a nuisance than an actual physical pain. Okay. And is it a six or seven all the time? Whenever it starts to act up, yes. Okay. And how often a day does that happen? I would say about once a week or twice a week. Okay. And how often a day does that happen? I would say maybe two or three times per day. Do you notice any pattern to that at all? No. Okay. All righty. And can you point exactly to where it is for me, the location of it exactly? It's kind of the area that just kind of wraps around the actual elbow that is really bothering me. And does that pain go up your arm or down your arm or anywhere else on your arm? No. It stays straight in that area. Okay. And how often does that happen? I would say maybe two or three times per day. Do you notice any pattern to that at all? No. Okay. All righty. Is there anything else that goes on at the same time? Any other symptoms that happen? Anything else other than when the pain is happening there? Anything else going on for you? Not that I've noticed, no. Okay. All righty. Is there anything that makes it feel better? Nothing that completely gets rid of it. Tylenol will relieve it for a temporary period of time. But I would say I would say I would say I would say I would say I would say I would say I would say but it doesn't but it doesn't get rid of it. okay How much Tylenol do you take? Whatever it says on the bottle. Usually one to two tablets. And is that regular strength or extra strength? Regular strength. Okay. And you just take it across the counter the normal direction in the bottle? Correct. okay. Does anything make it worse? Like you mentioned, any sort of exertion, picking up a child, doing the dishes, pretty much every... pretty much daily kind of living activities. So using it? Yes. Okay. Alright. Have you seen anybody else for this complaint? No. What else have you tried other than the Tylenol and anything else other than the Tylenol? I've attempted to use a heating pad on it and I've also attempted ice. Neither were successful. Okay. It sounds you've talked a little bit about how it's impacted you to be able to work in the garage or do the dishes with your child. Is there other impact on your life? Like I mentioned, it's more of a nuisance. There'll be times in the middle of the night that it'll start to act up. If I get up to go to the bathroom, I'll notice pain in my elbow. Does it wake you at night? It doesn't, but if I wake up in the middle of the night, it will trouble me and fall back asleep. Okay. What do you think it is? I'm not quite sure. My best guess is maybe some sort of pulled muscle or something. Okay. But honestly, I don't know. All right. What I'd like to do now is just kind of go through all the things that you've told me and summarize for you just as information that I want to take back, but I want to make sure that I have it all correct. So if I've forgotten something or I've gotten something incorrect, please help me. Okay. You came to the clinic today for a complaint of left elbow pain. And it's pain that you mostly noticed when you were bending it or using it in some capacity. It's a throbbing pain that happens randomly but it does happen two to three times during the day. What you notice about it is if you exert or you extend or flex your elbow at all, that's when it seems to be at its worst. It's gone on for about a week maybe to two weeks when you think back on it. And it started out when you were helping your husband clean the garage and you were lifting lots of boxes. It's about a six to seven on a pain scale and you describe it over and over as being a nuisance which tells me that it's getting kind of in the way of doing some things that you want to. You report that it happens probably two to three times a day and that the pain wraps around the joint completely. You've taken some Tylenol for it across the counter. You've taken that several times a day without much relief that it hasn't helped much. You've also tried a heating pad. You've tried some ice. That hasn't really helped either too much. It sounds like, you know, again, you kept referring to it as a nuisance that it's just kind of getting in the way of your daily activities. It doesn't necessarily keep you up at night but you do notice that at night when you wake up that it's still going on and it's not helping you so sleep doesn't seem to help much. What you mostly think this could be is a pulled muscle of some type. Is there anything I've forgotten or that you wanted to tell me about this? Not that I can think of, no. Thank you for telling me about your chief concern. I'm going to take it back to Dr. Smith. Thank you very much.";
        return view ('show_chat_completions_data',compact('body'));
    }

    public function chat_completions (Request $req)
    {
        $client = new Client();

        $template = "OPERATIVE REPORT

        Patient Name: [Insert Patient Name]
        Date of Surgery: [Insert Date of Surgery]
        Surgeon: [Insert Surgeon's Name]
        Pre-Operative Diagnosis: [Insert Pre-Operative Diagnosis]
        Post-Operative Diagnosis: [Insert Post-Operative Diagnosis]
        Anesthesia: [Insert Type of Anesthesia]
        
        Procedure:
        
        1. [Insert Procedure Details]
        OPERATIVE TECHNIQUE:
        
        The patient presented for [Insert Procedure Details].
        
        Vital Signs:
        
        1. B/P: [Insert Blood Pressure]
        2. Pulse: [Insert Pulse Rate]
        
        Procedure Details:
        
        [Insert details of the procedure, including any pre-operative preparations, surgical techniques used, materials used, and any post-operative procedures performed. Be sure to include vital signs, anesthesia details, and any specific instructions given to the patient.]
        Post-Operative Instructions:
        
        [Insert post-operative instructions given to the patient, including medication regimen, activity restrictions, and any other relevant information.]
        Follow-Up:
        
        The patient is scheduled for a follow-up appointment on [Insert Follow-Up Date] for suture removal, observation, and further care.
        
        Rx:
        
        1. [Insert Medication 1]: [Insert Dosage], [Insert Quantity], [Insert Frequency]
        2. [Insert Medication 2]: [Insert Dosage], [Insert Quantity], [Insert Frequency]
        3. [Insert Medication 3]: [Insert Dosage], [Insert Quantity], [Insert Frequency]
        
        Date: [Insert Date]
        __________________";

        $rules = "1. If Date of diagnosis is not provided take today's date
        2. Content should be in text format only no YAML, math or any other format
        3. Converted content should start with START_FROM_HERE and end with END_WITH_HERE";

        $prompt = 'Below is Template and content, template is between START_OF_TEMPLATE and END_OF_TEMPLATE, and content is between START_OF_CONTENT and END_OF_CONTENT. What I want is to parse content and convert like provided template.
                
        Please follow rules below when converting and giving output:
        '.$rules.'
    
        START_OF_TEMPLATE:
        '.$template.'
        
        END_OF_TEMPLATE
    
        START OF CONTENT:
        '.$req->text.'
        END_OF_CONTENT';

        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . getenv('OPENAI_API_KEY') ?? ''
                ],
                // 'body' => "{\n    \"model\": \"gpt-3.5-turbo\",\n    \"messages\": [\n      {\n        \"role\": \"system\",\n        \"content\": \"You are a helpful assistant.\"\n      },\n      {\n        \"role\": \"user\",\n        \"content\": \"Hello!\"\n      }\n    ]\n  }",
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a helpful assistant which converts conversation data to document format.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ]
                    ]
                ]
            ]);
            $responseData = json_decode($response->getBody(), true);

            if ($responseData) {
                $formattedText = "";
                
                foreach ($responseData['choices'] as $choice) {
                    if (isset($choice['message']['content'])) {
                        $content = $choice['message']['content'];
                        $formattedText .= str_replace("\n", "<br>", $content) . "\n\n"; 
                    }
                }
            
                $formattedText = rtrim($formattedText, "\n\n");
                $formattedText = str_replace("\t", "&nbsp;", $formattedText);

                $promptData = $formattedText;
                $pattern = '/START_FROM_HERE(.*?)END_WITH_HERE/s';

                if (preg_match($pattern, $promptData, $matches)) {
                    $extractedContent = trim($matches[1]);
                } else {
                    echo "No content found between START_FROM_HERE and END_WITH_HERE.";
                }

                $pdf = PDF::loadHTML($extractedContent);
    
                return $pdf->download('operative_reports.pdf');
        
            } else {
                return $responseData;;
            }
        }catch (RequestException $e) {
               
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorMessage = $response->getBody()->getContents();
        
            echo  "Coode :" . $statusCode . "\n" . $errorMessage;
        } catch (\Exception $e) {
            echo   "Error: " .  $e->getMessage() . "\n";
        }
    }

    public function convert($responseData)
    {
        $jsonData = $responseData;
        dd($jsonData);
        if ($jsonData) {
            $formattedText = "";
           
            foreach ($jsonData as $item) {
                if (isset($item->message->content)) {
                    $content = $item->message->content;
                    $formattedText .= str_replace("\n", "<br>", $content) . "\n\n"; 
                }
            }
        
            $formattedText = rtrim($formattedText, "\n\n");
            $formattedText = str_replace("\t", "&nbsp;", $formattedText); 
        
        } else {
            dd("Invalid JSON input");
        }
        
        $pdf = PDF::loadHTML($formattedText);
      
        return $pdf->download('operative_report.pdf');
    }

}
