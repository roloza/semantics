<?php

namespace App\Custom;

class AuditValidation
{

    private $score = 0;

    public function __construct($audit)
    {
        $this->audit = $audit;
    }

    public function getStructure()
    {
        $this->score = 0;
        return [
            'Langue' => $this->validateLang(),
            'Encodage' => $this->validateEncodage(),
            'Balise <title>' => $this->validateTitle(),
            'Balise <description>' => $this->validateDescription(),
            'Balise <canonical>' => $this->validateCanonical(),
            'Titre principal (H1)' => $this->validateH1(),
            'Hiérarchie des sous titres' => $this->validateOutline(),
            'Balises <title> et <h1> différentes' => $this->validateTitlesAndH1(),
            'Balises Open Graph' => $this->validateOpenGraph(),
            'Balises Twitter Card' => $this->validateTwitterCard(),
            // 'Ratio texte / code' => '',
            'Mots totaux' => $this->validateTotalWords(),
            'Mots pertinents' => $this->validateUniqueWords(),
            // 'mots pertinents distincts' => '',
            'Phrases totales' => $this->validatePhrasesCount(),
            // 'Phrases de plus de 4 mots' => '',
            'Liens' => $this->validateLinks(),
        ];
    }

    public function getStructureScore()
    {

        $total = count($this->getStructure()) * 10;
        return (int)(($this->score * 100) / $total);
    }

    public function validateLang()
    {
        $errorLvl = 2;
        $value = '-';
        $message = '';
        $error = false;
        if (isset($this->audit['headers']) && $this->audit['headers'] != null)  {
            $value = $this->audit['headers']['lang'] ?? '-';
            if ($value === '-') {
                $error = true;
            }
        } else {
            $error = true;
        }

        if ($error) {
            $message = 'Langue non trouvée';
            $errorLvl = 0;
        }

        $this->score += ($errorLvl * 5);
        return [
            'value' => $value,
            'message' => $message,
            'errorLvl' => $errorLvl,
        ];
    }
    public function validateEncodage()
    {
        $errorLvl = 2;
        $value = '-';
        $message = '';
        $error = false;
        if (isset($this->audit['headers']) && $this->audit['headers'] != null)  {
            $value = $this->audit['headers']['encodage'] ?? '-';
            if ($value === '-') {
                $error = true;
            }
        } else {
            $error = true;
        }

        if ($error) {
            $message = 'Encodage non trouvé. Ajoutez une <meta> charset dans votre header HTML';
            $errorLvl = 0;
        }

        $this->score += ($errorLvl * 5);
        return [
            'value' => $value,
            'message' => $message,
            'errorLvl' => $errorLvl,
        ];
    }


    private function validateTitle()
    {
        $length = isset($this->audit['title'])  ? strlen($this->audit['title']) : 0;
        $message = '(' . $length . ' caractères) - Essayez de proposer une balise title au minimum de 40-45 caractères, et au maximum de 65-70 caractères';
        $errorLvl = 2;
        if ($length > 70 || $length < 40) {
            if ($length < 80 && $length > 30) {
                $errorLvl = 1;
            } else {
                $errorLvl = 0;
            }
        }
        $this->score += ($errorLvl * 5);
        return [
            'value' => $this->audit['title'] ?? '-',
            'message' => $message,
            'errorLvl' => $errorLvl,
        ];
    }

