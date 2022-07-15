<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Config;
use Illuminate\Support\Arr;
use Psy\CodeCleaner\IssetPass;

class AuthController extends Controller
{
    public $base_url = "https://testing.sparkdlens.com";
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'password' => 'required',
        ]);
        
        $apiURL = $this->base_url.'/oauth/token';
        $postInput = [
            'grant_type' => 'password',
            'client_id' => '969981be-3bd3-4976-94f7-63ce09c9f9a5',
            'client_secret' => 'nu5XDpPfOmXMpi3IN3K9wk454nRCHBdFBLopvHK2',
            'username' => $request->user_id,
            'password' => $request->password
        ];
  
        $headers = [
            'Accept' => 'application/json'
        ];
  
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        $response = json_decode($response);
        if(!isset($response->access_token) || !isset($response->refresh_token))
        {
            return redirect('login')->with(['error_message'=> $response->message]);
        }

        Session::put('access_token',$response->access_token);
        Session::put('refresh_token',$response->refresh_token);
        $user_details = $this->user_details();
        $user_details = json_decode($user_details)->data;
        Session::put('auth-user',$user_details);
        Session::put('user_name',$user_details->first_name.' '.$user_details->last_name);
        Session::put('participant_id',$user_details->last_participant->id);
        
        return redirect('/');

    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }

    public function user_details()
    {
        $apiURL = $this->base_url.'/api/user/me';
        return $response = Http::withToken(Session::get('access_token'))->get($apiURL);
    }

    public function personalDashboard(Request $request)
    {
        $phase_code_description = $this->phaseCodeDescription();
        $phase_distribution = array();
        $question_values  = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,);
        $contrast_values  = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,);
        $phase_code = "";
        $questions = array();
        $compare_graphs = array(0=>0,0=>0,0=>0);
        $compare_graphs_rating = array(0=>0,0=>0,0=>0);
        $feeling_of_Purpose_Inspiration_compareable = 0;
        $feeling_mastery_compareable = 0;
        $feeling_mastery_contrast = 0;
        $feeling_autonomy_compareable = 0;
        $feeling_autonomy_contrast = 0;
        $feeling_origanizational_compareable = 0;
        $feeling_origanizational_contrast = 0;
        $feeling_of_Purpose_Inspiration_contrast = 0;
        $fuel_passion_compareable = 0;
        $fuel_passion_compareable_total = 0;
        $fuel_passion_contrast = 0;
        $fuel_passion_contrast_total = 0;
        $top_strength = array(0 => 0, 1=>0, 2=>0);
        $top_improvements = array(0 => 0, 1=>0, 2=>0);
        $inspiration_compareable = array(0 => 0, 1=>0, 2=>0, 3=>0);
        $inspiration_compareable_index = 0;
        $mastery_compareable = array(0 => 0, 1=>0, 2=>0, 3=>0);
        $mastery_compareable_index = 0;
        $organizational_compareable = array(0 => 0, 1=>0, 2=>0, 3=>0,4 => 5, 5=>0, 6=>0, 7=>0);
        $organizational_compareable_index = 0;
        $autonomy_compareable = array(0 => 0, 1=>0, 2=>0, 3=>0,4 => 5);
        $autonomy_compareable_index = 0;
        $autonomy_contrast = array(0 => 0, 1=>0, 2=>0, 3=>0,4 => 5);
        $autonomy_contrast_index = 0;
        $inspiration_contrast = array(0 => 0, 1=>0, 2=>0, 3=>0);
        $inspiration_contrast_index = 0;
        $organizational_contrast = array(0 => 0, 1=>0, 2=>0, 3=>0,4 => 5, 5=>0, 6=>0, 7=>0);
        $organizational_contrast_index = 0;
        $mastery_contrast = array(0 => 0, 1=>0, 2=>0, 3=>0);
        $mastery_contrast_index = 0;
        $company_compareable = 0;
        $company_compareable_total = 0;
        $company_contrast = 0;
        $company_contrast_total = 0;

        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/contrast';
        $response = Http::withToken(Session::get('access_token'))->get($apiURL);
        if(!empty($response)){
            $response = json_decode($response);
            if(isset($response->data)){
                $response = $response->data;
                if(isset($response->phase_distribution))
                $phase_distribution = $response->phase_distribution;
            }
        }

        $compareable = $this->comparable();
        $phase_code = '';
        if(!empty($compareable)){
            $compareable = json_decode($compareable);
            if(isset($compareable->data))
            {
                $compareable = $compareable->data;
                if(isset($compareable->question_values))
                $questions = $compareable->question_values;

                foreach($questions as $index=>$question )
                {
                    $question_values[$question->display_order - 1] = $question->question_value;
                    if($index == 5)
                    {
                        break;
                    }
                }
                foreach($questions as $index=>$question_rating )
                {
                    if($question_rating->bucket == 3)
                    {
                        $compare_graphs_rating[$question_rating->display_order - 1] = $question_rating->question_value; 
                        
                        $company_compareable += $question_rating->question_value;
                        $company_compareable_total++;
                    }
                    if($question_rating->bucket == 2)
                    {
                        $fuel_passion_compareable += $question_rating->question_value;
                        $fuel_passion_compareable_total++;
                    }

                    if($question_rating->category_id == "e8a8a5ef-9763-11ec-8166-0800273b46ed")
                    {
                        $inspiration_compareable[$inspiration_compareable_index] = $question_rating->question_value;
                        $inspiration_compareable_index++;
                    }
                    if($question_rating->category_id == "e8a8a770-9763-11ec-8166-0800273b46ed")
                    {
                        $organizational_compareable[$organizational_compareable_index] = $question_rating->question_value;
                        $organizational_compareable_index++;
                    }
                    if($question_rating->category_id == "e8a8ab91-9763-11ec-8166-0800273b46ed")
                    {
                        $autonomy_compareable[$autonomy_compareable_index] = $question_rating->question_value;
                        $autonomy_compareable_index++;
                    }
                    if($question_rating->category_id == "e8a8acfc-9763-11ec-8166-0800273b46ed")
                    {
                        $mastery_compareable[$mastery_compareable_index] = $question_rating->question_value;
                        $mastery_compareable_index++;
                    }
                   
                }
                $fuel_passion_compareable = $fuel_passion_compareable/$fuel_passion_compareable_total;
                $company_compareable = $company_compareable/$company_compareable_total;

                if(isset($compareable->category_comparables)){
                    foreach($compareable->category_comparables as $category_comparable){
                        if($category_comparable->category_id == "e8a8a5ef-9763-11ec-8166-0800273b46ed"){
                            $feeling_of_Purpose_Inspiration_compareable = $category_comparable->category_average;

                        }
                        if($category_comparable->category_id == "e8a8a770-9763-11ec-8166-0800273b46ed"){
                            $feeling_origanizational_compareable = $category_comparable->category_average;
                        }
                        if($category_comparable->category_id == "e8a8ab91-9763-11ec-8166-0800273b46ed"){
                            $feeling_mastery_compareable = $category_comparable->category_average;
                        }
                        if($category_comparable->category_id == "e8a8acfc-9763-11ec-8166-0800273b46ed"){
                            $feeling_autonomy_compareable = $category_comparable->category_average;
                        }
                    }
                }
            }

            if(isset($compareable->phase_code))
            $phase_code = $compareable->phase_code;

            
        }

        $contrast = $this->contrast();
        if(!empty($contrast))
        {
            $contrast = json_decode($contrast);
            if(isset($contrast->data))
            $contrast = $contrast->data;

            if(isset($contrast->question_averages)){
            foreach($contrast->question_averages as $contrast_index=>$average)
            {
                $contrast_values[$average->display_order - 1] = $average->question_average;
                if($contrast_index == 5)
                {
                    break;
                }
            }


            
            foreach($contrast->question_averages as $contrast_index=>$question_average)
            {
                if($question_average->bucket == 3)
                {
                    $compare_graphs[$question_average->display_order - 1] = $question_average->question_average; 

                    $company_contrast += $question_average->question_average;
                    $company_contrast_total++;
                }
                if($question_average->bucket == 2)
                {
                    $fuel_passion_contrast += $question_average->question_average;  
                    $fuel_passion_contrast_total++; 
                }

                if($question_average->category_id == "e8a8a5ef-9763-11ec-8166-0800273b46ed")
                {
                    $inspiration_contrast[$inspiration_contrast_index] = $question_average->question_average;
                    $inspiration_contrast_index++;
                }
                if($question_average->category_id == "e8a8a770-9763-11ec-8166-0800273b46ed")
                {
                    $organizational_contrast[$organizational_contrast_index] = $question_average->question_average;
                    $organizational_contrast_index++;
                }
                if($question_average->category_id == "e8a8ab91-9763-11ec-8166-0800273b46ed")
                {
                    $autonomy_contrast[$autonomy_contrast_index] = $question_average->question_average;
                    $autonomy_contrast_index++;
                }
                if($question_average->category_id == "e8a8acfc-9763-11ec-8166-0800273b46ed")
                {
                    $mastery_contrast[$mastery_contrast_index] = $question_average->question_average;
                    $mastery_contrast_index++;
                }
               
            }
            $fuel_passion_contrast = $fuel_passion_contrast/$fuel_passion_contrast_total;
            $company_contrast = $company_contrast/$company_contrast_total;
        }
            if(isset($contrast->category_averages)){
                foreach($contrast->category_averages as $average)
                {
                    if($average->category_id == "e8a8a5ef-9763-11ec-8166-0800273b46ed"){
                        $feeling_of_Purpose_Inspiration_contrast = $average->category_average;
                    }
                    if($average->category_id == "e8a8a770-9763-11ec-8166-0800273b46ed"){
                        $feeling_origanizational_contrast = $average->category_average;
                    }
                    if($average->category_id == "e8a8ab91-9763-11ec-8166-0800273b46ed"){
                        $feeling_mastery_contrast = $average->category_average;
                    }
                    if($average->category_id == "e8a8acfc-9763-11ec-8166-0800273b46ed"){
                        $feeling_autonomy_contrast = $average->category_average;
                    }
                }
            }
        }

        //get saved action plans 1
        $myactions = array();
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/1';
        $myactions_api = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions_api = json_decode($myactions_api);
        if(isset($myactions_api->data)){
            $myactions = $myactions_api->data;
        }
        
        //get saved action plans 2
        $myactions_two = array();
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/2';
        $myactions_api = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions_api = json_decode($myactions_api);
        if(isset($myactions_api->data)){
            $myactions_two = $myactions_api->data;
        }

        //engagement
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/engagement';
        $engagement = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $engagement = json_decode($engagement);
        if(isset($engagement->data)){
            $lowest_engagements = $engagement->data->lowest_engagement;
            foreach($lowest_engagements as $index=>$lowest_engagement){
                $top_strength[$index] = $lowest_engagement->rating;
            }
            $highest_engagements = $engagement->data->highest_engagement;
            foreach($highest_engagements as $index=>$highest_engagement){
                $top_improvements[$index] = $highest_engagement->rating;
            }
        }
        // print_r($top_improvements);die;
        $resume = $request->is_resume;
        $states = array("A"=>"Frustrated", "B"=>"Unfulfilled", "C"=>"Stagnated", "D"=> "Disconnected", "E"=> "Neutral", "F"=>"Energized", "G"=> "Engaged", "H"=> "Passionately Engaged"); 
        return view('personal_dashboard',compact('company_contrast','company_compareable','mastery_contrast','mastery_compareable','autonomy_contrast','autonomy_compareable','organizational_contrast','organizational_compareable','inspiration_contrast','inspiration_compareable','feeling_mastery_contrast','feeling_mastery_compareable','feeling_autonomy_compareable','feeling_autonomy_contrast','feeling_origanizational_contrast','feeling_origanizational_compareable','feeling_of_Purpose_Inspiration_contrast','feeling_of_Purpose_Inspiration_compareable','fuel_passion_contrast','fuel_passion_compareable','compare_graphs_rating','compare_graphs','top_improvements','top_strength','phase_distribution', 'states','resume','phase_code','question_values','contrast_values','phase_code_description','myactions','myactions_two'));
    }

    public function comparable()
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/comparable';
        return $response = Http::withToken(Session::get('access_token'))->get($apiURL);   
    }

    public function contrast()
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/contrast';
        return $response = Http::withToken(Session::get('access_token'))->get($apiURL);   
    }
    public function privacy(){
        return view('privacy');
    }
    public function actionPlans()
    {
        $myactions_ids_array = array();
        $description = $this->actionPlansDescription();
        $phase_code = "";
        $states = array("A"=>"Frustrated", "B"=>"Unfulfilled", "C"=>"Stagnated", "D"=> "Disconnected", "E"=> "Neutral", "F"=>"Energized", "G"=> "Engaged", "H"=> "Passionately Engaged"); 
        $myactions = array();
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/1';
        $myactions_api = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions_api = json_decode($myactions_api);
        if(isset($myactions_api->data)){
            $myactions = $myactions_api->data;
        }
        // print_r($myactions);
        foreach($myactions as $index=>$myaction)
        {
            $myactions_ids_array[$index] = $myaction->action_id;
        }

        $compareable = $this->comparable();
        $phase_code = "";
        if(!empty($compareable)){
            $compareable = json_decode($compareable);
            if(isset($compareable->data)){
            $compareable = $compareable->data;
            // $questions = $compareable->question_values;
            if(isset($compareable->phase_code))
            $phase_code = $compareable->phase_code;
            }
        }

        $available_action_plans = $this->available_action_plans();
        $available_action_plans = json_decode($available_action_plans);
        $available_action_plans = !empty($available_action_plans)? (isset($available_action_plans->data) ? $available_action_plans->data :array())  : array();
        $phase_code = $phase_code != "" ? $states[$phase_code] : '';
        // print_r($available_action_plans);die;
        if(count($available_action_plans) == 0){
            return redirect('personal-dashboard')->with(['error_message'=> 'Action Planning Not Available for you']);
        }
        return view('action_plan', compact('myactions', 'phase_code','available_action_plans','description','myactions_ids_array'));
    }
    public function actionPlansDriver()
    {
        $myactions_ids_array = array();
        $description = $this->actionPlansDescription();
        $phase_code = "";
        $states = array("A"=>"Frustrated", "B"=>"Unfulfilled", "C"=>"Stagnated", "D"=> "Disconnected", "E"=> "Neutral", "F"=>"Energized", "G"=> "Engaged", "H"=> "Passionately Engaged"); 
        $myactions = array();
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/2';
        $myactions_api = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions_api = json_decode($myactions_api);
        if(isset($myactions_api->data)){
            $myactions = $myactions_api->data;
        }
        // print_r($myactions);
        foreach($myactions as $index=>$myaction)
        {
            $myactions_ids_array[$index] = $myaction->action_id;
        }

        // $questions = array();
        $phase_code = "";
        $compareable = $this->comparable();
        if(!empty($compareable)){
            $compareable = json_decode($compareable);
            if(isset($compareable->data)){
                $compareable = $compareable->data;
            // $questions = $compareable->question_values;
            if(isset($compareable->phase_code))
            $phase_code = $compareable->phase_code;
            }
        }

        $descriptions = $this->action_plan_2_description();
        $available_action_plans = $this->available_action_plans_two();
        $available_action_plans = json_decode($available_action_plans);
        $available_action_plans = !empty($available_action_plans)? (isset($available_action_plans->data) ? $available_action_plans->data : array())  : array();
        $phase_code = $phase_code != "" ? $states[$phase_code] : '';
        // print_r($available_action_plans);die;
        return view('action_plans_drivers', compact('descriptions','myactions', 'phase_code','available_action_plans','description','myactions_ids_array'));
    }

    public function deleteAction($action_id, $action_type)
    {
        $postInput = [
            'action_id' => $action_id
        ];
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/'.$action_id.'/'.$action_type;
        $response = Http::withToken(Session::get('access_token'))->delete($apiURL, $postInput); 
        return redirect()->back()->with(['success_message'=> 'Action plan deleted successfully']);
    }

    public function available_action_plans()
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/1/available';
        return Http::withToken(Session::get('access_token'))->get($apiURL);  
    }
    public function available_action_plans_two()
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/2/available';
        return Http::withToken(Session::get('access_token'))->get($apiURL);  
    }

    public function save_action_plan(Request $request)
    {
        $postInput = [
            'action_id' => $request->id,
        ];
  
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/1';
        $response = Http::withToken(Session::get('access_token'))->post($apiURL,$postInput);
        $response = json_decode($response);
        if(isset($response->data)){
            $response = [
                'success_message' => 'Action Plan Saved Successfully',
                'id' => $response->data->id,
                'status_code' => 200
            ];
        }else{
            $response = [
                'error_message' => $response[0]->message,
                'id' => '',
                'status_code' => 202
            ];
        }
        return response()->json($response);
        // return redirect()->back()->with($message);
    }
    public function save_action_plan_two(Request $request)
    {
        $postInput = [
            'action_id' => $request->id,
        ];
  
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/2';
        $response = Http::withToken(Session::get('access_token'))->post($apiURL,$postInput);
        $response = json_decode($response);
        if(isset($response->data)){
            $response = [
                'success_message' => 'Action Plan Saved Successfully',
                'id' => $response->data->id,
                'status_code' => 200
            ];
        }else{
            $response = [
                'error_message' => $response[0]->message,
                'id' => '',
                'status_code' => 202
            ];
        }
        return response()->json($response);
        // return redirect()->back()->with($message);
    }

    public function actionPlansDescription()
    {
        $description = [
            'LOCATEMEANING_C' => '<P>When trying to engage more with your current work, it is crucial to begin with locating meaning. Think about the work you produce (the product and services you personally deliver)</P><p>- Who uses the products you create? Or, who benefits from the service you provide?</p><p>-	How do these products/services help your clients (internal or external) get what they need/want?</p><p>-	How does what you do or produce improve things?</p>',
            'DISCOVERMEANING_C' => '<P>Think about how you work to see if you can discover meaning in your work. For example,</P><p>-	How does the way you work contribute to excellence?</p><p>-	How does the way you do your work help your teammates do their work?</p><p>-	How do you nurture and create high-functioning, interpersonal relationships and networks? And how do these relationships make the work more efficient and more enjoyable to do?</p>',
            'LOOKCLOSELYATYOURSPHEREOFCONTROL_C' => '<P>-	What aspects of your work are you in control of?</P><P>-	Where can you make decisions, even if small ones?</P><P>-	What aspects of your work are not 100% in your control but fall within your sphere of influence?</P><P>-	Where can you influence change or how the work gets done?</P><P>-	Who are your key stakeholders that you have the potential to influence?</P>',
            'CONSIDERALTERNATIVES_C' => '<P>There are always opportunities to improve work processes and products.</P><P>-	Challenge yourself to think about how you could achieve the same goal but could do it more efficiently or with a better quality end result.</P><P>-	Put your brain to work and it`ll find new ways of approaching the work.</P><P>-	Change the things first that are completely within your control and then work on your sphere of influence.</P><p>-	Even if your ideas seem modest, execute them! This will build momentum for further action and will enable you to enjoy your work more fully.</p>',
            'THINKBIG_C' => '<p>-	How could you add more value? Think about the work you receive and the work you pass on.</p><p>-	How could you add more value? Think about the work you receive and the work you pass on.</p><p>-	What might make your team or manager`s life easier? How could you suggest changes that would lighten their load?</p>',
            'SEEKOUTMORECHALLENGINGWORK_C' => '<p>Let`s face it you`re bored! So put your talents, skills to use!</p><p>-	Make a list of work you see around you that you could take on.</p><p>-	Visit your peers and manager and offer to take something off their plate.</p><p>-	If you feel you do not have the skill, ask them if you can learn from them during your down time or slow times.</p><p>-	Create a development plan for yourself and meet with your manager to ask for his or her support.</p>',
            'VOLUNTEERFORCOMMITTEEWORK_C' => '<p>Demonstrate an interest in the organization by volunteering for tasks outside of your job description.</p><p>-	If you like social events, think of the committees in your workplace; for example, Summer Party, Christmas Party, Fun Day, Volunteer Day, etc.</p><p>-	If you want to deepen your knowledge in an area, think about a committee that would help you do that, such as Health & Safety, Wellness, Charitable Donations, Social Media, etc.</p>',
            'LOOKFORSIGNALSOFPROGRESS_C' => '<p>: Signals of progress let you know that you are making a difference, having impact and experiencing forward movement. For example, think about the following:</p><p>-	Positive feedback you`ve received from others.</p><p>-	The goals or objectives you have recently accomplished.</p><p>-	Challenges or obstacles you have overcome.</p><p>-	Recognition you received from someone who mattered to you.</p><p>-	The pace at which you are able to get your work done.</p><p>-	The people you touch in a day and how your work helps them move their work forward.</p><p>-	The problems you resolved.</p><p>-	The things you learned.</p><p>-	What task did you stop avoiding and checked off your to-do list?</p>',
            'MEASURE&QUANTIFY_C' => '<p>Identify what you could measure in order to get a sense of progress. For example, consider the following:</p><p>-	How many inquiries did you satisfy today?</p><p>-	How many tasks did you complete this week?</p><p>-	How many items did you process today?</p><p>-	What milestone did you reach?</p><p>-	What objective or goal was completed this month?</p><p>-	How many new professional contacts did you make? (Linked In, Twitter, FaceBook, etc.)</p><p></p>',
            'INVESTIGATEOTHERPOSSIBILITIES_C' => '<p>-	<b>Reflect:</b> Within the scope of your current role, what new challenges could you take on? What changes could you lead to make things work better? If you can`t think of anything, ask someone who knows your position well, as they may see possibilities you don`t see.</p><p>- <b>Document your aspirations and values: </b>What have you always wanted to do? What work aligns best to your natural interests?</p><p>-  <b>Identify your strengths:</b>What are you good at? Where do you excel? What skills are you most proud of? What attributes do others admire in you?</p>
                                                <p>-  <b>Create a list of all the things you1d like to learn about at work: </b>What are you curious about? Who could help inform you? How could you gain direct experience?</p><p>-  <b>Ask someone to be your career coach or mentor: </b>Who do you admire and how might they guide you to discovering a better fit for you within the organization? What job does someone else have that is appealing to you and could they give you advice about how to make a transition?</p><p>-  <b>Ask for feedback: </b>Ask people you trust to give you straight and honest feedback. What do they see as your strength(s)? What do they think holds you back? What are your development areas? What do they think you could do to make more of a contribution to the organization?</p><p>-  <b>Make a growth and change plan! </b>Based on the information you`ve collected above, create a plan for yourself that will have you learning new things and making both small and big changes at work. Start small and your successes will create small wins that will build momentum for bigger changes!</p>',

            'LOCATINGMEANING_B' => '<p>When trying to engage more with your current work, it is crucial to begin with locating meaning. Think about the work you produce (the product and services you personally deliver):</p><p>-	Who uses the products you create? Or, who benefits from the service you provide?</p><p>-	How do these products/services help your clients (internal or external) get what they need/want?</p><p>-	How does what you do or produce improve things?</p>',
            'DISCOVERMEANING_B' => '<p>Think about how you work to see if you can discover meaning in your work. For example,</p><p>-	How does the way you work contribute to excellence?</p><p>-	How does the way you do your work help your teammates do their work?</p><p>-	How do you nurture and create high-functioning, interpersonal relationships and networks? And how do these relationships make the work more efficient and more enjoyable to do?</p>',
            'FOCUSONYOURSIGNALSOFPROGRESS_B' => '<P>: Look for signals of progress to let you know that you are making a difference, having impact and experiencing forward movement. For example, think about the following:</P><P>-	Positive feedback you`ve received from others.</P><P>-	The goals or objectives you have recently accomplished.</p><p>-	Challenges or obstacles you have overcome.</p><p>-	Recognition you received from someone who mattered to you.</p><p>-	The pace at which you are able to get your work done.</p><p>-	The people you touch in a day and how your work helps them move their work forward.</p><p>-	The problems you resolved.</p><p>-	The things you learned.</p><p>-	What task did you stop avoiding and checked off your to-do list?</p>',
            'MEASURE&QUANTIFY_B' => '<p>Identify what you could measure in order to get a sense of progress. For example, consider the following:</p><p>-	How many inquiries did you satisfy today?</p><p>-	How many tasks did you complete this week?</p><p>-	How many items did you process today?</p><p>-	What milestone did you reach?</p><p>-	What objective or goal was completed this month?</p><p>-	How many new professional contacts did you make? (Linked In, Twitter, FaceBook, etc.)</p><p>If once you have exhausted the possibilities in your current work you still feel unfulfilled and unchallenged, it`s time to consider your options.</p>',
            'INVESTIGATAOTHERPOSSIBILITIES_B' => '<p><b>Reflect:</b> Within the scope of your current role, what new challenges could you take on? What changes could you lead to make things work better? If you can`t think of anything, ask someone who knows your position well, as they may see possibilities you don`t see.</p><p><b>Document your aspirations and values: </b>What have you always wanted to do? What work aligns best to your natural interests?</p><p><b>Identify your strengths: </b>What are you good at? Where do you excel? What skills are you most proud of? What attributes do others admire in you?</p><p><b>•	Create a list of all the things you`d like to learn about at work: </b>What are you curious about? Who could help inform you? How could you gain direct experience?</p><p><b>Ask someone to be your career coach or mentor: </b> Who do you admire and how might they guide you to discovering a better fit for you within the organization? What job does someone else have that is appealing to you and could they give you advice about how to make a transition?</p><p><b>•	Ask for feedback: </b>Ask people you trust to give you straight and honest feedback. What do they see as your strength(s)? What do they think holds you back? What are your development areas? What do they think you could do to make more of a contribution to the organization?</p><p><b>Make a growth and change plan! </b> Based on the information you`ve collected above, create a plan for yourself that will have you learning new things and making both small and big changes at work. Start small and your successes will create small wins that will build momentum for bigger changes!</p>',       
            
            'APPLAUDSMALLWINS_A' => '<p>Your expectations for progress may be high. For example, you may expect change to happen quickly or you may hope for large shifts to occur or you may feel very impatient with the inefficiencies and bureaucracy. If this is the case, you may be depriving yourself of a sense of progress. One way to infuse your day, week or month with a sense of achievement is to see and celebrate the small wins.</p><p>Small wins are meaningful but small advances which, when acknowledged, provide a reason to celebrate and as a result uplift and encourage you. They also help build resilience. Examples of small wins:</p><p>•	You finally got the task done that you`d been postponing!</p><p>•	You managed to get a colleague on side for a new project idea.</p><p>•	You had a very good conversation with a team member and got to the bottom of a problem.</p><p>•	You didn`t buy any junk food from the vending machines today!</p><p>•	You figured out a piece of the solution to an ongoing problem.</p><p>•	You chaired a meeting that went very well.</p><p>•	You helped two colleagues sort out a problem.</p><p>The purpose of small wins is to make sure that your small success also hit your radar. If you only keep your eye on the big advances, you will deprive yourself of a sense of progress.</p>',
            'FINDTHEBRIGHTSPOTS_A' => '<p>Make it a practice every day to find a bright spot in your day. Bright spots encourage us and support both a sense of meaning and progress. In terms of progress, a bright spot might be:</p><p>•	Positive feedback from a client.</p><p>•	A word of appreciation from your boss.</p><p>•	A colleague asking you to lunch.</p><p>•	A team member giving you credit for helping with a task.</p><p>•	Something new that you learned.</p><p>•	A new opportunity to collaborate on an interesting project.</p><p>•	An expression of interest in your offering.</p><p>•	Seeing what worked well today so as not to take those things for-granted.</p>',
            'TAKECONTROLOFYOURDAY_A' => '<p>Frustrations often begin when you take lots of action without seeing enough impact. For example, I attend what seems to be an endless string of meetings. I feel exhausted but I don`t know what I have accomplished from my own to-do list. Or, I have many emails and telephone calls asking for my help with finding information or answering a question, but by the end of the day I don`t seem to have had the time I needed for my own work!</p><p>We need to learn to be discerning about how we spend our time. Here are a few suggestions to get you started:</p><p>•	Block your calendar for your day`s tasks. Be realistic. Often 30 minutes blocks are a good place to start. Don`t leave it up to chance. If you don`t carve out time for you, others will quickly grab that time from you!</p><p>•	Don`t accept meetings automatically. Ensure you know how you are going to add value and make sure the organizer has a clear objective. ("By the end of the meeting we will have done X.")</p><p>•	Check emails no more than 2 or 3 times a day (beginning, just after lunch and before the end of the day, for example). Research shows that the constant interruptions of emails keeps people much less productive than if they book time to check in.</p><p>•	Book a meeting room if you need to work with no interruptions to meet a deadline or finish work that requires a lot of concentration.</p><p>•	Book time for relationship building, especially people with whom you are interdependent. Trust is a key factor in moving our work forward. Don`t neglect this important task. It will make your life easier.</p>',
            'FOCUSONTHEBIGTHINGS_A' => '<p>At the beginning of each day, make a list of the three most important things for you to achieve in the day. It could be as simple as a telephone call to a client or as complex as planning a project.</p><p>•	Ask yourself, "What three things could I achieve today that would move the things I care about forward?" Do not be overly ambitious. Think about relatively modest actions you can take that will create a momentum for your larger goals.</p><p>•	Then, block time as early as possible in your calendar so you don`t run out of time! Waiting until 3pm to book your time will put you up against time and will set you up for failure.</p><p>•	Set three meetings with yourself for the amount of time you think it will take to accomplish each task. The three tasks might only take 15 minutes each or one might take a few minutes while another 2 hours. Make sure your top three things do not consume more than 30% of your day. You need to know you can achieve them alongside your other work and unexpected work. </p>',
            'FOCUSONYOURSPHEREOFINFLUENCE_A' => '<p>One of the best ways to reduce frustration is to focus on what you can control as well as your sphere of influence. Let go of all the issues and items that are beyond either of these. Focus on what you can either control or can at least influence. Otherwise, you will be spinning your wheels griping about things that are not in your power to change.</p><p>"Let go" is easy to say but sometimes hard to do. It may require you to re-focus. For example, instead of letting your mind think about the things that are not within your control, refocus on the things that are meaningful to you that you can move forward.</p><p>As you refocus on what is in your control and you see the results of your efforts, your frustrations will begin to lessen and you will gain a sense of progress.</p>',
            'SETYOURSELFUPFORSUCCESS_A' => '<p>Take time to think about the current situation in relation to your aspiration or goal. Make sure both are clear to you. </p><p>Once you are grounded in the "what is" and you know exactly the "where to", you can decide on the "what`s next"! </p><p>Make a list of all the actions you can take to achieve your goal. Make a list of small tasks that once completed will add up to significant progress. By breaking the large goal down into small manageable actions, you will be able to measure and see your progress on a daily basis! Setting large milestones that are intimidating and challenging to achieve will only discourage and frustrate. Small, meaningful goals that take you in the right direction will give you something to celebrate every day or at least every week and will fuel you with a strong sense of progress.</p>',

            'INCREASEMEANING_E' => '<p>When trying to engage more with your current work, it is crucial to begin with boosting meaning. Think about the work you produce (the product and services you personally deliver): </p><p>•	Who uses the products you create? Or, who benefits from the service you provide?</p><p>•	How do these products/services help your clients (internal or external) get what they need/want?</p><p>•	How does what you do or produce improve things?</p>',
            'DISCOVERMEANING_E' => '<p>Also think about how you work to see if you can discover more meaning in your work. For example:</p><p>•	How does the way you work contribute to excellence?</p><p>•	How does the way you do your work help your teammates do their work?</p><p>•	How do you nurture and create high-functioning, interpersonal relationships and networks? And how do these relationships make the work more efficient and more enjoyable to do?</p>',
            'MAKEPROGRESSVISIBLE_E' => '<p>Once you have identified further meaning in your work, focus on seeing more progress. Look for more and new signals of progress to let you know that you are making a difference, having impact and experiencing forward movement. For example, think about the following:</p><p>•	Positive feedback you`ve received from others.</p><p>•	The goals or objectives you have recently accomplished.</p><p>•	Challenges or obstacles you have overcome.</p><p>•	Recognition you received from someone who mattered to you.</p><p>•	The pace at which you are able to get your work done.</p><p>•	How your work helps others move their work forward.</p><p>•	The problems you resolved.</p><p>•	The things you learned.</p><p>•	What task did you stop avoiding and checked off your to-do list?</p>',
            'MEASURE&QUANTIFY_E' => '<p>Identify what you could measure in order to get a sense of progress. For example, consider the following:</p><p>•	How many inquiries did you satisfy today?</p><p>•	How many tasks did you complete this week?</p><p>•	How many items did you process today?</p><p>•	What milestone did you reach?</p><p>•	What objective or goal was completed this month?</p><p>•	How many new professional contacts did you make? (Linked In, etc.)</p><p>If once you have exhausted the possibilities in your current work you still feel unfulfilled, it`s time to consider your options.</p>',
            'INVESTIGATEOTHERPOSSIBILITIES_E' => '<p><b>•	Reflect: </b>Within the scope of your current role, what new challenges could you take on? What changes could you lead to make things work better? If you can`t think of anything, ask someone who knows your position well, as they may see possibilities you don`t see.</p><p><b>• Document your aspirations and values: </b>What have you always wanted to do? What work aligns best to your natural interests?</p><p><b>•	Identify your strengths: </b> What are you good at? Where do you excel? What skills are you most proud of? What attributes do others admire in you?</p><p><b>•	Create a learning list: </b> Think about of all the things you`d like to learn about at work: What are you curious about? Who could help inform you? How could you gain direct experience?</p><p><b>•	Ask someone to be your career coach or mentor: </b> Who do you admire and how might they guide you to discovering a better fit for you within the organization? What job does someone else have that is appealing to you and could they give you advice about how to make a transition?</p><p><b>•	Ask for feedback: </b> Ask people you trust to give you straight and honest feedback. What do they see as your strength(s)? What do they think holds you back? What are your development areas? What do they think you could do to make more of a contribution to the organization?</p><p><b>•	Make a growth and change plan!: </b> Based on the information you`ve collected above, create a plan for yourself that will have you learning new things and making both small and big changes at work. Start small and your successes will create small wins that will build momentum for bigger changes!</p>',

            'INCREASEMEANING-BEGINSELF_D' => '<p>Reflect on what is most meaningful to you at work. You may find the questions below helpful.</p><p>•	What do you personally value the most about your work?</p><p>•	What are you most proud of?</p><p>•	When do you feel most connected to the organization?</p><p>•	Think about why your job is important for the organization versus focusing on what you do. Write a statement about why your work matters and how it has impact.</p><p>•	How do you show yourself appreciation?</p><p>•	How could you further contribute? What are opportunities you may have not yet explored in your work?</p><p>•	In what areas would you like to deepen your learning and polish your craft?</p><p>Once you have finished your reflections, write a Purpose Statement: My work is meaningful because...</p>',
            'INCREASEMEANING-CONSULTOTHERS_D' => '<p>Ask others in what ways they find their work meaningful. There are many different ways to ask this question.</p><p>•	What aspects of your work give you the greatest sense of purpose?</p><p>•	How do you relate your work to the purpose or mission of the company?</p><p>•	How would you sum up why your work matters?</p><p>Then, with those who know you and your work well, ask them how they perceive your work.</p><p>•	What facets of your work do they think matters most to others/the organization?</p><p>•	How do they see your work supporting the purpose/mission of the organization?</p><p>•	What do they appreciate about what/how you contribute?</p><p>Finally, add any insights you receive to your Purpose Statement above. Make the statement succinct and easy to share or to remind yourself.</p>',
            'BRINGOUTSIDEINTERESTSINTOTHEWORKPLACE_D' => '<p>Consider ways you could incorporate more of your outside interests into your day-to-day work thereby strengthening the connection between the workplace and facets of your life`s purpose. Here are some examples from other clients:</p><<p>•	An professional who cared a great deal about the environment, established a Green Team at work</p><p>•	An employee wanting to promote health, started a lunchtime walking club</p><p>•	A manager interested in community service organized a volunteer day at work</p>',
            'LINKINGPROGRESSWITHCORPORATEPURPOSE_D' => '<p>•	Keep track of your significant daily accomplishments. At the end of the day, link them to an organizational objective. Which objective did your task serve?</p><p>•	If you are not clear about the organization`s objectives, it`s time to find out! Do some research. Ask around. Look around. What`s on your website? What`s in your annual report? What`s on your intranet regarding strategy and business plans? What are your departmental objectives? Become fluent. As you show your interest, people will happily share.</p><p>•	Remind yourself on a regular basis how your progress benefits others and the organization. Do not lose sight of the inherent meaning in your work.</p>',
            'LOOKFORMORECHALLENGE_D' => '<p>You may have reached a stage where you are very efficient at what you do and there is no longer challenge in your work or perhaps your process and product are very predictable. It might be time to shake it up!  Consider the following:</p><p><b>•	Seek out another position:  </b>Look within the company, even if on a temporary basis. Changing your routine and perspective can make a big difference when it come to boosting engagement.</p><p><b>•	Ask to lead a project for your department: </b>Select something for which you have the basic skills but something that would be a stretch as well. Delegate other routine work if needed. Give someone else an opportunity to learn too!</p><p><b>•	Consider becoming accredited: </b>Growing in a new aspect of your field or even something only loosely related but of interest to you is very stimulating. Studying a new subject with the aim of attaining a recognized qualification can stimulate you and will signal to others that you are seeking change.</p>',

            'BOOSTINGMEANING_F' => '<p>. Your sense of meaning is high but there may be room to grow. Think about both what you produce at work and how you work to see if you can discover further opportunities to increase meaning. For example:</p><p>•	What would it take to deepen or broaden your sense of purpose?</p><p>•	How could you work differently to finesse processes?</p><p>•	What opportunities exist to take key relationships to the next level?</p><p>•	Are you thinking ahead about your next challenge?</p><p>•	What`s an area of growth for you that could become part of your development plan?</p>',
            'MAINTAINMEANING_F' => '<p>To maintain high meaning, consider the following:</p><p>•	Consider a daily practice that keeps you grounded in your deepest purpose. For example, write out your purpose statement and read it every morning before you start work.</p><p>•	Take time to remind yourself why your work matters and to whom it matters.</p><p>•	Develop a practice of gratitude for all that works well at work.</p><p>•	Take time to share your appreciation of others with them. Be generous (and sincere) with praise and thanks.</p><p>•	Continue to maintain a balance between a task-focus and a people-focus, especially if you are a leader.</p>',
            'STRENGTHENPROGRESS_F' => '<p> Your biggest opportunity to increase your engagement is through strengthening progress. You have strength in this area but it could grow and deepen. Deliberately look for signals of progress to let you know that you are making a difference, having impact and experiencing forward movement. For example, think about the following:</p><p>•	Positive feedback you`ve received from others.</p><p>•	The goals or objectives you have recently accomplished.</p><p>•	Challenges or obstacles you have overcome.</p><p>•	Recognition you received from someone who mattered to you.</p><p>•	The pace at which you are able to get your work done.</p><p>•	The people you touch in a day and how your work helps them move their work forward.</p><p>•	The problems you resolved.</p><p>•	The things you learned.</p><p></p>',
            'MEASURE&QUANTIFY_F' => '<p>Identify what you could measure in order to get a sense of progress. For example, consider the following:</p><p>•	How many inquiries did you satisfy today?</p><p>•	How many tasks did you complete this week?</p><p>•	How many items did you process today?</p><p>•	What milestone did you reach?</p><p>•	What objective or goal was completed this month?</p><p>•	How many new professional contacts did you make? (Linked In, Twitter, FaceBook, etc.)</p>',

            'BOOSTMEANING_G' => '<p>Your sense of meaning is high but there may be room to grow. Think about both what you produce at work and how you work to see if you can discover further opportunities to increase meaning. For example:</p><p>•	What would it take to deepen or broaden your sense of purpose?</p><p>•	How could you work differently to finesse processes?</p><p>•	What opportunities exist to take key relationships to the next level?</p><p>•	Are you thinking ahead about your next challenge?</p><p>•	What`s an area of growth for you that could become part of your development plan?</p>',
            'MAINTAINMEANING_G' => '<p>To maintain high meaning, consider the following:</p><p>•	Consider a daily practice that keeps you grounded in your deepest purpose. For example, write </p><p>•	Take time to remind yourself why your work matters and to whom it matters.</p><p>•	Develop a practice of gratitude for all that works well at work.</p><p>•	Take time to share your appreciation of others with them. Be generous (and sincere) with praise and thanks.</p><p>•	Continue to maintain a balance between a task-focus and a people-focus, especially if you are a leader.</p>',
            'STRENGTHENPROGRESS_G' => '<p>Your biggest opportunity to increase your engagement is through strengthening progress. You have strength in this area but it could grow and deepen. Deliberately look for signals of progress to let you know that you are making a difference, having impact and experiencing forward movement. For example, think about the following:</p><p>•	Positive feedback you`ve received from others.</p><p>•	The goals or objectives you have recently accomplished.</p><p>•	Challenges or obstacles you have overcome.</p><p>•	Recognition you received from someone who mattered to you.</p><p>•	The pace at which you are able to get your work done.</p><p>•	The people you touch in a day and how your work helps them move their work forward.</p><p>•	The problems you resolved.</p><p>•	The things you learned.</p><p>•	What task did you stop avoiding and checked off your to-do list?</p>',
            'MEASURE&QUANTIFY_G' => '<p>Identify what you could measure in order to get a sense of progress. For example, consider the following:</p><p>•	How many inquiries did you satisfy today?</p><p>•	How many tasks did you complete this week?</p><p>•	How many items did you process today?</p><p>•	What milestone did you reach?</p><p>•	What objective or goal was completed this month?</p><p>•	How many new professional contacts did you make? (Linked In, Twitter, FaceBook, etc.)</p>',
            
            'SUSTAINMEANING_H' => '<p>Your sense of meaning is high. The current challenge for you is to maintain this high level of meaning in your current work and career. Consider the following practices:</p><p>•	On a daily basis, begin or end your day with a reflection on the meaning that is inherent in what you produce at work and how you produce it. Recalling your essence of meaning keeps it clear and strong within you.</p><p>•	Remind yourself how your current work and career support your sense of purpose in life. This will also sustain you.</p><p>•	Continue to nurture your drivers of meaning and progress to ensure none are neglected.</p><p>•	Quarterly, identify new challenges and growth areas for yourself to maintain the optimal level of challenge for your skills and talents. The more you learn, the more you need to be on the look out for opportunities to use and challenge those skills.</p><p>•	Stay connected to your deepest aspirations. Annually, take a retreat. It may be a few hours spent writing and reflecting on your aspirations or a week-long yoga retreat! Find the format that is right for you.</p>',
            'KEEPSEEINGYOURSENSEOFPROGRESS_H' => '<p>You are exceptional at creating and noticing a sense of progress for yourself. Protect this skill and mindset. Nurture it. Continue to look for and notice signals of progress which shows you how you are making a difference, having impact and experiencing forward movement. For example, create a daily practice to notice or think about the following:</p><p>•	Positive feedback you`ve received from others.</p><p>•	The goals or objectives you have recently accomplished.</p><p>•	Challenges or obstacles you have overcome.</p><p>•	Recognition you received from someone who mattered to you.</p><p>•	The pace at which you are able to get your work done.</p><p>•	How your work helps others move their work forward.</p><p>•	The problems you resolved.</p><p>•	The things you learned.</p><p>•	What task did you stop avoiding and checked off your to-do list?</p>',
            'MEASURE&QUANTIFY_H' => '<p>Ensure you consciously know what you are measuring to get a sense of progress. Make a list of the things that are measurable which you consciously or unconsciously drawn upon to give you a sense of progress. For example:</p><p>•	Inquiries you satisfy in a day</p><p>•	Tasks you completed today/this week</p><p>•	Number of items you processed today</p><p>•	Milestones achieved</p><p>•	Objective or goal you completed this month</p><p>•	New professional contacts you made (Linked In, Twitter, FaceBook, etc.)</p>'
        ];

        return $description;
    }

    public function phaseCodeDescription()
    {
        $description = [
            'Frustrated' => '<p>In this state you may find yourself feeling exasperated because your sense of progress is less that you hoped for or expected. There might be specific things you want to achieve or a change you would like to bring into the workplace or into your work product; however, the pace of progress is likely unsatisfying for you on some level.  As a result, you might find it challenging to find things to celebrate. This state indicates that you see your work as highly meaningful and because of this it may also be true that you feel some pressure to make things happen. This caring can lead to high levels of activity (trying to do too much) that could become stressful over time. In some instances it might even cause you to obsess.</p><p>Often, a facet of obsessing is a tendency to allow failures at work to play on one`s mind. This may be because failures are seen as a missed opportunity to create forward movement, which may cause further frustration because you care so much.</p><p>In this state, your work offers some fulfillment but because passion is also fueled by progress, the lack of forward movement you sometimes experience can become an energy drain. Without a high sense of progress, work may not be quite as much fun, perhaps making it difficult, at times, to stay inspired.  When this happens work may feel too much like work, especially when everything seems to be a high priority. During these times, you may feel so busy that you don`t seem to have time to think. The upside is that time does pass fairly quickly.</p>',
            'Unfulfilled' => '<p>In this state you may find your work doesn`t provide you with the sense of fulfillment you desire. This situation may sometimes cause you to lack energy both at work and outside of work. Your work does hold some meaning for you but you are not able to see the progress you desire. As a result, experiencing a sense of fulfillment, consistently at work, is perhaps difficult. The domino effect of this could be that you tend not to celebrate, which may further prevent you from experiencing a reliable sense of accomplishment, thereby progress.</p><p>You likely have deep aspirations and ambitions that you yearn to achieve and it may appear that your current work experience is not supporting movement in this direction, hence your pace of progress may feel too slow. You may even puzzle over others` enthusiasm. On some days, you may find yourself considering other work but you also worry about the financial impact of change</p><p>It could also be that you sometimes doubt whether your current work will provide opportunities to fulfill these aspirations or help you achieve your potential. These doubts, over time, may effect your self-esteem or self-confidence if you don`t manage this situation to your benefit</p>',
            'Stagnated' => '<p>In this state you may find your work fairly unchallenging or not as fulfilling as you would like. This could result, at times, in feeling disengaged from your work. As a result, time may drag and you might find yourself living for your interests outside of work. You might also struggle to find reasons to celebrate as your work may not give you the sense of accomplishment you desire. The sense of meaning and progress at work you crave may feel low compared to what you have previously known. You may notice on some days, or perhaps even many days, you find yourself yearning for more.</p><p>It could be that your aspirations and long-term goals may be unclear to you or you do not see how they can be achieved within your current work and career situation, which will likely reduce the meaning you see in your work. This has left you feeling somewhat at a standstill.</p><p>This may be compounded by the fact that your work is not challenging enough for you. In fact, it might be too easy for you.  You desire to use fully your talents and to also continue to learn and grow.  You may find that your sense of progress at work is held back without this stimulation. It may also mean that you worry about having the opportunity in your current work to achieve your potential. This situation, when prevalent for longer periods of time, may begin to impact your self-esteem or self-confidence.</p><p>All in all, this work experience may leave you feeling a lack of momentum, as you are not actively working toward personally meaningful goals at work; however, your heart`s desire is likely much deeper engagement.</p>',
            'Disconnected' => '<p>In this state you reported experiencing a strong sense of progress. This functions as a strength for you.  You also reported that your overall meaning is significantly lower than your sense of progress. This situation may lead to a work experience in which you get your work done but you may not get a great deal of joy from it. Nonetheless, you have ownership for your work and you do move your tasks/objectives forward.</p><p>This profile usually indicates that you are responsible at work in that you meet your obligations. You likely have a sense of ownership for your work and how your work is accomplished. It is also possible that you are able to make at least some decisions about how your work gets done. People with this profile generally have the skills to do their work; in fact, you may feel you have untapped potential.</p><p>However, it is also often true that with this profile you do not have a strong connection to purpose, which may also be lowering you sense of meaning. In addition, you might feel that your work often goes unappreciated by others, especially outside of your immediate team. Sometimes, you (your position/work) may feel taken for-granted or under-valued. For example, you may not feel fully included in the flow of communications and you may not see how to offer your input.  It is possible that this may lead to a sense of being separate from the heartbeat of the organization or possibly over-focusing on your own area.</p><p>Although a focus on your own work may give you a sense of healthy progress, you may not know exactly how the progress you achieve connects to the organization`s mission. This may lead to a tendency to neglect celebration.</p>',
            'Neutral' => '<p>In this state, you likely find your work somewhat challenging and somewhat fulfilling. Your score indicates that your sense of meaning and progress are typical, meaning they fall in the average zone (neither high nor low). You get your work done and take things in stride; in other words, you tend not to get too worked up about things. You celebrate some of your accomplishments however may miss opportunities to celebrate other achievements, as you may deem them less significant and so less worthy of celebration.</p><p>Your score indicates that you see your work as somewhat meaningful and you are seeing some progress. This is the most common profile in our database. Statistically, it is deemed "the average." In other words, people in this state may enjoy their work but there may be room to deepen one`s connection to meaning and to increase the opportunities to make progress visible</p><p>A common characteristic of this state is not getting too fussed about mistakes. You pretty much go with the flow. Time goes neither too slowly nor does it fly. You appear to have enough work to keep you occupied and productive without becoming too busy or overwhelmed.  This state indicates that in many ways you are comfortable with your work. In this state, it is likely that your work neither aggravates you nor really jazzes you.</p><p>You have enough meaning and progress to engage in at least some facets of your work. In other words, you have enough to buffer you from the negative areas but you might need a boost to move you into the states of Energized, Engaged, or Passionately Engaged.</p>',
            'Energized' => '<p>In this state you likely find your work fulfilling and fairly challenging. You are likely taking action against things that matter to you. You appear to be a doer. Your scores indicate your overall engagement is driven more by a high sense of meaning, as your sense of progress is somewhat lower. You do celebrate some of your accomplishments but it may be that others you do not deem worthy of celebration.</p><p>Your strength is you see your work as highly meaningful. You seem to have a sense of purpose and to feel emotionally invested in your work. It is probable that this is highly motivating for you.</p><p>You also report a healthy sense of progress.  It appears that for the most part, you can see the impact of your actions and, as a result, feel a sense of forward movement. This sense of progress seems to energize you.</p><p>It is likely that when your sense of progress is strongest, you celebrate your achievements. This acknowledgement of success has the added benefit of reinforcing both meaning and progress, as we celebrate what is meaningful to us and what tells us we are getting somewhere. You tend to feel good about the contributions you are making at work.</p><p>In this state, it is probable that your current work and career are fulfilling. You may find your work challenging thereby seeing your talents and skills being put to good use. Therefore, imaginably you are also learning and growing. As a result, you may find it easy to focus on your work and identify with your work. You may, at times, feel as if you care more than others, as your work appears to mean more to you than a paycheck.</p><p>With this profile, it is unlikely that you need to dream about other possibilities, as your current work seems to allow you to take action against those things that are meaningful to you. You are likely a doer and you usually know how to take your ideas and make them happen. The actions you take at work are prone to energize you and you generally look forward to coming to work. You are apt to sustain fairly intense action without it draining you. It is apt on most days, you end your day feeling good with energy to spare, which you may devote to your outside work interests.</p>',
            'Engaged' => '<p>In this state you may experience a good measure of fulfillment at work and you likely take time to celebrate your accomplishments. You are apt to have some resilience and are probably not driven crazy or frustrated by most matters. Therefore, you tend not to obsess; however, work is likely very important to you and contributes significantly to your sense of identity. Your scores indicate that your engagement is driven more by a sense of high progress, as your meaning scores are somewhat lower. Nevertheless, you do see a good amount of meaning in your work. Your scores indicate you have a sense of purpose and feel emotionally connected to your work.</p><p>Your scores indicate a very healthy sense of progress.  For the most part, you appear to see the impact of your actions and, as a result, feel a sense of forward movement. This sense of progress likely energizes you. In fact, in this state of work, progress is a distinguishing driver of engagement.</p><p>When your sense of progress is strongest, you are apt to celebrate your achievements. This acknowledgement of your accomplishments has the added benefit of reinforcing both meaning and progress, as we tend to celebrate what is meaningful to us and what tells us we are getting somewhere. You are prone to feeling good about the contributions you are making at work.</p><p>Your current work and career are likely fulfilling. You may also see your talents and skills being put to use as your work challenges you. In this state, it is quite possible that you are also learning and growing. As a result, you may find it easy to focus on your work and you may identify strongly with it. At times, you might feel as if you care more than others, as your work likely means more to you than a paycheck</p><p>With this profile, it is unlikely that you need to dream about other possibilities, as your current work seems to allow you to take action against those things that are meaningful to you. You are most probably a doer and you usually know how to take your ideas and make them happen. The actions you take at work are prone to energize you and you generally look forward to coming to work. You are apt to sustain fairly intense action without it draining you. It is likely that on most days, you end your day feeling good with energy to spare, which you may devote to your outside work interests.</p>',
            'PassionatelyEngaged' => '<p>In this state of work you are likely energized, as you probably feel challenged and have a high sense of fulfillment. You are prone to take action on goals that matter to you and you are apt to celebrate your achievements. You appear to work at an appropriate pace and you tend not to obsess. Your scores indicate that you have both a sense of high meaning and progress at work.</p><p>Your scores indicate that you see your work as of the highest meaning. It is therefore probable that you have a clear sense of purpose and feel emotionally connected to your work. You are likely highly motivated.</p><p>Your scores also indicate that you have the highest sense of progress.  Given this, you very likely see the impact of your actions and, as a result, feel a significant amount of forward movement. This sense of progress is apt to energize you. You see progress in your current work as well as your career in general. This progress will tend to create resilience and fuel your motivation.</p><p>You are also likely skilled at observing progress and you may recognize the benefit of celebrating your achievements as this creates a virtuous cycle: the acknowledgement of accomplishments reinforces both that which is meaningful to you as well as highlights the progress you have made. Celebration signals to us that we are getting somewhere toward that which matters most to us.</p><p>Your current work and career appear to be fulfilling. You generally do not need to dream about other possibilities as your current work allows you to take action against those things that are meaningful to you. You may also see your talents and skills being put to use as your work challenges you. You likely feel good about the contributions you are making at work.</p><p>In this state, you are disposed to learn and grow. You have probably developed the ability to learn from your mistakes so are accepting that mistakes will happen. You therefore may have a healthy attitude toward mistakes.</p><p>In this state, it is common to feel fully engaged when at work while not leaving work exhausted. Work likely energizes you and so you have energy for your activities and interests outside of work.");</p>' 
        ];

        return $description;
    }

    public function action_plan_print()
    {
        $description = $this->actionPlansDescription();
        $myactions = array();
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/1';
        $myactions_api = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions_api = json_decode($myactions_api);
        if(isset($myactions_api->data)){
            $myactions = $myactions_api->data;
        }

        $myactions_two = array();
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/2';
        $myactions_api = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions_api = json_decode($myactions_api);
        if(isset($myactions_api->data)){
            $myactions_two = $myactions_api->data;
        }
        
        $descriptions = $this->action_plan_2_description();
        // return $myactions;
        return view('action_print',compact('myactions','description','myactions_two','descriptions'));
    }
    public function export_report()
    {
        {
            $phase_code_description = $this->phaseCodeDescription();
            $phase_distribution = array();
            $question_values  = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,);
            $contrast_values  = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,);
            $phase_code = "";
            $compare_graphs = array(0=>0,0=>0,0=>0);
            $compare_graphs_rating = array(0=>0,0=>0,0=>0);
            $feeling_of_Purpose_Inspiration_compareable = 0;
            $feeling_mastery_compareable = 0;
            $feeling_mastery_contrast = 0;
            $feeling_autonomy_compareable = 0;
            $feeling_autonomy_contrast = 0;
            $feeling_origanizational_compareable = 0;
            $feeling_origanizational_contrast = 0;
            $feeling_of_Purpose_Inspiration_contrast = 0;
            $fuel_passion_compareable = 0;
            $fuel_passion_compareable_total = 0;
            $fuel_passion_contrast = 0;
            $fuel_passion_contrast_total = 0;
            $top_strength = array(0 => 0, 1=>0, 2=>0);
            $top_improvements = array(0 => 0, 1=>0, 2=>0);
            $inspiration_compareable = array(0 => 0, 1=>0, 2=>0, 3=>0);
            $inspiration_compareable_index = 0;
            $mastery_compareable = array(0 => 0, 1=>0, 2=>0, 3=>0);
            $mastery_compareable_index = 0;
            $organizational_compareable = array(0 => 0, 1=>0, 2=>0, 3=>0,4 => 5, 5=>0, 6=>0, 7=>0);
            $organizational_compareable_index = 0;
            $autonomy_compareable = array(0 => 0, 1=>0, 2=>0, 3=>0,4 => 5);
            $autonomy_compareable_index = 0;
            $autonomy_contrast = array(0 => 0, 1=>0, 2=>0, 3=>0,4 => 5);
            $autonomy_contrast_index = 0;
            $inspiration_contrast = array(0 => 0, 1=>0, 2=>0, 3=>0);
            $inspiration_contrast_index = 0;
            $organizational_contrast = array(0 => 0, 1=>0, 2=>0, 3=>0,4 => 5, 5=>0, 6=>0, 7=>0);
            $organizational_contrast_index = 0;
            $mastery_contrast = array(0 => 0, 1=>0, 2=>0, 3=>0);
            $mastery_contrast_index = 0;
            $company_compareable_total = 0;
            $company_compareable = 0;
            $company_contrast_total = 0;
            $company_contrast = 0;

            $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/contrast';
            $response = Http::withToken(Session::get('access_token'))->get($apiURL);
            if(!empty($response)){
                $response = json_decode($response);
                if(isset($response->data)){
                $response = $response->data;
                
                if(isset($response->phase_distribution))
                $phase_distribution = $response->phase_distribution;
                }
            }
    
            $phase_code = "";
            $compareable = $this->comparable();
            if(!empty($compareable)){
                $compareable = json_decode($compareable);
                if(isset($compareable->data))
                {
                    $compareable = $compareable->data;
                    if(isset($compareable->question_values)){
                        $questions = $compareable->question_values;
                        foreach($questions as $index=>$question )
                        {
                            $question_values[$question->display_order - 1] = $question->question_value;
                            if($index == 5)
                            {
                                break;
                            }
                        }
                            foreach($questions as $index=>$question_rating )
                            {
                                if($question_rating->bucket == 3)
                                {
                                    $compare_graphs_rating[$question_rating->display_order - 1] = $question_rating->question_value;  
                                    
                                    $company_compareable += $question_rating->question_value;
                                    $company_compareable_total++;
                                }

                                if($question_rating->bucket == 2)
                                {
                                    $fuel_passion_compareable += $question_rating->question_value;
                                    $fuel_passion_compareable_total++;
                                }

            
                                if($question_rating->category_id == "e8a8a5ef-9763-11ec-8166-0800273b46ed")
                                {
                                    $inspiration_compareable[$inspiration_compareable_index] = $question_rating->question_value;
                                    $inspiration_compareable_index++;
                                }
                                if($question_rating->category_id == "e8a8a770-9763-11ec-8166-0800273b46ed")
                                {
                                    $organizational_compareable[$organizational_compareable_index] = $question_rating->question_value;
                                    $organizational_compareable_index++;
                                }
                                if($question_rating->category_id == "e8a8ab91-9763-11ec-8166-0800273b46ed")
                                {
                                    $autonomy_compareable[$autonomy_compareable_index] = $question_rating->question_value;
                                    $autonomy_compareable_index++;
                                }
                                if($question_rating->category_id == "e8a8acfc-9763-11ec-8166-0800273b46ed")
                                {
                                    $mastery_compareable[$mastery_compareable_index] = $question_rating->question_value;
                                    $mastery_compareable_index++;
                                }
                               
                            }
                           
                            $fuel_passion_compareable = $fuel_passion_compareable/$fuel_passion_compareable_total;
                            $company_compareable = $company_compareable/$company_compareable_total;
                            if(isset($compareable->category_comparables)){
                                foreach($compareable->category_comparables as $category_comparable){
                                    if($category_comparable->category_id == "e8a8a5ef-9763-11ec-8166-0800273b46ed"){
                                        $feeling_of_Purpose_Inspiration_compareable = $category_comparable->category_average;
            
                                    }
                                    if($category_comparable->category_id == "e8a8a770-9763-11ec-8166-0800273b46ed"){
                                        $feeling_origanizational_compareable = $category_comparable->category_average;
                                    }
                                    if($category_comparable->category_id == "e8a8ab91-9763-11ec-8166-0800273b46ed"){
                                        $feeling_mastery_compareable = $category_comparable->category_average;
                                    }
                                    if($category_comparable->category_id == "e8a8acfc-9763-11ec-8166-0800273b46ed"){
                                        $feeling_autonomy_compareable = $category_comparable->category_average;
                                    }
                                }
                            }
                }
                    if(isset($compareable->phase_code))
                    $phase_code = $compareable->phase_code;
                }
            }
            // echo  $fuel_passion_compareable;die;
            $contrast = $this->contrast();
            if(!empty($contrast))
            {
                $contrast = json_decode($contrast);
                if(isset($contrast->data)){
                    $contrast = $contrast->data;
                    foreach($contrast->question_averages as $contrast_index=>$average)
                    {
                        $contrast_values[$average->display_order - 1] = $average->question_average;
                        if($contrast_index == 5)
                        {
                            break;
                        }
                    }

                    foreach($contrast->question_averages as $contrast_index=>$question_average)
                    {
                        if($question_average->bucket == 3)
                        {
                            $compare_graphs[$question_average->display_order - 1] = $question_average->question_average; 
                            
                            $company_contrast += $question_average->question_average;
                            $company_contrast_total++;
                        }

                        if($question_average->bucket == 2)
                        {
                            $fuel_passion_contrast += $question_average->question_average;  
                            $fuel_passion_contrast_total++; 
                        }
        
                        if($question_average->category_id == "e8a8a5ef-9763-11ec-8166-0800273b46ed")
                        {
                            $inspiration_contrast[$inspiration_contrast_index] = $question_average->question_average;
                            $inspiration_contrast_index++;
                        }
                        if($question_average->category_id == "e8a8a770-9763-11ec-8166-0800273b46ed")
                        {
                            $organizational_contrast[$organizational_contrast_index] = $question_average->question_average;
                            $organizational_contrast_index++;
                        }
                        if($question_average->category_id == "e8a8ab91-9763-11ec-8166-0800273b46ed")
                        {
                            $autonomy_contrast[$autonomy_contrast_index] = $question_average->question_average;
                            $autonomy_contrast_index++;
                        }
                        if($question_average->category_id == "e8a8acfc-9763-11ec-8166-0800273b46ed")
                        {
                            $mastery_contrast[$mastery_contrast_index] = $question_average->question_average;
                            $mastery_contrast_index++;
                        }
                       
                    }
                    $fuel_passion_contrast = $fuel_passion_contrast/$fuel_passion_contrast_total;
                    $company_contrast = $company_contrast/$company_contrast_total;
                    
                    }
                    if(isset($contrast->category_averages)){
                        foreach($contrast->category_averages as $average)
                        {
                            if($average->category_id == "e8a8a5ef-9763-11ec-8166-0800273b46ed"){
                                $feeling_of_Purpose_Inspiration_contrast = $average->category_average;
                            }
                            if($average->category_id == "e8a8a770-9763-11ec-8166-0800273b46ed"){
                                $feeling_origanizational_contrast = $average->category_average;
                            }
                            if($average->category_id == "e8a8ab91-9763-11ec-8166-0800273b46ed"){
                                $feeling_mastery_contrast = $average->category_average;
                            }
                            if($average->category_id == "e8a8acfc-9763-11ec-8166-0800273b46ed"){
                                $feeling_autonomy_contrast = $average->category_average;
                            }
                        }
                    }
                }


            //get saved action plans 1
            $myactions = array();
            $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/1';
            $myactions_api = Http::withToken(Session::get('access_token'))->get($apiURL);  
            $myactions_api = json_decode($myactions_api);
            if(isset($myactions_api->data)){
                $myactions = $myactions_api->data;
            }
            
            //get saved action plans 2
            $myactions_two = array();
            $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/2';
            $myactions_api = Http::withToken(Session::get('access_token'))->get($apiURL);  
            $myactions_api = json_decode($myactions_api);
            if(isset($myactions_api->data)){
                $myactions_two = $myactions_api->data;
            }

            
            //engagement
            $top_strength = array(0 => 0, 1=>0, 2=>0);
            $top_improvements = array(0 => 0, 1=>0, 2=>0);
            $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/engagement';
            $engagement = Http::withToken(Session::get('access_token'))->get($apiURL);  
            $engagement = json_decode($engagement);
            if(isset($engagement->data)){
                $lowest_engagements = $engagement->data->lowest_engagement;
                foreach($lowest_engagements as $index=>$lowest_engagement){
                    $top_strength[$index] = $lowest_engagement->rating;
                }
                $highest_engagements = $engagement->data->highest_engagement;
                foreach($highest_engagements as $index=>$highest_engagement){
                    $top_improvements[$index] = $highest_engagement->rating;
                }
            }
    
            $states = array("A"=>"Frustrated", "B"=>"Unfulfilled", "C"=>"Stagnated", "D"=> "Disconnected", "E"=> "Neutral", "F"=>"Energized", "G"=> "Engaged", "H"=> "Passionately Engaged"); 
            return view('export_report',compact('company_contrast','company_compareable','mastery_contrast','mastery_compareable','autonomy_contrast','autonomy_compareable','organizational_contrast','organizational_compareable','inspiration_contrast','inspiration_compareable','feeling_autonomy_contrast','feeling_autonomy_compareable','feeling_mastery_contrast','feeling_mastery_compareable','feeling_origanizational_contrast','feeling_origanizational_compareable','feeling_of_Purpose_Inspiration_contrast','feeling_of_Purpose_Inspiration_compareable','fuel_passion_contrast','fuel_passion_compareable','top_strength','top_improvements','compare_graphs','compare_graphs_rating','myactions','myactions_two','phase_distribution', 'states','phase_code','question_values','contrast_values','phase_code_description'));
        }
    }

    public function action_plan_2_description()
    {
        $description['1c3f6046-9381-497d-962a-fbe0c32d762f']['Get Clarity'][0][6]['dfd7ea53-975d-11ec-8166-0800273b46ed'] = "Ensure you are clear on the values of your team/organization and how they are defined in practice. For example, if integrity is a value, reflect on what behaviors represent integrity in the context of your organization. If you work in insurance, it might be expressed by ensuring claims are paid fairly and in a timely fashion, according to the contract. Values are not theoretical notions but are defined by behaviors that speak to how the work gets done within your organization.";
        $description['43a934c3-d5bc-48ea-a590-8a99fd2dbeae']['Determine Purpose'][0][6]['dfd7ea53-975d-11ec-8166-0800273b46ed'] = "Reflect on the extent to which you can support them: Consider how they benefit your stakeholders, how they support the mission and vision of your organization, and how the values help create a healthy work environment";
        $description['9a80f6ac-cbda-43ee-af4d-638aaecf48f7']['Take Action'][0][6]['dfd7ea53-975d-11ec-8166-0800273b46ed'] = "Think about the behaviours that align you to these values. For example, if transparency is a team/corporate value, and if it is defined as sharing information freely and genuinely with those who either receive your work or from whom you receive work, look for ways to share beyond your normal habit and observe the results of this sharing. Assessing these results will enable you to affirm your belief in the value. Do this with each team/organizational value.";
        $description['d3694d35-692d-4f12-a3fd-ac7c23e4531b']['Get Clarity'][7][8]['dfd7ea53-975d-11ec-8166-0800273b46ed'] = "Ensure you are clear on how your team/organizational values are defined in practice. For example, if integrity is a value, reflect on what behaviors represent integrity in the context of your organization. If you work in insurance, it might be expressed by ensuring claims are paid fairly and in a timely fashion, according to the contract. Values are not theoretical notions but are defined by behaviors that speak to how the work gets done within your organization.";
        $description['968ff331-e93c-4fb8-a75a-d5d497fa25c8']['Reflect'][7][8]['dfd7ea53-975d-11ec-8166-0800273b46ed'] = "Reflect on how you can support the mission and values of your organization further. Consider the key benefits to your stakeholders and how this links to the mission and vision. Also, consider what would be gained if these values were fully promoted within your team/organizational context.";
        $description['5bf8003b-ee89-4715-9317-b82ab3b806a3']['Experiment'][7][8]['dfd7ea53-975d-11ec-8166-0800273b46ed'] = "Explore ways to deepen your belief in these values by experimenting with consciously living these values in your day-to-day interactions at work. For example, if transparency is a team/corporate value, and if it is defined as sharing information freely and genuinely with those who either receive your work or from whom you receive work, look for ways to share beyond your normal habit and observe the results of this sharing. Assessing these results will enable you to affirm your belief in the value. Do this with each team/organizational value in turn.";
        $description['078cfca9-491c-4e0b-a267-d2661e54f129']['Take Notice'][9][10]['dfd7ea53-975d-11ec-8166-0800273b46ed'] = "Notice how these values contribute to a positive work environment and quality outputs. When the team chooses in favor of its values, especially under pressure, point this out as something to be celebrated and appreciated.";
        $description['2dc2aa99-5ad0-4246-b2e8-e19030d9fda4']['Advocate'][9][10]['dfd7ea53-975d-11ec-8166-0800273b46ed'] = "Become an advocate for the values by pointing out when they might help guide decision-making. For example, if collaboration is a team/corporate value and circumstances arise that may violate this value (i.e., two colleagues are placed in a potentially competitive situation), share your observations with your team and suggest that you discuss this discrepancy in the hope of resolving it so the value can be upheld.";
        $description['088edf92-40e0-4415-9ff5-7d0f3f6ae7c7']['Share Examples in Action'][9][10]['dfd7ea53-975d-11ec-8166-0800273b46ed'] = "When new people join the team/organization, look for opportunities to share with them the values in action so they can learn to align their behaviors with the team's/organization's values. Suggest the team/organization also find ways to orientate new members collectively.";
        $description['90eca9e9-ac3b-43f4-9dd8-94da63f2edbc']['Get Clarity'][0][6]['dfd7eac0-975d-11ec-8166-0800273b46ed'] = "Ensure you are clear on your organization's vision. Review any written documents that discuss the vision, such as Annual Reports, the Corporate website, the Business Plan, etc. If you require clarification, ask your manager or reach out to others in your organization that could help, such as your Communications Department or even the CEO. Once you have clarity, spend some time reflecting on what the vision would mean to the organization's stakeholders, if achieved. How would employees, customers, vendors, the community and shareholders benefit? If you don't know, ask more questions. Discuss it with others.";
        $description['d83c8d9b-39b4-4bcd-b3db-fbf265069ac4']['Make it Meaningful'][0][6]['dfd7eac0-975d-11ec-8166-0800273b46ed'] = "As you think about the vision and mission, ask yourself, is this something you could stand behind? Would achieving this make you proud to work for this organization? Create a clear statement that connects you to what's meaningful about the organization's vision for you! For example, 'I believe in my organization's vision because...'.";
        $description['d7a89f1c-dd38-466c-a188-2f9251ed32d8']['Reflect & Engage'][0][6]['dfd7eac0-975d-11ec-8166-0800273b46ed'] = "If after going through this process, you are not able to connect in a meaningful way to your organization's vision, ask yourself, `What would make the vision statement resonate with me? What`s currently lacking? What aspirations do I have for the organization?”. Once you`ve articulated these, ask to meet with your manager to discuss and explore ways of providing upward feedback so that your ideas can be presented and considered by your leadership team.";
        $description['c583425a-9853-476d-a79d-f1596ca84165']['Get Clarity'][7][8]['dfd7eac0-975d-11ec-8166-0800273b46ed'] = "Ensure you are clear on your organization's vision. Review any written documents that discuss the vision, such as Annual Reports, the Corporate website, the Business Plan, etc. If you require clarification, ask your manager or reach out to others in your organization that could help, such as your Communications Department or even the CEO. Once you confirm clarity, spend some time reflecting on what achieving the vision would mean to the organization's stakeholders. How would employees, customers, vendors, the community and shareholders benefit? If you don't know, ask more questions. Discuss it with others.";
        $description['6c73d5fc-aebb-4cb1-a0f4-869f022695f1']['Make it Meaningful'][7][8]['dfd7eac0-975d-11ec-8166-0800273b46ed'] = "As you think about the benefits, ask yourself, is this something you stand behind? Will achieving this vision make you proud to work for this organization? Create a clear statement that connects you to what's meaningful about the organization's vision for you! For example, “I believe in my organization's vision because...”.";
        $description['c30af3b8-131f-4138-8b5c-eda8bbd16c73']['Reflect & Engage'][7][8]['dfd7eac0-975d-11ec-8166-0800273b46ed'] = "If after going through this process, you don’t fully connect in a meaningful way to your organization's vision, ask yourself, `What would make the vision statement really resonate with me? What's currently lacking? What aspirations do I have for the organization?”. Once yo`ve articulated these, ask to meet with your manager to discuss and explore ways of providing upward feedback so that your ideas can be presented and considered by your leadership team.";
        $description['d734b674-0a2a-4c5b-bd99-72e4481dc47a']['Maintain Clarity'][9][10]['dfd7eac0-975d-11ec-8166-0800273b46ed'] = "Ensure you maintain clarity on your organization's vision by staying up to date and asking questions, especially if decisions and actions seem to be working against the vision as you understand it. Stay on top of key publications such as Annual Reports, the Corporate website, the Business Plan, etc.";
        $description['f2bb7ad0-69c5-4902-b3c8-a737dc6eb148']['Reconnect When Needed'][9][10]['dfd7eac0-975d-11ec-8166-0800273b46ed'] = "If at any time you have doubts or questions, direct them to your manager or an appropriate person/group like Internal Communications or even the CEO! Make a practice of periodically reminding yourself what achieving the vision would mean to the organization's stakeholders. How would employees, customers, vendors, the community, and shareholders benefit?";
        $description['1720f4e0-c0d0-4360-9e60-e73b1cb4b7db']['Create Personal Meaning'][9][10]['dfd7eac0-975d-11ec-8166-0800273b46ed'] = "As you think about the benefits, create a clear statement that connects you to what's meaningful about the organization's vision for you! For example, `I believe in my organization's vision because....";
        $description['4bed1f75-90eb-49f5-93df-dacad001680c']['Permit Yourself'][0][6]['dfd7f9ce-975d-11ec-8166-0800273b46ed'] = "People often deprive themselves of celebration. They sometimes feel they do not need it or that it is not appropriate in the workplace, at least in a commonplace way. However, celebration is a wonderful way to support your sense of meaning and to acknowledge your progress. Celebration energizes and creates resilience. It uplifts the spirit and fuels forward movement. It is important to create a habit of celebration. So begin by valuing it and reflecting on how it will support your enjoyment and fulfillment at work.";
        $description['38844c21-9226-4dec-a9cd-3a2302839b7d']['Keep an inventory'][0][6]['dfd7f9ce-975d-11ec-8166-0800273b46ed'] = "Make a list of ways you could celebrate your achievements at work. Everyone celebrates in different ways. For some people it may be a small, intimate gathering and for others more public. For some it might be a frequent event as they acknowledge small wins as well as milestones; for others, it might be less frequent but very special. Your list should be a reflection of ways you like to acknowledge your achievements.";
        $description['1d0ed5cc-62b8-4138-8461-bf5ecec1758c']['Make It a Daily Practice'][0][6]['dfd7f9ce-975d-11ec-8166-0800273b46ed'] = "Make celebration a daily practice. The habit of celebration will help you sustain your energy and interest in your work. For example, at the end of each day, identify one thing that you achieved that day that felt like meaningful progress. It doesn't have to be big. It could be that you achieve a task you had been putting off so give yourself a pat on the back for overcoming your procrastination. Or, perhaps you took an important step forward on a project that opened up new possibilities. Share your excitement with a colleague that you know will provide positive reinforcement and will be happy for you. And, when you have completed a project or a complex task, make sure you do something a little extra special. Maybe treat yourself to a lunch out with a colleague you particularly enjoy. Or, give yourself permission to take a well-deserved break when appropriate.";
        $description['ef433757-50a3-4115-a01f-aa5fb4215cab']['Create an Inventory'][7][8]['dfd7f9ce-975d-11ec-8166-0800273b46ed'] = "Make a list of the ways you currently celebrate and note when you typically celebrate. For example, do you have a reward system for yourself? Do you treat yourself after an achievement? Do you share your progress with colleagues so they can enjoy your `win` with you? Do you acknowledge meaningful advancements on a daily basis, such as the closing of a file with a private `Well done, mate!` Or, a private congratulatory mantra, such as `Another one down! Good for you!`";
        $description['3b96c1ab-0c09-4aa4-a125-e1830cab056b']['Build Capacity'][7][8]['dfd7f9ce-975d-11ec-8166-0800273b46ed'] = "Think about how you can build on your healthy acknowledgements of progress by thinking about other ways to celebrate.  Also consider other accomplishments that could be celebrated that currently go unnoticed or taken for-granted. For example, if you only celebrate the big stuff with a big party, think about how you could celebrate your small wins in a fun but meaningful way. Or, consider how you might acknowledge daily accomplishments with a celebratory spirit and modest but meaningful practice. Ask others how they celebrate their accomplishments so you can mine others' ideas. There are many ways to celebrate small and big successes so develop a range of approaches to boost your experience.";
        $description['203738d6-4bbc-427c-a926-9ccba12782bc']['Expand Your Repertoire'][9][10]['dfd7f9ce-975d-11ec-8166-0800273b46ed'] = "Ensure you are clear on the values of your team/organization and how they are defined in practice. For example, if integrity is a value, reflect on what behaviors represent integrity in the context of your organization. If you work in insurance, it might be expressed by ensuring claims are paid fairly and in a timely fashion, according to the contract. Values are not theoretical notions but are defined by behaviors that speak to how the work gets done within your organization.";
        $description['479e0db0-4cf7-4f55-a991-087711df280f']['Take An Inventory'][9][10]['dfd7f9ce-975d-11ec-8166-0800273b46ed'] = "Take an inventory of how and when you celebrate: Notice where you are consistently good at taking the opportunity to celebrate. Now think about areas that you may be neglecting. For example, do you forget to celebrate your small wins? Or, are you so busy that you move from project to project with only cursory celebrations rather than giving your `big wins` the acknowledgement they deserve? Or do you take for-granted some of your more routine or daily tasks and neglect to acknowledge how they contribute to your success? If so, each week or month select one of these more routine tasks and see how the routine task is worth celebrating. If nothing emerges, question whether the task should continue or not.";
        $description['95513f1b-ba57-4285-9d4f-c597cedc4c63']['Make Suggestions'][9][10]['dfd7f9ce-975d-11ec-8166-0800273b46ed'] = "Suggest to your team about how you might celebrate in meaningful ways together. It's important to have your own practices but it is also important to celebrate collective success or to have ways to celebrate each other's successes. For example, ask your manager to consider adding to your team meetings agenda an item around celebrating individual and team success stories. Perhaps you could open each meeting with a quick round table on `What I am most proud of accomplishing since our last team meeting` and applaud each other's contributions. Or, each week highlight the department's biggest `win` and toast to your success with sparkling water!";
        $description['7fa047bb-ad23-4a4e-a500-1f725895e3b9']['Make A List'][0][6]['dfd7eb2d-975d-11ec-8166-0800273b46ed'] = "Write down a list of your highest values (i.e., make note of your top three values). What are your non-negotiables? For example, if freedom is of high importance to you and you cannot imagine yourself without a significant amount of autonomy, freedom might be one of your highest values. This may take you some time to figure out, as it often requires deep reflection. You may also want to use the internet to help you. There are many free online values assessments that might be quite useful to you as you look to gain further clarity on this issue.";
        $description['e2427709-57ac-4127-ab6b-f5ffd2dc08b6']['Know Your Truth'][0][6]['dfd7eb2d-975d-11ec-8166-0800273b46ed'] = "Once you know your top three values, think about your work environment and ask yourself the following two questions? `In what ways am I able to live these values at work?`. Make a list of specific examples. For example, if my top value was freedom, I might list the areas in which I am free to make my own decisions at work. I may also think about the areas I am free to take initiative. Or, I might think about the flexibility I do have in terms of how I organize my day. `In what ways am I not able to live these values at work?`. Make a list of examples. For example, gain using freedom for comparison's sake, I might list the areas in which I do not have decision-making power or I might list the constraints that most bother me about the way the organization is structured, such as spending authority or other policies. Once you have completed your assessment, ask yourself if you can amplify the areas in which you are able to live your highest values and minimize the areas in which you feel conflicted. Spend the next little while reframing this for yourself as you move through your day.";
        $description['5ebf14d8-9555-434f-afdf-4c0386da6d75']['Engage in Conversation'][0][6]['dfd7eb2d-975d-11ec-8166-0800273b46ed'] = "Ask to meet with your manager about where you feel conflicted and see if, together, you cannot find a workable solution. Some of the constraints you see may not be as fixed as they seem. Also, your manager may be able to share a different perspective that will assist you in aligning your work activities with your personal values.";
        $description['244e33af-0ed2-4880-8ba7-37fde6fe897a']['Get Clarity'][7][8]['dfd7eb2d-975d-11ec-8166-0800273b46ed'] = "Begin by ensuring you are clear about your highest values. These are the ones you want to concentrate on as they will matter the most and will help you focus on what is most important. Make a list of your highest values (i.e., make note of your top three values). What are your non-negotiables? For example, if your end product is of high importance to you and you cannot imagine yourself cutting corners to deliver it, quality might be one of your highest values. This may take you some time to figure out as it often requires deep reflection. You may also want to use the internet to help you. There are many free online values assessments that might be quite useful to you as you look to gain further clarity on this issue.";
        $description['0f6b6b5f-ad89-4ed9-89e7-e29faeb8a192']['Create An Inventory'][7][8]['dfd7eb2d-975d-11ec-8166-0800273b46ed'] = "Now take an inventory of your three highest values. List all the ways you are able to be true to these values at work. We often take this alignment for-granted. In fact, many people only think about their values at work when they are facing a dilemma. However, to reinforce the alignment between your personal values and how you live at work, make the connections explicit. Look for ways to deepen this connection. Perhaps there are other opportunities to live your personal values at work through how you approach your work or by serving on special committees or projects.";
        $description['1eb8d9f7-93ca-4da4-8b2d-b293dd29d2a3']['Engage in Conversation'][7][8]['dfd7eb2d-975d-11ec-8166-0800273b46ed'] = "Your neutral score may be the result of a perceived conflict. For example, if your highest value is honesty but you feel your organizational culture promotes harmony to the exclusion of straight talk, you may question your ability to live your values at work. Whenever you find yourself in such a dilemma, open up the conversation with others. You might say, for instance, `I appreciate that our culture promotes harmony. How can we also ensure we do not inhibit people from expressing contrary views?` It does not have to be either/or; it can be both. It just might require some conversation.";
        $description['cce1e046-4020-4e70-835d-9e107ea7e7b7']['Determine Your Non-Negotiables'][9][10]['dfd7eb2d-975d-11ec-8166-0800273b46ed'] = "Determine your three to five top values in life. There are many free assessment tools on the web that would support your exploration. You may enjoy testing two or three and combining what resonates most for you. Search for “Free Values Assessment”.";
        $description['e673e4b9-9462-4da6-b4cb-84a9c041f4d2']['Confirm Alignment'][9][10]['dfd7eb2d-975d-11ec-8166-0800273b46ed'] = "Reflect on all the ways you are able to be true to your values at work. It is important not to take this for-granted to reinforce your sense of purpose at work. As you reflect, note what areas provide you with the greatest sense of fulfillment. Make a special note of these and consciously nurture these areas to protect them as a source of inspiration.";
        $description['e2c7a306-7b18-49f3-bc19-f795b7dd9e31']['Celebrate Real Examples'][9][10]['dfd7eb2d-975d-11ec-8166-0800273b46ed'] = "Celebrate when you experience strong alignment. For example, if you work in health care and the organization’s policy is to put patients first versus prioritizing financial results, look for opportunities to appreciate this.  Share your appreciations with others. You will reinforce what works for you and perhaps also inspire others!";
        $description['4e284f88-3bc2-4714-b3e7-a931ce0c8f04']['Find Touchpoints'][0][6]['dfd7e96e-975d-11ec-8166-0800273b46ed'] = "Identify ways you can access such information on a regular basis. For example, if you have team meetings, ask for a standing item about upcoming changes or other critical information. If you are the manager, take it upon yourself to seek out this information before your team meetings. If you are a team member, come prepared with questions so you can ask about specific things you have heard are happening or might be happening.";
        $description['667b51a7-8f41-4fe8-92e4-dde96c6690b1']['Seek Information'][0][6]['dfd7e96e-975d-11ec-8166-0800273b46ed'] = "Pay attention to organizational communications. Read your organization's press releases, annual reports and all other external communications. These are a great source for further questions to deepen your understanding. Also, read your intranet for all relevant internal communications. You will be surprised at the difference this will make. At the very least, it will inform your questions.";
        $description['62a1efef-e7a1-4a7b-94aa-812b5049e23d']['Engage with Others Who Know'][0][6]['dfd7e96e-975d-11ec-8166-0800273b46ed'] = "Seek out people in the organization that appear to be well informed. People are generally pleased that you view them as a valuable source of information and are usually happy to share. Start with people with whom you have existing relationships. The more informed you become the easier it is to reach out to others less familiar to you with well-crafted questions. You will gain respect from your peers and other colleagues for taking such initiative in a professional and thoughtful manner.";
        $description['2e491295-4006-49b5-8faf-79c131a1c0d4']['Take Initiative'][7][8]['dfd7e96e-975d-11ec-8166-0800273b46ed'] = "Pick an issue or topic on which being better informed would support your work. Then, speak to your manager about how to best inform yourself. Your manager may have the information, may help you access it or may make recommendations as to where it would exist. The key here is to take initiative and seek out the information you desire.";
        $description['9ed00a03-c8af-4478-9f93-034cc6fe952d']['Suggest Ways to Share'][7][8]['dfd7e96e-975d-11ec-8166-0800273b46ed'] = "Ask your manager to take time at each team meeting to discuss and invite questions regarding emerging organization-wide issues, changes or hot topics.  If you do not have team meetings, suggest you begin with a monthly team meeting and share the benefits to you and your colleagues of these information-sharing sessions. If you already have team meetings, ask that updates on upcoming changes and other critical information be added as a standing item. Even offer to lead the first discussion. You could invite a subject matter expert or a senior leader or you could inform yourself and present the information you have gathered. You could also offer to seek out answers to questions you cannot answer.";
        $description['cd6d1a87-b079-47a0-8fd7-53984a7a9e76']['Reach Out to Leaders'][7][8]['dfd7e96e-975d-11ec-8166-0800273b46ed'] = "If your organization does not have all-staff meetings or town hall meetings, offer this as a suggestion. Encourage your leadership to share information. Often, leaders do not realize how interested people are in the information and sometimes they do not appreciate how understanding a strategic decision will support your day-to-day decision making and sense of personal empowerment.";
        $description['a02ad355-bad5-4afa-9e7c-56b8e18d427c']['Take A Leadership Role'][9][10]['dfd7e96e-975d-11ec-8166-0800273b46ed'] = "When people on your team or other colleagues express concerns about a change or other critical issue and you have a perspective, based on information received, share it freely. Do not underestimate your ability to absorb and process information. You and your teammates may have heard or read the same information but you may have a different way of understanding the information that will be helpful to others.";
        $description['66c406fc-6cf3-4fe5-a7af-92a51b759e43']['Encourage Leaders to Share'][9][10]['dfd7e96e-975d-11ec-8166-0800273b46ed'] = "Encourage your leadership team to continue to share changes and critical information. Provide feedback that lets them know how helpful it is and why it matters to you and others. When leaders feel their investment in communications is appreciated and has benefits, they will be motivated to sustain or even increase it where appropriate.";
        $description['a750ca9a-1138-4bd4-bc11-331d6f73307f']['Offer Feedback on Gaps'][9][10]['dfd7e96e-975d-11ec-8166-0800273b46ed'] = "Where you see communication gaps, offer this insight to your manager or to the leadership team. Emphasize how past communications have been helpful (and how) and share why you think further information on these topics will be equally helpful. Leaders may not appreciate the importance of the communication or may not see the connections you see. Helping your leaders identify communication opportunities is an important way to sustain organizational communications.";
        $description['ad564c65-e832-474a-93f2-a3f4a95fa908']['Volunteer'][0][6]['dfd7e9fc-975d-11ec-8166-0800273b46ed'] = "Put yourself forward to sit on a committee that sets and/or influences policies. This will give you an insider's view and will be an excellent way for you to learn as well as contribute.";
        $description['c8b3ce1d-a0af-4597-8e4e-61a76636a34b']['Inform Yourself'][0][6]['dfd7e9fc-975d-11ec-8166-0800273b46ed'] = "Reread the employee handbook and seek out policies that could benefit you. For example, you may have the right to more learning and development than you realize or there may be a wellness program of which you could take advantage or perhaps you are entitled to more personal days off than you realize. Often we focus on the policies that we feel don't work well and miss out on opportunities to make the most of other policies provide.";
        $description['45ba81a5-5222-4762-b376-f53ce7e54a6d']['Suggest Easy Solutions'][0][6]['dfd7e9fc-975d-11ec-8166-0800273b46ed'] = "Select a policy that you know is irksome to you and your fellow employees but has an easy solution. Sometimes the senior leadership team does not understand the negative impact of a policy on engagement and so appears insensitive when, in fact, the leaders have not had appropriate feedback. Ask to meet with a manager/executive whom you know well and who you feel has influence. During this meeting, run your thoughts by him/her for input. Share that you want to support employee engagement and have a couple of ideas about how a particular policy could be modified to improve engagement without creating significant risk to the organization. End by asking for guidance about how to move your ideas forward.";
        $description['b9619069-9e29-4533-86f2-f7258ee85bd5']['Research to Understand'][7][8]['dfd7e9fc-975d-11ec-8166-0800273b46ed'] = "Seek out background information on policies that you view as not personnel friendly. Understand why the policies were created and why they were written in this way. Understanding the underlying issues or historical situations will reveal the reasoning behind the policy and will enable you to make informed comments and suggestions. As part of your investigation, learn what challenges have emerged in administering the policy. Human Resources is normally a great source for this information.";
        $description['6122292e-7a03-4249-bb45-db573fb4f40c']['Make Suggestions'][7][8]['dfd7e9fc-975d-11ec-8166-0800273b46ed'] = "Make suggestions to help the organization find a solution that suits its needs as well as helps to eliminate any downsides of a policy. All suggestions should be aimed at creating a win-win: addressing organizational concerns while supporting employee engagement. In order to begin this process, select a policy that you believe would meet little resistance if changes were suggested. It's always better to learn about how a change process might work by selecting a fairly straightforward item. Next, reflect on who might provide you with new and fresh ideas. Be careful to select people who you respect and who will also offer a different perspective. Creative thinking is always better by engaging diverse brains.";
        $description['33ff94c5-8345-4b96-8676-506777479254']['Find An Advocate'][7][8]['dfd7e9fc-975d-11ec-8166-0800273b46ed'] = "Find an advocate on the executive team or within Human Resources. Spend time with them sharing your views on a policy that significantly impacts engagement; and, most importantly, how you think a specific change would create a win-win solution. Speak positively and enthusiastically versus critically. In other words, don't put the existing policy down but show how a modification could give the organization and employee engagement a boost! It is important to highlight the benefits of the change for the organization first and then for the employee group second. Also remember to be patient. Change can take time. Building understanding takes time and working out the details takes time. This is an opportunity for you to lead and make your overall environment a better place. Stay focused on this purpose and accept the challenges as part of the process. Persevere and the rewards will come.";
        $description['552884eb-ee17-4c8a-8c27-3f4ea5e7aadd']['Be A Mentor'][9][10]['dfd7e9fc-975d-11ec-8166-0800273b46ed'] = "Consider sharing your views on policies that are controversial with colleagues. For example, if you hear colleagues complain about a particular policy and you have a different perspective on it, share your perspective so others have the opportunity to see it differently. Sometimes people only see issues from one angle and need a fresh perspective to change their own mindset. Acknowledging another point of view is important but sharing differences is also key: `I see why you might see it like that. I`ve always thought about it in this way….";
        $description['bea06675-0e15-4ec3-8eae-3cf7018194f5']['Provide Feedback'][9][10]['dfd7e9fc-975d-11ec-8166-0800273b46ed'] = "Provide feedback to the Human Resources team and to the senior leadership to let them know that you support the existing policies from an employee engagement point of view. Be specific as to why you think the organization has got it right and why the policies are, from your standpoint, personnel friendly. It is important for an organization to understand what's working well so they can continue to strengthen already good work.";
        $description['f14c9d84-c143-416c-aa59-c47177c1683f']['Influence Future Policies'][9][10]['dfd7e9fc-975d-11ec-8166-0800273b46ed'] = "Given you are not one to complain about the organization's policies, you are likely in a good position to influence future policies. Take the opportunity to offer input when you feel the organization is going off track with a policy. Always state what has made other policies so effective and what concerns you about the policy under consideration. And, of course, have a suggestion in your back pocket. Reflecting on what's working well enables you to express gratitude and to help guide the future policies as well.";
        $description['1f6dfa11-4cb4-4e53-91b3-a5ff6f3fc8e6']['Discuss Your Priorities'][0][6]['dfd7edf5-975d-11ec-8166-0800273b46ed'] = "Sit with your manager and discuss your priorities. Before setting this meeting, ensure you have documented your tasks and projects.  Rank them in order of importance. Beside each, indicate the time required for each.  When you meet with your manager, the most important facet of the discussion is to ensure you share the same view of your priorities and agree to the resources needed to serve these priorities. Next, discuss the other end of your list, the items that have lowest priority. You will want to change these from `have to dos` to `nice to dos`, given your current level of resourcing. Or, find alternative ways to achieve these goals; for example, reallocation across the team, a shared resources model, or a deferral. (There is also the foundation of a business case within this exercise. Essentially, you are illustrating what is doable within your employment contract and what is making it difficult for you to be successful.)";
        $description['3371bdf2-3181-41ff-b3ec-b0af41b49c1c']['Learn from Others'][0][6]['dfd7edf5-975d-11ec-8166-0800273b46ed'] = "Efficiency may hold an opportunity for you. All of us develop habits and ways of doing things that work at the time; however, we often neglect to revisit our processes and look for better ways to achieve the same end goal. Depending on your role, you may have colleagues that do similar work. If so, consult them on their ways of approaching the work. You may well discover someone else has a system that works better than yours and one which could help you. If this is not your situation, you can still gather input and feedback. For example, as a project manager, you could solicit your project team for ideas to run and work the project more efficiently. Or, if you are finding a particular task very time consuming, perhaps there are ways to automate aspects of it or perhaps you are not clear on the performance standard and you are going well beyond the requirements. It is always important to check performance standards. We often mean well by doing a job at 100% but in many cases the organization only needs 80% or even less, depending on the task.";
        $description['9885e13f-902e-49e6-b4eb-68ed6e9b806e']['Stop Multi-tasking!'][0][6]['dfd7edf5-975d-11ec-8166-0800273b46ed'] = "Time management is a hackneyed phrase but it still remains a challenge for many of us. For example, many of us constantly check emails during the day. Many studies have proven this to be ineffective. We work at our best when we stick to one task at a time. Multi-tasking has also been shown to be a myth. Our brains, although remarkable, can only handle one task at a time. Therefore, when you jump around tasks, you are asking your brain to stop one thing and begin another. This is inefficient. Track how you spend your time. Then look for ways to make the time you have as impactful as possible. How many meetings do you attend that do not contribute to your ability to add value? (Ask for the minutes but ask to be excused from attendance.) How often do you make yourself unavailable? (Post a little sign at your office entrance or book a meeting room and go work there.) Really look at how your day flows and how you are adding value.";
        $description['21a5e5fc-f29e-40c1-824f-693272ebd244']['Check-in On Priorities'][7][8]['dfd7edf5-975d-11ec-8166-0800273b46ed'] = "It is often helpful to have a conversation with your manager about your priorities. We often try to take on whatever is asked of us and before we know it, we are somewhat overwhelmed. Revisiting with your manager your top priorities and the resources required to deliver those keeps you both on the same page. You can then take the opportunity to discuss items that you do not feel add true value to your objectives or the organization generally.";
        $description['6cbe39ab-7cea-427d-87fe-2934b2652f8a']['Break Patterns'][7][8]['dfd7edf5-975d-11ec-8166-0800273b46ed'] = "All of us can work more efficiently, from revamping a process or two to reviewing our time-management practices. We all fall into patterns of behavior that help us conserve brainpower for more complicated tasks but sometimes these habitual patterns are inefficient and consume more of our resources than desirable. Spend a week tracking how you spend your day. There are lots of online templates for this. Then examine where we derive the most value. Also look at where you derive very little value. Aim to remove or restrict those activities that add little value. Finally, develop the habit of checking email only three times per day. Experts have studied the email phenomenon and determined this is one of the biggest time wasters! Examine your schedule and determine the most important times to check email, for example, for your work it may be mid-morning, early afternoon and toward the end of the day. You might even want to experiment with this to discover your optimal times.";
        $description['f57f44a1-f06f-4b38-95ce-de7394cad523']['Make Your Case'][7][8]['dfd7edf5-975d-11ec-8166-0800273b46ed'] = "If you are working on a task or project that has not been properly considered from a resourcing point of view, it may be time to do a business case. When compiling your business case, make sure you have lots of facts; for example, how many files come in during a typical week, how many hours on average it takes to work one file, what the service standards are for the work, how much time it takes to complete the process as per current standards but with X change, how much time it would then take, etc. These will be the foundation of your case and demonstrate that you are not simply whining about resources but have a business challenge.";
        $description['dc3c5b12-5125-408c-b17e-20cd3de271e1']['Check In Frequently'][9][10]['dfd7edf5-975d-11ec-8166-0800273b46ed'] = "Continue having conversions with your manager and team that maintain clarity around your priorities. Ensure you always know what is more important than what and (re)allocate your time accordingly. Often we hit a good groove and we become complacent and stop checking-in. Often surprises hit us down the road. So stay on top of this. It never hurts to ask your manager questions such as, `I am focusing here and here this quarter. Do these priorities still stand, based on what you know about the organization`s direction?` Or, even something as simple as `Using our current systems and processes, I am able to close 10 files per day. However, I only have an hour of additional time for other items. Currently, this means the following three objectives can be attained. Does that still suit our department`s needs?`";
        $description['cde8e9e1-5850-493f-9d05-d95adeeba805']['Create Capacity'][9][10]['dfd7edf5-975d-11ec-8166-0800273b46ed'] = "You may also want to be proactive about potential efficiencies. It's always nice to have a little extra capacity for new and exciting things! For example, you may want to review your time-management practices. We all fall into patterns of behavior that help us conserve brainpower for more complicated tasks, but sometimes these habitual patterns ultimately become inefficient. Also look at where you derive very little value. Aim to remove or restrict those activities that add little value. Finally, develop the habit of checking email only three times per day. Experts have studied the email phenomenon and determined this is one of the biggest time wasters! Examine your schedule and determine the most important times to check email, for example, for your work it may be mid-morning, early afternoon and toward the end of the day.";
        $description['1139b21b-691e-4e0c-91cb-cad288bd85ed']['Be Deliberate'][9][10]['dfd7edf5-975d-11ec-8166-0800273b46ed'] = "Keep a close eye on how resources are allocated to your projects or to activities with which you are involved. You want to ensure the discipline of properly allocating resources continues. Be vigilant to preserve your currently positive situation. If you have concerns about resourcing issues emerging down the road on a project or work task, be proactive and begin the conversations now. Collect the data you need to support your views. You will then always be in the best position to deal with resourcing challenges if and when they come.";
        $description['51795821-7532-4b73-bc76-6ac246ded945']['Begin With Yourself'][0][6]['dfd7eb81-975d-11ec-8166-0800273b46ed'] = "How do you currently promote high-quality work? Do you share positive client (internal or external) feedback with your manager/team, especially when quality work is being congratulated? Do you track the impact of the work when you go the extra mile? Share success stories! It helps raise the bar for others.";
        $description['9686f7fc-26e3-4d5e-94a9-1092b303a0a9']['Influence Your Team'][0][6]['dfd7eb81-975d-11ec-8166-0800273b46ed'] = "Pay attention to team discussions and decision-making. Does your team make its decisions based on company values around service? Do you speak up when you think a decision will compromise quality or contradict company values?";
        $description['ce04be3f-19f0-4d28-a793-4439eaccc69e']['Think About Interdependencies'][0][6]['dfd7eb81-975d-11ec-8166-0800273b46ed'] = "What departments receive your work? To which departments do you give your work? What are the opportunities to raise the bar of quality work across the organization? Is there a process you could improve that would improve quality work? Is there a way to measure and build in accountabilities so that everyone along the value chain can deliver to the appropriate standard? Discuss your ideas with your manager and team. You may find that people will join you on promoting high-quality work across the organization.";
        $description['dc5c21ac-2d0c-4b45-9122-4fd0795fc682']['Begin With Yourself'][7][8]['dfd7eb81-975d-11ec-8166-0800273b46ed'] = "How do you currently promote high-quality work? Do you share positive client (internal or external) feedback with your manager/team, especially when quality work is being congratulated? Do you track the impact of the work when you go the extra mile? Share success stories! It helps raise the bar for others.";
        $description['c68de59d-330e-4c64-ab4e-00be7f1185e2']['Influence Your Team'][7][8]['dfd7eb81-975d-11ec-8166-0800273b46ed'] = "Pay attention to team discussions and decision-making. Does your team make its decisions based on company values around service? Do you speak up when you think a decision will compromise quality or contradict company values?";
        $description['8867c2f7-8a7a-475b-9d53-6033fb95020d']['Think About Interdependencies'][7][8]['dfd7eb81-975d-11ec-8166-0800273b46ed'] = "What departments receive your work? To which departments do you give your work? What are the opportunities to raise the bar of quality work across the organization? Is there a process you could improve that would improve quality work? Is there a way to measure and build in accountabilities so that everyone along the value chain can deliver to the appropriate standard? Discuss your ideas with your manager and team. You may find that people will join you on promoting high-quality work across the organization.";
        $description['0e5b2cec-0a34-4b35-8841-2aa188fb6e47']['Begin With Yourself'][9][10]['dfd7eb81-975d-11ec-8166-0800273b46ed'] = "How do you currently promote high-quality work? Do you share positive client (internal or external) feedback with your manager/team, especially when quality work is being congratulated? Do you track the impact of the work when you go the extra mile? Share success stories! It helps raise the bar for others.";
        $description['25c404bb-36db-4e5b-9e98-5e62d51b6c2c']['Influence Your Team'][9][10]['dfd7eb81-975d-11ec-8166-0800273b46ed'] = "Pay attention to team discussions and decision-making. Does your team make its decisions based on company values around service? Do you speak up when you think a decision will compromise quality or contradict company values?";
        $description['ddfeebd5-6b9a-4256-89b7-0994f4e998d6']['Notice your interdependencies.'][9][10]['dfd7eb81-975d-11ec-8166-0800273b46ed'] = "What departments receive your work? To which departments do you give your work? What are the opportunities to raise the bar of quality work across the organization? Is there a process you could improve that would improve quality work? Is there a way to measure and build in accountabilities so that everyone along the value chain can deliver to the appropriate standard? Discuss your ideas with your manager and team. You may find that people will join you on promoting high-quality work across the organization.";
        $description['ba9d588a-25c8-4a26-9bd9-f90175b33f2d']['Start Small But Meaningful'][0][6]['dfd7ebf6-975d-11ec-8166-0800273b46ed'] = "Notice when you have a view that you would like to share because you think it would be helpful in the decision-making process. Take the opportunity to share your input by identifying an influencer or person responsible that could benefit from your insight and is open to hearing diverse views.  You will begin to establish yourself as a person who looks at the bigger picture and cares about the decisions made. Starting small, but in a meaningful way leads to progress. ";
        $description['43239264-ba7b-4876-89c0-6b0758fc0322']['Volunteer to Help'][0][6]['dfd7ebf6-975d-11ec-8166-0800273b46ed'] = "Think about the things that matter to you at work. Are there any committees or project teams working on these items? Is there an opportunity to volunteer to have a greater voice?";
        $description['452002ed-5ddd-4d3f-b667-c519af551383']['Decide to Make Meetings Matter'][0][6]['dfd7ebf6-975d-11ec-8166-0800273b46ed'] = "Most of us at work attend many meetings. This is a perfect opportunity to provide input and suggest input is gathered from others. Does your organization have all-staff meetings? Does your department? Is there a Question & Answer Period? Perhaps you can suggest to the meeting organizer that the agenda is designed in such a way as to be able to gather input and feedback from those attending (e.g., small group discussion exercises that produce feedback)? And, you could suggest why it might be helpful to do so. Have others, who wish greater involvement, do the same. Influencers will notice and hopefully begin to take action.";
        $description['c9ec1af7-a71a-4d31-bd90-b1110faf4f99']['Share & Encourage'][7][8]['dfd7ebf6-975d-11ec-8166-0800273b46ed'] = "Look for opportunities, personally, to share your views and knowledge. Encourage others to do the same. When this is done in a helpful manner, people will appreciate your caring and concern. Be proactive in offering your input. It's easy to answer questions when asked but this is passive as you are waiting for others to approach you. Try taking the lead in support of the organization's wellbeing.";
        $description['1470855b-2eb5-449e-ba99-cbffe00702fc']['Connect With Influencers'][7][8]['dfd7ebf6-975d-11ec-8166-0800273b46ed'] = "Find the key influencers in the area of employee communications. It could be a Communications Manager, an HR Head, or a line of business manager that is passionate about inclusive communications. Then, set up times formally or informally to share with them the successes you've seen in the workplace when employee input is sought. Encourage more of this to happen. Based on what is going on in the organization, suggest areas or topics where this would be currently helpful.";
        $description['d8301dbe-b2d4-497d-9613-ca143eda6da4']['Explore Upward Feedback'][7][8]['dfd7ebf6-975d-11ec-8166-0800273b46ed'] = "Observe the mechanism for upward feedback in your workplace. How does the leadership team inform themselves? Perhaps there is a manager that has established a clear practice in his/her unit that others could also use? Consider how to implement on your team. Begin by asking your manager what input would help him/her with their objectives. Learn what keeps him/her up at night and rally the team around these issues, offering input as is beneficial.";
        $description['dfdda3f5-9a3b-451d-9c67-91225022ce2c']['Talk It Up!'][9][10]['dfd7ebf6-975d-11ec-8166-0800273b46ed'] = "Look for opportunities to highlight the benefits you see of how the organization currently seeks input. Reinforcing what's working helps sustain a practice. Don't take it for-granted or let others take it for-granted. It's a key driver of employee engagement. In other words, talk it up! Often organizations wane on communications because the leadership isn't getting enough feedback on its importance or impact.";
        $description['b282494b-9c2e-49f7-a492-2615a3837472']['Highlight Examples'][9][10]['dfd7ebf6-975d-11ec-8166-0800273b46ed'] = "Help the organization or your team to take time to celebrate successes that have included a process that gathered input from employees. This will let the employees know how their contributions helped create a success and it will reinforce the benefits of this process. Even more importantly, when input has averted a problem, celebrate that! If you are a manager you can certainly adopt these practices within your team. If you are an employee, you can highlight the value of a colleague's input to lead by example.";
        $description['b8f6c53f-e9b7-4a6a-9779-5f9896d37dcc']['Explore Fresh Ideas'][9][10]['dfd7ebf6-975d-11ec-8166-0800273b46ed'] = "Explore fresh ideas for gathering input. To sustain this degree of effort needs feedback but it also needs to be kept fresh. Suggest new ways input could be gathered within your team or across the organization and have some fun with it. There are good online resources for facilitating employee input. Check them out and see what might work within your organization. Keeping it fresh is important!";
        $description['6e157a60-93ca-45d3-bf98-fa3e11fae82e']['Be Proactive'][0][6]['dfd7f2bb-975d-11ec-8166-0800273b46ed'] = "The main strategy here is to be proactive! Don't wait for someone to give you feedback but consider what feedback you need and then go get it! Spend some time thinking about the type of feedback that would help you: - Perhaps there is a project with unclear parameters and end goals and you want to know if you are properly aligned; - Perhaps your current work seems never-ending or complicated and you need someone to help you see and appreciate the progress you are making; - Or, perhaps you have been doing the same job for a long time and you feel that you are efficient but never hear either way. Once you know what feedback you need, set a time to meet with the person best able to give you that feedback. It may be your manager or a project lead or a client. Be in the driver's seat when it comes to feedback!";
        $description['1f480c49-9030-42f4-a6da-fb1a37a1895e']['Create a Career Map'][0][6]['dfd7f2bb-975d-11ec-8166-0800273b46ed'] = "We also need feedback on our career path. Research the available resources within your workplace but also within the community.  Speak to people within your Human Resources department. Create a clear picture of where you want to be and create an action plan that will get you there. Also meet with your manager to share your aspirations and to ask for his/her support and take the opportunity to get feedback on what you need to work on to move in this direction. Whenever you have performance review meetings, include a discussion on your career path and always ask for feedback at this time. Between sessions, action the feedback to demonstrate that you were listening and you are open and appreciative of the feedback.";
        $description['9bf79fe8-f9c9-4b58-84d2-1705a62c0f82']['Take Ownership'][0][6]['dfd7f2bb-975d-11ec-8166-0800273b46ed'] = "Often people become over-dependent on their manager for feedback but you may have a manager that does not possess the leadership style that is inclined to give feedback.  You should ask for the feedback you need, as per our first strategy; however, you also want to find other sources of feedback: - Perhaps there is someone you could ask to mentor you; or, - Seek out colleagues you respect and ask them for their insights; or, - Meet with those with whom you have some friction, as they will be a great source of feedback, especially for developmental needs. Chances are they have preferences different than your own and they will help you see possible blind spots. Normalizing feedback is an essential element of engagement and success. Enjoy the journey!";
        $description['dd4726bd-a847-4893-9ac0-c50111503b4a']['Normalize feedback'][7][8]['dfd7f2bb-975d-11ec-8166-0800273b46ed'] = "Make it a part of every significant conversation. When meeting with your manager for an update meeting, ensure you ask for feedback on all the objectives discussed. Does your manager feel you are on track? Is there anything that your manager feels you could do differently? What significant progress has your manager observed? What areas are moving along well and which ones are of concern? Mix it up and ask different questions but make sure you take the opportunity to get the feedback you need to support your success. If you don't have regular update meetings with your manager, book time in your manager's calendar for a monthly catch-up. Even if your work is routine, meeting monthly provides the opportunity to suggest changes, provide internal/external client feedback, raise issues of concern for you or show appreciations. Make time to meet one-on-one!";
        $description['5f63b932-faa4-462e-a9a6-e6a52cfe8129']['Create A Development Plan'][7][8]['dfd7f2bb-975d-11ec-8166-0800273b46ed'] = "Ensure you have a development plan. Make it specific and outline the key activities for the year. Do not wait for your manager to do this for you. Instead, think about your long-term aspirations (or short term) and create a number of action steps that you could take that would help you get there and then share with your manager. Incorporate your manager's feedback and then revisit during all your performance appraisal meetings.";
        $description['c73daf7e-653a-4224-ae32-43e0b6d622b4']['Seek Feedback'][7][8]['dfd7f2bb-975d-11ec-8166-0800273b46ed'] = "We often over-rely on our managers for feedback. Seek out others with whom you interact. Ask their views on your strengths and your areas of improvement. Or, speak about specific work: ask them about what is working well and what could use improvement. For those who receive your work as part of their deliverable, ask them how you could make their job easier. Feedback is designed to help everyone deliver a better product and to help support long-term aspirations. Be in control of your feedback and ask for it frequently!";
        $description['856fc33f-4af1-4869-8a36-5f5aacc8ae97']['Beware Of Complacency.'][9][10]['dfd7f2bb-975d-11ec-8166-0800273b46ed'] = "When we are receiving feedback regularly, it is easy to take it for-granted. Always express your appreciation of the feedback and state how it will be helpful. When people know it's valuable, they will gladly continue to offer it. Nurture it with appreciation.";
        $description['3bf3134b-71f9-458e-a29e-1a6fb511089c']['Be Proactive'][9][10]['dfd7f2bb-975d-11ec-8166-0800273b46ed'] = "At the earliest sign that something is off track, ask a question. Often people will offer hints or clues versus direct comments when things begin to go a little off course. As soon as you are aware that there has been a slight shift, have a discussion and ask for direct feedback. Nipping things in the bud is always a smart strategy. Letting things build is not.";
        $description['f7f5b304-912d-4315-954e-0d1beefbce5e']['Celebrate Successes'][9][10]['dfd7f2bb-975d-11ec-8166-0800273b46ed'] = "Acknowledging progress and achievement is a form of feedback. It tells you that you have hit a milestone that is meaningful and has impact. Don't let your wins, big or small, pass by unacknowledged. Celebration is a key motivator of engagement in its own right but it is also a form of feedback.";
        $description['38d6c2a6-5323-4a34-a215-b1c20a58c955']['Focus on Current Connections'][0][6]['dfd7ed7d-975d-11ec-8166-0800273b46ed'] = "Focus on the people with whom you do have a connection, even a modest one. Nurture those relationships. Refrain from gossiping about any team member (i.e., speaking about them in any way negative or undermining when they are not within earshot). Then, once you have your foundation, slowly begin to reach out to others. Look for opportunities to interact. Notice when they have done something well and compliment them. Encourage them. Help them when you can. Even if you are very different people, having a positive, cordial relationship at work makes everyone's life more pleasant.";
        $description['a0e5ae7b-c92a-4df8-be21-b353401bdad4']['Invite Challenge'][0][6]['dfd7ed7d-975d-11ec-8166-0800273b46ed'] = "It's great when people agree with you but it can be even better when people challenge your current way of thinking or doing something. If you do not feel people are helping you grow and develop then ask for their input. Invite challenge. Let people know you want to stretch. People will oblige and it will also help build better connections.";
        $description['bfea4201-cc49-463b-88a3-f4060f977ed4']['Offer to Support'][0][6]['dfd7ed7d-975d-11ec-8166-0800273b46ed'] = "If you feel team dynamics are poor, raise this with your manager. Ask the manager if s/he could work with the team to address this. Research is clear: teamwork improves individual and collective performance. If the team can become more cohesive, the organization wins and people become more engaged and happier at work. If you are the manager, seek out support within your organization from areas such as Human Resources. They will find a way to support you and your team.";
        $description['35ed4e8e-0fb3-4e33-8ec1-b46e5aeb3058']['Make Suggestions'][7][8]['dfd7ed7d-975d-11ec-8166-0800273b46ed'] = "Frequently, teams do not meet often enough and when they do the meetings are not very meaningful. If this is the case, suggest to your manager how current team meetings could be made more meaningful. For example: Perhaps people sit and listen more than discuss so, to engage the team more, design the agenda to stimulate discussion and healthy debate. Or, if the team rarely meets, suggesting a monthly or bi-weekly meeting with interesting agenda topics (not just operational updates) such as: Big picture items that relate to strategy and the market so people feel and know what they are a part of; Team operational concerns so that processes and systems can be continuously improved; Upcoming changes that may or may not impact them but are still good to know and help people feel like they know what's going on; and so on.";
        $description['78007d4c-7389-4b7d-afc0-84846cef75af']['Be A Champion'][7][8]['dfd7ed7d-975d-11ec-8166-0800273b46ed'] = "Promote the idea of a team-working session that actually deals with why the team functions as it does and how they could leverage the team talent and current way of working to take the team to another level. Build on what's working, celebrate that, and look for ways to develop collectively. Team relationships are like any other relationships: they need investment of energy and time. A great way to promote this is to build this into another agenda. For example, if it is the time of year to plan or review, suggest a team meeting designed with this as an objective and complement that objective with team development work as well. Make it clear that the type of team building you are promoting is designed to build performance and to help everyone engage just a little more.";
        $description['1b85004e-98c1-4323-881a-34cd15c3d628']['Be A Team Builder'][7][8]['dfd7ed7d-975d-11ec-8166-0800273b46ed'] = "You alone can also make a difference. To build deeper support across the team, continue to nurture those relationships that are already strong. Then, look for opportunities to interact more with the others on the team. Notice when they have done something well and compliment them. Encourage them. If you are very different people, this is even better! Diversity helps teams get to the next level. The key is to start seeing that another point of view deepens the conversation and helps everyone think through the issue.";
        $description['85e2a096-cf4c-4bf7-807f-ce6280fd89b0']['Celebrate Together!'][9][10]['dfd7ed7d-975d-11ec-8166-0800273b46ed'] = "Teams that are high performing also become very work-focused. This is positive of course, but to keep the team strong, ensure you celebrate your individual and collective successes. Even small but meaningful milestones are worthy. And have fun! Laughter at work uplifts, replenishes and is good for your health too!";
        $description['53cd9475-80cb-429e-a0fa-c0d40abb225f']['Build Resilience'][9][10]['dfd7ed7d-975d-11ec-8166-0800273b46ed'] = "When teams are strong, it's important to ensure they take the opportunity to deepen their well so that when challenges arise, the team has emotional resources available to them and can dig deep. You can build resilience by developing practices that train people to see what's working, to notice and appreciate the lessons learned even within successes, and to ensure everyone is practicing self-care.";
        $description['8fa1f960-7b43-4113-a636-2c120a0312e4']['Consider Team Dynamics'][9][10]['dfd7ed7d-975d-11ec-8166-0800273b46ed'] = "Although your team is strong, are there any early warning signals? Or perhaps there is a long-standing issue that has never been properly addressed? Or, although everyone supports each other emotionally, perhaps there is little collaboration around work? If you have insight that would help your manager take the team to the next level, share it with him/her and suggest you dedicate time at your next team meeting to discuss team dynamics and how to sustain it or perhaps even take it to another level.";
        $description['8c72eff4-386a-4075-99c4-9330c84d1ce2']['Identify Who Needs Your Work'][0][6]['dfd7eca1-975d-11ec-8166-0800273b46ed'] = "Everyone needs to have a sense that his/her work matters to someone. No one wants to come to work every day and waste his/her time on pointless work. It is important to understand where you sit in the value chain. The best place to start is think of who receives your work: Is it a colleague? Is it another department? Is it your manager? And then ask yourself, who benefits the most from my work? Once you have identified your critical others, consider creating a statement that connects you to what matters most and to whom.";
        $description['c18448d8-e993-4855-95b7-31e100c00691']['Create a “My Value” statement'][0][6]['dfd7eca1-975d-11ec-8166-0800273b46ed'] = "Create a statement for yourself that functions as an affirmation and reminder of how you add value. Word it in a way that explains the way in which you add value. Why do colleagues/clients need what you produce? How do they use the work you have produced and for what purpose? How does your piece of work contribute to the work of the department/company? ";
        $description['235d0662-f918-4a78-b995-2342d0a106ba']['Consider New Ways to Add Value'][0][6]['dfd7eca1-975d-11ec-8166-0800273b46ed'] = "If you feel your work deliverables lack substance or impact relative to the company purpose of mission, the best thing you can do is to think about new ways to add value. Each day, we all have an opportunity to raise our game: 
        •	To think of a way to deliver the product of our work differently so those receiving our work can more easily use it
        •	To look at how we allocate our time and adjust to ensure our time is spent on the tasks that add the greatest value
        •	To see a gap and a need that we can fill within the parameters of our role and then do so!
        ";
        $description['668c642b-ea04-4d31-bb0d-b2c59381736a']['Explore a Change with Your Manager'][0][6]['dfd7eca1-975d-11ec-8166-0800273b46ed'] = "If you feel your work is not terribly important relative to the purpose or mission of the company, have a discussion with your manager. S/he may have a perspective or information that is not visible to you. Or, you may both discover that there are better ways for you to add value. This is an important conversation to have within the context of engagement at work. All of us want to make a contribution to something.";
        $description['e5436661-956a-4a2d-8a08-83c6b5123287']['Consider New Ways To Add Value'][7][8]['dfd7eca1-975d-11ec-8166-0800273b46ed'] = "Conceive of new ways of delivering your product to add greater value to boost the importance of your work. Seeing new possibilities in your work stimulates key drivers of engagement. Ask yourself these questions to help you think this through: How could the process be improved? How could the product be improved? How could the work be segmented and reallocated to have better impact?";
        $description['b051e0cf-424e-4e10-96f2-5aa1f724dc81']['Get Feedback!'][7][8]['dfd7eca1-975d-11ec-8166-0800273b46ed'] = "Ask those who receive your work how you could increase your value to them. Ask them how they see their work contributing to the purpose or mission of the company. We should all be connected in meaningful ways to the purpose of our company. It doesn't matter where we are in the chain. It just matters that we are in the chain! We are building something together and big or small our work should be making a meaningful contribution.";
        $description['26a715dd-c6cd-486b-afa8-a1bc78c1a323']['Create a “My Value” statement'][9][10]['dfd7eca1-975d-11ec-8166-0800273b46ed'] = "A great place to start is to think about the organization's value chain. You see how you add value but it might be valuable to really think it through. At the very least it will affirm how you currently view your work or it may reveal other facets or an importance you currently haven't thought about. What value does your work represent? Who receives your work from you and what value does it give them? Who else benefits from it? Once you have identified your critical others, consider creating a statement that connects you to what matters most and to whom.";
        $description['d1962114-6293-4262-bc5e-77943a3fe410']['Consider New Ways to Add Value:'][9][10]['dfd7eca1-975d-11ec-8166-0800273b46ed'] = "Sustain the importance of your work, relative to your organization's mission statement, to ensure you do not become complacent. Remember the market and the organization are always changing and new needs emerging. Therefore, occasionally, take time to conceive of new ways of delivering your product to add greater value, relative to the organization's purpose. Seeing new possibilities in your work stimulates key drivers of engagement. Ask yourself these questions to help you think this through: How could the process be made more efficient? How could the product be more greatly aligned to the expressed needs of those receiving the work? How could the work be segmented and reallocated to have better impact?";
        $description['f40a5ae4-a158-4d16-a62f-22a8c97b6b26']['Get feedback!'][9][10]['dfd7eca1-975d-11ec-8166-0800273b46ed'] = "Ask those who receive work from you how you could increase the value of your work to them. Ask them how they see their work contributing to the purpose or mission of the company, especially as it regards the work into which you feed. It's affirming to take a moment to appreciate more fully how our work benefits the organizational value chain.";
        $description['5b42b044-02ac-4e5e-93d0-a6f8c097aeda']['Do A Skills Assessment'][0][6]['dfd7fe85-975d-11ec-8166-0800273b46ed'] = "Identify the skills you currently possess that are assets in doing your work. List these on the left-hand side of a piece of paper. Then, on the right-hand side, list all of the skills you feel require development. Once you are satisfied all skills have been listed, rank order them in order of importance: the ones that are deficient in some way but are critical (highest importance) to doing your job well to those that might be `nice to haves` (lowest importance). Now update (or create) your Learning & Development Plan to include those that are most critical.";
        $description['06f0aa80-ff4e-4a3b-a7ee-d39ace24ef06']['Request A Manager/Colleague Check-In'][0][6]['dfd7fe85-975d-11ec-8166-0800273b46ed'] = "Speak to your manager and others that work closely with you to share with them the skills you believe you need to acquire. Ask for their feedback. Do they see it the same way you do? They may have a different perspective. It is especially important when it comes to identifying your core strengths and most needed development areas. You don't want to spend a lot of time developing a skill that others do not see as critical to your success. Once you feel there is consensus and clarity, update (or create) your Learning & Development Plan to include those that are most critical.";
        $description['4e282ac7-6dd8-42c1-b435-c7c3e1be2e51']['Create An Action Plan'][0][6]['dfd7fe85-975d-11ec-8166-0800273b46ed'] = "If you know your core strengths and critical development areas, it's important to have and action plan. Research has proven that building on existing strengths is a key to success. Equally, if a skill is critical to a job well done then developing in that area is a must. Pick one strength and one critical development area. Consider and research, if needed, ways you can develop these skills. Do you see these skills well developed in others? Would they be willing to help you boost your skillset? Are there in-house programs that you could apply for that target these areas?  What about external courses? Ensure you speak to Human Resources as well. They will likely know of available resources. Do not wait for others to equip you to do your job. Go after what you need. And if there is no budget for training, then get creative and find ways to learn the skills on the job. When people see your commitment, they will be motivated to help you.";
        $description['a1b7e116-6b85-49c6-9dd9-da1b7000cb5e']['Consider Your Strengths & Challenges'][7][8]['dfd7fe85-975d-11ec-8166-0800273b46ed'] = "When are you most comfortable in your work? When do you feel most confident? When do you feel the opposite? Or less secure? When is the challenge fun, because you have the requisite skills to meet the challenge at hand? And when is the challenge stressful, because you feel you lack the skill to deal with the situation appropriately? Spend some time observing yourself. Become familiar with your strengths and with possible development areas.";
        $description['2630e86a-f458-4474-bf0b-8498e0008889']['Identify A Focus Area'][7][8]['dfd7fe85-975d-11ec-8166-0800273b46ed'] = "Focus on the area that you feel would benefit you the most and would increase your ease, confidence and results in your work. It is always good to seek feedback when determining an area of focus. What you perceive to be a critical area may appear differently to others and they may have other suggestions to support a job well done. Always discuss your development with your manager as well. You will want his/her support as you pursue skill development. Once you are clear on your focus, you are ready to take action.";
        $description['0b0d6643-d541-4dd3-9f38-0fcb76886d7b']['Create An Action Plan'][7][8]['dfd7fe85-975d-11ec-8166-0800273b46ed'] = "Determine the best way to develop the skill. Would you learn best on-the-job, being mentored, online or in a traditional classroom environment? Constraints like budget may have an impact on your choices but do not let that deter you. Speak to Human Resources, your manager, and people in the community to discover all of the available resources. Then, commit to an action plan and follow it through and enjoy how good it feels to close gaps.";
        $description['a03d494e-38d0-493e-bf69-d2bf780d071b']['Identify Your Game Changer'][9][10]['dfd7fe85-975d-11ec-8166-0800273b46ed'] = "Focus in on the area that you feel would benefit you the most and would increase your ease, confidence and results. What skill, if acquired or further developed, would be a game changer for you? What skill, if pursued, would open up new possibilities for you? Think about the direction in which you want to grow. Learning is always exciting and given you are well skilled for your current role, thinking about what's next may be a refreshing change!";
        $description['467d80ee-fa76-45ed-add4-4e5c0a29db9a']['Develop Self-Awareness'][9][10]['dfd7fe85-975d-11ec-8166-0800273b46ed'] = "Many experts agree that excellence comes from leveraging your strengths not always addressing weaker areas. You may want to ask your manager, colleagues and friends the following questions: 
        a.	What do you see as my greatest strengths at work? 
        b.	And, what strength, if I were to fully commit to its development, might provide the greatest benefit to myself and to the organization? 
        c.	What do you feel holds me back? 
        d.	What skill, if developed, would help me grow personally and would best support the organization? 
        e.	What skill, if developed, would help me progress in my career?
        ";
        $description['7f9219bc-ce88-4128-bfc7-367c4c43b0e4']['Reflect On Feedback'][9][10]['dfd7fe85-975d-11ec-8166-0800273b46ed'] = "Take some time to ponder all feedback you have received over your career to date. Reflection is a wonderful thing. As you think about others' perspective, connect with your greatest aspirations. Think beyond your current job and role. Think long term. Then select the area of focus that will help you achieve your greatest aspirations. You'll never regret the time and effort spent on something that matters that much.";
        $description['6c54a7b7-d476-494f-9f27-c8b75e876684']['Be specific'][0][6]['dfd7fe18-975d-11ec-8166-0800273b46ed'] = "Your knowledge encompasses what you know about a particular field. It is the facts and information that form the basis of action. Knowledge is acquired through experience and education. What knowledge would you like to acquire? Gain clarity on what specific information and/or experience. Know what you need and what you want. Then ask for it. Always begin with what will help you excel in your current role. Be clear on why this knowledge will help you excel.";
        $description['5c7e53ee-9169-4757-9255-122606f78985']['Ask for support'][0][6]['dfd7fe18-975d-11ec-8166-0800273b46ed'] = "Ask people to have coffee with you. Ask them questions about how you might acquire the information or if they have this expertise, ask them if they would be willing to share. Create a network of people who have the knowledge of which you are in pursuit. Spend time with them. Listen to them and ask questions. You will be amazed at people's generosity and your ability to absorb the facts and information.";
        $description['cd949255-98b7-4c6d-85fd-e4a742cdc3d4']['Conduct Research'][0][6]['dfd7fe18-975d-11ec-8166-0800273b46ed'] = "We are living in the Information Age. Go online and seek out resources. Spend time reading. Listen to online experts speak about the topic. Discuss your findings with others (online or in person) to gain their perspective and to clarify your understanding. It's fun to acquire knowledge. Enjoy the journey!";
        $description['3d1e2b67-dbea-4377-8eeb-c70a56576be1']['Ask, Ask, Ask'][7][8]['dfd7fe18-975d-11ec-8166-0800273b46ed'] = "Your knowledge is the facts and information that form the basis of action. Begin by asking yourself what knowledge you would need to excel? What knowledge would take you from average to above average? Does it involve a designation or a certification? If so, what are your options? What programs are available online? Do local colleges offer what you need? Or, is it experience-based knowledge? How might you create opportunities for yourself?";
        $description['553ba629-70e9-4dcb-811d-b4dd8d988640']['Read, Read, Read'][7][8]['dfd7fe18-975d-11ec-8166-0800273b46ed'] = "Do not wait to be spoon fed. In this Information Age, we can self-educate quite easily. At the very least, we can learn enough to know what questions to ask and what topics to pursue. Be proactive and diligent.";
        $description['18cd03c8-653b-4bc5-845b-99ccfed7d56f']['Network, Network, Network.'][7][8]['dfd7fe18-975d-11ec-8166-0800273b46ed'] = ". Join communities where the knowledge you wish to acquire is plentiful. Immerse yourself for periods of time so you are able to absorb the knowledge that surrounds you. Take time to document your learnings and insights for reference purposes and for reflection at a later date.";
        $description['bec0500e-86e2-40e9-88e6-15ceaec1cf61']['Mentor'][9][10]['dfd7fe18-975d-11ec-8166-0800273b46ed'] = "Consider mentoring others who still need to acquire the knowledge you possess. Sharing what we know can be deeply satisfying. Offer to train the new kid on the block or a long-time colleague who would like to develop.";
        $description['5ea0faa7-d59c-4642-80bd-e32984b7d8b5']['Offer To Collaborate'][9][10]['dfd7fe18-975d-11ec-8166-0800273b46ed'] = "With your knowledge base, you are in a good position to undertake a joint venture! You will be able to offer insight and also be able to play with new ideas. You can take your foundation and go beyond the obvious to create and innovate.";
        $description['6e82fb06-e1b6-4422-94f1-bfa19aa0875b']['Challenge Yourself'][9][10]['dfd7fe18-975d-11ec-8166-0800273b46ed'] = "You may be ready for another challenge. Your current knowledge allows you to excel in your current work but what's next? What new frontier would you like to tackle? Or, what is the next level of mastery in your field? Perhaps you would like to take on a teaching role? Or perhaps a specialty appeals? Life-long learning keeps us energized and enables us to reach new goals or new heights. Take some time to consider your next learning journey.";
        $description['02e8badb-c23e-4765-8b78-c718234b9b24']['Learn About Creativity'][0][6]['dfd7f94b-975d-11ec-8166-0800273b46ed'] = "As you do not feel able, in any significant way, to be creative in the way you work, it may be because you perceive the parameters of your current work do not allow for this, or it may be that you feel you do not have the skills needed to be creative. Brain research has proven we all have the potential to be creative. However, it's like any muscle, it needs exercise. We also know that some people develop this skillset early in life. Regardless of your abilities, you have the raw material required to be creative in any circumstance. Sure, some situations will be easier than others. Some of us have carte blanche at work and others of us work within tight parameters. But being creative is about imagining things. We all have imaginations and we can all imagine. So step one is recognizing that you have a creative brain that can be applied to any situation! Go online and learn more about applying creativity at work.";
        $description['cfe51ec6-ccd7-44aa-b6eb-d8b0b190ae17']['Identify Work Opportunities'][0][6]['dfd7f94b-975d-11ec-8166-0800273b46ed'] = "Consider the following: What areas of my work provide me with the greatest latitude? Or, what current problems or issues would invite fresh ideas? What workflow processes are less than ideal? What feedback have I received from clients/customers that could form the basis for suggesting change? Or it may be something small but meaningful, such as, a form letter that has not kept up with the times and comes across dated and too formal. Once you have looked at the opportunities or potential areas of focus, you are ready to begin using your imagination.";
        $description['de489408-3d1a-42e1-a29b-7486b1c58a87']['Use Your Imagination'][0][6]['dfd7f94b-975d-11ec-8166-0800273b46ed'] = "Imagination is often a word we associate with childhood but if we think about it in its verb form, to imagine, we can immediately see its application at work.  Can I imagine a different way of doing this daily task that might be a positive change in some way (i.e., quicker, cheaper, more user-friendly, of a better quality)? Can I imagine a new team practice that would help us all with our work? Can I imagine a new habit that would give me a better result on small and big things? Can I imagine a way to get something done without a budget? Once we ask ourselves questions that allow our imagination to get to work, we usually come up with workable solutions!";
        $description['7e4ff8fb-f096-40e7-9084-97b77abbff69']['Identify Work Opportunities'][7][8]['dfd7f94b-975d-11ec-8166-0800273b46ed'] = "Consider the parameters of your current work. Where do you feel restricted? Where do you feel you have latitude? Are you making the most where you have the greatest flexibility? Building on this area may bring you the best return on your investment of time and energy. Conversely, is there an area where you feel dissatisfaction and addressing this would support your engagement at work? If you are imagining a better way of doing something, go for it! Where you need approvals, prepare your business case so others know you've thought it through. Thinking creatively is all about imagining how it could be different. We all have this ability and when we exercise it, we automatically become more invested and engaged.";
        $description['ee24e7d8-d3e0-4b70-ba72-b67a3d0109b8']['Push Your Skillset'][7][8]['dfd7f94b-975d-11ec-8166-0800273b46ed'] = "You have skills to be creative at work. You may want to develop this further, however. Your brain is like a muscle and its creative centers need to be exercised! Ideally, know your development area before you investigate resources to narrow your search. For example, are you strong on idea generation but need support when creating within constraints? Or are you good at problem-solving in creative ways but are challenged when you need to combine your ideas with others to find an alternative solution? Spend some time trying to identify where you'd like to take your creativity. Then, consider your available resources. Perhaps your organization offers development in this area or provides funding for external program or conferences. At the very least, there are many online resources and any bookstore (virtual or in your neighborhood) will have business books on how to be more creative at work. If this is a skill you wish to develop, there are innumerable resources available to you, including your local art association! On the surface it doesn't have anything to do with business but it does get the creative part of your brain going and this will carry over into your work life as well.";
        $description['0700a26e-e460-4c37-be91-29278c5725cd']['Take Initiative'][7][8]['dfd7f94b-975d-11ec-8166-0800273b46ed'] = "Volunteer to work on a change initiative that will require original thinking because your organization is trying something completely new or it's a new situation in the market and everyone is needing to think it through. Or, pick something smaller but something that will nevertheless help you be more creative at work; for example, offer to figure out something for your team that's a pet peeve or create a habit of asking `Given this constraint, how can we do X?`. This will train your brain to imagine all sorts of new possibilities!";
        $description['20d4cdef-5f82-4fb7-a4b4-8e1ecfe904a2']['Nurture Your Skills'][9][10]['dfd7f94b-975d-11ec-8166-0800273b46ed'] = "To sustain your creativity, ensure you keep looking for opportunities to be apply these skills. Do not take your creativity for-granted. Appreciate this ability and nurture it. An excellent way to do this is to take on a task or project that requires you to build something from scratch. You are then truly creating and in the process of creating you will have to imagine how things should go and along the way will likely hit some bumps in the road, both of which will require you to tap into your creativity. New situations, new challenges and old problems that won't go away, require creativity. Challenge yourself and keep developing that creative muscle!";
        $description['ce62dee0-1cad-4634-a10c-30906f4f34d4']['Hang Out With Creatives'][9][10]['dfd7f94b-975d-11ec-8166-0800273b46ed'] = "Spend time with others whose creative abilities you admire. This will provide you with support and will open up new possibilities. Ask `what if` questions and 1how can we` questions to stimulate yours and others' thinking. Build on other`s ideas by applying the `Yes, and...` rule from improvisational theater, in which actors accept whatever the other actors have offered (i.e., have said or done) and work with that to build a story. Do the same at work. Say, yes and then add to the idea by building it into an even better idea. This practice alone will ensure you never stop being creative at work!";
        $description['2e835d5b-e0e5-4d47-97a6-f60d81aff55d']['Expand On Your Toolkit'][9][10]['dfd7f94b-975d-11ec-8166-0800273b46ed'] = "Learn more about the discipline. Read and study experts in the field. There are many resources online from books to videos to online communities. And if your budget permits, attend conferences that focus on such things as creative problem-solving and innovation. There may also be local resources for you through your Human Resource department or through local colleges and universities. Either way, learning about creativity will be stimulating and most likely lots of fun!";
        $description['e7a72f05-2245-4984-8333-4a5b7621d993']['Amplify Your Natural Interests'][0][6]['dfd7f732-975d-11ec-8166-0800273b46ed'] = "Your score indicates you need to make some effort to be interested in the type of work you are doing. Consider what facet of your current work most naturally interests you. 
        o	Do you love working with numbers? Is writing a pleasurable task for you? 
        o	Do you love the people-side of things? Are you more interested in how things work?
        o	Out of all the things you have to do in a day, where are you most inclined to enjoy yourself and be naturally interested? What facets of your work are most effortless? 
        Once you have identified areas of greatest natural interest, ask yourself how you can bring more of this type of work into your job? Can you take on additional tasks that align with your natural interests? Can you delegate the ones that don't? Can you collaborate so that your colleagues take on the work that interests you the least but them the most? And vice versa? Really play with the idea of how to bring more of what naturally interests you into your work. Discuss this with others you trust. They may see possibilities where you do not. The goal is to amplify what naturally interests you and de-emphasize, where possible and practical, what doesn't.
        ";
        $description['62c4da47-8030-4532-84bd-8460d714817c']['Infuse More Interest'][0][6]['dfd7f732-975d-11ec-8166-0800273b46ed'] = "Consider ways to make the work that is of little interest more interesting. For example, if working with numbers drags you down, perhaps there is a way to buddy up with someone on the task so you can at least enjoy the human interaction. Or, perhaps if working in a very detailed and analytical way is not a natural fit for you, you could manage your schedule so that you work in concentrated time periods and then treat yourself in-between with work you enjoy. Get creative with how you work to minimize the additional effort of working outside your areas of natural interest.";
        $description['17bad94f-71b2-4ffb-abdb-db20d78fb951']['Prepare Yourself For Change'][0][6]['dfd7f732-975d-11ec-8166-0800273b46ed'] = "Your current job may not be a good fit for you. It is worth properly considering this position and considering the alternatives. As you are doing this, reflect on your current performance. To create new opportunities for yourself, it is wise to do your current job well. Others are more likely to support a move if you've contributed well in your current role. Also, before taking any steps to change your work, conduct a proper analysis: you should have a clear picture of the work that does interest you, a clear picture of how to equip yourself for that work, and you should begin preparing yourself for the change before you make a change. For example, you might undertake part-time studies, or a part-time job in the field, or you might interview people currently doing that job. The point is that you want to prepare for a change and not react to your current circumstances.";
        $description['d00c443a-e74b-4f57-8f7a-8f3a77132968']['Amplify Your Natural Interests'][7][8]['dfd7f732-975d-11ec-8166-0800273b46ed'] = "Your score indicates that you do not feel a strong, natural connection to your work. In fact, your score indicates you need to make some effort to be interested in the type of work you are doing. Consider what facet of your current work most naturally interests you. 
        o	Do you love working with numbers? Is writing a pleasurable task for you? 
        o	Do you love the people-side of things? Are you more interested in how things work?
        o	Out of all the things you have to do in a day, where are you most inclined to enjoy yourself and be naturally interested? What facets of your work are most effortless? 
        
        Once you have identified these, ask yourself how you can bring more of this type of work into your job? Can you take on additional tasks that align with your natural interests? Can you delegate the ones that don't? Can you collaborate so that your colleagues take on the work that interests you the least but them the most? And vice versa? Really play with the idea of how to bring more of what naturally interests you into your work. Discuss this with others you trust. They may see possibilities where you do not. The goal is to amplify what naturally interests you and de-emphasize, where possible and practical, what doesn't.
        ";
        $description['bd9c4ebc-4b75-4c97-aa26-91dd3578b4a7']['Explore Greater Fit'][7][8]['dfd7f732-975d-11ec-8166-0800273b46ed'] = "Research other areas of the company that may play more to your natural interests. Providing you are doing a good job where you are, organizations are usually happy to help people make changes that better align to their strengths and interests. Once you know where you might like to work, explore ways of experiencing the area first hand. For example: volunteer in that area; see if a secondment to that area is possible; or, perhaps there are ways to collaborate around a business goal. At the very least, speak to people who work there and ensure your impressions are accurate. Learn about their experiences. Learn about that business. Once you have informed yourself, you will be in a much better position to make a decision. The same is true for areas of interest outside of your current company. Always educate yourself first so you don't fall into the `grass is always greener` trap.";
        // $description['507a764e-8e19-4046-87e5-9e7903f0d93a']['Explore Greater Fit'][7][8]['dfd7f732-975d-11ec-8166-0800273b46ed'] = "";
        $description['2279387b-66dc-4ba4-b4bc-aab70ea1bcce']['Keep It Exciting'][9][10]['dfd7f732-975d-11ec-8166-0800273b46ed'] = "Your goal is to maintain and sustain the connection you currently feel with your work. Continue to deepen your learning in your field. Do not allow yourself to get bored. Stay curious and stimulate yourself through investigation and exploration. When was the last time you invested in your learning and professional development? When was the last time that you felt you were in new territory within your field? If it's been more than a year or two, it's time to pay attention and get out there and expose yourself to what is new and exciting in your field!";
        $description['b3ec9887-f72e-4af9-aee8-4e8ad982791c']['Increase Challenge'][9][10]['dfd7f732-975d-11ec-8166-0800273b46ed'] = "We all need challenge to stay engaged. As your knowledge and skill increase, the challenge also has to increase in proportion to your learning. We all need an opportunity to apply our learning so that we feel we are stretching while still contributing. Set goals within your job scope that allow for this type of growth to sustain your natural interest and depend your connection with your work.";
        $description['386a9d4b-dbc8-4719-a85d-53b08f62aa1c']['Spend Time Thinking About Purpose'][9][10]['dfd7f732-975d-11ec-8166-0800273b46ed'] = "When we feel naturally interested in our work, we often develop a sense of purpose as well. What's our reason for doing what we do? What's most meaningful about our work? How can we shift our focus from what our job gives us (i.e., money, status, identity, power, flexibility, etc.) to how we add value in the world? How can we be more intentional in our work? What will be our legacy?";
        $description['00874c9d-6cc0-4666-ae41-2f5e85b93e36']['Accept. Correct. Reflect. Learn.'][0][6]['dfd7ecef-975d-11ec-8166-0800273b46ed'] = "Your score indicates that you do not feel well able to learn and grow from mistakes. Developing this practice is quite straightforward but it requires mental discipline and self-restraint. Next time you make a mistake, adopt the following practice: 
            	Accept. Accept your accountability immediately. This means owning the part you are responsible for rather than explaining why it happened that way. For example, if you are late for a meeting and your manager speaks to you about it, don't provide excuses. Simply state the facts:  `It`s true I didn't leave myself enough buffer between meetings.` Or, if you missed a deadline, say: `I waited until the day before the report was due to crunch the numbers. I hadn't anticipated I would have difficulty reconciling the numbers.` 
            Correct. Now focus on making it right. What needs to happen to get things back on track? Make a plan and communicate it to those concerned. Begin actioning the corrective measures immediately. 
            	Reflect. Once the mistake has been corrected, take time to reflect on why the mistake happened and what you learned about yourself, the system/process, or others as a result of the mistake. 
            	Learn. Then, think about how you might have prevented the mistake and incorporate this learning into future work.
            ";
        $description['cd512b38-048c-42d5-96c3-746318c1fab2']['Separate Yourself From Your Mistakes'][0][6]['dfd7ecef-975d-11ec-8166-0800273b46ed'] = "People often internalize mistakes and adopt negative self-talk. For example, when someone fails at accomplishing a task, they might say, `I am a failure.` It takes discipline to see that you are not your failures or mistakes. A mistake or failure might be interesting and you might be curious about how it came about but it is not a reflection of your self-worth. Focus your mind on understanding how it came to be and not on blaming yourself";
        $description['3f64a5b0-f07b-4b69-ad2c-38d1db12ec9c']['Develop A Learning Orientation'][0][6]['dfd7ecef-975d-11ec-8166-0800273b46ed'] = "Next time you make a mistake, adopt a curious mindset and ask yourself questions that will help you learn from the event:  `Why did I choose to do that?`, `Was I acting from a place of fear, or from the best of intentions?`, `What could I have done differently to get a better end result?`. These questions will place you into a learning mode and will provide you with insight to choose differently next time.";
        $description['2d6c0ee6-949e-4053-8f45-c7a2a893119c']['Accept. Correct. Reflect. Learn.'][7][8]['dfd7ecef-975d-11ec-8166-0800273b46ed'] = "Develop a conscious practice to increase your skill in this area or to increase the consistency of its application. For example, you might consider developing the following habit (or version thereof): 
        o	Accept. Accept your accountability immediately. Begin by owning your responsibility and stop yourself from explaining why it happened that way. 
        o	Correct. Focus on making it right. What needs to happen to get things back on track? Make a plan and communicate it to those concerned. Begin actioning the corrective measures immediately. 
        o	Reflect. Once the mistake has been corrected, take time to reflect on why the mistake happened and what you learned about yourself, the system/process, or others as a result of the mistake. 
        o	Learn. Then, think about how you might have prevented the mistake and incorporate this learning into future work. Creating your own practice and following it consistently will boost your ability to learn from mistakes and might in fact make them a rich experience rather than something to be dreaded.
        ";
        $description['556add5f-830f-45ea-9af9-55f58b97a7f8']['Step Back'][7][8]['dfd7ecef-975d-11ec-8166-0800273b46ed'] = "On occasion, you might have a tendency to get caught up in the emotions around a mistake or failure. Recognize that this may prevent you from being able to learn from the events. Instead, take a deep breath and refocus on the facts and ask helpful questions to understand your and others' motivations, decisions, and actions. When you have a full picture of how the mistake came to pass, you will be well equipped to see the learning.";
        $description['715b6fd5-38bc-4f76-95ea-c35b54eb53ff']['Promote A Learning Orientation'][7][8]['dfd7ecef-975d-11ec-8166-0800273b46ed'] = "Promote the idea of a learning organization. Encourage others to focus on what's to be learned rather than who's to blame. You may sound like a broken record after a while but people will notice. Learn how to ask good open and honest questions so you can guide the learning: `What lead to this decision?` `Why did we feel the need to take that action?`, `What result were we expecting?`, `Did we have a contingency plan?`.";
        $description['26aaedb3-0c56-4bb3-b34f-e0fe4752d0e9']['Mentor Others'][9][10]['dfd7ecef-975d-11ec-8166-0800273b46ed'] = "Help others adopt this orientation so together you can create a culture of learning versus blaming. When others are struggling with their mistakes, share how you process mistakes and how it helps you grow and develop. If you are a manager, make this a topic of a team meeting and work with your team to develop a practice around mistakes so you can all learn and grow from everyone's mistakes and failures.";
        $description['cc57ac31-7452-409c-880f-3494eb2a3bbb']['Lead The Way'][9][10]['dfd7ecef-975d-11ec-8166-0800273b46ed'] = "Refuse to blame another person or department for a failure. Instead, refocus on understanding how the mistake came to pass and encourage people to learn from it so changes can be made to get a better result next time. For example, if there has been a delivery failure, rather than participating in a discussion that might be looking for a scapegoat, redirect the conversation to productive learning.";
        $description['5391d7d2-aa09-44f6-97fd-411c0eaab1c8']['Study The Topic'][9][10]['dfd7ecef-975d-11ec-8166-0800273b46ed'] = "There are many good books that deal with how we work with mistakes and how we could work better with mistakes. Build on this skill but taking yourself to the level of mastery. Listen to what jazz artists have to say about mistakes. Most acknowledge that the concept of mistakes doesn't exist on the stage. If anything, it's the team's failure to respond to the new event (e.g., a note is played from another scale) rather than it being the failure of the artist who made the change. Improvisational theatre adopts the `Yes, and` rule to enable the story to continue to unfold rather than stopping to address a mistake. There are lots of online resources you can read or listen to on this subject.";
        $description['25d01695-873b-4fab-8168-a3c9e53d13ed']['Create A Summary'][0][6]['dfd7ed37-975d-11ec-8166-0800273b46ed'] = "Your score indicates that your goals require further clarity both in terms of what you need to do as well as their rank order. Review your current goals and answer the following questions: 
        o	Do I know what success looks like for me this year? 
        o	Do my goals pass the `champagne test`? Will I recognize the exact moment they have been achieved and can I then celebrate the achievement? 
        o	Do I know which goals are more important than others? 
        o	Are they weighted accordingly?
        o	If I have to choose how to spend my time, do I know where I should first apply my efforts?
        o	Write out your key goals, using the SMART Gal format, and place them in rank order. Make sure they can easily fit on a page and should typically range from 5-10 in number.
        ";
        $description['7b7fa3b0-f44a-47eb-a986-4d11c775c396']['Get On The Same Page As Your Manager'][0][6]['dfd7ed37-975d-11ec-8166-0800273b46ed'] = "Develop questions that will help you and your manager clarify importance as well as desired end results. You also need to be clear about what is an acceptable result as well as what is an exceptional result. Example questions (but have your own answers ready to compare):
            o	`If I had to choose only three goals to achieve this year, which are the most important?`
            o	`How will we know when I have met your expectations?`
            o	`How important is my day-to-day performance relative to my project or stretch goals?`
            o	`How should I allocate my time accordingly?`
            o	`How could we quantify or measure my daily work so we can see whether I am meeting the expected performance standards?`
            ";
        $description['dfacb1c8-a32e-4c4b-9352-3e5a84f511e7']['Draft Your Own Goals'][0][6]['dfd7ed37-975d-11ec-8166-0800273b46ed'] = "If your manager or organization are not strong on goal setting, then formulate your own goals. You know your work well. You likely know the needs well. If not, learn about your internal or external client desires and create appropriate goals. It is very important you connect to goals that matter to you; otherwise, engagement at work will be very difficult. And don't be afraid to challenge yourself. It feels good to use your talent in service of your clients or the organization.";
        $description['eb1b5386-40d0-4502-a293-7be3385abc8b']['Review Your Documented Goals'][7][8]['dfd7ed37-975d-11ec-8166-0800273b46ed'] = "Do they reflect your current understanding? If not, make it a priority to revise and update what is documented. This review should also trigger a conversation with your manager. Prepare for the meeting by drafting new goals that better reflect what you believe is required of you this year.";
        $description['049a928b-539c-4f9d-ba23-e2825c9f42c4']['Propose Better Goals'][7][8]['dfd7ed37-975d-11ec-8166-0800273b46ed'] = "It may be very interesting to consider whether your goals as set are adding the best value. From your point of view, are they the right goals? Will time spent in these areas provide the organization with the best return on investment? Are there other, more important ways for you to spend your time? Be discerning. Then, meet with your manager to propose a shift of focus.";
        $description['3e4e2eff-1c60-4b0b-8f7c-9052df1218cd']['Rank Order'][7][8]['dfd7ed37-975d-11ec-8166-0800273b46ed'] = "Many managers don't want to decide which goals are most important or give them a specific priority. This, however, is a critical component of success: knowing which goals is more important than others or where they fit in the order of importance. Draft a rank ordered list of your goals and meet with your manager to discuss.  At the very least, divide them into three categories: Essential to Achieve, Important to Achieve, Nice to Achieve. Ensure that you and your manager agree on which are the most important and which might be nice to have but are not essential. This is especially important if your daily work begins to compete with your goals.";
        $description['6a19ef10-3f79-412b-a2c3-eee526e93808']['Establish Quarterly Check-ins'][9][10]['dfd7ed37-975d-11ec-8166-0800273b46ed'] = "Meet quarterly with your manager to review your goals and their relative importance. Adjust as needed. These regular conversations will ensure you do not have surprises at the end of the year.";
        $description['896ab3b1-db51-4eac-816e-aaa508cb737d']['Ask For feedback'][9][10]['dfd7ed37-975d-11ec-8166-0800273b46ed'] = "Does your manager, your client, or your team members believe you are focused on the right things? Do they have suggestions that would improve how you are approaching your goals or the end result?";
        $description['1cd82dd7-9697-45b6-882c-77d4c492209d']['Reflect On Your Goals'][9][10]['dfd7ed37-975d-11ec-8166-0800273b46ed'] = "Are they truly SMART goals (specific, measurable, achievable, realistic, timely)? Many goals are poorly written and are often vague. Does each goal pass the `champagne test`? Will you recognize the exact moment it has been achieved so you can then celebrate the achievement? Most goals are not written his clearly. If yours are not, rewrite them to meet this standard.";
        $description['4142d52f-1a52-49fa-a431-f4efb4c5822c']['Present Your Game Plan'][0][6]['dfd7f905-975d-11ec-8166-0800273b46ed'] = "Overall, you do not feel empowered. The best place to start to increase your sense of empowerment is to ensure you are clear on your end goal and/or the performance standards. Often organizations dictate how the work gets done rather than focus on the desired outcomes. When outcomes are clear, managers are more willing to let you find your own way to achieve the goal. When there is a lack of clarity, often people focus wrongly on process. To give comfort, we may also want to review our approach at a high level. Share with your manager/team how you plan to tackle your goal. Knowing that you have a game plan will also leave more of the decision-making within your domain.";
        $description['fa0fec30-6658-49aa-8915-22dddab51961']['Confirm Your Autonomy'][0][6]['dfd7f905-975d-11ec-8166-0800273b46ed'] = "Often we have more latitude than we think we have, so it's smart to check your assumptions. For example, is your workflow process non-negotiable or is your manager/team open to improvements? Or perhaps there is flexibility at certain stages of the process but not others? If your decision making is restricted in some areas, focus on those areas where you can assume more decision making. Having a sense of control over one’s work builds engagement and empowerment.";
        $description['4fe4bd55-9d50-4c52-9d13-d2c0400400d3']['Confirm Performance Standards'][0][6]['dfd7f905-975d-11ec-8166-0800273b46ed'] = "If you feel your manager lacks trust in you to get the job done to standard, this is an important conversation to have. It may be that the manager does have concerns but once you talk them through you can determine a process to follow that will build trust. Sometimes managers micromanage rather than discussing the issues at hand. Come to the conversation open to feedback. If trust is a barrier, figure out why and then determine how to resolve it. Decision-making comes with trust. The starting point is to ensure you agree to the performance standard for your task or project. Ensuring you both see the end result in the same way, builds confidence and trust.";
        $description['d1e4ba00-6e59-46af-8ba7-a2f081cb8167']['Propose Change'][7][8]['dfd7f905-975d-11ec-8166-0800273b46ed'] = "Ask yourself where you would like to have more decision-making capacity in relation to how your work gets done. Are you dealing with antiquated templates? Are you working within an inefficient system that constrains you? Are you working for a manager or on a team that hasn't updated its processes in a very long time? Take it upon yourself to propose a change or request the flexibility to explore other ways of achieving the goal. Offer to report in and share your plans so people feel assured.";
        $description['5682901c-9a0e-4889-b105-20b7a079b0e6']['Address Bottlenecks'][7][8]['dfd7f905-975d-11ec-8166-0800273b46ed'] = "Where there are bottlenecks that impact your work? Offer to help address them. In so doing, you will increase your influence and perhaps your decision-making capacity. Taking a positive approach and being willing to go the extra mile will often open up new possibilities.";
        $description['f6ee7678-ffa2-4b13-8e68-9a146450a874']['Ask To Decide'][7][8]['dfd7f905-975d-11ec-8166-0800273b46ed'] = "Where you know you have competence but do not currently have the ability to make the decisions about how the work gets done, make an explicit request. Ask for the power. Be prepared with evidence of your competence, why you would like to have control, and why this would benefit the team/organization. Often, constraints are in place but people are not attached to them and so reasonable proposals will be well received.  At the very least, you may learn the reasons for the constraints (e.g., legal, regulatory, etc.).";
        $description['1f8e8c93-3ea9-4cdd-9a59-d2e0a5c55456']['Proactively Ask To Decide'][9][10]['dfd7f905-975d-11ec-8166-0800273b46ed'] = "Autonomy is a natural outcome of competence. As you continue to learn and grow, your desire for decision-making will also increase proportionately. Be proactive about this. As you feel able to take more control over a NEW task, make sure you bring your manager along with you. - Remember, ensure your manager feels they have imparted their knowledge to you, including showing you how to do it, if that is their wish. - As you progress in the task, check-in with your manager so they can see your progress and can direct you, if needed. - Once your manager knows you are on track, just do it without checking in. Competent employees often forget to follow these foundational steps, when they receive new responsibilities; and, then get annoyed when their sphere of control is pulled back. However, it's good to follow these basic steps so you don't run into roadblocks down the road.";
        $description['f7e72c94-05b4-4739-b05d-3f56ea94d7ae']['Pay It Forward'][9][10]['dfd7f905-975d-11ec-8166-0800273b46ed'] = "As you gain more and more control over how your work gets done, pay-it-forward and help others acquire the same privilege. Perhaps you are in a position to delegate some of your work to one of your employees or perhaps to one of your colleagues who would see this piece of work as an opportunity to learn and grow. As we take on more responsibility, it is important to share responsibility, regardless of your position in the organization. At the very least, you can always suggest to your manager that, in your view, a colleague would do an excellent job of a particular task. Sharing power brings new opportunities so don't be stingy!";
        $description['4ef6f60e-c7bb-47cf-a2b3-e711a365e51c']['Identify Your Needs'][0][6]['dfd7f88d-975d-11ec-8166-0800273b46ed'] = "Your score indicates that you do not feel a strong sense of ownership for your work. This could be for many reasons. Identify the barriers to a strong sense of ownership in your work. Are you micromanaged? Do you simply feel like a cog in a wheel? Is it a collaborative effort with unclear roles and responsibilities? Try to pinpoint why your sense of ownership is lower than what is needed for high engagement and passion in your work.";
        $description['6d5d064e-186a-4d26-859f-52482c385df7']['Define Your Specific Responsibilities'][0][6]['dfd7f88d-975d-11ec-8166-0800273b46ed'] = "Where does your work start and end? Or at what points/stages does the work require your contribution? Carefully scope out your accountability and manage it accordingly. Recognize the importance of your work and write a statement that reflects the value of your work. It's important to place its meaning clearly in your consciousness. Your brain needs to know why it's worth pursuing the work. When your brain knows why it matters, you will be motivated to ensure the work is delivered to the highest standard.";
        $description['d690c9d2-f996-4048-b285-7d00e9386097']['Manage Your Boundaries'][0][6]['dfd7f88d-975d-11ec-8166-0800273b46ed'] = "If others appear to be a barrier to your sense of ownership, have the necessary conversations. For example, if your manager is micromanaging your work, set up a meeting to explore why your manager feels the need to be so involved. If there are no real issues, explain how this oversight impedes your sense of ownership and negotiate another way for your manager to feel comfortable with your progress.  Regardless of the reason, surface any issues, address them or suggest ways to work together that will enable you to own your part.";
        $description['f80f01b0-ce2d-44fd-847e-6293484bc553']['Analyze Your Work'][7][8]['dfd7f88d-975d-11ec-8166-0800273b46ed'] = "What areas of your work currently give you the highest sense of ownership? Now think about why. What conditions support this level of accountability? Now think about the areas in which you do not feel empowered. How do they differ from your strength areas? How are the conditions different? How could you address the barriers to increase your ownership in these areas? Does it require gaining clarification over your role or responsibilities in a particular area? Does it require a conversation with your manager or a project manager if their behavior inhibits your sense of ownership; for example, do you feel they are micromanaging? Do others who receive your work make changes to it without including you? Whatever the reason, identify it and take action to remove these blockers.";
        $description['a324044b-f2a9-40be-ae33-7f12a9f17373']['Take On Something New'][7][8]['dfd7f88d-975d-11ec-8166-0800273b46ed'] = "Opportunities to increase your sense of ownership might exist in taking on new responsibilities. For example, perhaps you are ready for a new challenge or you are ready to take on greater responsibility by increasing the scope of your work? Or, it might be time for you to take on more of a leadership role. It does not have to be a traditional management role. Leading happens on all levels and takes many forms. Simply offering to `take care of` something from start to finish is a clear way of increasing ownership. Or, offering to coordinate efforts around a team or client need will also boost ownership. While increasing your sense of ownership, it may also invigorate you and provide the boost of energy learning something new gives our brains.";
        $description['325ee334-e477-4e14-942b-26610f3637f7']['Take Radical Responsibility'][7][8]['dfd7f88d-975d-11ec-8166-0800273b46ed'] = "Ownership is also an attitude. We can choose to have it as part of everything we do, regardless of how big or small the task may be. We can take pride in whatever our contribution may be. If I am asked to attend a meeting but it is not my meeting or my project, I can still choose to own my support role and decide to actively support when opportunities present themselves. Ownership is seeing that our contribution matters and the extent to which we deliver on it matters. We are not apathetic or careless. We own the goal/task, we own the process and we own the result. Everyday we have opportunities, if we choose to take them, to strengthen our sense of ownership rather than nurture indifference.";
        $description['3838e1b3-32c5-4b28-8da5-0278b83863ee']['Deepen Self-Awareness'][9][10]['dfd7f88d-975d-11ec-8166-0800273b46ed'] = "To sustain a strong sense of ownership, it is helpful to sharpen your awareness of what enables your accountability. Is it your attitude? Is it how your work is structured? Is it the scope of your work or how it connects to your aspirations? Is it how you are managed? Notice what leads you to embrace your work as your own and then nurture it. Do not let any of your pillars fall. Pay attention to any cracks that emerge and then mend them. Maintaining the conditions which create strong ownership will support you long term.";
        $description['3f29e7b6-34c5-4e01-8ca1-392b83f3bd07']['Build Your Network'][9][10]['dfd7f88d-975d-11ec-8166-0800273b46ed'] = "Continue to nurture strong relationships and connections at work. Broaden your network. Maintaining high levels of trust across the organization will fortify the extent to which you are supported. Strong ties always make it easier to maintain a feeling of ownership. When others around us believe in us and trust us to do our work well, we know this and we respond accordingly. It becomes a virtuous cycle.";
        $description['fe8604e3-7045-4d0b-854b-9e95d54b749b']['Strengthen Connection To Purpose'][9][10]['dfd7f88d-975d-11ec-8166-0800273b46ed'] = "Every year, create new goals for yourself that support your purpose and your aspirations. Make direct links between your work and your goals. Also articulate why your work matters and to whom it matters. When we know our work counts, that people rely on us, that our work enables others to achieve their goals, we will do what it takes to deliver.  When we get disconnected from these things, our sense of ownership wanes. So stay connected and acknowledge how your work matters.";
        $description['4b2d4ee4-3872-4f14-a1c2-ce35aa883771']['Surface Your Expectations'][0][6]['dfd7f3f1-975d-11ec-8166-0800273b46ed'] = "It is often true that when we have set a plan, we prepare for best-case scenarios, and when the plan does not unfold as planned, we feel caught off guard.  We then focus on what's not working or the perceived obstacle in our path and miss seeing the new situation in its entirety. If we over-focus on the obstacle, we will not notice other changes. By fixating on the change we don't want, we miss other changes that might afford us an alternative path. So when you face a challenge, begin the practice of stepping back and looking at the complete picture. Yes, there may be a rock on the road but perhaps there is now a hole in the mountain.";
        $description['906c1a9d-740d-4b07-ab8b-76c57ab55e1c']['Reconsider Problem Solving'][0][6]['dfd7f3f1-975d-11ec-8166-0800273b46ed'] = "Our culture is addicted to it and as a result when a challenge emerges we often feel we have to tackle it, destroy it or overcome it, rather than work with it. Most of us do not have a practice of embracing what is and moving with the challenge rather than resisting the challenge. Learn to dance with the roadblocks in your path. As you begin to work with the challenge rather than trying to overpower it, you will preserve your creative energy, allowing you to discover new ways of moving forward. Think of a time when you were denied something. If you then responded by aggressively trying to change that person's mind, you likely did not succeed. However, if you worked with the objections, welcomed them, investigated them, honored them, you might very well have found a new opening upon which to build.";
        $description['1e6db524-24f6-41db-87a9-2478c0139559']['Seeing Possibilities Is A Mindset'][0][6]['dfd7f3f1-975d-11ec-8166-0800273b46ed'] = "It comes from knowing that things are never static. Everything is always in a state of flux. Sometimes the changes are subtle; sometimes they are obvious. If we truly recognize that we simply have to adapt our approach to the new situation, then we can find our way. It's our refusal to adapt that threatens our success. Whenever we stop changing and become rigid, we set ourselves up for failure. Nature teaches us that to survive and thrive is to adapt to our landscape. Our brains are malleable, our bodies pliable. We simply have to be willing to flex and change. Coyotes learn to live with humans and eat urban fare; we need to learn to accept the challenges in our reality and know we are equipped to respond.";
        $description['2eebba76-d91f-4267-981b-2a53bdde4369']['Observe How You Play With Possibility'][7][8]['dfd7f3f1-975d-11ec-8166-0800273b46ed'] = "Can you think of a time when you met a challenge with ease? What made it easy for you to see the possibilities in this challenge so that you were able to discover new paths forward? Think of another time and answer the same questions. Do this three times. What do you notice? What makes it easy for you to see possibility? For example, you might notice that you are very good at getting people to collaborate in a crisis or to come together to overcome obstacles.";
        $description['98953a1f-a7de-4ab9-9a60-b0b1f99ee6b5']['Observe How You Deal With Challenge'][7][8]['dfd7f3f1-975d-11ec-8166-0800273b46ed'] = "Think of a time when you faced a challenge and your reaction was to see it as an immoveable roadblock. How is this different from when you met a challenge with ease? What was different about these circumstances? Now think of another two times, if you can. What themes are emerging from this analysis? What is it about these challenges that made it difficult for you to see possibility?";
        $description['a0aeb115-9de5-4c17-9fc2-310ecdc16810']['Frame For Possibility'][7][8]['dfd7f3f1-975d-11ec-8166-0800273b46ed'] = "Think about how you could frame all of your challenges so that you were able to see possibilities. For example, if you find it difficult to see possibilities when resources are severely restricted, think instead about the company's resources holistically. Then contemplate how you could use what's already there to achieve your goal? How can you work through another project or through normal operations or through another department? Use your collaboration strength to help you see possibilities in your current challenge.";
        $description['ed583649-6f44-4749-b71b-da787fbf22ac']['Teach Others'][9][10]['dfd7f3f1-975d-11ec-8166-0800273b46ed'] = "You have a mindset around challenges that enables you to see possibilities. One of the best ways to understand how you do it is to teach others. If you are a manager, mentor your team when you see they are feeling daunted by the challenge. Help them to see the challenge differently. If you are a team member, support others by noticing when they are frustrated by a challenge and feel intimidated by it. Share with them your perspective and help them develop an action plan. In sharing, you will become more conscious of your own skill and this will in turn reinforce your positive mindset.";
        $description['4dbd639c-d5b2-4fb9-b4e9-93ddbd7c39cb']['Deepen Your Skillset'][9][10]['dfd7f3f1-975d-11ec-8166-0800273b46ed'] = "Consider developing your strength further by learning more about such subjects as creative problem-solving, improvisation, which teaches working with all realities in positive ways, and critical thinking. Read books, attend seminars, and seek out webinars or online talks. You will recognize yourself in these resources and they will add to your existing toolkit, reinforcing this skill you possess.";
        $description['e2005fcc-8ea1-4796-a4c3-f28453173a58']['Make A Cheat Sheet'][9][10]['dfd7f3f1-975d-11ec-8166-0800273b46ed'] = "Consider articulating some basic principles to follow so that in any situation you can always see possibilities; for example, if we decide to always adapt. Then, every time we are met with a challenge that might feel like an immoveable roadblock we know our response is, `How can I adapt?` It's our refusal to adapt that threatens our success. Whenever we stop changing and become rigid, we set ourselves up for failure. Nature teaches us that to survive and thrive is to adapt to our landscape. Our brains are malleable, our bodies pliable. We simply have to be willing to flex and change. We need to learn to accept the challenges in our reality and know we are equipped to respond.";

        return $description;
    }
}
