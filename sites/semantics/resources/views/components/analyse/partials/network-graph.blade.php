<div>
    <div class="intro-y flex items-center h-10">
        <h2 id="keywordGraph-title" class="text-lg font-medium truncate mr-5">Suggestions d'expression sur le thême <strong id="keywordGraph-keyword">{{ ucfirst(urldecode($keyword)) }}</strong></h2>
        <a href="{{ route('accueil') }}" class="btn btn-dark ml-auto truncate">Afficher les détails</a>
    </div>

    <div class="intro-y box p-5 mt-5">
        <button id="btn-reset-keyword-graph" class="btn btn-sm btn-outline-primary w-24 mr-1 mb-2">Reset</button>
        <div  id="network-graph-container">
            <div id="loader" class="fa-3x">
                <i class="fas fa-spinner fa-spin"></i>
                <div>Chargement en cours. Merci de patienter...</div>
            </div>
            <div style="height:200px" id="network-graph">
            </div>
        </div>
    </div>

    @section('script')
        @parent

        <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-core.min.js"></script>
        <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-graph.min.js"></script>
        <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-data-adapter.min.js"></script>

        <script>
            anychart.onDocumentReady(function () {
                loadNetworkGraph("{{ $keyword }}");

                document.getElementById("btn-reset-keyword-graph").addEventListener("click", function() {
                        reloadNetworkGraph("{{ $keyword }}");
                });
            });


            var reloadNetworkGraph = function (keyword) {
                var elem = document.getElementById("network-graph");
                        elem.parentNode.removeChild(elem);
                        document.getElementById("loader").hidden = false;
                        var div = document.createElement('div');
                        div.setAttribute("id", "network-graph");
                        document.getElementById('network-graph-container').appendChild(div)
                        document.getElementById('keywordGraph-keyword').innerHTML = keyword.charAt(0).toUpperCase() + keyword.slice(1);
                        document.getElementById("network-graph").style.height = "300px";
                        loadNetworkGraph(keyword);
            }

            var loadNetworkGraph = function(keyword) {
                anychart.data.loadJsonFile("{{ route('ajax.networkgraph-data', $job->uuid) }}?keyword=" + keyword, function (data) {

                    // create a chart from the loaded data
                    var chart = anychart.graph(data);

                    chart.listen("dblClick", function(e) {
                        reloadNetworkGraph(e.domTarget.tag.id);
                    });

                    chart.interactivity(false);

                    // access nodes
                    var nodes = chart.nodes();

                    // set the size of nodes
                    nodes.normal().height(25);


                    // set the stroke of nodes
                    nodes.normal().stroke(null);
                    nodes.hovered().stroke("#333333", 3);
                    nodes.selected().stroke("#333333", 3);

                    // enable the labels of nodes
                    chart.nodes().labels().enabled(true);

                    // configure the labels of nodes
                    chart.nodes().labels().format("{%id}");
                    chart.nodes().labels().fontSize(12);
                    chart.nodes().labels().fontWeight(200);

                    chart.layout().type('force');

                    // draw the chart
                    chart.container("network-graph").draw();
                    document.getElementById("loader").hidden = true;
                    document.getElementById("network-graph").style.height = "1300px";
                });
            };


        </script>

    @endSection