    private function validateDescription()
    {
        $errorLvl = 2;
        $message = '';
        $length = isset($this->audit['description']) ? strlen($this->audit['description']) : 0;
        if ($length === 0) {
            $message = 'Balise description manquante';
            $errorLvl = 0;
        }
        else if ($length > 170) {
            $message = '(' . $length . ' caractères) - La taille idéale maximale pour la balise description est d\'environ 155 caractères';
            if ($length > 255) {
                $errorLvl = 0;
            } else {
                $errorLvl = 1;
            }
        }

        $this->score += ($errorLvl * 5);
        return [
            'value' => $this->audit['description'] ?? '-',
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validateCanonical()
    {
        $errorLvl = 2;
        $message = '';
        if (!isset($this->audit['canonical']) || $this->audit['canonical'] === null) {
            $message = 'La balise canonical est absente. Elle n\'est pas obligatoire, mais permet d\'éviter les contenus dupliqués';
            $errorLvl = 0;
        }

        $this->score += ($errorLvl * 5);
        return [
            'value' => $this->audit['canonical'] ?? '-',
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validateH1()
    {
        $errorLvl = 2;
        $message = '';
        if (isset($this->audit['headings']['h1']) && current($this->audit['headings']['h1']) == '') {
            $message = 'La balise H1 est absente. Elle est très importante pour votre référencement';
            $errorLvl = 0;
        }
        else if (isset($this->audit['headings']['h1']) && count($this->audit['headings']['h1']) > 1) {
            $message = 'La balise H1 est dupliquée';
            $errorLvl = 0;
        }

        $this->score += ($errorLvl * 5);
        return [
            'value' => isset($this->audit['headings']['h1']) ? current($this->audit['headings']['h1']) : '-',
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validateOutline()
    {
        $errorLvl = 2;
        $message = '';
        $count = 0;
        if (isset($this->audit['headings'])) {
            foreach ($this->audit['headings'] as $tag => $headings) {
                if ($tag === 'h1') continue;
                foreach ($headings as $heading) {
                    $count++;
                }
            }
        }
        if ($count === 0 ) {
            $message = 'Essayez d\'utiliser les balises de sous-titre';
            $errorLvl = 0;
        }
        else if ($count < 3 ) {
            $message = 'Essayez d\'utiliser plus de balises de sous-titre';
            $errorLvl = 1;
        }

        $this->score += ($errorLvl * 5);
        return [
            'value' => $count,
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validateTitlesAndH1()
    {
        $errorLvl = 2;
        $message = '';

        $value = 'OK. Les balises Title et H1 sont différentes';
        if (isset($this->audit['headings']['h1']) && current($this->audit['headings']['h1']) == '') {
            $value = 'Non OK';
            $message = 'H1 vide. Comparaison impossible';
            $errorLvl = 0;
        }
        else if(isset($this->audit['title']) && strlen($this->audit['title']) === 0) {
            $value = 'Non OK';
            $message = 'Title vide. Comparaison impossible';
            $errorLvl = 0;
        }

        else if(isset($this->audit['title']) && trim($this->audit['title']) ===  trim(current($this->audit['headings']['h1']))) {
            $value = 'Non OK';
            $message = 'Title et H1 identiques';
            $errorLvl = 0;
        }


        $this->score += ($errorLvl * 5);
        return [
            'value' => $value,
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validateOpenGraph()
    {

        $errorLvl = 2;
        $value = isset($this->audit['openGraph']) ? count($this->audit['openGraph']) : 0;
        $messageArray = [];
        if (isset($this->audit['openGraph'])) {
            foreach ($this->audit['openGraph'] as $balise => $content) {
                $messageArray[] = $balise;
            }
        }
        if (count($messageArray) > 0)  {
            $message = '(' . (implode(', ', $messageArray)) . ')';
        } else {
            $message = '';
            $errorLvl = 0;
        }
        $this->score += ($errorLvl * 5);
        return [
            'value' => $value,
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validateTwitterCard()
    {
        $errorLvl = 2;
        $value = isset($this->audit['twitterCard']) ? count($this->audit['twitterCard']) : 0;
        $messageArray = [];
        if (isset($this->audit['twitterCard'])) {
            foreach ($this->audit['twitterCard'] as $balise => $content) {
                $messageArray[] = $balise;
            }
        }
        if (count($messageArray) > 0)  {
            $message = '(' . (implode(', ', $messageArray)) . ')';
        } else {
            $message = '';
            $errorLvl = 0;
        }
        $this->score += ($errorLvl * 5);
        return [
            'value' => $value,
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validateLinks()
    {
        $errorLvl = 2;
        $total = 0;
        $totalUnique = isset($this->audit['links']) ? count($this->audit['links']) : 0;
        if (isset($this->audit['links'])) {
            foreach ($this->audit['links'] as $link) {
                $total += $link['count'];
            }
        }
        $pct = $total > 0 ? (int)(($totalUnique * 100) / $total) : 0;

        $message = '';
        $value = $total . ' liens dont ' . $totalUnique . ' uniques (' . $pct .'%).';
        if ($pct > 65) {
            $message = 'Vous avez un trop grand nombre de liens duppliqués';
            $errorLvl = 0;
        }
        $this->score += ($errorLvl * 5);
        return [
            'value' => $value,
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validateTotalWords()
    {
        $errorLvl = 2;
        $value = 0;
        if (isset($this->audit['text']) && $this->audit['text'] != null)  {
            $value = (int)$this->audit['text']['wordsCount'];
        }
        $message = '';

        if ($value < 250) {
            $message = 'Essayer d\'enrichir votre contenu';
            $errorLvl = 0;
        }

        $this->score += ($errorLvl * 5);
        return [
            'value' => $value,
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validateUniqueWords()
    {
        $errorLvl = 2;
        $message = '';

        $wordsCount = 0;
        $value = 0;
        if (isset($this->audit['text']) && $this->audit['text'] != null)  {
            $wordsCount = (int)$this->audit['text']['wordsCount'];
        }
        if (isset($this->audit['text']) && $this->audit['text'] != null)  {
            $value = (int)$this->audit['text']['wordsUseFullCount'];
        }
        $pct = $wordsCount > 0 ? (int)(($value * 100) / $wordsCount) : 0;
        $message = $pct . '% des mots sont pertinents';

        if ($pct < 50) {
            $errorLvl = 1;
        }
        elseif ($pct < 30) {
            $errorLvl = 0;
        }

        $this->score += ($errorLvl * 5);
        return [
            'value' => $value,
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }

    private function validatePhrasesCount()
    {
        $errorLvl = 2;
        $message = 'Nombre de phrases trouvées dans votre contenu';
        $value = 0;

        if (isset($this->audit['text']) && $this->audit['text'] != null)  {
            $value = (int)$this->audit['text']['phrasesCount'];
        }

        if ($value < 20) {
            $message .= '. Essayer d\'enrichir votre contenu';
            $errorLvl = 0;
        }

        $this->score += ($errorLvl * 5);
        return [
            'value' => $value,
            'message' => $message,
            'errorLvl' => $errorLvl
        ];
    }
}
