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
        $phase_code_description = $this->phaseCodeDescription();
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
        return view('personal_dashboard',compact('phase_distribution', 'states','phase_code','question_values','contrast_values','phase_code_description'));
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
        $myactions_ids_array = array();
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
        // print_r($myactions);
        foreach($myactions as $index=>$myaction)
        {
            $myactions_ids_array[$index] = $myaction->action_id;
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
        // print_r($available_action_plans);die;
        return view('action_plan', compact('myactions', 'phase_code','available_action_plans','description','myactions_ids_array'));
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

    public function save_action_plan(Request $request)
    {
        $postInput = [
            'action_id' => $request->id,
        ];
  
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions';
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
        $apiURL = $this->base_url.'/api/participants/'.Session::get('participant_id').'/actions';
        $myactions = Http::withToken(Session::get('access_token'))->get($apiURL);  
        $myactions = json_decode($myactions);
        if(isset($myactions->data)){
            $myactions = $myactions->data;
        }
        // return $myactions;
        return view('action_print',compact('myactions','description'));
    }
}
