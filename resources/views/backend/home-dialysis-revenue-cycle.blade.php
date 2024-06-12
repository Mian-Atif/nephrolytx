@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    
   

    
</div>


    

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const grideHide = {
            responsive: true,
            maintainAspectRatio: false,
            scales:{
                y:{
                    beginAtZero: true,
                    grid:{
                        display: false
                    }
                }
            },
            plugins: { legend: { display: false }, }
    };

    
    const grideHide2 = {
            responsive: true,
            maintainAspectRatio: false,
            scales:{
                y:{
                    display: false
                },
                x:{
                    display: false
                }
            },
            plugins: { 
                    legend: { display: false },
                }
    };

    /* active_patients_count_per_physician Start */
    const labels1 = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
    ];

    const data1 = {
        labels: labels1,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [
            @if(count($activePatientPerPhysicians)>0)
                @foreach($activePatientPerPhysicians as $activePatientPerPhysician)
                    {{$activePatientPerPhysician->active_patients}},
                @endforeach
            @else
                0, 10, 5, 2, 20, 30, 45, 5, 2, 20, 30, 45
            @endif
            ],
        }]
    };

    const config1 = {
        type: 'line',
        data: data1,
        options: grideHide
    };

    const myChart1 = new Chart(
        document.getElementById('myChart1'),
        config1
    );
    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config1
    );
    const myChart4 = new Chart(
        document.getElementById('myChart4'),
        config1
    );
    /* active_patients_count_per_physician End */
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    