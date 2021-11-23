<div>
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">{{ $name }}</h2>
        @if (isset($showMore) && $showMore)
        <a href="{{ route('analyse.show.descripteurs', [$job->type->slug, $job->uuid]) }}" class="btn btn-dark ml-auto truncate">Afficher les détails</a>
        @endif
    </div>
    <div class="intro-y box p-5 mt-5">
        <div id="word-cloud"></div>
    </div>


    @section('script')
        @parent
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/wordcloud.js"></script>
        <script src="https://code.highcharts.com/modules/networkgraph.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>


        <script>
            Highcharts.chart('word-cloud', {

                series: [{
                    colors: ['#FF8B26', '#D32a2a', '#91C715', '#285FD3', '#FFC533'],
                    rotation: {
                        from: -30,
                        to: 30,
                        orientations: 20,

                    },
                    maxFontSize: 120,
                    minFontSize: 20,
                    type: 'wordcloud',
                    data: {!! $data  !!}
                }],
                title: {
                    text: ''
                },
                tooltip: {
                    enabled: false
                }
            });


        </script>

    @endsection



</div>
