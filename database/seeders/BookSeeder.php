<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = [
            [
                'title' => 'O Pequeno Príncipe',
                'author' => 'Antoine de Saint-Exupéry',
                'genre' => 'Fábula',
                'registration_number' => 87234,
                'synopsis' => 'Um piloto encontra-se preso no deserto do Saara após uma falha em seu avião e conhece um jovem príncipe que viaja de planeta em planeta. Este conto filosófico explora temas de amor, amizade, e a essência da humanidade.',
                'image' => 'pequeno_principe.jpg'
            ],
            [
                'title' => 'A Odisseia',
                'author' => 'Homero',
                'genre' => 'Épico',
                'registration_number' => 84573,
                'synopsis' => 'Uma das maiores epopeias da Grécia Antiga, "A Odisseia" narra as aventuras de Odisseu, que, após a Guerra de Troia, enfrenta uma longa jornada de volta para casa, cheia de desafios e provações.',
                'image' => 'odisseia.jpg'
            ],
            [
                'title' => 'Laravel Para Ninjas',
                'author' => 'Ademir C. Gabardo',
                'genre' => 'Técnico',
                'registration_number' => 92831,
                'synopsis' => 'Este livro é uma referência completa para desenvolvedores que desejam dominar o framework Laravel. Com uma abordagem prática, ensina desde os fundamentos até técnicas avançadas para construir aplicações robustas e eficientes.',
                'image' => 'laravel_para_ninjas.jpg'
            ],
            [
                'title' => 'Harry Potter E O Cálice de Fogo',
                'author' => 'J. K. Rowling',
                'genre' => 'Fantasia',
                'registration_number' => 17462,
                'synopsis' => 'No quarto ano em Hogwarts, Harry Potter participa do Torneio Tribruxo, uma competição mágica perigosa. Enfrentando desafios mortais e revelações sombrias, Harry deve lutar para sobreviver e enfrentar os perigos crescentes de Voldemort.',
                'image' => 'clice_de_fogo.jpg'
            ],
            [
                'title' => 'Só A Gente Sabe O Que Sente',
                'author' => 'Fred Elboni',
                'genre' => 'Poemas',
                'registration_number' => 31929,
                'synopsis' => 'Uma coleção de pensamentos e reflexões sobre a vida, o amor e as emoções que carregamos. Fred Elboni captura com sensibilidade as nuances dos sentimentos que muitas vezes não conseguimos expressar em palavras.',
                'image' => 'so_gente_sabe.jpg'
            ],
            [
                'title' => 'Quem É Você, Alasca?',
                'author' => 'John Green',
                'genre' => 'Romance',
                'registration_number' => 84763,
                'synopsis' => 'Miles Halter se apaixona pela enigmática Alasca Young ao ingressar em um novo colégio interno. O livro explora temas de identidade, perda e a busca pelo "Grande Talvez", enquanto os personagens navegam pelas complexidades da adolescência.',
                'image' => 'quem_e_vc_alasca.jpg'
            ],
            [
                'title' => 'O Iluminado',
                'author' => 'Stephen King',
                'genre' => 'Terror',
                'registration_number' => 33831,
                'synopsis' => 'Jack Torrance, um escritor em busca de inspiração, aceita o trabalho de zelador de inverno em um hotel isolado nas montanhas. Enquanto o inverno avança, forças sobrenaturais dentro do hotel começam a tomar conta de sua sanidade, colocando sua família em perigo.',
                'image' => 'o_iluminado.jpg'
            ]
        ];

        foreach ($books as $book) {
            DB::table('books')->insert([
                'title' => $book['title'],
                'author' => $book['author'],
                'genre' => $book['genre'],
                'registration_number' => $book['registration_number'],
                'synopsis' => $book['synopsis'],
                'image' => $book['image']
            ]);
        }
    }
}
