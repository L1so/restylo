<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutfitCombinationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outfits = [
            // Sunny weather outfits (8 combinations)
            [
                'name' => 'Summer Casual',
                'top' => 'Light cotton t-shirt',
                'bottom' => 'Denim shorts',
                'shoes' => 'Canvas sneakers',
                'weather_condition' => 'sunny',
                'image_url' => 'https://example.com/images/summer-casual.jpg',
            ],
            [
                'name' => 'Beach Ready',
                'top' => 'Tank top',
                'bottom' => 'Linen shorts',
                'shoes' => 'Flip-flops',
                'weather_condition' => 'sunny',
                'image_url' => 'https://example.com/images/beach-ready.jpg',
            ],
            [
                'name' => 'Office Summer',
                'top' => 'Lightweight button-up shirt',
                'bottom' => 'Chino pants',
                'shoes' => 'Loafers',
                'weather_condition' => 'sunny',
                'image_url' => 'https://example.com/images/office-summer.jpg',
            ],
            [
                'name' => 'Sunny Sporty',
                'top' => 'Moisture-wicking athletic shirt',
                'bottom' => 'Athletic shorts',
                'shoes' => 'Running shoes',
                'weather_condition' => 'sunny',
                'image_url' => 'https://example.com/images/sunny-sporty.jpg',
            ],
            [
                'name' => 'Garden Party',
                'top' => 'Flowy blouse',
                'bottom' => 'Midi skirt',
                'shoes' => 'Sandals',
                'weather_condition' => 'sunny',
                'image_url' => 'https://example.com/images/garden-party.jpg',
            ],
            [
                'name' => 'Sunny Brunch',
                'top' => 'Polo shirt',
                'bottom' => 'Bermuda shorts',
                'shoes' => 'Boat shoes',
                'weather_condition' => 'sunny',
                'image_url' => 'https://example.com/images/sunny-brunch.jpg',
            ],
            [
                'name' => 'Festival Vibes',
                'top' => 'Graphic tee',
                'bottom' => 'Distressed jeans',
                'shoes' => 'High-top sneakers',
                'weather_condition' => 'sunny',
                'image_url' => 'https://example.com/images/festival-vibes.jpg',
            ],
            [
                'name' => 'Sunny Elegant',
                'top' => 'Silk camisole',
                'bottom' => 'Wide-leg trousers',
                'shoes' => 'Block heel sandals',
                'weather_condition' => 'sunny',
                'image_url' => 'https://example.com/images/sunny-elegant.jpg',
            ],

            // Rainy weather outfits (8 combinations)
            [
                'name' => 'Rainy Day Comfort',
                'top' => 'Hoodie',
                'bottom' => 'Waterproof jeans',
                'shoes' => 'Rain boots',
                'weather_condition' => 'rainy',
                'image_url' => 'https://example.com/images/rainy-comfort.jpg',
            ],
            [
                'name' => 'Storm Office',
                'top' => 'Wool sweater',
                'bottom' => 'Dark dress pants',
                'shoes' => 'Waterproof dress shoes',
                'weather_condition' => 'rainy',
                'image_url' => 'https://example.com/images/storm-office.jpg',
            ],
            [
                'name' => 'Trendy Rainwear',
                'top' => 'Trench coat over turtleneck',
                'bottom' => 'Skinny jeans',
                'shoes' => 'Ankle boots',
                'weather_condition' => 'rainy',
                'image_url' => 'https://example.com/images/trendy-rainwear.jpg',
            ],
            [
                'name' => 'Cozy Rainy',
                'top' => 'Cardigan over long-sleeve shirt',
                'bottom' => 'Leggings',
                'shoes' => 'Waterproof sneakers',
                'weather_condition' => 'rainy',
                'image_url' => 'https://example.com/images/cozy-rainy.jpg',
            ],
            [
                'name' => 'Rain Athletic',
                'top' => 'Waterproof jacket',
                'bottom' => 'Track pants',
                'shoes' => 'Waterproof running shoes',
                'weather_condition' => 'rainy',
                'image_url' => 'https://example.com/images/rain-athletic.jpg',
            ],
            [
                'name' => 'Stylish Storm',
                'top' => 'Denim jacket over sweater',
                'bottom' => 'Black jeans',
                'shoes' => 'Combat boots',
                'weather_condition' => 'rainy',
                'image_url' => 'https://example.com/images/stylish-storm.jpg',
            ],
            [
                'name' => 'Rainy Professional',
                'top' => 'Blazer with scarf',
                'bottom' => 'Tailored trousers',
                'shoes' => 'Oxford shoes',
                'weather_condition' => 'rainy',
                'image_url' => 'https://example.com/images/rainy-professional.jpg',
            ],
            [
                'name' => 'Weekend Rain',
                'top' => 'Flannel shirt',
                'bottom' => 'Corduroy pants',
                'shoes' => 'Hiking boots',
                'weather_condition' => 'rainy',
                'image_url' => 'https://example.com/images/weekend-rain.jpg',
            ],

            // Cloudy weather outfits (8 combinations)
            [
                'name' => 'Cloudy Casual',
                'top' => 'Light sweater',
                'bottom' => 'Straight jeans',
                'shoes' => 'White sneakers',
                'weather_condition' => 'cloudy',
                'image_url' => 'https://example.com/images/cloudy-casual.jpg',
            ],
            [
                'name' => 'Overcast Office',
                'top' => 'Button-up shirt with vest',
                'bottom' => 'Dress pants',
                'shoes' => 'Leather dress shoes',
                'weather_condition' => 'cloudy',
                'image_url' => 'https://example.com/images/overcast-office.jpg',
            ],
            [
                'name' => 'Cloudy Chic',
                'top' => 'Blazer over blouse',
                'bottom' => 'Ankle-length trousers',
                'shoes' => 'Low heels',
                'weather_condition' => 'cloudy',
                'image_url' => 'https://example.com/images/cloudy-chic.jpg',
            ],
            [
                'name' => 'Gentle Weather',
                'top' => 'Cardigan',
                'bottom' => 'Midi dress',
                'shoes' => 'Ballet flats',
                'weather_condition' => 'cloudy',
                'image_url' => 'https://example.com/images/gentle-weather.jpg',
            ],
            [
                'name' => 'Cloudy Athletic',
                'top' => 'Light zip-up jacket',
                'bottom' => 'Joggers',
                'shoes' => 'Cross-training shoes',
                'weather_condition' => 'cloudy',
                'image_url' => 'https://example.com/images/cloudy-athletic.jpg',
            ],
            [
                'name' => 'Casual Meeting',
                'top' => 'Henley shirt',
                'bottom' => 'Khaki pants',
                'shoes' => 'Casual oxfords',
                'weather_condition' => 'cloudy',
                'image_url' => 'https://example.com/images/casual-meeting.jpg',
            ],
            [
                'name' => 'Cloudy Weekend',
                'top' => 'Pullover sweater',
                'bottom' => 'Relaxed jeans',
                'shoes' => 'Slip-on shoes',
                'weather_condition' => 'cloudy',
                'image_url' => 'https://example.com/images/cloudy-weekend.jpg',
            ],
            [
                'name' => 'Layered Look',
                'top' => 'T-shirt with light jacket',
                'bottom' => 'Chinos',
                'shoes' => 'Minimalist sneakers',
                'weather_condition' => 'cloudy',
                'image_url' => 'https://example.com/images/layered-look.jpg',
            ],

            // Cold weather outfits (8 combinations)
            [
                'name' => 'Winter Warmth',
                'top' => 'Heavy wool sweater',
                'bottom' => 'Thermal leggings under jeans',
                'shoes' => 'Winter boots',
                'weather_condition' => 'cold',
                'image_url' => 'https://example.com/images/winter-warmth.jpg',
            ],
            [
                'name' => 'Cold Office',
                'top' => 'Turtleneck under blazer',
                'bottom' => 'Wool trousers',
                'shoes' => 'Leather boots',
                'weather_condition' => 'cold',
                'image_url' => 'https://example.com/images/cold-office.jpg',
            ],
            [
                'name' => 'Cozy Layers',
                'top' => 'Thermal shirt with cardigan',
                'bottom' => 'Fleece-lined jeans',
                'shoes' => 'Insulated sneakers',
                'weather_condition' => 'cold',
                'image_url' => 'https://example.com/images/cozy-layers.jpg',
            ],
            [
                'name' => 'Winter Sporty',
                'top' => 'Fleece pullover',
                'bottom' => 'Thermal track pants',
                'shoes' => 'Winter running shoes',
                'weather_condition' => 'cold',
                'image_url' => 'https://example.com/images/winter-sporty.jpg',
            ],
            [
                'name' => 'Cold Weather Chic',
                'top' => 'Cashmere sweater',
                'bottom' => 'Wool skirt with tights',
                'shoes' => 'Knee-high boots',
                'weather_condition' => 'cold',
                'image_url' => 'https://example.com/images/cold-chic.jpg',
            ],
            [
                'name' => 'Bundled Up',
                'top' => 'Hoodie under puffer jacket',
                'bottom' => 'Insulated pants',
                'shoes' => 'Snow boots',
                'weather_condition' => 'cold',
                'image_url' => 'https://example.com/images/bundled-up.jpg',
            ],
            [
                'name' => 'Elegant Winter',
                'top' => 'Wool coat over dress',
                'bottom' => 'Thick tights',
                'shoes' => 'Heeled ankle boots',
                'weather_condition' => 'cold',
                'image_url' => 'https://example.com/images/elegant-winter.jpg',
            ],
            [
                'name' => 'Cold Casual',
                'top' => 'Flannel shirt with vest',
                'bottom' => 'Corduroy pants',
                'shoes' => 'Work boots',
                'weather_condition' => 'cold',
                'image_url' => 'https://example.com/images/cold-casual.jpg',
            ],
        ];

        foreach ($outfits as $outfit) {
            DB::table('outfit_combinations')->insert(array_merge($outfit, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
