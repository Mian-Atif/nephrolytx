
[
    {
        label: "This Year",
        backgroundColor: "#4472c5",
        data: [
                '{{$CKDPatientsComparison->early_stage_cnt_prior_year}}',
                '{{$CKDPatientsComparison->late_stage_cnt_prior_year}}',
                '{{$CKDPatientsComparison->esrd_cnt_prior_year}}',
            ]
    },
    {
        label: "Prior Year",
        backgroundColor: "#ed7e30",
        data: [
                '{{$CKDPatientsComparison->early_stage_cnt_analysis_year}}',
                '{{$CKDPatientsComparison->late_stage_cnt_analysis_year}}',
                '{{$CKDPatientsComparison->esrd_cnt_analysis_year}}',
            ]
    }
]