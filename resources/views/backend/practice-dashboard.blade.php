{{--@extends('backend.layouts.app')--}}
@extends('backend.layouts.dashboard')

@section('after-styles')
<style>
    #chart-container,
    #chart-container-yearly {
        position: relative;
    }

    #chart-container::after,
    #chart-container-yearly::after {
        position: absolute;
        content: '';
        background-color: #fff;
        height: 15px;
        width: 200px;
        bottom: 0;
        left: 0;

    }

    /* Tooltip container */
    /*  .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black; !* If you want dots under the hoverable text *!
        }*/

    /* Tooltip text */
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;

        /* Position the tooltip text - see examples below! */
        position: absolute;
        z-index: 1;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    .tooltip:hover .tooltiptext {
        visibility: visible;
    }
    .blackclr{
        color: #000;
    }
    .pd-ar-box{
        display: flex;
        align-items: center;
    }
    .paragraph-pd-clr{
        color: #787389;
    }
</style>
@endsection
@section('content-new')
<div class="content-wrapper">
    @include('backend.partials.stats')
    {{ Form::open(['route' => 'admin.search', 'class' => 'form', 'role' => 'form', 'method' => 'post','id'=>'searchDashboardFilter']) }}
    {{-- {{ Widget::searchFilter() }}--}}
    @include('widgets.search_filter')
    {{ Form::close() }}
    <br>
    <div class="table-body">
        <div class="row">
            <div class="col-md-12 col-lg-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Projected/Actual Collection</h4>

                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-2 mb-md-3"></h5>
                            </div>
                        </div>
                        <div class=" mt-12">
                            <canvas class="graph-height" id="chart-sales"></canvas>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Target VS Achievement</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center">Year To Date</h5>
                                <div class="chart-container-2-outer">
                                    <div class="chart-container-2">
                                        <div id="chart-container"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h5 class="text-center">Month To Date</h5>
                                <div class="chart-container-2-outer">
                                    <div class="chart-container-2">
                                        <div id="chart-container-yearly"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- </div>--}}

        <div class="row">

            {{-- <div class="col-md-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                 <!--<canvas id="orders-chart-azure"></canvas>-->
                                 <canvas id="bar-chart-grouped" width="800" height="450"></canvas>

                             </div>
                        </div>
                    </div>--}}
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>

                                <h4 class="card-title mb-2 mb-md-3">Account Receivables</h4>
                                <!--<h6 class="text-muted font-weight-normal">Your sales and referral earnings over the last 30 days.</h6>-->
                            </div>

                        </div>
                        <div class="mt-4" style="width:100%;">


                            <canvas id="Chart1" class="practice-Chart2"></canvas>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="row barchartbottom">
                                    <div class="col-md-4 pd-ar-box">
                                        <div>           
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="101" height="102" viewBox="0 0 101 102"> <defs> <filter id="Rectangle" x="0" y="0" width="101" height="102" filterUnits="userSpaceOnUse"> <feOffset input="SourceAlpha"/> <feGaussianBlur stdDeviation="2" result="blur"/> <feFlood flood-color="#e881b7" flood-opacity="0.498"/> <feComposite operator="in" in2="blur"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g id="Group_41782" data-name="Group 41782" transform="translate(23004 8065)"> <g transform="matrix(1, 0, 0, 1, -23004, -8065)" filter="url(#Rectangle)"> <g id="Rectangle-2" data-name="Rectangle" transform="translate(6 6)" fill="rgba(232,129,183,0.2)" stroke="#fff" stroke-width="2"> <rect width="89" height="90" rx="10" stroke="none"/> <rect x="1" y="1" width="87" height="88" rx="9" fill="none"/> </g> </g> <g id="bill-8853" transform="translate(-22971 -8032.381)"> <path id="Path_38075" data-name="Path 38075" d="M184.138,8.9a.8.8,0,0,1-.8-.8V1.182a.8.8,0,0,1,1.6,0V8.1A.8.8,0,0,1,184.138,8.9Z" transform="translate(-157.241 -0.001)" fill="#b5427e"/> <path id="Path_38076" data-name="Path 38076" d="M.8,28.935a.8.8,0,0,1-.8-.8V1.182a.8.8,0,0,1,1.6,0V28.135A.8.8,0,0,1,.8,28.935Z" transform="translate(0 -0.001)" fill="#b5427e"/> <path id="Path_38077" data-name="Path 38077" d="M188.289,217.869a.8.8,0,0,1,0-1.6,3.358,3.358,0,0,0,3.255-2.551h-7.406a.8.8,0,0,1,0-1.6h8.3a.8.8,0,0,1,.8.8A4.957,4.957,0,0,1,188.289,217.869Z" transform="translate(-157.241 -181.598)" fill="#b5427e"/> <path id="Path_38078" data-name="Path 38078" d="M184.138,155.112a.8.8,0,0,1-.8-.8v-9.727a.8.8,0,0,1,1.6,0v9.727A.8.8,0,0,1,184.138,155.112Z" transform="translate(-157.241 -122.991)" fill="#b5427e"/> <path id="Path_38079" data-name="Path 38079" d="M4.951,198.661A4.956,4.956,0,0,1,0,193.711v-3.188a.8.8,0,1,1,1.6,0v3.188a3.355,3.355,0,0,0,3.351,3.351.8.8,0,0,1,0,1.6Z" transform="translate(0 -162.39)" fill="#b5427e"/> <path id="Path_38080" data-name="Path 38080" d="M56.057,242.878h-26.1a.8.8,0,1,1,0-1.6h26.1a.8.8,0,1,1,0,1.6Z" transform="translate(-25.009 -206.606)" fill="#b5427e"/> <path id="Path_38081" data-name="Path 38081" d="M29.959,217.869a.8.8,0,0,1,0-1.6,3.355,3.355,0,0,0,3.351-3.351.8.8,0,0,1,.8-.8h17.8a.8.8,0,0,1,0,1.6H34.846A4.959,4.959,0,0,1,29.959,217.869Z" transform="translate(-25.009 -181.598)" fill="#b5427e"/> <path id="Path_38082" data-name="Path 38082" d="M50.137,136.677H39.792a.8.8,0,1,1,0-1.6H50.137a.8.8,0,1,1,0,1.6Z" transform="translate(-33.442 -115.522)" fill="#b5427e"/> <path id="Path_38083" data-name="Path 38083" d="M190.208,99.273a1.241,1.241,0,0,1-.762-2.362,1.563,1.563,0,0,1,1.562,1.562A.8.8,0,0,1,190.208,99.273Zm-.762-.762h0Z" transform="translate(-161.794 -82.79)" fill="#69c229"/> <g id="Group_40683" data-name="Group 40683" transform="translate(24.58 10.483)"> <path id="Path_38084" data-name="Path 38084" d="M184.138,73.889a.8.8,0,0,1-.8-.8v-.943a.8.8,0,0,1,1.6,0v.943A.8.8,0,0,1,184.138,73.889Z" transform="translate(-181.821 -71.346)" fill="#69c229"/> <path id="Path_38085" data-name="Path 38085" d="M175.753,82.267h-1.511a1.563,1.563,0,0,1-1.562-1.562V79.533a1.563,1.563,0,0,1,1.562-1.562h1.511a1.563,1.563,0,0,1,1.562,1.562.8.8,0,0,1-1.6.038H174.28v1.1h1.473a.8.8,0,1,1,0,1.6Z" transform="translate(-172.68 -77.029)" fill="#69c229"/> <path id="Path_38086" data-name="Path 38086" d="M184.138,118.394a.8.8,0,0,1-.8-.8v-.943a.8.8,0,0,1,1.6,0v.943A.8.8,0,0,1,184.138,118.394Z" transform="translate(-181.821 -109.516)" fill="#69c229"/> <path id="Path_38087" data-name="Path 38087" d="M175.753,105.8h-1.511a1.563,1.563,0,0,1-1.562-1.562.8.8,0,0,1,1.6-.038h1.436v-1.134a.8.8,0,1,1,1.6,0v1.173A1.564,1.564,0,0,1,175.753,105.8Zm-1.473-1.562h0Z" transform="translate(-172.68 -97.861)" fill="#69c229"/> </g> <path id="Path_38088" data-name="Path 38088" d="M55.149,170.768H39.792a.8.8,0,0,1,0-1.6H55.149a.8.8,0,0,1,0,1.6Z" transform="translate(-33.442 -144.761)" fill="#b5427e"/> <path id="Path_38089" data-name="Path 38089" d="M23.635,4.744a.8.8,0,0,1-.517-.19L20.373,2.229,17.628,4.555a.8.8,0,0,1-1.034,0L13.849,2.229,11.1,4.555a.8.8,0,0,1-1.034,0L7.324,2.229,4.579,4.555a.8.8,0,0,1-1.034,0L.282,1.791A.8.8,0,1,1,1.317.57L4.062,2.9,6.807.57a.8.8,0,0,1,1.034,0L10.586,2.9,13.331.57a.8.8,0,0,1,1.034,0L17.111,2.9,19.856.57a.8.8,0,0,1,1.034,0L23.635,2.9,26.38.57a.8.8,0,0,1,1.034,1.221L24.152,4.555A.8.8,0,0,1,23.635,4.744Z" transform="translate(0 0)" fill="#b5427e"/> <path id="Path_38090" data-name="Path 38090" d="M143.494,64.1a7.546,7.546,0,1,1,7.546-7.546A7.555,7.555,0,0,1,143.494,64.1Zm0-13.492a5.946,5.946,0,1,0,5.946,5.946A5.953,5.953,0,0,0,143.494,50.6Z" transform="translate(-116.597 -41.702)" fill="#b5427e"/> <path id="Path_38091" data-name="Path 38091" d="M47.317,102.589H39.792a.8.8,0,0,1,0-1.6h7.526a.8.8,0,0,1,0,1.6Z" transform="translate(-33.442 -86.287)" fill="#b5427e"/> <path id="Path_38092" data-name="Path 38092" d="M50.137,68.5H39.792a.8.8,0,0,1,0-1.6H50.137a.8.8,0,1,1,0,1.6Z" transform="translate(-33.442 -57.051)" fill="#b5427e"/> </g> </g></svg>
                                        </div>
                                        <div>
                                            <h3 class="blackclr">{{prettyPrice($accountReceivablesStats[0]->PrimaryBalance)}}</h3>
                                            <!-- <p class="text-purple " style="font-size: 12px;font-weight: 600;" data-toggle="tooltip" data-placement="top" title="{{prettyPrice($accountReceivablesStats[0]->PrimaryBalance)}}">Primary Open Balance
                                            </p> -->
                                            <p class="paragraph-pd-clr">Primary Open Balance</p>
                                        </div>
                                    </div>

                                    <div class="col-md-4 pd-ar-box">
                                        <div>           
                                            <svg xmlns="http://www.w3.org/2000/svg" width="101" height="102" xmlns:v="https://vecta.io/nano"><defs><filter id="A" x="0" y="0" width="101" height="102" filterUnits="userSpaceOnUse"><feOffset/><feGaussianBlur stdDeviation="2" result="A"/><feFlood flood-color="#81c8e8" flood-opacity=".502"/><feComposite operator="in" in2="A"/><feComposite in="SourceGraphic"/></filter><clipPath id="B"><path transform="translate(0 .061)" fill="#4390b3" d="M0 0h37v34H0z"/></clipPath></defs><g transform="translate(22521 8065)"><g transform="translate(-22521 -8065)" filter="url(#A)"><g transform="translate(6 6)" fill="rgba(129,200,232,0.2)" stroke="#fff"><rect width="89" height="90" rx="10" stroke="none"/><rect x="1" y="1" width="87" height="88" rx="9" fill="none" stroke-width="2"/></g></g><g transform="translate(-22489.001 -8031.062)" clip-path="url(#B)"><g fill="#4390b3"><path d="M26.789 6.818c-.18.085-.258.056-.257-.171V3.042c-.116-.028-.147.065-.2.114q-.777.771-1.547 1.549a1.24 1.24 0 0 1-.869.443.5.5 0 0 0-.354 0 1.17 1.17 0 0 1-.795-.4l-1.872-1.891c-.158-.165-.237-.148-.386.007l-1.732 1.739c-.276.333-.686.526-1.119.526s-.843-.193-1.119-.526l-1.757-1.755c-.138-.141-.213-.156-.36 0l-1.727 1.723a1.46 1.46 0 0 1-2.3-.015l-1.87-1.887L6.45 4.733c-.208.244-.505.393-.825.412a.33.33 0 0 0-.3 0 1.21 1.21 0 0 1-.88-.417q-.753-.76-1.52-1.528l-.253-.234v.312q0 13.875 0 27.75c0 .224.03.409.248.517.051.075.127.035.189.035q4.607 0 9.214 0a.46.46 0 0 0 .232-.024h4.206c.083.032.173.041.261.026q4.535 0 9.071 0c.064 0 .138.035.193-.032.181-.087.285-.282.254-.481v-3.5c0-.369 0-.369.366-.286-.244.015-.294.145-.291.379l.011 3.516v-2.957-.385c0-.475 0-.475.443-.542h1.6c.068.047.145.018.217.026.038 0 .051-.037.015-.022l-.017-.02c.1-.04.193-.085.192.09q-.008 2.06-.015 4.12c-.005.029-.015.056-.029.082-.069-.087-.036-.19-.036-.285v-3.607c-.013-.1-.065-.034-.034-.059.01-.008.017 0 .019.023.031.382.011.764.012 1.146v2.537c0 .1-.029.2.032.287-.171 1.332-1.269 2.351-2.609 2.424-.073-.03-.154-.039-.232-.026-2.416 0-4.832-.027-7.247.007q-3.845.054-7.689.014l-8.132-.02a.7.7 0 0 0-.321.025 2.79 2.79 0 0 1-2.6-2.484 6.29 6.29 0 0 0 0-.936q0-13.864 0-27.727a3.35 3.35 0 0 0 0-.88C.262 1.006 1.028.19 2.025.06a3.34 3.34 0 0 0 .591 0 2.23 2.23 0 0 1 1.426.7l1.194 1.188c.187.2.281.166.448-.012L6.914.699C7.311.27 7.865.02 8.45.006s1.15.209 1.567.618l1.384 1.375c.115.117.177.128.3 0q.618-.636 1.26-1.249a2.19 2.19 0 0 1 3.305 0L17.525 2c.118.12.183.114.3-.006L19.031.775c.336-.374.788-.625 1.284-.713h.826A2.08 2.08 0 0 1 22.315.7l1.271 1.282c.149.16.225.139.363 0q.6-.618 1.217-1.209a2.25 2.25 0 0 1 1.423-.715 3.29 3.29 0 0 0 .649.007 2.1 2.1 0 0 1 1.772 1.77.75.75 0 0 0-.024.321q0 1.922 0 3.843a1.1 1.1 0 0 1 0 .246v-3.99c0-.105-.034-.217.033-.316a.7.7 0 0 1 .045.347L29.07 6.6c0 .191-.034.249-.243.223a11.83 11.83 0 0 0-1.825-.023.71.71 0 0 0-.32-.018c.024-.029.066-.009.107.036M14.476 9.897c-.478.07-.833.478-.835.961a1.03 1.03 0 0 0 .63 1.094l2.116 1.032c.579.276.993.808 1.12 1.436a1.54 1.54 0 0 1 .017.2 2.49 2.49 0 0 0 0 .708 2 2 0 0 1-1.241 1.792 2.76 2.76 0 0 1-.871.268c-.222.027-.267.125-.26.328.013.4 0 .4-.406.4h-.059c-.45 0-.46 0-.461-.459 0-.168-.071-.217-.214-.25a4.15 4.15 0 0 1-1.413-.578 2.04 2.04 0 0 1-.949-1.857c0-.178.054-.239.238-.232H13.1c.167 0 .211.055.233.214a1.33 1.33 0 0 0 1.958 1.055.98.98 0 0 0 .561-.9.99.99 0 0 0-.458-.964 15 15 0 0 0-1.509-.742c-.316-.137-.623-.295-.918-.473a2.17 2.17 0 0 1-1.044-2.139 2.2 2.2 0 0 1 1.425-1.941 4.44 4.44 0 0 1 .729-.235c.208-.047.276-.149.248-.35-.014-.1 0-.2 0-.3-.009-.118.042-.16.155-.15h.148c.6 0 .607 0 .627.593.006.18.1.2.233.234a2.54 2.54 0 0 1 1.635 1.026 1.9 1.9 0 0 1 .341.869c-.011.017-.017.036-.018.056.078.7 0 .584-.587.593-.217 0-.434-.006-.651 0a.53.53 0 0 1-.345-.1 1.47 1.47 0 0 0-.591-1.084c-.236-.22-.53-.139-.8-.149-.061 0 .031.018.009.037M18.3 20.781l.953 1.831c-.054.127-.168.119-.276.119q-3.513 0-7.027 0c-.11 0-.22 0-.28-.118v-.059a10.35 10.35 0 0 0 .023-1.473c0-.225.063-.279.283-.278h6c.107.018.217.009.32-.027"/><path d="M.187 2.011c.094.089.055.2.055.308q0 14.463 0 28.926c0 .1.037.219-.053.309a2.77 2.77 0 0 1-.038-.677q0-14.228 0-28.455c0-.137.019-.274.029-.411m2.61 32.028c.09-.092.2-.054.309-.054q11.5 0 23 0c.1 0 .219-.038.308.054l-2.127.023q-10.6 0-21.2-.005c-.1 0-.2-.012-.294-.018m2.789-8.286c.053-.091.142-.047.212-.047q5.127 0 10.255 0c.08 0 .177-.049.242.046-.067.067-.153.113-.246.131-.166.024-.333.032-.5.024h-9.34a1.66 1.66 0 0 1-.5-.034c-.056-.022-.1-.065-.124-.12m1.804-4.999h1.567c.162 0 .225.039.222.213v1.6c0 .161-.035.225-.211.224q-1.611-.011-3.222 0c-.14 0-.189-.04-.187-.184v-1.656c0-.165.061-.194.207-.192H7.38m4.289 1.856a.61.61 0 0 0 .344.06h6.9a.62.62 0 0 0 .344-.062c.068.071.179.152-.033.166h-.148q-3.565 0-7.131-.005c-.1 0-.316.119-.272-.159"/><path d="M5.575 25.753l.056.06a.55.55 0 0 1 .093.393v1.034c0 .229.094.326.317.312h.207 9.4c.483 0 .486 0 .486-.5l-.023-1.241c.042-.068.111-.056.174-.058l.022 1.829c0 .1-.026.148-.132.14-.069-.005-.138 0-.207 0l-10.106.008c-.268 0-.33-.072-.315-.324l.028-1.65m6.982 5.805c-.081.084-.185.052-.28.052q-4.616 0-9.232 0c-.062 0-.132.033-.188-.024 0 0 0-.018.01-.02.018-.008.036-.014.055-.02h9.459c.059 0 .117.009.176.014m13.729-.01c.01 0 .021 0 .028.008s.022.023.031.036l-.225.018q-4.525 0-9.05 0c-.1 0-.219.038-.308-.054l.561-.012 8.964.006m-7.988-10.774c-.1.1-.224.055-.336.055h-5.875c-.276 0-.386.06-.365.354.025.362.008.728 0 1.092 0 .094.033.2-.057.277l-.015-1.622c0-.113.013-.18.155-.179q3.231.012 6.462.016c.01.002.019.006.027.011M29.022 1.938v4.514c-.059-.095-.082-.209-.064-.32q0-1.994 0-3.988c0-.1-.038-.219.052-.309l.012.1"/><path d="M15.861 11.092c.006-.039 0-.091.02-.113.058-.057.048.019.052.039.029.145.145.107.235.108l.968.006c.225.012.3-.069.279-.286-.01-.1-.038-.217.046-.309.158.682.158.683-.524.682h-.879c-.089 0-.213.041-.2-.127m11.204 16.204c-.414.142-.419.142-.413.626l.023 3.127c-.005.068-.017.135-.037.2-.082-.056-.042-.135-.042-.2l-.008-3.425c0-.251.057-.372.318-.343l.16.012m1.955 4.322c-.077-.056-.062-.139-.062-.216q0-1.878 0-3.757c-.001-.047.025-.09.067-.11v4.042c.006.006.009.014.008.023s-.006.016-.014.019M14.475 9.896l-.135-.021v-.031l.9.005c.115.006.067.1.026.159a1.99 1.99 0 0 0-.795-.112M21.14.065a1.4 1.4 0 0 1-.826 0c.269-.081.557-.081.826 0m7.224 8.107a1.75 1.75 0 0 1-.945 0c.314-.035.631-.035.945 0"/><path d="M27.238.064a.83.83 0 0 1-.649-.007c.213-.054.437-.052.649.007M2.611.056a.68.68 0 0 1-.591 0 1.14 1.14 0 0 1 .591 0m14.915 15.275a1 1 0 0 1 0-.708 1.77 1.77 0 0 1 0 .708m9.261-8.513l-.182-.035c.166-.044.283-.068.394.017l-.213.018m2.086 20.464l.107.035c-.109 0-.223.08-.321-.019l.215-.016M23.57 5.143c.103-.085.251-.085.354 0-.116.032-.238.032-.354 0m-18.236.006a.2.2 0 0 1 .3 0 .52.52 0 0 1-.3 0"/><path d="M26.64 3.391v3.217h-.029V3.38l.029.011m10.127 13.245h0l-.009-.412a8.8 8.8 0 0 0-4.6-6.985 7.97 7.97 0 0 0-3.8-1.067 3.56 3.56 0 0 1-.945 0 2.64 2.64 0 0 0-.618.04 8.9 8.9 0 1 0 8.653 13.521 8.36 8.36 0 0 0 1.313-4.271 1.33 1.33 0 0 1 0-.827m-8.877 7.528a7.12 7.12 0 1 1 7.124-7.1c-.012 3.926-3.198 7.102-7.124 7.1"/><path d="M20.712 16.649v.813h-.029v-.812h.029m-4.602 9.162c.164.029.116.16.116.259l.006 1.3c.009.226-.071.282-.288.281-1.34-.009-2.68 0-4.021 0-1.991 0-3.981-.005-5.972.006-.265 0-.338-.075-.327-.333l.006-1.508h10.479m-8.746-4.975h1.448c.19 0 .262.053.257.251v1.359c.005.175-.065.213-.217.216q-1.506.032-3.011 0c-.155 0-.22-.045-.215-.217v-1.359c-.005-.2.071-.253.259-.249h1.477"/></g><path d="M25.592 21.27a1.17 1.17 0 0 1-1.02-.488c-.735-.99-1.348-2.064-1.827-3.2-.059-.167-.108-.337-.146-.51a.38.38 0 0 1 .114-.429c.132-.094.306-.105.449-.028a3.17 3.17 0 0 1 .84.488l1.411 1.172c.165.145.256.119.412-.007l5.13-3.9c.3-.2.629-.368.945-.548a.58.58 0 0 1 .309-.085c.258.007.341.114.258.358-.125.323-.313.618-.553.868l-2.566 2.9-2.865 2.991c-.228.255-.55.406-.891.418" fill="#69c229"/></g></g></svg>                                       
                                        </div>
                                            <div>
                                                <h3 class="blackclr">{{prettyPrice($accountReceivablesStats[0]->SecondaryBalance)}}</h3>
                                                    <!-- <p class="text-purple" style="font-size: 12px;font-weight: 600;" data-toggle="tooltip" data-placement="top" title="{{prettyPrice($accountReceivablesStats[0]->SecondaryBalance)}}">Secondary Open Balance </p> -->
                                                    <p class="paragraph-pd-clr">Secondary Open Balance</p>
                                            </div>
                                    </div>

                                    <div class="col-md-4 pd-ar-box">
                                        <div>           
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="102" height="102" viewBox="0 0 102 102"> <defs> <filter id="Rectangle" x="0" y="0" width="102" height="102" filterUnits="userSpaceOnUse"> <feOffset input="SourceAlpha"/> <feGaussianBlur stdDeviation="2" result="blur"/> <feFlood flood-color="#e89981" flood-opacity="0.502"/> <feComposite operator="in" in2="blur"/> <feComposite in="SourceGraphic"/> </filter> </defs> <g id="Group_40672" data-name="Group 40672" transform="translate(-859 -2385)"> <g transform="matrix(1, 0, 0, 1, 859, 2385)" filter="url(#Rectangle)"> <g id="Rectangle-2" data-name="Rectangle" transform="translate(6 6)" fill="rgba(232,153,129,0.2)" stroke="#fff" stroke-width="2"> <rect width="90" height="90" rx="10" stroke="none"/> <rect x="1" y="1" width="88" height="88" rx="9" fill="none"/> </g> </g> <g id="Group_40680" data-name="Group 40680" transform="translate(-31.001 -362)"> <path id="Path_38041" data-name="Path 38041" d="M31.668,16.452A3.593,3.593,0,0,1,34.552,17.9a3.593,3.593,0,1,1,0,4.291,3.594,3.594,0,1,1-2.884-5.739ZM14.321,13.5c3.98,2.522,7.577,3.717,10.662,3.436a27.661,27.661,0,0,1-1.177,10.227H42.447a1.048,1.048,0,0,0,1.042-1.042v-13.7H1.429v13.7a1.048,1.048,0,0,0,1.042,1.042H4.989a30.476,30.476,0,0,1-1.29-10.4A15.224,15.224,0,0,0,14.321,13.5Zm8.937,15.092a15.122,15.122,0,0,1-8.9,8.374,14.678,14.678,0,0,1-8.835-8.374H2.471A2.477,2.477,0,0,1,0,26.123V2.471A2.471,2.471,0,0,1,2.471,0H42.447a2.471,2.471,0,0,1,2.467,2.467V26.116a2.477,2.477,0,0,1-2.467,2.471H23.258Zm-8.93-12.906c3.308,2.1,6.3,3.089,8.86,2.855A22.014,22.014,0,0,1,22.059,27.4l-.026.066c-.029.073-.055.146-.084.216l-.033.08c-.026.066-.055.132-.08.2l-.033.077-.088.2-.04.091-.077.164-.055.11a12.549,12.549,0,0,1-7.186,6.389,12.133,12.133,0,0,1-7.142-6.389L7.2,28.572l0-.026-.011-.022c-.026-.058-.051-.113-.077-.172L7.1,28.331l-.011-.022-.011-.022-.011-.022-.011-.022-.077-.175-.011-.022-.011-.022L6.948,28c-.037-.088-.073-.179-.11-.267l-.007-.022-.007-.022c-.026-.069-.055-.135-.08-.2l-.007-.022-.007-.022-.007-.022L6.715,27.4l-.077-.208-.007-.022A24.582,24.582,0,0,1,5.494,18.4a12.7,12.7,0,0,0,8.835-2.719ZM1.429,5.322H43.486V2.471a1.048,1.048,0,0,0-1.042-1.042H2.471A1.048,1.048,0,0,0,1.429,2.471V5.322Z" transform="translate(919 2780)" fill="#d07e65" fill-rule="evenodd"/> <path id="Path_38042" data-name="Path 38042" d="M24.36,59.688l1.89-.026.143.037a7.331,7.331,0,0,1,1.078.757,7.065,7.065,0,0,1,.694.673,27.279,27.279,0,0,1,2.164-3.016,26.149,26.149,0,0,1,2.657-2.763l.183-.069h2.065l-.417.461a43.957,43.957,0,0,0-3.487,4.4,43.068,43.068,0,0,0-2.818,4.69l-.26.5-.238-.508a12.334,12.334,0,0,0-1.594-2.584A10.456,10.456,0,0,0,24.21,60.2l.15-.508Z" transform="translate(903.639 2744.926)" fill="#69c229"/> </g> </g></svg>
                                        </div>
                                        <div>
                                                <h3 class="blackclr">{{prettyPrice($accountReceivablesStats[0]->PatientBalance)}}</h3>
                                                    <!-- <p class="text-purple" style="font-size: 12px;font-weight: 600;" data-toggle="tooltip" data-placement="top" title="{{prettyPrice($accountReceivablesStats[0]->PatientBalance)}}">Patient Balance </p> -->
                                                    <p class="paragraph-pd-clr">Patient Balance</p>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>


                </div>
            </div>

            <!--             
           <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Profit & Loss / Provider</h4>

                        <div class="align-items-center justify-content-between mt-2">
                            <div>
                                <h6 class="text-purple" style="border-left: 2px solid #f7af27;
                                        height: 17px;padding: 0 29px;margin-left: -24px;">Avg Cost / Provider</h6>
                            </div>
                            <div class="icon-box pb-4" style="font-size: 24px">
                                $0
                            </div>
                        </div>

                        <div class="align-items-center justify-content-between mt-2">
                            <div>
                                <h6 class="text-purple" style="border-left: 2px solid #04b4f0;
                                        height: 17px;padding: 0 29px;margin-left: -24px;">Avg Revenue / Provider </h6>
                            </div>
                            <div class="icon-box pb-4" style="font-size: 24px">
                                $0
                            </div>
                        </div>

                        <div class="align-items-center justify-content-between mt-2">
                            <div>
                                <h6 class="text-purple" style="border-left: 2px solid #744af4;
                                        height: 17px;padding: 0 29px;margin-left: -24px;">Net Profit / Loss</h6>
                            </div>
                            <div class="icon-box pb-4" style="font-size: 24px">
                                $0
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> -->

            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-xl-6 col-md-6  grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body background-image-graph">

                                <h4 class="card-title">
                                    Revenue / Patient Type <br/> 
                                    <small>(Based on 12 months trend)</small>

                                    <span class="graph-left-filter-btn z-index"> 
                                        <a href="#" data-canvas=".rev-in-wrap" class="btn btn-secondary rev-inout active ">In Patient</a> 
                                        <a href="#" data-canvas=".rev-out-wrap"  class="btn btn-secondary rev-inout">Out Patient</a>
                                    </span>

                                </h4>
                                
                    
                                <div class="rev-inout-wrap">
                                    <div class="rev-in-wrap active">

                                        <div class="row">
                                            <div class="col-md-6" style="padding-top:27px">
                                                <div class="mt-4">
                                                    <canvas id="traffic-chart" width="200" height="200"></canvas>
                                                    <!-- <canvas id="piechart"></canvas> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="padding-top: 48px;">
                                                <div id="traffic-chart-legend" class="chartjs-legend traffic-chart-legend mt-5">

                                                </div>
                                                <!-- <ul><li><h2 class="mb-2">40%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(145deg, #8433f7, #006699)"></span>CKD </div></li><li><h2 class="mb-2">40%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(to right, rgba(238, 143, 154, 1), rgba(233, 79, 133, 1))"></span>ESRD</div></li><li><h2 class="mb-2">20%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(145deg, #ffc173, #ff6491)"></span>Non CKD</div></li></ul> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rev-out-wrap">

                                        <div class="row">
                                            <div class="col-md-6" style="padding-top:27px">
                                                <div class="mt-4">
                                                    <canvas id="traffic2-chart" width="200" height="200"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="padding-top: 48px;">
                                                <div id="traffic2-chart-legend" class="chartjs-legend traffic-chart-legend mt-5">

                                                </div>
                                                <!-- <ul><li><h2 class="mb-2">40%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(145deg, #8433f7, #006699)"></span>CKD </div></li><li><h2 class="mb-2">40%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(to right, rgba(238, 143, 154, 1), rgba(233, 79, 133, 1))"></span>ESRD</div></li><li><h2 class="mb-2">20%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(145deg, #ffc173, #ff6491)"></span>Non CKD</div></li></ul> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-6 grid-margin">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title">Revenue Forecast Based on Patient Volume <small>(Based on 12 months trend)</small></h4>
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class=" align-items-center justify-content-between block-revenueforecast mb-30">
                                            <div>
                                                <div class="header-revenueforecast">

                                                    <h6 class="text-purple ">Patients Increase / Decrease </h6>
                                                </div>
                                                <div class="inner-revenueforecast">
                                                    <h6>
                                                        <div class="row">
                                                            <div class="col-md-8">New pts:</div>
                                                            <div class="col-md-4 text-end">{{$patientVolume[0]->new_patients}}</div>
                                                        </div>
                                                    </h6>
                                                    <h6>
                                                        <div class="row">
                                                            <div class="col-md-8">Less inactive pts:</div>
                                                            <div class="col-md-4 text-end">{{$patientVolume[0]->inactive_patients}}</div>
                                                        </div>
                                                    </h6>
                                                    <h6>

                                                        <div class="row">
                                                            <div class="col-md-8">Net impact:</div>
                                                            <div class="col-md-4 text-end">{{$patientVolume[0]->net_impact}}</div>
                                                        </div>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6  col-lg-6 col-xl-6 ">
                                        <div class=" align-items-center justify-content-between block-revenueforecast mb-30">
                                            <div class="header-revenueforecast">
                                                <h6 class="text-purple">Expected Encounters</h6>
                                            </div>
                                            <div class="inner-revenueforecast-2">
                                                <div class="icon-box-2">
                                                    {{number_format((float)(count($patientVolume)> 0)?$patientVolume[0]->expected_encounters:0, 0, '.', '')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">

                                    <div class="col-md-6 col-lg-6 col-xl-6 ">
                                        <div class=" align-items-center justify-content-between block-revenueforecast">
                                            <div class="header-revenueforecast">
                                                <h6 class="text-purple">Avg Revenue / Encounter</h6>
                                            </div>
                                            <div class="inner-revenueforecast-2">
                                                <div class="icon-box-2">
                                                    ${{number_format((float)(count($patientVolume)> 0)?$patientVolume[0]->avg_revenue_per_encounter:0, 2, '.', '')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-6 ">
                                        <div class=" align-items-center justify-content-between block-revenueforecast ">
                                            <div class="header-revenueforecast">
                                                <h6 class="text-purple">Expected Increase in Revenue</h6>
                                            </div>
                                            <div class="inner-revenueforecast-2">
                                                <div class="icon-box-2 ">
                                                ${{number_format((float)(count($patientVolume)> 0)?$patientVolume[0]->expected_increase_revenue:0, 2, '.', '')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 grid-margin">
                        <div class="card">

                            <div class="card-body">
                            <ul class="graph-label-ul graph-label-ul-2">
                            <li>
                                <span class="greenish-label-color"></span>
                                <span>Collection Amount</span>
                            </li>
                            <li>
                                <span class="purple-label-color"></span>
                                <span>Charge Amount</span>
                            </li>
                        </ul>
                            
                                <canvas id="payer-bar-charts" class="practice-Chart1" width="800" height="450"></canvas>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 grid-margin ">

                        <div class="card">
                            <div class="extra-pad">

                                <div class="card-body">
                                <h4 class="card-title">
                                    Top 10 Services
                                    <span class="graph-left-filter-btn z-index"> 
                                        <a href="#" id="cpt-code-chart" data-type="month" data-chart_type="actual" data-actual_data =""   class="btn btn-secondary active activity-cpt">Units</a> 
                                        <a href="#" id="cpt-revenue-chart" data-type="quarter" data-chart_type="actual" data-actual_data="" class="btn btn-secondary activity-revenue activity-direction">Revenue</a>
                                    </span>
                                </h4>
                                    <!--<canvas id="orders-chart-azure"></canvas>-->
                                    <div class="cpt-rev-wrap">
                                        <div class="bar-chart-cptcode active">
                                            <canvas id="bar-chart-cptcode" class="practice-Chart1" width="600" height="250"></canvas>
                                        </div>
                                        <div class="bar-chart-cptcode-revenue">
                                            <canvas id="bar-chart-cptcode-revenue" class="practice-Chart1" width="600" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

            </div>

        </div>
    </div>
    @endsection

    @section('after-scripts')
    {{-- {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}

    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}

    <script>
        $("footer .dashboard-footer").addClass("footer-margin");
    </script>
    @include('backend.partials.graph-script')

    <script>
        jQuery('body').on('click','.activity-cpt', function(e){
            e.preventDefault();

            $(".bar-chart-cptcode").addClass('active');
            $(".bar-chart-cptcode-revenue").removeClass('active');
            $('#cpt-code-chart').addClass('active');
            $('#cpt-revenue-chart').removeClass('active');




        });

        jQuery('body').on('click','.activity-revenue', function(e){
            e.preventDefault();

            $('#cpt-revenue-chart').addClass('active');
            $('#cpt-code-chart').removeClass('active');
            $(".bar-chart-cptcode").removeClass('active');
            $(".bar-chart-cptcode-revenue").addClass('active');

        });

        jQuery('body').on('click','.rev-inout', function(e){
            e.preventDefault();
            var canvasData = $(this).data('canvas');
            $('.rev-inout').removeClass('active');
            $(this).addClass('active');
            $('.rev-in-wrap').removeClass('active');
            $('.rev-out-wrap').removeClass('active');
            $(canvasData).addClass('active');

        });

    </script>



    @endsection