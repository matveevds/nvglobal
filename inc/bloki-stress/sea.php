<?php
/**
 * Стресс-кадры блока SEA tabs (`template-parts/kyc-sea-section`): минимум / норма / максимум контента.
 * Файл возвращает slug => array(part, args); подмешивается в inc/bloki-stress.php.
 */

if (!defined('ABSPATH')) {
    exit;
}

$nv_sea_long_t = 'An unusually long heading that keeps going across several lines to prove that nothing collides or gets clipped';
$nv_sea_long_p = 'This paragraph is deliberately long. It carries several sentences so that the card has to grow in height instead of clipping the text or sliding under the picture: the block must stay readable when an editor pastes a full paragraph from a brief, with numbers such as 99.74% and 195+ countries, long words like internationalisation and a URL-like string example.com/very/long/path.';

return array(
    /* Одна страна (не Сингапур), без текста и без подписи строки. */
    'sea-min' => array(
        'part' => 'template-parts/kyc-sea-section',
        'args' => array(
            'section_id' => 'sea-min',
            'title'      => 'Where we work',
            'countries'  => array(
                array('id' => 'thailand', 'label' => 'Thailand', 'rows' => array(
                    array('label' => 'ID', 'values' => array('National ID card')),
                )),
            ),
        ),
    ),
    /* Шесть стран, Сингапур не первый; у Вьетнама нет текста, у Индонезии — одна строка. */
    'sea-norm' => array(
        'part' => 'template-parts/kyc-sea-section',
        'args' => array(
            'section_id' => 'sea-norm',
            'badge'      => 'Southeast Asia',
            'title'      => 'Rules and IDs by Country',
            'lead'       => 'Each country has its own regulator, ID cards and government databases. We adapt the checks to each market.',
            'tabs_label' => 'Southeast Asia countries',
            'countries'  => array(
                array('id' => 'vietnam', 'label' => 'Vietnam', 'title' => 'eKYC in Vietnam', 'text' => '', 'rows' => array(
                    array('label' => 'Regulator', 'values' => array('SBV')),
                    array('label' => 'Main ID', 'values' => array('CCCD (chip)')),
                    array('label' => 'What we check', 'values' => array('ID document', 'selfie', 'liveness')),
                )),
                array('id' => 'singapore', 'label' => 'Singapore', 'title' => 'eKYC in Singapore', 'text' => 'Banks follow MAS Notice 626 and many use Singpass Myinfo to pre-fill verified data. Where it is not available, customers verify with an NRIC, FIN card or passport and a selfie.', 'rows' => array(
                    array('label' => 'Regulator', 'values' => array('MAS')),
                    array('label' => 'Main ID', 'values' => array('NRIC / FIN, passport')),
                    array('label' => 'What we check', 'values' => array('ID document', 'selfie', 'liveness')),
                )),
                array('id' => 'malaysia', 'label' => 'Malaysia', 'title' => 'eKYC in Malaysia', 'text' => 'Bank Negara Malaysia’s e-KYC Policy Document sets out how banks and e-money issuers verify customers remotely.', 'rows' => array(
                    array('label' => 'Regulator', 'values' => array('BNM')),
                    array('label' => 'Main ID', 'values' => array('MyKad, passport')),
                )),
                array('id' => 'indonesia', 'label' => 'Indonesia', 'title' => 'eKYC in Indonesia', 'text' => 'OJK rules allow banks and fintech lenders to onboard customers remotely.', 'rows' => array(
                    array('label' => 'Main ID', 'values' => array('KTP-el (NIK)')),
                )),
                array('id' => 'philippines', 'label' => 'Philippines', 'title' => 'eKYC in the Philippines', 'text' => 'BSP allows electronic KYC for banks and e-money issuers.', 'rows' => array(
                    array('label' => 'Regulator', 'values' => array('BSP')),
                    array('label' => 'Main ID', 'values' => array('PhilSys ID / ePhilID')),
                )),
                array('id' => 'thailand', 'label' => 'Thailand', 'title' => 'eKYC in Thailand', 'text' => 'Thai banks verify the national ID card against the DOPA database.', 'rows' => array(
                    array('label' => 'Regulator', 'values' => array('BOT')),
                    array('label' => 'Main ID', 'values' => array('Thai national ID card')),
                )),
            ),
        ),
    ),
    /* Шесть стран, длинные заголовок/тексты/значения, много токенов; у одной страны нет строк, у другой — нет текста. */
    'sea-max' => array(
        'part' => 'template-parts/kyc-sea-section',
        'args' => array(
            'section_id' => 'sea-max',
            'badge'      => 'Southeast Asia',
            'title'      => $nv_sea_long_t,
            'lead'       => $nv_sea_long_p,
            'tabs_label' => 'Southeast Asia countries',
            'countries'  => array(
                array('id' => 'philippines', 'label' => 'The Republic of the Philippines', 'title' => $nv_sea_long_t, 'text' => $nv_sea_long_p, 'rows' => array(
                    array('label' => 'Regulator and financial intelligence unit', 'values' => array('BSP', 'AMLC (FIU)', 'SEC', 'a very long regulator name that has to wrap onto several lines inside the token')),
                    array('label' => 'Main ID', 'values' => array('PhilSys ID / ePhilID', 'UMID', 'driver’s license', 'passport', 'postal ID', 'voter’s ID', 'PRC ID', 'TIN ID')),
                    array('label' => 'What we check', 'values' => array('ID document', 'selfie', 'liveness', 'duplicates', 'sanctions', 'PEP', 'watchlists', 'adverse media')),
                )),
                array('id' => 'singapore', 'label' => 'Singapore', 'title' => $nv_sea_long_t, 'text' => $nv_sea_long_p, 'rows' => array(
                    array('label' => 'Regulator', 'values' => array('MAS')),
                    array('label' => 'Main ID', 'values' => array($nv_sea_long_p)),
                )),
                array('id' => 'malaysia', 'label' => 'Malaysia', 'title' => 'eKYC in Malaysia', 'text' => '', 'rows' => array(
                    array('label' => 'Regulator', 'values' => array('BNM', 'SSM', 'SC Malaysia')),
                )),
                array('id' => 'indonesia', 'label' => 'Indonesia', 'title' => 'eKYC in Indonesia', 'text' => $nv_sea_long_p, 'rows' => array()),
                array('id' => 'vietnam', 'label' => 'Vietnam', 'title' => 'eKYC in Vietnam', 'text' => $nv_sea_long_p, 'rows' => array(
                    array('label' => 'Main ID', 'values' => array('Citizen ID (CCCD)', 'chip ID', 'driver’s license', 'passport')),
                    array('label' => 'What we check', 'values' => array('ID document', 'face authentication against national records')),
                    array('label' => 'Extra row', 'values' => array('one', 'two', 'three')),
                )),
                array('id' => 'thailand', 'label' => 'Thailand', 'title' => 'eKYC in Thailand', 'text' => 'Thai banks verify the national ID card against the DOPA database.', 'rows' => array(
                    array('label' => 'Regulator', 'values' => array('BOT')),
                )),
            ),
        ),
    ),
);
