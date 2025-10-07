<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ingredientes')->truncate();


        $ingredientes = [
            // Carnes e Proteínas Animais (48)
            'peito de frango','coxa de frango','asa de frango','sobrecoxa de frango','coração de frango','fígado de frango',
            'carne bovina moída','alcatra','picanha','contrafilé','patinho','músculo bovino','costela bovina','acém','fraldinha',
            'filé mignon','lagarto','carne suína moída','lombo suíno','costelinha de porco','pernil','bacon','presunto',
            'linguiça toscana','linguiça calabresa','salsicha','mortadela','carne de cordeiro','carne de cabrito','carne de coelho',
            'carne de peru','peito de peru','peixe tilápia','salmão','sardinha','atum','bacalhau','cação','merluza','robalo',
            'camarão','lula','polvo','ostra','mexilhão','ovo de galinha','gema de ovo','clara de ovo','ovo de codorna',

            // Legumes e Verduras (63)
            'alface americana','alface crespa','alface roxa','rúcula','agrião','espinafre','couve-manteiga','repolho','acelga',
            'chicória','almeirão','cenoura','beterraba','batata','batata-doce','batata inglesa','inhame','mandioca','mandioquinha',
            'cará','abóbora cabotiá','abóbora moranga','abóbora japonesa','abobrinha italiana','abobrinha brasileira','pepino',
            'berinjela','tomate','tomate cereja','pimentão verde','pimentão vermelho','pimentão amarelo','cebola branca','cebola roxa',
            'alho','alho-poró','cebolinha','salsinha','coentro','manjericão','hortelã','orégano','alecrim','tomilho','louro',
            'sálvia','gengibre','açafrão-da-terra','pimenta-do-reino','pimenta calabresa','pimenta-de-cheiro','quiabo','chuchu',
            'vagem','brócolis','couve-flor','ervilha-torta','rabanete','nabo',

            // Frutas (43)
            'maçã','banana nanica','banana prata','banana maçã','banana-da-terra','mamão papaya','mamão formosa','manga','abacaxi',
            'melancia','melão','pera','uva','morango','laranja','limão','tangerina','ameixa','cereja','goiaba','maracujá','kiwi',
            'pêssego','abacate','coco','jabuticaba','acerola','caju','figo','carambola','pitanga','romã','graviola','tamarindo',
            'melão cantaloupe','mirtilo','framboesa','amora','cupuaçu','buriti',

            // Grãos, Cereais e Massas (44)
            'arroz branco','arroz integral','arroz parboilizado','arroz basmati','arroz arbório','feijão carioca','feijão preto',
            'feijão fradinho','feijão branco','lentilha','grão-de-bico','ervilha seca','soja','trigo','farinha de trigo',
            'farinha integral','aveia em flocos','aveia em farinha','cevada','centeio','quinoa','chia','linhaça','amaranto',
            'milho em grão','milho verde','fubá','amido de milho','macarrão espaguete','macarrão penne','macarrão parafuso',
            'macarrão instantâneo','lasanha','talharim','nhoque','pão francês','pão de forma','pão integral','pão sírio',
            'pão de hambúrguer','pão de hot dog','torrada','farinha de rosca','polvilho doce','polvilho azedo',

            // Laticínios e Derivados (22)
            'leite integral','leite desnatado','leite semidesnatado','leite condensado','creme de leite','manteiga','margarina',
            'queijo mussarela','queijo prato','queijo minas','queijo parmesão','queijo coalho','queijo ricota','queijo cottage',
            'queijo cheddar','requeijão','iogurte natural','iogurte grego','leite em pó','nata','creme azedo','kefir',

            // Produtos de Panificação e Farinhas (29)
            'farinha de trigo','farinha integral','farinha de rosca','fubá','farinha de arroz','farinha de milho','farinha de mandioca',
            'amido de milho','fermento biológico','fermento químico','fermento em pó','bicarbonato de sódio','fermento fresco',
            'fermento seco','fermento instantâneo','fermento de pão','massa de pizza','massa folhada','massa de pastel','massa de torta',
            'massa de lasanha','pão francês','pão de forma','pão integral','pão de leite','pão de centeio','pão sírio','bolo pronto',
            'mistura para bolo',

            // Enlatados e Conservas (16)
            'milho verde enlatado','ervilha enlatada','seleta de legumes','palmito','azeitona verde','azeitona preta','champignon',
            'picles','pepino em conserva','atum em lata','sardinha em lata','tomate pelado','molho de tomate','extrato de tomate',
            'polpa de tomate',

            // Temperos e Condimentos (42)
            'sal','açúcar','açúcar mascavo','sal grosso','sal rosa','sal marinho','pimenta-do-reino','pimenta calabresa','noz-moscada',
            'canela em pó','cravo-da-índia','curry','cominho','páprica doce','páprica picante','gengibre em pó','ervas finas',
            'coentro em pó','alho em pó','cebola em pó','vinagre branco','vinagre de maçã','vinagre balsâmico','molho shoyu',
            'molho inglês','molho de pimenta','molho barbecue','mostarda','maionese','ketchup','azeite de oliva','óleo de soja',
            'óleo de girassol','óleo de milho','óleo de coco','vinagrete',

            // Doces, Mel e Açúcares (33)
            'mel','melado','rapadura','açúcar refinado','adoçante','xarope de bordo','glucose','chocolate em pó','cacau em pó',
            'chocolate amargo','chocolate ao leite','chocolate branco','gotas de chocolate','granulado','leite condensado','creme de avelã',
            'geleia de morango','geleia de uva','geleia de damasco','doce de leite','paçoca','coco ralado',

            // Bebidas (18)
            'água','água com gás','refrigerante','suco natural','suco industrializado','chá preto','chá verde','chá de camomila',
            'café','café solúvel','leite','leite vegetal','leite de soja','leite de amêndoas','leite de aveia','achocolatado',
            'iogurte líquido','água de coco','cerveja','vinho tinto','vinho branco',

            // Sobremesas e Confeitaria (14)
            'creme de leite fresco','leite condensado','chocolate derretido','chantilly','essência de baunilha','gelatina',
            'gelatina sem sabor','amido de milho','manteiga sem sal','corante alimentício','glucose de milho','açúcar de confeiteiro',
            'essência de amêndoas','essência de coco',

            // Outros Ingredientes Comuns (33)
            'tapioca','fécula de batata','fécula de mandioca','farinha de castanha','farinha de amêndoas','castanha-do-pará',
            'castanha-de-caju','nozes','amêndoas','amendoim','pistache','avelã','gergelim','semente de abóbora','semente de girassol',
            'semente de chia','semente de linhaça','tofu','proteína de soja','proteína texturizada de soja','carne vegetal','hambúrguer vegetal',
            'leite vegetal','leite de coco','creme vegetal','maionese vegetal','azeite de dendê',
        ];

        foreach ($ingredientes as $nome) {
            DB::table('ingredientes')->updateOrInsert(
                ['nome' => $nome]
            );
        }

        $this->command->info('Lista completa de ingredientes inserida com sucesso! Total: '.count($ingredientes));
    }
}
