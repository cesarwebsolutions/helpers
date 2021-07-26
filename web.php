<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // saber se o array é acessivel
    $isAccessible = Arr::accessible(['a' => 1, 'b' => 2]); //true
    $isAccessible = Arr::accessible('abc'); //false

    // se não tive o PRICE ou ele for nulo ele irá setar
    $array = Arr::add(['name' => 'Desk', 'price' => null], 'price', 100);
    $array = Arr::add(['name' => 'Desk'], 'price', 100);

    // Junta diferentes arrays em um só
    $array = Arr::collapse([[1,2,3],[4,5,6],[7,8,9]]);

    // junta 2 arrays, criando todas as possibilidades de junção entre eles
    $matrix = Arr::crossJoin([1,2], ['a', 'b']);
    $matrix = Arr::crossJoin([1,2], ['a', 'b'], ['I', 'II']);

    // divide um array, virando 2 arrys ex: um array chave e outro valor
    [$keys, $values] = Arr::divide(['name' => 'desk']);

    //faz o caminho de um array multidimencional divindo as chaves por "."
    $array = ['products' => ['desk' => ['price' => 100]]];
    $flattened = Arr::dot($array);

    // retona o array sem o par de chave/valor escolhido
    $array = ['name' => 'desk', 'price' => 100, 'teste' => 'cesar'];
    $filtered = Arr::except($array, ['price']);

    // verifica se a CHAVE fornecido existe no array obs: retorna boolean
    $array = ['name' => 'cesar', 'agr' => 17];
    $exists = Arr::exists($array, 'name');

    // retorna o primeiro elemento de um array caso a condição seja verdadeira
    $array = ['100', '200', '300'];
    $default = 10;
    $first = Arr::first($array, function($value, $key) {
        return $value >= 550;
    }, $default); // se a condição acima não for atendida retorna essa variavel

    // Faz um array unico com os valores, ignorando as chaves
    $array = ['name' => 'Joe', 'languagens' => ['PHP', 'Ruby']];
    $flattened = Arr::flatten($array);

    // remove de um array profundamente aninhado as chaves apartir de uma chave escolhida
    $array = ['products' => ['desk' => ['price' => 100]]];
    Arr::forget($array, 'products.desk');

    // busca de um array profundamente aninha o valor da chave
    $array = ['products' => ['desk' => ['price' => 100]]];
    $discount = Arr::get($array, 'products.desk.discount', 10); // o terceiro paramentro é para caso nao encontre a chave buscada

    // verifica se contem a chave em um array profundamente aninhado, retornando um boolean
    $array = ['products' => ['desk' => ['price' => 100]]];    
    $contains = Arr::has($array, 'products.desk');

    // verifica se contem as chaves de um array, se encontra uma retorna TRUE
    $array = ['products' => ['name' => 'Desk', 'price' => 100]];
    $contains = Arr::hasAny($array, ['category', 'products.discount']);


    // retorna TRUE se for um array associativo
    $isAssoc = Arr::isAssoc(['product' => ['name' => 'Desk', 'price' => 100]]);

    // retorna o ultimo elemento de array caso passe na condição
    $array = [100, 200, 300, 110];
    $default = 0;
    $last = Arr::last($array, function($value, $key) {
        return $value >= 1150;
    }, $default); // caso não atenda a condição pode retorna um valor por padrão

    // recupera as chaves escolhidas
    $array = ['name' => 'desk', 'price' => 100, 'orders' => 10];
    $slice = Arr::only($array, ['name', 'price']);

    // Recupera todos os valores para uma determidada chave de um array
    $array = [
        ['developer' => ['id' => 1, 'name' => 'Cesar']],
        ['developer' => ['id' => 2, 'name' => 'Henrique']],
    ];
    $names = Arr::pluck($array, 'developer.name', 'developer.id'); // no 3º parametro vc pode escolher a chave para retornar

    // adiciona um valor no primeiro item de um array
    $array = ['one', 'two', 'three', 'four'];
    $array = Arr::prepend($array, 'zero');
    // adiciona um valor no primeiro item de um array escolhendo o nome da chave
    $array = ['price' => 100];
    $array = Arr::prepend($array, 'Desk', 'name'); // 1º array, 2º valor, 3º chave

    // Adiciona em uma variavel o valor e remove do array
    $array = ['name' => 'Desk', 'proce' => 100];
    $name = Arr::pull($array, 'name');
    // Adiciona em uma variavel o valor e remove do array, caso não encontre retorna um valor padrão
    $array = ['name' => 'Desk', 'proce' => 100];
    $default = 200;
    $name = Arr::pull($array, 'amount', $default);

    // converte um array em uma query string
    $array = ['name' => 'Icaro', 'order' => ['column' => 'create_at', 'direction' => 'desc']];
    $query = Arr::query($array);

    // retorna um valor aleatorio do array
    $array = [1,2,3,4,5];
    $random = Arr::random($array);
    // retorna a quantidade de valores mas em um array
    $items = Arr::random($array, 1);

    // altera o valor em um array profundamente aninhado
    $array = ['products' => ['desk' => ['price' => 100]]];
    Arr::set($array, 'products.desk.price', 200);

    // embaralha um array aleatoriamente
    $array = Arr::shuffle([1, 2, 3, 4, 5]);

    // ordena um array com seus valores
    $array = ['desk', 'table', 'chair'];
    $sorted = Arr::sort($array);

    // retorna um array apartir de uma clausula fornecida
    $array = [
        ['name' => 'desk'],
        ['name' => 'table'],
        ['name' => 'chair'],
    ];
    $sorted = array_values(Arr::sort($array, function ($value){
        return $value['name'];
    }));

    // ordena os valores ex: ordem numerica alfabetica etc.
    $array = [
        ['Roman', 'Taylor', 'Li'],
        ['PHP', 'Ruby', 'JavaScript'],
        ['one' => 1, 'two' => 2, 'three' => 3],
    ];
    $sorted = Arr::sortRecursive($array);

    // retorna somente oque foi string, matendo suas chaves
    $array = [100, '200', 300, '400', 500];
    $filtered = Arr::where($array, function($value, $key){
        return is_string($value);
    });

    // transforma uma string em um array, caso seja nulo retorna um array vazio
    $string = 'Laravel';
    $array = Arr::wrap($string);

    /**
     *  FUNCTIONS GLOBAIS
     */

    //  Adiciona um valor em um array profundamente aninhado caso não tenha o valor
    $data = ['products' => ['desk' => ['price' => 100]]];
    data_fill($data, 'products.desk.price', 200);
    data_fill($data, 'products.desk.discount', 10);
    // Cria uma chave com o valor setado
    $data = [
        'products' => [
            ['name' => 'Desk 1', 'price' => 100],
            ['name' => 'Desk 2'],
        ],
    ];
    data_fill($data, 'products.*.price', 200);

    // Retorna o valor
    $data = ['products' => ['desk' => ['price' => 100]]];
    $price = data_get($data, 'products.desk.price', 10); // caso não encontre o valor retorna um valor passado no 3º parametro
    // Retorna todos os valores dos das chaves de arrays diferentetes
    $data = [
        'product-um' => ['name' => 'desk1', 'price' => 100],
        'product-dois' => ['name' => 'desk2', 'price' => 300],
    ];
    $arrayDesk = data_get($data, '*.name');

    // se achar a chave irá alterar o valor
    $data = ['products' => ['desk' => ['price' => 100]]];
    data_set($data, 'products.desk.price', 200);
    // TUDO que tiver price dentro de PRODUCTS vai setar para 200
    $data = [
        'products' => [
            ['name' => 'Desk 1', 'price' => 100],
            ['name' => 'Desk 2', 'price' => 150],
        ],
    ];
    data_set($data, 'products.*.price', 200);
    //  no 4º parametro colocando false ele so atribiu se a chave não existir
    $data = [
        'products' => [
            ['name' => 'Desk 1', 'price' => 100],
            ['name' => 'Desk 2'],
        ],
    ];
    data_set($data, 'products.*.price', 200, false);

    // retorna o primeiro valor de um array
    // $array = [100,200,300];
    $first = head($array);

    // retorna o ultimo valor
    $array = [50, 100, 200, 300, 400];
    $last = last($array);

    dd($last);

    
});
