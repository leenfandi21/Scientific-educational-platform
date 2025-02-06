<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Pdf;
use App\Models\Voices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Models\Role;

class CourseController extends Controller
{
    public function index( Request $request)
    {
        return view('vendor.voyager.slug-name.course');
    }
    public function uploadFiles(Request $request)
    {
        $user = Auth::user();

        if( $user->role_id == 1)
        {

                // Validate the form data
                $request->validate([
                    'course' => 'required',
                    'pdf_file' => 'mimes:pdf',
                    //'voice_file' => 'required|mimetypes:audio/mpeg,audio/wav',
                ]);

                // Get the selected course
                $course = $request->input('course');
                $course_id = Course::where('course_name',$course)->first()->id;
                // Get the PDF file
                if($request->file('pdf_file') != null)
                {
                    $pdfFile = $request->file('pdf_file');
                    $pdfFileName = $pdfFile->getClientOriginalName();
                    $pdfPath = $pdfFile->store('pdfs');
                    $createdPdf = [
                        'file_name' => $pdfFileName,
                        'path' => $pdfPath,
                        'course_id' => $course_id
                    ];
                    $pdf = Pdf::create($createdPdf);
                }


                // Get the voice file
                if($request->file('voice_file') != null)
                {
                    $voiceFile = $request->file('voice_file');
                    $voiceFileName = $voiceFile->getClientOriginalName();
                    $voicePath = $voiceFile->store('voices');
                    $createdVoice = [
                     'file_name' => $voiceFileName,
                     'path' => $voicePath,
                     'course_id' => $course_id
                    ];
                    $voice = Voices::create($createdVoice);
                }
                // Redirect the user or return a response
                return redirect()->back()->with('success', 'Files uploaded successfully.');
            }
            return view('unAuth');
    }

    public function getFiles(Request $request)
    {
        $files = [];
        $courseName = $request->input('course_id');
        if($courseName != 'all')
        {
            $coursId = Course::where('course_name',$courseName)->first()->id;
        }


        // Query the database to retrieve files based on the selected course ID
        if ($courseName === 'all') {
            $filespdf = Pdf::all();
            $fileVoice = Voices::all();
            foreach( $filespdf as $file)
            {
                $coursname = Course::where('id',$file->course_id)->first()->course_name;
                $file['course']= $coursname;
                $file['type'] = 'PDF';
                $files[] = $file;
            }
            foreach( $fileVoice as $file)
            {
                $coursname = Course::where('id',$file->course_id)->first()->course_name;
                $file['course']= $coursname;
                $file['type'] = 'voice';
                $files[] = $file;
            }

        } else {
            $filespdf = Pdf::where('course_id', $coursId)->get();
            $fileVoice = Voices::where('course_id', $coursId)->get();
            if(sizeof($filespdf)==0 && sizeof($fileVoice)==0)
            {
                $files = null;

            }
            else{
               foreach($filespdf as $file)
               {
                $file['course']= $courseName;
                $file['type'] = 'PDF';
                $files[] = $file;
               }
               foreach($fileVoice as $file)
               {
                $file['course']= $courseName;
                $file['type'] = 'voice';
                $files[] = $file;
               }
            }

        }

        return response()->json(['files' => $files]);
    }


    public function deleteFile(Request $request)
    {
        $user = Auth::user();

        if( $user->role_id == 1)
        {
        $fileId = $request->input('file_id');

        // Find the file by ID and delete it
        $file = Pdf::find($fileId);
        if ($file) {
            $file->delete();
        } else {
            return response()->json(['message' => 'File NOt Found ']);
        }

        return response()->json(['message' => 'File deleted successfully']);
        }
        return view('unAuth');
    }

   public function viewFilesPdf()
        {
           // $user =auth()->user();
            $user=Auth::user();

            $role_id = $user->role_id;
            $role = Role::find($role_id);
            $permissions = $role->permissions;
           // dd( sizeof($permissions));
            if(sizeof($permissions) != 0)
            {
                $roleName = Role::find($role_id)->with('permissions')->name;
                $cours_id = Course::where('name',$roleName)->first()->id;
                $pdfs = Pdf::where('course_id',$cours_id)->get();
                $pdfs = Pdf::all();
                $Responsepdfs = [];
                foreach($pdfs as $key => $pdf)
                {
                    $name = $pdf['file_name'];
                  //$fullPath = storage_path('app\\' . $pdf['path']);
                //  dd($pdf['path']);
                    $Responsepdfs[$key] = [
                        'file_name' =>$name ,
                        'path' =>'app\\'.$pdf['path'],
                    ];

                }
            //    $voice = Voices::where('course_id',$cours_id)->get();
                return response()->json([
                    'Pdfs'=> $Responsepdfs,
                ]);
            }



        }
   public function viewFilesVoice()
        {
            // $user = Auth::user();
            // $role_id = $user->role;
            // $roleName = Role::find($role_id)->name;
            // $cours_id = Course::where('name',$roleName)->first()->id;
            // $pdfs = Pdf::where('course_id',$cours_id)->get();
            $voices = Voices::all();
            $Responsevoices = [];

            foreach($voices as $key => $voice)
            {
                $name = $voice['file_name'];
              //$fullPath = storage_path('app\\' . $pdf['path']);
            //  dd($pdf['path']);
                $Responsevoices[$key] = [
                    'file_name' =>$name ,
                    'path' =>'app\\'.$voice['path'],
                ];

            }
        //    $voice = Voices::where('course_id',$cours_id)->get();
               return response()->json([
                'voice'=> $Responsevoices,
               ]);


        }

    public function getCourse(Request $request){

        $courses = Course::select('course_name','course_code')->get();

        // Return the courses as a response
        return response()->json($courses, 200);
    }
}
