<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //department
        Service::create(['service'=>'Investment licensing','department'=>'department']);
        Service::create(['service'=>'Renewal of investment license','department'=>'department']);
        Service::create(['service'=>'Cancellation of investment license','department'=>'department']);
        Service::create(['service'=>'Provide letters of recommendation to investors','department'=>'department']);
        Service::create(['service'=>'Prepare a research document that solves the investor problem','department'=>'department']);

        //expansion
        Service::create(['service'=>'meet the infrastructure of industrial villages','department'=>'expansion']);
        Service::create(['service'=>'Demarcation of industrial villages by site plan','department'=>'expansion']);
        Service::create(['service'=>'Facilitation of leasing and project financing loans for investors','department'=>'expansion']);
        Service::create(['service'=>'Issuing letters of support for tax relief to investors','department'=>'expansion']);
        Service::create(['service'=>'Issuance of letters of recommendation for tax-free incentives to investors','department'=>'expansion']);

        //development service
        Service::create(['service'=>'Technical support with factories','department'=>'development']);
        Service::create(['service'=>'Identification and provision of technical training','department'=>'development']);
        Service::create(['service'=>'Creation of industrial market linkages','department'=>'development']);
        Service::create(['service'=>'Making the transition of level and technology','department'=>'development']);
        Service::create(['service'=>'Conduct panel and forum discussions on various topics for investors in construction and production','department'=>'development']);

        //miniral service
        Service::create(['service'=>'Creating awareness for the society about the management of mineral resources','department'=>'miniral']);
        Service::create(['service'=>'Issuance of mining license','department'=>'miniral']);
        Service::create(['service'=>'Collection of revenue from various mining revenue titles','department'=>'miniral']);
        Service::create(['service'=>'Identification of mineral resources with the help of a map','department'=>'miniral']);
        Service::create(['service'=>'Job creation','department'=>'miniral']);
    }
}
