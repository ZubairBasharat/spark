@extends('components.app')
@section('content')
@section('scripts')
<style>
    ul li{
        line-height: 2;
        color: #333333de;
        font-size:15px;
    }
    p{
        font-size:15px !important;
    }
</style>
@endsection
<div class="bg-red p-5 text-center">
    <h1 class="text-white mb-0 py-4 f-bold" style="font-size: 50px;">Privacy</h1>
</div>
<section class="theme-container pb-0">
   <div class="auth-content">
        <h1>Privacy Statement</h1>
        <p>At Spark Engagement Inc., and Spark Engagement Index we do things a little differently so we want to make sure you understand how we collect, use and disclose your personal information.</p>
        <p>The privacy statement is directed at employees, to describe how we manage personal information of those who complete the Spark Engagement Index. We refer to these people as “Employees” in this privacy statement. The companies that engage Spark Engagement Inc. to measure engagement in their workplaces are referred to as “Employers”. What we do for Employers and Employees is referred to as the “Services”. Information that is connected to an individual Employee or can be connected to an individual Employee is referred to as “personal information”.</p>
        <h6>What is different about Spark Engagement?</h6>
        <p>At Spark Engagement Inc., we provide Employees with continued access to their personalized report to help Employees understand their engagement over time. Most companies that are in the business of measuring employee engagement focus only on the company, not on the Employee. We focus on both. So if an Employee leaves his or her job, they continue to be able to track their engagement with new employers. We see this as a value to the Employee and the Employer.</p>
        <h6>What information we collect about Employees</h6>
        <p>In order to provide the Services, we collect the following from Employees:</p>
        <ul>
            <li>Identifying information to associate one individual with their records, usually an email address;</li>
            <li>Password created by the Employee and stored in encrypted form;</li>
            <li>Information about employment status and position with the Employer (generally, this includes the following fields: Email Address, Given Name, Surname, Job Title, Department, Line Manager, Male/Female, Start Date, Length of Service, Region, Management Level, Company, Industry, Country);</li>
            <li>Answers to the Spark Engagement Index; and</li>
            <li>Analytics information related to the use of our website and use of the Services.</li>
        </ul>
        <h6>How we use personal information about Employees</h6>
        <p>We analyze the results of the Spark Engagement Index in order to provide both Employees and Employers with insights into employee engagement. Only Spark Employees with a need to know have access to Employee personal information.</p>
        <p>We provide only aggregate results to Employers so that no individual Employee can be identified from the results provided to Employers. We use statistically validated methods to mask “small groups” so that back-calculation cannot be performed. If a subset of Employees in a report is four or fewer, we will not report that information to the Employer. For example, if an Employer has fifteen office clerks, we will report on engagement among that group. But if there is only one office clerk, we will not provide a report because it would identify that one person.</p>
        <p>We provide Employees with access to their own results and give them the ability to compare their results with other colleagues and peer groups.</p>
        <p>We may also use Employee personal information for the following purposes:</p>
        <ul>
            <li>to administer and improve the Services, including ensuring that content is presented in the most effective manner for you and for your computer;</li>
            <li>to communicate with Employees regarding their use of the Services, to advise them of new features and services and to provide them with materials that we believe will be of use to them (Employees can opt-out of all non-essential communications);</li>
            <li>for internal operations, including troubleshooting, data analysis, testing, research, statistical and survey purposes; as part of our efforts to keep the Services safe and secure; or to compile reports (which do not personally identify Employees) of usage of the Services.</li>
        </ul>
        <h6>Disclosure of personal information</h6>
        <p>We will not disclose personal information of an Employee to any third party other than with the consent of the relevant individual or if we are lawfully obliged to disclose it. If we receive any legal process that would compel us to disclose any such personal information, we will make reasonable efforts to give the relevant individual notice of the disclosure, provided we are lawfully able to do so.</p>
        <p>If we were to be acquired by another company, the personal information necessary to operate Spark Engagement Inc. as a going concern would be transferred to the purchasing company. The purchasing company would be subject to this privacy statement.</p>
        <h6>Safeguarding personal information</h6>
        <p>We are required by law to safeguard the personal information in our custody or control. We use industry standard measures to protect personal information against loss or theft, as well as unauthorized access, disclosure, copying, use, or modification. We protect personal information regardless of the format in which it is held. We recognize that Employee personal information is sensitive information and we protect it accordingly.</p>
        <p>Our methods of protection include (a) physical measures, such as restricted physical access to our information system; (b) organizational measures, including limiting access on a “need-to-know” basis; and (c) technological measures, including the use of passwords and encryption.</p>
        <p>We use service providers, including data hosting providers, to facilitate providing the Services. We use contractual means to make sure that our service providers only deal with personal information on our behalf to provide the Services and not for any other purposes. We also undertake diligence to satisfy ourselves that our service providers will implement adequate safeguards to protect personal information. Our data hosting providers may store personal information outside of the jurisdiction where the relevant individual resides.</p>
        <h6>Anonymous information</h6>
        <p>Spark Engagement Inc. may use anonymized information, derived from personal information, for any purposes, including:</p>
        <ul>
            <li>Analytics to understand how users make use of the Service and our website; and</li>
            <li>For research purposes, either for Spark Engagement Inc. or for others.</li>
        </ul>
        <p>We will take industry standard steps so that this anonymous information cannot be connected to any particular individual.</p>
        <h6>Who can I contact with questions or complaints about this privacy statement?</h6>
        <p>If you have any questions or complaints regarding Spark Engagement Inc.’s privacy practices and/or this privacy statement or want to exercise your rights to access, review, correct, delete or object to the processing of your information, please contact us via email at&nbsp;<a href="mailto:hello@spark-engagement.com" rel="noopener noreferrer" target="_blank" style="color: rgb(204, 51, 102); background-color: transparent;">hello@spark-engagement.com</a>.</p>
        <h6>Updates to this privacy statement</h6>
        <p>This privacy statement may be updated periodically and without prior notice to you to reflect changes to Spark Engagement Inc.’s practices and procedures. In the event of any updates or changes to this privacy statement, Spark Engagement Inc. will always maintain the most current version of this privacy disclosure on our website(s), accompanied by the date of the revision of those terms.</p>
    </div>
</section>
<div class="footer-layer-bottom">
    <img
        src="{{asset('/assets/images/bottom-layer.svg')}}"
        alt="bottom Layer"
        class="w-100"
    />
</div>
@endsection