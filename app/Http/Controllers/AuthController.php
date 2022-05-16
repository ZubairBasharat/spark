<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Config;

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
            'client_id' => '96022a85-d94d-494b-8991-38368e0d2763',
            'client_secret' => 'wbvlDOzhKkmPaW7kLdBP7uj2sCuIpJ6nKsUKjhAm',
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
        Session::put('user_name',$user_details->name);
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

    public function personalDashboard()
    {
        $phase_distribution = array();
        $question_values  = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,);
        $contrast_values  = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,);
        $phase_code = "";
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/contrast';
        $response = Http::withToken(Session::get('access_token'))->get($apiURL);
        if(!empty($response)){
            $response = json_decode($response)->data;
            $phase_distribution = $response->phase_distribution;
        }

        $compareable = $this->comparable();
        if(!empty($compareable)){
            $compareable = json_decode($compareable)->data;
            $questions = $compareable->question_values;
            foreach($questions as $index=>$question )
            {
                $question_values[$question->display_order - 1] = $question->question_value;
                if($index == 5)
                {
                    break;
                }
            }
            $phase_code = $compareable->phase_code;
        }

        $contrast = $this->contrast();
        if(!empty($contrast))
        {
            $contrast = json_decode($contrast)->data;
            foreach($contrast->question_averages as $contrast_index=>$average)
            {
                $contrast_values[$average->display_order - 1] = $average->question_average;
                if($contrast_index == 5)
                {
                    break;
                }
            }
        }

        $states = array("A"=>"Frustrated", "B"=>"Unfulfilled", "C"=>"Stagnated", "D"=> "Disconnected", "E"=> "Neutral", "F"=>"Energized", "G"=> "Engaged", "H"=> "Passionately Engaged"); 
        return view('personal_dashboard',compact('phase_distribution', 'states','phase_code','question_values','contrast_values'));
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

    public function actionPlans()
    {
        $description = $this->actionPlansDescription();
        $phase_code = "";
        $states = array("A"=>"Frustrated", "B"=>"Unfulfilled", "C"=>"Stagnated", "D"=> "Disconnected", "E"=> "Neutral", "F"=>"Energized", "G"=> "Engaged", "H"=> "Passionately Engaged"); 
        $myactions = array();
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions';
        $myactions = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions = json_decode($myactions);
        if(isset($myactions->data)){
            $myactions = $myactions->data;
        }

        $compareable = $this->comparable();
        if(!empty($compareable)){
            $compareable = json_decode($compareable)->data;
            $questions = $compareable->question_values;
            $phase_code = $compareable->phase_code;
        }

        $available_action_plans = $this->available_action_plans();
        $available_action_plans = json_decode($available_action_plans)->data;

        $phase_code = $phase_code != "" ? $states[$phase_code] : '';
        return view('action_plan', compact('myactions', 'phase_code','available_action_plans','description'));
    }

    public function deleteAction($action_id)
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/'.$action_id;
        $response = Http::withToken(Session::get('access_token'))->delete($apiURL); 
       return redirect()->back()->with(['success_message'=> 'Action plan deleted successfully']);
    }

    public function available_action_plans()
    {
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions/available';
        return Http::withToken(Session::get('access_token'))->get($apiURL);  
    }

    public function save_action_plan($plan_id)
    {
        $postInput = [
            'action_id' => $plan_id,
        ];
  
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions';
        $response = Http::withToken(Session::get('access_token'))->post($apiURL,$postInput);
        $response = json_decode($response);
        if(isset($response->data)){
            $message = [
                'success_message' => 'Action Plan Saved Successfully'
            ];
        }else{
            $message = [
                'error_message' => $response[0]->message
            ];
        }
        return redirect()->back()->with($message);
    }

    public function actionPlansDescription()
    {
        $description = [
            'LOCATEMEANING' => '<P>When trying to engage more with your current work, it is crucial to begin with locating meaning. Think about the work you produce (the product and services you personally deliver)</P><p>- Who uses the products you create? Or, who benefits from the service you provide?</p><p>-	How do these products/services help your clients (internal or external) get what they need/want?</p><p>-	How does what you do or produce improve things?</p>',
            'DISCOVERMEANING' => '<P>Think about how you work to see if you can discover meaning in your work. For example,</P><p>-	How does the way you work contribute to excellence?</p><p>-	How does the way you do your work help your teammates do their work?</p><p>-	How do you nurture and create high-functioning, interpersonal relationships and networks? And how do these relationships make the work more efficient and more enjoyable to do?</p>',
            'LOOKCLOSELYATYOURSPHEREOFCONTROL' => '<P>-	What aspects of your work are you in control of?</P><P>-	Where can you make decisions, even if small ones?</P><P>-	What aspects of your work are not 100% in your control but fall within your sphere of influence?</P><P>-	Where can you influence change or how the work gets done?</P><P>-	Who are your key stakeholders that you have the potential to influence?</P>',
            'CONSIDERALTERNATIVES' => '<P>There are always opportunities to improve work processes and products.</P><P>-	Challenge yourself to think about how you could achieve the same goal but could do it more efficiently or with a better quality end result.</P><P>-	Put your brain to work and it`ll find new ways of approaching the work.</P><P>-	Change the things first that are completely within your control and then work on your sphere of influence.</P><p>-	Even if your ideas seem modest, execute them! This will build momentum for further action and will enable you to enjoy your work more fully.</p>',
            'THINKBIG' => '<p>-	How could you add more value? Think about the work you receive and the work you pass on.</p><p>-	How could you add more value? Think about the work you receive and the work you pass on.</p><p>-	What might make your team or manager`s life easier? How could you suggest changes that would lighten their load?</p>',
            'SEEKOUTMORECHALLENGINGWORK' => '<p>Let`s face it you`re bored! So put your talents, skills to use!</p><p>-	Make a list of work you see around you that you could take on.</p><p>-	Visit your peers and manager and offer to take something off their plate.</p><p>-	If you feel you do not have the skill, ask them if you can learn from them during your down time or slow times.</p><p>-	Create a development plan for yourself and meet with your manager to ask for his or her support.</p>',
            'VOLUNTEERFORCOMMITTEEWORK' => '<p>Demonstrate an interest in the organization by volunteering for tasks outside of your job description.</p><p>-	If you like social events, think of the committees in your workplace; for example, Summer Party, Christmas Party, Fun Day, Volunteer Day, etc.</p><p>-	If you want to deepen your knowledge in an area, think about a committee that would help you do that, such as Health & Safety, Wellness, Charitable Donations, Social Media, etc.</p>',
            'LOOKFORSIGNALSOFPROGRESS' => '<p>: Signals of progress let you know that you are making a difference, having impact and experiencing forward movement. For example, think about the following:</p><p>-	Positive feedback you`ve received from others.</p><p>-	The goals or objectives you have recently accomplished.</p><p>-	Challenges or obstacles you have overcome.</p><p>-	Recognition you received from someone who mattered to you.</p><p>-	The pace at which you are able to get your work done.</p><p>-	The people you touch in a day and how your work helps them move their work forward.</p><p>-	The problems you resolved.</p><p>-	The things you learned.</p><p>-	What task did you stop avoiding and checked off your to-do list?</p>',
            'MEASURE&QUANTIFY' => '<p>Identify what you could measure in order to get a sense of progress. For example, consider the following:</p><p>-	How many inquiries did you satisfy today?</p><p>-	How many tasks did you complete this week?</p><p>-	How many items did you process today?</p><p>-	What milestone did you reach?</p><p>-	What objective or goal was completed this month?</p><p>-	How many new professional contacts did you make? (Linked In, Twitter, FaceBook, etc.)</p><p></p>',
            'INVESTIGATEOTHERPOSSIBILITIES' => '<p>-	<b>Reflect:</b> Within the scope of your current role, what new challenges could you take on? What changes could you lead to make things work better? If you can`t think of anything, ask someone who knows your position well, as they may see possibilities you don`t see.</p><p>- <b>Document your aspirations and values: </b>What have you always wanted to do? What work aligns best to your natural interests?</p><p>-  <b>Identify your strengths:</b>What are you good at? Where do you excel? What skills are you most proud of? What attributes do others admire in you?</p>
                                                <p>-  <b>Create a list of all the things you1d like to learn about at work: </b>What are you curious about? Who could help inform you? How could you gain direct experience?</p><p>-  <b>Ask someone to be your career coach or mentor: </b>Who do you admire and how might they guide you to discovering a better fit for you within the organization? What job does someone else have that is appealing to you and could they give you advice about how to make a transition?</p><p>-  <b>Ask for feedback: </b>Ask people you trust to give you straight and honest feedback. What do they see as your strength(s)? What do they think holds you back? What are your development areas? What do they think you could do to make more of a contribution to the organization?</p><p>-  <b>Make a growth and change plan! </b>Based on the information you`ve collected above, create a plan for yourself that will have you learning new things and making both small and big changes at work. Start small and your successes will create small wins that will build momentum for bigger changes!</p>    '
        ];

        return $description;
    }

    public function action_plan_print()
    {
        $description = $this->actionPlansDescription();
        $myactions = array();
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions';
        $myactions = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions = json_decode($myactions);
        if(isset($myactions->data)){
            $myactions = $myactions->data;
        }
        return view('action_print',compact('myactions','description'));
    }
}
