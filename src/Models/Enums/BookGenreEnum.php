<?php

namespace App\Models\Enums;

enum BookGenreEnum: string
{
    case CLASSIC = 'Classic';
    case COMIC_GRAPHIC_NOVEL = 'Comic/Graphic Novel';
    case CRIME_DETECTIVE = 'Crime/Detective';
    case FABLE = 'Fable';
    case FAIRY_TALE = 'Fairy tale';
    case FANFICTION = 'Fanfiction';
    case FANTASY = 'Fantasy';
    case FICTION_NARRATIVE = 'Fiction narrative';
    case FICTION_IN_VERSE = 'Fiction in verse';
    case FOLKLORE = 'Folklore';
    case HISTORICAL_FICTION = 'Historical fiction';
    case HORROR = 'Horror';
    case HUMOR = 'Humor';
    case LEGEND = 'Legend';
    case METAFICTION = 'Metafiction';
    case MYSTERY = 'Mystery';
    case MYTHOLOGY = 'Mythology';
    case MYTHOPOEIA = 'Mythopoeia';
    case REALISTIC_FICTION = 'Realistic fiction';
    case SCIENCE_FICTION = 'Science fiction';
    case SHORT_STORY = 'Short story';
    case SUSPENSE_THRILLER = 'Suspense/Thriller';
    case TALL_TALE = 'Tall tale';
    case WESTERN = 'Western';
    case BIOGRAPHY_AUTOBIOGRAPHY = 'Biography/Autobiography';
    case ESSAY = 'Essay';
    case NARRATIVE_NONFICTION = 'Narrative nonfiction';
    case SPEECH = 'Speech';
    case TEXTBOOK = 'Textbook';
    case REFERENCE_BOOK = 'Reference book';

    public static function randomValue(): string
    {
        $arr = array_column(self::cases(), 'value');

        return $arr[array_rand($arr)];
    }
}