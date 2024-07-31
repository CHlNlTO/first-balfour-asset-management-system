<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetSeeder extends Seeder
{
    public function run()
    {
        // List of brands and their models
        $brandsAndModels = [
            // **Apple**:
            'Apple' => [
                'models' => [
                    'iPhone 14 Pro', 'iPhone 14', 'iPhone 13 Pro', 'iPhone 13', 'iPhone SE (3rd generation)', 
                    'iPad Pro (12.9-inch, 6th generation)', 'iPad Pro (11-inch, 4th generation)', 'iPad Air (5th generation)', 
                    'iPad (10th generation)', 'iPad mini (6th generation)', 'MacBook Pro (16-inch, 2023)', 
                    'MacBook Pro (14-inch, 2023)', 'MacBook Air (M2, 2022)', 'iMac (24-inch, 2021)', 'Mac Studio', 
                    'Mac mini (M2, 2023)', 'Apple Watch Ultra', 'Apple Watch Series 8', 'Apple Watch SE (2nd generation)', 
                    'AirPods Pro (2nd generation)', 'AirPods (3rd generation)', 'AirPods Max', 'HomePod (2nd generation)', 
                    'Apple TV 4K (2022)', 'Apple TV HD', 'Magic Keyboard', 'Magic Mouse', 'Magic Trackpad', 
                    'Pro Display XDR', 'Apple Pencil (2nd generation)', 'Apple Pencil (1st generation)', 'Mac Pro (2023)', 
                    'Apple Studio Display', 'iPhone 12 Pro Max', 'iPhone 12 Mini', 'iPhone 11 Pro', 'iPhone 11', 
                    'iPhone XR', 'iPhone X', 'iPhone 8 Plus', 'iPhone 8', 'iPad Pro (12.9-inch, 5th generation)', 
                    'iPad Pro (11-inch, 3rd generation)', 'iPad Air (4th generation)', 'iPad (9th generation)', 
                    'iPad mini (5th generation)', 'MacBook Pro (13-inch, 2022)', 'iMac (27-inch, 2020)', 'MacBook Air (2020)'
                ]
            ],
            // **Samsung**:
            'Samsung' => [
                'models' => [
                    'Galaxy S23 Ultra', 'Galaxy S23+', 'Galaxy S23', 'Galaxy Note 20 Ultra', 'Galaxy Z Fold 4',
                    'Galaxy Z Flip 4', 'Galaxy Tab S8 Ultra', 'Galaxy Tab S8+', 'Galaxy Tab S8', 'Galaxy Buds 2 Pro',
                    'Galaxy Watch 5 Pro', 'Galaxy Watch 5', 'Galaxy A54', 'Galaxy A34', 'Galaxy A14'
                ]
            ],
            // **Dell**:
            'Dell' => [
                'models' => [
                    'XPS 13', 'XPS 15', 'Alienware x17', 'Inspiron 14', 'Latitude 7420',
                    'G15 Gaming Laptop', 'XPS 17', 'Precision 5560', 'Vostro 15', 'Latitude 9520'
                ]
            ],
            // **HP**:
            'HP' => [
                'models' => [
                    'Spectre x360 14', 'Envy 15', 'Omen 17', 'Pavilion 27', 'Elite Dragonfly',
                    'HP Reverb G2', 'Pavilion x360', 'ENVY 14', 'ZBook Studio G8', 'HP 27f'
                ]
            ],
            // **Lenovo**:
            'Lenovo' => [
                'models' => [
                    'ThinkPad X1 Carbon (9th Gen)', 'Legion 5 Pro', 'Yoga 9i', 'IdeaPad Flex 5', 'ThinkPad T14s',
                    'ThinkPad X1 Extreme Gen 4', 'Legion 7i', 'Yoga 7i', 'ThinkPad P52', 'IdeaPad 3'
                ]
            ],
            // **Asus**:
            'Asus' => [
                'models' => [
                    'ROG Zephyrus G14', 'ZenBook 14', 'VivoBook Pro 16', 'TUF Gaming A15', 'ProArt Studiobook',
                    'ROG Flow Z13', 'ZenBook Duo 14', 'ROG Strix Scar 15', 'VivoBook 15', 'ROG Zephyrus M16'
                ]
            ],
            // **Acer**:
            'Acer' => [
                'models' => [
                    'Predator Helios 300', 'Aspire 7', 'Swift X', 'ConceptD 7', 'Nitro 5',
                    'Predator Triton 500', 'Acer Chromebook Spin 713', 'Aspire 5', 'Swift 3', 'Predator Helios 500'
                ]
            ],
            // **Microsoft**:
            'Microsoft' => [
                'models' => [
                    'Surface Laptop 5', 'Surface Pro 9', 'Surface Studio 2+', 'Surface Book 3', 'Surface Headphones 2',
                    'Surface Go 3', 'Surface Laptop Studio', 'Surface Duo 2', 'Surface Earbuds', 'Surface Pro X'
                ]
            ],
            // **Sony**:
            'Sony' => [
                'models' => [
                    'VAIO SX14', 'Xperia 1 IV', 'WH-1000XM5', 'A7 IV Camera', 'PlayStation 5',
                    'Xperia 5 IV', 'WH-1000XM4', 'VAIO Z', 'Xperia 10 IV', 'PlayStation VR2'
                ]
            ],
            // **Nvidia**:
            'Nvidia' => [
                'models' => [
                    'GeForce RTX 4090', 'GeForce RTX 4080', 'GeForce RTX 4070', 'GeForce RTX 4060', 'Quadro RTX 8000',
                    'GeForce RTX 3090', 'GeForce RTX 3080', 'GeForce RTX 3070', 'GeForce RTX 3060', 'GeForce GTX 1660 Ti'
                ]
            ],
            // **Intel**:
            'Intel' => [
                'models' => [
                    'Core i9-13900K', 'Core i7-13700K', 'Core i5-13600K', 'Core i3-13400', 'Xeon W-3375',
                    'Core i9-12900K', 'Core i7-12700K', 'Core i5-12600K', 'Core i3-12100', 'Core i9-11900K'
                ]
            ],
            // **AMD**:
            'AMD' => [
                'models' => [
                    'Ryzen 9 7950X', 'Ryzen 7 7800X', 'Ryzen 5 7600X', 'Radeon RX 7900 XT', 'Radeon RX 7800 XT',
                    'Ryzen 7 5800X', 'Ryzen 5 5600X', 'Ryzen Threadripper PRO 5995WX', 'Radeon RX 6700 XT', 'Ryzen 9 5900X'
                ]
            ],
            // **Huawei**:
            'Huawei' => [
                'models' => [
                    'P50 Pro', 'Mate 40 Pro', 'MateBook X Pro', 'Watch GT 3', 'FreeBuds Pro 2',
                    'P40 Pro', 'Mate 30 Pro', 'MatePad Pro', 'Nova 9', 'P30 Pro'
                ]
            ],
            // **Xiaomi**:
            'Xiaomi' => [
                'models' => [
                    'Mi 11 Ultra', 'Redmi Note 11 Pro', 'Mi Mix 4', 'Poco X4 Pro', 'Mi Pad 5',
                    'Mi 10T Pro', 'Redmi K40', 'Mi 11 Lite', 'Poco F4', 'Redmi Note 10'
                ]
            ],
            // **Dropbox**:
            'Dropbox' => [
                'models' => [
                    'Dropbox Paper', 'Dropbox Professional', 'Dropbox Business Advanced', 'Dropbox Business Standard', 'Dropbox Basic'
                ]
            ],
            // **Facebook (Meta)**:
            'Facebook (Meta)' => [
                'models' => [
                    'Oculus Quest 2', 'Portal Plus', 'Portal Mini', 'Horizon Workrooms', 'Ray-Ban Stories'
                ]
            ],
            // **Google**:
            'Google' => [
                'models' => [
                    'Pixel 7 Pro', 'Pixel 6a', 'Pixel Buds Pro', 'Nest Hub (2nd Gen)', 'Pixelbook Go'
                ]
            ],
            // **Adobe**:
            'Adobe' => [
                'models' => [
                    'Photoshop CC', 'Illustrator CC', 'Premiere Pro CC', 'After Effects CC', 'Adobe XD'
                ]
            ],
            // **VMware**:
            'VMware' => [
                'models' => [
                    'vSphere 8', 'vSAN 8', 'NSX-T 3.2', 'vRealize Suite 8', 'Horizon 8'
                ]
            ],
            // **Salesforce**:
            'Salesforce' => [
                'models' => [
                    'Sales Cloud', 'Service Cloud', 'Marketing Cloud', 'Commerce Cloud', 'Tableau CRM'
                ]
            ],
            // **Palantir Technologies**:
            'Palantir Technologies' => [
                'models' => [
                    'Foundry', 'Gotham', 'Apollo', 'Edge AI', 'Data Integration Platform'
                ]
            ],
            // **Qualys**:
            'Qualys' => [
                'models' => [
                    'Vulnerability Management', 'Policy Compliance', 'Web Application Scanning', 'Cloud Security', 'Threat Protection'
                ]
            ],
            // **Palo Alto Networks**:
            'Palo Alto Networks' => [
                'models' => [
                    'PA-7000 Series', 'Cortex XDR', 'Prisma Cloud', 'VM-Series', 'GlobalProtect'
                ]
            ],
            // **Splunk**:
            'Splunk' => [
                'models' => [
                    'Splunk Enterprise', 'Splunk Cloud', 'Splunk IT Service Intelligence', 'Splunk Observability Cloud', 'Splunk Phantom'
                ]
            ],
            // **Okta**:
            'Okta' => [
                'models' => [
                    'Okta Identity Cloud', 'Okta Single Sign-On', 'Okta Adaptive MFA', 'Okta Lifecycle Management', 'Okta API Access Management'
                ]
            ],
            // **GitHub**:
            'GitHub' => [
                'models' => [
                    'GitHub Copilot', 'GitHub Enterprise', 'GitHub Actions', 'GitHub Packages', 'GitHub Discussions'
                ]
            ],
            // **Twilio**:
            'Twilio' => [
                'models' => [
                    'Twilio Flex', 'Twilio SendGrid', 'Twilio Autopilot', 'Twilio Video', 'Twilio Voice'
                ]
            ],
            // **MongoDB**:
            'MongoDB' => [
                'models' => [
                    'MongoDB Atlas', 'MongoDB Enterprise Advanced', 'MongoDB Community Server', 'MongoDB Charts', 'MongoDB Stitch'
                ]
            ],
            // **Elastic**:
            'Elastic' => [
                'models' => [
                    'Elasticsearch', 'Kibana', 'Elastic APM', 'Elastic Security', 'Elastic Enterprise Search'
                ]
            ],
            // **Snowflake**:
            'Snowflake' => [
                'models' => [
                    'Snowflake Data Cloud', 'Snowflake Marketplace', 'Snowflake Native App Framework', 'Snowflake Data Engineering', 'Snowflake Data Science'
                ]
            ],
            // **Red Hat**:
            'Red Hat' => [
                'models' => [
                    'Red Hat OpenShift', 'Red Hat Enterprise Linux', 'Red Hat Ansible Automation Platform', 'Red Hat OpenStack Platform', 'Red Hat OpenShift Service on AWS'
                ]
            ],
            // **Docker**:
            'Docker' => [
                'models' => [
                    'Docker Desktop', 'Docker Enterprise', 'Docker Hub', 'Docker Compose', 'Docker Swarm'
                ]
            ]
        ];

        // Fetch all assets from the database
        $assets = DB::table('assets')->get();

        foreach ($assets as $asset) {
            // Randomly select a brand from the list
            $randomBrand = array_rand($brandsAndModels);

            // Retrieve the models for the selected brand
            $models = $brandsAndModels[$randomBrand]['models'];

            // Randomly select a model from the list of models
            $randomModel = $models[array_rand($models)];

            // Update the asset with the randomly selected brand and model
            DB::table('assets')
                ->where('id', $asset->id)
                ->update(['brand' => $randomBrand, 'model' => $randomModel]);
        }
    }
}
