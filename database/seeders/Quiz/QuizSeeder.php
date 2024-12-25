<?php
// database/seeders/Quiz/QuizSeeder.php
namespace Database\Seeders\Quiz;

use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizOption;
use App\Models\Quiz\Region;
use App\Models\Quiz\QuizCategory;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $harajuku = Region::where('code', 'harajuku')->first();
        
        // 原宿の各カテゴリーのクイズを作成
        $this->createCultureQuizzes($harajuku);
        $this->createHistoryQuizzes($harajuku);
        $this->createLanguageQuizzes($harajuku);
        $this->createPeopleQuizzes($harajuku);
        $this->createEconomyQuizzes($harajuku);
    }

    private function createCultureQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'culture')->first();
        
        $quizzes = [
            [
                'question' => '原宿のファッションカルチャーを代表する通りは次のうちどれ？',
                'explanation' => '竹下通りは原宿を代表するファッションストリートで、若者向けのブティックや雑貨店が立ち並びます。',
                'options' => [
                    ['text' => '竹下通り', 'is_correct' => true],
                    ['text' => '表参道', 'is_correct' => false],
                    ['text' => '明治通り', 'is_correct' => false],
                    ['text' => '井の頭通り', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿で有名なクレープの発祥店は何年に開店した？',
                'explanation' => '1977年に開店した「アングレープ」が原宿クレープの発祥とされています。',
                'options' => [
                    ['text' => '1977年', 'is_correct' => true],
                    ['text' => '1985年', 'is_correct' => false],
                    ['text' => '1969年', 'is_correct' => false],
                    ['text' => '1982年', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿のストリートファッションを世界に発信した雑誌は？',
                'explanation' => 'FRUiTSは1997年から2017年まで、原宿のストリートファッションを世界に発信し続けた伝説的な雑誌です。',
                'options' => [
                    ['text' => 'FRUiTS', 'is_correct' => true],
                    ['text' => 'VOGUE', 'is_correct' => false],
                    ['text' => 'ELLE', 'is_correct' => false],
                    ['text' => 'GINZA', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿カルチャーを代表するファッションスタイルは？',
                'explanation' => 'デコラは1990年代後半から2000年代に流行した原宿発祥のファッションスタイルです。',
                'options' => [
                    ['text' => 'デコラ', 'is_correct' => true],
                    ['text' => 'モード', 'is_correct' => false],
                    ['text' => 'アメカジ', 'is_correct' => false],
                    ['text' => 'トラッド', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿で人気の「タピオカドリンク」が日本で流行し始めたのは？',
                'explanation' => '2015年頃から原宿を中心に若者の間で人気となり、その後全国的なブームとなりました。',
                'options' => [
                    ['text' => '2015年頃', 'is_correct' => true],
                    ['text' => '2010年頃', 'is_correct' => false],
                    ['text' => '2005年頃', 'is_correct' => false],
                    ['text' => '2020年頃', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の「カワイイ文化」を世界に広めた有名なモデルは？',
                'explanation' => 'きゃりーぱみゅぱみゅは原宿カルチャーを代表するアーティストとして世界的に知られています。',
                'options' => [
                    ['text' => 'きゃりーぱみゅぱみゅ', 'is_correct' => true],
                    ['text' => '浜崎あゆみ', 'is_correct' => false],
                    ['text' => '安室奈美恵', 'is_correct' => false],
                    ['text' => '倖田來未', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿で毎週日曜日に行われていた若者文化の象徴的なイベントは？',
                'explanation' => '歩行者天国は1977年から2019年まで、原宿の若者文化を象徴するイベントでした。',
                'options' => [
                    ['text' => '歩行者天国', 'is_correct' => true],
                    ['text' => 'フリーマーケット', 'is_correct' => false],
                    ['text' => 'ストリートライブ', 'is_correct' => false],
                    ['text' => 'コスプレパレード', 'is_correct' => false]
                ]
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createHistoryQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'history')->first();
        
        $quizzes = [
            [
                'question' => '原宿駅が開業した年は？',
                'explanation' => '原宿駅は1906年（明治39年）に開業しました。当時は原宿停車場と呼ばれていました。',
                'options' => [
                    ['text' => '1906年', 'is_correct' => true],
                    ['text' => '1920年', 'is_correct' => false],
                    ['text' => '1889年', 'is_correct' => false],
                    ['text' => '1912年', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿という地名の由来となった江戸時代の施設は？',
                'explanation' => '原宿は江戸時代、内藤新宿と千駄ヶ谷の間にあった「原の宿場」に由来します。',
                'options' => [
                    ['text' => '原の宿場', 'is_correct' => true],
                    ['text' => '原の神社', 'is_correct' => false],
                    ['text' => '原の城', 'is_correct' => false],
                    ['text' => '原の市場', 'is_correct' => false]
                ]
            ],
            [
                'question' => '1964年の東京オリンピック時、原宿に建設された施設は？',
                'explanation' => '1964年の東京オリンピックでは、選手村が原宿に建設され、現在の代々木公園の一部となっています。',
                'options' => [
                    ['text' => '選手村', 'is_correct' => true],
                    ['text' => 'メインスタジアム', 'is_correct' => false],
                    ['text' => 'プレスセンター', 'is_correct' => false],
                    ['text' => '練習場', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の表参道に、戦後初めてできたファッションブランドの旗艦店は？',
                'explanation' => '1967年にルイ・ヴィトンが表参道に日本初の店舗をオープンし、その後の表参道のブランドストリート化の先駆けとなりました。',
                'options' => [
                    ['text' => 'ルイ・ヴィトン', 'is_correct' => true],
                    ['text' => 'グッチ', 'is_correct' => false],
                    ['text' => 'エルメス', 'is_correct' => false],
                    ['text' => 'シャネル', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿のシンボル的存在である「ラフォーレ原宿」が開業したのは何年？',
                'explanation' => 'ラフォーレ原宿は1978年に開業し、原宿のファッションの中心地として大きな役割を果たしてきました。',
                'options' => [
                    ['text' => '1978年', 'is_correct' => true],
                    ['text' => '1985年', 'is_correct' => false],
                    ['text' => '1970年', 'is_correct' => false],
                    ['text' => '1990年', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の竹下通りが商店街として発展し始めたのは何年代？',
                'explanation' => '1970年代後半から、若者向けのブティックや雑貨店が増え始め、現在のような商店街として発展していきました。',
                'options' => [
                    ['text' => '1970年代', 'is_correct' => true],
                    ['text' => '1960年代', 'is_correct' => false],
                    ['text' => '1980年代', 'is_correct' => false],
                    ['text' => '1990年代', 'is_correct' => false]
                ]
            ],
            [
                'question' => '明治神宮が創建された年は？',
                'explanation' => '明治神宮は1920年（大正9年）に創建され、原宿の歴史的シンボルの一つとなっています。',
                'options' => [
                    ['text' => '1920年', 'is_correct' => true],
                    ['text' => '1900年', 'is_correct' => false],
                    ['text' => '1910年', 'is_correct' => false],
                    ['text' => '1930年', 'is_correct' => false]
                ]
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createLanguageQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'language')->first();
        
        $quizzes = [
            [
                'question' => '「原宿」の「原」の字の読み方として正しいものは？',
                'explanation' => '「原宿」の「原」は「はら」と読みます。江戸時代、この地域が原っぱだったことに由来します。',
                'options' => [
                    ['text' => 'はら', 'is_correct' => true],
                    ['text' => 'げん', 'is_correct' => false],
                    ['text' => 'わら', 'is_correct' => false],
                    ['text' => 'かわ', 'is_correct' => false]
                ]
            ],
            [
                'question' => '「竹下通り」の「竹下」の正しい読み方は？',
                'explanation' => '「竹下通り」は「たけした通り」と読みます。この通りは戦前からある古い通りの一つです。',
                'options' => [
                    ['text' => 'たけした', 'is_correct' => true],
                    ['text' => 'ちくか', 'is_correct' => false],
                    ['text' => 'たけくだり', 'is_correct' => false],
                    ['text' => 'たけもと', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の若者言葉「めっちゃ」の意味として正しいものは？',
                'explanation' => '「めっちゃ」は関西弁由来で「とても」「非常に」という意味で使われ、原宿の若者文化とともに全国に広まりました。',
                'options' => [
                    ['text' => 'とても', 'is_correct' => true],
                    ['text' => 'あまり', 'is_correct' => false],
                    ['text' => 'まったく', 'is_correct' => false],
                    ['text' => 'ほとんど', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿で生まれた若者言葉「かわいい」の英語表現として定着したものは？',
                'explanation' => '「kawaii」は日本のポップカルチャーとともに世界に広まり、英語でもそのまま使われるようになりました。',
                'options' => [
                    ['text' => 'kawaii', 'is_correct' => true],
                    ['text' => 'cute', 'is_correct' => false],
                    ['text' => 'pretty', 'is_correct' => false],
                    ['text' => 'lovely', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿ファッションで使われる「ゴス」という言葉の由来は？',
                'explanation' => '「ゴス」は「Gothic（ゴシック）」の略語で、暗めの色調や装飾的なファッションスタイルを指します。',
                'options' => [
                    ['text' => 'Gothic（ゴシック）', 'is_correct' => true],
                    ['text' => 'Gossip（ゴシップ）', 'is_correct' => false],
                    ['text' => 'Gorgeous（ゴージャス）', 'is_correct' => false],
                    ['text' => 'Gospel（ゴスペル）', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の若者言葉「まじ」の使い方として正しいものは？',
                'explanation' => '「まじ」は「本当に」という意味で使われ、驚きや感動を表現する際によく使用されます。',
                'options' => [
                    ['text' => '本当に', 'is_correct' => true],
                    ['text' => '少し', 'is_correct' => false],
                    ['text' => 'たまに', 'is_correct' => false],
                    ['text' => 'いつも', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿で使われる「激かわ」の「激」の漢字の読み方は？',
                'explanation' => '「激」は「げき」と読み、「とても」「非常に」という意味を強調する接頭語として使われます。',
                'options' => [
                    ['text' => 'げき', 'is_correct' => true],
                    ['text' => 'はげ', 'is_correct' => false],
                    ['text' => 'きょう', 'is_correct' => false],
                    ['text' => 'しょう', 'is_correct' => false]
                ]
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createPeopleQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'people')->first();
        
        $quizzes = [
            [
                'question' => '1970年代に原宿のストリートファッションを世界に発信した写真家は？',
                'explanation' => '荒木経惟は1970年代から原宿の若者文化を写真で記録し、世界に発信した先駆者の一人です。',
                'options' => [
                    ['text' => '荒木経惟', 'is_correct' => true],
                    ['text' => '篠山紀信', 'is_correct' => false],
                    ['text' => '森山大道', 'is_correct' => false],
                    ['text' => '土門拳', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿カルチャーを代表するファッションデザイナー「コムデギャルソン」のデザイナーは？',
                'explanation' => '川久保玲は、コムデギャルソンのデザイナーとして、原宿から世界的なファッションブランドを築き上げました。',
                'options' => [
                    ['text' => '川久保玲', 'is_correct' => true],
                    ['text' => '山本耀司', 'is_correct' => false],
                    ['text' => '三宅一生', 'is_correct' => false],
                    ['text' => '高田賢三', 'is_correct' => false]
                ]
            ],
            [
                'question' => '1990年代に原宿系ファッションを確立したスタイリストは？',
                'explanation' => '藤原裕は、原宿系ファッションの確立に大きく貢献し、多くの若者に影響を与えました。',
                'options' => [
                    ['text' => '藤原裕', 'is_correct' => true],
                    ['text' => '栗原貴史', 'is_correct' => false],
                    ['text' => '北村道子', 'is_correct' => false],
                    ['text' => '松田翔太', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿のストリートブランド「A BATHING APE」の創設者は？',
                'explanation' => 'NIGO（西村六郎）は、1993年に原宿で「A BATHING APE」を立ち上げ、ストリートファッションの革新者となりました。',
                'options' => [
                    ['text' => 'NIGO', 'is_correct' => true],
                    ['text' => 'HIROSHI FUJIWARA', 'is_correct' => false],
                    ['text' => 'JUN TAKAHASHI', 'is_correct' => false],
                    ['text' => 'SHINSUKE TAKIZAWA', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿発のアイドルグループ「きゃりーぱみゅぱみゅ」のプロデューサーは？',
                'explanation' => '中田ヤスタカは、原宿カルチャーを音楽で表現し、新しいポップカルチャーを生み出しました。',
                'options' => [
                    ['text' => '中田ヤスタカ', 'is_correct' => true],
                    ['text' => '秋元康', 'is_correct' => false],
                    ['text' => 'つんく♂', 'is_correct' => false],
                    ['text' => '小室哲哉', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿のファッション誌「FRUiTS」の創刊者は？',
                'explanation' => '青木正一は1997年にFRUiTSを創刊し、20年以上にわたって原宿のストリートファッションを世界に発信しました。',
                'options' => [
                    ['text' => '青木正一', 'is_correct' => true],
                    ['text' => '都築響一', 'is_correct' => false],
                    ['text' => '荒木経惟', 'is_correct' => false],
                    ['text' => '篠山紀信', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿のカフェ文化を広めた「CAFÉ STUDIO」のオーナーは？',
                'explanation' => '山本貴史は1990年代に原宿でCAFÉ STUDIOを開業し、若者の新しい集まる場所を作り出しました。',
                'options' => [
                    ['text' => '山本貴史', 'is_correct' => true],
                    ['text' => '田中健一', 'is_correct' => false],
                    ['text' => '佐藤誠', 'is_correct' => false],
                    ['text' => '鈴木道夫', 'is_correct' => false]
                ]
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createEconomyQuizzes(Region $region): void
    {
        $category = QuizCategory::where('name', 'economy')->first();
        
        $quizzes = [
            [
                'question' => '原宿の商業施設「ラフォーレ原宿」の年間来場者数は約何人？',
                'explanation' => 'ラフォーレ原宿には年間約1000万人が訪れ、原宿の主要な商業施設となっています。',
                'options' => [
                    ['text' => '約1000万人', 'is_correct' => true],
                    ['text' => '約500万人', 'is_correct' => false],
                    ['text' => '約2000万人', 'is_correct' => false],
                    ['text' => '約100万人', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の竹下通りの平均店舗賃料（1坪あたり）は？',
                'explanation' => '竹下通りの平均店舗賃料は1坪あたり約5万円で、若者向けブランドでも出店できる賃料設定となっています。',
                'options' => [
                    ['text' => '約5万円', 'is_correct' => true],
                    ['text' => '約10万円', 'is_correct' => false],
                    ['text' => '約3万円', 'is_correct' => false],
                    ['text' => '約7万円', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の主要商店街の年間売上高は約いくら？',
                'explanation' => '竹下通りを中心とする原宿の主要商店街の年間売上高は約300億円と推定されています。',
                'options' => [
                    ['text' => '約300億円', 'is_correct' => true],
                    ['text' => '約100億円', 'is_correct' => false],
                    ['text' => '約500億円', 'is_correct' => false],
                    ['text' => '約1000億円', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿エリアの小売店舗数は約何店舗？',
                'explanation' => '原宿エリアには約1000店舗の小売店があり、ファッション関連店舗が多くを占めています。',
                'options' => [
                    ['text' => '約1000店舗', 'is_correct' => true],
                    ['text' => '約500店舗', 'is_correct' => false],
                    ['text' => '約2000店舗', 'is_correct' => false],
                    ['text' => '約3000店舗', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の観光客の年間消費額は約いくら？',
                'explanation' => '原宿を訪れる観光客の年間消費額は約500億円と推定されています。',
                'options' => [
                    ['text' => '約500億円', 'is_correct' => true],
                    ['text' => '約100億円', 'is_correct' => false],
                    ['text' => '約1000億円', 'is_correct' => false],
                    ['text' => '約200億円', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の平均来街者数（1日あたり）は約何人？',
                'explanation' => '原宿には1日あたり約10万人が訪れ、週末はさらに多くの人で賑わいます。',
                'options' => [
                    ['text' => '約10万人', 'is_correct' => true],
                    ['text' => '約5万人', 'is_correct' => false],
                    ['text' => '約20万人', 'is_correct' => false],
                    ['text' => '約1万人', 'is_correct' => false]
                ]
            ],
            [
                'question' => '原宿の外国人観光客の割合は約何％？',
                'explanation' => '原宿を訪れる人の約30％が外国人観光客で、アジアからの観光客が多くを占めています。',
                'options' => [
                    ['text' => '約30％', 'is_correct' => true],
                    ['text' => '約10％', 'is_correct' => false],
                    ['text' => '約50％', 'is_correct' => false],
                    ['text' => '約20％', 'is_correct' => false]
                ]
            ]
        ];

        $this->createQuizzes($region, $category, $quizzes);
    }

    private function createQuizzes(Region $region, QuizCategory $category, array $quizData): void
    {
        foreach ($quizData as $data) {
            $quiz = Quiz::create([
                'region_id' => $region->id,
                'category_id' => $category->id,
                'question' => $data['question'],
                'explanation' => $data['explanation'],
                'is_ai_generated' => false
            ]);

            QuizOption::createOptionsForQuiz(
                $quiz->id,
                collect($data['options'])->map(function ($option) {
                    return [
                        'text' => $option['text'],
                        'is_correct' => $option['is_correct']
                    ];
                })->toArray()
            );
        }
    }
}