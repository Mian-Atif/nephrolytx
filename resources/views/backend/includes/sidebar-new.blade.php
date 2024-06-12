<nav class="sidebar sidebar-info" id="sidebar">
    <div class="sidebar-content-wrapper sidebar-offcanvas">
        <ul class="nav">
            <li class=" nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link {{ (request()->segment(2) == 'home') ? 'active' : '' }}">
                    <svg id="Group_40844" data-name="Group 40844" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="21" height="22" viewBox="0 0 21 22">
                        <defs>
                            <clipPath id="clip-path">
                                <rect id="Rectangle_17679" data-name="Rectangle 17679" width="21" height="22" fill="#fff" />
                            </clipPath>
                        </defs>
                        <g id="Group_40843" data-name="Group 40843" clip-path="url(#clip-path)">
                            <path id="Path_38136" data-name="Path 38136" d="M8.91,14.079a.46.46,0,0,1-.056.02.6.6,0,0,0-.519.655c0,1.914-.016,3.828.007,5.741A1.455,1.455,0,0,1,6.88,22q-1.112-.015-2.224,0A1.456,1.456,0,0,1,3.19,20.5c.021-2.244,0-4.489.012-6.734a.653.653,0,0,0-.669-.69c-.4,0-.8.008-1.194-.006a1.38,1.38,0,0,1-.958-2.333Q2.836,7.953,5.287,5.167L9.364.54a1.47,1.47,0,0,1,2.28,0l2.874,3.269.153.172c0-.107,0-.185,0-.263A12.036,12.036,0,0,1,14.7,2.4a1.566,1.566,0,0,1,3.111.1.534.534,0,0,1,0,.06c-.05.05-.032.115-.032.174q0,2.3,0,4.6,0-2.276,0-4.545c0-.059-.018-.123.033-.173,0,.06.01.121.01.181q0,2.313,0,4.627a.357.357,0,0,0,.1.258c.89,1.008,1.775,2.022,2.668,3.028a1.341,1.341,0,0,1,.3,1.514,1.369,1.369,0,0,1-1.327.863c-.348.008-.7,0-1.045,0a.9.9,0,0,0-.266.03.6.6,0,0,0-.445.624q0,2.626,0,5.253,0,.794,0,1.588a.4.4,0,0,1-.021.195c-.028-.036-.017-.078-.017-.118q0-3.436,0-6.871c0-.024-.007-.049,0-.056,0,2.286,0,4.587,0,6.889a.534.534,0,0,0,.011.211,1.393,1.393,0,0,1-1.055,1.13,1.491,1.491,0,0,1-.354.041c-.646,0-1.292,0-1.938,0a1.413,1.413,0,0,1-1.412-1.158,1.593,1.593,0,0,1-.013-.2.241.241,0,0,0,.012-.12q0-2.918,0-5.835c0-.037.021-.082-.02-.113a.684.684,0,0,0-.682-.5.183.183,0,0,0-.116-.015h-3.2c-.026,0-.06-.019-.079.018" transform="translate(0 0)" fill="#fff" />
                        </g>
                    </svg>
                    <span class="menu-title">Home</span>
                </a>
            </li>


            <li class="{{ (request()->segment(2) == 'quick-tools') ? 'active' : '' }} nav-item">
                <a class="nav-link" data-toggle="collapse" href="#quick_summary_menu" aria-expanded="false" aria-controls="ui-apps">
                    <svg id="Group_40917" data-name="Group 40917" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="21" height="21" viewBox="0 0 21 21">
                        <defs>
                            <clipPath id="clip-path">
                                <rect id="Rectangle_17694" data-name="Rectangle 17694" width="21" height="21" fill="#fff" />
                            </clipPath>
                        </defs>
                        <g id="Group_40915" data-name="Group 40915" clip-path="url(#clip-path)">
                            <path id="Path_38137" data-name="Path 38137" d="M17.977,485.351c.162.186.311.364.468.533.061.065.052.1-.007.157q-1.5,1.5-3,3-1.572,1.572-3.144,3.144a.429.429,0,1,0,.609.6q.96-.964,1.924-1.925l4.158-4.157c.029-.029.055-.061.088-.1.2.227.386.447.58.663.056.062,0,.083-.029.112q-.866.868-1.734,1.735-2.162,2.162-4.325,4.323a.432.432,0,0,0-.131.466.405.405,0,0,0,.361.291.433.433,0,0,0,.37-.146q.747-.749,1.5-1.5,2.261-2.261,4.52-4.523c.064-.064.092-.053.143.009.131.158.263.315.4.465.06.064.045.092-.009.146q-1.123,1.118-2.242,2.24-1.873,1.873-3.746,3.746a2.135,2.135,0,0,1-3.639-1.069,2.107,2.107,0,0,1,.62-1.949q3.092-3.093,6.186-6.185c.026-.026.054-.051.084-.081" transform="translate(-10.802 -474.476)" fill="#fff" />
                            <path id="Path_38138" data-name="Path 38138" d="M538.305,15.328c-.011.02-.023.043-.037.066q-.76,1.288-1.52,2.577a.235.235,0,0,1-.127.1,10.93,10.93,0,0,0-1.91.954,2.841,2.841,0,0,0-.45.367q-1.763,1.768-3.526,3.536c-.064.065-.1.078-.175.01-.365-.331-.735-.655-1.108-.978-.058-.05-.055-.073,0-.125,1.09-1.084,2.161-2.189,3.274-3.25a6.554,6.554,0,0,0,1.439-2.157q.129-.29.247-.585a.236.236,0,0,1,.1-.123q1.283-.755,2.565-1.514a.111.111,0,0,1,.162.02c.333.338.669.672,1,1.007.026.026.058.048.061.094" transform="translate(-517.547 -13.862)" fill="#fff" />
                            <path id="Path_38139" data-name="Path 38139" d="M20.148,16.123q-2.546-2.259-5.106-4.5-2.78-2.451-5.562-4.9a.143.143,0,0,1-.048-.187,4.744,4.744,0,0,0,.138-2.889A4.86,4.86,0,0,0,4.87,0,5.135,5.135,0,0,0,3.279.264a.177.177,0,0,0-.136.17c0,.074.049.121.1.169l2.741,2.74a.483.483,0,0,1,.008.739q-.953.956-1.909,1.909a.525.525,0,0,1-.224.142.514.514,0,0,1-.54-.177C2.41,5.045,1.5,4.141.6,3.228A.193.193,0,0,0,.25,3.31,4.9,4.9,0,0,0,.082,5.737,4.691,4.691,0,0,0,1.957,8.756,4.764,4.764,0,0,0,6.5,9.442a.186.186,0,0,1,.24.065q2.447,2.806,4.9,5.606,2.206,2.511,4.445,4.993a2.6,2.6,0,0,0,2.637.816,2.9,2.9,0,0,0,2.271-2.645,2.515,2.515,0,0,0-.846-2.154m-2.033,3.666a1.669,1.669,0,1,1,1.671-1.669,1.67,1.67,0,0,1-1.671,1.669" transform="translate(-0.001 0)" fill="#fff" />
                        </g>
                    </svg>
                    <span class="menu-title">Quick Tools</span>
                </a>
                <div class="collapse {{ (request()->segment(2) == 'quick-tools') ? 'show' : '' }}" id="quick_summary_menu">
                    <ul class="nav flex-column sub-menu">
                        <li class="{{ (request()->is('admin/quick-tools/quick-summary*')) ? 'active' : '' }} nav-item">
                            <a href="{{ route('admin.quicksummary-quicktools') }}" class="nav-link menu-level-33">
                                <span>Quick Summary</span>
                            </a>
                            <ul class="nav flex-column sub-menu">
                                <li class="{{ (request()->is('admin/quick-tools/quick-summary/esrdpatients')) ? 'active' : '' }}">
                                    <a href="{{ route('admin.esrdpatients') }}" class="nav-link">
                                        ESRD Patients
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'late-stage-ckd-patient') ? 'active' : '' }}">
                                    <a href="{{ route('admin.late-stage-ckd-patient') }}" class="nav-link">
                                        Late Stage CKD Patient
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'practice-revenue') ? 'active' : '' }}">
                                    <a href="{{ route('admin.practice-revenue') }}" class="nav-link">
                                        Practice Revenue
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'productivity-others') ? 'active' : '' }}">
                                    <a href="{{ route('admin.productivity-others') }}" class="nav-link">
                                        Productivity/Others
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ (request()->segment(3) == 'optimal-starts') ? 'active' : '' }} nav-item">
                            <a href="{{ route('admin.optimal-starts-quick-tools') }}" class="nav-link menu-level-33">
                                <span>Optimal Starts</span>
                            </a>
                            <ul class="nav flex-column sub-menu">
                                <li class="{{ (request()->segment(4) == 'summary') ? 'active' : '' }}">
                                    <a href="{{ route('admin.summary-optimal-starts') }}" class="nav-link">
                                        Summary
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'drivers') ? 'active' : '' }}">
                                    <a href="{{ route('admin.drivers-optimal-starts') }}" class="nav-link">
                                        Drivers
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'home-dialysis') ? 'active' : '' }}">
                                    <a href="{{ route('admin.home-dialysis-optimal-starts') }}" class="nav-link">
                                        Home Dialysis
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'new-start-roster') ? 'active' : '' }}">
                                    <a href="{{ route('admin.new-start-roaster') }}" class="nav-link">
                                        New Start Roster
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'late-stage-roster') ? 'active' : '' }}">
                                    <a href="{{ route('admin.late-stage-roaster') }}" class="nav-link">
                                        Late Stage Roster
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ (request()->segment(3) == 'revenue-cycle') ? 'active' : '' }} nav-item">
                            <a href="{{ route('admin.revenue-cycle-quicktools') }}" class="nav-link menu-level-33">
                                <span>Revenue Cycle</span>
                            </a>
                            <ul class="nav flex-column sub-menu">
                                <li class="{{ (request()->segment(4) == 'summary') ? 'active' : '' }}">
                                    <a href="{{ route('admin.summary-revenue-cycle') }}" class="nav-link">
                                        Summary
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'office-services') ? 'active' : '' }}">
                                    <a href="{{ route('admin.office-services') }}" class="nav-link">
                                        Office Services
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'hospital-services-revenue-cycle') ? 'active' : '' }}">
                                    <a href="{{ route('admin.hospital-services-revenue-cycle') }}" class="nav-link">
                                        Hospital Services
                                    </a>
                                </li>
                                <li class="{{ (request()->segment(4) == 'mcp-services') ? 'active' : '' }}">
                                    <a href="{{ route('admin.mcp-services') }}" class="nav-link">
                                        MCP Services
                                    </a>
                                </li>
                                <!-- <li class="{{ (request()->segment(4) == 'rate-volume-analysis') ? 'active' : '' }}">                            

                                    <a href="#" class="nav-link">
                                    Rate Volume Analysis
                                    </a>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="{{ (request()->segment(2) == 'patient-dashboard') ? 'active' : '' }} nav-item">
                <a class="nav-link {{ (request()->segment(2) == 'patient-dashboard') ? 'active' : '' }}" data-toggle="collapse" href="#quick_summary_menu_23" aria-expanded="false" aria-controls="ui-apps">
                    <svg id="Group_40718" data-name="Group 40718" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" viewBox="0 0 22 22">
                        <defs>
                            <clipPath id="clip-path">
                                <rect id="Rectangle_17656" data-name="Rectangle 17656" width="22" height="22" fill="#fff" />
                            </clipPath>
                        </defs>
                        <g id="Group_40717" data-name="Group 40717" clip-path="url(#clip-path)">
                            <path id="Path_38094" data-name="Path 38094" d="M11.18,0A11,11,0,1,0,22,11.011,11,11,0,0,0,11.18,0M3.28,13.062a1.44,1.44,0,0,1,.015-2.88,1.379,1.379,0,0,1,1.434,1.452A1.405,1.405,0,0,1,3.28,13.062M5.545,7.593A1.458,1.458,0,0,1,4.084,6.134,1.422,1.422,0,0,1,5.54,4.684a1.454,1.454,0,0,1,.005,2.909M12.1,16.037a1.842,1.842,0,0,1-3.411-1c.027-.775-.073-1.543-.109-2.314s-.1-1.57-.152-2.355q-.081-1.242-.158-2.484c-.009-.155,0-.311,0-.467L8.315,7.4c.222.4.445.8.664,1.2q1.383,2.523,2.766,5.047a1.259,1.259,0,0,0,.166.223,1.829,1.829,0,0,1,.185,2.175M11,5.285A1.449,1.449,0,0,1,9.55,3.835a1.456,1.456,0,1,1,2.912.027A1.437,1.437,0,0,1,11,5.285m4.016.831a1.466,1.466,0,0,1,1.469-1.432,1.418,1.418,0,0,1,1.437,1.467,1.453,1.453,0,1,1-2.906-.035m3.7,6.946A1.408,1.408,0,0,1,17.273,11.6a1.378,1.378,0,0,1,1.448-1.417,1.4,1.4,0,0,1,1.432,1.443,1.419,1.419,0,0,1-1.446,1.437" transform="translate(0 0)" fill="#fff" />
                        </g>
                    </svg>
                    <span class="menu-title">Patient Dashboard</span>
                </a>
                <div class="collapse {{ (request()->segment(2) == 'patient-dashboard') ? 'show' : '' }}" id="quick_summary_menu_23">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item {{ (request()->segment(3) == 'roster') ? 'active' : '' }}">
                            <a class="nav-link menu-level-33 menu-pointer">
                                <span>Roster</span>
                            </a>
                            <ul class="nav flex-column sub-menu menu-pointer">
                                <li>
                                    <a href="{{ route('admin.pt-roster-list') }}" class="nav-link {{ (request()->segment(4) == 'pt-roster-list') ? 'active' : '' }}">
                                        Pt Roster List
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.pt-follow-up-roster') }}" class="nav-link {{ (request()->segment(4) == 'pt-follow-up-roster') ? 'active' : '' }}">
                                        Pt Follow Up Roster
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item {{ (request()->segment(3) == 'patient-analytics') ? 'active' : '' }}">
                            <a class="nav-link menu-pointer menu-level-33 {{ (request()->segment(3) == 'patient-analytics') ? 'active' : '' }}">
                                <span>Patient Analytics</span>
                            </a>
                            <ul class="nav flex-column sub-menu ">
                                <li class="">
                                    <a href="{{ route('admin.no-of-pts-patientAnalysis') }}" class="nav-link {{ (request()->segment(4) == 'no-of-pts-patientAnalysis') ? 'active' : '' }}">
                                        No of Pts/Month
                                    </a>
                                </li>
                           <!--    
                                <li class="">
                                    <a href="{{ route('admin.pt-analysis-patient-analytics') }}" class="nav-link {{ (request()->segment(4) == 'pt-analysis-patient-analytics') ? 'active' : '' }}">
                                        Pt Analysis
                                    </a> 
                                </li> 
                            -->
                                <li class="">
                                    <a href="{{ route('admin.ckd-pt-comparision') }}" class="nav-link {{ (request()->segment(4) == 'ckd-pt-comparision') ? 'active' : '' }}">
                                        CKD Pt Comparison
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('admin.ckd-pt-bmi') }}" class="nav-link {{ (request()->segment(4) == 'ckd-pt-bmi') ? 'active' : '' }}">
                                        CKD Pt/BMI
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ (request()->segment(3) == 'patients-abnormal') ? 'active' : '' }}">
                            <a class="nav-link menu-pointer menu-level-33">
                                <span>Patients with Abnormal Labs</span>
                            </a>
                            <ul class="nav flex-column sub-menu">
                                <li>
                               <a href="{{ route('admin.pts-with-albumin-under') }}" class="nav-link {{ (request()->segment(4) == 'pts-with-albumin-under') ? 'active' : '' }}">

                                    <!--  <a href="{{ route('admin.pts-with-albumin-under') }}" class="nav-link"> -->
                                        Pts With Albumin under 2.0
                                    </a>
                                </li>
                                <li>
                                <a href="{{ route('admin.pts-with-gf-under') }}" class="nav-link {{ (request()->segment(4) == 'pts-with-gf-under') ? 'active' : '' }}">

                                   <!-- <a href="{{ route('admin.pts-with-gf-under') }}" class="nav-link"> -->
                                        Pts With GFR under 60
                                    </a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </li>
          
 
            <li class=" nav-item">
                  <a href="{{ route('admin.practiceDashboard') }}" class="nav-link {{ (request()->segment(2) == 'practice-dashboard') ? 'active' : '' }}">  
                      <!--  <a href="{{ route('admin.practiceDashboard') }}" class="nav-link"> -->
                    <svg id="Group_40723" data-name="Group 40723" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15.898" height="22" viewBox="0 0 15.898 22">
                        <defs>
                            <clipPath id="clip-path">
                                <rect id="Rectangle_17658" data-name="Rectangle 17658" width="15.898" height="22" fill="#fff" />
                            </clipPath>
                        </defs>
                        <g id="Group_40722" data-name="Group 40722" clip-path="url(#clip-path)">
                            <path id="Path_38111" data-name="Path 38111" d="M49.843,0a.8.8,0,0,1,.473.719.558.558,0,0,0,.62.5c.565.005,1.131,0,1.7,0,.533,0,.72.188.72.723,0,.372,0,.744,0,1.116a.565.565,0,0,1-.631.637h-6.1a.558.558,0,0,1-.63-.614q-.007-.623,0-1.245a.561.561,0,0,1,.631-.616c.565,0,1.131,0,1.7,0,.479,0,.67-.154.724-.626A.769.769,0,0,1,49.5,0Z" transform="translate(-41.722)" fill="#fff" />
                            <path id="Path_38112" data-name="Path 38112" d="M15.9,26.8a.648.648,0,0,0-.738-.735c-.573,0-1.146,0-1.718,0-.2,0-.477-.092-.595.04-.1.114-.033.38-.035.579a1.722,1.722,0,0,1-1.8,1.816q-3.061.016-6.122,0a1.72,1.72,0,0,1-1.744-1.281,3.371,3.371,0,0,1-.055-.983c0-.141-.038-.179-.179-.178-.716.007-1.432,0-2.148,0-.535,0-.763.232-.763.774q0,9,0,18c0,.55.23.779.783.779H15.111c.564,0,.787-.226.787-.8q0-4.49,0-8.979,0-4.522,0-9.044M1.289,30.714a.555.555,0,0,1,.506-.4c.071-.006.143-.006.214-.006H7.784c.48,0,.76.217.762.589s-.281.593-.758.593H4.911c-1.009,0-2.018,0-3.027,0a.583.583,0,0,1-.6-.775m.6,2.034q1.792-.01,3.583,0a.587.587,0,0,1,.627.613.6.6,0,0,1-.646.57c-.6,0-1.2,0-1.8,0-.579,0-1.159,0-1.738,0a.605.605,0,0,1-.662-.579.6.6,0,0,1,.638-.605m4.17,3.244a.6.6,0,0,1-.609.384c-.594,0-1.187,0-1.781,0s-1.159,0-1.738,0a.6.6,0,1,1,0-1.192q1.749,0,3.5,0a.6.6,0,0,1,.627.807m4.358,7.7a4.255,4.255,0,1,1,4.267-4.249,4.254,4.254,0,0,1-4.267,4.249" transform="translate(0 -23.617)" fill="#fff" />
                            <path id="Path_38113" data-name="Path 38113" d="M79.845,152.251c.532.532,1.059,1.065,1.593,1.592.845.833.513.684,1.69.7.68.007,1.36.012,2.039,0,.228-.006.223.071.168.242a2.961,2.961,0,0,1-2.448,2.188,2.921,2.921,0,0,1-3.035-1.3,3.011,3.011,0,0,1-.007-3.415" transform="translate(-71.957 -138.122)" fill="#fff" />
                            <path id="Path_38114" data-name="Path 38114" d="M94.035,138.028a3.009,3.009,0,0,1,1.958-.514,3.072,3.072,0,0,1,2.7,2.234c.047.167.043.235-.164.232-.794-.011-1.588,0-2.382,0a.289.289,0,0,1-.235-.07c-.618-.624-1.24-1.244-1.874-1.878" transform="translate(-85.308 -124.743)" fill="#fff" />
                        </g>
                    </svg>
                    
                    <span class="menu-title">Financial Dashboard</span>
                </a>
            </li>
        </ul>

       
    </div>
</nav>