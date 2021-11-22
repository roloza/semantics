@extends('layout')

@section('title')
    Lancer une analyse
@endsection

@section('description')
    Analyser la sémantique, un page unique, un site entier ou encore le web en général
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')

<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h1 class="text-lg font-medium truncate mr-5">Analyse détaillée de la page - Audit de la structure HTML</h1>
        <strong>{{ $url->url }}</strong>
    </div>

    <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
        <div class="box mt-6">
            <div class="tab w-full overflow-hidden border-t">
                <x-analyse.partials.seo.structure :auditStructure="$auditStructure"/>
            </div>
            <div class="tab w-full overflow-hidden border-t">
                <x-analyse.partials.seo.outline :audit="$audit"/>
            </div>
            <div class="tab w-full overflow-hidden border-t">
                <x-analyse.partials.seo.links :audit="$audit"/>
            </div>
            <div class="tab w-full overflow-hidden border-t">
                <x-analyse.partials.seo.images :audit="$audit"/>
            </div>
            <div class="tab w-full overflow-hidden border-t">
                <x-analyse.partials.seo.open-graph :audit="$audit"/>
            </div>
            <div class="tab w-full overflow-hidden border-t">
                <x-analyse.partials.seo.twitter-card :audit="$audit"/>
            </div>
            <div class="tab w-full overflow-hidden border-t">
                <x-analyse.partials.seo.content :audit="$audit"/>
            </div>
        </div>

    </div>


        {{-- Analyse des liens hypertextes internes (liens sortants depuis la page) --}}
        {{-- Analyse des balises alt des images --}}
        {{-- Langue et encodage --}}
        {{-- https://www.textfocus.net/audit?url=https%3A%2F%2Fwww.recette-pateacrepe.fr&recaptcha_response=03AGdBq24jgD3vVT6EwZfb_mREaSukVEMPy93Cp1YNNXiJIHIW7qyHKemdTEg1b0iopwEALgGJLha4l4CCmG-8nrYZrYBqqunlkU7kYSTaOyr6HUnqI30-f5nz3xgt6PeVg2hHxPna377B5ITtsINQuVgOLczqLJLbZbJdt-Sx48ByaW4EtfSrDMysTRgY_kGb0AyZ-iOMEAICqnthCF0COSyFMck4UPW-PiSp0YoUI5g4AFXePHNVsx_qK2aaVyDsFFlxmyPF4mZBeD7q_Vnk1juFUa6LGsoh0jWAv2S-0HVZpGITgsNPBm1A10tE9h1ehS9TcZ6IkS6D6Kra3jvU7cdo9PXWcoqg7mrD8gCStv2GN1EyOH6fv4S4m7jXgekWlUmnPbZLC0SQIloch-IRsKm53SJ6U23Nq4u2iiQx-T4nYot1_76IALqertC7P6Il_Q0DRlUWUzq_&mykeyword= --}}



    <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
        <div class="box p-5 mt-6">
            <x-analyse.partials.navigation :job="$job" :url="$url"/>
        </div>

        <div class="box p-5 mt-6 bg-theme-3 intro-x">
            <div class="flex flex-wrap gap-3">
                <div class="mr-auto">
                    <div class="text-white text-opacity-70 flex items-center leading-3">
                        Score sémantique
                    </div>
                    <div class="text-white relative text-2xl font-medium leading-5 pl-4 mt-3.5">
                        {{ $auditStructureScore }} <span class="absolute text-xl top-0 -mt-1.5">%</span>

                    </div>
                </div>
                <span class="flex items-center justify-center w-12 h-12 mr-2  text-3xl ">
                    @if ($auditStructureScore >= 70)
                        <i class="far fa-star text-theme-9"></i>
                    @elseif ($auditStructureScore >= 50)
                        <i class="far fa-star text-theme-11"></i>
                    @else
                        <i class="far fa-star text-theme-6"></i>
                    @endif
                </span>
            </div>
        </div>
    </div>


</div>

<style>
    /* Tab content - closed */
    .tab-content {
        max-height: 0;
        -webkit-transition: max-height .35s;
        -o-transition: max-height .35s;
        transition: max-height .35s;
    }
    /* :checked - resize to full height */
    .tab input:checked ~ .tab-content {
        max-height: 100%;
    }
    /* Label formatting when open */
    .tab input:checked + label{
    /*@apply text-xl p-5 border-l-2 border-indigo-500 bg-gray-100 text-indigo*/
        font-size: 1.25rem; /*.text-xl*/
        padding: 1.25rem; /*.p-5*/
        border-left-width: 2px; /*.border-l-2*/
        border-color: rgba(28,63,170); /*.border-indigo*/
        background-color: #f8fafc; /*.bg-gray-100 */
        color: rgba(28,63,170); /*.text-indigo*/
    }
    /* Icon */
    .tab label::after {
        float:right;
        right: 0;
        top: 0;
        display: block;
        width: 1.5em;
        height: 1.5em;
        line-height: 1.5;
        font-size: 1.25rem;
        text-align: center;
        -webkit-transition: all .35s;
        -o-transition: all .35s;
        transition: all .35s;
    }
    /* Icon formatting - closed */
    .tab input[type=checkbox] + label::after {
        content: "+";
        font-weight:bold; /*.font-bold*/
        border-width: 1px; /*.border*/
        border-radius: 9999px; /*.rounded-full */
        border-color: #b8c2cc; /*.border-grey*/
    }
    .tab input[type=radio] + label::after {
        content: "\25BE";
        font-weight:bold; /*.font-bold*/
        border-width: 1px; /*.border*/
        border-radius: 9999px; /*.rounded-full */
        border-color: #b8c2cc; /*.border-grey*/
    }
    /* Icon formatting - open */
    .tab input[type=checkbox]:checked + label::after {
        transform: rotate(315deg);
        background-color: rgba(28,63,170); /*.bg-indigo*/
        color: #f8fafc; /*.text-grey-lightest*/
    }
    .tab input[type=radio]:checked + label::after {
        transform: rotateX(180deg);
        background-color: rgba(28,63,170); /*.bg-indigo*/
        color: #f8fafc; /*.text-grey-lightest*/
    }
 </style>

<script>
    /* Optional Javascript to close the radio button version by clicking it again */
    var myRadios = document.getElementsByName('tabs2');
    var setCheck;
    for (x = 0; x < myRadios.length; x++) {
        myRadios[x].onclick = function() {
            if (setCheck != this) {
                 setCheck = this;
            } else {
                this.checked = false;
                setCheck = null;
            }
        };
    }
 </script>
@endsection
