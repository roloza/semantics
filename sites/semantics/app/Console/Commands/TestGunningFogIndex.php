<?php

namespace App\Console\Commands;

use App\Custom\Tools\HtmlScrapper\HtmlScrapper;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Console\Command;

class TestGunningFogIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test-gunning-fog-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

    $content = "Vous avez eu les yeux plus gros que le ventre? Il vous reste des crêpes? Ou pire, vous n'avez pas pu faire toute votre pâte? Pas de panique, vous trouverez ici toutes les techniques qui vous permettront de conserver votre pâte, vos crêpes ou vos galettes.

CONSERVATION DE LA PÂTE À CRÊPE
AU CONGÉLATEUR
Une simple bouteille d'eau en plastique vide est idéale pour conserver votre pâte. Ne la remplissez pas entièrement, ainsi, vous pourrez la mettre au congélateur.

Quand vous souhaitez faire des crêpes, sortez la bouteille du congélateur le matin et laissez la pâte décongeler jusqu'au soir à température ambiante.

La pâte congelée se conserve sans problème pendant une durée de 2 mois.

 
AU RÉFRIGÉRATEUR
Si vous ne souhaitez ou ne pouvez pas congeler la pâte, sachez qu'elle se conserve jusqu'à 48 h au réfrigérateur, toujours dans une bouteille en plastique vide.

Avant utilisation, secouez bien la bouteille puis versez dans un grand saladier et mélangez à nouveau avec votre louche.

CONSERVATION DE VOS CRÊPES
Autant la congélation de la pâte à crêpes est efficace, autant la congélation de la crêpe par elle-même n'est pas souhaitable.
Conservez donc les crêpes en bas de votre réfrigérateur, aux plus 72 heures, enveloppées dans du papier aluminium, en intercalant à chaque fois une feuille d'essuie-tout.";


        $uri = new Uri('');
        $htmlParser = new HtmlScrapper($content, $uri);

        $text = $htmlParser->text(false);

//        $sentencesCount = explode('.', $content);
//        $words = preg_split("/[\s\']+/", $content);
        $words = self::contentToWordsList($content);
        $wordsCount = count($words);
        $sentences = self::contentToSentencesList($content);
        $sentencesCount = count($sentences);
//        $words = self::contentToWordsList($text['content']);
//
//        $wordsCount = count($words);
//        $sentencesCount = $text['phrasesCount'];


        $complexeWords = [];
        foreach ($words as $word) {
            $lexique = \App\Models\Lexique::where('forme', $word)->first();
            if ($lexique !== null && $lexique->nb_syllables >= 3) {
                $complexeWords[] = $lexique->forme;
            }
        }

        $complexeWordsCount = count($complexeWords);

        $score = 0.4 * ( ($wordsCount / $sentencesCount) + (100 * ($complexeWordsCount / $wordsCount)) );

        $res = [
            'score' => $score,
            'sentencesCount' => $sentencesCount,
            'wordsCount' => $wordsCount,
            'complexeWordsCount' => $complexeWordsCount,
            'complexeWords' => $complexeWords
        ];
        dd($res);



        return Command::SUCCESS;
    }


    private static function contentToSentencesList($content)
    {
        $sentences = preg_split("/(?<=\?|\.|!)/", $content);
        $sentences = array_filter($sentences, fn($value) => !is_null($value) && $value !== '');

        return $sentences;
    }

    private static function contentToWordsList($content)
    {
//        $content = preg_replace('/[^A-Za-z0-9\-]/', ' ', $content);
//        $content = str_replace("-", ' ', $content);
//        $content = preg_replace("`[^\p{L}']`u", ' ', $content);
        $content = preg_replace("/(\?|\.|!)/", ' ', $content);
        $words = preg_split("/[\s\']+/", $content);
//        $content = str_replace("'", ' ', $content);
//        $words = explode(' ', $content);
        $words = array_filter($words, fn($value) => !is_null($value) && $value !== '');
        return $words;
    }
}
