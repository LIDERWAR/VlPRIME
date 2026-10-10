<?php
if (function_exists('acf_add_local_field_group')):

    // 1. Global Theme Options (Phone, etc.)
    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));

    acf_add_local_field_group(array(
        'key' => 'group_global_settings',
        'title' => 'Global Settings',
        'fields' => array(
            array(
                'key' => 'field_phone_number',
                'label' => 'Phone Number',
                'name' => 'phone_number',
                'type' => 'text',
                'default_value' => '+7 (926) 62-62-662',
            ),
            array(
                'key' => 'field_whatsapp_link',
                'label' => 'WhatsApp Link',
                'name' => 'whatsapp_link',
                'type' => 'url',
                'default_value' => 'https://wa.me/79266262662',
            ),
            array(
                'key' => 'field_telegram_link',
                'label' => 'Telegram Link',
                'name' => 'telegram_link',
                'type' => 'url',
                'default_value' => 'https://t.me/+79266262662',
            ),
            array(
                'key' => 'field_address_text',
                'label' => 'Address',
                'name' => 'address_text',
                'type' => 'text',
                'default_value' => 'г. Москва, ул. Примерная, д. 1',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-general-settings',
                ),
            ),
        ),
    ));

    // 2. Homepage: Hero Section
    acf_add_local_field_group(array(
        'key' => 'group_home_hero',
        'title' => 'Home: Hero Section',
        'fields' => array(
            array(
                'key' => 'field_hero_overhead',
                'label' => 'Overhead Text',
                'name' => 'hero_overhead',
                'type' => 'text',
                'default_value' => 'Специализированный сервис Volvo',
            ),
            array(
                'key' => 'field_hero_title',
                'label' => 'Main Title',
                'name' => 'hero_title',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Профессиональный ремонт и обслуживание Volvo в Москве',
            ),
            array(
                'key' => 'field_hero_subtitle',
                'label' => 'Subtitle',
                'name' => 'hero_subtitle',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Полный цикл работ: от планового ТО до капитального ремонта двигателей и трансмиссии.',
            ),
            array(
                'key' => 'field_hero_bg',
                'label' => 'Background Image',
                'name' => 'hero_bg_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
    ));

    // 3. Homepage: About (Simplified for brevity, can assume hardcoded structured content for now or add more fields later)
    acf_add_local_field_group(array(
        'key' => 'group_home_about',
        'title' => 'Home: About Section',
        'fields' => array(
            array(
                'key' => 'field_about_title',
                'label' => 'Title',
                'name' => 'about_title',
                'type' => 'text',
                'default_value' => 'Мы знаем о Volvo все',
            ),
            array(
                'key' => 'field_about_text_main',
                'label' => 'Main Text',
                'name' => 'about_text_main',
                'type' => 'wysiwyg',
            ),
            array(
                'key' => 'field_about_image',
                'label' => 'Image',
                'name' => 'about_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
    ));

endif;
