<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class WebsiteContentController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::allValues();

        return view('admin.settings.website', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'hero_label', 'hero_title', 'hero_subtitle', 'hero_primary_cta_text', 'hero_primary_cta_link',
            'hero_secondary_cta_text', 'hero_secondary_cta_link', 'hero_background_image',
            'hero_badge_1_title', 'hero_badge_1_subtitle',
            'hero_badge_2_title', 'hero_badge_2_subtitle',
            'why_title', 'why_description', 'why_card_1_title', 'why_card_1_desc',
            'why_card_2_title', 'why_card_2_desc', 'why_card_3_title', 'why_card_3_desc',
            'about_label', 'about_title', 'about_paragraph_1', 'about_paragraph_2', 'about_image',
            'about_feature_1_title', 'about_feature_1_text', 'about_feature_2_title', 'about_feature_2_text',
            'about_feature_3_title', 'about_feature_3_text', 'about_feature_4_title', 'about_feature_4_text',
            'contact_label', 'contact_title', 'contact_description', 'contact_address', 'contact_phone',
            'contact_email', 'contact_hours', 'contact_note', 'footer_text', 'seo_title', 'seo_description', 'seo_keywords',
            'social_whatsapp', 'social_instagram', 'social_facebook', 'social_tiktok',
        ];

        for ($i = 1; $i <= 3; $i++) {
            $fields[] = "testimonial_{$i}_initial";
            $fields[] = "testimonial_{$i}_name";
            $fields[] = "testimonial_{$i}_role";
            $fields[] = "testimonial_{$i}_text";
        }

        for ($i = 1; $i <= 5; $i++) {
            $fields[] = "faq_{$i}_question";
            $fields[] = "faq_{$i}_answer";
        }
        for ($i = 1; $i <= 5; $i++) {
            $fields[] = "gallery_img_{$i}_title";
        }

        $validated = $request->validate(array_fill_keys($fields, 'nullable|string'));

        // Handle file uploads for hero images, logo, and gallery images
        $fileFields = ['hero_image_1', 'hero_image_2', 'site_logo', 'gallery_img_1', 'gallery_img_2', 'gallery_img_3', 'gallery_img_4', 'gallery_img_5'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store('settings/hero', 'public');
                SiteSetting::set($field, $path);
            }
        }

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan konten website berhasil diperbarui!');
    }
}
