<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // Temizle
        Faq::truncate();

        $faqs = [
            [
                'question' => [
                    'tr' => '{product} sipariş süreci nasıl işler?',
                    'en' => 'How does the ordering process for {product} work?',
                ],
                'answer' => [
                    'tr' => 'MATIXO ürünleri eğitim mekanlarına özel ölçü ve tasarımda üretildiği için öncelikle WhatsApp veya iletişim hattımızdan fiyat teklifi talep edilir. Projenize uygun ölçü ve teknik detaylar belirlendikten sonra siparişiniz onaylanır, üretim aşamasına geçilir ve ekibimiz tarafından teslimat/kurulum gerçekleştirilir.',
                    'en' => 'Since MATIXO products are custom-manufactured in size and design for educational spaces, a price quote is requested from our WhatsApp or contact line first. Once measurements and technical details matching your project are determined, your order is approved, production begins, and delivery/installation is carried out by our team.',
                ],
                'sort_order' => 1,
            ],
            [
                'question' => [
                    'tr' => 'Ürünü kendi alan ölçülerimize veya renklerimize göre özelleştirebilir miyiz?',
                    'en' => 'Can we customize the product according to our own area measurements or colors?',
                ],
                'answer' => [
                    'tr' => 'Evet, MATIXO bünyesindeki tüm bilim, matematik parkları ve müze ekipmanları projenizin boyut gereksinimlerine, alan mimarisine ve renk temalarına göre %100 özelleştirilebilir.',
                    'en' => 'Yes, all science, math parks, and museum equipments within MATIXO can be 100% customized according to your project size requirements, spatial architecture, and color themes.',
                ],
                'sort_order' => 2,
            ],
            [
                'question' => [
                    'tr' => 'Teslimat ve kurulum hizmetleri fiyata dahil midir?',
                    'en' => 'Are delivery and installation services included in the price?',
                ],
                'answer' => [
                    'tr' => 'Teslimat ve kurulum şartları projenin büyüklüğüne ve konumuna göre değişiklik göstermektedir. Fiyat teklifi aşamasında kurulum ve nakliye koşulları şeffaf bir şekilde tarafınıza iletilmektedir.',
                    'en' => 'Delivery and installation conditions vary based on the size and location of the project. Installation and shipping terms are transparently communicated to you during the price quotation phase.',
                ],
                'sort_order' => 3,
            ],
            [
                'question' => [
                    'tr' => 'Ürünlerin güvenlik sertifikaları ve garanti durumları nelerdir?',
                    'en' => 'What are the safety certifications and warranty statuses of the products?',
                ],
                'answer' => [
                    'tr' => 'Tüm eğitim modüllerimiz ve park ekipmanlarımız çocuk güvenliği standartlarına uygun malzemelerden üretilmekte olup CE sertifikalıdır. Ürünlerimiz üretim ve montaj hatalarına karşı firma garantimiz altındadır.',
                    'en' => 'All of our educational modules and park equipment are manufactured from materials complying with child-safety standards and are CE certified. Our products are under our company warranty against production and assembly defects.',
                ],
                'sort_order' => 4,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create([
                'question'   => $faq['question'],
                'answer'     => $faq['answer'],
                'is_active'  => true,
                'sort_order' => $faq['sort_order'],
            ]);
        }
    }
}
